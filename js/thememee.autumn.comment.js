jQuery(document).ready(function($) {

$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');

$(document).ready(function($) {
	var $commentform = $('#commentform'),
	$cancel = $('#cancel-comment-reply-link'),
	cancel_text = "取消回复";
	$(document).on("submit", "#commentform",
	function() {
        $('#comment').after('<div class="tips loading"></div>');
		$('.tips.loading').slideDown().html("<span>评论提交中....</span>");
		$('#submit').addClass("disabled").val("发表评论").attr("disabled","disabled");
		$.ajax(
			_thememee.url+'/wp-admin/admin-ajax.php',
			{
				data: $(this).serialize() + "&action=ajax_comment",
				type: $(this).attr('method'),
				error: function(request) {
					$('#comment').each(function() {
						this.value = ''
					});
					$('.tips.loading').slideUp(300);
					setTimeout( function() {
						$('.tips.loading').remove();
						$('#comment').after('<div class="tips error"></div>');
						$('.tips.error').slideDown(300).html(request.responseText);
					}, 300 )
					setTimeout( function() {
						$('#submit').removeClass('disabled').val('发表评论').attr('disabled',false);
						$('.tips.error').slideUp(300);
						setTimeout( function() {
							$('.tips.error').remove();
						}, 300 )
					}, 3000 )
				},
				success: function(data) {
					$('#comment').each(function() {
						this.value = ''
					});
					var t = addComment,
					cancel = t.I('cancel-comment-reply-link'),
					temp = t.I('wp-temp-form-div'),
					respond = t.I(t.respondId),
					post = t.I('comment_post_ID').value,
					parent = t.I('comment_parent').value;
					if ( parent != '0' ) {
						$('#respond').before(data);
					} else {
						$('.comments>.content>ul').prepend(data);
					}
                    $('.tips.loading').slideUp(300);
                    $('.comment-from-main .input').html('');
					setTimeout( function() {
						$('.tips.loading').remove();
						$('#comment').after('<div class="tips success"></div>');
						$('.tips.success').slideDown(300).html("<span>评论提交成功！</span>");
					}, 300 )
					setTimeout( function() {
						$('#submit').removeClass('disabled').val('发表评论').attr('disabled',false);
						$('.tips.success').slideUp(300);
						setTimeout( function() {
							$('.tips.success').remove();
						}, 300 )
					}, 3000 )
					cancel.style.display = 'none';
					cancel.onclick = null;
					t.I('comment_parent').value = '0';
					if ( temp && respond ) {
						temp.parentNode.insertBefore(respond, temp);
						temp.parentNode.removeChild(temp)
					}
				}
			}
		);
		return false;
	});
	addComment = {
		moveForm: function(commId, parentId, respondId) {
			var t = this,
			div,
			comm = t.I(commId),
			respond = t.I(respondId),
			cancel = t.I('cancel-comment-reply-link'),
			parent = t.I('comment_parent'),
			post = t.I('comment_post_ID');
			$cancel.text(cancel_text);
			t.respondId = respondId;
			if (!t.I('wp-temp-form-div')) {
				div = document.createElement('div');
				div.id = 'wp-temp-form-div';
				div.style.display = 'none';
				respond.parentNode.insertBefore(div, respond)
			} ! comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
			$("body").animate({
				scrollTop: $('#respond').offset().top - 180
			},
			400);
			parent.value = parentId;
			cancel.style.display = '';
			cancel.onclick = function() {
				var t = addComment,
				temp = t.I('wp-temp-form-div'),
				respond = t.I(t.respondId);
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp);
				}
				this.style.display = 'none';
				this.onclick = null;
				return false;
			};
			try {
				t.I('comment').focus();
			}
			catch(e) {}
			return false;
		},
		I: function(e) {
			return document.getElementById(e);
		}
	};
});

$('#submit').on('click', function () {
  	$('.comment-from-main input[name="comment"]').val($('.comment-from-main .input').html());
});
$('.element .smilies a').on('click', function () {
	$('.element .smilies .emoji').toggleClass('open');
});
$(document).on('click', function(e) {
	if ( $(e.target).closest('.element .smilies a').length !== 0 )
	return;
	$('.element .smilies .emoji').removeClass('open');
});

$('.smilies .emoji ul li').on('click', function () {
	var lastEditRange;
	$('.comment-from-main .input').focus();
	var el = document.createElement('div');
	el.innerHTML = '<img class="smilies" src="' + $(this).find('img').attr('src') +'" ondragstart="return false;">';
	var selection = getSelection();
	if (lastEditRange) {
		selection.removeAllRanges();
		selection.addRange(lastEditRange);
	}
	var range = selection.getRangeAt(0);
	range.deleteContents();
	var frag = document.createDocumentFragment(), node, lastNode;
	while ( (node = el.firstChild) ) {
		lastNode = frag.appendChild(node);
	}
	range.insertNode(frag);
	if (lastNode) {
		range = range.cloneRange();
		range.setStartAfter(lastNode);
		range.collapse(true);
		selection.removeAllRanges();
		selection.addRange(range);
	}
	lastEditRange = selection.getRangeAt(0);
	$('.element .smilies .emoji').removeClass('open');
});

});