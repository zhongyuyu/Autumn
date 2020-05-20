<?php 

session_start();

require( dirname(__FILE__) . '/../../../../wp-load.php' );

global $wpdb;

if( $_POST['action'] == 'popup.sidebar' ){
	$html .= '<div class="mobile-sidebar show"><div class="popup"><div class="sign"><div class="banner" style="background:url(' . sidebar_background() . ') center center / cover no-repeat"></div></div><div class="content"><div class="menu"><ul>';
	if( _thememee('sidebar_menu') ){
		foreach ( _thememee('sidebar_menu') as $key => $i ) {
			$html .= '<li><a href="' . $i['_url'] . '"><i class="' . $i['_icon'] . '"></i><span>' . $i['_text'] . '</span></a></li>';
		}
	} else if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('main') ) {
		$html .= str_replace("</ul></div>", "", preg_replace( "{<div[^>]*><ul[^>]*>}", "", wp_nav_menu( array('theme_location' => 'main', 'echo' => false) ) ) );
	}
	$html .= '</ul></div></div><div class="action"><a href="/wp-login.php">登录</a><a href="/wp-login.php?action=register">注册</a></div></div></div>';
	echo $html;
}

if ( $_POST['action'] == 'popup.search' ) {
	$html .= '<div class="search-form show"><div class="popup"><div class="box"><form method="get" action="' . get_option('home') . '" role="search"><span><i class="iconfont icon-search"></i></span><input class="form-control" type="text" name="s" placeholder="输入关键词搜索…" required="required"></form>';
	$keyword = _thememee('search_keyword');
	if( ! empty( $keyword ) ) {
		$key  = explode(',',$keyword);
		$html .= '<div class="key"><h1><i class="iconfont icon-hot"></i>热门搜索</h1><ul>';
		for ( $i=0; $i < count($key); $i++ ) {
			$html .= '<li><a href="' . get_option('home') . '/search/' . $key[$i] . '">' . $key[$i] . '</a></li>';
		}
		$html .= '</ul></div>';
	}
	$html .= '</div></div><div class="popup-close"><svg t="1584946321984" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2627" width="200" height="200"><path d="M511.686 33.418c-264.163 0-478.31 214.147-478.31 478.31s214.147 478.31 478.31 478.31c264.164 0 478.31-214.147 478.31-478.31s-214.147-478.31-478.31-478.31zM752.729 707.486c13.282 13.405 13.179 35.037-0.226 48.314s-35.037 13.178-48.317-0.227l-191.968-193.778-194.163 192.353c-13.405 13.279-35.037 13.177-48.314-0.228s-13.177-35.036 0.227-48.314l194.163-192.353-192.748-194.564c-13.279-13.404-13.177-35.037 0.228-48.314s35.036-13.177 48.314 0.228l192.748 194.564 194.178-192.365c13.408-13.279 35.038-13.177 48.316 0.228 13.28 13.404 13.177 35.037-0.227 48.314l-194.179 192.365 191.969 193.778z" fill="#CCCCCC" p-id="2628"></path></svg></div></div>';
	echo $html;
}

if ( $_POST['action'] == 'popup.notify' ) {
	$html .= '<div class="site-notify show"><div class="popup"><div class="heading">';
	if( _thememee('notify')['_heading'] ) {
		$html .= '<h1>' . _thememee('notify')['_heading'] . '</h1>';
	} else {
		$html .= '<h1>网站通知</h1>';
	}
	$html .= '</div><div class="content">' . _thememee('notify')['_content'] . '</div></div><div class="popup-close"><svg t="1584946321984" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2627" width="200" height="200"><path d="M511.686 33.418c-264.163 0-478.31 214.147-478.31 478.31s214.147 478.31 478.31 478.31c264.164 0 478.31-214.147 478.31-478.31s-214.147-478.31-478.31-478.31zM752.729 707.486c13.282 13.405 13.179 35.037-0.226 48.314s-35.037 13.178-48.317-0.227l-191.968-193.778-194.163 192.353c-13.405 13.279-35.037 13.177-48.314-0.228s-13.177-35.036 0.227-48.314l194.163-192.353-192.748-194.564c-13.279-13.404-13.177-35.037 0.228-48.314s35.036-13.177 48.314 0.228l192.748 194.564 194.178-192.365c13.408-13.279 35.038-13.177 48.316 0.228 13.28 13.404 13.177 35.037-0.227 48.314l-194.179 192.365 191.969 193.778z" fill="#CCCCCC" p-id="2628"></path></svg></div></div>';
	echo $html;
}

if ( $_POST['action'] == 'popup.contact' ) {
	$html .= '<div class="contact-wechat show"><div class="popup"><h1>微信扫一扫 关注公众号</h1>';
	if( _thememee('contact')['_wechat'] ) {
		$html .= '<img src="' . _thememee('contact')['_wechat'] . '" alt="微信扫一扫 关注公众号">';
	} else {
		$html .= '<img src="' . bloginfo('template_url') . '/qrcode/?url=' . bloginfo('url') . '" alt="微信扫一扫 关注公众号">';
	}
	$html .= '<span>在微信内长按二维码关注</span></div><div class="popup-close"><svg t="1584946321984" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2627" width="200" height="200"><path d="M511.686 33.418c-264.163 0-478.31 214.147-478.31 478.31s214.147 478.31 478.31 478.31c264.164 0 478.31-214.147 478.31-478.31s-214.147-478.31-478.31-478.31zM752.729 707.486c13.282 13.405 13.179 35.037-0.226 48.314s-35.037 13.178-48.317-0.227l-191.968-193.778-194.163 192.353c-13.405 13.279-35.037 13.177-48.314-0.228s-13.177-35.036 0.227-48.314l194.163-192.353-192.748-194.564c-13.279-13.404-13.177-35.037 0.228-48.314s35.036-13.177 48.314 0.228l192.748 194.564 194.178-192.365c13.408-13.279 35.038-13.177 48.316 0.228 13.28 13.404 13.177 35.037-0.227 48.314l-194.179 192.365 191.969 193.778z" fill="#CCCCCC" p-id="2628"></path></svg></div></div>';
	echo $html;
}

if ( $_POST['action'] == 'popup.share' ) {
	$html .= '<div class="share-wechat show"><div class="popup"><h1>微信扫一扫 分享朋友圈</h1><img src="' . THEME_URI . '/qrcode/?url=' . $_SERVER['HTTP_REFERER'] . '" alt="微信扫一扫 分享朋友圈"><span>在微信内点击<i class="iconfont icon-more"></i>分享</span></div><div class="popup-close"><svg t="1584946321984" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2627" width="200" height="200"><path d="M511.686 33.418c-264.163 0-478.31 214.147-478.31 478.31s214.147 478.31 478.31 478.31c264.164 0 478.31-214.147 478.31-478.31s-214.147-478.31-478.31-478.31zM752.729 707.486c13.282 13.405 13.179 35.037-0.226 48.314s-35.037 13.178-48.317-0.227l-191.968-193.778-194.163 192.353c-13.405 13.279-35.037 13.177-48.314-0.228s-13.177-35.036 0.227-48.314l194.163-192.353-192.748-194.564c-13.279-13.404-13.177-35.037 0.228-48.314s35.036-13.177 48.314 0.228l192.748 194.564 194.178-192.365c13.408-13.279 35.038-13.177 48.316 0.228 13.28 13.404 13.177 35.037-0.227 48.314l-194.179 192.365 191.969 193.778z" fill="#CCCCCC" p-id="2628"></path></svg></div></div>';
	echo $html;
}

die;

?>