<?php
if ( post_password_required() ) {
	return;
}
?>
<?php
function comment_callback( $comment, $args, $depth ) {
	global $post;
	$GLOBALS['comment'] = $comment;
?>
<li id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment-body">
		<div class="left">
			<div class="avatar">
				<?php echo get_avatar( $comment ); ?>
			</div>
		</div>
		<div class="right">
			<div class="top">
				<span class="name"><?php comment_author_link(); ?></span>
				<?php if ( $comment->user_id == 1 ) { ?>
				<span class="level"><?php echo _thememee('admin_name', '官方'); ?></span>
                <?php } ?>
				<span class="time"><?php echo get_comment_time('Y-m-d H:i') ?></span>
				<span class="reply">
				<?php if ($depth == get_option('thread_comments_depth')) { ?>
					<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php echo $comment->comment_parent; ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' )" href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link" rel="nofollow">回复</a>
 				<?php } else { ?>
					<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php comment_ID(); ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link" rel="nofollow">回复</a>
				<?php } ?>
				</span>
			</div>
			<div class="bottom">
				<?php comment_text(); ?>
				<?php if ( $comment->comment_approved == '0' ) { ?>
				<font style="color:#f90a0a;font-style:inherit">您的评论正在等待审核中...</font>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
<div class="comments" id="comments">
	<div class="heading">
		<i class="iconfont icon-comment"></i>发表评论<span>（<?php  echo get_comments_number();?>）</span>
	</div>
	<div class="content">
		<div id="respond" class="respond">
			<?php if ( get_option('comment_registration') && !$user_ID ) { ?>
				<p class="tips"><?php print '您必须'; ?><a href="<?php echo get_option('siteurl'); ?>/login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"> [ 登录 ] </a>才能发表留言！</p>
			<?php } else { ?>
				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="comment-form">
					<?php if ( ! $user_ID ) { ?>
						<div class="comment-author-info">   
							<div class="item">
								<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" placeholder="昵称 *" />
							</div>
							<div class="item">
								<input type="email" name="email" id="email" value="<?php echo $comment_author_email; ?>" placeholder="邮箱 *"   />
							</div>
							<div class="item">
								<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" placeholder="网址" />
							</div>
						</div>
					<?php } ?>
					<div class="comment-from-main">
						<div class="textarea">
							<div class="input" contenteditable="true" placeholder="说点什么吧..."></div>
							<input name="comment" id="comment" type="hidden">
						</div>
						<div class="control">
							<div class="element">
								<div class="smilies">
									<a href="javascript:void(0);"><i class="iconfont icon-emoji"></i></a>
									<?php echo get_the_emoji(); ?>
								</div>
 							</div>
 							<div class="button">
                        		<?php cancel_comment_reply_link(); ?>
								<input class="btn-comment" name="submit" type="submit" id="submit" tabindex="5" title="发表评论" value="发表评论">
								<?php comment_id_fields(); ?>
							</div>
						</div>
					</div>
				</form>
			<?php } ?>
		</div>
		<?php if ( ! comments_open() ) { ?>
		<?php } else { ?>
			<ul>
				<?php wp_list_comments( array( 'type' => 'comment', 'callback' => 'comment_callback', 'max_depth' => 1 ) ); ?>
			</ul>
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
				<div class="pagination">
				    <?php paginate_comments_links( array( 'prev_text' => '<i class="iconfont icon-left"></i>', 'next_text' => '<i class="iconfont icon-right"></i>' ) ); ?>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
</div>