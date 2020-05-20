<?php if (!defined('ABSPATH')) {die;} // Cannot access directly.

$prefix = 'thememee_options';

// Create options
CSF::createOptions($prefix, array(
	'menu_title'  => '主题设置',
	'menu_slug'   => 'codestar-options',
));

// 基本设置
CSF::createSection($prefix, array(
	'id'          => 'general',
	'title'	      => '基本设置',
	'icon'		  => 'fa fa-cog',
	'description' => '基本设置',
));

CSF::createSection($prefix, array(
	'parent'       => 'general',
	'title'        => '基本设置',
	'icon'         => 'fa fa-long-arrow-right',
	'description'  => '基本设置',
	'fields'       => array(
		array(
			'id'           => 'logo',
			'type'         => 'upload',
			'title'        => 'Logo',
			'desc'         => '输入网站Logo文件URL',
			'default'      => 'https://img.2tu.xyz/logo.png',
		),
		array(
			'id'           => 'favicon',
			'type'         => 'upload',
			'title'        => 'Favicon',
			'desc'         => '输入网站Favicon文件URL',
			'default'      => 'https://img.2tu.xyz/favicon.ico',
		),
		array(
			'id'           => 'gray_skin',
			'type'         => 'switcher',
			'title'        => '网站变灰',
			'label'        => '使网站变灰，支持IE、Chrome，基本上覆盖了大部分用户，不会降低访问速度',
			'default'      => false,
		),
		array(
			'id'           => 'avatar',
			'type'         => 'upload',
			'title'        => '默认头像',
			'desc'         => '自定义默认头像。',
			'default'      => 'https://img.2tu.xyz/avatar.png',
		),
		array(
			'id'           => 'admin_name',
			'type'         => 'text',
			'title'        => '管理员的称号',
			'desc'         => '设置管理员的称号，默认为 【官方】',
			'default'      => '官方',
		),
		array(
			'id'           => 'thumbnail_random',
			'type'         => 'switcher',
			'title'        => '随机缩略图',
			'label'        => '启用后将随机加载默认缩略图',
			'default'      => true,
		),
		array(
			'id'           => 'thumbnail_default',
			'type'         => 'upload',
			'title'        => '默认缩略图',
			'desc'         => '请上传一个默认文章缩略图的图片文件或输入文件URL',
			'default'      => 'https://img.2tu.xyz/thumbnail.png',
			'dependency'   => array( 'thumbnail_random', '==', 'false' ),
		),
		array(
			'id'           => 'thumbnail_path',
			'type'         => 'upload',
			'title'        => '随机图片目录',
			'desc'         => '请输入默认随机缩略图目录',
			'default'      => 'https://img.2tu.xyz/random/',
			'dependency'   => array( 'thumbnail_random', '==', 'true' ),
		),
		array(
			'id'           => 'thumbnail_number',
			'type'         => 'text',
			'title'        => '随机图片数量',
			'desc'         => '请输入默认缩略图随机数量',
			'default'      => '10',
			'dependency'   => array( 'thumbnail_random', '==', 'true' ),
		),
		array(
			'id'           => 'lazyload',
			'type'         => 'switcher',
			'title'        => '缩略图延迟加载',
			'label'        => '启用后图片将延迟加载',
			'default'      => true,
		),
		array(
			'id'           => 'lazyload_thumbnail',
			'type'         => 'upload',
			'title'        => '延迟加载缩略图',
			'desc'         => '请上传一个默认延迟加载缩略图的图片文件或输入文件URL',
			'default'      => 'https://img.2tu.xyz/lazyload/thumbnail.png',
			'dependency'   => array( 'lazyload', '==', 'true' ),
		),
	),
));

CSF::createSection($prefix, array(
	'parent'       => 'general',
	'title'        => '网站弹窗',
	'icon'         => 'fa fa-long-arrow-right',
	'description'  => '网站弹窗',
	'fields'       => array(
		array(
			'id'           => 'search_keyword',
			'type'         => 'text',
			'title'        => '热门搜索',
			'desc'         => '热门搜索关键词，以英文逗号隔开',
			'default'      => 'WordPress,Autumn,中与雨,QQ:20708998',
 			'attributes'   => array( 'style' => 'width: 100%;' ),
		),
		array(
			'id'           => 'notify',
			'type'         => 'fieldset',
			'title'        => '通知设置',
			'fields'       => array(
				array(
					'id'           => '_heading',
					'type'         => 'text',
					'title'        => '标题',
					'desc'         => '输入您的网站通知标题',
					'default'      => '网站通知',
 					'attributes'   => array( 'style' => 'width: 100%;' ),
				),
				array(
					'id'           => '_content',
					'type'         => 'textarea',
					'title'        => '内容',
					'desc'         => '输入您的网站通知内容',
					'default'      => 'ThemeMee致力于为国内外中小站长提供方便快捷的WordPress建站服务体验！',
				),
			),
		),
	),
));

CSF::createSection($prefix, array(
	'parent'       => 'general',
	'title'        => '自定义代码',
	'icon'         => 'fa fa-long-arrow-right',
	'description'  => '自定义代码',
	'fields'       => array(
		array(
			'id'           => 'css',
			'type'         => 'textarea',
			'title'        => '自定义CSS代码',
			'default'      => '',
		),
		array(
			'id'           => 'javascript',
			'type'         => 'textarea',
			'title'        => '自定义JavaScript代码',
			'default'      => '',
		),
		array(
			'id'           => 'statistics',
			'type'         => 'textarea',
			'title'        => '网站统计代码',
			'subtitle'     => '如百度统计、CNZZ、Google Analytics，不填则不显示',
			'default'      => '',
		),
	),
));

CSF::createSection($prefix, array(
	'id'          => 'mobile',
	'title'	      => '移动设置',
	'icon'		  => 'fa fa-mobile-alt',
	'description' => '移动设置',
));

CSF::createSection($prefix, array(
	'parent'       => 'mobile',
	'title'        => '侧栏设置',
	'icon'         => 'fa fa-long-arrow-right',
	'description'  => '侧栏设置',
	'fields'       => array(
		array(
			'id'           => 'sidebar_background',
			'type'         => 'fieldset',
			'title'        => '背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
		array(
			'id'           => 'sidebar_menu',
			'type'         => 'repeater',
			'title'        => '菜单',
			'fields'	   => array(
				array(
					'id'           => '_text',
					'type'         => 'text',
					'title'        => '文本',
				),
				array(
					'id'           => '_url',
					'type'         => 'text',
					'title'        => '链接',
				),
				array(
					'id'           => '_icon',
					'type'         => 'icon',
					'title'        => '图标',
				),
			),
		),
	),
));

// 功能优化
CSF::createSection($prefix, array(
	'title'        => '网站优化',
	'icon'         => 'fa fa-envira',
	'description'  => '网站优化',
	'fields'       => array(
		array(
			'id'           => 'seo',
			'type'         => 'fieldset',
			'title'        => 'SEO设置',
			'fields'       => array(
				array(
					'id'           => 'keywords',
					'type'         => 'text',
					'title'        => '网站关键词',
					'desc'         => '输入您的网站关键词，以英文逗号隔开。',
					'default'      => 'ThemeMee,主题迷,WordPress主题开发,WordPress原创主题,高端主题定制',
 					'attributes'   => array( 'style' => 'width: 100%;' ),
				),
				array(
					'id'           => 'description',
					'type'         => 'textarea',
					'title'        => '网站描述',
					'desc'         => '输入您的网站描述，一般不超过200字符',
					'default'      => 'ThemeMee致力于为国内外中小站长提供方便快捷的WordPress建站服务体验！',
				),
			),
		),
		array(
			'id'           => 'separator',
			'type'         => 'text',
			'title'        => '网站标题连接符',
			'desc'         => '一经选择，切勿更改，对SEO不友好，一般为“-”或“_”',
			'default'      => '-',
		),
		array(
			'id'           => 'breadcrumbs',
			'type'         => 'switcher',
			'title'        => '面包屑导航',
			'label'        => '显示在博客文章页面及分类列表页面中',
			'default'      => true,
		),
		array(
			'id'           => 'add_trailingslashit',
			'type'         => 'switcher',
			'title'        => '分类结尾添加斜杠',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'no_category_base_refresh_rules',
			'type'         => 'switcher',
			'title'        => '移除Category别名',
			'label'        => '默认开启',
			'default'      => true,
		),
	),
));

// 布局模块
CSF::createSection($prefix, array(
	'id'          => 'layout',
	'title'	      => '布局模块',
	'icon'		  => 'fa fa-cube',
	'description' => '布局模块',
));

CSF::createSection($prefix, array(
	'parent'       => 'layout',
	'title'        => '基本设置',
	'icon'         => 'fa fa-long-arrow-right',
	'description'  => '基本设置',
	'fields'       => array(
		array(
			'id'           => 'post_hide',
			'type'         => 'text',
			'title'        => '首页隐藏文章',
			'desc'         => '输入首页要隐藏文章的分类ID，以英文逗号隔开',
		),
        array(
			'id'           => 'module_category',
			'type'         => 'select',
			'title'        => '首页分类模块',
			'desc'         => '选择分类，分类下至少有三篇文章，不然不美观',
			'chosen'       => true,
			'multiple'     => true,
			'options'      => 'categories',
		),
		array(
			'id'           => 'module_copyright',
			'type'         => 'textarea',
			'title'        => '页脚版权模块',
			'desc'         => '显示在网站底部，请按照默认代码格式填写或删除，不懂代码的请不要随意更改，会造成错位',
			'default'      => '<span>© 2020 <a href="https://zhongyuyu.cn">中与雨</a> 保留所有权利.</span><span><a href="http://www.beian.miit.gov.cn/" target="_blank">皖ICP备16025017</a></span><span><a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=34019102000280" target="_blank"><img src="https://img.2tu.xyz/beian.png" alt="皖公网安备 34019102000280号" /><span>皖公网安备 34019102000280号</span></a></span>',
		),
		array(
			'id'           => 'module_contact',
			'type'         => 'switcher',
			'title'        => '页脚联系模块',
			'label'        => '显示在页脚底部',
			'default'      => true,
		),
		array(
			'id'           => 'contact',
			'type'         => 'fieldset',
			'title'        => '联系方式',
			'desc'         => '显示在网站底部，不填则不显示',
			'fields'	   => array(
				array(
					'id'           => '_weibo',
					'type'         => 'text',
					'title'        => '微博',
					'default'      => 'https://weibo.com/577550382',
 					'attributes'   => array( 'style' => 'width: 100%;' ),
				),
				array(
					'id'           => '_wechat',
					'type'         => 'upload',
					'title'        => '微信',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/wechat.png',
				),
				array(
					'id'           => '_qq',
					'type'         => 'text',
					'title'        => 'QQ',
					'default'      => '799193085',
 					'attributes'   => array( 'style' => 'width: 100%;' ),
				),
				array(
					'id'           => '_email',
					'type'         => 'text',
					'title'        => '邮箱',
					'default'      => 'admin@thememee.com',
 					'attributes'   => array( 'style' => 'width: 100%;' ),
				),
				array(
					'id'           => '_zcool',
					'type'         => 'text',
					'title'        => '站酷',
					'default'      => '',
 					'attributes'   => array( 'style' => 'width: 100%;' ),
				),
				array(
					'id'           => '_facebook',
					'type'         => 'text',
					'title'        => 'Facebook',
					'default'      => '',
 					'attributes'   => array( 'style' => 'width: 100%;' ),
				),
				array(
					'id'           => '_twitter',
					'type'         => 'text',
					'title'        => 'Twitter',
					'default'      => '',
 					'attributes'   => array( 'style' => 'width: 100%;' ),
				),
				array(
					'id'           => '_github',
					'type'         => 'text',
					'title'        => 'Github',
					'default'      => 'https://github.com/zhongyuyu',
 					'attributes'   => array( 'style' => 'width: 100%;' ),
				),
			),
			'dependency'   => array( 'module_contact', '==', 'true' ),
		),

	),
));

CSF::createSection($prefix, array(
	'parent'       => 'layout',
	'title'        => '幻灯轮播',
	'icon'         => 'fa fa-long-arrow-right',
	'description'  => '幻灯轮播',
	'fields'       => array(
		array(
			'id'           => 'slide',
			'type'         => 'repeater',
			'title'        => '首页幻灯片',
			'fields'	   => array(
				array(
					'id'           => '_title',
					'type'         => 'text',
					'title'        => '标题',
					'default'      => 'ThemeMee',
				),
				array(
					'id'           => '_desc',
					'type'         => 'text',
					'title'        => '描述',
					'default'      => '用户成就了我们，我们为用户创造价值！',
				),
				array(
					'id'           => '_img',
					'type'         => 'upload',
					'title'        => '上传幻灯片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
				),
				array(
					'id'           => '_blank',
					'type'         => 'switcher',
					'title'        => '新窗口打开链接',
					'default'      => true,
				),
				array(
					'id'           => '_href',
					'type'         => 'text',
					'title'        => '链接地址',
					'default'      => '#',
				),
			),
			'default'      => array(
				array(
					'_title'       => 'ThemeMee',
					'_desc'        => '用户成就了我们，我们为用户创造价值！',
					'_img'         => 'https://img.2tu.xyz/slide/1.png',
					'_blank'       => true,
					'_href'        => 'https://zhongyuyu.cn/',
				),
				array(
					'_title'       => 'Autumn',
					'_desc'        => 'WordPress Free Personal Blog Theme',
					'_img'         => 'https://img.2tu.xyz/slide/2.png',
					'_blank'       => true,
					'_href'        => 'https://zhongyuyu.cn/autumn.html',
				),
				array(
					'_title'       => 'FAQ',
					'_desc'        => 'Autumn主题常见问题！',
					'_img'         => 'https://img.2tu.xyz/slide/3.png',
					'_blank'       => true,
					'_href'        => 'https://zhongyuyu.cn/tag/autumn/',
				),
			),
		),
	),
));

// 列表设置
CSF::createSection($prefix, array(
	'id'          => 'list',
	'title'	      => '列表设置',
	'icon'		  => 'fa fa-bars',
	'description' => '列表设置',
));

CSF::createSection($prefix, array(
	'parent'       => 'list',
	'title'        => '背景设置',
	'icon'         => 'fa fa-long-arrow-right',
	'description'  => '背景设置',
	'fields'       => array(
		array(
			'id'           => 'background_category',
			'type'         => 'fieldset',
			'title'        => '分类页面背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
		array(
			'id'           => 'background_tag',
			'type'         => 'fieldset',
			'title'        => '标签页面背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
		array(
			'id'           => 'background_search',
			'type'         => 'fieldset',
			'title'        => '搜索页面背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
		array(
			'id'           => 'background_author',
			'type'         => 'fieldset',
			'title'        => '作者页面背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
	),
));

// 文章设置
CSF::createSection($prefix, array(
	'id'           => 'post',
	'title'        => '文章设置',
	'icon'         => 'fa fa-circle',
	'description'  => '文章设置',
	'fields'       => array(
		array(
			'id'           => 'fancybox',
			'type'         => 'switcher',
			'title'        => '图片灯箱',
			'label'        => '开启后，文章中的图片点击都将是弹窗显示。',
			'default'      => true,
		),
		array(
			'id'           => 'post_tags',
			'type'         => 'switcher',
			'title'        => '文章标签',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'post_likes',
			'type'         => 'switcher',
			'title'        => '文章点赞',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'post_copyright',
			'type'         => 'switcher',
			'title'        => '文章版权',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'post_share',
			'type'         => 'switcher',
			'title'        => '文章分享',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'post_nav',
			'type'         => 'switcher',
			'title'        => '文章导航',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'post_prev',
			'type'         => 'upload',
			'title'        => '文章上一篇背景图',
			'desc'         => '请上传一个文章页上一篇默认的背景图片或输入图片URL',
			'default'      => 'https://img.2tu.xyz/prev.png',
			'dependency'   => array( 'post_nav', '==', 'true' ),
		),
		array(
			'id'           => 'post_next',
			'type'         => 'upload',
			'title'        => '文章下一篇背景图',
			'desc'         => '请上传一个文章页下一篇默认的背景图片或输入图片URL',
			'default'      => 'https://img.2tu.xyz/next.png',
			'dependency'   => array( 'post_nav', '==', 'true' ),
		),
		array(
			'id'           => 'post_related',
			'type'         => 'switcher',
			'title'        => '相关文章',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'post_related_number',
			'type'         => 'text',
			'title'        => '相关文章数量',
			'desc'         => '默认6篇，建议填写3的倍数',
			'default'      => '6',
		),
		array(
			'id'           => 'check_comment_chinese',
			'type'         => 'switcher',
			'title'        => '禁止全英文评论',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'check_comment_link',
			'type'         => 'switcher',
			'title'        => '禁止含有链接的评论',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'comment_reply_add_at',
			'type'         => 'switcher',
			'title'        => '评论回复添加@',
			'label'        => '默认开启',
			'default'      => true,
		),
		array(
			'id'           => 'comment_author_link_specs',
			'type'         => 'switcher',
			'title'        => '评论作者链接新标签页打开',
			'label'        => '默认开启',
			'default'      => true,
		),
	),
));

// 页面设置
CSF::createSection($prefix, array(
	'id'          => 'page',
	'title'	      => '页面设置',
	'icon'		  => 'fa fa-pagelines',
	'description' => '页面设置',
));

CSF::createSection($prefix, array(
	'parent'       => 'page',
	'title'        => '背景设置',
	'icon'         => 'fa fa-long-arrow-right',
	'description'  => '背景设置',
	'fields'       => array(
		array(
			'id'           => 'background_full',
			'type'         => 'fieldset',
			'title'        => '全宽页面背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
		array(
			'id'           => 'background_archives',
			'type'         => 'fieldset',
			'title'        => '年度归档背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
		array(
			'id'           => 'background_links',
			'type'         => 'fieldset',
			'title'        => '友情链接背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
		array(
			'id'           => 'background_tags',
			'type'         => 'fieldset',
			'title'        => '热门标签背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
		array(
			'id'           => 'background_sitemap',
			'type'         => 'fieldset',
			'title'        => '网站地图背景',
			'fields'	   => array(
				array(
					'id'           => '_random',
					'type'         => 'switcher',
					'title'        => '背景随机',
					'label'        => '启用后将随机加载默认背景图',
					'default'      => true,
				),
				array(
					'id'           => '_path',
					'type'         => 'upload',
					'title'        => '目录',
					'desc'         => '请输入默认随机背景图片目录',
					'default'      => 'https://img.2tu.xyz/random/',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_number',
					'type'         => 'text',
					'title'        => '数量',
					'desc'         => '请输入默认背景图片随机数量',
					'default'      => '10',
					'dependency'   => array( '_random', '==', 'true' ),
				),
				array(
					'id'           => '_image',
					'type'         => 'upload',
					'title'        => '背景图片',
					'library'      => 'image',
					'default'      => 'https://img.2tu.xyz/banner.png',
					'dependency'   => array( '_random', '==', 'false' ),
				),
			),
		),
	),
));

// SMTP设置
CSF::createSection($prefix, array(
	'title'        => '邮件配置',
	'icon'         => 'fa fa-envelope',
	'description'  => '邮件配置',
	'fields'       => array(
		array(
			'id'           => 'mail_smtps',
			'type'         => 'switcher',
			'title'        => '是否启用SMTP服务',
			'label'        => '该设置主题自带，不能与插件重复开启',
			'default'      => true,
		),
		array(
			'id'           => 'mail_name',
			'type'         => 'text',
			'title'        => '发信邮箱',
			'subtitle'     => '请填写发件人邮箱帐号',
			'default'      => 'admin@thememee.com',
			'validate'     => 'csf_validate_email',
		),
		array(
			'id'           => 'mail_nicname',
			'type'         => 'text',
			'title'        => '发信人昵称',
			'default'      => 'ThemeMee',
		),
		array(
			'id'           => 'mail_host',
			'type'         => 'text',
			'title'        => '邮件服务器',
			'default'      => 'smtp.exmail.qq.com',
		),
		array(
			'id'           => 'mail_port',
			'type'         => 'text',
			'title'        => '服务器端口',
			'default'      => '465',
		),
		array(
			'id'           => 'mail_password',
			'type'         => 'text',
			'title'        => '邮箱密码',
			'default'      => '88888888',
		),
		array(
			'id'           => 'mail_smtpauth',
			'type'         => 'switcher',
			'title'        => '启用SMTPAuth服务',
			'default'      => true,
		),
		array(
			'id'           => 'mail_smtpsecure',
			'type'         => 'text',
			'title'        => 'SMTPSecure设置',
			'default'      => 'ssl',
		),
	),
));

// 广告设置
CSF::createSection($prefix, array(
	'title'        => '广告设置',
	'icon'         => 'fa fa-legal',
	'fields'       => array(
		array(
			'id'           => 'ad_pc_list',
			'type'         => 'textarea',
			'title'        => 'ＰＣ端广告 - 文章列表',
			'default'      => '<a href="https://zhongyuyu.cn/autumn" target="_blank"><img src="https://img.2tu.xyz/ad/1.png" alt="Autumn - WordPress Free Personal Blog Theme" /></a>',
		),
		array(
			'id'           => 'ad_pc_list_location',
			'type'         => 'text',
			'title'        => 'ＰＣ端广告 - 文章列表 - 位置',
			'default'      => '3',
		),
		array(
			'id'           => 'ad_pc_post',
			'type'         => 'textarea',
			'title'        => 'ＰＣ端广告 - 文章下方',
			'default'      => '<a href="https://zhongyuyu.cn/autumn" target="_blank"><img src="https://img.2tu.xyz/ad/1.png" alt="Autumn - WordPress Free Personal Blog Theme" /></a>',
		),
		array(
			'id'           => 'ad_mobile_list',
			'type'         => 'textarea',
			'title'        => '移动端广告 - 文章列表',
			'default'      => '<a href="https://zhongyuyu.cn/autumn" target="_blank"><img src="https://img.2tu.xyz/ad/1.png" alt="Autumn - WordPress Free Personal Blog Theme" /></a>',
		),
		array(
			'id'           => 'ad_mobile_list_location',
			'type'         => 'text',
			'title'        => '移动端广告 - 文章列表 - 位置',
			'default'      => '3',
		),
		array(
			'id'           => 'ad_mobile_post',
			'type'         => 'textarea',
			'title'        => '移动端广告 - 文章下方',
			'default'      => '<a href="https://zhongyuyu.cn/autumn" target="_blank"><img src="https://img.2tu.xyz/ad/1.png" alt="Autumn - WordPress Free Personal Blog Theme" /></a>',
		),
	),
));

// 网站备份
CSF::createSection($prefix, array(
	'title'        => '备份恢复',
	'icon'         => 'fa fa-shield',
	'description'  => '备份-恢复您的主题设置，方便迁移快速复刻网站</a>',
	'fields'       => array(
		array(
			'type'         => 'backup',
		),
	),
));