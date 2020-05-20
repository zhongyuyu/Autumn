<?php
	if ( _thememee('ad_pc_list') && !wp_is_mobile() ) {
		$location = _thememee( 'ad_pc_list_location', 3 );
		if ( $wp_query->current_post == $location ) {
			$html .= '<div class="item post-advert">' . _thememee('ad_pc_list') . '</div>';
		}
	} else if ( _thememee('ad_mobile_list') && wp_is_mobile() ){
		$location = _thememee('ad_mobile_list_location');
		if ( $wp_query->current_post == $location ) {
		   $html .= '<div class="item post-advert">' . _thememee('ad_mobile_list') . '</div>';
		}
	}
	echo $html;
?>
<div class="item posts-default">
	<div class="left">
		<div class="thumbnail">
			<?php if ( _thememee('lazyload') ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo _thememee('lazyload_thumbnail'); ?>) center center / cover no-repeat"  data-original="<?php echo posts_thumbnail_src(); ?>" >
			</a>
			<?php } else { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo posts_thumbnail_src(); ?>) center center / cover no-repeat">
			</a>
			<?php } ?>
		</div>
		<div class="category">
			<?php $category = get_the_category();if ($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';}?>
		</div>
		<div class="views">
			<span><?php post_views(); ?> 热度</span>
		</div>
	</div>
	<div class="right">
		<div class="top">
			<div class="title">
				<?php echo post_new(); ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</div>
			<div class="extract">
				<?php echo the_excerpt(); ?>
			</div>
		</div>
		<div class="bottom">
			<div class="author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><div class="avatar"><?php echo get_avatar( get_the_author_meta('ID') ); ?></div><span><?php echo the_author_meta( 'nickname' ); ?></span></a></div>
			<div class="time"><?php echo get_the_time('Y-m-d'); ?></div>
			<div class="like"><i class="iconfont icon-like"></i> <?php if ( get_post_meta($post->ID,'likes',true) ){ echo get_post_meta($post->ID,'likes',true); } else {echo '0';}?></div>
		</div>
	</div>
</div>