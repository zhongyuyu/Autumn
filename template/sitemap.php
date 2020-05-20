<?php
/*
Template Name: 站点地图
*/
get_header();
?>
<div class="main">
	<div class="container">
		<div class="banner">
			<div class="content" style="background:url(<?php echo background(); ?>) center center / cover no-repeat">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
		<div class="detail">
			<div class="content">
				<h2>全部文章</h2>
				<ul>
					<?php echo sitemap_post(); ?>
				</ul>
				<h2>分类目录</h2>
				<ul>
					<?php echo sitemap_category(); ?>
				</ul>
				<h2>独立页面</h2>
				<ul>
					<?php echo sitemap_page(); ?>
				</ul>
				<p>最后更新：<?php echo sitemap_update(); ?></p>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>