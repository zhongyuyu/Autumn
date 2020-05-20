<?php 
/*
Template Name: 归档页面
*/
get_header(); ?>
<?php if ( have_posts() ) { while( have_posts() ) { the_post(); ?>
<div class="main">
	<div class="container">
		<div class="banner">
			<div class="content" style="background:url(<?php echo background(); ?>) center center / cover no-repeat">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
		<div class="detail">
			<div class="content">
			<?php 
				$args = array(
					'posts_per_page'	  => -1,
					'post_type'		      => 'post',
					'post_status'		  => 'publish',
					'ignore_sticky_posts' => 1
				);
				$yearpost = new WP_Query( $args );
				$i = 1;
				if ( $yearpost->have_posts() ) {
			?>
			<?php while($yearpost->have_posts()) { $yearpost->the_post(); ?>
				<?php if ( $date != date( 'Y', strtotime( $post->post_date ) ) ) { ?>
						</ul>
					<h2><?php echo date( 'Y', strtotime( $post->post_date ) ); ?></h2>
						<ul>
				<?php } ?>
							<li>
								<time><?php the_time('m.d'); ?></time>
								<span><?php post_views('',''); ?> 热度</span>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</li>
				<?php $i++; $date = date( 'Y', strtotime($post->post_date) ); ?>
			<?php } ?>
			<?php } ?>
			<?php wp_reset_query(); ?>
			</div>
		</div>
	</div>
</div>
<?php } } ?>
<?php get_footer(); ?>