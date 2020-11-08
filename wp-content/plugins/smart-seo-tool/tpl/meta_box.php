<?php
/**
 * This was contained in an addon until version 1.0.0 when it was rolled into
 * core.
 *
 * @package    WBOLT
 * @author     WBOLT
 * @since      1.1.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2019, WBOLT
 */

?>
<template id="wbs_tpl_tags">
    <label class="wb-tags-ctrl">
        <div class="tag-items">
            <div class="tag-item" v-if="taglist.length" v-for="(v,k) in taglist">
                <span class="vam ib" v-html="displayFormat(v)"></span>
                <a class="del" @click="delItem(k)" :data-del-val="v"></a>
            </div>
        </div>
        <input class="wb-tag-input j-skt-input" @keyup="wbTagInput" data-wp-taxonomy="true" v-model="cur_input" type="text" placeholder="输入关键词, 回车键确认。">
    </label>
</template>

<div class="wb-post-sitting-panel v-wp" id="J_WBSSTMetaBox" v-cloak>
    <div class="sc-body mt">
        <table class="wbs-form-table">
            <tbody>
            <tr>
                <th class="row w8em">标题</th>
                <td>
                    <div class="seo-setitem input-with-count">
                        <input name="wb_sst_seo[0]" class="wbs-input j-skt-input" data-max="80" type="text" v-model="title" placeholder="">
                    </div>
                    <p class="description">
                        <span class="desc-count" v-if="title_count>0">已输入 <b class="{'hl':title_count>30}">{{title_count}}</b> 字符</span>
                        不超30个中文字符，建议15-30为宜。
                    </p>
                </td>
            </tr>

            <tr>
                <th>关键词</th>
                <td>
                    <label class="input-with-count mt wb-tags-module">
                        <input name="wb_sst_seo[1]" class="wbs-input" data-max="100" type="hidden" v-model="keywords" placeholder="">
                        <wbs-tags-module v-bind:tags="keywords" @set-tags="keywords = $event"></wbs-tags-module>

                    </label>
                    <p class="description">建议3-5个为宜，切勿进行关键词堆叠。</p>
                </td>
            </tr>

            <tr>
                <th>描述</th>
                <td>
                    <div class="seo-setitem input-with-count mt">
                        <textarea class="wbs-input" data-max="200" rows="5" cols="42" name="wb_sst_seo[2]" v-model="description"></textarea>
                    </div>
                    <p class="description">
                        <span class="desc-count" v-if="desc_count>0">已输入 <b :class="{'hl':desc_count>100}">{{desc_count}}</b> 字符</span>
                    不超100个中文字符，建议50-100字为宜。</p>
                </td>
            </tr>
            <tr>
                <th></th><td>
                    <p class="description">* 若单独设置文章或者独立页面SEO信息，则SEO插件通用规则对此URL无效。</p>
                    <p class="description">* 推荐安装<a class="link" href="<?php echo admin_url('plugin-install.php?s=Wbolt+smart+keywords+tool&tab=search&type=term');?>">热门关键词推荐插件</a>，提升SEO优化效率。</p>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</div>


