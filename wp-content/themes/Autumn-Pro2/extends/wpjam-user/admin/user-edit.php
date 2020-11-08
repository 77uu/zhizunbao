<?php
add_action('admin_head', function(){
	?>
	<style type="text/css">

	<?php if(wpjam_get_user_setting('disable_personal')){ ?>

	table.form-table:first-of-type,
	form h2:first-of-type{
		display: none;
	}
	
	<?php } ?>

	<?php if(wpjam_get_user_setting('nickname_as_display_name')){ ?>

	tr.user-display-name-wrap{
		display: none;
	}
	
	<?php } ?>

	<?php if(wpjam_get_user_setting('disable_first_last_name')){ ?>

	tr.user-first-name-wrap,
	tr.user-last-name-wrap{
		display: none;
	}
	
	<?php } ?>

	form h2:nth-of-type(2),
	form h2:nth-of-type(3),
	form h2:nth-of-type(4){
		display: none
	}

 	</style>
	<?php
});

add_filter('user_profile_picture_description', '__return_empty_string');

function wpjam_edit_user_profile_update($user_id){
	if (!current_user_can('edit_user', $user_id)){
		return false;
	}

	$avatarurl	= $_POST['avatarurl'] ?: '';

	if($avatarurl){
		update_user_meta($user_id, 'avatarurl', $avatarurl);
	}else{
		delete_user_meta($user_id, 'avatarurl');
	}

	if(wpjam_get_user_setting('nickname_as_display_name')){
		$_POST['display_name']	= $_POST['nickname'];
	}
}
add_action('personal_options_update','wpjam_edit_user_profile_update');
add_action('edit_user_profile_update','wpjam_edit_user_profile_update');

function wpjam_edit_user_profile($profileuser){
	if(wpjam_get_user_setting('nicename_enable')){
		$nicename_field	= ['title'=>'别名', 'type'=>'text',	'required', 'value'=>$profileuser->user_nicename, 'description'=>'“别名”是在URL中使用的别称，使用小写，只能包含字母，数字和连字符（-）。<br />请勿使用和用户名相同的别名，防止用户名暴露。'];
		$nicename_html	= wpjam_fields(['nicename'=>$nicename_field], ['fields_type'=>'tr', 'echo'=>false]);
	}else{
		$nicename_html	= '';
	}

	$avatarurl		= get_user_meta($profileuser->ID, 'avatarurl', true);
	$avatar_html	= wpjam_get_field_html(['key'=>'avatarurl', 'title'=>'自定义头像', 'type'=>'img', 'item_type'=>'url', 'size'=>'200x200', 'value'=>$avatarurl]);

	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('tr.user-nickname-wrap').after('<?php echo $nicename_html; ?>');
		$('tr.user-profile-picture td').html('<?php echo $avatar_html; ?>');
		$('tr.user-profile-picture th').html('自定义头像');
	});
	</script>
	<?php 
}
add_action('show_user_profile','wpjam_edit_user_profile',1);
add_action('edit_user_profile','wpjam_edit_user_profile',1);


add_action('user_profile_update_errors', function ($errors, $update, $user){
	global $wpdb;

	if($update){
		$user_id	= $user->ID;
		$user_data	= get_userdata($user_id);
	}

	if(wpjam_get_user_setting('nicename_enable')){
		$nicename	= $_POST['nicename'] ?? '';

		if(!$update || $user_data->user_nicename != $nicename){
			if(empty($nicename)){
				$errors->add('empty_nicename', '别名不能为空。');
			}elseif(preg_replace('/[^a-z0-9_\-]/i', '', $nicename) != $nicename){
				$errors->add('invalid_nicename', '别名只能只能小写字母，数字和-_。');
			}elseif(is_numeric($nicename)){
				$errors->add('only_numeric', '别名不能为纯数字。');
			}elseif(mb_strwidth($nicename)>20){
				$errors->add('too_long', '别名超过20个字符。');
			}elseif(wpjam_blacklist_check($nicename)){
				$errors->add('illegal_nicename', '别名含有非法字符。');
			}elseif(empty($errors)){
				$user_check = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_nicename = %s OR user_login = %s OR display_name = %s", $nicename, $nicename, $nicename));

				if($user_check){
					if(!$update || count($user_check) >1){
						$errors->add('duplicate_nicename', '该别名已被其他用户占用了。');
					}elseif(current($user_check) != $user_id){
						$errors->add('duplicate_nicename', '该别名已被其他用户占用了。');
					}
				}
			}

			$user->user_nicename 	= $nicename;
		}
	}

	$nickname	= $_POST['nickname'] ?? '';

	if(!$update || $user_data->display_name != $nickname){
		if(mb_strwidth($nickname)>20){
			$errors->add('too_long', '昵称超过20个字符。');
		}elseif(wpjam_blacklist_check($nickname)){
			$errors->add('illegal_nickname', '昵称含有非法字符。');
		}elseif(empty($errors) && wpjam_get_user_setting('nickname_as_display_name')){

			$user_check	= $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_nicename = %s OR user_login = %s OR display_name = %s", $nickname, $nickname, $nickname));

			if($user_check){
				if(!$update || count($user_check) >1){
					$errors->add('duplicate_nicename', '该昵称已被其他用户占用了。');
				}elseif($user_check && current($user_check) != $user_id){
					$errors->add('duplicate_nicename', '该昵称已被其他用户占用了。');
				}
			}
		}
	}
	
},10,3 );