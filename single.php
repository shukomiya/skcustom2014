<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				<nav class="single-page-navi entry-content">
					<h2 class="add-section-title">前後の記事</h2>
					<ul>
						<li><strong>【前の記事】&nbsp;</strong>
							<?php global $g_category_nav; previous_post_link( '%link', '<span class="meta-nav">' . '</span> %title',  $g_category_nav , '' ); ?></span></li>
						<li><strong>【次の記事】&nbsp;</strong>
							<?php  global $g_category_nav; next_post_link( '%link', '%title <span class="meta-nav">' . '</span>', $g_category_nav, '' ); ?></span></li>
					</ul>
					<h2 class="add-section-title">関連記事</h2>
					<?php sk_get_the_ad('adsense', 'mg_single_content_bottom_rel_ad'); ?>
				</nav>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php if (!is_mobile()) : ?>
<?php get_sidebar(); ?>
<?php endif; ?>
<?php get_footer(); ?>