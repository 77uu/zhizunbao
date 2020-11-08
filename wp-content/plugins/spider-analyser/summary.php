<?php

if(!defined('WP_SPIDER_ANALYSER_PATH')){
    exit('Forbid');
}
?>

<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/wbs_admin.tpl.php'; ?>
<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/component.tpl.php'; ?>

<div class="wrap wbs-wrap wbps-wrap v-wp" id="data-chart-wrap" data-wba-source="<?php echo $pd_code; ?>" v-cloak>
    <div id="version_tips" v-if="new_ver">
        <div class="update-message notice inline notice-warning notice-alt">

            <p>当前<?php echo $pd_title;?>有新版本可用. <a href="<?php echo $pd_index_url; ?>" data-wba-campaign="notice-bar#J_updateRecordsSection" target="_blank">查看版本<span class="ver">{{new_ver}}</span> 详情</a>
                或 <a href="<?php echo admin_url('/plugins.php?plugin_status=upgrade');?>" class="update-link" aria-label="现在更新<?php echo $pd_title;?>">现在更新</a>.
            </p>

        </div>
    </div>
	<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/wbs_header.tpl.php'; ?>

    <div class="wbs-main">
        <div class="wbs-content wbsc-spa-summary">
            <div class="sc-wp">
                <h3 class="sc-header"><strong>今日蜘蛛</strong></h3>
                <div class="overview-box">
                    <table class="wbs-table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>蜘蛛数</th>
                            <th>爬取URLs数</th>
                            <th>爬取URLs均值</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>今日</th>
                            <td>{{summary[0].spider}}</td>
                            <td>{{summary[0].url}}</td>
                            <td>{{summary[0].avg_url}}</td>
                        </tr>
                        <tr>
                            <th>昨日</th>
                            <td>{{summary[1].spider}}</td>
                            <td>{{summary[1].url}}</td>
                            <td>{{summary[1].avg_url}}</td>
                        </tr>
                        <tr>
                            <th>30天平均</th>
                            <td>{{summary[2].spider}}</td>
                            <td>{{summary[2].url}}</td>
                            <td>{{summary[2].avg_url}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-nav style-c">
                <a class="tn-item" :class="{current:tab_day==0}" @click="switch_day(0)">今天</a>
                <a class="tn-item" :class="{current:tab_day==1}" @click="switch_day(1)">昨天</a>
                <a class="tn-item" :class="{current:tab_day==7}" @click="switch_day(7)">最近7天</a>
                <a class="tn-item" :class="{current:tab_day==30}" @click="switch_day(30)">最近30天</a>
            </div>

            <div class="sc-wp">
                <h3 class="sc-header">
                    <strong>趋势图</strong>
                </h3>

                <div class="tab-nav">
                    <a class="tn-item" :class="{current:data_type==1}" @click="set_type(1)">蜘蛛数</a>
                    <a class="tn-item" :class="{current:data_type==2}" @click="set_type(2)">爬取URLs数</a>
                    <a class="tn-item" :class="{current:data_type==3}" @click="set_type(3)">爬取URLs均值</a>
                </div>
                <div class="chart">
                    <div class="charts-box" v-if="chart_loading">
                        <div class="wbui-loading"><div class="wbui-cont"><i></i><i class="wbui-load"></i><i></i></div></div>
                    </div>
                    <v-chart v-show="!chart_loading" class="charts-box" :options="chart_conf" :autoresize="true" />
                </div>
            </div>


            <div class="sc-wp">
                <h3 class="sc-header with-flex">
                    <strong class="primary">Top10搜索引擎蜘蛛</strong>

                    <span>
                        <a href="<?php echo admin_url('admin.php?page=wp_spider_analyser_list');?>">
                            <svg class="wb-icon sico-readmore"><use xlink:href="#sico-readmore"></use></svg>
                        </a>
                    </span>
                </h3>
                <div class="log-box-b">
                    <table class="wbs-table">
                        <thead>
                        <tr>
                            <th width="35%">蜘蛛名称</th>
                            <th width="35%">爬取URLs数</th>
                            <th>占比</th>
                        </tr>
                        </thead>
                        <body v-show="!spider_loading">
                        <tr v-for="r in top_spider">
                            <td>
                                <div>{{r.spider}}</div>
                            </td>
                            <td>
                                <div>{{r.num}}</div>
                            </td>
                            <td>
                                <div>{{r.rate}}%</div>
                            </td>
                        </tr>
                        </body>
                        <tbody v-if="spider_loading">
                        <tr>
                            <td></td>
                            <td><div class="wbui-loading"><div class="wbui-cont"><i></i><i class="wbui-load"></i><i></i></div></div></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>

                    <div v-if="!spider_loading && !top_spider.length" class="empty-tips-bar">
                        -- 暂无数据 --
                    </div>
                </div>
            </div>

            <div class="sc-wp">
                <h3 class="sc-header">
                    <strong>Top10蜘蛛爬取URL</strong>
                </h3>
                <div class="log-box">
                    <table class="wbs-table">
                        <thead>
                        <tr>
                            <th width="35%">URL</th>
                            <th width="35%">爬取次数</th>
                            <th>占比</th>
                        </tr>
                        </thead>
                        <body v-show="!url_loading">
                        <tr v-for="r in top_url">
                            <td>
                                <div class="url" data-label="URL">{{r.url}}</div>
                            </td>
                            <td>
                                <div data-label="爬取次数">{{r.num}}</div>
                            </td>
                            <td>
                                <div data-label="占比">{{r.rate}}%</div>
                            </td>
                        </tr>
                        </body>
                        <tbody v-if="url_loading">
                        <tr>
                            <td></td>
                            <td><div class="wbui-loading"><div class="wbui-cont"><i></i><i class="wbui-load"></i><i></i></div></div></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>

                    <div v-if="!url_loading && (top_url && !top_url.length)" class="empty-tips-bar">
                        -- 暂无数据 --
                    </div>
                </div>
            </div>

	        <?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/wbs_footer.tpl.php'; ?>
        </div>
    </div>
</div>


