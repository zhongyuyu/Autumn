<?php

date_default_timezone_set('PRC');
define('THEME_VERSION', 'Autumn 1.2');
if ( !defined( 'THEME_DIR' ) ) {
	define( 'THEME_DIR', get_template_directory() );
}
if ( !defined( 'THEME_URI' ) ) {
	define( 'THEME_URI', get_template_directory_uri() );
}

if ( !function_exists('_thememee') ) {
	function _thememee( $option = '', $default = null){
		$options = get_option('thememee_options');
		// Attention: Set your unique id of the framework
		return (isset($options[$option])) ? $options[$option] : $default;
	}
}

if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
	wp_redirect( admin_url( "admin.php?page=codestar-options" ) );
	// 启用主题自动跳转主题选项
	exit;
}

require THEME_DIR . '/includes/main.php';
require THEME_DIR . '/includes/seo.php';
require THEME_DIR . '/includes/taxonomy.php';
require THEME_DIR . '/includes/widgets/widgets.php';
require THEME_DIR . '/includes/codestar-framework/codestar-framework.php';
require THEME_DIR . '/includes/options.php';
require THEME_DIR . '/includes/meta-box/meta-box.php';
require THEME_DIR . '/includes/metabox.php';
require THEME_DIR . '/action/comments.php';

function thememee_static() {
	$static_url = get_bloginfo( 'template_url' );
	wp_enqueue_style( 'style', $static_url . '/css/thememee.autumn.main.css', array(), THEME_VERSION, 'all' );
	wp_enqueue_style( 'tooltips', $static_url . '/css/thememee.autumn.tooltips.css', array(), THEME_VERSION, 'all' );
	wp_enqueue_style( 'iconfont', $static_url . '/fonts/thememee.autumn.iconfont.css', array(), THEME_VERSION, 'all' );
	wp_enqueue_style( 'fontawesome', $static_url . '/fonts/fontawesome.min.css', array(), THEME_VERSION, 'all' );
	if ( is_home() ) {
		wp_enqueue_style( 'carousel', $static_url . '/css/owl.carousel.min.css', array(), THEME_VERSION, 'all' );
	}
	if ( is_single() || is_page() ) {
		wp_enqueue_style( 'fancybox', $static_url . '/css/jquery.fancybox.min.css', array(), THEME_VERSION, 'all' );
		wp_enqueue_style( 'highlight', $static_url . '/css/highlight.min.css', array(), THEME_VERSION, 'all' );
	}
	wp_enqueue_script( 'jQuery', $static_url . '/js/jquery.min.js', false, THEME_VERSION, true );
	wp_enqueue_script( 'cookie', $static_url . '/js/jquery.cookie.min.js', false, THEME_VERSION, true );
	if ( _thememee('lazyload') ) {
		wp_enqueue_script( 'lazyload', $static_url . '/js/jquery.lazyload.min.js', false, THEME_VERSION, true );
	}
	if ( is_single() || is_page() ) {
		wp_enqueue_script( 'fancybox', $static_url . '/js/jquery.fancybox.min.js', false, THEME_VERSION, true );
	}
	if ( is_home() ) {
		wp_enqueue_script( 'carousel', $static_url . '/js/owl.carousel.min.js', false, THEME_VERSION, true );
	}
	wp_enqueue_script( 'sidebar', $static_url . '/js/theia-sticky-sidebar.min.js', false, THEME_VERSION, true );
	if ( is_single() || is_page() ) {
		wp_enqueue_script( 'highlight', $static_url . '/js/highlight.min.js', false, THEME_VERSION, true );
	}
	wp_enqueue_script( 'main', $static_url . '/js/thememee.autumn.main.js', false, THEME_VERSION, true );
	if ( is_single() || is_page() ) {
		wp_enqueue_script( 'comments', $static_url . '/js/thememee.autumn.comment.js', false, THEME_VERSION, true );
	}
	wp_localize_script( 'jQuery', '_thememee',
		array(
			"uri"	 => THEME_URI,
			"url"	 => home_url(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'thememee_static' );

/*****启用友情链接*****/
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

/*****启用特色图像*****/
if ( function_exists('add_theme_support') ){
	add_theme_support('post-thumbnails');
}

/*****菜单*****/
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus( array(
		'main' => __( '主要菜单' ),
	) );
}

/*****侧边栏*****/
if ( function_exists('register_sidebar') ) {
	register_sidebar(
		array(
			'name'          => '全站侧栏',
			'id'            => 'widget_all',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3><span>',
			'after_title'   => '</span></h3>'
		)
	);
	register_sidebar(
		array(
			'name'          => '首页侧栏',
			'id'            => 'widget_home',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3><span>',
			'after_title'   => '</span></h3>'
		)
	);
	register_sidebar(
		array(
			'name'          => '页面侧栏',
			'id'            => 'widget_page',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3><span>',
			'after_title'   => '</span></h3>'
		)
	);
	register_sidebar(
		array(
			'name'          => '文章侧栏',
			'id'            => 'widget_post',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3><span>',
			'after_title'   => '</span></h3>'
		)
	);
	register_sidebar(
		array(
			'name'          => '分类/标签/搜索页面侧栏',
			'id'            => 'widget_other',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3><span>',
			'after_title'   => '</span></h3>'
		)
	);
}

function remove_footer_admin () {
	echo '感谢选择 <a href="https://www.thememee.com" target="_blank">ThemeMee</a> 为您设计！</p>';
}
add_filter( 'admin_footer_text', 'remove_footer_admin' );