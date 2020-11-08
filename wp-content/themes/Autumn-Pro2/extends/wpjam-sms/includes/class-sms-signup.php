<?php
class SMS_Signup extends WPJAM_Signup{
	public static function code_signup($phone, $code, $args=[]){
		if($user = apply_filters('wpjam_sms_signup', null, $phone, $code)){
			return $user;
		}

		$result	= wpjam_verify_sms($phone, $code);

		if(is_wp_error($result)){
			do_action('wpjam_sms_signup_failed', $phone);
			return $result;
		}

		return self::signup($phone, $args);
	}

	public static function get_third_user($phone){
		return WPJAM_UserPhone::get($phone);
	}

	protected static function update_third_user($phone, $data){
		return WPJAM_UserPhone::update($phone, $data);
	}

	public static function bind($user_id, $phone){
		if(!WPJAM_UserPhone::get($phone)){
			$result	= WPJAM_UserPhone::insert(compact('phone', 'user_id'));
		}

		return parent::bind($user_id, $phone);
	}

	public static function get_openid_by_user_id($user_id){
		return WPJAM_UserPhone::Query()->where('user_id', $user_id)->get_var('phone');
	}

	public static function login_action($args=[]){
		$errors = new WP_Error();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$phone	= $_POST['phone'] ?? '';
			$code	= $_POST['code'] ?? '';
			$user 	= self::code_signup($phone, $code, $args);

			if(is_wp_error($user)){
				$errors	= $user;
			}else{
				self::redirect();
			}
		}

		$action	= $args['action'];

		$redirect_to	= $_REQUEST['redirect_to'] ?? '';
		$errors			= apply_filters('wp_login_errors', $errors, $redirect_to);

		login_header($args['login_title'].'验证码登录','',$errors);

		$login_url	= site_url('wp-login.php?action='.$action, 'login_post');

		if(isset($_REQUEST['interim-login'])){
			$login_url	= add_query_arg(['interim-login'=>1], $login_url);
		}
		?>

		<form name="loginform" id="loginform" action="<?php echo esc_url($login_url); ?>" method="post">
			<p>
				<label for="code">手机号码<br />
					<input type="button" name="send_sms" id="send_sms" class="button" value="获取验证码" style="min-height: 40px; float: right;">
					<input type="text" name="phone" id="phone" class="input" value="" size="20" style="width:64%" />
				</label>
			</p>
			<p>
				<label for="code">验证码<br />
					<input type="number" name="code" id="code" class="input" value="" size="20" disabled required />
				</label>
			</p>

			<?php do_action( 'login_form' );?>

			<input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>" />
			
			<p class="submit">
				<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Log In'); ?>" />
			</p>
		</form>

		<?php

		login_footer('phone');
		
		exit;
	}

	public static function login_footer($action){
		?>
		<script type="text/javascript">
		var ajaxurl	= '<?php echo admin_url('admin-ajax.php', 'login_post'); ?>'

		jQuery(function($){
			$('body').on('submit', '#loginform', function(e){
				e.preventDefault();

				var phone	= $.trim($('#phone').val());
				var code	= $.trim($('#code').val());

				if(!phone){
					alert('请输入有效的手机号码'); 
					return false;
				}

				if(!code){
					alert('请输入有效的验证码'); 
					return false;
				}

				$('div#login_error').hide(300);

				$.post(ajaxurl, {
					action:	'sms-signup',
					phone:	phone,
					code:	code
				},function(data, status){
					if(data.errcode){
						$('h1').after('<div id="login_error">'+data.errmsg+'</div>');
						wpjam_shake_form();
					}else{
						window.location.href	= '<?php echo $_REQUEST['redirect_to'] ?? admin_url(); ?>';
					}
				});
			});
		});
		</script>

		<?php

		self::send_sms_js();
	}

	public static function send_sms_js(){
		?>
		<script type="text/javascript">
		jQuery(function($){
			$('body').on('click', '#send_sms', function(){
				var phone		= $.trim($('#phone').val());
				var phoneReg	= /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
				var	time_left	= 60;

				if(!phone){
					alert('请输入手机号码');
					return false;
				}

				if (!phoneReg.test(phone)) {
					alert('请输入有效的手机号码'); 
					return false;
				}

				var sms_timer = window.setInterval(function(){
					if(time_left == 0){                
						window.clearInterval(sms_timer);
						$("#send_sms").removeAttr('disabled');
						$("#send_sms").val("重新发送");
					}else {
						$("#send_sms").val(time_left + "秒再获取");

						time_left--;
					}
				}, 1000);

				$.post(ajaxurl, {
					action:	'send-sms',
					phone:	phone
				},function(data, status){
					if(data.errcode){
						alert(data.errmsg);
						window.clearInterval(sms_timer);
						$("#send_sms").removeAttr('disabled');
						$("#send_sms").val("获取验证码");
					}else{
						$('#code').removeAttr('disabled');
					}
				});
			});
		});
		</script>
		<?php
	}

	public static function bind_form($echo=true){
		$user_id	= get_current_user_id();
		$phone		= self::get_user_openid($user_id);

		if(!wp_doing_ajax()){
			add_action('admin_footer', [__CLASS__, 'send_sms_js']);
		}

		if($phone){
			$third_user	= self::get_third_user($phone);

			if(!$third_user){
				// wpjam_admin_add_error('绑定错误，请重新改绑定！', 'error');
			}
		}else{
			$phone	= self::get_openid_by_user_id($user_id);

			if($phone){
				$third_user	= self::get_third_user($phone);
			}else{
				$third_user	= [];
			}
		}

		$form	= '';

		if($third_user){
			$form	.=  '<p>绑定的手机号是：'.$phone.'</p>';

			$form	.=  '<p>'.wpjam_get_ajax_button([
				'action'		=> 'unbind',
				'button_text'	=> '解除绑定',
				'direct'		=> true,
				'confirm'		=> true
			]).'</p>';
		}else{
			$send_button	= '<input type="button" name="send_sms" id="send_sms" class="button" value="获取验证码">';
			$fields = [
				'view'	=> ['title'=>'',		'type'=>'view',		'value'=>'<p>绑定手机号码之后就可以直接短信验证码登录。</p>'],
				'phone'	=> ['title'=>'手机号码',	'type'=>'number',	'class'=>'all-options',	'description'=>$send_button],
				'code'	=> ['title'=>'验证码',	'type'=>'text',		'class'=>'',	'disabled',	'required',	'description'=>'验证码10分钟内有效！'],
			];

			$form	.=  wpjam_get_ajax_form([
				'action'		=> 'bind',
				'fields'		=> $fields,
				'submit_text'	=> '立刻绑定'
			]);
		}

		if($echo){
			echo $form;
		}else{
			return $form;
		}
	}

	protected static function get_avatar_field(){
		return '';
	}

	protected static function get_email($phone){
		return $phone.'@phone.sms';
	}

	protected static function get_meta_key(){
		return apply_filters('phone_bind_meta_key', 'phone');
	}

	protected static function get_cache_key($key){
		return 'phone:'.$key;
	}
}