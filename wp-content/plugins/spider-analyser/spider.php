<?php

if(!defined('WP_SPIDER_ANALYSER_PATH')){
    exit('Forbid');
}
?>

<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/wbs_admin.tpl.php'; ?>
<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/component.tpl.php'; ?>

<div class="wrap wbs-wrap wbps-wrap v-wp" id="wb-spider-log" data-wba-source="<?php echo $pd_code; ?>" v-cloak>
	<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/wbs_header.tpl.php'; ?>

    <div class="wbs-main">
        <div class="wbs-content pt-l">
            <h3 class="sc-header">
                <strong>蜘蛛列表</strong>
            </h3>
            <div class="tablenav">

                <div class="alignleft actions">

                    <select v-model="q.type">
                        <option value="">所有类型</option>
                        <?php foreach ($types as $v){
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

                  <input type="text" v-model="q.name" placeholder="输入蜘蛛名称"/>

                    <input value="筛选" @click="search_log" name="search" class="button-secondary action" type="button"/>
                </div>
                <br class="clear">
            </div>


            <div class="mt log-box">
                <table class="wp-list-table wbs-table">
                    <thead>
                    <tr>
                        <th>蜘蛛名称</th>
                        <th>类型</th>
                        <th>蜘蛛地址</th>
                        <th>最近来访时间</th>
                        <th>爬取URLs</th>
                        <th>占比</th>
                    </tr>
                    </thead>
                    <body>
                    <tr v-for="r in spider_log">
                        <td>
                            <div data-label="蜘蛛名称">{{r.spider}}</div>
                        </td>
                        <td>
                            <div data-label="类型">{{r.type}}</div>
                        </td>
                        <td>
                            <div class="url" data-label="蜘蛛地址">{{r.url}}</div>
                        </td>
                        <td>
                            <div data-label="最近来访时间">{{r.last_visit}}</div>
                        </td>
                        <td>
                            <div data-label="爬取URLs">{{r.num}}</div>
                        </td>
                        <td>
                            <div data-label="占比">{{r.rate}}%</div>
                        </td>
                    </tr>
                    </body>
                </table>
				
                <div v-if=" !spider_log.length" class="empty-tips-bar">
                    -- 暂无数据 --
                </div>
                <wb-page-num-nav :num="num" :page="page" :total="total" v-on:nav-page="nav_page($event)"></wb-page-num-nav>
            </div>
			<div class="description">*部分不常见蜘蛛尤其是伪蜘蛛，可能类型显示为空。但站长切勿以此为标准判别该蜘蛛是否为伪蜘蛛。</div>

			<?php include  WP_SPIDER_ANALYSER_PATH . '/tpl/wbs_footer.tpl.php'; ?>
        </div>
    </div>
</div>