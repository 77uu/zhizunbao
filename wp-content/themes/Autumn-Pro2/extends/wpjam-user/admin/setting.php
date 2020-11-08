<?php
add_filter('wpjam_avatar_setting', function(){
	$priority_options = [
		'default'	=>'直接从默认头像中随机选择，不管用户的Gravatar设置',
		'gravatar'	=>'如果用户在Gravatar设置了头像，优先使用Gravatar中设置的头像'
	];

	$sections	= [
		'user'	=> [
			'title'		=>'用户设置', 
			'fields'	=> [
				'disable_personal'			=> ['title'=>'屏蔽个人设置',	'type'=>'checkbox',	'description'=>'屏蔽后台个人资料个人设置，「可视化编辑器」,「语法高亮」,「配色方案」,「键盘快捷键」,「工具栏」,「语言」等选项使用系统默认值。'],
				'disable_first_last_name'	=> ['title'=>'屏蔽姓名设置',	'type'=>'checkbox',	'description'=>'屏蔽后台个人资料姓氏和名字设置，简化后台界面设置。'],
				'nickname_as_display_name'	=> ['title'=>'显示名称设置',	'type'=>'checkbox',	'description'=>'后台个人资料取消显示名称选择器，直接使用昵称作为显示名称。'],
				'hide_user_login'			=> ['title'=>'隐藏登录名',	'type'=>'checkbox',	'description'=>'如果别名（user_nicename）和用户名（user_login）一样，作者文章链接不显示，防止暴露用户名。'],
				'nicename_enable'			=> ['title'=>'开启别名设置',	'type'=>'checkbox',	'description'=>'在后台个人资料可以编辑用户的别名（user_nicename）。'],
				'limit_login_attempts'		=> ['title'=>'开启登录限制',	'type'=>'checkbox',	'description'=>'限制登陆失败次数，防止密码被暴力破解。'],
				'login_as'					=> ['title'=>'以此身份登陆',	'type'=>'checkbox',	'description'=>'在用户列表界面，管理员可以以用户身份登录后台。'],
				'order_by_registered'		=> ['title'=>'按注册时间排序','type'=>'checkbox',	'description'=>'后台用户列表按照用户注册时间排序并且显示注册时间。'],
				'last_login'				=> ['title'=>'最后登录时间',	'type'=>'checkbox',	'description'=>'记录用户最后登录时间，并且在后台用户列表可按照最后登录时间排序。'],
			]
		],
		'avatar'	=> [
			'title'		=>'默认头像',
			'fields'	=>[
				'defaults'	=> ['title'=>'默认头像',	'type'=>'mu-img',	'item_type'=>'url'],
				'priority'	=> ['title'=>'优先级',	'type'=>'radio',	'options'=>$priority_options,	'sep'=>'<br />']
			]
		]
	];
		
	return compact('sections');
});