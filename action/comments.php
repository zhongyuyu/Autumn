<?php

add_action('wp_ajax_nopriv_ajax_comment', 'ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'ajax_comment_callback');
function ajax_comment_callback() {
 	global $wpdb;
	$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;
	$post = get_post($comment_post_ID);
	$post_author = $post->post_author;
	if ( empty($post->comment_status) ) {
		do_action('comment_id_not_found', $comment_post_ID);
		ajax_comment_error('无效的评论状态。');
	}
	$status = get_post_status($post);
	$status_obj = get_post_status_object($status);
	if ( !comments_open($comment_post_ID) ) {
		do_action('comment_closed', $comment_post_ID);
		ajax_comment_error( '<span>对不起，本文评论已关闭。</span>' );
	} else if ( 'trash' == $status ) {
		do_action('comment_on_trash', $comment_post_ID);
		ajax_comment_error( '<span>未知错误。</span>' );
	} else if ( !$status_obj->public && !$status_obj->private ) {
		do_action('comment_on_draft', $comment_post_ID);
		ajax_comment_error( '<span>未知错误。</span>' );
    } else if ( post_password_required($comment_post_ID) ) {
		do_action('comment_on_password_protected', $comment_post_ID);
		ajax_comment_error( '<span>请输入文章密码！</span>' );
    } else {
		do_action('pre_comment_on_post', $comment_post_ID);
    }
	$comment_author  = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
	$comment_email   = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
	$comment_url     = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
	$comment_content = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
	$user = wp_get_current_user();
	if ( $user->exists() ) {
		if ( empty( $user->display_name ) ) {
			$user->display_name=$user->user_login;
		}
		$comment_author = esc_sql( $user->display_name );
		$comment_email  = esc_sql( $user->user_email );
		$comment_url    = esc_sql( $user->user_url );
		$user_ID              = esc_sql($user->ID);
		if ( current_user_can('unfiltered_html') ) {
			if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
				kses_remove_filters();
				kses_init_filters();
			}
		}
	} else {
		if ( get_option('comment_registration') || $status === 'private' ) {
			ajax_comment_error('<span>您必须登录后才能发表评论！</span>');
		}
	}
	
    $comment_time   = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) );
	$comment_repeat .= "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
    if ( $comment_email ){
        $comment_repeat .= "OR comment_author_email = '$comment_email' ";
    }
	$comment_repeat .= ") AND comment_content = '$comment_content' LIMIT 1";

	if ( $comment_time ) {
		$comment_last  = mysql2date('U', $comment_time, false);
		$comment_new   = mysql2date('U', current_time('mysql', 1), false);
		$comment_flood = apply_filters('comment_flood_filter', false, $comment_last, $comment_new);
		if ( $comment_flood ) {
			ajax_comment_error('<span>你回复太快栏，请稍后再试！</span>');
		}
	}
	if ( get_option('require_name_email') && !$user->exists() ) {
		if ( strlen( $comment_email ) < 6 || empty( $comment_author ) ) {
			ajax_comment_error( '<span>请输入昵称/电子邮件！</span>' );
		} else if ( !is_email($comment_email)) {
			ajax_comment_error( '<span>请输入有效的电子邮件地址！</span>' );
		}
	}
	if ( empty( $comment_content )) {
		ajax_comment_error( '<span>说点什么？</span>' );
	}
	if ( $wpdb->get_var($comment_repeat) ) {
		ajax_comment_error('<span>似乎说过这句话？</span>');
	}

	$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
	$comment_data   = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
	$comment_id     = wp_new_comment( $comment_data );
	$comment        = get_comment( $comment_id );
	do_action( 'set_comment_cookies', $comment, $user );
	$i  = 1;
	while( $comment->comment_parent != 0 ) {
		$comment = get_comment( $comment->comment_parent );
		$i++;
	}
	$GLOBALS['comment'] = $comment;

?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment-body">
		<div class="left">
			<div class="avatar">
				<?php echo get_avatar( $comment ); ?>
			</div>
		</div>
		<div class="right">
			<div class="top">
				<span class="name"><a class="url" href="/i?a=<?php echo base64_encode( get_comment_author_url($comment_ID) ); ?>" target="_blank" rel="external nofollow"><?php comment_author(); ?></a></span>
				<?php if($comment->user_id == 1) { ?>
				<span class='level'><?php echo _thememee('admin_name', '官方'); ?></span>
				<?php } ?>
				<span class="time"><?php echo get_comment_time('Y-m-d H:i') ?></span>
				<span class="reply">
				<?php if ( $depth == get_option('thread_comments_depth') ) { ?>
					<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php echo $comment->comment_parent; ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' )" href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link" rel="nofollow">回复</a>
 				<?php } else { ?>
					<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php comment_ID(); ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link" rel="nofollow">回复</a>
				<?php } ?>
				</span>
			</div>
			<div class="bottom">
				<?php comment_text(); ?>
				<?php if ( $comment->comment_approved == '0' ) { ?>
				<font style="color:#f90a0a; font-style:inherit">您的评论正在等待审核中...</font>
				<?php } ?>
			</div>
		</div>
	</div>
<?php die(); } ?>