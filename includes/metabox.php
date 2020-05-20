<?php

function thememee_metabox( $meta_boxes ) {

	// 文章扩展
	$meta_boxes[] = array(
		'id'         => 'standard',
		'title'      => __( '文章扩展', 'thememee' ),
		'post_types' => array( 'post' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			array(
				'type' => 'heading',
				'name' => __( '文章设置', 'thememee' ),
				'desc' => __( '文章基本选项，自由调用', 'thememee' ),
			),
			array(
				'name'  => __( '特色图像', 'thememee' ),
				'id'    => "thumb",
				'desc'  => __( '自定义缩略图URL', 'thememee' ),
				'type'  => 'text',
			),

			array(
				'name'    => __( '版权所有', 'thememee' ),
				'id'      => "cc",
				'type'    => 'button_group',
				'options' => array(
					'0' => __( '关闭', 'thememee' ),
					'1' => __( '原创', 'thememee' ),
					'2' => __( '转载', 'thememee' ),
				),
				'attributes' => array(
					'class'     => 'button',
				),
				'std'  		=> 0,
			),
			array(
				'name'  => __( '转载来源', 'thememee' ),
				'id'    => "source",
				'desc'  => __( '转载文章作者或平台名称', 'thememee' ),
				'type'  => 'text',
			),
			array(
				'name'  => __( '来源链接', 'thememee' ),
				'id'    => "source_url",
				'desc'  => __( '转载文章平台作者或文章链接', 'thememee' ),
				'type'  => 'text',
			),
		),
	);

	// SEO扩展
	$meta_boxes[] = array(
		'title' => __( 'SEO扩展', 'thememee' ),
		'post_types' => array( 'post', 'page' ),
		'fields' => array(
			array(
				'type' => 'heading',
				'name' => __( '自定义SEO', 'thememee' ),
				'desc' => __( '不设置将自动调取标题、关键词、描述等', 'thememee' ),
			),
			array(
				'name'  => __( '自定义标题', 'thememee' ),
				'id'    => "seo_title",
				'desc'  => __( '自定义SEO标题，不填写则默认调取标题', 'thememee' ),
				'type'  => 'text',
			),
			array(
				'name'  => __( '自定义关键词', 'thememee' ),
				'id'    => "seo_key",
				'desc'  => __( '自定义SEO关键词，多个关键词用英文逗号隔开，不填写则默认调取标签或者标题', 'thememee' ),
				'type'  => 'text',
			),
			array(
				'name' => __( '自定义描述', 'thememee' ),
				'desc' => __( '自定义SEO描述，不填写则默认调取内容指定截断的字数或者摘要', 'thememee' ),
				'id'   => "seo_description",
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
			),
		),
	);
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'thememee_metabox' );