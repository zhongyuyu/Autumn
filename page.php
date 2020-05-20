<?php if ( have_posts()) { while( have_posts() ) { the_post(); ?>
<?php get_header(); ?>
<div class="main">
	<div class="container">
		<div class="banner">
			<div class="content" style="background:url(<?php echo background(); ?>) center center / cover no-repeat">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
		<div class="detail">
			<div class="content">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
<?php } } ?>