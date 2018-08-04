<?php
/**
 * Template Name: user-info
 */
 
function check_inputdata($user_info) {
	$err_mes = array();

	if ($user_info["nickname"] === null){
		$err_mes[] = '※名前を入力してください';
	}

	if ($user_info["password"] !== null && $user_info["password2"] !== null){
		if ($user_info["password"] !== $user_info["password2"]){
			$err_mes[] = '※パスワードが異なっています';
		}
	}
}

//操作アクションを取得
$act = isset($_POST["act"]) ? intval($_POST["act"]) : 1;

if ($act == 1) {
	// セッションデータクリア
	$user_info = array();
	// 初期値セット
	$err_msg = array();
	$user = wp_get_current_user();
	$email = $user->user_email;
	$nickname = $user->display_name;
} elseif ($act == 2) { // 登録ボタンを押下された場合
	$user_info = isset($_POST["user_info"]) ? $_POST["user_info"] : array();
 	// 入力チェック
 	$err_msg = check_inputdata($user_info);
	if (!$err_msg){
	 	$email = isset($user_info["email"]) ? $user_info["email"] : "";
		$nickname = isset($user_info["nickname"]) ? $user_info["nickname"] : "";
		$password = isset($user_info["password"]) ? $user_info["password"] : "";

		$user_id = get_current_user_id();
		update_user_meta( $user_id, 'nickname', $nickname );

		if (empty($password)){
			$user_id = wp_update_user( array( 'ID' => $user_id, 'display_name' => $nickname ));
		} else {
			$user_id = wp_update_user( array( 'ID' => $user_id, 'password' => $password, 'display_name' => $nickname ));
		}
	} else {
	 	$email = isset($user_info["email"]) ? $user_info["email"] : "";
		$nickname = isset($user_info["nickname"]) ? $user_info["nickname"] : "";
		$password = isset($user_info["password"]) ? $user_info["password"] : "";
	}
} else {
	// セッションデータ取得
	$user_info = isset($_POST["user_info"]) ? $_POST["user_info"] : array();
	// 各項目データをセット
	$nickname = isset($user_info["nickname"]) ? $user_info["nickname"] : "";
	$email = isset($user_info["email"]) ? $user_info["email"] : "";
 }

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
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
				
					<p class="mb30">以下を入力し確認するボタンを押してください。<span class="red">*</span>は入力必須です。</p>
					<div class="userinfo">
					<form name="userinfoform" role="form" method="post" action="" novalidate>
						<div class="field">
							<label>ＩＤ／メールアドレス:</label><br>
							<input type="field" readonly name="user_info[field]" value="<?php echo htmlspecialchars($email); ?>">
						</div>
			
						<div class="field">
						<label>名前:</label><br>
						<input type="text" name="user_info[nickname]" value="<?php echo htmlspecialchars($nickname); ?>">
						</div>

						<div class="field">
						<label>パスワード:</label><br>
						<input type="password" name="user_info[password]" value="">
						</div>
			
						<div class="field">
						<label>パスワードの確認:</label><br>
						<input type="password" name="user_info[password2]" value="">
						</div>
			
					<div class="btn-area">
						<button type="submit" class="btn btn-success">送信する<i class="fa fa-envelope-o"></i></button>
						<input type="hidden" name="act" value="2">
					</div>
				</form>
				
					</main><!-- .site-main -->
				
				</div><!-- .entry-content -->
			</article><!-- #post -->
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer('nosidebar'); ?>