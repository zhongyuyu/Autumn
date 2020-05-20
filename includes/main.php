<?php

/*****删除 wp_head 中无关紧要的代码*****/
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'locale_stylesheet' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'rest_api_init', 'wp_oembed_register_route' );
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );
remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
remove_filter( 'oembed_response_data',   'get_oembed_response_data_rich',  10, 4 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action( 'wp_footer', 'wp_print_footer_scripts' );
remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
remove_filter( 'the_title', 'capital_P_dangit' );
remove_filter( 'the_content', 'capital_P_dangit' );
remove_filter( 'the_content', 'wptexturize');
remove_filter( 'comment_text', 'capital_P_dangit' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'embed_head', 'print_emoji_detection_script');
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'emoji_svg_url', '__return_false' );
add_filter( 'show_admin_bar', '__return_false' );
remove_action('wp_head', 'adjacent_posts_rel_link');
remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
add_filter('xmlrpc_enabled', '__return_false');
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');
remove_action('template_redirect', 'rest_output_link_header', 11 );

/*****body add loader class*****/
function loader($classes) {
	$classes[] = 'loader';
	return $classes;
}
add_filter( 'body_class', 'loader' );

/*****删除多余CSS选择器*****/
function my_css_attributes_filter( $var ) {
	return is_array($var) ? array_intersect( $var, array( 'current-menu-item', 'current-post-ancestor', 'current-menu-ancestor', 'current-menu-parent', 'menu-item-has-children' ) ) : '';
}
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1 );
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1 );
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1 );

/*****移除加载的JS和CSS链接中的版本号*****/
function remove_cssjs_ver( $src ) {
	if ( strpos( $src, 'ver=' ) ){
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 999 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 999 );

/*****移除 WordPress 4.2 中前台自动加载的 emoji 脚本*****/
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/*****屏蔽WordPress默认小工具*****/
function unregister_widgets() {
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
}
add_action( 'widgets_init', 'unregister_widgets' );

/*****禁用Gutenberg（古腾堡） 编辑器*****/
add_filter( 'use_block_editor_for_post', '__return_false' );
remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );

/*****禁用文章自动保存*****/
function disable_autosave() {
	wp_deregister_script('autosave');
}
add_action('wp_print_scripts','disable_autosave');

/*****禁用文章修订版本*****/
function specs_wp_revisions_to_keep( $num, $post ) {
	return 0;
}
add_filter( 'wp_revisions_to_keep', 'specs_wp_revisions_to_keep', 10, 2 );

/*****取消文章转义*****/
remove_filter( 'the_content', 'wptexturize' );
remove_filter( 'the_excerpt', 'wptexturize' );
remove_filter( 'comment_text', 'wptexturize' );

/*****去除文章摘要p标签*****/
remove_filter (  'the_excerpt' ,  'wpautop'  );

/*****文章摘要长度*****/
function post_excerpt_length( $length ) {
	return 60;
}
add_filter('excerpt_length', 'post_excerpt_length');

/*****文章摘要默认结尾[...]换成...*****/
function post_excerpt_more(){
	global $post;
	return "...";
}
add_filter('excerpt_more', 'post_excerpt_more');

/*****转换code标签中的html代码*****/
function code_convert_entities( $matches ) {
	return str_replace( $matches[1], htmlentities( $matches[1] ), $matches[0] );
}
function code_content_filter( $content ) {
	return preg_replace_callback( '|<code.*>(.*)</code|isU' , 'code_convert_entities', $content );
}
add_filter( 'the_content', 'code_content_filter', 0 );

/*****自定义用户头像*****/
function get_user_avatar() {
	if ( is_admin() ) {
		$avatar .= '<img class="avatar" src="' .  _thememee('avatar') . '"  height="32" width="32"  />';
	} else {
		$avatar .= '<img src="' .  _thememee('avatar') . '" alt="' . get_the_author_meta( 'nickname' ) . '" />';
	}
	return $avatar;
}
function get_ssl_avatar( $gravatar ) {
	global $current_user;
	$gravatar = preg_replace('/.*\\/avatar\\/(.*)\\?s=([\\d]+)&.*/', get_user_avatar($current_user->ID, $current_user->display_name ), $gravatar);
	return $gravatar;
}
add_filter( 'get_avatar', 'get_ssl_avatar' );

/*****根据上传时间重命名文件*****/
function upload_file_rename( $file ) {
	$info         = pathinfo($file['name']);
	$ext          = $info['extension'];
	$filedate     = date('YmdHis').rand(10,99);
	$file['name'] = $filedate . ' . ' . $ext;
	return $file;
}
add_filter('wp_handle_upload_prefilter', 'upload_file_rename' );

/*****邮箱配置*****/
if ( _thememee( 'mail_smtps' )) {
	function mail_smtp( $phpmailer ) {
		$phpmailer->IsSMTP();
		$mail_name .= _thememee( 'mail_name' );
		$mail_host .= _thememee( 'mail_host' );
		$mail_port .= _thememee( 'mail_port' );
		$mail_username .= _thememee( 'mail_username' );
		$mail_password .= _thememee( 'mail_password' );
		$mail_smtpsecure .= _thememee( 'mail_smtpsecure' );
		$phpmailer->FromName .= $mail_name ? $mail_name : 'thememee';
		$phpmailer->Host .= $mail_host ? $mail_host : 'smtp.qq.com';
		$phpmailer->Port .= $mail_port ? $mail_port : '465';
		$phpmailer->Username .= $mail_username ? $mail_username : 'admin@thememee.com';
		$phpmailer->Password .= $mail_password ? $mail_password : '123456789';
		$phpmailer->From .= $mail_username ? $mail_username : 'admin@thememee.com';
		$phpmailer->SMTPAuth .= _thememee( 'mail_smtpauth' ) == 1 ? true : false;
		$phpmailer->SMTPSecure .= $mail_smtpsecure ? $mail_smtpsecure : 'ssl';
	}
	add_action( 'phpmailer_init', 'mail_smtp' );
}

/*****添加Canonical标签*****/
function canonical( $paged = true ) {
	$link = false;
	if ( is_front_page() ) {
		$link = home_url( '/' );
	} else if ( is_home() && "page" == get_option('show_on_front') ) {
		$link = get_permalink( get_option( 'page_for_posts' ) );
	} else if ( is_tax() || is_tag() || is_category() ) {
		$term = get_queried_object();
		$link = get_term_link( $term, $term->taxonomy );
	} else if ( is_post_type_archive() ) {
		$link = get_post_type_archive_link( get_post_type() );
	} else if ( is_author() ) {
		$link = get_author_posts_url( get_query_var('author'), get_query_var('author_name') );
	} else if ( is_archive() ) {
		if ( is_date() ) {
			if ( is_day() ) {
				$link = get_day_link( get_query_var('year'), get_query_var('monthnum'), get_query_var('day') );
			} else if ( is_month() ) {
				$link = get_month_link( get_query_var('year'), get_query_var('monthnum') );
			} else if ( is_year() ) {
				$link = get_year_link( get_query_var('year') );
			}											   
		}
	}
	if ( $paged && $link && get_query_var('paged') > 1 ) {
		global $wp_rewrite;
		if ( !$wp_rewrite->using_permalinks() ) {
			$link = add_query_arg( 'paged', get_query_var('paged'), $link );
		} else {
			$link = user_trailingslashit( trailingslashit( $link ) . trailingslashit( $wp_rewrite->pagination_base ) . get_query_var('paged'), 'archive' );
		}
	}
	return $link;
}

/*****移除Category别名*****/
function no_category_base_refresh_rules() {
	global $wp_rewrite;
	$wp_rewrite -> flush_rules();
}
add_action( 'load-themes.php', 'no_category_base_refresh_rules' );
add_action( 'created_category', 'no_category_base_refresh_rules' );
add_action( 'edited_category', 'no_category_base_refresh_rules' );
add_action( 'delete_category', 'no_category_base_refresh_rules' );
function no_category_base_permastruct() {
	global $wp_rewrite, $wp_version;
	if ( version_compare( $wp_version, '3.4', '<' ) ) {
		$wp_rewrite -> extra_permastructs['category'][0] = '%category%';
	} else {
		$wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
	}
}
add_action('init', 'no_category_base_permastruct');
function no_category_base_rewrite_rules( $category_rewrite ) {
	$category_rewrite = array();
	$categories = get_categories( array( 'hide_empty' => false ) );
	foreach ( $categories as $category ) {
		$category_nicename = $category -> slug;
		if ( $category -> parent == $category -> cat_ID ) {
			$category -> parent = 0;
		} else if ( $category -> parent != 0 ) {
			$category_nicename = get_category_parents( $category -> parent, false, '/', true ) . $category_nicename;
		}
		$category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
		$category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
		$category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
	}
	global $wp_rewrite;
	$old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
	$old_category_base = trim($old_category_base, '/');
	$category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
	return $category_rewrite;
}
add_filter( 'category_rewrite_rules', 'no_category_base_rewrite_rules' );
function no_category_base_query_vars( $public_query_vars ) {
	$public_query_vars[] = 'category_redirect';
	return $public_query_vars;
}
add_filter( 'query_vars', 'no_category_base_query_vars' );
function no_category_base_request( $query_vars ) {
	if ( isset( $query_vars['category_redirect'] ) ) {
		$catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
			status_header(301);
		header("Location: $catlink");
		exit();
	}
	return $query_vars;
}
add_filter( 'request', 'no_category_base_request' );

/*****分类结尾添加斜杠*****/
function add_trailingslashit( $string, $type_of_url ) {
	if ( $type_of_url != 'single' && $type_of_url != 'page' ) {
		$string = trailingslashit( $string );
	}
	return $string;
}
add_filter( 'user_trailingslashit', 'add_trailingslashit', 10, 2 );

/*****页眉CSS代码*****/
function custom_css() {
	if ( _thememee('gray_skin') ) {
		$css .= 'html{overflow-y:scroll;filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);-webkit-filter: grayscale(100%);}';
		// 使网站变灰，支持IE、Chrome，基本上覆盖了大部分用户，不会降低访问速度
	}
	$css .= _thememee('css');
	if ( $css ) {
		echo '<style>' . $css . '</style>';
	}
}
add_action( 'wp_head', 'custom_css' );

/*****自定义底部footer代码*****/
function custom_javascript() {
	if ( _thememee('javascript') ) {
		echo '<script>'._thememee('javascript').'<script>';
	}
}
add_action( 'wp_footer', 'custom_javascript' );

/*****菜单显示结构*****/
function nav_menu_description_prefix( $item_output, $item, $depth, $args ) {
	if ( !empty( $item->description ) ) {
		$item_output = str_replace( '">' . $args->link_before . $item->title, '">' . $args->link_before . '' . $item->description . '<span>' . $item->title . '</span>', $item_output );
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'nav_menu_description_prefix', 10, 4 );

/*****菜单描述支持html*****/
function nav_menu_description_html( $menu_item ) {
	if ( isset( $menu_item->post_type ) ) {
		if ( 'nav_menu_item' == $menu_item->post_type ) {
			$menu_item->description = apply_filters( 'nav_menu_description', $menu_item->post_content );
		}
	}
	return $menu_item;
}
remove_filter( 'nav_menu_description', 'strip_tags' );
add_filter( 'wp_setup_nav_menu_item', 'nav_menu_description_html' );

/*****文章缩略图*****/
function posts_thumbnail_src( $post = null ) {
	if ( $post === null ) {
		global $post;
	}
	if ( $thumbnail_src = get_post_custom_values("thumb") ) {
		$thumbnail_src = get_post_custom_values("thumb");
		$src = $thumbnail_src [0];
	} else if ( has_post_thumbnail($post) ) {
		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$src = $thumbnail_src [0];
	} else {
		$src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if ( !empty($matches[1][0]) ) {
			$src = $matches[1][0];
		} else if ( _thememee('thumbnail_random') ) {
			$src = _thememee('thumbnail_path') . mt_rand( 1, _thememee('thumbnail_number') ) . '.png';
		} else if ( _thememee('thumbnail_default') ) {
			$src = _thememee('thumbnail_default');
		}
	}
	return $src;
}

/*****文章上下篇缩略图*****/
function post_thumbnail_nav( $post_id ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$post    = get_post($post_id);
	if ( has_post_thumbnail() ) {
		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
		$src = $thumbnail_src [0];
	} else {
		$src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if ( !empty($matches[1][0]) ) {
			$src = $matches[1][0];
		} else if ( _thememee('thumbnail_random') ) {
			$src = _thememee('thumbnail_path') . mt_rand( 1, _thememee('thumbnail_number') ) . '.png';
		} else {
			$src = '';
		}
	}
	return $src;
}

/*****列表文章最新标识*****/
function post_new() {
	global $post;
	$time = ( strtotime( date( "Y-m-d H:i:s" ) ) - strtotime( $post->post_date ) ) / 3600;
	if ( $time < 1 ){
		return '<span>最新</span>';
	} else {
		return false;
	}
}

/*****文章浏览*****/
function record_visitors() {
	if ( is_singular() ) {
		global $post;
		if ( $post->ID ) {
			$views = (int)get_post_meta( $post->ID, 'views', true );
			if ( !update_post_meta( $post->ID, 'views', ( $views + 1 ) ) ) {
				add_post_meta( $post->ID, 'views', 1, true );
			}
		}
	}
}
add_action( 'wp_head', 'record_visitors' );
function post_views( $echo = 1 ) {
	global $post;
	$views = (int)get_post_meta( $post->ID, 'views', true );
	if ( $echo ){
		echo number_format($views);
	} else {
		return $views;
	}
};

/*****文章点赞*****/
function like() {
	global $wpdb, $post;
	$id = $_POST["id"];
	$action = $_POST["like"];
	if ( $action == 'like' ){
		$raters = get_post_meta( $id, 'likes', true );
		$expire = time() + 99999999;
		$domain = ( $_SERVER['HTTP_HOST'] != 'localhost' ) ? $_SERVER['HTTP_HOST'] : false; 
		setcookie('likes_' . $id,$id,$expire,'/',$domain,false);
		if ( !$raters || !is_numeric($raters) ) {
			update_post_meta( $id, 'likes', 1 );
		} else {
			update_post_meta( $id, 'likes', ( $raters + 1 ) );
		}
		echo get_post_meta( $id, 'likes', true );
	}
	die;
}
add_action('wp_ajax_nopriv_like', 'like');
add_action('wp_ajax_like', 'like');

/*****文章外链自动添加nofollow属性*****/
function nofollow( $content ) {
	$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
	if ( preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER) ) {
		if ( !empty($matches) ) {
			$srcUrl = get_option('siteurl');
			for ( $i=0; $i < count($matches); $i++ ) {
				$tag = $matches[$i][0];
				$tag2 = $matches[$i][0];
				$url = $matches[$i][0];
   				$noFollow = '';
				$pattern = '/target\s*=\s*"\s*_blank\s*"/';
				preg_match( $pattern, $tag2, $match, PREG_OFFSET_CAPTURE );
				if ( count($match) < 1 ) {
					$noFollow .= ' target="_blank" ';
				}
				$pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
				preg_match( $pattern, $tag2, $match, PREG_OFFSET_CAPTURE );
				if ( count($match) < 1 ) {
					$noFollow .= ' rel="nofollow" ';
				}
				$pos = strpos( $url, $srcUrl );
				if ( $pos === false ) {
					$tag = rtrim ($tag,'>');
					$tag .= $noFollow . '>';
					$content = str_replace( $tag2, $tag, $content );
					}
			}
		}
	}
	$content = str_replace(']]>', ']]>', $content);
	return $content;
}
add_filter( 'the_content', 'nofollow');

/*****文章fancybox图片灯箱*****/
if ( _thememee('fancybox') ){
	function fancybox1( $content ) {
		global $post;
		$pattern	 = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png|swf)('|\")(.*?)>/i";
		$replacement = '<a$1href=$2$3.$4$5 data-fancybox="images"><img$1src=$2$3.$4$5$6></a>';
		$content	 = preg_replace($pattern, $replacement, $content);
		return $content;
	}
	function fancybox2( $content ) {
		global $post;
		$pattern	 = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png|swf)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 data-fancybox="images"$6>$7</a>';
		$content	 = preg_replace($pattern, $replacement, $content);
		return $content;
	}
	add_filter('the_content', 'fancybox1');
	add_filter('the_content', 'fancybox2');
}

/*****文章图片自动添加alt和title信息*****/
function image_alt_title( $content ) {
	global $post;
	preg_match_all( '/<img (.*?)\/>/', $content, $images );
	if ( !is_null( $images ) ) {
		foreach($images[1] as $index => $value) {
			$new_img = str_replace( '<img', '<img alt="' . get_the_title() . '-' . get_option( 'blogname' ) . '" title="' . get_the_title() . '-' . get_option( 'blogname' ) . '"', $images[0][$index] );
			$content = str_replace( $images[0][$index], $new_img, $content );
		}
	}
	return $content;
}
add_filter( 'the_content', 'image_alt_title' );

/*****文章去掉图片外围标签P，添加DIV*****/
function image_filter_p( $content ) {
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/s', '<div class="post-image">\1\2\3</div>', $content );
}
add_filter( 'the_content', 'image_filter_p', 30 );

/*****文章版权*****/
function cc_declare() {
	global $post;
	$html .= '<div class="declare">';
	if ( get_post_meta( $post->ID, 'cc', !0 ) == 1 ) {
		$html .= '<a class="tooltips-right" href="javascript:void(0)" data-title="原创文章，未经允许禁止转载！"><i class="iconfont icon-declare"></i></a>';
	} else if ( get_post_meta( $post->ID, 'cc', !0 ) == 2 ) {
		$html .= '<a class="tooltips-right large" href="javascript:void(0)" data-title="转载文章，作者：' . get_post_meta( $post->ID, 'source', true ) . '，来源地址：' . get_post_meta( $post->ID, 'source_url', true ) . '"><i class="iconfont icon-declare"></i></a>';
	} else if ( _thememee('post_copyright') ) {
		$html .= '<a class="tooltips-right large" href="javascript:void(0)" data-title="本作品采用【知识共享署名-非商业性使用-相同方式共享 4.0 国际许可协议】进行许可！"><i class="iconfont icon-declare"></i></a>';
	}
	$html .= '</div>';
	return $html;
}

/*****友情链接*****/
function get_the_link( $id = null ) {
	$bookmarks = get_bookmarks( array( 'orderby' => 'date', 'category' => $id ) );
	if ( !empty($bookmarks) ) {
		$html .= '<ul>';
		foreach ($bookmarks as $bookmark) {
			$html .= '<li><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" rel="' . $bookmark->link_rel . '" >';
			if ( $bookmark->link_notes ){
				$html .= get_avatar( $bookmark->link_notes, 64 );
			} else if ( $bookmark->link_image ){
				$html .= '<div class="favicon" style="background: url(' .  $bookmark->link_image  . ') center center / cover no-repeat"></div>';
			} else if ( _thememee('background_random') ) {
				$html .= '<div class="favicon" style="background: url(' . _thememee('background_path') . mt_rand( 1, _thememee('background_number') ) . '.png'   . ') center center / cover no-repeat"></div>';
			} else if ( _thememee('background_random') ) {
				$html .= '<div class="favicon" style="background: url(' . _thememee('background_links') . ') center center / cover no-repeat"></div>';
			}
			$html .= '<div class="info"><div class="box"><span class="name">' .  $bookmark->link_name  . '</span><span class="description">' .$bookmark->link_description. '</span></div></div></a></li>';
		}
		$html .= '</ul>';
	}
	return $html;
}

/*****热门标签*****/
function get_the_tag() {
	$tags = get_tags( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 50 ) );
	if ( $tags ) {
		foreach( $tags as $tag ) {
			$html .= '<li><div class="box"><a href="' . get_tag_link($tag) . '">' .  $tag->name  . '</a><span>x ' .  $tag->count  . '</span>';
				$posts = get_posts( array( 'tag_id' => $tag->term_id, 'numberposts' => 1 ) );
				if ( $posts ) {
					foreach( $posts as $post ) {
						$html .= '<div class="title"><a href="' . get_permalink($post) . '">' . get_the_title($post) . '</a></div>';
					}
				}
			$html .= '</div></li>';
		}
	}
	return $html;
}

/*****网站地图*****/
function sitemap_post() {
	$posts = get_posts( array( 'orderby' => 'post_date', 'order' => 'DESC', 'numberposts' => -1 ) );
	foreach ( $posts as $post ) {
		$html .= '<li><a href="' . get_permalink($post) . '" title="' . get_the_title($post) . '">' . get_the_title($post) . '</a></li>';
	}
	return $html;
}
function sitemap_category() {
	$category = wp_list_categories( array( 'title_li' => '' ) );
	return $category;
}
function sitemap_page() {
	$page = wp_list_pages( array( 'title_li' => '' ) );
	return $page;
}
function sitemap_update() {
	global $wpdb;
	$sql = $wpdb->get_results( "SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')" );
	$time = date('Y-m-d G:i:s', strtotime($sql[0]->MAX_m));
	return $time;
}

/*****评论数量*****/
function author_comment_number( $author_id ) { 
	global $wpdb;
	$comment_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->comments  WHERE comment_approved='1' AND user_id = %d AND comment_type not in ('trackback','pingback')" ,$author_id ) );
	return $comment_count;
}

/*****评论表情*****/
function get_the_emoji() {
	$file = file_get_contents( THEME_DIR . '/action/emoji.json' );
	$json = json_decode($file, true);
	foreach ( $json as $key1 => $val1 ) {
		$html .= '<div class="emoji"><ul>';
		foreach ( $val1['value'] as $key2 => $val2 ) {
			$html .= '<li><img src="' . $val1['path'] . $val2 . '"></li>';
		}
		$html .= '</ul></div>';
	}
	return $html;
}

/*****Ajax评论错误*****/
function ajax_comment_error( $tips ) {
	header('HTTP/1.0 500 Internal Server Error');
	header('Content-Type: text/plain;charset=UTF-8');
	echo $tips;
	exit;
}

/*****禁止全英文评论*****/
if ( _thememee('check_comment_chinese') ) {
	function check_comment_chinese( $check ) {
		$pattern = '/[一-龥]/u';
		if ( !preg_match( $pattern, $check['comment_content'] ) ) {
			ajax_comment_error( '<span>您的评论中必须包含汉字!</span>' );
		}
		return( $check );
	}
	add_filter('preprocess_comment', 'check_comment_chinese');
}

/*****禁止含有链接的评论*****/
if ( _thememee('check_comment_link') ) {
	function check_comment_link( $check ) {
		if ( strpos( $check['comment_content'], 'http://' ) !== false || strpos( $check['comment_content'], 'https://' ) !== false || strpos( $check['comment_content'], 'www' ) !== false ||strpos( $check['comment_content'], '<a' ) !== false) {
			ajax_comment_error( '<span>您的评论中不能包含链接!</span>' );
		}
		return $check;
	}
	add_filter('preprocess_comment', 'check_comment_link');
}

/*****评论作者链接新窗口打开*****/
if ( _thememee('comment_author_link_specs') ){
	function comment_author_link_specs() {
		$url	= get_comment_author_url();
		$author = get_comment_author();
		if ( empty( $url ) || 'http://' == $url ) {
			return $author;
		} else {
			return "<a target='_blank' href='$url' rel='external nofollow' class='url'>$author</a>";
		}
	}
	add_filter( 'get_comment_author_link', 'comment_author_link_specs' );
}

/*****修复评论回复按钮链接*****/
global $wp_version;
if ( version_compare( $wp_version, '5.1.1', '>=' ) ) {
	function replace_comment_reply_link( $link, $args, $comment, $post ) {
		if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) {
			$link = sprintf(
				'<a rel="nofollow" class="comment-reply-login" href="%s">%s</a>',
				esc_url( wp_login_url( get_permalink() ) ),
				$args[ 'login_text' ]
			);
		} else {
			$onclick = sprintf(
				'return addComment.moveForm( "%1$s-%2$s", "%2$s", "%3$s", "%4$s" )',
				$args[ 'add_below' ],
				$comment->comment_ID,
				$args[ 'respond_id' ],
				$post->ID
			);
			$link = sprintf(
				"<a rel='nofollow' class='comment-reply-link' href='%s' onclick='%s' aria-label='%s'>%s</a>",
				esc_url( add_query_arg( 'replytocom', $comment->comment_ID, get_permalink( $post->ID ) ) ) . "#" . $args[ 'respond_id' ],
				$onclick,
				esc_attr( sprintf( $args[ 'reply_to_text' ], $comment->comment_author ) ),
				$args[ 'reply_text' ]
			);
		}
		return $link;
	}
	add_filter( 'comment_reply_link', 'replace_comment_reply_link', 10, 4 );
}

/*****评论回复添加@*****/
if ( _thememee('comment_reply_add_at') ){
	function comment_reply_add_at( $comment_text, $comment = '' ) {
		if ( $comment->comment_parent > 0) {
			$comment_text = '<a class="at" href="#comment-' . $comment->comment_parent . '">@ ' . get_comment_author( $comment->comment_parent ) . '： </a>' . $comment_text;
		}
		return $comment_text;
	}
	add_filter( 'comment_text' , 'comment_reply_add_at', 20, 2);
}

/*****搜索弹窗*****/
function get_search() {
	$html .= '<div class="search-form show"><div class="popup"><div class="box"><form method="get" action="' . get_option('home') . '" role="search"><input class="form-control" type="text" name="s" placeholder="Search…" required="required"></form></div>';
	$keyword = _thememee('search_keyword');
	if ( ! empty( $keyword ) ) {
		$key  = explode(',',$keyword);
		$html .= '<div class="key"><h1>热门搜索</h1><ul>';
		for ( $i=0; $i < count($key); $i++ ) {
			$html .= '<li><a href="' . get_option('home') . '/search/' . $key[$i] . '">' . $key[$i] . '</a></li>';
		}
		$html .= '</ul></div>';
	}
	$html .= '</div><div class="popup-close"><span></span><span></span></div></div>';
	return $html;
}

/*****修改搜索结果的链接*****/
function redirect_search() {
	if ( is_search() && !empty($_GET['s']) ) {
		wp_redirect( home_url("/search/").urlencode( get_query_var('s') ) );
		// 修改搜索结果的链接结构，例如：https://www.thememee.com/search/关键词
		exit();
	}
}
add_action('template_redirect', 'redirect_search' );

/*****搜索排除所有页面*****/
function search_filter_page($query) {
	if ( $query->is_search ) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','search_filter_page');

/*****搜索只有一篇文章时跳转到该文章*****/
function redirect_single_post() {
	if ( is_search() ) {
		global $wp_query;
		if ( $wp_query->post_count == 1 && $wp_query->max_num_pages == 1 ) {
			wp_redirect( get_permalink( $wp_query->posts[ '0' ]->ID ) );
			// 当搜索文章只有一篇时则跳转至该文章
			exit;
		}
	}
}
add_action( 'template_redirect', 'redirect_single_post' );

/*****面包屑导航*****/
if ( _thememee('breadcrumbs') ){
	function breadcrumbs() {
		$text['home']     = '<i class="iconfont icon-location"></i>首页'; 
		$text['category'] = '%s';
		$text['search']   = '%s';
		$text['tag']      = '%s';
		$text['author']   = '%s';
		$text['404']      = 'Error 404';
		$text['page']     = 'Page %s';
		$text['cpage']    = 'Comment Page %s';
		if ( is_category() || is_tax() ) {
			$category  = get_the_category()[0];
			$html      = '<div class="breadcrumbs"><span><a href="' . home_url('/') . '" class="home"><span>' . $text['home'] . '</span></a></span><span><i class="iconfont icon-right"></i></span><span>分类</span><span><i class="iconfont icon-right"></i></span><span>' . get_category_parents( $category->term_id, true, '' ) . '</span></div>';
		} else if ( is_search() ) {
			$html      = '<div class="breadcrumbs"><span><a href="' . home_url('/') . '" class="home"><span>' . $text['home'] . '</span></a></span><span><i class="iconfont icon-right"></i></span><span>搜索</span><span><i class="iconfont icon-right"></i></span><span>' .  sprintf($text['search'], get_search_query())  . '</span></div>';
		} else if ( is_single() && !is_attachment() ) {
			$category  = get_the_category()[0];
			$html      = '<div class="breadcrumbs"><span><a href="' . home_url('/') . '" class="home"><span>' . $text['home'] . '</span></a></span><span><i class="iconfont icon-right"></i></span><span>' . get_category_parents( $category->term_id, true, '' ) . '</span><span><i class="iconfont icon-right"></i></span><span>正文</span></div>';
		} else if ( is_tag() ) {
			$tag       = get_tag(get_queried_object_id());
			$html      = '<div class="breadcrumbs"><span><a href="' . home_url('/') . '" class="home"><span>' . $text['home'] . '</span></a></span><span><i class="iconfont icon-right"></i></span><span>标签</span><span><i class="iconfont icon-right"></i></span><span>' .  sprintf($text['tag'], single_tag_title('', false))  . '</span></div>';
		} else if ( is_author() ) {
			global $author;
			$author	   = get_userdata($author);
			$html      = '<div class="breadcrumbs"><span><a href="' . home_url('/') . '" class="home"><span>' . $text['home'] . '</span></a></span><span><i class="iconfont icon-right"></i></span><span>作者</span><span><i class="iconfont icon-right"></i></span><span>' .  sprintf( $text['author'], $author->nickname )  . '</span></div>';
		}
		return $html;
	}
}

/*****横幅背景*****/
function background() {
	if ( is_category() || is_tax() ) {
		$background = _thememee('background_category');
	} else if ( is_tag() ) {
		$background = _thememee('background_tag');
	} else if ( is_author() || is_single() ) {
		$background = _thememee('background_author');
	} else if ( is_search() ) {
		$background = _thememee('background_search');
	} else if ( is_page_template('template/archives.php') ) {
		$background = _thememee('background_archives');
	} else if ( is_page_template('template/links.php') ) {
		$background = _thememee('background_links');
	} else if ( is_page_template('template/tags.php') ) {
		$background = _thememee('background_tags');
	} else if ( is_page_template('template/sitemap.php') ) {
		$background = _thememee('background_sitemap');
	} else if ( is_page() ){
		$background = _thememee('background_full');
	}
	if ( is_tax() && !empty( taxonomy_image_url() ) ) {
		$src .= taxonomy_image_url();
	} else if ( is_page() && get_post_custom_values("thumb") ) {
		$src .= get_post_custom_values("thumb") [0];
	} else if ( $background['_random'] ) {
		$src .= $background['_path'] . mt_rand( 1, $background['_number'] ) . '.png';
	} else {
		$src .= $background['_image'];
	}
	return $src;
}

/*****移动端侧边栏背景*****/
function sidebar_background() {
	$background = _thememee('sidebar_background');
	if ( $background['_random'] ) {
		$src .= $background['_path'] . mt_rand( 1, $background['_number'] ) . '.png';
	} else {
		$src .= $background['_image'];
	}
	return $src;
}

/*****识别作者身份*****/
function author_level() {
	$author_id = get_post( get_the_ID() )->post_author;
	if ( user_can( $author_id, 'administrator' ) ) {
		echo '官方';
	}
	if ( user_can( $author_id, 'editor' ) ) {
		echo '编辑';
	}
	if ( user_can( $author_id, 'author' ) ) {
		echo '作者';
	}
	if ( user_can( $author_id, 'contributor' ) ) {
		echo '投稿者';
	}
	if ( user_can( $author_id, 'subscriber' ) ) {
		echo '订阅者';
	}
}

/*****获取作者评论数量*****/
function author_comments_count() {
	$author = get_the_author_meta( 'ID' );
	echo get_comments( array( 'count' => true, 'user_id' => $author ) );
}

/*****获取作者文章数量*****/
function author_posts_count() {
	$post = get_post();
	if ( ! $post ) {
		return 0;
	}
	return count_user_posts( $post->post_author, $type = 'post' );
}

/*****获取作者获赞数量*****/
function author_likes_count($display = true) {
	global $wpdb;
	$author = get_the_author_meta( 'ID' );
	$sql	= "SELECT SUM(meta_value+0) FROM $wpdb->posts left join $wpdb->postmeta on ($wpdb->posts.ID = $wpdb->postmeta.post_id) WHERE meta_key = 'likes' AND post_author =$author";
	$count  = intval( $wpdb->get_var( $sql ) );
	if ( $display ) {
		echo number_format_i18n( $count );
	} else {
		return $count;
	}
}