<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<aside class="footmenu">
			<ul class="footmenu">
				<li><a href="/law" target="_blank">特定商取引法に基づく表記</a>&nbsp;&nbsp;|</li>
				<li><a href="/privacy" target="_blank">プライバシーについて</a>&nbsp;&nbsp;|</li>
				<li><a href="/profile">プロフィール</a>&nbsp;&nbsp;|</li>
				<li><a href="/contact">問い合わせ</a></li>
			</ul>
		</aside>
		<div class="site-info">
			Copyright &copy; 2008-<?php echo date('Y'); ?> <a href="<?php bloginfo('wpurl') ?>"><?php bloginfo('name'); ?></a> All rights reserverd.
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>