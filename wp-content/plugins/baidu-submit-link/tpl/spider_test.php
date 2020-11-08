<?php
if(!defined('ABSPATH')){
    return;
}

?><?php if(!$spider_install || !$spider_active){?>

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
<?php } ?>