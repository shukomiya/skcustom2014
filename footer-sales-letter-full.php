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
				<li><a href="<?php echo esc_url( home_url() ); ?>/privacy" target="_blank">プライバシーについて</a>&nbsp;&nbsp;|</li>
				<li><a href="<?php echo esc_url( home_url() ); ?>/profile">プロフィール</a>&nbsp;&nbsp;|</li>
				<li><a href="<?php echo esc_url( home_url() ); ?>/contact">問い合わせ</a></li>
			</ul>
		</aside>
		<div class="site-info">
			Copyright &copy; 2008-<?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url('/') ); ?>"><?php bloginfo('name'); ?></a> All rights reserverd.
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>