<!doctype html>
<html amp <?php echo AMP_HTML_Utils::build_attributes_string( $this->get( 'html_tag_attributes' ) ); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<?php do_action( 'amp_post_template_head', $this ); ?>
	<style amp-custom>
		<?php $this->load_parts( array( 'style' ) ); ?>
		<?php do_action( 'amp_post_template_css', $this ); ?>
	</style>
</head>

<body class="<?php echo esc_attr( $this->get( 'body_class' ) ); ?>">

<?php $this->load_parts( array( 'header-bar' ) ); ?>

<article class="amp-wp-article">

	<header class="amp-wp-article-header">
		<h1 class="amp-wp-title"><?php echo wp_kses_data( $this->get( 'post_title' ) ); ?></h1>
		<?php $this->load_parts( apply_filters( 'amp_post_article_header_meta', array( 'meta-author', 'meta-time' ) ) ); ?>
	</header>

	<?php $this->load_parts( array( 'featured-image' ) ); ?>

	<div class="amp-wp-article-content">
		<div class="ad-top">
		<amp-ad
			layout="fixed-height"
			height=100
			type="adsense"
			data-ad-client="ca-pub-7935009294964527"
			data-ad-slot="4240646084">
		</amp-ad>
		</div>
		<?php echo $this->get( 'post_amp_content' ); // amphtml content; no kses ?>
		<div class="ad-bottom">
		<amp-ad
			layout="responsive"
		 	type="adsense"
		 	data-ad-client="ca-pub-7935009294964527"
		 	data-ad-slot="5406783285"
		 	width="300"
		 	height="250">
		</amp-ad>
		</div>
		<h2>おすすめ記事</h2>
		<div class="ad-bottom2">
		<amp-ad
			layout="responsive"
		 	type="adsense"
		 	data-ad-client="ca-pub-7935009294964527"
		 	data-ad-slot="5717379286"
		 	width=300
			height=250>
		</amp-ad>
		</div>
		</div>
		<?php 
			if (function_exists('related_posts')){
				echo '<h2>関連記事</h2>';
				related_posts(); 
			}
			
			/*
			if ( function_exists( 'wpp_get_mostpopular' ) ) {
				echo '<h2>このカテゴリの１週間の人気記事</h2>';
				$cat = get_the_category();
				$cat_id = $cat[0]->cat_ID;
				$args = array(
					'range' => 'weekly', // 週単位で集計
					'post_type' => 'post', // ポストタイプを指定
					'limit' => 5, // 表示件数を指定
					'stats_views' => 0,
					'pid' => "$post->ID",
					'cat' => "$cat_id"
				);
				wpp_get_mostpopular( $args );
			}				
			*/
			?>
	<footer class="amp-wp-article-footer">
		<?php $this->load_parts( apply_filters( 'amp_post_article_footer_meta', array( 'meta-taxonomy', 'meta-comments-link' ) ) ); ?>
	</footer>

</article>

<?php $this->load_parts( array( 'footer' ) ); ?>

<?php do_action( 'amp_post_template_footer', $this ); ?>

</body>
</html>
