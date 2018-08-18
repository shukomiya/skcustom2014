<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php entry_date(); ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-meta">
			<?php twentytwelve_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;<span class="edit-link">', '</span>' ); ?></div>
		</header>

		<div class="entry-content">
			<?php if (count($err_msg) > 0) { ?>
			<div>
				<ul class="error">
					<?php foreach ($err_msg as $msg) { ?>
					<li><?php echo $msg; ?></li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
		
			<div class="page-content">
				<p class="mb30">�ʲ������Ϥ���ǧ����ܥ���򲡤��Ƥ���������<span class="red">*</span>������ɬ�ܤǤ���</p>
		
				<form class="userinfo" name="userinfoform" role="form" method="post" action="" novalidate>
					<div class="email">
						<label>�ɣġ��᡼�륢�ɥ쥹:</label><br>
						<input type="email" readonly name="user_info[email]" value="<?php echo htmlspecialchars($email); ?>">
					</div>
		
					<label>̾��:</label>
					<input type="text" name="user_info[nickname]" value="<?php echo htmlspecialchars($nickname); ?>">
		
					<label>�ѥ����:</label>
					<input type="password" name="user_info[password]" value="">
		
					<label>�ѥ���ɤγ�ǧ:</label>
					<input type="password" name="user_info[password2]" value="">
		
				<div class="btn-area">
					<button type="submit" class="btn btn-success">��������<i class="fa fa-envelope-o"></i></button>
					<input type="hidden" name="act" value="2">
				</div>
			</form>
			</div>
		
			</main><!-- .site-main -->
		
		</div><!-- .entry-content -->
	</article><!-- #post -->
