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
	<?php get_sidebar( 'footer' ); ?>
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
<script src="https://use.fontawesome.com/9b0c8d6824.js"></script>
<script type="text/javascript">jQuery(function() {  
    jQuery("a").click(function(e) {        
        var ahref = jQuery(this).attr('href');
        if (ahref.indexOf("komish.com") != -1 || ahref.indexOf("http") == -1 ) {
            ga('send', 'event', 'internal-link', 'click', ahref);} 
        else { 
            ga('send', 'event', 'external-link', 'click', ahref);}
        });
    });
</script>
</body>
</html>