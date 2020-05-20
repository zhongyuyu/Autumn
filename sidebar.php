<div class="sidebar">
	<?php if ( is_single() || is_author() ) { ?>
	<div class="widget author">
		<div class="profile">
			<div class="panel" style="background:url(<?php echo background(); ?>) center center / cover no-repeat">
				<a class="avatar" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>" title="<?php echo the_author_meta( 'nickname' ); ?>">
					<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
				</a>
			</div>	
			<div class="name">
				<a href="<?php echo get_author_posts_url(  get_the_author_meta( 'ID' ) );?>" title="<?php echo the_author_meta( 'nickname' ); ?>"><?php echo the_author_meta( 'nickname' ); ?></a>
				<span><?php echo author_level(); ?></span>
			</div>
			<div class="desc">
				<p><?php if ( get_the_author_meta( 'description' ) ) { echo the_author_meta( 'description' ); } else { echo __( '这家伙真懒，个人简介都没有填写…' ); } ?></p>
			</div>
			<div class="stats">
				<div class="item">
					<span><?php echo author_posts_count(); ?></span>
					<small>文章</small>
				</div>
				<div class="item">
					<span><?php echo author_comments_count(); ?></span>
					<small>评论</small>
				</div>
				<div class="item">
					<span><?php echo author_likes_count(); ?></span>
					<small>获赞</small>
				</div>
			</div>
		</div>
	</div>			
	<?php }	?>
	<?php if ( !is_active_sidebar( 'widget_right' ) && !is_active_sidebar( 'widget_post' ) && !is_active_sidebar( 'widget_sidebar' ) && !is_active_sidebar( 'widget_other' )) { ?>
	<div class="widget">
		<p>请到[后台->外观->小工具]中添加需要显示的小工具。</p>
	</div>
	<?php } else { ?>
	<?php
		dynamic_sidebar( 'widget_all' ); 
		wp_reset_query();
		if ( is_home() ) {
			dynamic_sidebar( 'widget_home' );
		} else if ( is_page() ) {
			dynamic_sidebar( 'widget_page' );
		} else if ( is_single() ) {
			dynamic_sidebar( 'widget_post' );
		} else {
			dynamic_sidebar( 'widget_other' );
		}
 	?>
	<?php } ?>
</div>