<?php 
/*
Template Name: 标签页面
*/
get_header(); ?>
</div>
<div class="main">
	<div class="container">
		<div class="banner">
			<div class="content" style="background:url(<?php echo background(); ?>) center center / cover no-repeat">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
		<div class="detail">
			<div class="content">
				<ul>
					<?php echo get_the_tag(); ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>