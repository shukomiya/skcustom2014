<?php
/**
 * The template for displaying Category pages
 *
 * Used to display archive-type pages for posts in a category.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

$culUri = $_SERVER["REQUEST_URI"]; // Uri
$culUriArr = explode("/",$culUri); // Uriを分解
$culUriArr = array_filter($culUriArr); // 空要素を削除

$sp_cat= in_array("toolkit",$culUriArr) || in_array("subtext",$culUriArr);

get_header(); 

if ( $sp_cat > 0) :
//指定したカテゴリに属する場合の処理
?>
	<section id="primary" class="site-content">
		<div id="content" role="main">
		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( '%s', 'twentytwelve' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>

			<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>
			</header><!-- .archive-header -->
			
			<div class="entry-content">
			<?php
			global $cat;
				
			$parent = $cat;
			//現在のカテゴリが子カテゴリを持つかどうか判定する
			$children = get_term_children($parent, 'category');

			//子カテゴリを持つなら、子孫カテゴリのリンクリストを表示
			if (!empty($children)) {
				get_category_tree($parent);
			//子カテゴリを持たないなら、タイトルリンクを表示
			}else{
				echo '<ul>';
				$args = array(
				    'cat' => $parent,
				    'order' => 'ASC'
				);
				$query = new WP_Query( $args );
				if ( $query ->have_posts() ) {
					while ( $query ->have_posts() ) {
						$query ->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
						<?php
					}
				}
				wp_reset_postdata();
				echo '</ul>';
			}
			?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php else: ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'twentytwelve' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>

			<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>
			</header><!-- .archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			endwhile;

			twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
