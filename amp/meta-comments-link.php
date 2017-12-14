<?php
$comments_link_url = $this->get( 'comments_link_url' );
?>
<?php if ( $comments_link_url ) : ?>
	<?php //$comments_link_text = $this->get( 'comments_link_text' ); 
		$comments_link_text =  'コメントする';
	?>
	<div class="amp-wp-meta amp-wp-comments-link">
		<a href="<?php echo esc_url( $comments_link_url ); ?>">
			<?php echo esc_html( $comments_link_text ); ?>
		</a>
	</div>
<?php endif; ?>
