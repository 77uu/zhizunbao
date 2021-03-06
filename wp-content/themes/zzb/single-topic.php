<?php get_header();
$post_categories = get_the_terms( $post->ID, 'group' );?>
<?php get_template_part( 'template-parts/single-top' );?>
<div class="site-content container">
	<div class="row">
		<?php
			if( wpjam_theme_get_setting('sidebar_left') ){
				$post_layout_3 = get_post_meta($post->ID, 'post_layout', true) == '3';
				if( !$post_layout_3 ){
					get_sidebar();
				}
			}
		?>
		<div class="col-lg-9">
			<div class="content-area">
				<main class="site-main">
				<article class="type-post post">
				<div class="term-bar breadcrumbs">
					<div class="term-info">
						<i class="iconfont icon-locationfill"></i> <a href="<?php echo home_url(); ?>">首页</a> <span>»</span> <a href="<?php echo home_url(); ?>/topic">讨论组</a>  <span>»</span> <a href="<?php echo get_category_link($post_categories[0]->term_id);?>" rel="category tag"><?php echo $post_categories[0]->name;?></a>  <span>»</span> <?php the_title(); ?>
					</div>
				</div>
				<header class="entry-header">
				<div class="entry-category">
					<a href="<?php echo get_category_link($post_categories[0]->term_id);?>" rel="category tag"><?php echo $post_categories[0]->name;?></a>
				</div>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="entry-action">
					<div>
						<a class="view" href="<?php the_permalink(); ?>"><i class="iconfont icon-rili"></i><span class="count"><?php the_time('Y-m-d') ?></span></a>
						<?php wpjam_post_like_button(get_the_ID());?>
						<a class="view" href="<?php the_permalink(); ?>"><i class="iconfont icon-icon-test"></i><span class="count"><?php echo wpjam_get_post_views(get_the_ID()); ?></span></a>
						<a class="comment" href="<?php the_permalink(); ?>#comments"><i class="iconfont icon-pinglun"></i><span class="count"><?php echo get_post($post->ID)->comment_count; ?></span></a>
						<?php edit_post_link('[编辑文章]'); ?>
					</div>
				</div>
				<div class="entry-wrapper">
					<div class="entry-content u-clearfix">
					<?php while( have_posts() ): the_post(); ?>
						<?php the_content();?>

						<?php if($images	= get_post_meta(get_the_ID(), 'images', true)){
							echo '<p>';
							
							foreach ($images as $image) {
								echo '<a href="'.$image.'" data-fancybox="images"><img srcset="'.$image.' 2x" src="'.$image.'" /></a>';
							}

							echo '</p>';
						}?>
					<?php endwhile; ?>
					</div>
					<div class="tag-share">
						<div class="post-share" style="float: initial;">
							<div class="post-share-icons" style="display: inline-block;">
								<?php wpjam_post_like_button_2(get_the_ID());?>
								<a rel="nofollow" href="https://service.weibo.com/share/share.php?url=<?php the_permalink(); ?>&amp;type=button&amp;language=zh_cn&amp;title=<?php the_title_attribute(); ?>&amp;pic=<?php echo wpjam_get_post_thumbnail_url($post,array(840,520), $crop=1);?>&amp;searchPic=true" target="_blank"><i class="iconfont icon-weibo"></i></a>
								<a rel="nofollow" href="https://connect.qq.com/widget/shareqq/index.html?url=<?php the_permalink(); ?>&amp;title=<?php the_title_attribute(); ?>&amp;pics=<?php echo wpjam_get_post_thumbnail_url($post,array(840,520), $crop=1);?>&amp;summary=<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 200,"……"); ?>" target="_blank"><i class="iconfont icon-QQ"></i></a>
								<a href="javascript:;" data-module="miPopup" data-selector="#post_qrcode" class="weixin"><i class="iconfont icon-weixin"></i></a>
							</div>
						</div>
					</div>
				</div>
				</article>
				<div class="entry-navigation">
				<?php
					$prev_post = get_previous_post();
					if(!empty($prev_post)):?>					
					<div class="nav previous">
						<img class="lazyload" data-srcset="<?php echo wpjam_get_post_thumbnail_url($prev_post, '690x400'); ?>">
						<span>上一篇</span>
						<h4 class="entry-title"><?php echo $prev_post->post_title;?></h4>
						<a class="u-permalink" href="<?php echo get_permalink($prev_post->ID);?>"></a>
					</div>
					<?php else: ?>
					<div class="nav none">
						<span>没有了，已经是最后一篇了</span>
					</div>
				<?php endif;?>
				<?php
					$next_post = get_next_post();
					if(!empty($next_post)):?>
					<div class="nav next">
						<img class="lazyload" data-srcset="<?php echo wpjam_get_post_thumbnail_url($next_post, '690x400'); ?>">
						<span>下一篇</span>
						<h4 class="entry-title"><?php echo $next_post->post_title;?></h4>
						<a class="u-permalink" href="<?php echo get_permalink($next_post->ID);?>"></a>
					</div>
					<?php else: ?>
					<div class="nav none">
						<span>没有了，已经是最新一篇了</span>
					</div>
				<?php endif;?>
				</div>
				<?php if( wpjam_theme_get_setting('xintheme_author') ) : ?>
				<div class="about-author">
					<div class="author-image">
						<?php echo get_avatar( get_the_author_meta('ID'), '200' );?>	
					</div>
					<div class="author-info">
						<h4 class="author-name">
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php echo get_the_author() ?></a>
						</h4>
						<div class="author-bio">
							<?php if(get_the_author_meta('description')){ echo the_author_meta( 'description' );}else{ echo '我还没有学会写个人说明！'; }?>
						</div>
						<a class="author_link" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>" rel="author"><span class="text">查看作者页面</span></a>
					</div>
				</div>
				<?php endif; ?>

				<div class="related-post rownone">
					<h3 class="section-title"><span>相关推荐</span></h3>
					<?php $related_query	= wpjam_get_related_posts_query(4);
					if($related_query->have_posts()){ ?>
					<?php while( $related_query->have_posts() ) { $related_query->the_post(); ?>
					<article class="post-list">
					<div class="post-wrapper">
						<div class="entry-media fit">
							<div class="placeholder">
								<a href="<?php the_permalink(); ?>">
									<?php echo get_avatar( get_the_author_meta('ID'), '300' );?>
								</a>
							</div>
						</div>
						<div class="entry-wrapper">
							<header class="entry-header">
							<div class="entry-meta">
								<span class="meta-category">
									<a href="<?php echo get_category_link($post_categories[0]->term_id);?>" rel="category tag"><?php echo $post_categories[0]->name;?></a>
								</span>
								<span class="meta-time">
									<?php the_time('Y-m-d') ?>
								</span>
							</div>
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							</header>
							<div class="entry-excerpt u-text-format">
								<p><?php the_excerpt();?></p>
							</div>
						</div>
					</div>
					</article>
					<?php } } else {?> 
						<p>暂无相关帖子推荐!</p>
					<?php } wp_reset_query(); ?>
				</div>

				<?php if( is_user_logged_in() ){?>
					<?php comments_template( '', true ); ?>
				<?php }else{?>
					<div class="must-log-in">
						<p>
							要发表评论，您必须先 <a href="<?php echo home_url(user_trailingslashit('/user/login')); ?>" rel="nofollow"><i class="iconfont icon-weidenglu"></i>登录</a>
						</p>
					</div>
				<?php }?>
				
				</main>
			</div>
		</div>
		<?php
			if( !wpjam_theme_get_setting('sidebar_left') ){
				$post_layout_3 = get_post_meta($post->ID, 'post_layout', true) == '3';
				if( !$post_layout_3 ){
					get_sidebar();
				}
			}
		?>
	</div>
</div>
<?php get_footer();?>