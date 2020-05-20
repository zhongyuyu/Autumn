<?php

add_action( 'widgets_init', 'widgets_recommend_posts_loader' );

function widgets_recommend_posts_loader() {
	register_widget( 'widgets_recommend_posts' );
}

class widgets_recommend_posts extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'post-gather',
			'description' => '最新文章/热门文章/热评文章/随机文章。',
		);
		parent::__construct( 'widgets_recommend_posts', '聚合文章', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$limit      = $instance['limit'];
		$cat        = $instance['cat'];
		$orderby    = $instance['orderby'];
		$title      = apply_filters('widget_name', $instance['title']);
		$title_show = ! empty( $instance['title_show'] ) ? esc_attr( $instance['title_show'] ) : '';
		echo $before_widget;
		echo thememee_widget_recommend_posts( $title, $title_show, $orderby, $limit, $cat );
		echo $after_widget;	
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'  => '热门推荐',
			'width'  => '100%',
			'height' => 'auto',
		) );
		$instance['orderby']    = ! empty( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : '';
		$instance['cat']        = ! empty( $instance['cat'] ) ? esc_attr( $instance['cat'] ) : '';
		$instance['limit']      = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 5;
		$instance['title_show'] = ! empty( $instance['title_show'] ) ? esc_attr( $instance['title_show'] ) : '';
?>
<p style="clear: both;padding-top: 5px;">
	<label>
		标题：
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
	</label>
</p>
<p>
	<label>
		<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['title_show'], 'on' ); ?> id="<?php echo $this->get_field_id('title_show'); ?>" name="<?php echo $this->get_field_name('title_show'); ?>">
		显示栏目标题
	</label>
</p>
<p>
	<label>
		排序方式：
		<select style="width:100%;" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" style="width:100%;">
			<option value="date" <?php selected('date', $instance['orderby']); ?>>最新文章</option>
			<option value="views" <?php selected('views', $instance['orderby']); ?>>热门文章</option>
			<option value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>>热评文章</option>
			<option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机文章</option>
		</select>
	</label>
</p>
<p>
	<label>
		分类限制：
		<p>显示指定分类，填写数字，用英文逗号隔开，例如：1,2 。</p>
		<p>排除指定分类，填写负数，用英文逗号隔开，例如：-1,-2。</p>
		<input style="width:100%;" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo $instance['cat']; ?>" size="24" />
	</label>
</p>
<p>
	<label>
		显示数目：
		<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" />
	</label>
</p>
<?php } } ?>
<?php function thememee_widget_recommend_posts( $title, $title_show, $orderby, $limit, $cat) { ?>
<?php if( $title_show ){ ?>
<h3><?php echo $title; ?></h3>
<?php } else { ?>
<h3 style="display: none"><?php echo $title; ?></h3>
<?php } ?>
<?php if( $orderby == 'date' ){  ?>
<?php 
	$date = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $limit,
		'orderby'             => $orderby,
		'order'               => 'DESC',
		'cat'                 => $cat,
		'ignore_sticky_posts' => 1,
	);
?>
<?php $posts = new WP_Query( $date ); if ( $posts->have_posts() ) { ?>
<ul class="new-post">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
	<li>
		<div class="thumbnail">
			<?php if ( _thememee('lazyload') ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo _thememee('lazyload_thumbnail'); ?>) center center / cover no-repeat"  data-original="<?php echo posts_thumbnail_src(); ?>" >
			</a>
			<?php } else { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo posts_thumbnail_src(); ?>) center center / cover no-repeat">
			</a>
			<?php } ?>
		</div>
		<div class="title">
			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<span><?php echo get_the_time('Y-m-d'); ?></span>
		</div>
	</li>
	<?php $i++; endwhile; wp_reset_query(); ?>
</ul>
<?php } else { ?>
	<p>暂无文章</p>
<?php } ?>
<?php } else if( $orderby == 'views' ){  ?>
<?php 
	$views = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $limit,
		'cat'                 => $cat,
		'meta_key' 			  => $orderby,
		'orderby'             => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
		'ignore_sticky_posts' => 1,
	);
?>
<?php $posts = new WP_Query( $views ); if ( $posts->have_posts() ) { ?>
<ul class="hot-views-post">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
	<li>
		<?php if ( _thememee('lazyload') ) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo _thememee('lazyload_thumbnail'); ?>) center center / cover no-repeat"  data-original="<?php echo posts_thumbnail_src(); ?>" >
		<?php } else { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo posts_thumbnail_src(); ?>) center center / cover no-repeat">
		<?php } ?>
			<div class="title">
				<h2><?php the_title(); ?></h2>
			</div>
			<div class="meta">
				<span><?php echo get_the_time('Y-m-d'); ?></span>
				<span><?php echo post_views('',''); ?> 热度</span>
			</div>
		</a>
	</li>
	<?php $i++; endwhile; wp_reset_query(); ?>
</ul>
<?php } else { ?>
	<p>暂无文章</p>
<?php } ?>
<?php } else if( $orderby == 'comment_count' ){  ?>
<?php 
	$comment = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $limit,
		'orderby'             => $orderby,
		'order'               => 'DESC',
		'cat'                 => $cat,
		'ignore_sticky_posts' => 1,
	);
?>
<?php $posts = new WP_Query( $comment ); if ( $posts->have_posts() ) { ?>
<ul class="hot-comments-post">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
    <li>
		<?php if ( _thememee('lazyload') ) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo _thememee('lazyload_thumbnail'); ?>) center center / cover no-repeat"  data-original="<?php echo posts_thumbnail_src(); ?>" >
		<?php } else { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo posts_thumbnail_src(); ?>) center center / cover no-repeat">
		<?php } ?>
			<div class="title">
				<div class="meta">
					<span><?php echo get_the_time('Y-m-d'); ?></span>
					<span><?php echo get_comments_number('0','1','%'); ?> Comments</span>
				</div>
				<h2><?php the_title(); ?></h2>
			</div>
		</a>
	</li>
	<?php $i++; endwhile; wp_reset_query(); ?>
</ul>
<?php } else { ?>
	<p>暂无文章</p>
<?php } ?>
<?php } else if( $orderby == 'rand' ){  ?>
<?php 
	$rand = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $limit,
		'orderby'             => $orderby,
		'order'               => 'DESC',
		'cat'                 => $cat,
		'ignore_sticky_posts' => 1,
	);
?>
<?php $posts = new WP_Query( $rand ); if ( $posts->have_posts() ) { ?>
<ul class="rand-post">
	<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
	<li>
		<div class="thumbnail">
			<?php if ( _thememee('lazyload') ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo _thememee('lazyload_thumbnail'); ?>) center center / cover no-repeat"  data-original="<?php echo posts_thumbnail_src(); ?>" >
			</a>
			<?php } else { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background:url(<?php echo posts_thumbnail_src(); ?>) center center / cover no-repeat">
			</a>
			<?php } ?>
		</div>
		<div class="title">
			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<span><?php echo get_the_time('Y-m-d'); ?></span>
		</div>
	</li>
	<?php $i++; endwhile; wp_reset_query(); ?>
</ul>
<?php } else { ?>
	<p>暂无文章</p>
<?php } ?>
<?php } ?>
<?php } ?>