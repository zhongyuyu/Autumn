<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo site_title(); ?></title>
<meta name="keywords" content="<?php echo site_keywords(); ?>">
<meta name="description" content="<?php echo site_description(); ?>">
<link rel="shortcut icon" href="<?php echo _thememee( 'favicon' ); ?>" type="image/x-icon" >
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<meta name="theme-color" content="#008c95"/>
<meta name="msapplication-navbutton-color" content="#008c95">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE; chrome=1">
<?php wp_head(); ?>
<link rel="canonical" href="<?php the_permalink(); ?>"/>
</head>
<body <?php body_class(); ?>>
<div class="header">
	<div class="container">
		<div class="logo">
			<a href="<?php bloginfo('url');?>" style="background: url(<?php echo _thememee('logo'); ?>) center center / contain no-repeat;"></a>
		</div>
		<div class="menu">
			<ul>
				<?php if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('main') ) { echo str_replace("</ul></div>", "", preg_replace( "{<div[^>]*><ul[^>]*>}", "", wp_nav_menu( array('theme_location' => 'main', 'echo' => false) ) ) ); ?>
				<?php } ?>
			</ul>
		</div>
		<div class="action">
			<a class="search tooltips-top" href="javascript:void(0)" data-title="搜索"><i class="iconfont icon-search"></i></a>
			<a class="notify tooltips-top" href="javascript:void(0)" data-title="通知"><i class="iconfont icon-notify"></i></a>
			<?php if ( is_user_logged_in() ) { global $current_user; ?>
			<a class="user tooltips-top" href="/wp-admin/" data-title="后台管理"><i class="iconfont icon-editor"></i></a>
			<?php } else { ?>
			<a class="sign tooltips-top" href="/wp-login.php" data-title="登录"><i class="iconfont icon-sign-in"></i></a>
			<?php } ?>
			<a class="to-top tooltips-top" href="javascript:void(0)" data-title="去顶部"><i class="iconfont icon-to-up"></i></a>
			<a class="to-bottom tooltips-top" href="javascript:void(0)" data-title="去底部"><i class="iconfont icon-to-down"></i></a>
		</div>
		<div class="button">
			<div class="open">
				<span class="line"></span>
				<span class="line"></span>
				<span class="line"></span>
			</div>
			<div class="search">
				<i class="iconfont icon-search"></i>
			</div>
		</div>
	</div>
</div>