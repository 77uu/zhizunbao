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
                <strong>蜘蛛日志</strong>
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
                        <th>访问时间</th>
                        <th>状态码</th>
                        <th>访问URL</th>
                        <th>蜘蛛IP</th>
                        <th>蜘蛛名称</th>
                    </tr>
                    </thead>
                    <body>
                    <tr v-for="r in spider_log">
                        <td>
                            <div data-label="访问时间">{{r.visit_date}}</div>
                        </td>
                        <td>
                            <div data-label="状态码">{{r.code}}</div>
                        </td>
                        <td>
                            <div class="url" data-label="访问URL">{{r.url}}</div>
                        </td>
                        <td>
                            <div data-label="蜘蛛IP">{{r.visit_ip}}</div>
                        </td>
                        <td>
                            <div data-label="蜘蛛名称">{{r.spider}}</div>
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