<?php

// Taxonomy
function thememee_taxonomy() {
	$taxonomies = get_taxonomies();
	if ( is_array($taxonomies) ) {
		$options = get_option('options');
		if ( !is_array($options) ) {
			$options = array();
		}
		if ( empty( $options['excluded_taxonomies'] ) ) {
			$options['excluded_taxonomies'] = array();
		}
		foreach ( $taxonomies as $taxonomy ) {
			if ( in_array( $taxonomy, $options['excluded_taxonomies'] ) ) {
				continue;
			}
			add_action( $taxonomy.'_add_form_fields', 'taxonomy_add_image_field' );
			add_action( $taxonomy.'_edit_form_fields', 'taxonomy_edit_image_field' );
			add_filter( 'manage_edit-' . $taxonomy . '_columns', 'taxonomy_columns' );
			add_filter( 'manage_' . $taxonomy . '_custom_column', 'taxonomy_column', 10, 3 );
        }
    }
}
add_action('admin_init', 'thememee_taxonomy');

// Taxonomy：自定义样式
function add_style() {
	echo '<style type="text/css" media="screen">th.column-thumb {width:60px}.form-field img.taxonomy-image {border:1px solid #eee;max-width:300px;max-height:300px}.inline-edit-row fieldset .thumb label span.title {width:48px;height:48px;border:1px solid #eee;display:inline-block}.column-thumb span {width:48px;height:48px;border:1px solid #eee;display:inline-block}.inline-edit-row fieldset .thumb img,.column-thumb img {width:48px;height:48px} </style>';
}

// Taxonomy：添加图像字段
function taxonomy_add_image_field() {
	if ( get_bloginfo('version') >= 3.5 ) {
		wp_enqueue_media();
	} else {
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
	}
	echo '<div class="form-field"><label for="taxonomy_image">' . __( '图像', 'thememee' ) . '</label><input type="text" name="taxonomy_image" id="taxonomy_image" value="" /><br/><button class="upload_image_button button">' . __( '上传/添加图像', 'thememee' ) . '</button></div>'.script();
}

// Taxonomy：编辑图像字段
function taxonomy_edit_image_field( $taxonomy ) {
	if ( get_bloginfo('version') >= 3.5 ) {
		wp_enqueue_media();
	} else {
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
    }
	if ( taxonomy_image_url( $taxonomy->term_id, NULL, TRUE ) == taxonomy_image_placeholder ) {
		$image_url = "";
	} else {
        $image_url = taxonomy_image_url( $taxonomy->term_id, NULL, TRUE );
    }
	echo '<tr class="form-field"><th scope="row" valign="top"><label for="taxonomy_image">' . __( '图像', 'thememee' ) . '</label></th><td><img class="taxonomy-image" src="' . taxonomy_image_url( $taxonomy->term_id, 'medium', TRUE ) . '" style="width:50%"/><br/><input type="text" name="taxonomy_image" id="taxonomy_image" value="'.$image_url.'" /><br /><button class="upload_image_button button">' . __( '上传/添加图像', 'thememee' ) . '</button><button class="remove_image_button button">' . __( '删除图像', 'thememee' ) . '</button></td></tr>'.script();
}

// Taxonomy：使用WordPress上传
function script() {
	return '<script type="text/javascript">
		jQuery(document).ready(function($) {
			var wordpress_ver = "'.get_bloginfo("version").'", upload_button;
			$(".upload_image_button").click(function(event) {
				upload_button = $(this);
				var frame;
				if (wordpress_ver >= "3.5") {
					event.preventDefault();
					if (frame) {
						frame.open();
						return;
					}
					frame = wp.media();
					frame.on( "select", function() {
						// Grab the selected attachment.
						var attachment = frame.state().get("selection").first();
						frame.close();
						if (upload_button.parent().prev().children().hasClass("tax_list")) {
							upload_button.parent().prev().children().val(attachment.attributes.url);
							upload_button.parent().prev().prev().children().attr("src", attachment.attributes.url);
						}
						else
						$("#taxonomy_image").val(attachment.attributes.url);
					});
					frame.open();
				} else {
					tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
					return false;
				}
			});

			$(".remove_image_button").click(function() {
				$(".taxonomy-image").attr("src", "'.taxonomy_image_placeholder.'");
				$("#taxonomy_image").val("");
				$(this).parent().siblings(".title").children("img").attr("src","' . taxonomy_image_placeholder . '");
				$(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
				return false;
			});
            
			if (wordpress_ver < "3.5") {
				window.send_to_editor = function(html) {
					imgurl = $("img",html).attr("src");
					if (upload_button.parent().prev().children().hasClass("tax_list")) {
						upload_button.parent().prev().children().val(imgurl);
						upload_button.parent().prev().prev().children().attr("src", imgurl);
					}
					else
						$("#taxonomy_image").val(imgurl);
					tb_remove();
				}
			}

			$(".editinline").click(function() { 
				var tax_id = $(this).parents("tr").attr("id").substr(4);
				var thumb = $("#tag-"+tax_id+" .thumb img").attr("src");
				if (thumb != "' . taxonomy_image_placeholder . '") {
					$(".inline-edit-col :input[name=\'taxonomy_image\']").val(thumb);
				} else {
					$(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
				}
				$(".inline-edit-col .title img").attr("src",thumb);
			});
		});
	</script>';
}

// Taxonomy：保存图像
function taxonomy_image_save( $term_id ) {
	if ( isset( $_POST['taxonomy_image'] ) ) {
		update_option('image'.$term_id, $_POST['taxonomy_image'], NULL);
	}
}
add_action('edit_term','taxonomy_image_save');
add_action('create_term','taxonomy_image_save');

// Taxonomy：附件ＩＤ
function taxonomy_attachment_id( $image_src ) {
	global $wpdb;
	$query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src);
	$id = $wpdb->get_var($query);
	return (!empty($id)) ? $id : NULL;
}

// Taxonomy：获取分类图像网址
function taxonomy_image_url( $term_id = NULL, $size = 'full', $return_placeholder = FALSE ) {
	if (!$term_id) {
		if (is_category()) {
			$term_id = get_query_var('cat');
		} else if (is_tag()) {
			$term_id = get_query_var('tag_id');
		} else if (is_tax()) {
			$current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			$term_id = $current_term->term_id;
		}
	}
	$image_url = get_option('image'.$term_id);
	if ( !empty($image_url) ) {
		$attachment_id = taxonomy_attachment_id($image_url);
		if ( !empty($attachment_id) ) {
			$image_url = wp_get_attachment_image_src($attachment_id, $size);
			$image_url = $image_url[0];
		}
	}
	if ( $return_placeholder ) {
		return ($image_url != '') ? $image_url : taxonomy_image_placeholder;
	} else {
		return $image_url;
	}
}

// Taxonomy：快速编辑
function taxonomy_quick_edit( $column_name, $screen, $name ) {
	if ($column_name == 'thumb') {
		echo'<fieldset><div class="thumb inline-edit-col"><label><span class="title"><img src="" alt="缩略图"/></span><span class="input-text-wrap"><input type="text" name="taxonomy_image" value="" class="tax_list" /></span><span class="input-text-wrap"><button class="upload_image_button button">' . __( '上传/添加图像', 'thememee' ) . '</button><button class="remove_image_button button">' . __( '删除图像', 'thememee' ) . '</button></span></label></div></fieldset>';
	}
}

// Taxonomy：分类列表名称
function taxonomy_columns( $columns ) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumb'] = __( '图像', 'thememee' );
	unset( $columns['cb'] );
	return array_merge( $new_columns, $columns );
}

// Taxonomy：分类列表缩略图
function taxonomy_column( $columns, $column, $id ) {
	if ( $column == 'thumb' ) {
		$columns = '<span><img src="' . taxonomy_image_url($id, 'thumbnail', TRUE) . '" alt="' . __('缩略图', 'thememee') . '" class="wp-post-image" /></span>';
    }
	return $columns;
}

// Taxonomy：分类列表设置图像样式
if ( strpos( $_SERVER['SCRIPT_NAME'], 'edit-tags.php' ) > 0 ) {
	add_action( 'admin_head', 'add_style' );
	add_action('taxonomy_quick_edit', 'taxonomy_quick_edit', 10, 3);
}

// Taxonomy：默认图像占位符
define('taxonomy_image_placeholder',"https://image.zhongyuyu.cn/placeholder.png");

// Taxonomy：添加SEO字段
function taxonomy_add_seo_field() {
	wp_nonce_field( basename( __FILE__ ), 'seo_nonce' );
	echo '<div><p>自定义SEO</p><div class="form-field"><label for="seo-title">自定义标题</label><input type="text" name="seo_title" id="seo-title" /></div><div class="form-field"><label for="seo-keywords">自定义关键词</label><input type="text" name="seo_keywords" id="seo-keywords" /></div><div class="form-field"><label for="seo-description">自定义描述</label><textarea name="seo_description" id="seo-keywords" rows="5" cols="40"></textarea></div></div>';
}
add_action( 'category_add_form_fields', 'taxonomy_add_seo_field' );
add_action( 'post_tag_add_form_fields', 'taxonomy_add_seo_field' );

// Taxonomy：编辑SEO字段
function taxonomy_edit_seo_field( $term ) {
    $title       = get_term_meta( $term->term_id, 'seo_title', true );
    $keywords    = get_term_meta( $term->term_id, 'seo_keywords', true );
    $description = get_term_meta( $term->term_id, 'seo_description', true );
    echo '<tr class="form-field"><th scope="row"><label for="seo-title">自定义标题</label></th><td><input type="text" name="seo_title" id="seo-title" value="' .esc_attr( $title ). '" /></td></tr><tr class="form-field"><th scope="row"><label for="seo-keywords">自定义关键词</label></th><td><input type="text" name="seo_keywords" id="seo-keywords" value="' .esc_attr( $keywords ). '" /></td></tr><tr class="form-field"><th scope="row"><label for="seo-description">自定义描述</label></th><td><textarea name="seo_description" id="seo-description">' .esc_attr( $description ). '</textarea></td></tr>';
    echo wp_nonce_field( basename( __FILE__ ), 'seo_nonce' );
}
add_action( 'category_edit_form_fields', 'taxonomy_edit_seo_field' );

// Taxonomy：保存SEO
function taxonomy_seo_save( $term_id ) {
    if ( ! isset( $_POST['seo_nonce'] ) || ! wp_verify_nonce( $_POST['seo_nonce'], basename( __FILE__ ) ) ){
        return;
    }
    $title = isset( $_POST['seo_title'] ) ? $_POST['seo_title'] : '';
    $keywords = isset( $_POST['seo_keywords'] ) ? $_POST['seo_keywords'] : '';
    $description = isset( $_POST['seo_description'] ) ? $_POST['seo_description'] : '';
    if ( '' === $title ) {
        delete_term_meta( $term_id, 'seo_title' );
    } else {
        update_term_meta( $term_id, 'seo_title', $title );
    }
    if ( '' === $keywords ) {
        delete_term_meta( $term_id, 'seo_keywords' );
    } else {
        update_term_meta( $term_id, 'seo_keywords', $keywords );
    }
    if ( '' === $description ) {
        delete_term_meta( $term_id, 'seo_description' );
    } else {
        update_term_meta( $term_id, 'seo_description', $description );
    }
}
add_action( 'create_category', 'taxonomy_seo_save' );
add_action( 'edit_category',   'taxonomy_seo_save' );