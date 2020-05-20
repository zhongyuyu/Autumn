<?php get_header(); ?>
<div class="main">
	<div class="container">
		<div class="row">
			<div class="post">
			<?php if ( have_posts()) { while( have_posts() ) { the_post(); ?>
				<div class="detail">
					<div class="banner" style="background:url(<?php echo posts_thumbnail_src(); ?>) center center / cover no-repeat">
						<?php if ( _thememee('breadcrumbs') ){ ?>
							<?php echo breadcrumbs(); ?>
						<?php } ?>
						<div class="title">
							<h1><?php the_title(); ?></h1>
						</div>
						<div class="meta">
							<ul>
								<li><span><?php $category = get_the_category();if ($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';}?></span></li>
								<li><span><?php echo get_the_time('Y-m-d'); ?></span></li>
								<li><span><?php post_views(); ?></span> 热度</li>
								<li><span><?php comments_popup_link( __( '0' ) , __( '1'), __( '%') ); ?></span> 评论</li>
								<li><span><?php if ( get_post_meta( $post->ID, 'likes', true ) ){ echo get_post_meta( $post->ID, 'likes', true ); } else {echo '0';}?></span> 喜欢</li>
							</ul>
						</div>
					</div>
					<div class="content">
						<?php if ( has_excerpt() ) { ?>
							<p class="post-abstract"><span class="abstract-tit">摘要：</span><?php echo get_the_excerpt(); ?></p>
						<?php } ?>
						<?php the_content(); ?>
					</div>
					<?php if ( _thememee('post_tags') ) { ?>
						<?php the_tags('<div class="tags"><i class="iconfont icon-tag"></i><span>#', '</span><span>#', '</span></div>'); ?>
					<?php } ?>
					<div class="action">
						<?php if ( _thememee('post_likes') ) { ?>
						<div class="likes">
							<a class="like<?php if (isset($_COOKIE['likes_'.$post->ID])) { echo ' active'; }; ?>" href="javascript:void(0)" data-action="like" data-id="<?php the_ID(); ?>">
								<i class="iconfont icon-like"></i><span><?php if ( get_post_meta( $post->ID, 'likes', true) ){ echo get_post_meta( $post->ID, 'likes', true ); } else { echo '0'; }?></span>
							</a>
						</div>
						<?php } ?>
						<?php echo cc_declare(); ?>
						<?php if ( _thememee('post_share') ) { ?>
						<div class="share">
							<?php if ( !wp_is_mobile() ) { ?>
							<a class="weibo tooltips-left" data-share="weibo" data-title="分享到微博"><i class="iconfont icon-weibo"></i></a>
							<a class="wechat tooltips-left" href="javascript:void(0)" data-share="wechat" data-title="分享到微信"><i class="iconfont icon-wechat"></i></a>
							<a class="qq tooltips-left" data-share="qq" data-title="分享到 QQ"><i class="iconfont icon-qq"></i></a>
							<a class="facebook tooltips-left" data-share="facebook" data-title="分享到 Facebook"><i class="iconfont icon-facebook"></i></a>
							<a class="twitter tooltips-left" data-share="twitter" data-title="分享到 Twitter"><i class="iconfont icon-twitter"></i></a>
							<?php } else { ?>
							<a class="weibo" data-share="weibo"><i class="iconfont icon-weibo"></i></a>
							<a class="wechat" href="javascript:void(0)" data-share="wechat"><i class="iconfont icon-wechat"></i></a>
							<a class="qq" data-share="qq"><i class="iconfont icon-qq"></i></a>
							<a class="facebook" data-share="facebook"><i class="iconfont icon-facebook"></i></a>
							<a class="twitter" data-share="twitter"><i class="iconfont icon-twitter"></i></a>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php if ( _thememee('post_nav') ) { ?>
				<div class="navigation">
					<?php
						$prev_post  = get_previous_post(false,'');
						$next_post  = get_next_post(false,'');
						if ( empty( $prev_post ) ) {
							$next_class = 'style="width:100%;padding-left:0"';
						}
						if ( empty( $next_post ) ) {
							$prev_class = 'style="width:100%;padding-right:0"';
						}
					?>	
					<?php if ( !empty( $prev_post ) ) { ?>
						<div class="prev-posts" <?php echo $prev_class; ?>>
							<a class="prev thumbnail" href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo $prev_post->post_title; ?>" style="background: url(<?php $prev_img = post_thumbnail_nav($prev_post->ID); echo !empty( $prev_img ) ? $prev_img : _thememee('post_prev'); ?>) center center / cover no-repeat" alt="<?php echo $prev_post->post_title; ?>">
								<span>上一篇</span>
								<h1><?php echo $prev_post->post_title; ?></h1>
							</a>
						</div>
					<?php } ?>
					<?php if ( !empty( $next_post ) ) { ?>
						<div class="next-posts" <?php echo $next_class; ?>>
							<a class="next thumbnail" href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo $next_post->post_title; ?>" style=" background: url(<?php $next_img = post_thumbnail_nav($next_post->ID); echo !empty( $next_img ) ? $next_img : _thememee('post_next'); ?>) center center / cover no-repeat" alt="<?php echo $next_post->post_title; ?>">
								<span>下一篇</span>
								<h1><?php echo $next_post->post_title; ?></h1>
							</a>
						</div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php if ( !wp_is_mobile() && _thememee( 'ad_pc_post', true ) ) { ?>
				<div class="advert"><?php echo _thememee( 'ad_pc_post'); ?></div>
				<?php } ?>
				<?php if ( wp_is_mobile() && _thememee( 'ad_mobile_post', true )){ ?>
				<div class="advert"><?php echo _thememee( 'ad_mobile_post'); ?></div>
				<?php } ?>
				<?php if ( _thememee('post_related') ) { ?>
				<div class="related">
					<div class="heading">
						<i class="iconfont icon-related"></i>相关文章
					</div>
					<div class="content">
						<ul>
						<?php
							$exclude_id  = isset( $post->ID ) ? $post->ID : NULL;
							$post_number = _thememee('post_related_number',true);
							$post_tags   = get_the_tags();
							$i           = 0;
						?>
						<?php if ( $i < $post_number ) {
							$cats = '';
							foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
							$args = array(
								'category__in'        => explode(',', $cats),
								'post__not_in'        => explode(',', $exclude_id),
								'ignore_sticky_posts' => 1,
								'orderby'             => 'comment_date',
								'posts_per_page'      => $post_number - $i
							);
						?>
						<?php query_posts($args); while( have_posts() ) { the_post(); ?>
							<li>
								<div class="box">
									<?php if ( _thememee('lazyload') ) { ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo _thememee('lazyload_thumbnail'); ?>) center center / cover no-repeat"  data-original="<?php echo posts_thumbnail_src(); ?>" >
									<?php } else { ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo posts_thumbnail_src(); ?>) center center / cover no-repeat">
									<?php } ?>
										<div class="title">
											<h2><?php the_title(); ?></h2>
										</div>
									</a>
								</div>
							</li>
						<?php $i ++; } wp_reset_query(); } if ( $i == 0 )  echo '<li>暂无相关文章</li>'; ?>
						</ul>
					</div>
				</div>
				<?php } ?>
				<?php if (comments_open()) comments_template( '', true ); ?>
				<?php } } ?>	
			</div>	
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>