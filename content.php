<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<?php the_post_thumbnail('post_thumbnail'); ?>
			<div class="breadcrumbs">
			    <?php 
			    	if (function_exists('bcn_display')) {
			        	bcn_display();
			    	}
			    ?>
			</div>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->

	<!-- rakuten_ad_target_begin --> 
	<!-- google_ad_section_start -->
		<?php if ( is_search() || is_home() || is_archive() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"></a>
			<span class="alignleft"><div style="margin: 8px 16px 0 0;"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div></span>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php 
				if (is_single()){
					if ( is_ad_enabled() ) {
						if ( !is_no_adsense() ) {
							sk_get_the_ad('adsense', 'mg_single_content_top_link_res');
						}
					}
				}
			?>
			<?php the_content( '続きを読む...' ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-link-title">' . __( 'Pages:', 'twentytwelve' ) . '</span>', 'after' => '</div>',
				'link_before' => '<span class="page-link-item">', 'link_after'  => '</span>' ) ) ; ?>
			<?php get_template_part( 'sns' ); ?>
	<!-- google_ad_section_end -->
	<!-- rakuten_ad_target_end --> 
			<?php 
			global $g_ad_enabled, $g_category_nav;
			
			if ( is_single() ) {
				if ( is_ad_enabled() ) {
					if ( !is_no_adsense() ) {
						sk_get_the_ad('adsense', 'mg_sp_single_content_bottom');
						sk_get_the_ad('adsense', 'mg_single_content_bottom_rel_ad');
					}
				}
				if (!$g_category_nav){
					echo '<center><a class="twitter-timeline" href="https://twitter.com/shukomiya?ref_src=twsrc%5Etfw" data-lang="ja" data-width="80%" data-height="600">Tweets by shukomiya</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></center>';
				}
				if ( is_ad_enabled() ){
					if ( !is_mobile() ) {
						sk_get_the_ad('rakuten', 'content_bottom_336x280');
					} else {
						sk_get_the_ad('rakuten', 'content_bottom_300x160');
					}
				}
			}
			
			?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<footer class="entry-meta">
			<?php twentytwelve_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->

		<?php
		global $g_index_ad_count;
		
		if ( !is_single() ) {
			if ( is_ad_enabled() ) {
				if ( $g_index_ad_count == 0|| $g_index_ad_count == 4 || $g_index_ad_count == 9) {
					sk_get_the_ad('adsense', 'mg_in_feed');
				}
				$g_index_ad_count++;
			}
		}
		?>
	</article><!-- #post -->
