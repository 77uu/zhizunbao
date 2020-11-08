<?php
$login_actions	= wpjam_get_login_actions();

if(empty($login_actions)){
	return;
}

add_action('login_form_login', function(){
	$action	= $_REQUEST['action'] ?? '';
	$args	= [];

	if(wpjam_get_invite_actions()){
		$invite_key	= $_REQUEST['invite_key'] ?? '';

		if($invite_key){
			$invite	= WPJAM_Invite::validate($invite_key);

			if(is_wp_error($invite)){
				wp_die($invite);
			}elseif($invite){
				$args['invite']				= $invite_key;
				$args['role']				= $invite['role'];
				$args['blog_id']			= $invite['blog_id'] ?? 0;
				$args['users_can_register']	= true;
			
				$action	= 'weixin';
			}
		}
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(empty($action)){
			$action	= 'login';
		}
	}

	if($action == 'login'){
		return;
	}

	$login_actions	= wpjam_get_login_actions();

	if($action && isset($login_actions[$action])){
		$login_action			= $login_actions[$action];
		$args['action']			= $action;
		$args['login_title']	= $login_action['login_title'];
		call_user_func([$login_action['model'], 'login_action'], $args);
	}else{
		foreach($login_actions as $login_key => $login_action){
			$args['login_title']	= $login_action['login_title'];
			$args['action']			= $login_key;
			call_user_func([$login_action['model'], 'login_action'], $args);
		}
	}
});

add_action('login_init', function(){
	if(empty($_COOKIE[TEST_COOKIE])){
		$_COOKIE[TEST_COOKIE]	= 'WP Cookie check';
	}

	wp_enqueue_script('jquery');
});

add_action('login_footer', 	function(){
	if(!empty($_REQUEST['invite_key'])){
		return;
	}

	$login_actions	= wpjam_get_login_actions();
	$login_actions['login']	= ['title'=>'账号密码',	'login_title'=>'使用账号和密码登录'];

	$action	= $_REQUEST['action'] ?? '';

	if(empty($action)){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$action	='login';
		}else{
			$action	= current(array_keys($login_actions));
		}
	}
	
	if($action != 'login' && isset($login_actions[$action])){
		call_user_func([$login_actions[$action]['model'], 'login_footer'], $action);
	}

	unset($login_actions[$action]);

	$login_texts	= [];

	$redirect_to	= $_REQUEST['redirect_to'] ?? '';
	$interim_login	= isset($_REQUEST['interim-login']);
	$login_url		= site_url('wp-login.php', 'login_post');

	foreach ($login_actions as $login_key => $login_action) {
		$args	= ['action'=>$login_key];

		if($interim_login){
			$args['interim-login']	= 1;
		}

		if($redirect_to){
			$args['redirect_to']	= urlencode($redirect_to);
		}

		$login_url		= add_query_arg($args, $login_url);
		$login_texts[]	= '<a style="text-decoration: none;" href="'.esc_url($login_url).'">'.$login_action['login_title'].'</a>';
	}

	$login_text	= '<p style="line-height:30px; float:left;">'.implode('<br />', $login_texts).'</p>';

	if($action == 'login'){
		$login_text	= '<p style="clear:both;"></p>'.$login_text;
	}

	?>
	<script type="text/javascript">

	<?php if(!has_action('login_head', 'wp_shake_js')){ ?>
	
	function s(id,pos){g(id).left=pos+'px';}
	function g(id){return document.getElementById(id).style;}
	function shake(id,a,d){c=a.shift();s(id,c);if(a.length>0){setTimeout(function(){shake(id,a,d);},d);}else{try{g(id).position='static';wp_attempt_focus();}catch(e){}}}
	
	<?php } ?>

	function wpjam_shake_form(){
		var p=new Array(15,30,15,0,-15,-30,-15,0);p=p.concat(p.concat(p));var i=document.forms[0].id;g(i).position='relative';shake(i,p,20);
	}

	jQuery(function($){
		$('p.submit').after('<?php echo $login_text; ?>');
	});
	</script>

	<style type="text/css">
	p#nav{display:none;} 
	</style>

	<?php
}, 999);

add_filter('shake_error_codes', function ($shake_error_codes){
	return array_merge($shake_error_codes, [
		'invalid_code',
		'invalid_openid',
		'invalid_scene',
		'already_binded',
		'invalid_invite'
	]);
});