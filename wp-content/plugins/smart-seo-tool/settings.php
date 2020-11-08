<?php
/**
 * This was contained in an addon until version 1.0.0 when it was rolled into
 * core.
 *
 * @package    WBOLT
 * @author     WBOLT
 * @since      2.4.2
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2019, WBOLT
 */

$pd_title = 'Smart SEO Tool';
$pd_version = SMART_SEO_TOOL_VERSION;
$pd_code = 'sst-setting';
$pd_index_url = 'https://www.wbolt.com/plugins/sst';
$pd_doc_url = 'https://www.wbolt.com/sst-plugin-documentation.html';


$spider_install = file_exists(WP_CONTENT_DIR.'/plugins/spider-analyser/index.php');
if($spider_install){
    $spider_active = class_exists('WP_Spider_Analyser');
}
?>
<div style=" display:none;">
    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <symbol id="sico-upload" viewBox="0 0 16 13">
                <path d="M9 8v3H7V8H4l4-4 4 4H9zm4-2.9V5a5 5 0 0 0-5-5 4.9 4.9 0 0 0-4.9 4.3A4.4 4.4 0 0 0 0 8.5C0 11 2 13 4.5 13H12a4 4 0 0 0 1-7.9z" fill="#666" fill-rule="evenodd"/>
            </symbol>
            <symbol id="sico-wb-logo" viewBox="0 0 18 18">
                <title>sico-wb-logo</title>
                <path d="M7.264 10.8l-2.764-0.964c-0.101-0.036-0.172-0.131-0.172-0.243 0-0.053 0.016-0.103 0.044-0.144l-0.001 0.001 6.686-8.55c0.129-0.129 0-0.321-0.129-0.386-0.631-0.163-1.355-0.256-2.102-0.256-2.451 0-4.666 1.009-6.254 2.633l-0.002 0.002c-0.791 0.774-1.439 1.691-1.905 2.708l-0.023 0.057c-0.407 0.95-0.644 2.056-0.644 3.217 0 0.044 0 0.089 0.001 0.133l-0-0.007c0 1.221 0.257 2.314 0.643 3.407 0.872 1.906 2.324 3.42 4.128 4.348l0.051 0.024c0.129 0.064 0.257 0 0.321-0.129l2.25-5.593c0.064-0.129 0-0.257-0.129-0.321z"></path>
                <path d="M16.714 5.914c-0.841-1.851-2.249-3.322-4.001-4.22l-0.049-0.023c-0.040-0.027-0.090-0.043-0.143-0.043-0.112 0-0.206 0.071-0.242 0.17l-0.001 0.002-2.507 5.914c0 0.129 0 0.257 0.129 0.321l2.571 1.286c0.129 0.064 0.129 0.257 0 0.386l-5.979 7.264c-0.129 0.129 0 0.321 0.129 0.386 0.618 0.15 1.327 0.236 2.056 0.236 2.418 0 4.615-0.947 6.24-2.49l-0.004 0.004c0.771-0.771 1.414-1.671 1.929-2.7 0.45-1.029 0.643-2.121 0.643-3.279s-0.193-2.314-0.643-3.279z"></path>
            </symbol>
            <symbol id="sico-more" viewBox="0 0 16 16">
                <path d="M6 0H1C.4 0 0 .4 0 1v5c0 .6.4 1 1 1h5c.6 0 1-.4 1-1V1c0-.6-.4-1-1-1M15 0h-5c-.6 0-1 .4-1 1v5c0 .6.4 1 1 1h5c.6 0 1-.4 1-1V1c0-.6-.4-1-1-1M6 9H1c-.6 0-1 .4-1 1v5c0 .6.4 1 1 1h5c.6 0 1-.4 1-1v-5c0-.6-.4-1-1-1M15 9h-5c-.6 0-1 .4-1 1v5c0 .6.4 1 1 1h5c.6 0 1-.4 1-1v-5c0-.6-.4-1-1-1"/>
            </symbol>
            <symbol id="sico-plugins" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M16 3h-2V0h-2v3H8V0H6v3H4v2h1v2a5 5 0 0 0 4 4.9V14H2v-4H0v5c0 .6.4 1 1 1h9c.6 0 1-.4 1-1v-3.1A5 5 0 0 0 15 7V5h1V3z"/>
            </symbol>
            <symbol id="sico-doc" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 0H1C.4 0 0 .4 0 1v14c0 .6.4 1 1 1h14c.6 0 1-.4 1-1V1c0-.6-.4-1-1-1zm-1 2v9h-3c-.6 0-1 .4-1 1v1H6v-1c0-.6-.4-1-1-1H2V2h12z"/><path d="M4 4h8v2H4zM4 7h8v2H4z"/>
            </symbol>
            <symbol id="wbsico-notice" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 16A8 8 0 108 0a8 8 0 000 16zM7.2 4h1.6v4.8H7.2V4zm1.6 6.4H7.2V12h1.6v-1.6z" clip-rule="evenodd"/>
            </symbol>
        </defs>
    </svg>
</div>

<div id="optionsframework-wrap" class="wbs-wrap wbps-wrap" data-wba-source="<?php echo $pd_code; ?>">

    <div id="new_ver" v-if="new_ver" style="display: none;">
        <div class="update-message notice inline notice-warning notice-alt">

            <p>当前<?php echo $pd_title;?>有新版本可用. <a href="<?php echo $pd_index_url; ?>" data-wba-campaign="notice-bar#J_updateRecordsSection" target="_blank">查看版本<span class="ver">{{new_ver}}</span> 详情</a>
                或 <a href="<?php echo admin_url('/plugins.php?plugin_status=upgrade');?>" class="update-link" aria-label="现在更新<?php echo $pd_title;?>">现在更新</a>.
            </p>

        </div>
    </div>

    <form id="optionsframework" action="options.php" method="post">
    <div class="wbs-header">
        <svg class="wb-icon sico-wb-logo"><use xlink:href="#sico-wb-logo"></use></svg>
        <span>WBOLT</span>
        <strong><?php echo $pd_title; ?></strong>

        <div class="links">
            <a class="wb-btn" href="<?php echo $pd_index_url; ?>" data-wba-campaign="title-bar" target="_blank">
                <svg class="wb-icon sico-plugins"><use xlink:href="#sico-plugins"></use></svg>
                <span>插件主页</span>
            </a>
            <a class="wb-btn" href="<?php echo $pd_doc_url; ?>" data-wba-campaign="title-bar" target="_blank">
                <svg class="wb-icon sico-doc"><use xlink:href="#sico-doc"></use></svg>
                <span>说明文档</span>
            </a>
        </div>
    </div>
    <div class="sst-notice-bar default-hidden-box" id="J_sstNotice">
        <p>Smart SEO Tool已启用，请务必确保其他SEO插件已停用，以免产生冲突。</p>
        <a class="sst-notice-close"></a>
    </div>
    <div class="wbs-main">

        <div class="wbs-aside wbs-aside-sst">
            <div class="wbs-tabs">
                <a class="tab-item" data-href="#J_titleMetas"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="14"><path fill="#444" fill-rule="evenodd" d="M14 5H2V2h12v3zm1-5H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V1a1 1 0 00-1-1z"/></svg><span>TKD优化</span></a>
                <a class="tab-item" data-href="#J_imageSection"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"><path fill="#444" fill-rule="evenodd" d="M15 0H1C.4 0 0 .4 0 1v14c0 .6.4 1 1 1h14c.6 0 1-.4 1-1V1c0-.6-.4-1-1-1zM6 4c.6 0 1 .4 1 1s-.4 1-1 1-1-.4-1-1 .4-1 1-1zm-3 8l2-4 2 2 3-4 3 6H3z"/></svg><span>图片优化</span></a>
                <a class="tab-item" data-href="#J_urlResSection"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="14"><g fill="#444" fill-rule="evenodd"><path d="M13 4.14v2.14A2 2 0 0114 8v2a2 2 0 01-2 2H8a2 2 0 01-2-2V8c0-1.1.9-2 2-2h1V4H8a4 4 0 00-4 4v2a4 4 0 004 4h4a4 4 0 004-4V8a4 4 0 00-3-3.86"/><path d="M8 0H4a4 4 0 00-4 4v2a4 4 0 003 3.86V7.72A2 2 0 012 6V4c0-1.1.9-2 2-2h4a2 2 0 012 2v2a2 2 0 01-2 2H7v2h1a4 4 0 004-4V4a4 4 0 00-4-4"/></g></svg><span>链接优化</span></a>
                <a class="tab-item" data-href="#J_404Url"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"><path fill="#444" fill-rule="evenodd" d="M7.1 12.1a5 5 0 01-5-5C2 4.3 4.2 2 7 2s5.1 2.3 5.1 5.1a5 5 0 01-5 5zm5.6-.8A7 7 0 100 7.1c0 3.9 3.2 7.1 7.1 7.1 1.6 0 3.1-.5 4.2-1.4l3 3c.2.2.5.3.7.3.2 0 .5-.1.7-.3.4-.4.4-1 0-1.4l-3-3.1z"/></svg><span>404监测</span></a>
                <a class="tab-item" data-href="#J_brokenLink"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"><g fill="#444" fill-rule="evenodd"><path d="M13.4 9.7l1.2-1.2A5 5 0 0016 5c0-1.3-.5-2.6-1.5-3.5C13.6.5 12.3 0 11 0 9.7 0 8.4.5 7.5 1.5L6.3 2.6a1 1 0 000 1.4c.4.4 1 .4 1.4 0l1.2-1.2a3 3 0 014.2 0c.6.6.9 1.4.9 2.2 0 .8-.3 1.6-.9 2.1L12 8.3a1 1 0 000 1.4c.2.2.5.3.7.3.2 0 .5-.1.7-.3M8.3 12l-1.2 1.2a3 3 0 01-4.2 0c-.6-.6-.9-1.4-.9-2.2 0-.8.3-1.6.9-2.1L4 7.7c.4-.4.4-1 0-1.4a1 1 0 00-1.4 0L1.5 7.5C.5 8.4 0 9.7 0 11c0 1.3.5 2.6 1.5 3.5.9 1 2.2 1.5 3.5 1.5 1.3 0 2.6-.5 3.5-1.5l1.2-1.2c.4-.4.4-1 0-1.4-.4-.4-1-.3-1.4.1"/><path d="M9.4 5.2L5.2 9.4a1 1 0 000 1.4c.2.2.5.3.7.3.2 0 .5-.1.7-.3l4.2-4.2c.4-.4.4-1 0-1.4a1 1 0 00-1.4 0M2.3 3.7c.2.2.4.3.7.3.3 0 .5-.1.7-.3.4-.4.4-1 0-1.4l-2-2A1 1 0 00.3.3a1 1 0 000 1.4l2 2zM13.7 12.3a1 1 0 00-1.4 0 1 1 0 000 1.4l2 2c.2.2.5.3.7.3.2 0 .5-.1.7-.3.4-.4.4-1 0-1.4l-2-2z"/></g></svg><span>失效URL</span></a>
                <a class="tab-item" data-href="#J_robotsSection"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"><g fill="#444" fill-rule="evenodd"><path d="M1 7.5a1 1 0 00-1 1v5a1 1 0 002 0v-5a1 1 0 00-1-1M15 7.5a1 1 0 00-1 1v5a1 1 0 002 0v-5a1 1 0 00-1-1M3 15.5h10v-8H3zM3 6.5h10c0-1.55-.72-2.93-1.84-3.84L12.42.78a.5.5 0 10-.84-.56L10.33 2.1c-.7-.37-1.48-.6-2.33-.6-.85 0-1.63.23-2.33.6L4.42.22a.5.5 0 10-.84.56l1.26 1.88A4.97 4.97 0 003 6.5"/></g></svg><span>robots.txt</span></a>
                <a class="tab-item" data-href="#J_sitemapSection"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"><g fill="#444" fill-rule="evenodd"><path d="M5.94 12h4v4h-4zM5.94 0h4v4h-4zM11.94 12h4v4h-4zM0 12h3.94v4H0zM2.94 9h4v2h2V9h4v2h2V8c0-.6-.4-1-1-1h-5V5h-2v2h-5c-.6 0-1 .4-1 1v3h2V9"/></g></svg><span>Sitemap生成</span></a>
            </div>
        </div>

        <div class="wbs-content">
		    <?php
		    settings_fields($setting_field);
		    ?>

            <div class="tab-content current" id="J_titleMetas">
                <h3 class="sc-header">
                    <span><input class="wb-switch" type="checkbox" data-target="#J_normalSettingTabs" name="<?php echo $setting_field;?>[normal_seo_active]" <?php echo isset($opt['normal_seo_active']) && $opt['normal_seo_active']?' checked':'';?> id="seo_active_normal"></span>
                    <strong>TDK优化</strong>
                    <span>页面Title/Description/Keywords优化设置</span>
                </h3>
                <div class="sc-body default-hidden-box<?php echo isset($opt['normal_seo_active']) && $opt['normal_seo_active']?' active':'';?>" id="J_normalSettingTabs">
                    <div class="wbs-tab-navs-row">
                        <ul class="tab-nav-inner">
                            <li class="tab-nav-item current">首页</li>
                            <li class="tab-nav-item">分类</li>
                            <li class="tab-nav-item">更多</li>
                        </ul>
                    </div>

                    <div class="tab-cont current">
			            <?php
			            $item_obj =  isset($opt['index']) ? $opt['index'] : array('','','');
			            $item_name =  $setting_field . '[index]';
			            ?>
                        <table class="wbs-form-table">
                            <tbody>
                            <tr>
                                <th class="row w8em">标题</th>
                                <td>

                                    <div class="input-with-count">
                                        <input id="<?php echo $item_name . '_0'; ?>" class="wbs-input" data-max="80" data-preview-target="#J_pv_index_title" name="<?php echo $item_name;?>[0]" type="text" value="<?php echo $item_obj[0];?>" placeholder="">
                                        <span class="count"></span>
                                    </div>
                                    <p class="description">一般不超过30个中文字符，首页标题必须填写完整正副标题（即站点名称+副标题）；分类页标题则无需写站点名称。</p>
                                </td>
                            </tr>
                            <tr>
                                <th>关键词</th>
                                <td>
                                    <label class="input-with-count mt wb-tags-module">
                                        <input id="<?php echo $item_name . '_1'; ?>" data-max="100" name="<?php echo $item_name;?>[1]" data-tags-value="<?php echo $item_obj[1];?>" type="hidden" value="<?php echo $item_obj[1];?>" placeholder="">
                                        <span class="count">已输入<?php echo strlen($item_obj[1]);?></span>

                                        <div class="wb-tags-ctrl">
                                            <div class="tag-items">
									            <?php
									            if($item_obj[1]){
										            trim($item_obj[1]);
										            $tagArr = explode(',',$item_obj[1]);

										            foreach ( $tagArr as $item ) :
											            ?>
                                                        <div class="tag-item">
                                                            <span><?php echo $item; ?></span>
                                                            <a class="del" data-del-val="<?php echo $item; ?>"></a>
                                                        </div>
										            <?php endforeach; ?>
									            <?php } //endif; ?>
                                            </div>
                                            <input class="wb-tag-input" type="text" placeholder="以逗号或回车分隔">
                                        </div>
                                    </label>
                                    <p class="description">建议3-5个为宜，切勿进行关键词堆叠。</p>
                                </td>
                            </tr>
                            <tr>
                                <th>描述</th>
                                <td>
                                    <div class="input-with-count mt">
                                        <textarea id="<?php echo $item_name . '_2'; ?>" class="wbs-input" data-max="200" data-preview-target="#J_pv_index_desc" rows="5" cols="42" name="<?php echo $item_name;?>[2]" placeholder=""><?php echo $item_obj[2];?></textarea>
                                        <span class="count"></span>
                                    </div>
                                    <p class="description">不超100个中文字符，建议50-100字为宜。</p>
                                </td>
                            </tr>
                            <tr style="display: <?php echo $item_obj[0] && $item_obj[2] ? 'table-row' : 'none'; ?>;">
                                <th>预览</th>
                                <td>
                                    <div class="preview-box">
                                        <div class="pvb-display">
                                            <a class="preview-title" id="J_pv_index_title"><?php echo $item_obj[0];?></a>
                                            <p class="preview-desc" id="J_pv_index_desc"><?php echo $item_obj[2];?></p>
                                            <p class="preview-link"><?php echo esc_url( home_url( '/' ) ); ?></p>
                                        </div>
                                        <div class="pvb-ft">* 搜索引擎收录结果展示预览</div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-cont cate_seo">
			            <?php
                        $all_taxonomy = Smart_SEO_Tool_Admin::term_category();


                        //print_r($all_taxonomy);

			            $tableHTML = '';
			            $site_title = ' - ' . get_bloginfo('name', 'display');
                        /*foreach ($all_taxonomy as $taxonomy){

                        }*/

			            foreach ($all_taxonomy as $taxonomy){
                        //print_r($taxonomy);
                        ?>
                        <table class="wbs-form-table">
                            <tbody>

                            <tr>
                                <th class="row w8em">请选择<?php echo $taxonomy->label;?></th>
                                <td>
						            <?php

                                    $all_item_name = $taxonomy->labels->all_items;
                                    $index_name = '';
                                    if($taxonomy->name !='category'){
                                        $index_name = '</option><option value="'.$taxonomy->name.'_index">'.$taxonomy->label.'首页';
                                    }
                                    $dropdown_options = array(
							            'show_option_all' => '',//$all_item_name,
							            'show_option_none'=>$all_item_name.$index_name,
                                        'option_none_value'=>'0',
                                        'hide_empty' => 0,
                                        'echo'=>0,
							            'hierarchical' => 1,
							            'show_count' => 0,
							            'orderby' => 'name',
							            'taxonomy'=>$taxonomy->name,
							            'class' => 'settings-cate-dropdown',
							            'selected' => null
						            );

						            $select = wp_dropdown_categories( $dropdown_options );
                                    if($select){
                                        if(preg_match('#<select[^>]+>#is',$select,$match)){

                                        }
                                    }

                                    echo $select;
						            ?>

                                </td>
                            </tr>

                            </tbody>
                        </table>

			            <?php

                        $tableHTML = '';
                        //分类
                        $c_list = get_categories(array('hide_empty'=>0, 'taxonomy' => $taxonomy->name));
                        if($taxonomy->name != 'category'){
                            $index_term = new stdClass();
                            $index_term->term_id = $taxonomy->name.'_index';
                            if($c_list){
                                array_unshift($c_list,$index_term);
                            }else{
                                $c_list = array($index_term);
                            }
                        }


                        if($c_list)foreach($c_list as $k => $o){
                            $f_name = $o->term_id;
                            $o_id = 'seo_'.$f_name;
                            $o_k = $setting_field.'['.$f_name.']';
                            $o_v = isset($opt[$f_name])?$opt[$f_name]:array('','','');

                            $tagsHTML = '';

                            if($o_v[1]){
                                trim($o_v[1]);
                                $tagArr = explode(',',$o_v[1]);

                                foreach ( $tagArr as $item ) :
                                    $tagsHTML .= '<div class="tag-item">
                                    <span>' .  $item . '</span>
                                    <a class="del" data-del-val="' . $item .'"></a>
                                </div>';
                                endforeach;
                            }

                            $display = $o_v[0] && $o_v[2] ? 'table-row' : 'none';

                            $tableHTML .='
					    <div class="cate-item mt" id="J_'. $o_id .'">
                            <table class="wbs-form-table">
                                <tbody>
                                    <tr>
                                        <th class="row w8em">标题</th>
                                        <td>
                                            <div class="seo-setitem input-with-count">
                                                <input id="'. $o_id .'_title" class="wbs-input" data-max="80" data-preview-target="#J_targetCate'. $f_name .'Title" name="' . $o_k .'[]" type="text" value="'. $o_v[0] .'" placeholder="">
                                                <span class="count">已输入' . strlen($o_v[0]) . '</span>
                                            </div>
                                            <p class="description">不超30个中文字符，建议15-30为宜。</p>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>关键词</th>
                                        <td>
                                            <label class="input-with-count mt wb-tags-module">
                                                <input id="'. $o_id .'_keyWord" name="' . $o_k .'[]" type="hidden" data-max="100" data-tags-value="'. $o_v[1] .'" value="'. $o_v[1] .'" placeholder="">
                                                <span class="count">已输入' . strlen($o_v[1]) . '</span>
                                                
                                                <div class="wb-tags-ctrl">
                                                    <div class="tag-items">'.  $tagsHTML .'</div>
                                                        <input class="wb-tag-input" type="text" placeholder="以逗号或回车分隔">
                                                </div>
                                            </label>
                                            <p class="description">建议3-5个为宜，切勿进行关键词堆叠。</p>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>描述</th>
                                        <td>
                                             <div class="seo-setitem input-with-count mt">
                                                <textarea id="'. $o_id .'_desc" class="wbs-input" data-max="200" data-preview-target="#J_targetCate'. $f_name .'Desc" rows="5" cols="42" name="' . $o_k .'[]" placeholder="">'. $o_v[2] .'</textarea>
                                                <span class="count">已输入' . strlen($o_v[2]) . '</span>
                                            </div>
                                            <p class="description">不超100个中文字符，建议50-100字为宜。</p>
                                    </td>
                                    </tr>
                                    
                                    <tr style="display: ' . $display .'; ">
                                        <th>预览</th>
                                        <td>
                                            <div class="preview-box">
                                                <div class="pvb-display">
                                                    <a class="preview-title" id="J_targetCate'. $f_name .'Title">'. $o_v[0] . $site_title .'</a>
                                                    <p class="preview-desc" id="J_targetCate'. $f_name .'Desc">'. $o_v[2] .'</p>
                                                    <p class="preview-link">' . esc_url( home_url( "/" ) ) . '</p>
                                                </div>
                                                <div class="pvb-ft">* 搜索引擎收录结果展示预览</div>
                                             </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';
                        }

                        echo $tableHTML; ?>

                        <?php } ?>
                    </div>

                    <div class="tab-cont">
                        <h4 class="sc-title-sub">
                            <span>文章页优化</span>
                        </h4>
                        <div class="sc-body">
                            <p>主题将按如下规则分别自动匹配每篇post的设定：</p>
                            <ul class="list-li">
                                <li>标题: 文章标题 - 站点名称</li>
                                <li>关键词: 文章编辑时使用的tag</li>
                                <li>描述: 系统自动读取文章内容前100个中文字符</li>
                            </ul>

                            <div class="preview-box mt">
                                <div class="pvb-display">
                                    <a class="preview-title">文章标题<?php echo $site_title; ?></a>
                                    <p class="preview-desc">这里将会截取你所发布文章时全文的前100个中文字符内容作为摘要内容，这仅演示数据，实际将会与你的站点数据为主。</p>
                                    <p class="preview-link"><?php echo esc_url( home_url( '/' ) ); ?>xxx</p>
                                </div>
                                <div class="pvb-ft">* 搜索引擎收录结果展示预览，上述为DEMO演示数据</div>
                            </div>
                        </div>

                        <h4 class="sc-title-sub">
                            <span>独立页面优化</span>
                        </h4>
                        <div class="sc-body">
                            <p>主题将按如下规则分别自动匹配每篇Page的设定：</p>
                            <ul class="list-li">
                                <li>标题: 独立页面标题 - 站点名称</li>
                                <li>关键词: 为“空”</li>
                                <li>描述: 系统自动读取文章内容前100个中文字符</li>
                            </ul>

                            <div class="preview-box mt">
                                <div class="pvb-display">
                                    <a class="preview-title">独立页面标题<?php echo $site_title; ?></a>
                                    <p class="preview-desc">这里将会截取独立页面内容的前100个中文字符内容作为摘要内容，这仅演示数据，实际将会与你的站点数据为主。</p>
                                    <p class="preview-link"><?php echo esc_url( home_url( '/' ) ); ?>xxx</p>
                                </div>
                                <div class="pvb-ft">* 搜索引擎收录结果展示预览，上述为DEMO演示数据</div>
                            </div>
                        </div>

                        <h4 class="sc-title-sub">
                            <span>搜索列表页优化</span>
                        </h4>
                        <div class="sc-body">
                            <p>主题将按如下规则优化搜索词列表页：</p>
                            <ul class="list-li">
                                <li>标题: 与「{search_keyword}」匹配搜索结果 - 站点名称 </li>
                                <li>关键词: {search_keyword}, {search_keyword}相关, {search_keyword}内容及搜索结果文章Top5热门关键词</li>
                                <li>描述: 当前页面展示所有与「{search_keyword}」相关的匹配结果，包括搜索结果文章Top5关键词（以顿号分割）等内容。</li>
                            </ul>

                            <div class="preview-box mt">
                                <div class="pvb-display">
                                    <a class="preview-title">与「WordPress」匹配的搜索结果<?php echo $site_title; ?></a>
                                    <p class="preview-desc">当前页面展示所有与「WordPress」搜索词相匹配的结果,包括WordPress、WordPress相关、WordPress插件、WordPres主题等内容。</p>
                                    <p class="preview-link"><?php echo esc_url( home_url( '/' ) ); ?>xxx</p>
                                </div>
                                <div class="pvb-ft">* 搜索引擎收录结果展示预览，上述为DEMO演示数据</div>
                            </div>
                        </div>

                        <h4 class="sc-title-sub">
                            <span>标签页优化</span>
                        </h4>
                        <div class="sc-body">
                            <p>主题将按如下规则优化Tag列表页：</p>
                            <ul class="list-li">
                                <li>标题: 「{tag}」相关文章列表 - 站点名称</li>
                                <li>关键词: {tag}, {tag}相关, {tag}内容及标签结果文章Top5关键词</li>
                                <li>描述: 关于「{tag}」相关内容全站索引列表，包括{tag}标签列表页所有结果Top5关键词（以顿号分割）。</li>
                            </ul>

                            <div class="preview-box mt">
                                <div class="pvb-display">
                                    <a class="preview-title">「WordPress主题」相关文章列表<?php echo $site_title; ?></a>
                                    <p class="preview-desc">关于「WordPress主题」相关内容全站索引列表，包括WordPress主题、WordPress主题相关、WordPress主题内容、WordPress企业主题等内容。</p>
                                    <p class="preview-link"><?php echo esc_url( home_url( '/' ) ); ?>xxx</p>
                                </div>
                                <div class="pvb-ft">* 搜索引擎收录结果展示预览，上述为DEMO演示数据</div>
                            </div>
                        </div>

                        <h4 class="sc-title-sub">
                            <span>作者页优化</span>
                        </h4>
                        <div class="sc-body">
                            <p>主题将按如下规则优化作者索引页：</p>
                            <ul class="list-li">
                                <li>标题: “「author_name}」作者主页 - {sitename}</li>
                                <li>关键词: 读取该作者所有文章Top5热门关键词</li>
                                <li>描述: 「author_name}」主页，主要负责{该作者所有文章Top5热门关键词（以顿号分割）}等内容发布。</li>
                            </ul>

                            <div class="preview-box mt">
                                <div class="pvb-display">
                                    <a class="preview-title">「WBOLT_COM」作者主页<?php echo $site_title; ?></a>
                                    <p class="preview-desc">「WBOLT_COM」作者主页，主要负责WordPress、WordPress教程、WordPress优化、WordPress主机、WordPress免费插件等内容发布。</p>
                                    <p class="preview-link"><?php echo esc_url( home_url( '/' ) ); ?>xxx</p>
                                </div>
                                <div class="pvb-ft">* 搜索引擎收录结果展示预览，上述为DEMO演示数据</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="tab-content" id="J_imageSection">
	            <?php
	            $img_seo_field = $setting_field.'[img_seo]';
	            $img_seo_val = isset($opt['img_seo'])?$opt['img_seo']:array('active'=>1,'title'=>0,'alt'=>0);
	            ?>
                <h3 class="sc-header">
                    <strong>图片优化</strong>
                    <span>图片Title/ALT属性优化设置</span>
                </h3>
                <div class="sc-body">
                    <table class="wbs-form-table default-hidden-box active" id="J_imgSEOSettingBox">
                        <tbody>
                        <tr>
                            <th class="row w8em">应用方式</th>
                            <td>
                                <div class="selector-bar">
                                    <label><input class="wbs-radio" type="radio" name="<?php echo $img_seo_field;?>[active]" value="0" <?php echo !$img_seo_val['active'] ?  'checked' : ''; ?>> 关闭</label>
                                    <label><input class="wbs-radio" type="radio" name="<?php echo $img_seo_field;?>[active]" value="1" <?php echo $img_seo_val['active']==1?  'checked' : ''; ?>> 仅补充</label>
                                    <label><input class="wbs-radio" type="radio" name="<?php echo $img_seo_field;?>[active]" value="2" <?php echo $img_seo_val['active']==2?  'checked' : ''; ?>> 全覆盖</label>
                                </div>
                                <p class="description">仅补充即无ALT和Title时应用优化规则，全覆盖则全部应用优化规则。</p>
                            </td>
                        </tr>

                        <tr>
                            <th class="row w8em">图片ALT&Title</th>
                            <td>
                                <div class="selector-bar">
                                    <input type="text" class="wbs-input" name="<?php echo $img_seo_field;?>[content]" value="<?php echo $img_seo_val['content'];?>" />

                                </div>
                                <p class="description"></p>
                            </td>
                        </tr>
                        <tr>
                            <th class="row w8em">特色图片ALT&Title</th>
                            <td>
                                <div class="selector-bar">
                                    <input type="text" class="wbs-input" name="<?php echo $img_seo_field;?>[thumb]" value="<?php echo $img_seo_val['thumb'];?>" />

                                </div>
                                <p class="description"></p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <p class="description">温馨提示
                                <ul>
                                    <li>％site_name-代表站点名称。</li>
                                    <li>％name-代表图像文件名称。</li>
                                    <li>％title-代表文章标题。</li>
                                    <li>％post_cat-代表文章子类别。</li>
                                    <li>%num-代表序号，即当post或者page存在多个图片时，以序号区分不同图片的alt和title</li>
                                </ul>
                                </p>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="tab-content" id="J_urlResSection">
	            <?php
	            $url_seo_field = $setting_field.'[url_seo]';
	            $url_seo_val = isset($opt['url_seo'])?$opt['url_seo']:array('active'=>1,'hide_category'=>1,'reset_tag'=>1,'set_nofollow'=>1,'set_gopage'=>1);
	            ?>
                <h3 class="sc-header">
                    <span><input class="wb-switch" type="checkbox" data-target="#J_urlSEOSettingBox"  name="<?php echo $url_seo_field;?>[active]" <?php echo $url_seo_val['active']?' checked':'';?> value="1" id="url_seo_active"></span>
                    <strong>链接优化</strong>
                    <span>站内外链接改写优化设置</span>
                </h3>
                <div class="sc-body">
                    <table class="wbs-form-table default-hidden-box active" id="J_urlSEOSettingBox">
                        <tbody>
                        <tr>
                            <th class="row w8em">站内链接优化</th>
                            <td>
                                <div class="item-block">
                                    <input class="wb-switch" value="1" type="checkbox" name="<?php echo $url_seo_field;?>[reset_tag]" <?php echo isset($url_seo_val['reset_tag']) && $url_seo_val['reset_tag']?' checked':'';?>><span>标签URL改写为： /Tag/%tag_id%</span>
                                    <p class="description">*WordPress中文TAG标签默认生成的URL对搜索引擎不友好，通过改写URL优化SEO</p>
                                </div>

                                <div class="item-block pt-l">
                                    <input class="wb-switch" value="1" type="checkbox" name="<?php echo $url_seo_field;?>[hide_category]" <?php echo isset($url_seo_val['hide_category']) && $url_seo_val['hide_category']?' checked':'';?>> <span>隐藏URL地址category字段</span>
                                    <p class="description">启用后分类URL地址为https://www.yourdomain.com/<del>category/</del>catename/…</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="row w8em">站外链接优化</th>
                            <td>
                                <div class="item-block">

                                    <dl id="exclude_dl">
                                        <dt>例外域名</dt>
                                        <?php foreach($url_seo_val['exclude'] as $val){

                                            echo '<dd><input class="wbs-input wbs-input-short" name="'.$url_seo_field.'[exclude][]" value="'.$val.'"> <button type="button" onclick="jQuery(this).parent().remove();">-</button> </dd>';

                                        }?>

                                        <dd>
                                            <input class="wbs-input wbs-input-short" name="<?php echo $url_seo_field;?>[exclude][]" value="" placeholder="例如：yourdomain.com">
                                            <button type="button" style="display: none;" onclick="jQuery(this).parent().remove();">-</button><button class="wbs-btn-primary" type="button" onclick="jQuery('#exclude_dl').append(jQuery(this).parent().clone());jQuery(this).prev().show();jQuery(this).remove();">增加</button>
                                        </dd>
                                    </dl>
                                    <p class="description">*无需填写http(s)://协议头，仅填写主域名即可。如：yourdomain.com</p>
                                </div>

                                <div class="item-block">
                                    <input class="wb-switch" value="1" type="checkbox" name="<?php echo $url_seo_field;?>[set_nofollow]" <?php echo isset($url_seo_val['set_nofollow']) && $url_seo_val['set_nofollow']?' checked':'';?>> <span>所有Post及Page页面站外链接增加 <code>rel="noopener noreferrer nofollow"</code> </span>
                                </div>

                                <div class="item-block mt">
                                    <input class="wb-switch" value="1" type="checkbox" name="<?php echo $url_seo_field;?>[set_gopage]" <?php echo isset($url_seo_val['set_gopage']) && $url_seo_val['set_gopage']?' checked':'';?>>
                                    <span>站外链接改写为https://www.yourdomain.com/go?=*</span>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="tab-content" id="J_404Url">
                <h3 class="sc-header">
                    <strong>404监测</strong>
                    <span></span>
                </h3>
                <div class="sc-body log-box">
	                <?php if(!$spider_install || !$spider_active){?>
                        <div class="getpro-mask">
                            <div class="mask-inner">
				                <?php
				                if(!$spider_install){?>
                                    <div class="tips">
                                        <p>* 当前功能依赖Spider Analyser-蜘蛛分析插件。</p>
                                        <div class="wb-hl mt">
                                            <svg class="wb-icon wbsico-notice"><use xlink:href="#wbsico-notice"></use></svg>
                                            <span>未检测到安装，去</span>
                                            <a class="link" href="<?php echo admin_url('plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term');?>">安装</a>
                                        </div>
                                    </div>
				                <?php }else if(!$spider_active){?>
                                    <div class="tips">
                                        <p>* 当前功能依赖Spider Analyser-蜘蛛分析插件。</p>
                                        <div class="wb-hl mt">
                                            <svg class="wb-icon wbsico-notice"><use xlink:href="#wbsico-notice"></use></svg>
                                            <span>检测到未启用，去</span>
                                            <a class="link" href="<?php echo admin_url('plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term');?>">启用</a>
                                        </div>
                                    </div>
				                <?php } ?>
                            </div>
                        </div>
	                <?php }else{

		                global $wpdb;

		                $url_404_log = $wpdb->prefix.'wb_spider_log';
		                $total = $wpdb->get_var("SELECT COUNT(1) FROM $url_404_log WHERE `code`=404");

		                ?>
                        <table class="table wbs-table">
                            <thead>
                            <tr>
                                <th>URL地址</th>
                                <th>响应码</th>
                                <th>反馈蜘蛛</th>
                                <th>访问时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody id="404_url_box" data-offset="0" data-total="<?php echo $total;?>"></tbody>
                        </table>
		                <?php if($total>0){?>
                            <div class="btns-bar" id="404_url_more">
                                <a class="more-btn">查看更多</a>
                            </div>
		                <?php }else{?>
                            <div class="empty-tips-bar">
                                <span>- 暂无数据 -</span>
                            </div>
		                <?php } ?>

	                <?php } ?>
                </div>

            </div>
            <?php $broken_seo_field = $setting_field.'[broken]';
            $broken_seo_val = isset($opt['broken'])?$opt['broken']:array('test_rate'=>30,'post_type'=>array('post','page'),'post_status'=>array('publish','future','pending'),'exclude'=>array(),'auto_op'=>array());
            $url_log = $wpdb->prefix.'wb_sst_broken_url';
            $total = $wpdb->get_var("SELECT COUNT(1) FROM $url_log WHERE url_md5 IS NOT NULL");
            $broken_url_sum = Smart_SEO_Tool_Admin::broken_url_count();
            ?>
            <div class="tab-content" id="J_brokenLink">
                <h3 class="sc-header">
                    <strong>失效URL</strong>
                    <span></span>
                </h3>
                <div class="sc-body log-box">
                    <div class="tab-nav" id="broken_url_type">
                        <a class="tn-item current" data-type="0">全部 (<?php echo $total;?>)</a>
                        <a class="tn-item" data-type="3">正常 (<?php echo $broken_url_sum['ok'];?>)</a>
                        <a class="tn-item" data-type="1">异常 (<?php echo $broken_url_sum['error'];?>)</a>
                        <a class="tn-item" data-type="2">重定向 (<?php echo $broken_url_sum['redirect'];?>)</a>
                    </div>
                    <table class="table wbs-table mt">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="batch_broken_chk"></th>
                            <th>URL</th>
                            <th>状态</th>
                            <th>文章</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="broken_url_box" data-offset="0" data-total="<?php echo $total;?>"></tbody>
                        <?php if($total>0){?>
                        <tfoot id="broken_footer">
                        <tr>
                            <td><input type="checkbox" class="batch_broken_chk"></td>
                            <td colspan="4">
                                <select id="broken_url_batch">

                                    <option value="">批量操作</option>
                                    <option value="update">重新检查</option>
                                    <option value="cancel">取消链接</option>
                                    <option value="ok">未失效</option>
                                </select>

                                <button id="broken_url_batch_submit" type="button" class="button-secondary">应用</button>
                            </td>
                        </tr>
                        </tfoot>
                        <?php } ?>
                    </table>
                    <?php if($total>0){?>
                        <div class="btns-bar" id="broken_url_more">
                            <a class="more-btn">查看更多</a>

                            <button id="clear_broken_url" class="button-primary" type="button">重新检测</button>
                        </div>
                        <div id="broken_url_empty" style="display: none;" class="empty-tips-bar">
                            <span>- 暂无数据 -</span>
                        </div>
                    <?php }else{?>
                        <div class="empty-tips-bar">
                            <span>- 暂无数据 -</span>
                        </div>
                    <?php } ?>
                </div>


                <h3 class="sc-header">
=                    <strong>设置</strong>
                </h3>
                <div class="sc-body">

                    <table class="wbs-form-table">
                        <tbody>
                        <tr>
                            <th class="w6em">开启</th>
                            <td class="info">
                                <span><input class="wb-switch" type="checkbox" name="<?php echo $broken_seo_field;?>[active]" <?php echo $broken_seo_val['active']?' checked':'';?> value="1"></span>
                            </td>
                        </tr>

                        <tr>
                            <th>检测频率</th>
                            <td>
                                <div class="selector-bar">
                                <?php foreach(array(3=>'每3天',7=>'每7天',30=>'每30天') as $_k=>$_v){
                                    echo '<label><input type="radio" name="'.$broken_seo_field.'[test_rate]"'.($broken_seo_val['test_rate'] == $_k?' checked':'').' value="'.$_k.'"/><span>'.$_v.'</span></label>';
                                } ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>检测范围</th>
                            <td>
                                <div class="selector-bar">
                                    <strong class="label">文章类型</strong>
                                    <?php
                                global  $wp_post_types;
                                if($wp_post_types && is_array($wp_post_types))foreach($wp_post_types as $type){
                                    if($type->public){
                                        echo '<label><input type="checkbox" name="'.$broken_seo_field.'[post_type][]"'.(in_array($type->name,$broken_seo_val['post_type'])?' checked="checked"':'').' value="'.$type->name.'"/><span>'.$type->labels->name.'</span></label> ';
                                    }

                                }
                                ?>
                                </div>

                                <div class="selector-bar">
                                    <strong class="label">文章状态</strong>
                                      <?php
                                    global  $wp_post_statuses;
                                    if($wp_post_statuses && is_array($wp_post_statuses))foreach($wp_post_statuses as $type){
                                        if($type->show_in_admin_status_list){
                                            echo '<label><input type="checkbox" name="'.$broken_seo_field.'[post_status][]"'.(in_array($type->name,$broken_seo_val['post_status'])?' checked="checked"':'').' value="'.$type->name.'"/><span>'.$type->label.'</span></label> ';
                                        }

                                    }
                                    ?>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <th>排除域名列表</th>
                            <td>
                                <dl id="broken_exclude_dl">
                                    <dt>例外域名</dt>
                                    <?php foreach($broken_seo_val['exclude'] as $val){
                                        if(empty($val))continue;
                                        echo '<dd><input class="wbs-input wbs-input-short" name="'.$broken_seo_field.'[exclude][]" value="'.$val.'"> <button type="button" onclick="jQuery(this).parent().remove();">-</button> </dd>';

                                    }?>

                                    <dd>
                                        <input class="wbs-input wbs-input-short" name="<?php echo $broken_seo_field;?>[exclude][]" value="" placeholder="例如：yourdomain.com">
                                        <button type="button" style="display: none;" onclick="jQuery(this).parent().remove();">-</button>
                                        <button class="wbs-btn-primary" type="button" onclick="jQuery('#broken_exclude_dl').append(jQuery(this).parent().clone());jQuery(this).prev().show();jQuery(this).remove();">增加</button>
                                    </dd>
                                </dl>
                                <p class="description mt">*无需填写http(s)://协议头，仅填写主域名即可。如：yourdomain.com</p>
                            </td>
                        </tr>
                        <tr style="display: none;">
                            <th>自动操作</th>
                            <td>
                                <?php foreach(array('del_url'=>'自动删除失效URL','auto_update'=>'自动修复重定向') as $_k=>$_v){
                                    echo '<label><input type="checkbox" name="'.$broken_seo_field.'[auto_op][]"'.(in_array($_k,$broken_seo_val['auto_op'])?' checked="checked"':'').' value="'.$_k.'"/>'.$_v.'</label>';
                                } ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>


                </div>
            </div>

            <div class="tab-content" id="J_robotsSection">
	            <?php
	            $robots_seo_field = $setting_field.'[robots_seo]';
	            $robots_seo_val = isset($opt['robots_seo'])?$opt['robots_seo']:array('active'=>1);
	            ?>
                <h3 class="sc-header">
                    <span><input class="wb-switch" type="checkbox" data-target="#J_robotsSEOSettingBox"  name="<?php echo $robots_seo_field;?>[active]" <?php echo $robots_seo_val['active']?' checked':'';?> value="1" id="robots_seo_active"></span>
                    <strong>robots.txt</strong>
                    <span>搜索引擎爬虫权限设置</span>
                </h3>
                <div class="sc-body">
                    <table class="wbs-form-table default-hidden-box<?php echo $robots_seo_val['active']?' active':'';?>" id="J_robotsSEOSettingBox">
                        <tbody>
                        <tr>
                            <th class="row w8em">当前状态</th>
                            <td>
					            <?php if(0): ?>
                                    <p class="pd-b">当前未设置robots.txt，将使用通用robots.txt</p>
					            <?php else: ?>
                                    <p class="pd-b">已设置robots.txt，通过下方编辑框修改编辑</p>
                                    <div class="w100">
							            <?php
							            $robots_seo_val['content'] = isset($robots_seo_val['content']) && !empty($robots_seo_val['content']) ? $robots_seo_val['content']: '';

							            wp_editor( Smart_SEO_Tool_Sitemap::robots('',''), 'editor_robottxt_content', array(
									            'teeny' => true,
									            'textarea_rows' => 10,
									            'tinymce' => false,
									            'media_buttons' => false,
									            'quicktags' => false,
									            'textarea_name' => $robots_seo_field.'[content]')
							            );
							            ?>
                                    </div>
					            <?php endif; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="wbs-form-table">
                        <tbody>
                        <tr>
                            <th class="row w8em">使用说明</th>
                            <td>
                                <ol class="ol-decimal">
                                    <li>robots.txt可以告诉百度您网站的哪些页面可以被抓取，哪些页面不可以被抓取。</li>
                                    <li>您可以通过Robots工具来创建、校验、更新您的robots.txt文件，或查看您网站robots.txt文件在百度生效的情况。</li>
                                    <li>Robots工具目前支持48k的文件内容检测，请保证您的robots.txt文件不要过大，目录最长不超过250个字符。</li>
                                    <li>建议将wp-admin, wp-includes等不适宜被蜘蛛爬取的路径设为不可爬取，且可以禁止非主流的蜘蛛类型。</li>
                                    <li>参考阅读<a href="https://www.wbolt.com/optimize-wordpress-robots-txt.html"  target="_blank">《如何编写和优化WordPress网站的Robots.txt》</a> </li>
                                </ol>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>



            <div class="tab-content" id="J_sitemapSection">
	            <?php
	            $sitemap_seo_field = $setting_field.'[sitemap_seo]';
	            $sitemap_seo_val = $opt['sitemap_seo'];
	            ?>
                <h3 class="sc-header">
                    <span><input class="wb-switch" type="checkbox" data-target="#J_sitemapSEOSettingBox"  name="<?php echo $sitemap_seo_field;?>[active]" <?php echo $sitemap_seo_val['active']?' checked':'';?> value="1" id="sitemap_seo_active"></span>
                    <strong>Sitemap生成</strong>
                    <span>用于生成符合搜索引擎标准的sitemap文件</span>
                </h3>
                <div class="sc-body">

                    <table class="wbs-form-table default-hidden-box<?php echo $sitemap_seo_val['active']?' active':'';?>" id="J_sitemapSEOSettingBox">
                        <tbody>
                        <tr>
                            <th class="row w8em">通知搜索引擎</th>
                            <td>
					            <?php
					            $sitemap_field = $sitemap_seo_field.'[push_to]';
					            $sitemap_val = $sitemap_seo_val['push_to'];
					            ?>
                                <div class="item-block">
                                    <input class="wb-switch" value="1" type="checkbox" name="<?php echo $sitemap_field;?>[google]" <?php echo $sitemap_val['google']?' checked':'';?>> 谷歌 <span class="description">* 您也可以访问<a href="https://search.google.com/search-console" target="_blank">谷歌站长平台</a>提交你的Sitemap及查看更多信息。<a href="https://www.wbolt.com/how-to-add-a-sitemap-to-google-searchconsole.html"  target="_blank">《如何通过谷歌站长工具提交WordPress网站Sitemap》</a></span>
                                </div>
                                <div class="item-block">
                                    <input class="wb-switch" value="1" type="checkbox" name="<?php echo $sitemap_field;?>[bing]" <?php echo $sitemap_val['bing']?' checked':'';?>> Bing <span class="description">* 您也可以访问<a href="https://www.bing.com/toolbox/webmaster" target="_blank">Bing网站管理员工具</a>提交你的Sitemap及查看更多信息。<a href="https://www.wbolt.com/how-to-add-a-sitemap-to-bing-webmaster.html"  target="_blank">《如何添加Sitemap地图到Bing网站管理工具》</a></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="row w8em"></th>
                            <td>
                                <div class="item-block">
								    <p>温馨提示</p>
                                    <p class="description">1. 百度、360搜索及头条搜索均不支持sitemap通知，但可以手动提交sitemap。</p>
                                    <p class="description">2. 教程：<a href="https://www.wbolt.com/how-to-set-a-sitemap-linksubmit.html"  target="_blank">《提交Sitemap至百度搜索资源平台》</a>，<a href="https://www.wbolt.com/how-to-add-a-sitemap-to-360-zhanzhang.html" target="_blank">《提交Sitemap至360站长平台》</a>及<a href="https://www.wbolt.com/how-to-set-a-sitemap-linksubmit-for-toutiao.html" target="_blank">《提交Sitemap至头条搜索站长平台》</a></p>
                                </div>
                            </td>
                        </tr>
                        <?php if(!$is_rewrite){?>
						<tr>
                            <th class="row w8em">服务器配置</th>
                            <td>
							    <div class="item-block">
					                <p class="description">您当前使用的是<?php echo $software;?>网络服务器，请确保您已经配置伪静态及重写规则，否则sitemap可能生成失败：</p>
<code class="wbs-code-box"><?php if($software == 'Nginx'){?>
    # 为了sitemap能正常访问，请确保当前网站nginx配置文件添加了以下Wordpress伪静态 或 配置了 Sitemap URL重写规则
    # Wordpress伪静态规则
    location / {
    try_files $uri $uri/ /index.php?$args;
    }
    rewrite /wp-admin$ $scheme://$host$uri/ permanent;

    # Sitemap URL重写规则
    rewrite ^/sitemap(-([a-zA-Z0-9_-]+))?\.xml$ "/index.php?wb_sitemap=$2" last;
    <?php }else{?>
    # 为了sitemap能正常访问，请确保当前网站.htaccess配置文件添加了以下Wordpress伪静态 或 配置了 Sitemap URL重写规则
    # Wordpress伪静态规则
    &lt;IfModule mod_rewrite.c&gt;
        RewriteEngine On
        RewriteBase /
        RewriteRule ^index\.php$ - [L]
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule . /index.php [L]
    &lt;/IfModule&gt;
    # Sitemap URL重写规则
    &lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On
    RewriteRule ^sitemap(-([a-zA-Z0-9_-]+))?\.xml$ index.php?wb_sitemap=$2 [L]
    &lt;/IfModule&gt;
    <?php } ?>
</code>
								</div>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th class="row w8em">Sitemap内容</th>
                            <td>
					            <?php
                                $sitemap_field = $sitemap_seo_field.'[content_item]';
                                $sitemap_val = $sitemap_seo_val['content_item'] ;


                                $items_label = array('index'=>'首页','archive'=>'存档页面','author'=>'作者页面');
                                $post_types = Smart_SEO_Tool_Sitemap::post_types();
                                //print_r($post_types);
                                foreach($post_types as $k=>$r){
                                    $items_label[$k] = $r->labels->name;
                                    if(!isset($sitemap_val[$k])){
                                        $sitemap_val[$k] = array('switch'=>0,'weights'=>0.8,'frequency'=>'daily');
                                    }
                                }

                                $taxonomies = Smart_SEO_Tool_Sitemap::taxonomies();
                                foreach($taxonomies as $k=>$r){
                                    $items_label[$k] = $r->labels->name;
                                    if(!isset($sitemap_val[$k])){
                                        $sitemap_val[$k] = array('switch'=>0,'weights'=>$r->hierarchical?0.6:0.3,'frequency'=>'weekly');
                                    }
                                }
                                //print_r($taxonomies);


					            $frequency_arr = array('always'=>'总是','hourly'=>'每小时','daily'=>'每天','weekly'=>'每周','monthly'=>'每月','yearly'=>'每年','never'=>'从不');

					            ?>
                                <div class="table-wp-m">
                                    <table class="table table-with-border">
                                        <thead>
                                        <tr>
                                            <th>名称</th>
                                            <th>别名</th>
                                            <th>优先</th>
                                            <th>更改频率</th>
                                            <th class="w5">开关</th>
                                        </tr>
                                        </thead>
                                        <tbody>
		                                <?php foreach($sitemap_val as $name => $value) :
			                                ?>
			                                <?php $sitemap_field_name = $sitemap_field.'['.$name.']'; ?>
                                            <tr>
                                                <td><?php echo $items_label[$name]; ?></td>
                                                <td><?php echo $name; ?></td>
                                                <td>
                                                    <input class="wbs-input-range" name="<?php echo $sitemap_field_name; ?>[weights]" type="range" max="1" min="0.1" step="0.1" value="<?php echo $value['weights']; ?>">
                                                    <span class="wbs-range-val"><?php echo $value['weights'] * 100 . '%'; ?></span>
                                                </td>
                                                <td>
                                                    <select name="<?php echo $sitemap_field_name; ?>[frequency]" value="<?php echo $value['frequency']; ?>">
						                                <?php foreach($frequency_arr as $i => $v): ?>
                                                            <option value="<?php echo $i; ?>" <?php if($i == $value['frequency']) echo 'selected'; ?>><?php echo $v; ?></option>
						                                <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td><input class="wb-switch" value="1" type="checkbox" name="<?php echo $sitemap_field_name;?>[switch]" <?php echo $value['switch']?' checked':'';?>></td>
                                            </tr>
		                                <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th class="row w8em">Sitemap地址</th>
                            <td>
                                <p class="text-only"><a href="<?php echo home_url('/sitemap.xml'); ?>" target="_blank"><?php echo home_url('/sitemap.xml'); ?></a></p>

                                <div class="item-block">
                                    <h4 class="scb-hd">子sitemap清单</h4>
                                    <div class="scb-bd">
                                    <textarea class="wbs-input" id="J_subSML" rows="10"><?php
	                                    $sub_sitemap = Smart_SEO_Tool_Sitemap::sitemap_index();
	                                    if($sub_sitemap)foreach($sub_sitemap as $map){
		                                    echo $map."\n";
	                                    }
	                                    ?></textarea>
                                    </div>
                                    <div>
                                        <button type="button" class="button-primary" id="J_copySubSML">复制</button>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <th class="row w8em"></th>
                            <td>
                                <div class="item-block">
                                    <p>温馨提示</p>
                                    <p class="description">1. 百度新规，索引型sitemap不予处理且子文件会占用配额；</p>
                                    <p class="description">2. 百度搜索资源平台每日仅可提交10条sitemap地址；</p>
                                    <p class="description">3. 复制上面子Sitemap地址至百度搜索资源平台提交。教程：<a href='https://www.wbolt.com/submit-sitemap-url-to-baidu.html' target="_blank">百度搜索引擎之非索引型sitemap提交</a></p>
									<p class="description">4. 为了提升推送效果，建议安装<a class="link" href="<?php echo admin_url('plugin-install.php?s=Wbolt+baidu+submit+link&tab=search&type=term');?>">百度搜索推送插件</a>，以多种方式同时提交URL至百度及Bing搜索引擎。</p>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <script type="text/javascript" src="https://www.wbolt.com/wb-api/v1/news/lastest"></script>


            <div class="wb-copyright-bar">
                <div class="wbcb-inner">
                    <a class="wb-logo" href="https://www.wbolt.com" data-wba-campaign="footer" title="WBOLT" target="_blank"><svg class="wb-icon sico-wb-logo"><use xlink:href="#sico-wb-logo"></use></svg></a>
                    <div class="wb-desc">
                        Made By <a href="https://www.wbolt.com" data-wba-campaign="footer" target="_blank">闪电博</a>
                        <span class="wb-version">版本：<?php echo $pd_version;?></span>
                    </div>
                    <div class="ft-links">
                        <a href="https://www.wbolt.com/plugins" data-wba-campaign="footer" target="_blank">免费插件</a>
                        <a href="https://www.wbolt.com/knowledgebase" data-wba-campaign="footer" target="_blank">插件支持</a>
                        <a href="<?php echo $pd_doc_url; ?>" data-wba-campaign="footer" target="_blank">说明文档</a>
                        <a href="https://www.wbolt.com/terms-conditions" data-wba-campaign="footer" target="_blank">服务协议</a>
                        <a href="https://www.wbolt.com/privacy-policy" data-wba-campaign="footer" target="_blank">隐私条例</a>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <div class="wbs-footer" id="optionsframework-submit">
        <div class="wbsf-inner">
            <button class="wbs-btn-primary" type="submit" name="update">保存设置</button>
        </div>
    </div>
    </form>
</div>
