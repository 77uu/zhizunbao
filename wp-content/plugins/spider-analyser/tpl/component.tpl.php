<?php
/**
 * 设置通用组件
 */
?>


<?php
/**
 * 推荐产品
 */
?>
<template id="wb-page-num-nav">
    <div v-if="total_page>1" class="wb-navigation pagination pt-l" role="navigation">
        <a class="prev page-numbers" :class="{disabled:page==1}" @click="navPage(pre_page)">上一页</a>
        <a v-for="v in nums" class="page-numbers" :class="{current:cur_page==v}" @click="navPage(v)">{{v}}</a>
        <a class="next page-numbers" :class="{disabled:page==total_page}" @click="navPage(next_page)">下一页</a>
    </div>
</template>
<template id="wbs_tpl_more_products">
    <div class="wbolt-products tabs-box sc-wp">
        <div class="tab-navs">
            <div class="tab-nav-item" v-on:mouseover="curIndex = 0" v-bind:class="{current: curIndex === 0}"><span>主题推荐</span></div>
            <div class="tab-nav-item" v-on:mouseover="curIndex = 1" v-bind:class="{current: curIndex === 1}"><span>插件推荐</span></div>
            <div class="tab-nav-item" v-on:mouseover="curIndex = 2" v-bind:class="{current: curIndex === 2}"><span>WP教程</span></div>
        </div>
        <div class="tab-conts">
            <div class="tab-cont" v-bind:class="{current: curIndex === 0}">
                <ul class="pd-items-b">
                    <li class="pd-item" v-for="item in wbMoreData.themes">
                        <div class="item-inner">
                            <a class="post-thumbnail thumbnail-themes" v-bind:href="withCampaign(item.url)" data-wba-campaign="recommend" target="_blank">
                                <img v-bind:src="item.thumb[0]">
                            </a>
                            <div class="pd-info">
                                <a class="pd-name" v-bind:href="withCampaign(item.url)" data-wba-campaign="recommend" target="_blank"><em v-if="item.status_tag" class="state-tag" v-bind:class="item.status_tag">{{item.status_tag}}</em><b>{{item.post_title}}</b></a>
                                <div class="pd-desc">{{item.excerpt}}</div>
                                <p><a class="btn-sm" :href="withCampaign(item.url)" data-wba-campaign="recommend" target="_blank">查看详情</a></p>                        </div>

                            <div class="item-ft">
                                <span><svg class="wb-icon wbsico-views"><use xlink:href="#wbsico-views"></use></svg> <em>{{item.view_count}}</em></span>
                                <span><svg class="wb-icon wbsico-time"><use xlink:href="#wbsico-time"></use></svg> <em>{{item.post_date | displayDate}}</em></span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tab-cont" v-bind:class="{current: curIndex === 1}">
                <ul class="pd-items-b">
                    <li class="pd-item" v-for="item in wbMoreData.plugins">
                        <div class="item-inner">
                            <a class="post-thumbnail thumbnail-plugins" v-bind:href="withCampaign(item.url)" data-wba-campaign="recommend" target="_blank">
                                <img v-bind:src="item.thumb[0]">
                            </a>
                            <div class="pd-info">
                                <a class="pd-name" v-bind:href="withCampaign(item.url)" data-wba-campaign="recommend" target="_blank"><em v-if="item.status_tag" class="state-tag" v-bind:class="item.status_tag">{{item.status_tag}}</em><b>{{item.post_title}}</b></a>
                                <div class="pd-desc">{{item.excerpt}}</div>
                                <p><a class="btn-sm" :href="withCampaign(item.url)" data-wba-campaign="recommend" target="_blank">查看详情</a></p>                        </div>

                            <div class="item-ft">
                                <span><svg class="wb-icon wbsico-views"><use xlink:href="#wbsico-views"></use></svg> <em>{{item.view_count}}</em></span>
                                <span><svg class="wb-icon wbsico-time"><use xlink:href="#wbsico-time"></use></svg> <em>{{item.post_date | displayDate}}</em></span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tab-cont" v-bind:class="{current: curIndex === 2}">
                <ul class="list-blog">
                    <li class="list-item" v-for="item in wbMoreData.blog">
                        <div class="item-inner">
                            <a class="media-pic" v-bind:href="withCampaign(item.url)" data-wba-campaign="recommend" target="_blank">
                                <img v-bind:src="item.thumb[0]">
                            </a>
                            <div class="media-body">
                                <a class="post-title" v-bind:href="withCampaign(item.url)" data-wba-campaign="recommend" target="_blank">{{item.post_title}}</a>
                                <div class="summary">{{item.excerpt}}</div>
                                <div class="post-metas">
                                <span class="meta-item primary">
                                    <svg class="wb-icon wbsico-time"><use xlink:href="#wbsico-time"></use></svg>
                                    <em>{{item.post_date | displayDate}}</em>
                                </span>
                                    <span class="meta-item">
                                    <svg class="wb-icon wbsico-views"><use xlink:href="#wbsico-views"></use></svg>
                                    <em>{{item.view_count}}</em>
                                </span>
                                    <a class="meta-item" href="withCampaign(item.url)">
                                        <svg class="wb-icon wbsico-comment"><use xlink:href="#wbsico-comment"></use></svg>
                                        <em>{{item.comment_count}}</em>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
