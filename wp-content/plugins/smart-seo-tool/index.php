<?php
/*
Plugin Name: Smart SEO Tool-百度搜索SEO优化插件
Plugin URI: http://wordpress.org/plugins/smart-seo-tool/
Description: Smart SEO Tool是一款专门针对WordPress开发的智能SEO优化插件，与众多WordPress的SEO插件不一样的是，Smart SEO Tool更加简单易用，帮助站长快速完成WordPress博客/网站的SEO基础优化。
Author: wbolt team
Version: 2.4.4
Author URI: http://www.wbolt.com/
Requires PHP: 5.4.0
*/


if(!defined('ABSPATH')) {
    exit();
}

define('SMART_SEO_TOOL_PATH',__DIR__);
define('SMART_SEO_TOOL_BASE_FILE',__FILE__);
define('SMART_SEO_TOOL_VERSION','2.4.4');
define('SMART_SEO_TOOL_CODE','sst');
require_once SMART_SEO_TOOL_PATH.'/classes/admin.class.php';
require_once SMART_SEO_TOOL_PATH.'/classes/images.class.php';
require_once SMART_SEO_TOOL_PATH.'/classes/rewrite.class.php';
require_once SMART_SEO_TOOL_PATH.'/classes/sitemap.class.php';
require_once SMART_SEO_TOOL_PATH.'/classes/ajax.class.php';

new Smart_SEO_Tool_Admin();

