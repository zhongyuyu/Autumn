<?php

add_action( 'widgets_init', 'widgets_ads_loader' );

function widgets_ads_loader() {
	register_widget( 'widgets_ads' );
}

class widgets_ads extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'ads',
			'description' => '显示一个广告(包括富媒体)',
		);
		parent::__construct('widgets_ads', '广告推荐 ', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		$content    = $instance['content'];
		$link       = $instance['link'];
		$blank      = $instance['blank'];
		$img        = $instance['img'];
		$width      = $instance['width'];
		$height     = $instance['height'];
		$title      = apply_filters('widget_name', $instance['title']);
		$title_show = ! empty( $instance['title_show'] ) ? esc_attr( $instance['title_show'] ) : '';
		echo $before_widget;
		echo thememee_widgets_ads($title,$title_show,$img,$content,$link,$blank);
		echo $after_widget;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'  => '广告推荐',
			'width'  => '100%',
			'height' => 'auto',
		) );
		$instance['link']       = ! empty( $instance['link'] ) ? esc_attr( $instance['link'] ) : '';
		$instance['img']        = ! empty( $instance['img'] ) ? esc_attr( $instance['img'] ) : '';
		$instance['blank']      = ! empty( $instance['blank'] ) ? esc_attr( $instance['blank'] ) : '';
		$instance['content']    = ! empty( $instance['content'] ) ? esc_attr( $instance['content'] ) : '';
		$instance['title_show'] = ! empty( $instance['title_show'] ) ? esc_attr( $instance['title_show'] ) : '';
?>

<p>
	<label>
		栏目标题：
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
		描述：
		<textarea id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" class="widefat" rows="3"><?php echo $instance['content']; ?></textarea>
	</label>
</p>
<p>
	<label>
		跳转链接：
		<input style="width:100%;" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="url" value="<?php echo $instance['link']; ?>" size="24" />
	</label>
</p>
<p>
	<label>
		图片链接：
		<input style="width:100%;" id="<?php echo $this->get_field_id('img'); ?>" name="<?php echo $this->get_field_name('img'); ?>" type="url" value="<?php echo $instance['img']; ?>" size="24" />
	</label>
</p>
<p>
	<label>
		图片宽度（输入数字例如：250px或者100%）：
		<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $instance['width']; ?>" />
	</label>
</p>
<p>
	<label>
		图片高度（默认，或者输入数字例如：250px或者100%）：
		<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $instance['height']; ?>" />
	</label>
</p>
<p>
	<label>
		<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['blank'], 'on' ); ?> id="<?php echo $this->get_field_id('blank'); ?>" name="<?php echo $this->get_field_name('blank'); ?>">
		新打开浏览器窗口
	</label>
</p>
<?php } } ?>
<?php function thememee_widgets_ads( $title, $title_show, $img, $content, $link, $blank ){ ?>
<?php if( $title_show ){ ?>
<h3><?php echo $title; ?></h3>
<?php } else { ?>
<h3 style="display: none"><?php echo $title; ?></h3>
<?php } ?>
<div class="content">
	<a href="<?php echo $link; ?>"<?php if( $blank ) echo ' target="_blank"'; ?>>
		<img src="<?php echo $img; ?>" alt="<?php echo $content; ?>">
	</a>
</div>
<?php } ?>