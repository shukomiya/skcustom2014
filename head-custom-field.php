<?php
///////////////////////////////////////
// カスタムフィールドに「head_custom」と入力
///////////////////////////////////////
if ( is_singular() ){//投稿・固定ページの場合
$head_custom = get_post_meta($post->ID, 'head_custom', true);
if ( $head_custom ) {
echo $head_custom;
}
}