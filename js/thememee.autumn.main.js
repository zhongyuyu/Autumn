jQuery(document).ready(function($) {

// 默认菜单
$('.menu .current-menu-ancestor.menu-item-has-children').addClass('active');
$(document).on('click', '.menu .menu-item-has-children>a', function(event) {
	$(this).siblings('.menu .sub-menu')[0] && (
		event.preventDefault(), 
		$(this).parent().hasClass('active') ? (
		$(this).parent().removeClass('active'), 
		$(this).parent().find('.active').removeClass('active'),
		$(this).parent().find('.sub-menu').stop(!0).slideUp(300)) : ($(this).closest('.active')[0] || (
			$(this).find('.menu-item-has-children.active .sub-menu').stop(!0).slideUp(300), 
			$(this).find('.menu-item-has-children.active').removeClass('active')
		), 
			$(this).parent().addClass('active'), 
			$(this).parent().siblings('.active').find('.sub-menu').stop(!0).slideUp(300), 
			$(this).parent().siblings('.current-menu-parent').find('.sub-menu').stop(!0).slideUp(300), 
			$(this).parent().siblings('.active').removeClass('active'), 
			$(this).siblings('.sub-menu').stop(!0).slideDown(300)
		)
	);
	if ( $('.menu .menu-item-has-children').hasClass('active') ) {
		$('.menu>ul>li.current-menu-item').addClass('inactive');
	} else {
		$('.menu>ul>li.current-menu-item').removeClass('inactive');
	}
});

// 修复页面加载时transition加载
$(window).on('load', function() {
	$('body').removeClass('loader');
});

// 手机菜单弹窗
$('.header .button .open').on('click', function () {
	$.post(
		_thememee.uri + "/action/popup.php",
		{
			action: 'popup.sidebar',
		},
		function(data) {
			$('body').append(data+'<div class="overlay"></div>').addClass('active');
		}
	);
});

// 网站通知弹窗
$('.header .notify').on('click', function () {
	$.post(
		_thememee.uri + "/action/popup.php",
		{
			action: 'popup.notify',
		},
		function(data) {
			$('body').append(data+'<div class="overlay"></div>').addClass('active');
		}
	);
});

// 文章搜索弹窗
$('.header .search').on('click', function () {
	$.post(
		_thememee.uri + "/action/popup.php",
		{
			action: 'popup.search',
		},
		function(data) {
			$('body').append(data+'<div class="overlay"></div>').addClass('active');
		}
	);
});

// 联系微信弹窗
$('.footer .content .contact .wechat').on('click', function () {
	$.post(
		_thememee.uri + "/action/popup.php",
		{
			action: 'popup.contact',
		},
		function(data) {
			$('body').append(data+'<div class="overlay"></div>').addClass('active');
		}
	);
});

// 分享微信弹窗
$('.single .share a.wechat').on('click', function () {
	$.post(
		_thememee.uri + "/action/popup.php",
		{
			action: 'popup.share',
		},
		function(data) {
			$('body').append(data+'<div class="overlay"></div>').addClass('active');
		}
	);
});

// 弹窗关闭
$(document).on('click', function(e) {
	if($(e.target).closest('.popup').length !== 0){
		return;
	}
	$('.show').removeClass('show').addClass('hide');
	setTimeout(function() {
		$('.hide').remove();
	}, 500)
	$('body').removeClass('active');
	$('.overlay').remove();
});

// 侧栏随动
$( '.sidebar' ).theiaStickySidebar( {
	additionalMarginTop: 30,
	additionalMarginBottom: 30
} );

// 去顶部
$('.to-top').on('click', function(){
	$('html,body').animate({
		scrollTop: 0
	}, 300)
})

// 去底部
$('.to-bottom').on('click', function(){
	$('html,body').animate({
		scrollTop: $('.footer').offset().top
	}, 300)
})

// 缩略图延迟加载
$('.article .thumbnail a, .single .related a, .sidebar .widget a').lazyload({
});

// 首页幻灯片
if ( $('.home .slide').length > 0 ) {
	$('.home .slide').owlCarousel({
		loop: !0,
		nav: !0,
		dots: !0,
		margin: 10,
		smartSpeed: 1000,
		autoplayHoverPause: !0,
		autoplay: 1000,
		navText:'',
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 1
			},
			1200: {
				items: 1
			},
			1550: {
				items: 1
			}
		}
	});
}

// 代码高亮
$(document).ready(function() {
	$('pre code').each(function(i, block) {
		hljs.highlightBlock(block);
	});
});

// 文章点赞
$('.single .action .like').on('click', function () {
	if ( $(this).hasClass('active') ) {
		error("您已经赞过啦 (´-ω-`)");
		return false;
	} else {
		$(this).addClass('active');
		$.post(
			_thememee.url+'/wp-admin/admin-ajax.php',
			{
				action: 'like',
				id: $(this).data('id'),
				like: $(this).data('action')
			},
			function(data) {
				$('.single .action .like span').html(data);
				$('.single .post .banner .meta ul li:last-child span').html(data);
				success("谢谢点赞 o(∩_∩)o");
			}
		);
		return false;
	}
});

// 文章分享
if($('.single .posts .content img:first').length ){
	_thememee.image = $('.single .posts .content img:first').attr('src')
}
var share = {
	url: document.URL,
	pic: _thememee.image,
	title: document.title || '',
	desc: $('meta[name="description"]').length ? $('meta[name="description"]').attr('content') : ''
}
$('.single .share a').on('click', function(){
	switch( $(this).data('share') ){
		case 'weibo':
			url = 'http://service.weibo.com/share/share.php?title='+share.title+'&url='+share.url+'&source=bookmark&pic='+share.pic;
			break;
		case 'qq':
			url = 'http://connect.qq.com/widget/shareqq/index.html?url='+share.url+'&desc='+share.desc+'&summary='+share.title+'&site=zeshlife&pics='+share.pic;
			break;
		case 'facebook':
			url = 'https://www.facebook.com/sharer/sharer.php?u='+share.url+'&picture='+share.pic;
			break;
		case 'twitter':
			url = 'https://twitter.com/intent/tweet?url='+share.url+'&text='+share.desc;
			break;
	}
	if( !$(this).attr('href') && !$(this).attr('target') ){
		$(this).attr('href', url).attr('target', '_blank');
	}
});

// 成功提示
var _success_tips
function success(message) {
	if( !message ) return false
	_success_tips && clearTimeout(_success_tips)
	if ( $(".message").length > 0 ) {
		$(".message").remove();
	}
	$('body').append('<div class="message success"><span>' + message + '</span></div>');
	_success_tips = setTimeout(function() {
		$('.message').remove();
	}, 3000)
}

// 错误提示
var _error_tips
function error(message) {
	if( !message ) return false
	_error_tips && clearTimeout(_error_tips)
	if ( $(".message").length > 0 ) {
		$(".message").remove();
	}
	$('body').append('<div class="message error"><span>' + message + '</span></div>');
	_error_tips = setTimeout(function() {
		$('.message').remove();
	}, 3000)
}

console.log('\n' + ' %c Autumn Designed by 中与雨 %c https://zhongyuyu.cn ' + '\n', 'color: #fadfa3; background: #030307; padding:5px 0;', 'background: #fadfa3; padding:5px 0;');

});