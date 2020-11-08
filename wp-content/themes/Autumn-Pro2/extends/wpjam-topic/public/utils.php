<?php
function wpjam_get_topic_blog_id(){
	return is_multisite() ? apply_filters('wpjam_topic_blog_id', 0) : get_current_blog_id();
}

function wpjam_is_topic_blog(){
	return is_multisite() ? (get_current_blog_id() == wpjam_get_topic_blog_id()) : true;	
}

function wpjam_topic_switch_to_blog(){
	return is_multisite() ? switch_to_blog(wpjam_get_topic_blog_id()) : false;
}