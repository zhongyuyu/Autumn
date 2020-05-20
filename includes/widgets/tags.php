<?php  

add_action( 'widgets_init', 'widgets_tags_loader' );

function widgets_tags_loader() {
	register_widget( 'widgets_tags' );
}

class widgets_tags extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'tags',
			'description' => '显示文章标签'
		);
		parent::__construct( 'widgets_tags', '热门标签', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		$title = apply_filters('widget_name', $instance['title']);
		$offset = $instance['offset'];
		$count = $instance['count'];
		$hot = $instance['hot'];
		echo $before_title.$title.$after_title; 
		echo thememee_widgets_tags($count , $hot , $offset);
		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => '热门标签',
			'count' => '15',
			'offset' => '0',
			'hot' => '5',
		) );
    	$number = $number ? $number : 15;
		$hot = $hot ? $hot : 5;
		$offset = $offset ? $offset : 0;
?>
<p>
	<label>
		名称：
		<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
	</label>
</p>
<p>
	<label>
		显示数量：
		<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" value="<?php echo $instance['count']; ?>" class="widefat" />
	</label>
</p>
<p>
	<label>
		去除前几个：
		<input id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="number" value="<?php echo $instance['offset']; ?>" class="widefat" />
	</label>
</p>
<p>
	<label>
		热门标签规则（超过此数则为热门标签）：
		<input id="<?php echo $this->get_field_id('hot'); ?>" name="<?php echo $this->get_field_name('hot'); ?>" type="number" value="<?php echo $instance['hot']; ?>" class="widefat" />
	</label>
</p>
<?php } } ?>
<?php function thememee_widgets_tags( $number, $hot, $offset ) { ?>
<ul>
<?php
	$tags = get_tags( array (
		"number" => $number,
		"order" => "DESC",
		"offset" => $offset,
	) );
	foreach( $tags as $tag ){
?>
    <li>
<a <?php echo $class; ?>href="<?php echo esc_attr( get_tag_link( $tag->term_id ) ); ?>" title="浏览和<?php echo $tag->name; ?>有关的文章"><?php echo $tag->name; ?></a></li>
<?php } ?>
</ul>
<?php } ?>
