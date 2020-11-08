<?php

if(!defined('WP_SPIDER_ANALYSER_PATH')){
    exit('Forbid');
}

?>
<script>
    var path_type = {'index':'首页','post':'文章页','page':'独立页','category':'分类页','tag':'标签页','search':'搜索页','author':'作者页','feed':'Feed','sitemap':'SiteMap','api':'API','other':'其他'};
</script>
<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/wbs_admin.tpl.php'; ?>
<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/component.tpl.php'; ?>

<div class="wrap wbs-wrap wbps-wrap v-wp" id="wb-spider-path" data-wba-source="<?php echo $pd_code; ?>" v-cloak>
	<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/wbs_header.tpl.php'; ?>



    <div class="wbs-main">
        <div class="wbs-content pt-l">
            <h3 class="sc-header">
                <strong>访问路径</strong>
            </h3>
            <div class="tablenav">

                <div class="alignleft actions">
                    <select v-model="q.spider">
                        <option value="">所有蜘蛛</option>
                        <?php foreach ($spider as $v){
                            if($v){
                                echo '<option value="'.$v.'">'.$v.'</option>';
                            }
                        }?>
                    </select>
                    <select v-model="q.type">
                        <option value="">所有类型</option>
                        <option v-for="(v,k) in path_type" :value="k">{{v}}</option>
                    </select>
                    <select v-model="q.code">
                        <option value="">所有状态码</option>
                        <?php foreach ($code as $v){
                            if($v){
                                echo '<option value="'.$v.'">'.$v.'</option>';
                            }
                        }?>
                    </select>
                    <select v-model="q.day">
                        <option value="-1">所有时间</option>
                        <option value="0">今天</option>
                        <option value="7">近7天</option>
                        <option value="30">近30天</option>
                    </select>


                  <input type="text" v-model="q.url" placeholder="输入访问URL"/>
                  <input type="text" v-model="q.ip" placeholder="输入蜘蛛IP"/>

                    <input value="筛选" @click="search_log" name="search" class="button-secondary action" type="button"/>
                </div>
                <br class="clear">
            </div>


            <div class="mt log-box">
                <table class="wp-list-table wbs-table">
                    <thead>
                    <tr>
                        <th>URL</th>
                        <th>类型</th>
                        <th>爬取次数</th>
                        <th>占比</th>
                    </tr>
                    </thead>
                    <body>
                    <tr v-for="r in spider_log">
                        <td>
                            <div class="url" data-label="URL">{{r.url}}</div>
                        </td>
                        <td>
                            <div data-label="类型">{{r.url_type?path_type[r.url_type]:'unknown'}}</div>
                        </td>
                        <td>
                            <div data-label="爬取次数">{{r.num}}</div>
                        </td>
                        <td>
                            <div data-label="占比">{{r.percent}}%</div>
                        </td>
                    </tr>
                    </body>
                </table>

                <div v-if=" !spider_log.length" class="empty-tips-bar">
                    -- 暂无数据 --
                </div>

                <wb-page-num-nav :num="num" :page="page" :total="total" v-on:nav-page="nav_page($event)"></wb-page-num-nav>
            </div>

			<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/wbs_footer.tpl.php'; ?>
        </div>
    </div>
</div>