<?php

if(!defined('WP_SPIDER_TRACE_PATH')){
    exit('Forbid');
}
?>
<script type="text/javascript" src="<?php echo VVIP_PLUGIN_URL ;?>/js/calendar/wdatepicker.js"></script>

<div class="wrap">
    <h2>爬虫分析</h2>



    <form name="from1" action="<?php echo $cur_page_url;?>" method="get" autocomplete="off">
        <input type="hidden" name="page" value="<?php echo esc_html($_GET['page']);?>"/>

        <div class="tablenav">

            <div class="alignleft actions">
                <select name="spider">
                    <option value="" selected="selected">全部</option>
                    <?php
                    if($spider_list)foreach($spider_list as $spider){
                        echo '<option value="'.$spider.'"'.($spider==$get['spider']?' selected':'').'>'.$spider.'</option>';
                    }
                    ?>
                </select>
                <label for="fromdate">统计时间</label>
                <input type="text" name="fromdate" value="<?php echo isset($get['fromdate'])?$get['fromdate']:'';?>"  size="12" onClick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'todate\')}'})" id="fromdate">
                <label for="todate">~</label>
                <input type="text" name="todate" value="<?php echo isset($get['todate'])?$get['todate']:'';?>" size="12" onClick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'fromdate\')}'})" id="todate">

                <input value="筛选" name="search" id="search" class="button-secondary action" type="submit"/>
            </div>
            <br class="clear">
        </div>
    </form>


    <?php if($get['spider']){?>

    <h3>爬虫时段占比</h3>

        <form action="" method="post">

            <table class="widefat fixed" cellspacing="0">
                <thead>
                <tr>
                    <th scope="col" class="manage-column column-name" width="5%">时段</th>
                    <th scope="col" class="manage-column column-name" width="15%">数量</th>
                    <th scope="col" class="manage-column column-name" width="15%">占比</th>
                </tr>
                </thead>

                <tbody>
                <?php

                if($visit_sum && is_array($visit_sum))foreach($visit_sum as $k=>$v) {
                    ?>
                    <tr valign="middle">
                        <td class="column-name"><?php echo $v->h; ?></td>
                        <td class="column-name"><?php echo $v->num; ?></td>
                        <td class="column-name"><?php echo round($v->num/$sum_visit * 100,2);?>%</td>

                    </tr>
                    <?php

                } else { ?>
                    <tr>
                        <td colspan="3">暂无记录</td>
                    </tr>
                <?php } ?>
                </tbody>


            </table>
        </form>



    <?php }else{?>
    <h3>爬虫访问占比</h3>

    <form action="" method="post">

        <table class="widefat fixed" cellspacing="0">
            <thead>
            <tr>
                <th scope="col" class="manage-column column-name" width="5%">序号</th>
                <th scope="col" class="manage-column column-name" width="30%">爬虫</th>
                <th scope="col" class="manage-column column-name" width="15%">数量</th>
                <th scope="col" class="manage-column column-name" width="15%">占比</th>
            </tr>
            </thead>

            <tbody>
            <?php

                if($visit_sum && is_array($visit_sum))foreach($visit_sum as $k=>$v) {
                    ?>
                    <tr valign="middle">
                        <td class="column-name"><?php echo $k+1; ?></td>
                        <td class="column-name"><?php echo $v->spider;?></td>
                        <td class="column-name"><?php echo $v->num; ?></td>
                        <td class="column-name"><?php echo round($v->num/$sum_visit * 100,2);?>%</td>

                    </tr>
                    <?php

            } else { ?>
                <tr>
                    <td colspan="4">暂无记录</td>
                </tr>
            <?php } ?>
            </tbody>


        </table>



    </form>




    <?php } ?>
    <h3>URLTOP 50</h3>

    <table class="widefat fixed" cellspacing="0">
        <thead>
        <tr>
            <th scope="col" class="manage-column column-name" width="5%">序号</th>
            <th scope="col" class="manage-column column-name" width="30%">URL</th>
            <th scope="col" class="manage-column column-name" width="15%">数量</th>
            <th scope="col" class="manage-column column-name" width="15%">占比</th>
        </tr>
        </thead>

        <tbody>
        <?php

        if($top_url_list)foreach($top_url_list as $k=>$v) {
            ?>
            <tr valign="middle">
                <td class="column-name"><?php echo $k+1; ?></td>
                <td class="column-name"><?php echo $v->url;?></td>
                <td class="column-name"><?php echo $v->num; ?></td>
                <td class="column-name"><?php echo round($v->num/$sum_visit * 100,2);?>%</td>

            </tr>
            <?php

        } else { ?>
            <tr>
                <td colspan="4">暂无记录</td>
            </tr>
        <?php } ?>
        </tbody>


    </table>

</div>
