=== Spider Analyser - WordPress搜索引擎蜘蛛分析插件 ===
Contributors: wbolt,mrkwong
Donate link: https://www.wbolt.com/
Tags: Spider Analyser, SEO, Googlebot, MJ12bot, Spider, Baiduspider, SemrushBot, Bytespider, 360Spider
Requires at least: 4.8
Tested up to: 5.5.1
Stable tag: 1.1.2
License: GNU General Public License v2.0 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Spider Analyser是一款用于跟踪WordPress网站各种搜索引擎蜘蛛爬行日志，并进行详细的蜘蛛爬行数据统计、蜘蛛行为分析、蜘蛛爬取分析及伪蜘蛛拦截等。

== Description ==

Spider Analyser是一款用于跟踪WordPress网站各种搜索引擎蜘蛛爬行日志，并进行详细的蜘蛛爬行数据统计、蜘蛛行为分析、蜘蛛爬取分析及伪蜘蛛拦截等。

功能包括：

### 1.蜘蛛概况
支持查看网站日常各大搜索引擎蜘蛛来访的数据；

* **今日蜘蛛**
方便站长快速了解当日、昨日及30天平均的来访蜘蛛数、爬取URL数及平均爬取URL数。

* **趋势图**
支持按今天、昨天、最近7天及最近30天查看蜘蛛数、爬取URLs总量及爬取URLs均值走势折线图，并可查看上一周期数据，以作对比分析。

* **Top10蜘蛛**
支持按今天、昨天、最近7天及最近30天查看Top10蜘蛛的爬取URL数及占比相关数据。

* **Top10蜘蛛爬取URL**
支持按今天、昨天、最近7天及最近30天查看Top10蜘蛛爬取URL的爬取次数及占比，方便站长对热门蜘蛛爬取页面URL进行分析。

### 2.蜘蛛日志
支持按今天、最近7天及最近30天查看蜘蛛日志，包括蜘蛛访问时间、状态码、访问链接、蜘蛛IP及蜘蛛名称等参数。
并且支持按蜘蛛名称、状态码及时间进行筛选日志；以及可通过访问URL、蜘蛛IP搜索蜘蛛日志。

### 3.蜘蛛列表
支持按今天、最近7天及最近30天查看蜘蛛具体信息列表，包括蜘蛛名称、蜘蛛类型、蜘蛛地址、最近来访时间、爬取URLs及占比情况等数据。
并且支持按蜘蛛名称、类型、时间及蜘蛛名称进行筛选查询。

### 4.访问路径
支持按今天、最近7天及最近30天查看蜘蛛访问路径（爬取页面URL）具体信息列表，包括URL、URL类型、爬取次数及占比情况等数据。
并且支持按蜘蛛名称、类型、状态、时间、访问URL及蜘蛛IP进行筛选查询。

Spider Analyser插件非常适合站长作为网站SEO优化的辅助工具，通过数据统计深入了解更大搜索引擎蜘蛛爬取页面URL的行为习惯。WordPress站长可以利用该插件，并结合<a href='https://www.wbolt.com/plugins/sst?utm_source=wp&utm_medium=link&utm_campaign=spider-analyser' rel='friend' title='WordPress网站SEO优化插件'>WordPress网站SEO优化插件</a>、<a href='https://www.wbolt.com/plugins/bsl?utm_source=wp&utm_medium=link&utm_campaign=spider-analyser' rel='friend' title='百度推送插件'>百度推送插件</a>和<a href='https://www.wbolt.com/plugins/skt?utm_source=wp&utm_medium=link&utm_campaign=spider-analyser' rel='friend' title='关键词推荐插件'>关键词推荐插件</a>，对WordPress网站内容的搜索引擎收录及排名优化可以做到事半功倍的效果！

== Installation ==

方式1：在线安装(推荐)
1. 进入WordPress仪表盘，点击'插件-安装插件'，关键词搜索'Spider Analyser'，找搜索结果中找到'Spider Analyser'插件，点击'现在安装'；
2. 安装完毕后，启用 `Spider Analyser` 插件.
3. 通过仪表盘左侧菜单'蜘蛛分析'即可查看蜘蛛概况及蜘蛛日志.

方式2：上传安装

FTP上传安装
1. 解压插件压缩包spider-analyser.zip，将解压获得文件夹上传至wordpress安装目录下的 `/wp-content/plugins/`目录.
2. 访问WordPress仪表盘，进入'插件'-'已安装插件'，在插件列表中找到'Spider Analyser'，点击'启用'.
3. 通过仪表盘左侧菜单'蜘蛛分析'即可查看蜘蛛概况及蜘蛛日志.

仪表盘上传安装
1. 进入WordPress仪表盘，点击'插件-安装插件'；
2. 点击界面左上方的'上传按钮'，选择本地提前下载好的插件压缩包spider-analyser.zip，点击'现在安装'；
3. 安装完毕后，启用 `Spider Analyser` 插件；
4. 通过仪表盘左侧菜单'蜘蛛分析'即可查看蜘蛛概况及蜘蛛日志.


关于本插件，你可以通过阅读<a href='https://www.wbolt.com/spider-analyser-plugin-documentation.html?utm_source=wp&utm_medium=link&utm_campaign=spider-analyser' rel='friend' title='插件教程'>Spider Analyser插件教程</a>学习了解插件安装、设置等详细内容。

== Frequently Asked Questions ==

= 为什么插件统计的蜘蛛日志与服务器日志数据有差异? =
插件仅统计前端页面的蜘蛛访问日志，服务器日志则统计所有数据访问日志。因此，理论上服务器日志蜘蛛访问数据应该大于插件的蜘蛛访问数据。但插件统计的数据已经足以作为搜索引擎蜘蛛分析。
= Spider Analyser插件的蜘蛛数据存放在哪里? =
数据库。由于该数据仅用于网站管理分析时使用，存放在数据库更加实时和准确，主要是占数据库空间，对服务器性能影响可以忽略不计。
= Spider Analyser插件是否会识别伪蜘蛛? =
暂不对伪蜘蛛进行识别，如站长发现可以伪蜘蛛，甚至任意你不希望对网站内容爬取的其他蜘蛛，可以通过Robots.txt进行屏蔽。查看教程《<a href='https://www.wbolt.com/optimize-wordpress-robots-txt.html?utm_source=wp&utm_medium=link&utm_campaign=spider-analyser' rel='friend' title='Robots.txt教程'>如何编写和优化WordPress网站的Robots.txt</a>?》，但不是所有蜘蛛不一定遵循该协议。

== Notes ==

Spider Analyser是一款专门为WordPress开发的<a href='https://www.wbolt.com/plugins/spider-analyser?utm_source=wp&utm_medium=link&utm_campaign=spider-analyser' rel='friend' title='Spider Analyser插件'>搜索引擎蜘蛛分析插件</a>. 闪电博（<a href='https://www.wbolt.com/?utm_source=wp&utm_medium=link&utm_campaign=spider-analyser' rel='friend' title='闪电博官网'>wbolt.com</a>）专注于WordPress主题和插件开发,为中文博客提供更多优质和符合国内需求的主题和插件。此外我们也会分享WordPress相关技巧和教程。

除了Spider Analyser插件外，目前我们还开发了以下WordPress插件：

- [百度搜索推送管理-历史下载安装数80,000+](https://wordpress.org/plugins/baidu-submit-link/)
- [热门关键词推荐插件-最佳关键词布局插件](https://wordpress.org/plugins/smart-keywords-tool/)
- [IMGspider-轻量外链图片采集插件](https://wordpress.org/plugins/imgspider/)
- [Smart SEO Tool-高效便捷的WP搜索引擎优化插件](https://wordpress.org/plugins/smart-seo-tool/)
- [WP资源下载管理-快速打造资源下载博客网站](https://wordpress.org/plugins/download-info-page/)
- [博客社交分享组件-打赏/点赞/微海报/社交分享四合一](https://wordpress.org/plugins/donate-with-qrcode/)
- [HTML代码代码优化工具-一键清洗转载文章多余代码](https://wordpress.org/plugins/imgspider.zip/)
- [WP VK-WordPress知识付费插件](https://wordpress.org/plugins/wp-vk/)

- 更多主题和插件，请访问<a href='https://www.wbolt.com/?utm_source=wp&utm_medium=link&utm_campaign=spider-analyser' rel='friend' title='闪电博官网'>wbolt.com</a>!

如果你在WordPress主题和插件上有更多的需求，也希望您可以向我们提出意见建议，我们将会记录下来并根据实际情况，推出更多符合大家需求的主题和插件。

致谢！

闪电博团队

== Screenshots ==

1. Spider Analyser-今日蜘蛛统计界面截图.
2. Spider Analyser-蜘蛛数据统计趋势图截图.
3. Spider Analyser-Top10蜘蛛统计界面截图.
4. Spider Analyser-Top10蜘蛛爬取URL统计界面截图.
5. Spider Analyser-蜘蛛日志统计界面截图.
6. Spider Analyser-访问路径统计界面截图.

== Changelog ==

= 1.1.2 =
* 新增蜘蛛访问路径数据列表功能；
* 新增访问路径类型数据统计，支持按首页、文章页、独立页、分类页、搜索页、作者页、Feed、Sitemap、API和其他类型归类URL；
* 其他已知问题及bug修复。

= 1.1.1 =
* 新增蜘蛛列表功能，支持查看站点更多蜘蛛相关数据信息；
* 新增更多蜘蛛数据统计，支持300+不同类型蜘蛛数据统计；
* 优化插件移动端界面样式。

= 1.1.0 =
* 新增日志筛选搜索功能；
* 新增版本升级提示功能；
* 修复部分蜘蛛无法统计bug。

= 1.0.3 =
* 优化爬虫日志记录规则，由每小时更新改为实时更新；
* 删除原有的本地日志记录功能，改为直接数据库记录。

= 1.0.2 =
* 修复数据图表纵坐标参考值出现小数的bug；
* 修复统计图表数据取值异常问题；
* 优化数据统计图表当期及上期折线样式（当期实线，上期虚线）。

= 1.0.1 =
* 修复部分网站无数据展示bug；
* 优化插件部分统计数据术语，统一标准；
* 优化移动端展示外观;
* 删除非必要文件。

= 1.0.0 =
* 新增今日蜘蛛数据统计功能；
* 新增蜘蛛数据趋势图功能；
* 新增Top10搜索引擎蜘蛛统计功能；
* 新增Top10蜘蛛爬取URL统计功能；
* 新增蜘蛛日志功能，统计蜘蛛访问时间、状态码、访问链接、蜘蛛IP及蜘蛛名称等数据。