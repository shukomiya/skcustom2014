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
			<?php //the_post_thumbnail(); ?>
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
			<div class="entry-meta">
			<?php twentytwelve_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;<span class="edit-link">', '</span>' ); ?></div>
		</header><!-- .entry-header -->

	<!-- rakuten_ad_target_begin --> 
	<!-- google_ad_section_start -->
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<span class="thumbnail"><?php the_post_thumbnail('thumbnail'); ?></span></a>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php if ( ! post_password_required() && ! is_attachment() ) :
				the_post_thumbnail('post_thumbnail');
			endif; ?>

			<?php 
				if ( is_single() ) {
					if ( is_mobile() ) {
						sk_get_the_ad('denno', 'mg_sp_single_content_top');
					} else {
						sk_get_the_ad('denno', 'mg_single_content_top');
					}
				}
			?>
			<?php the_content( '続きを読む...' ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-link-title">' . __( 'Pages:', 'twentytwelve' ) . '</span>', 'after' => '</div>',
				'link_before' => '<span class="page-link-item">', 'link_after'  => '</span>' ) ) ; ?>
	<!-- google_ad_section_end -->
	<!-- rakuten_ad_target_end --> 
			<?php 
			global $ad_enabled, $post;
			
			if ( is_single() ) {
				if ( $ad_enabled ) {
					if ( !is_mobile() ) {
						sk_get_the_ad('adsense', 'mg_single_content_bottom'); 
					} else {
						sk_get_the_ad('adsense', 'mg_sp_single_content_bottom'); 
					}
				}
				
//				echo '<h2>この記事を共有する</h2>';
//				sk_the_social_original_buttons(true);
				
				if ( $ad_enabled ) {
					echo '<h2>おすすめ記事</h2>';
					sk_get_the_ad('adsense', 'mg_single_content_bottom_rel_ad');
	
					if ( is_mobile() ) {
						sk_get_the_ad('rakuten', 'content_bottom_300x250');
					} else {
						sk_get_the_ad('rakuten', 'content_bottom_336x280');
					}
				}

				if (function_exists('related_posts')){
					echo '<h2>関連記事</h2>';
					related_posts(); 
				}
			}
			?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<div class="author-info">
					<div class="author-avatar">
						<?php
						/** This filter is documented in author.php */
						$author_bio_avatar_size = apply_filters( 'twentytwelve_author_bio_avatar_size', 68 );
						echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
						?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
		</footer><!-- .entry-meta -->
				<?php
				global $index_ad_count;
				
				if ( !is_single() ) {
					if ( !is_noad() ) {
						if ( $index_ad_count == 0|| $index_ad_count == 4 || $index_ad_count == 9) {
							sk_get_the_ad('adsense', 'mg_in_feed');
						}
						$index_ad_count++;
					}
				}
				?>
	</article><!-- #post -->
