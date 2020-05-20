<?php get_header(); ?>
<div class="main">
	<div class="container">
		<div class="row">
			<?php if ( have_posts() ) { ?>
			<div class="article">
				<div class="banner" style="background:url(<?php echo background(); ?>) center center / cover no-repeat">
					<?php if ( _thememee('breadcrumbs') ){ ?>
						<?php echo breadcrumbs(); ?>
					<?php } ?>
					<div class="title">
						<h1><?php echo wp_specialchars( $s, 1 );?></h1>
					</div>
					<div class="desc">
						关于“<?php echo wp_specialchars( $s, 1 );?>”的搜索结果
					</div>
					<div class="stats">
						<p><?php global $wp_query; echo $wp_query->found_posts; ?> 篇文章</p>
					</div>
				</div>
				<div class="content">
					<?php while ( have_posts() ) { the_post(); get_template_part( 'content', get_post_format() ); ?>
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
			<?php } else { ?>
			<div class="no-content">
				<i class="iconfont icon-empty"></i>
				<p>抱歉，没有你要找的文章...</p>
				<a href="<?php bloginfo('url'); ?>">返回首页</a>
			</div>
		    <?php } ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>