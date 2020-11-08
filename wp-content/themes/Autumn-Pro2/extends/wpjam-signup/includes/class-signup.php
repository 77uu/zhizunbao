<?php
abstract class WPJAM_Signup{
	public static $signups	= [];

	public static function register_signup($key, $args){
		self::$signups[$key]	= $args;
	}

	public static function get_signups(){
		return self::$signups;
	}

	public static function signup($openid, $args){
		$user	= static::get_user_by_openid($openid);

		if(is_wp_error($user)){
			return $user;
		}

		if($user){
			$role	= $args['role'] ?? '';

			if($role){
				$blog_id	= $args['blog_id'] ?? '';

				if(is_multisite() && $blog_id){
					if(!is_user_member_of_blog($user->ID, $blog_id)){
						add_user_to_blog($blog_id, $user->ID, $role);
					}else{
						$switched	= switch_to_blog($blog_id);	
						$user		= get_userdata($user->ID);	// 不同博客的用户角色不同

						if($switched){
							restore_current_blog();
						}

						if(!in_array($role, $user->roles)){
							return new WP_Error('user_registered', '你已有权限，如果需要更改权限，请联系管理员直接修改。');
						}
					}
				}else{
					if(!in_array($role, $user->roles)){
						return new WP_Error('user_registered', '你已有权限，如果需要更改权限，请联系管理员直接修改。');
					}
				}
			}
		}else{
			$users_can_register	= $args['users_can_register'] ?? get_option('users_can_register');

			if(!$users_can_register){
				return new WP_Error('register_disabled', '账号未绑定，系统不开放注册，请联系管理员！');
			}

			$user	= static::register($openid, $args);

			if(is_wp_error($user)){
				return $user;
			}
		}

		wp_set_auth_cookie($user->ID, true, is_ssl());
		wp_set_current_user($user->ID);
		do_action('wp_login', $user->user_login, $user);

		do_action('wpjam_user_signuped', $user, $args);	

		return $user;	
	}

	protected static function register($openid, $args=[]){
		$register_lock	= static::cache_get($openid.'_register_lock');
		
		if($register_lock !== false){
			return new WP_Error('username_registering', '该用户名正在注册中，请稍后再试！');
		}

		$result	= static::cache_add($openid.'_register_lock', 1, 15);
		if($result === false){
			return new WP_Error('username_registering', '该用户名正在注册中1，请稍后再试！');
		}

		$user_name	= preg_replace( '/\s+/', '', sanitize_user($openid, true));
		$user_login	= wp_slash($user_name);
		$user_email	= static::get_email($openid);
		$user_pass	= wp_generate_password(12, false);

		$role		= $args['role'] ?? get_option('default_role');

		$userdata	= compact('user_login', 'user_email', 'user_pass','role');

		$third_user	= static::get_third_user($openid);

		if(is_wp_error($third_user)){
			return $third_user;
		}

		if(!empty($third_user['nickname'])){
			$userdata['nickname']	= $userdata['display_name']	= $third_user['nickname'];
		}

		if(is_multisite()){	
			$blog_id	= $args['blog_id'] ?? 0;

			$switched	= $blog_id ? switch_to_blog($blog_id) : false;
			$user_id	= wp_insert_user($userdata);

			if($switched){
				restore_current_blog();
			}
		}else{
			$user_id	= wp_insert_user($userdata);
		}

		if(is_wp_error($user_id)){
			return $user_id;
		}

		return static::bind($user_id, $openid);
	}

	public static function bind($user_id, $openid){
		$third_user	= static::get_third_user($openid);

		if(is_wp_error($third_user)){
			return $third_user;
		}

		if($third_user){
			if($third_user['user_id'] != $user_id){
				if($third_user['user_id'] && get_userdata($third_user['user_id'])){
					return new WP_Error('already_binded', '已绑定其他账号。');
				}else{
					// 旧的用户已经被删除，则可以重新绑定
					static::update_third_user($openid, compact('user_id'));
				}
			}

			$user_openid	= static::get_user_openid($user_id);

			if(empty($user_openid) || $openid != $user_openid){
				update_user_meta($user_id, static::get_meta_key(), $openid);
			}

			$avatar_field	= static::get_avatar_field();

			if($avatar_field && !empty($third_user[$avatar_field])){
				$avatarurl = get_user_meta($user_id, 'avatarurl', true);

				if(empty($avatarurl) || $third_user[$avatar_field] != $avatarurl){
					update_user_meta($user_id, 'avatarurl', $third_user[$avatar_field]);
				}			
			}

			if(!empty($third_user['nickname'])){
				$user	= get_userdata($user_id);
				
				if($user->nickname != $third_user['nickname']){
					wp_update_user([
						'ID'			=> $user_id,
						'nickname'		=> $third_user['nickname'],
						'display_name'	=> $third_user['nickname'],
					]);
				}
			}
		}	

		return get_userdata($user_id);	
	}

	public static function unbind($user_id, $openid=''){
		$openid		= $openid ?: static::get_user_openid($user_id);
		
		static::update_third_user($openid, ['user_id'=>'']);

		delete_user_meta($user_id, static::get_meta_key());

		// if($type == 'weixin' || $type == 'weapp'){
			// delete_user_meta($user_id, 'avatarurl');	
		// }

		// if($type == 'weixin'){
		// 	static::cache_delete($openid.'_weixin_wp_users', $type);
		// }
		
		return true;
	}

	public static function get_user_openid($user_id=0){
		$user_id	= $user_id ?: get_current_user_id();
		return get_user_meta($user_id, static::get_meta_key(), true);
	}

	public static function get_user_by_openid($openid){
		$third_user	= static::get_third_user($openid);

		if(is_wp_error($third_user)){
			return $third_user;
		}elseif(empty($third_user)){
			return null;
		}
		
		$user_id	= $third_user['user_id'] ?? 0;
		
		// if(!$user_id){
		// 	if($email = static::get_email($openid)){
		// 		$user		= get_user_by('email', $email);
		// 		$user_id	= $user->ID;	
		// 	}
		// }

		if(!$user_id || !get_userdata($user_id)){
			if(method_exists(get_called_class(), 'get_user_by_unionid')){
				$user	= static::get_user_by_unionid($third_user);

				if($user && !is_wp_error($user)){
					$user_id	= $user->ID;
				}
			}
			
			if(!$user_id || !get_userdata($user_id)){
				if($users = get_users(['meta_key'=>static::get_meta_key(), 'meta_value'=>$openid])){
					$user_id	= current($users)->ID;
				}else{
					$user_id	= username_exists($openid);
				}
			}
		}

		if($user_id && get_userdata($user_id)){
			$result	= static::bind($user_id, $openid);

			if(is_wp_error($result)){
				return $result;
			}

			return get_userdata($user_id);
		}else{
			return null;
		}		
	}

	protected static function redirect(){
		if (isset($_REQUEST['interim-login'])) {
			global $interim_login;
			$interim_login = 'success';
			$message       = '<p class="message">' . __( 'You have logged in successfully.' ) . '</p>';

			login_header('', $message);
			?>
			</div>
			<?php do_action('login_footer'); ?>
			</body></html>
			<?php
		}else{
			$redirect_to	= $_REQUEST['redirect_to'] ?? '';
			$redirect_to	= $redirect_to ?: admin_url();
			wp_redirect($redirect_to);
		}

		exit;
	}

	

	protected static function cache_get($key){
		$cache_key	= static::get_cache_key($key);

		return wp_cache_get($cache_key, 'wpjam_signup');
	}

	protected static function cache_set($key, $data, $cache_time=DAY_IN_SECONDS){
		$cache_key	= static::get_cache_key($key);

		return wp_cache_set($cache_key, $data, 'wpjam_signup', $cache_time);
	}

	protected static function cache_add($key, $data, $cache_time=DAY_IN_SECONDS){
		$cache_key	= static::get_cache_key($key);

		return wp_cache_add($cache_key, $data, 'wpjam_signup', $cache_time);
	}

	protected static function cache_delete($key){
		$cache_key	= static::get_cache_key($key);

		return wp_cache_delete($cache_key, 'wpjam_signup');
	}

	abstract protected static function get_cache_key($key);

	abstract protected static function get_third_user($openid);

	abstract protected static function update_third_user($openid, $data);

	abstract protected static function get_email($openid);

	abstract protected static function get_meta_key();
}