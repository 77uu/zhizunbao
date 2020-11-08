<?php
/**
 * This was contained in an addon until version 1.0.0 when it was rolled into
 * core.
 *
 * @package    WBOLT
 * @author     WBOLT
 * @since      3.4.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2019, WBOLT
 */


if(!defined('ABSPATH')){
    return;
}


$pd_title = '百度推送管理';
$pd_version = BSL_VERSION;
$pd_code = 'bsl-setting';
$pd_index_url = 'https://www.wbolt.com/plugins/bsl-pro';
$pd_doc_url = 'https://www.wbolt.com/bsl-plugin-documentation.html';


$spider_install = file_exists(WP_CONTENT_DIR.'/plugins/spider-analyser/index.php');
if($spider_install){
    $spider_active = class_exists('WP_Spider_Analyser');
}
?>

<?php
/**<div class="notice-info notice is-dismissible" style="display:none;" id="J_wbBslNotice">
    <p>通知：</p>
    <p>（1）百度已于5月18日下线天级收录推送，插件自v3.2.7版本不再提供相关功能支持。</p>
	<p>（2）百度搜索资源平台已下线自动推送功能，插件同步下线此功能。</p>
</div>
 */
 ?>

<div class="v-wp" id="optionsframework-wrap" data-wba-source="<?php echo $pd_code; ?>" v-cloak>
    <div id="version_tips" v-if="new_ver">
        <div class="update-message notice inline notice-warning notice-alt">

            <p>当前<?php echo $pd_title;?>有新版本可用. <a href="<?php echo $pd_index_url; ?>" data-wba-campaign="notice-bar#J_updateRecordsSection" target="_blank">查看版本<span class="ver">{{new_ver}}</span> 详情</a>
                或 <a href="<?php echo admin_url('/plugins.php?plugin_status=upgrade');?>" class="update-link" aria-label="现在更新<?php echo $pd_title;?>">现在更新</a>.
            </p>

        </div>
    </div>


<form action="options.php" method="post" autocomplete="off" class="wrap wbs-wrap">

    <div class="wbs-header">
        <svg class="wb-icon sico-wb-logo"><use xlink:href="#sico-wb-logo"></use></svg>
        <span>WBOLT</span>
        <strong><?php echo $pd_title; ?><i class="tag-pro" v-if="is_pro">PRO版</i><i class="tag-pro free" v-if="!is_pro">Free版</i></strong>

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

    <div class="wbs-main">
        <div class="wbs-aside wbs-aside-bsl">
            <ul class="wbs-tabs wbs-menu">
                <li class="tab-item" :class="{current: cur_section=='overview'}">
                    <a class="lv1" @click="switchMenu('overview')"><svg class="wb-icon sico-data"><use xlink:href="#sico-data"></use></svg><span>数据统计</span></a>
                    <div class="sub-menu">
                        <a :class="{current: cur_section=='overview'}" @click="switchMenu('overview')"><span>整站收录统计</span></a>
                        <a :class="{current: cur_section=='collection'}" @click="switchMenu('collection')"><span>普通收录推送</span></a>
                        <a :class="{current: cur_section=='push_daily'}" @click="switchMenu('push_daily')"><span>快速收录推送</span><i class="tag-pro" v-if="!is_pro">Pro</i></a>
                        <a :class="{current: cur_section=='collection_list'}" @click="switchMenu('collection_list')"><span>文章收录清单</span><i class="tag-pro" v-if="!is_pro">Pro</i></a>
                        <a v-if="cnf.check_404" :class="{current: cur_section=='sp_404_url'}" @click="switchMenu('sp_404_url')"><span>死链提交清单</span></a>

                    </div>
                </li>

                <li v-if="cnf.bing_key && (cnf.bing_auto||cnf.bing_manual)" class="tab-item" :class="{current: cur_section=='bing'}">
                    <a class="lv1" @click="switchMenu('bing')"><svg class="wb-icon sico-bing"><use xlink:href="#sico-bing"></use></svg><span>Bing推送</span></a>
                    <div class="sub-menu">
                        <a :class="{current: cur_section=='bing'}" @click="switchMenu('bing')"><span>Bing推送统计</span></a>
                        <a :class="{current: cur_section=='bing_auto'}" @click="switchMenu('bing_auto')"><span>Bing自动推送</span><i class="tag-pro" v-if="!is_pro">Pro</i></a>
                        <a :class="{current: cur_section=='bing_manual'}" @click="switchMenu('bing_manual')"><span>Bing手动推送</span></a>

                    </div>
                </li>

                <li class="tab-item" :class="{current: cur_section=='log_takepush'}">
                    <a class="lv1" @click="switchMenu('log_takepush')"><svg class="wb-icon sico-log"><use xlink:href="#sico-log"></use></svg><span>相关日志</span></a>
                    <div class="sub-menu">
                        <a :class="{current: cur_section=='log_takepush'}" @click="switchMenu('log_takepush')"><span>普通收录日志</span></a>
                        <a :class="{current: cur_section=='log_dailypush'}" @click="switchMenu('log_dailypush')"><span>快速收录日志</span><i class="tag-pro" v-if="!is_pro">Pro</i></a>
                        <a :class="{current: cur_section=='log_setting'}" @click="switchMenu('log_setting')"><span>插件执行日志</span><i class="tag-pro" v-if="!is_pro">Pro</i></a>
                    </div>
                </li>
                <li class="tab-item" :class="{current: cur_section=='setting'}">
                    <a class="lv1" @click="switchMenu('setting')"><svg class="wb-icon sico-setting"><use xlink:href="#sico-setting"></use></svg><span>插件设置</span></a>
                    <div class="sub-menu">
                        <a @click="cur_section='setting'" href="#settingType"><span>推送文章类型</span></a>
                        <a @click="cur_section='setting'" href="#settingSearchBD"><span>百度推送设置</span></a>
                        <a @click="cur_section='setting'" href="#setting404url"><span>死链检测设置</span></a>
                        <a @click="cur_section='setting'" href="#settingCollectionBD"><span>百度收录查询</span><i class="tag-pro" v-if="!is_pro">Pro</i></a>
                        <a @click="cur_section='setting'" href="#settingBing"><span>Bing推送设置</span></a>

                    </div>
                </li>
                <li class="tab-item" v-if="!isMobile()">
                    <a class="lv1" @click="switchMenu('about_pro')">
                        <i class="pro-btn"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="wbs-content option-form" id="optionsframework">
			<?php
			settings_fields($setting_field);
			?>

            <div id="wbui99" class="wbui wbui-loading" index="999"><div class="wbui-main"><div class="wbui-section"><div class="wbui-child  wbui-anim-def"><div class="wbui-cont"><i></i><i class="wbui-load"></i><i></i><p></p></div></div></div></div></div>

            <!-- overview S-->
            <div class="sc-wp" v-if="cur_section=='overview' || (isMobile() && cur_section=='overview')">
                <h3 class="sc-header ov-header">
                    <div class="ov-ctrl"><span>最后更新：<?php echo get_option('wb_idx_data_updated','-');?></span> <a class="btn-with-svg" @click="update_index_data" onclick="this.classList.add('active');"><svg class="wb-icon sico-update"><use xlink:href="#sico-update"></use></svg> <span>手动更新</span></a></div>
                    <strong>收录概况</strong>
                </h3>
                <div class="sc-body">
                    <div class="data-overview">
                        <div class="ao-it" v-for="item in overview">
                            <dl>
                                <dt class="it-name">{{item.name}}</dt>
                                <dd class="it-value">{{item.value}}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="sc-body overview-charts">
                    <h3 class="sc-header">
                        <strong>收录趋势</strong>
                    </h3>
                    <div class="tab-nav">
                        <a class="tn-item" v-bind:class="{current: echart_switch.collection_overview==7}" @click="echart_switch.collection_overview=7;collectionOverview(7)">近7天</a>
                        <a class="tn-item" v-bind:class="{current: echart_switch.collection_overview==30}" @click="echart_switch.collection_overview=30;collectionOverview(30)">近30天</a>
                    </div>
                    <v-chart class="charts-box" :options="collection_overview"/>
                </div>
                <dl class="description mt">
                    <dt>温馨提示：</dt>
                    <dd><b>整站收录数据为估算值</b>，本地查询数据每6小时更新一次，API查询数据每天更新一次。网站管理员如需了解更准确的索引量，请使用百度站长平台。</dd>
                    <dd>百度收录数据可能与百度搜索引擎查询有一定的差异，这跟不同地域不同客户端不同时间等因素搜索有关。</dd>
                    <dd v-if="!is_pro"><b>整站收录概况查询提示“请求返回【没有找到数据】”</b>，这是由于百度防爬虫机制导致。建议<a class="link" style="cursor: pointer;" @click="aboutPro">升级Pro版本</a>，使用百度收录查询API数据。</dd>
                </dl>
            </div>

            <div class="sc-wp" v-if="cur_section=='collection' || (isMobile() && cur_section=='overview')">
                <h3 class="sc-header">
                    <strong>普通收录推送</strong>
                </h3>

                <div class="sc-body">
                    <div class="tab-nav">
                        <a class="tn-item" v-bind:class="{current: echart_switch.push_overview==7}" @click="echart_switch.push_overview=7;pushOverview(7)">近7天</a>
                        <a class="tn-item" v-bind:class="{current: echart_switch.push_overview==30}" @click="echart_switch.push_overview=30;pushOverview(30)">近30天</a>
                    </div>
                    <div class="charts-wp">
                        <div class="chart">
                            <v-chart class="charts-box" :options="push_overview"/>
                        </div>
                    </div>

                    <dl class="description mt">
                        <dt>数据说明：</dt>
                        <dd>这里数据仅代表插件协作推送至百度搜索资源平台的数据，即完整推送数据；</dd>
                        <dd>百度搜索资源平台的统计数据为主动和sitemap推送方式去重数据，除sitemap推送外，主动推送不重复计算已经收录或者推送过的数据；</dd>
                        <dd>推送数据不代表收录数据，积极向百度推送数据目的是为了更好地获得收录数据。</dd>
                        <dd>对于已推送过的数据，不作重复推送，避免百度判断站点推送内容质量度低。</dd>
                    </dl>
                </div>
            </div>

            <div class="sc-wp" v-if="cur_section == 'push_daily' || (isMobile() && cur_section=='overview')">
                <h3 class="sc-header">
                    <strong>快速收录推送</strong>
                    <i class="tag-pro" @click="aboutPro">Pro</i>
                </h3>

                <div class="sc-body">
                    <div class="tab-nav">
                        <a class="tn-item" v-bind:class="{current: echart_switch.day_push==7}" @click="echart_switch.day_push=7;dayPush(7)">近7天</a>
                        <a class="tn-item" v-bind:class="{current: echart_switch.day_push==30}" @click="echart_switch.day_push=30;dayPush(30)">近30天</a>
                    </div>

                    <div class="charts-wp">
                        <div class="chart"><v-chart class="charts-box" :options="day_push"/></div>

                        <div v-if="!is_pro" class="getpro-mask">
                            <div class="mask-inner">
                                <a class="wbs-btn-primary j-get-pro" @click="aboutPro">获取PRO版本</a>
                                <p class="tips">* 注意：当前为随机演示数据，仅供参考</p>
                            </div>
                        </div>
                    </div>
                    <dl class="description mt">
                        <dt>温馨提示：</dt>
                        <dd>这里仅统计快速收录推送数据，快速收录推送收录情况请访问<a class="link" target="_blank" href="https://ziyuan.baidu.com/">百度搜索资源平台</a>查看。</dd>
                        <dd>快速收录推送收录数据有时候会出现1周的数据延迟或无数据的情况，这是百度系统问题。</dd>
                    </dl>
                </div>
            </div>

            <div class="sc-wp" v-if="cur_section == 'collection_list' || (isMobile() && cur_section=='overview')">
                <h3 class="sc-header">
                    <strong>文章收录清单</strong>
                    <i class="tag-pro" @click="aboutPro">Pro</i>
                </h3>

                <div class="sc-body log-box">
                    <div class="tab-nav style-b">
                        <a class="tn-item" :class="{current:log_baidu_type==1}" @click="switch_log_baidu(1)">所有文章</a>
                        <a class="tn-item" :class="{current:log_baidu_type==2}" @click="switch_log_baidu(2)">已收录文章</a>
                        <a class="tn-item" :class="{current:log_baidu_type==3}" @click="switch_log_baidu(3)">未收录文章</a>


                        <span class="btn-update disabled" v-if="last_check_date != ''">
                            <span>当前站点已完成{{query_times}}次收录查询 ,状态最后更新时间: {{last_check_date}} </span>
                            <a v-if="check_all == 0 && is_pro && cnf.in_bd_active" class="tn-item" @click="check_all_post">全量检测</a>
                        </span>
                    </div>

                    <div class="mt log-box">
                        <table class="wbs-table">
                            <thead>
                            <tr>
                                <th>标题/URL</th>
                                <th>发布日期</th>
                                <th>收录状态</th>
                                <th>最近检测时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <body>
                            <tr v-for="item in log_baidu">
                                <td><a :href="item.post_url" target="_blank">{{item.post_title}}</a></td>
                                <td>{{item.post_date}}</td>
                                <td v-html='item.in_baidu==1 ? "<span class=\"suc\">已收录</span>": (item.in_baidu == 2?"未收录":"检测中")'></td>
                                <td class="m-hide">{{item.in_baidu  ? item.last_date : ''}}</td>
                                <td class="m-hide">
                                    <a class="ib" href="javascript:void(0);" @click="check_baidu(item)">检测收录</a>
                                    <a class="ib" href="javascript:void(0);" @click="spider_history(item)">蜘蛛历史</a>
                                </td>
                            </tr>
                            </body>
                        </table>
                        <div class="empty-tips-bar" v-show="!log_baidu.length">
                            <span v-if="loading_data == -1">- 暂无数据 -</span>
                        </div>
                        <div class="btns-bar" v-show="log_baidu.length >0 && log_loadmore.baidu">
                            <a class="more-btn" @click="loadBaiduRecord(10)">查看更多</a>
                        </div>

                        <dl class="description mt">
                            <dt>温馨提示：</dt>
                            <dd><b>文章百度收录状态仅供参考，实际收录情况以百度搜索为准；</b></dd>
							<dd>百度升级了搜索验证码机制，收录查询结果可能会出现失败导致结果不准；</dd>
                            <dd>插件根据实际情况不定时检测文章百度收录情况，依据文章新旧赋予查询权重；</dd>
                            <dd>不建议使用过长的URL链接，不利于SEO优化且超出规定长度，无法查询该URL的收录状态；</dd>
                            <dd>网站仅支持一次全量文章收录状态检测;</dd>
							<dd>每个周日为百度收录查询API服务器维护日，不执行收录查询工作。</dd>
                        </dl>
                        <div v-if="!is_pro" class="getpro-mask">
                            <div class="mask-inner">
                                <a class="wbs-btn-primary j-get-pro" @click="aboutPro">获取PRO版本</a>
                                <p class="tips">* 注意：当前为随机演示数据，仅供参考</p>
                            </div>
                        </div>
                        <div v-if="is_pro && !cnf.in_bd_active" class="getpro-mask">
                            <div class="mask-inner">
                                <a class="wbs-btn-primary j-get-pro" @click="switchMenu('setting')">启用收录查询</a>
                                <p class="tips">*注意：当前功能依赖百度收录查询。当前该功能处于关闭状态，需启用后才可使用文章收录清单功能。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- overview E-->

            <div class="sc-wp" v-if="cur_section == 'sp_404_url' || (isMobile() && cur_section=='overview')">
                <h3 class="sc-header">
                    <strong>死链提交清单</strong>
                </h3>
                <div class="sc-body log-box">
                    <div class="mt log-box">
                        <table class="wbs-table">
                            <thead>
                            <tr>
                                <th>URL地址</th>
                                <th>响应码状态</th>
                                <th>检测时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <body>
                            <tr v-for="item in sp_404_url">
                                <td><div class="url"><a :href="item.url" target="_blank">{{item.url}}</a></div></td>
                                <td>{{item.code}}</td>
                                <td class="m-hide">{{item.visit_date}}</td>
                                <td class="m-hide">
                                    <a href="javascript:void(0);" @click="check_404_url(item)">刷新状态</a>
                                    <a href="javascript:void(0);" @click="del_404_url(item)">忽略</a>
                                </td>
                            </tr>
                            </body>
                        </table>
                        <div class="empty-tips-bar" v-show="!sp_404_url.length">
                            <span v-if="loading_data == -1">- 暂无数据 -</span>
                        </div>
                        <div class="btns-bar" v-show="sp_404_url.length >0 && log_loadmore.sp_404_url">
                            <a class="more-btn" @click="load_404_url(10)">查看更多</a>
                        </div>
                        <div class="mt" v-if="sp_404_url.length">
                            <input id="wb_bdsl_404-url" style="opacity: 0;" value="<?php echo home_url('/404-list.txt');?>" data-max="180" type="text" placeholder="" class="wbs-input">
                            <span class="ib vam"><b>清单文件</b>：<?php echo home_url('/404-list.txt');?></span>  <a id="J_copySubSML" onclick="var obj = jQuery('#wb_bdsl_404-url');obj.focus();obj.select();document.execCommand('Copy');wbui.toast('已复制');" class="button wbs-btn-copy ib" target="_blank"> 复制 </a>
                        </div>

                        <dl class="description mt">
                            <dt>温馨提示：</dt>
                            <dd>网站存在大量死链，将影响网站的站点评级，应及时处理网站死链。</dd>
                            <dd>如死链有可替代页面内容，建议采用301永久跳转方式对死链进行处理，<a class="link" target="_blank" data-wba-campaign="Setting-Des-txt" href="https://www.wbolt.com/how-to-fix-404-error-in-wordpress.html">参考教程</a>。</dd>
                            <dd>如死链无可替代页面内容，则应复制死链清单链接，然后登录<a class="link" target="_blank" href="https://ziyuan.baidu.com/">百度搜索资源平台</a>进行死链提交。</dd>
							<dd><a class="link" target="_blank" href="http://zhanzhang.so.com/">360站长平台</a>、<a class="link" target="_blank" href="https://zhanzhang.toutiao.com/">头条搜索站长平台</a>和<a class="link" target="_blank" href="https://zhanzhang.sm.cn/">神马站长平台</a>也提供死链提交支持。</dd>
                            <dd>此死链检测仅检测网站内部链接。</dd>
                        </dl>
                        <?php if(!$spider_install || !$spider_active){?>
                        <div class="getpro-mask">
                            <div class="mask-inner">
                        <?php include BSL_PATH.'/tpl/spider_test.php';?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>


            <bing-push :section="cur_section" :opt="cnf" :is_pro="is_pro" :is_mobile="isMobile()" @switch-menu="switchMenu($event)"></bing-push>

            <!-- log S-->
            <div class="sc-wp" v-if="cur_section == 'log_takepush' || (isMobile() && cur_section=='log_takepush')">
                <h3 class="sc-header">
                    <strong>普通收录日志</strong>
                </h3>
                <div class="log-box">
                    <table class="wbs-table" v-if="log_push">
                        <thead>
                        <tr>
                            <th>日期</th>
                            <th>链接</th>
                            <th>推送状态</th>
                        </tr>
                        </thead>
                        <body>
                        <tr v-for="item in log_push">
                            <td>{{item.date}}</td>
                            <td><div class="url">{{item.url}}</div></td>
                            <td v-html='item.s_push==1 ? "<span class=\"suc\">成功</span>": "失败"'></td>
                        </tr>
                        </body>
                    </table>
                    <div class="empty-tips-bar" v-show="!log_push.length">

                        <span v-if="loading_data == -1">- 最近7天无推送数据，建议保持每日更新内容 -</span>
                    </div>
                    <div class="btns-bar" v-show="log_push.length>0 && log_loadmore.push">
                        <a class="more-btn" @click="loadLogRecord('tackpush',10)">查看更多</a>
                    </div>

                    <div class="description mt">温馨提示：日志仅记录近7天数据。<b>若推送状态为失败，请先自检问题（百度搜索资源平台认证域名与网站实际域名不一致情况较多，区分www和无www域名）</b>，若无法解决<a href="https://www.wbolt.com/member?act=enquire" data-wba-campaign="enquire" target="_blank">提交工单</a>反馈。</div>
                </div>
            </div>

            <div class="sc-wp" v-if="cur_section == 'log_dailypush' || (isMobile() && cur_section=='log_takepush')">
                <h3 class="sc-header">
                    <strong>快速收录日志</strong><i class="tag-pro" @click="aboutPro">Pro</i>
                </h3>

                <div class="log-box">
                    <table class="wbs-table">
                        <thead>
                        <tr>
                            <th>日期</th>
                            <th>链接</th>
                            <th>推送状态</th>
                        </tr>
                        </thead>
                        <body>
                        <tr v-for="item in log_daypush">
                            <td>{{item.date}}</td>
                            <td><div class="url">{{item.url}}</div></td>
                            <td v-html='item.s_push==1 ? "<span class=\"suc\">成功</span>": "失败"'></td>
                        </tr>
                        </body>
                    </table>
                    <div class="empty-tips-bar" v-show="!log_daypush.length">
                        <span v-if="loading_data == -1">- 最近7天无推送数据，建议保持每日更新内容 -</span>
                    </div>
                    <div class="btns-bar" v-if="log_daypush.length >0 && log_loadmore.daypush">
                        <a class="more-btn" @click="loadLogRecord('daypush',10)">查看更多</a>
                    </div>

                    <div class="getpro-mask" v-if="!is_pro">
                        <div class="mask-inner">
                            <a class="wbs-btn-primary" @click="aboutPro">获取PRO版本</a>
                            <p class="tips">* 注意：当前为演示数据，仅供参考</p>
                        </div>
                    </div>
                </div>
                <div class="description mt" v-if="is_pro">温馨提示：日志仅记录近7天数据。若推送状态为失败，多半是由于快速收录推送无配额或者配额已用完导致，建议使用插件执行日志自查，若无法解决<a href="https://www.wbolt.com/member?act=enquire" data-wba-campaign="enquire" target="_blank">提交工单</a>反馈。</div>

            </div>

            <div class="sc-wp" v-if="cur_section == 'log_setting' || (isMobile() && cur_section=='log_takepush')" id="settingLog">
                <h3 class="sc-header">
                    <strong>插件执行日志</strong>
                    <i class="tag-pro" @click="aboutPro">Pro</i>
                </h3>

                <div class="log-box">
                    <table class="wbs-table">
                        <thead>
                        <tr>
                            <td width="20%">时间</td>
                            <td width="15%">类型</td>
                            <td width="*">详情</td>
                        </tr>
                        </thead>
                    </table>
                    <div class="log-wp" style="padding:0;" id="running_log">
                        <table class="wbs-table">
                            <tbody>
                            <tr v-for="r in run_log">
                                <td width="20%">{{r.time}}</td>
                                <td width="15%">{{r.type}}</td>
                                <td>{{r.msg}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="empty-tips-bar" v-show="!run_log.length">
                        <span v-if="loading_data == -1">- 暂无数据 -</span>
                    </div>

                    <div class="mt">
                        <button class="button button-cancel" type="button" @click="clear_log"> 清除日志 </button>
                        <button class="button button-primary" type="button" @click="reload_log"> 刷新日志 </button>
                    </div>

                    <div class="getpro-mask" v-if="!is_pro">
                        <div class="mask-inner">
                            <a class="wbs-btn-primary" @click="aboutPro">获取PRO版本</a>
                            <p class="tips">* 注意：当前为演示数据，仅供参考</p>
                        </div>
                    </div>

                </div>
            </div>
            <!-- log E-->

            <!-- setting S-->
            <div class="sc-wp" v-show="cur_section == 'setting'" id="settingType">
                <h3 class="sc-header">
                    <strong>推送链接类型</strong>
                </h3>
                <div class="sc-body">
                    <table class="wbs-form-table">
                        <tbody>
                        <tr>
                            <th class="row w8em">推送链接类型</th>
                            <td>
                                <div class="selector-bar">
									<?php
									global  $wp_post_types;

									if(!isset($opt['post_type']))$opt['post_type'] = array('post');
									if($wp_post_types && is_array($wp_post_types))foreach($wp_post_types as $type){
										if($type->public){
											echo '<label><input type="checkbox" name="'.$setting_field.'[post_type][]"'.(in_array($type->name,$opt['post_type'])?' checked="checked"':'').' value="'.$type->name.'"/>'.$type->labels->name.'</label> ';
										}

									}
									?>
                                </div>
								<div class="description mt">*不建议推送媒体、页面链接类型至百度。</div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="sc-wp" v-show="cur_section == 'setting'" id="settingSearchBD">
                <h3 class="sc-header">
                    <strong>百度推送设置</strong>

                </h3>
                <div class="sc-body">
                    <table class="wbs-form-table">
                        <tbody>
                        <tr>
                            <th class="row w8em">接口调用地址</th>
                            <td>
                                <input id="wb_bdsl_bdkey" class="wbs-input" data-max="180" v-model="cnf.token" name="<?php echo $setting_field;?>[token]"  type="text" placeholder="">
                                <span v-if="false" class="ml" id="J_checkToken"><a href="javascript:void(0);" onclick="return checkBaiduToken(this,2)">[验证密钥]</a> <span class="hl ml" id="check_baidu_resp"></span></span>

                                <div class="description mt">温馨提示：填写普通收录或者快速收录任意一个API提交推送接口调用地址即可。示例http://data.zz.baidu.com/urls?site=https://www.yourdomain.com/&token=***&type=daily</div>
                            </td>
                        </tr>
                        <tr>
                            <th class="row">推送方式</th>
                            <td class="info">
                                <label class="when-m-block"><input class="wb-switch" type="checkbox" v-model="cnf.pc_active" name="<?php echo $setting_field;?>[pc_active]" > <span>普通收录主动推送</span></label>
                                <label class="ml when-m-block"><input class="wb-switch" type="checkbox" true-value="1" v-model="cnf.bdauto" name="<?php echo $setting_field;?>[bdauto]" value="1" id="seo_bdauto"> <span>普通收录自动推送</span></label>
                                <label class="ml when-m-block"><input class="wb-switch" type="checkbox" @click="pro_click($event)" v-model="cnf.daily_active" name="<?php echo $setting_field;?>[daily_active]" > <span>快速收录推送 <i class="tag-pro" @click="aboutPro">Pro</i></span></label>

                                <div class="mt when-m-block">
                                    <label><input class="wb-switch" type="checkbox" checked name="sitemap_push" disabled value="1" id="seo_bdauto"> <span>Sitemap地图推送</span></label>
                                    <span class="ib ml" id="sitemap-check">检测中......</span>
                                    <!--检测是否开启sitemap 若未有：-->
                                    <span class="description ib ml" id="sitemap-404" style="display: none;">未检测到有效站点Sitemap，请依据下方说明安装插件生成站点sitemap</span>
                                    <!--若有：-->
                                    <span class="description ib ml" id="sitemap-200" style="display: none;"><a class="sitemap" href="###" target="_blank"></a></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>温馨提示</th>
                            <td>
                                <dl class="description">
                                    <?php if(isset($op_sets['bdauto']) && $op_sets['bdauto']): ?>
                                        <dd>已启用百度链接自动推送，切莫重复添加推送工具代码。</dd>
                                    <?php else: ?>
                                        <dd> 自动推送开关开启后，主题会添加自动推送工具代码，提高百度搜索引擎对站点新增网页发现速度。</dd>
                                    <?php endif; ?>
                                    <dd>快速收录推送需要先在百度搜索资源平台获得快速收录配额。</dd>
                                    <dd>Sitemap生成 - 下载并启动Sitemap生成插件，建议安装<a lass="link" target="_blank" data-wba-campaign="Setting-Des-txt" href="https://www.wbolt.com/plugins/sst" title="SEO插件">Smart SEO Tool</a>或者Google XML Sitemaps。<a lass="link" target="_blank" data-wba-campaign="Setting-Des-txt" href="https://www.wbolt.com/how-to-set-google-xml-sitemaps.html">查看教程</a></dd>
                                    <dd>Sitemap提交 - 访问并登陆<a class="link" target="_blank" href="https://ziyuan.baidu.com/">百度搜索资源平台</a>，找到链接提交-自动提交-sitemap，填入非索引型sitemap地址，最后提交。<a class="link" target="_blank" data-wba-campaign="Setting-Des-txt" href="https://www.wbolt.com/submit-sitemap-url-to-baidu.html">查看教程</a></dd>
                                    <dd>sitemap检测仅支持主流sitemap插件，如无法检测，请手动复制非索引型sitemap地址到百度搜索资源平台提交。</dd>
                                </dl>

                            </td>
                        </tr>




                        </tbody>
                    </table>
                </div>
            </div>

            <div class="sc-wp" v-show="cur_section == 'setting'" id="setting404url">
                <h3 class="sc-header">
                    <strong>死链检测设置</strong>
                    <input class="wb-switch" type="checkbox" v-model="cnf.check_404" name="<?php echo $setting_field;?>[check_404]" >
                </h3>
                <div class="sc-body">
                    <table class="wbs-form-table">
                        <tbody>
                        <tr>
                            <th class="row w8em">温馨提示</th>
                            <td>
							    <div class="description mt">*死链检测依赖Spider Analyser-蜘蛛分析插件。
                                    <?php
                                    if(!$spider_install){?>
                                    <div class="wb-hl wb-hl-inline">
                                        <svg class="wb-icon wbsico-notice"><use xlink:href="#wbsico-notice"></use></svg>
                                        <span>未检测到Spider Analyser安装，去</span> <a class="link" href="<?php echo admin_url('plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term');?>">安装</a>
                                    </div>

                                    <?php }else if(!$spider_active){?>
                                    <div class="wb-hl wb-hl-inline">
                                        <svg class="wb-icon wbsico-notice"><use xlink:href="#wbsico-notice"></use></svg>
                                        <span>未检测到Spider Analyser启用，去</span> <a class="link" href="<?php echo admin_url('plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term');?>">启用</a>
                                    </div>

                                    <?php } ?>
                                </div>
                                <div class="description mt">*对死链及时处理有利于网站权重，建议开启该功能。</div>

                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="sc-wp" v-show="cur_section=='abcdefg'" id="settingDailyBD">
                <h3 class="sc-header">
                    <strong>快速收录推送 <i class="tag-pro" @click="aboutPro">Pro</i></strong>

                </h3>
                <div class="sc-body">
                    <table class="wbs-form-table">
                        <tbody>
                        <tr>
                            <th class="row w8em">接口调用地址</th>
                            <td>
                                <input  class="wbs-input" data-max="180" :disabled="!is_pro" v-model="cnf.daily_api" name="<?php echo $setting_field;?>[daily_api]"  type="text" placeholder="">
                                <div class="description mt">温馨提示：请填写完整API接口URL地址；接口调用地址可通过访问“ <a class="link" target="_blank" href="https://ziyuan.baidu.com/">百度搜索资源平台</a>-快速收录-API提交”获取，示例http://data.zz.baidu.com/urls?site=https://www.yourdomain.com/&token=***&type=daily</div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="sc-wp" v-show="cur_section == 'setting'" id="settingCollectionBD">
                <h3 class="sc-header">
                    <strong>百度收录状态查询 <i class="tag-pro" @click="aboutPro">Pro</i></strong>
                    <input class="wb-switch" type="checkbox" @click="pro_click($event)" v-model="cnf.in_bd_active" name="<?php echo $setting_field;?>[in_bd_active]">
                </h3>
                <div class="sc-body setting-box">
                    <table class="wbs-form-table">
                        <tbody>
                        <tr>
                            <th class="row w8em"></th>
                            <td>
                                <dl class="description" >
                                    <dt>温馨提示：</dt>
                                    <dd>开启该功能后，采用插件API方式查询文章百度收录状态。</dd>
                                    <dd>在已发布文章列表快速编辑选项增加百度收录状态、百度收录查询入口及未收录链接提交选项。</dd>
                                    <dd><b>文章百度收录状态仅供参考，实际收录情况以百度搜索为准</b>。</dd>
									<dd>如关闭此开关，文章收录清单不再新增数据。</dd>
                                </dl>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="sc-wp" v-show="cur_section == 'setting'" id="settingBing">
                <h3 class="sc-header">
                    <strong>Bing推送设置</strong>
                </h3>
                <div class="sc-body setting-box">
                    <table class="wbs-form-table">
                        <tbody>
                        <tr>
                            <th class="row w8em">API密钥</th>
                            <td>
                                <input  class="wbs-input" data-max="180" v-model="cnf.bing_key" name="<?php echo $setting_field;?>[bing_key]"  type="text" placeholder="">
                                <div class="description mt">温馨提示：必填项，您可以通过访问Bing网站管理员工具生成API密钥，<a class="link" target="_blank" data-wba-campaign="Setting-Des-txt" href="https://www.wbolt.com/generate-bing-api-key.html">查看教程</a></div>
                            </td>
                        </tr>
                        <tr>
                            <th class="row w8em">推送方式</th>
                            <td class="info">
                                <label><input class="wb-switch" type="checkbox" @click="pro_click($event)" v-model="cnf.bing_auto" name="<?php echo $setting_field;?>[bing_auto]"><span>自动推送 <i class="tag-pro" @click="aboutPro">Pro</i></span></label>
                                <label class="ml"><input class="wb-switch" type="checkbox" v-model="cnf.bing_manual" name="<?php echo $setting_field;?>[bing_manual]"><span>手动推送</span></label>
								<dl class="description mt">
                                    <dt>温馨提示：</dt>
                                    <dd>无论使用Bing自动推送还是手动推送，都务必先配置API密钥，否则无法正常推送。</dd>
                                    <dd>如启用了Bing自动推送，又无需使用手动推送，可以考虑把手动推送关闭。</dd>
                                    <dd>目前Bing自动推送包含了新建、更新和删除等类型推送，因此同一URL多次推送是正常现象。</dd>
                                </dl>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- setting E-->


            <div class="sc-wp" v-show="cur_section == 'about_pro'">
                <div class="table-comparison">
                    <ul class="table-hd">
                        <li class="hd"><i class="pfc" title="功能对比"></i></li>
                        <li class="free">
                            <strong>免费版</strong>
                            <i class="gf-free"></i>
                        </li>
                        <li class="pro">
                            <strong>专业版</strong>
                            <i class="gf-pro"></i>
                        </li>
                    </ul>
                    <dl class="tr">
                        <dt>百度普通收录自动推送</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>百度普通收录API推送</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>Sitemap检测</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>推送类型设置</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>整站收录统计</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>百度普通收录API推送统计</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>百度普通收录自动推送统计</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>404死链检测</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>死链提交清单</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>百度主动推送日志</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
					<dl class="tr">
                        <dt>Bing推送统计</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
					<dl class="tr">
                        <dt>Bing手动推送</dt>
                        <dd class="free"><i class="wbicon-tick"></i></dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>					
                    <dl class="tr">
                        <dt>快速收录推送</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl> 					
                    <dl class="tr">
                        <dt>快速收录推送统计</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>快速收录推送日志</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>插件执行日志</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>文章收录清单</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>文章蜘蛛爬取历史</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>百度收录查询API</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>Bing自动推送</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>					
                    <dl class="tr">
                        <dt>文章收录状态筛选</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>
                    <dl class="tr">
                        <dt>文章百度收录检测</dt>
                        <dd class="free">无</dd>
                        <dd class="pro"><i class="wbicon-tick"></i></dd>
                    </dl>					
                    <dl class="tr tr-btns">
                        <dt></dt>
                        <dd class="free"></dd>
                        <dd class="pro">
                            <a class="wbs-btn wbs-btn-primary" v-if="!is_pro" @click="activePro">立即激活</a>
                            <span class="wbs-btn wbs-btn-outlined" v-if="is_pro">已激活</span>
                        </dd>
                    </dl>
                </div>
            </div>


            <more-wb-info v-bind:utm-source="pd_code"></more-wb-info>

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

<template id="tab-bing-push">
    <div>
    <!-- bing S -->
    <div class="sc-wp" v-if="section=='bing'">
        <h3 class="sc-header ov-header">
            <strong>概况</strong>
        </h3>
        <div class="sc-body">
            <div class="data-overview">
                <div class="ao-it" v-for="item in overview">
                    <dl>
                        <dt class="it-name">{{item.name}}</dt>
                        <dd class="it-value">{{item.value}}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="sc-body overview-charts">
            <h3 class="sc-header">
                <strong>统计图表</strong>
            </h3>
            <div class="tab-nav">
                <a class="tn-item" :class="{current: day==7}" @click="overview_data(7)">近7天</a>
                <a class="tn-item" :class="{current: day==30}" @click="overview_data(30)">近30天</a>
            </div>
            <v-chart class="charts-box" :options="chart_opt"/>
        </div>

    </div>


    <div class="sc-wp" v-if="section == 'bing_auto' || (is_mobile && section=='bing')">
        <h3 class="sc-header">
            <strong>Bing自动推送日志</strong><i class="tag-pro">Pro</i>
        </h3>
        <div class="log-box">
            <table class="wbs-table">
                <thead>
                <tr>
                    <th>日期</th>
                    <th>链接</th>
                    <th>推送状态</th>
                </tr>
                </thead>
                <body>
                <tr v-for="item in push_log">
                    <td>{{item.date}}</td>
                    <td><div class="url">{{item.url}}</div></td>
                    <td v-html='item.s_push==1 ? "<span class=\"suc\">成功</span>": "失败"'></td>
                </tr>
                </body>
            </table>
            <div class="empty-tips-bar" v-show="!push_log.length">
                <span v-if="loading_data == -1">- 最近7天无推送数据，建议保持每日更新内容 -</span>
            </div>

            <div class="btns-bar" v-show="push_log.length>0 && load_more">
                <a class="more-btn" @click="loadLogRecord('bing_auto',10)">查看更多</a>
            </div>
            <div v-if="is_pro && !opt.bing_auto" class="mt">   &nbsp;</div>

            <div v-if="is_pro && !opt.bing_auto" class="getpro-mask">
                <div class="mask-inner">
                    <a class="wbs-btn-primary j-get-pro" @click="switchMenu('setting')">启用收录查询</a>
                    <p class="tips">*注意：当前功能依赖百度收录查询。当前该功能处于关闭状态，需启用后才可使用文章收录清单功能。</p>
                </div>
            </div>

        </div>
        <dl class="description mt">
            <dt>温馨提示：</dt>
            <dd>推送失败，请检测Bing推送API密钥是否正确及当前站点域名是否在Bing站长平台验证绑定。</dd>
            <dd>Bing自动推送数据类型包括新发布的、更新的及删除的URL数据。</dd>
            <dd>Bing推送URL配额每天为10000个，实质为推送次数，包含自动和手动推送的次数。</dd>
            <dd>Bing站长平台每天在格林尼治标准时间午夜重置配额，这可能与网站本地的时间不一致。</dd>
        </dl>
    </div>

    <div class="sc-wp" v-if="section == 'bing_manual' || (is_mobile && section=='bing')">
        <h3 class="sc-header">
            <strong>Bing手动推送日志</strong>
        </h3>
        <div class="log-box">
            <table class="wbs-table">
                <thead>
                <tr>
                    <th>日期</th>
                    <th>链接</th>
                    <th>推送状态</th>
                </tr>
                </thead>
                <body>
                <tr v-for="item in push_log_manual">
                    <td>{{item.date}}</td>
                    <td><div class="url">{{item.url}}</div></td>
                    <td v-html='item.s_push==1 ? "<span class=\"suc\">成功</span>": "失败"'></td>
                </tr>
                </body>
            </table>
            <div class="empty-tips-bar" v-show="!push_log_manual.length">
                <span v-if="loading_data == -1">- 最近7天无推送数据，建议保持每日更新内容 -</span>
            </div>
            <div class="btns-bar" v-show="push_log_manual.length>0 && load_more_manual">
                <a class="more-btn" @click="loadLogRecord('bing_manual',10)">查看更多</a>
            </div>

            <div class="mt"><button class="button button-cancel" type="button" @click="submit_urls"> 手动提交链接 </button></div>



            <div v-if="!opt.bing_manual" class="getpro-mask">
                <div class="mask-inner">
                    <a class="wbs-btn-primary j-get-pro" @click="switchMenu('setting')">启用Bing手动推送</a>
                    <p class="tips">*注意：当前功能依赖Bing推送设置。当前该功能处于关闭状态，需启用后才可使用该功能。</p>
                </div>
            </div>
        </div>
        <dl class="description mt">
            <dt>温馨提示：</dt>
            <dd>推送失败，请检测Bing推送API密钥是否正确及当前站点域名是否在Bing站长平台验证绑定。</dd>
            <dd>可以通过上方<b>手动提交链接</b>按钮批量手动推送URL数据至Bing。或者在Bing站长平台也可以批量手动提交URL，<a class="link" target="_blank" data-wba-campaign="Setting-Des-txt" href="https://www.wbolt.com/how-to-submit-bing-urls-manually.html">查看教程</a>。</dd>
            <dd>如URL内容发生变化，可通过手动推送将最新的内容推送给Bing</dd>
            <dd>Bing推送URL配额每天为10000个，实质为推送次数，包含自动和手动推送的次数。</dd>
            <dd>Bing站长平台每天在格林尼治标准时间午夜重置配额，这可能与网站本地的时间不一致。</dd>
        </dl>
    </div>
    <!-- bing E-->
    </div>
</template>


<div style=" display:none;">
    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <symbol id="sico-update" viewBox="0 0 12 15">
                <path fill-rule="evenodd" d="M10 9a4 4 0 11-4-4v3l5-4-5-4v3a6 6 0 106 6h-2z"/>
            </symbol>
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
            <symbol id="wbsico-time" viewBox="0 0 18 18">
                <path d="M9 15.75c-3.71 0-6.75-3.04-6.75-6.75S5.29 2.25 9 2.25 15.75 5.29 15.75 9 12.71 15.75 9 15.75zM9 0C4.05 0 0 4.05 0 9s4.05 9 9 9 9-4.05 9-9-4.05-9-9-9z"/>
                <path d="M10.24 4.5h-1.8V9h4.5V7.2h-2.7z"/>
            </symbol>
            <symbol id="wbsico-views" viewBox="0 0 26 18">
                <path d="M13.1 0C7.15.02 2.08 3.7.02 8.9L0 9a14.1 14.1 0 0 0 13.09 9c5.93-.02 11-3.7 13.06-8.9l.03-.1A14.1 14.1 0 0 0 13.1 0zm0 15a6 6 0 0 1-5.97-6v-.03c0-3.3 2.67-5.97 5.96-5.98a6 6 0 0 1 5.96 6v.04c0 3.3-2.67 5.97-5.96 5.98zm0-9.6a3.6 3.6 0 1 0 0 7.2 3.6 3.6 0 0 0 0-7.2h-.01z"/>
            </symbol>
            <symbol id="wbsico-comment" viewBox="0 0 18 18">
                <path d="M9 0C4.05 0 0 3.49 0 7.88s4.05 7.87 9 7.87c.45 0 .9 0 1.24-.11L15.75 18v-4.95A7.32 7.32 0 0 0 18 7.88C18 3.48 13.95 0 9 0z"/>
            </symbol>
            <symbol id="sico-data" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14 7h-2.5L10 9.2l-4-6L3.5 7H2V2h12v5zm0 7H2V9h2.5L6 6.8l4 6L12.5 9H14v5zm1-14H1C.4 0 0 .4 0 1v14c0 .6.4 1 1 1h14c.6 0 1-.4 1-1V1c0-.6-.4-1-1-1z"/>
            </symbol>
            <symbol id="sico-log" viewBox="0 0 14 16">
                <path fill-rule="evenodd" d="M13 0H1C.4 0 0 .4 0 1v14c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V1c0-.6-.4-1-1-1zM3 11h4v2H3v-2zm0-4h8v2H3V7zm0-4h8v2H3V3z"/>
            </symbol>
            <symbol id="sico-setting" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14 6h-4V4h4v2zm0 6h-2.3c-.3.6-1 1-1.7 1a2 2 0 01-2-2c0-1.1.9-2 2-2a2 2 0 011.7 1H14v2zM6 7a2 2 0 01-1.7-1H2V4h2.3c.3-.6 1-1 1.7-1a2 2 0 012 2 2 2 0 01-2 2zm0 5H2v-2h4v2zm8-12H2a2 2 0 00-2 2v12c0 1.1.9 2 2 2h12a2 2 0 002-2V2a2 2 0 00-2-2z"/>
            </symbol>
            <symbol id="sico-bing" viewBox="0 0 1024 1024">
                <path d="M99.6 0v863.3l232.5 158L924.4 668V418.8L408 260.8 519 488.2l147.4 69.4L121 850.5l217.4-206.9-7.6-582z"/>
            </symbol>
            <symbol id="sico-pro" viewBox="0 0 32 16">
                <g fill="none" fill-rule="evenodd">
                    <rect width="32" height="16" fill="#06C" rx="3"/>
                    <path fill="#FFF" fill-rule="nonzero" d="M8.2 12V8.8h1.1c1 0 1.8-.2 2.4-.8.7-.6 1-1.3 1-2.2 0-.8-.3-1.5-.8-2-.6-.5-1.3-.7-2.3-.7H7v9h1.2zm1-4.3h-1V4h1.2c1.3 0 2 .6 2 1.8 0 .6-.1 1-.5 1.4-.4.3-1 .5-1.6.5zm6.1 4.4V8.8c0-.7.2-1.2.5-1.6.3-.5.6-.7 1-.7l.9.2V5.6l-.6-.1c-.8 0-1.4.5-1.7 1.4V5.6h-1.2v6.5h1.1zm6 .1c1 0 1.8-.3 2.4-1 .6-.5 1-1.4 1-2.4s-.4-1.9-1-2.5a3 3 0 00-2.2-.9c-1 0-1.8.4-2.4 1-.6.6-1 1.4-1 2.5 0 1 .4 1.8 1 2.4a3 3 0 002.3 1zm.1-1a2 2 0 01-1.5-.6c-.4-.4-.6-1-.6-1.7 0-.8.2-1.4.6-1.8.4-.5.9-.7 1.5-.7.7 0 1.2.2 1.5.6.4.4.5 1 .5 1.8s-.1 1.4-.5 1.8c-.3.5-.8.7-1.5.7z"/>
                </g>
            </symbol>
            <symbol id="wbsico-notice" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 16A8 8 0 108 0a8 8 0 000 16zM7.2 4h1.6v4.8H7.2V4zm1.6 6.4H7.2V12h1.6v-1.6z" clip-rule="evenodd"/>
            </symbol>
        </defs>
    </svg>
</div>

<div id="not_found_spider" data-status="<?php echo (!$spider_install || !$spider_active)?1:0;?>" style="display: none">
    <?php include BSL_PATH.'/tpl/spider_test.php';?>
</div>