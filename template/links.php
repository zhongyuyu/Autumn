<?php 
/*
	template name: 友情链接
	description: template for https://www.thememee.com
*/
get_header();?>
<div class="main">
	<div class="container">
		<div class="banner" style="background:url(<?php echo background(); ?>) center center / cover no-repeat">
			<h1><?php the_title(); ?></h1>
        </div>
		<div class="detail">
			<div class="content">
				<?php
					$categorys = get_terms( 'link_category' );
					if ( !empty( $categorys ) ) {
						foreach( $categorys as $category ){ 
							$result .= '<h2>'.$category->name.'</h2>';
							$result .= get_the_link( $category->term_id );
						}
					} else {
						$result .= get_the_link();
					}
					echo $result;
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>