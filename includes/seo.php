<?php

if ( !function_exists('utf8Substr') ) {
	function utf8Substr($str, $start, $length){
		return preg_replace( '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}' . '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$length.'}).*#s', '$1', $str );
	}
}

function site_title() {
	global $s, $page, $paged, $post;
	if ( _thememee('separator') ) {
		$separator .=  ' '._thememee('separator').' ';
	} else {
		$separator .= ' - ';
	}
	if ( is_home() || is_front_page() ) {
		if ( $paged >= 2 || $page >= 2 ){
			$title .= get_bloginfo('name') .$separator . sprintf( __( '第%s页' ), max( $paged, $page ) ) .$separator .get_option('blogdescription');
		} else {
			$title .= get_bloginfo('name') .$separator .get_option('blogdescription');
		}
	} else if ( is_category() || is_tax() ){
		if ( get_term_meta( get_queried_object()->term_id, 'seo_title', true ) ){
			$title .= get_term_meta( get_queried_object()->term_id, 'seo_title', true ) .$separator .get_bloginfo('name');
		} else {
			$title .= single_cat_title() .$separator .get_bloginfo('name');
		}
	} else if ( is_single() || is_page() ) {
		if ( get_post_meta( $post->ID, 'seo_title', true ) ) {
			$title .= get_post_meta( $post->ID, 'seo_title', true ) .get_bloginfo('name');
		} else {
			$title .= trim( wp_title( '', 0 ) ) .$separator .get_bloginfo('name');
		}
	} else if ( is_author() ) {
		$title .= the_author_meta( 'nickname' ) .$separator .get_bloginfo('name');
	} else if ( is_search() ) {
		$title .= '关于“' .esc_html( $s, 1 ) .'”的搜索结果' .$separator .get_bloginfo('name');
	} else if ( is_tag() ) {
		$title .= single_tag_title() .$separator .get_bloginfo('name');
	} else if ( is_404() ) {
		$title .= '未找到页面' .$separator .get_bloginfo('name');
	}
	return $title;
}
function site_keywords() {
	global $s, $post;
	if ( is_home() || is_front_page() ) {
		if ( _thememee('seo')['keywords'] ){
			$keywords .= _thememee('seo')['keywords'];
		} else {
			$keywords .= get_bloginfo('name').','.get_option('blogdescription');
		}
	} else if ( is_single() ) {
		if ( get_post_meta( $post->ID, 'seo_key', true ) ){
			$keywords .= get_post_meta( $post->ID, 'seo_key', true );
		} else {
			if ( get_the_tags( $post->ID ) ) {
				foreach ( get_the_tags( $post->ID ) as $tag ) {
					$keywords[] .= $tag->name;
				}
				$keywords .= join( ",", $keywords);
			} else {
				foreach ( get_the_category( $post->ID ) as $category ) {
					$keywords[] .= $category->cat_name;
				}
				$keywords .= join( ",", $keywords);
			}
		}
	} else if ( is_page() ) {
		if ( get_post_meta( $post->ID, 'seo_key', true ) ){
			$keywords .= get_post_meta( $post->ID, 'seo_key', true );
		} else {
			$keywords .= trim( wp_title( '', 0 ) );
		}
	} else if (  is_category() || is_tax() ) {
		if ( get_term_meta( get_query_var('cat'), 'seo_keywords', true ) ){
			$keywords .= get_term_meta( get_query_var('cat'), 'seo_keywords', true );
		} else {
			$keywords .= single_cat_title();
		}
	} else if ( is_tag() ) {
		$keywords .= single_tag_title( '', false );
	} else if ( is_search() ) {
		$keywords .= esc_html( $s, 1 );
	} else if ( is_404() ) {
		$keywords .= '404，未找到页面';
	} else {
		$keywords .= trim( wp_title( '', false ) );
	}
	return $keywords;
}

function site_description() {
	global $s, $post;
	if ( is_home() || is_front_page() ) {
		if ( _thememee('seo')['description'] ){
			$description .= _thememee('seo')['description']; 
		} else {
			$description .= get_option('blogdescription');
		}
	} else if ( is_single() ) {
		if ( get_post_meta( $post->ID, 'seo_description', true ) ){
			$description .= get_post_meta( $post->ID, 'seo_description', true );
		} else {
			if ( preg_match( '/<p>(.*)<\/p>/iU', trim( strip_tags( $post->post_content, "<p>" ) ), $result ) ){
				$text .= $result['1'];
			} else {
				$text .= explode( "\n", trim( strip_tags( $post->post_content ) ) )['0'];
			}
			$description .= utf8Substr( $text, 0, 220 );
		}
	} else if ( is_page() ) {
		if ( get_post_meta( $post->ID, 'seo_description', true ) ){
			$description .= get_post_meta( $post->ID, 'seo_description', true );
		} else {
		    $description .= trim( wp_title( '', 0 ) );
		}
	} else if ( is_category() ) {
		if ( get_term_meta( get_query_var('cat'), 'seo_description', true ) ){
			$description .= get_term_meta( get_query_var('cat'), 'seo_description', true );
		} else if ( category_description() ){
			$description .= category_description();
		} else {
			$description .= single_cat_title();
		}
	} else if ( is_tag() ) {
		$description .= single_tag_title();
	} else if ( is_search() ) {
		$description .= '关于“' .esc_html( $s, 1 ) .'”的搜索结果';
	} else if ( is_404() ) {
		$description .= '404，未找到页面...';
	} else {
		$description .= get_bloginfo('name') . "'" . trim( wp_title('', false) ) . "'";
	}
	return $description;
}