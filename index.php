<?php get_header(); ?>
<div class="main">
	<div class="container">
		<div class="row">
			<div class="banner">
				<?php if ( _thememee('slide') ) { ?>
				<div class="slide owl-carousel">
					<?php foreach ( _thememee('slide') as $key => $i) { ?>
					<div class="item">
						<a href="<?php echo $i['_href'] ?>"<?php if ( $i['_blank'] ) { ?> target="_blank"<?php } ?> >
							<div class="content" style="background: url(<?php echo $i['_img'] ?>) center center / cover no-repeat"></div>
						</a>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<div class="article">
				<div class="content">
				<?php
					$args = array(
						'ignore_sticky_posts'=> 1,
						'paged' => $paged
					);
					if ( _thememee('post_hide') ) {
						$pool = array();
						foreach (_thememee('post_hide') as $key => $value) {
							if ( $value ) $pool[] = $key;
						}
						$args['cat'] = '-'.implode($pool, ',-');
					}
				?>
				<?php query_posts($args); if ( have_posts() ) { ?>
					<?php
						$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
						$args  = array(
							'post_type'           => 'post',
							'post_status'         => 'publish',
							'posts_per_page'      => '10',
							'ignore_sticky_posts' => 1,
							'paged'               => $paged
						);
						query_posts($args);
					?>
					<?php while ( have_posts() ) { the_post(); get_template_part( 'content', get_post_format() ); ?>
					<?php } ?>
				<?php }	else { ?>
				<div class="no-content">
					<i class="iconfont icon-empty"></i>
					<p>暂无文章</p>
				</div>
				<?php } ?>
				</div>
			</div>
			<?php get_sidebar(); ?>
			<?php if ( !have_posts() ) { ?>
			<?php } else { ?>
			<div class="postsnav">
				<?php the_posts_pagination( array( 'prev_text'=>'上一页', 'next_text'=>'下一页', 'mid_size' => 1, ) ); ?>
			</div>
			<?php } ?>
			<div class="categorys">
				<div class="content">
					<?php
						$categories = ( _thememee('module_category') ) ? _thememee('module_category') : array();
						foreach ( $categories as $category ) {
							$cat	= get_category( $category );
							$url	= get_category_link( $category );
							$args   = array( 'cat' => $category, 'posts_per_page' => 3 );
							$posts  = get_posts( $args ); 
							$src	= array();
							$i	  = 0;
							foreach ( $posts as $post ) {
								$src[]  = posts_thumbnail_src( $post );
								$i++;
							}
					?>
					<div class="item">
						<div class="box">
							<div class="left">
								<a class="thumbnail" href="<?php echo $url;?>" style="background: url(<?php echo $src[0]; ?>) center center / cover no-repeat"></a>
								<div class="title">
									<span><?php echo $cat->cat_name; ?></span>
								</div>
								<div class="stats">
									<span><?php echo $cat->count; ?>篇文章</span>
								</div>
							</div>
							<div class="right">
								<a class="thumbnail"  href="<?php echo $url;?>" style="background: url(<?php echo $src[1]; ?>) center center / cover no-repeat"></a>
								<a class="thumbnail"  href="<?php echo $url;?>" style="background: url(<?php echo $src[2]; ?>) center center / cover no-repeat">
									<div class="stats">
										<span><?php echo $cat->count; ?>+</span>
									</div>
								</a>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>