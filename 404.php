<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title">あなたがアクセスしようとしたページは削除されたかURLが変更されています。</h1>
				</header>

				<div class="entry-content">
					<p>いつも当サイトをご覧頂きありがとうございます。大変申し訳ないのですが、あなたがアクセスしようとしたページは削除されたかURLが変更されています。お手数をおかけしますが、以下の方法からもう一度目的のページをお探し下さい。</p>
					<h2>検索して見つける</h2>
					<?php get_search_form(); ?>
					<h2>人気の記事から見つける</h2>
					<?php
					 $wpp = array (
					 'range' => 'monthly', /*集計期間の設定（daily,weekly,monthly）*/
					 'limit' => 15, /*表示数はmax5記事*/
					 'post_type' => 'post', /*投稿のみ指定（固定ページを除外）*/
					 'title_length' => '70', /*タイトル文字数上限*/
					 'stats_comments' => '0', /*コメント数は非表示*/
					 'stats_views' => '0', /*閲覧数を表示させる*/
					); ?>
					<?php wpp_get_mostpopular($wpp); ?>					
					<h2>最新の記事から見つける</h2>
					<?php 
						query_posts('showposts=10');
						if (have_posts()) : 
							while (have_posts()) : 
								the_post();
					?>
					<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
					<?php
							endwhile;
						endif;
					?>
					<h2>カテゴリーから見つける</h2>
					<?php 
					    $args = array(
						'show_option_all'    => '',
						'orderby'            => 'name',
						'order'              => 'ASC',
						'style'              => 'list',
						'show_count'         => 1,
						'hide_empty'         => 1,
						'use_desc_for_title' => 1,
						'child_of'           => 0,
						'feed'               => '',
						'feed_type'          => '',
						'feed_image'         => '',
						'exclude'            => '',
						'exclude_tree'       => '',
						'include'            => '',
						'hierarchical'       => 1,
						'title_li'           => '',
						'show_option_none'   => __( '' ),
						'number'             => null,
						'echo'               => 1,
						'depth'              => 0,
						'current_category'   => 0,
						'pad_counts'         => 0,
						'taxonomy'           => 'category',
						'walker'             => null
					    );
						wp_list_categories( $args ); 
					?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>