<?php
/**
 * Template Name: Product-Page Template, with Ad
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

<ul>
<?php wp_list_pages('child_of=900;depth=1;'); ?>
</ul>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>