<div class="footer">
	<div class="container">
		<div class="row">
			<div class="content">
				<div class="copyright">
					<?php echo _thememee('module_copyright'); ?>
				</div>
				<?php if ( _thememee('module_contact') ) { ?>
				<div class="contact">
					<?php if ( _thememee('contact')['_weibo'] ) { ?>
					<a class="weibo" href="<?php echo _thememee('contact')['_weibo']; ?>" target="_blank" rel="nofollow"><i class="iconfont icon-weibo"></i></a>
					<?php } ?>
					<?php if ( _thememee('contact')['_wechat'] ) { ?>
					<a class="wechat" href="javascript:void(0)"><i class="iconfont icon-wechat"></i></a>
					<?php } ?>
					<?php if ( _thememee('contact')['_qq'] ) { ?>
					<a class="qq" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo _thememee('contact')['_qq']; ?>&site=qq&menu=yes" target="_blank" rel="nofollow"><i class="iconfont icon-qq"></i></a>
					<?php } ?>
					<?php if ( _thememee('contact')['_email'] ) { ?>
					<a class="email" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=<?php echo _thememee('contact')['_email']; ?>" target="_blank" rel="nofollow"><i class="iconfont icon-email"></i></a>
					<?php } ?>
					<?php if ( _thememee('contact')['_zcool'] ) { ?>
					<a class="zcool" href="<?php echo _thememee('contact')['_zcool']; ?>" target="_blank" rel="nofollow"><i class="iconfont icon-zcool"></i></a>
					<?php } ?>
					<?php if ( _thememee('contact')['_facebook'] ) { ?>
					<a class="facebook" href="<?php echo _thememee('contact')['_facebook']; ?>" target="_blank" rel="nofollow"><i class="iconfont icon-facebook"></i></a>
					<?php } ?>
					<?php if ( _thememee('contact')['_twitter'] ) { ?>
					<a class="twitter" href="<?php echo _thememee('contact')['_twitter']; ?>" target="_blank" rel="nofollow"><i class="iconfont icon-twitter"></i></a>
					<?php } ?>
					<?php if ( _thememee('contact')['_github'] ) { ?>
					<a class="github" href="<?php echo _thememee('contact')['_github']; ?>" target="_blank" rel="nofollow"><i class="iconfont icon-github"></i></a>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php if ( _thememee('statistics') ) { ?>
	<script type="text/javascript"><?php echo _thememee('statistics'); ?></script>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>