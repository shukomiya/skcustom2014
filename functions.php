<?php

$domain_name = $_SERVER["SERVER_NAME"];
$is_localhost = $domain_name == 'localhost';
// for debug
//$is_localhost = false;

if ( $is_localhost ) {
	$analy_g_acount = 'UA-4079996-8';
	$domain_name = 'komish.com';
	$g_category_nav = false;
	$g_ad_enabled = false;
} else {
	if ( $domain_name === 'komish.com' ) {
		$analy_g_acount = 'UA-4079996-8';
		$g_category_nav = false;
		$g_ad_enabled = true;
	} else if ( $domain_name === 'members.komish.com' ) {
		$analy_g_acount = 'UA-4079996-23';
		$g_category_nav = true;
		$g_ad_enabled = false;
	} else if ( $domain_name === 'plus.komish.com' ) {
		$analy_g_acount = 'UA-4079996-23';
		$g_category_nav = true;
		$g_ad_enabled = false;
	}
}

// for debug
//$g_ad_enabled = true;

function is_amp(){
  //AMPチェック
	$is_amp = false;
	if ( empty($_GET['amp']) ) {
		return false;
	}
 
  //ampのパラメーターが1かつ投稿ページの
  //かつsingleページのみ$is_ampをtrueにする
	if(is_single() && $_GET['amp'] === '1'){
		$is_amp = true;
	}
	return $is_amp;
}

function amp_template($file, $type, $post) {
    if ( 'single' === $type ) {
        $file = get_stylesheet_directory().'/amp/single.php';
    }
    if ( 'style' === $type ) {
        $file = get_stylesheet_directory().'/amp/style.php';
    }
    if ( 'meta-author' === $type ) {
            $file = get_stylesheet_directory().'/amp/meta-author.php';
    }
    if ( 'meta-taxonomy' === $type ) {
            $file = get_stylesheet_directory().'/amp/meta-taxonomy.php';
    }
    if ( 'meta-time' === $type ) {
            $file = get_stylesheet_directory().'/amp/meta-time.php';
    }
    return $file;
}
add_filter('amp_post_template_file','amp_template', 10, 3 );

add_filter( 'amp_post_template_metadata', 'sk_amp_modify_json_metadata', 10, 2 );

function sk_amp_modify_json_metadata( $metadata, $post ) {
    $metadata['@type'] = 'NewsArticle';
 
/*
    $metadata['publisher']['logo'] = array(
        '@type' => 'ImageObject',
        'url' => get_stylesheet_directory_uri() . '/images/logo2.png',
        'height' => 512,
        'width' => 512
    );
*/

    if ( !has_post_thumbnail() ) {
	    $metadata['image'] = array(
	        '@type' => 'ImageObject',
	        'url' => get_stylesheet_directory_uri() . '/images/logo2.png',
	        'height' => 505,
	        'width' => 504
	    );
    }

    return $metadata;
}

add_filter( 'amp_post_template_analytics', 'sk_amp_add_custom_analytics' );
function sk_amp_add_custom_analytics( $analytics ) {
	global $is_localhost, $analy_g_acount;
	
	if ( $is_localhost )
		return;
		
    if ( ! is_array( $analytics ) ) {
        $analytics = array();
    }
 
    // https://developers.google.com/analytics/devguides/collection/amp-analytics/
    $analytics['sk-googleanalytics'] = array(
        'type' => 'googleanalytics',
        'attributes' => array(
            // 'data-credentials' => 'include',
        ),
        'config_data' => array(
            'vars' => array(
                'account' => $analy_g_acount
            ),
            'triggers' => array(
                'trackPageview' => array(
                    'on' => 'visible',
                    'request' => 'pageview'
                ),
            ),
        ),
    );

    return $analytics;
}

//Adsense-JS追加
add_action( 'amp_post_template_head', 'sk_amp_add_tag_adsense_js' );
function sk_amp_add_tag_adsense_js() {
?>
<!-- AMP Ad -->
<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
<script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>
<?php
}

function sk_dequeue_fonts() {
	wp_dequeue_style( 'twentytwelve-fonts' );
//	wp_dequeue_style( 'wprmenu-font' );
}
add_action( 'wp_enqueue_scripts', 'sk_dequeue_fonts', 11 );

// add to move the comment text field to the bottom in WordPress 4.4 12/12/2015
function wp34731_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	
	return $fields;
}
add_filter( 'comment_form_fields', 'wp34731_move_comment_field_to_bottom' );
// End 12/12/2015

// コメントからEmailとウェブサイトを削除
function my_comment_form_remove($arg) {
	$arg['url'] = '';
	$arg['email'] = '';
	return $arg;
}
add_filter('comment_form_default_fields', 'my_comment_form_remove');
 
// 「メールアドレスが公開されることはありません」を削除
function my_comment_form_before( $defaults){
	$defaults['comment_notes_before'] = '';
	return $defaults;
}
add_filter( "comment_form_defaults", "my_comment_form_before");
 
// 「HTMLタグと属性が使えます…」を削除
function my_comment_form_after($args){
	$args['comment_notes_after'] = '';
	return $args;
}
add_filter("comment_form_defaults","my_comment_form_after");

function sk_disable_autosave() {
	wp_deregister_script('autosave');
}
add_action( 'wp_print_scripts', 'sk_disable_autosave' );

function disable_emoji() {
     remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
     remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
     remove_action( 'wp_print_styles', 'print_emoji_styles' );
     remove_action( 'admin_print_styles', 'print_emoji_styles' );    
     remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
     remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );    
     remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'disable_emoji' );

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head','rest_output_link_wp_head');
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');
remove_action('template_redirect', 'rest_output_link_header', 11 );

add_action( 'after_setup_theme', 'child_theme_setup' );
 
add_action( 'wp_enqueue_scripts', 'sk_enqueue_styles' );
function sk_enqueue_styles() {
	global $wp_styles;

    wp_enqueue_style( 'twentytwelve', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'skcustom2014',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
	wp_enqueue_style( 'skcustom2014-ie', 
		get_stylesheet_directory_uri() . '/css/ie.css', array( 'twentytwelve-ie' ), '20121010' );
	$wp_styles->add_data( 'skcustom2014-ie', 'conditional', 'lt IE 9' );
}

// 子テーマで上書きしたい設定を書く
if ( ! function_exists( 'child_theme_setup' ) ):
function child_theme_setup() {

    // 「...」の出力関数を子テーマのものに入れ替える
//   remove_filter( 'wp_title', 'twentytwelve_wp_title' );
//	add_filter( 'wp_title', 'twentytwelve_wp_title_child', 10, 2 );

	remove_action( 'widgets_init', 'twentytwelve_widgets_init' );
	add_action( 'widgets_init', 'sk_widgets_init' );
}
endif;

// 上記の関数を、親テーマの読み込みより後に読み込んでもらう
add_action( 'after_setup_theme', 'child_theme_setup' );

function is_modified_content() {
	$mtime = get_the_modified_time('Ymd');
	$ptime = get_the_time('Ymd');
	if ($ptime > $mtime) {
		return false;
	} elseif ($ptime === $mtime) {
		return false;
	} else {
		return true;
	}
}

function entry_date() {
	$date = sprintf( '<i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbsp;<time class="entry-date date published updated" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
		);
	if  ( is_modified_content() ) {
		$date =  sprintf( '%1$s&nbsp;&nbsp;&nbsp;<i class="fa fa-repeat" aria-hidden="true"></i>&nbsp;<time class="entry-date date updated" datetime="%2$s">%3$s</time>',
			$date,
			esc_attr( get_the_modified_time('c')  ),
			esc_html( get_the_modified_date() )
			);
	}
	echo ' <div class="header-date">'. $date . '</div>';
}
function twentytwelve_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );
	 
	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );
 
 	$author = sprintf( '<span class="author vcard"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;<span class="fn">%1$s</span>&nbsp;&nbsp;&nbsp;</span></span>',
		 get_the_author()
	 );
	 
	 if ( !$categories_list ) {
		echo $author;
		return;
	}
 
	$date = sprintf( '<i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbsp;<time class="entry-date date published updated" datetime="%1$s">%2$s</time>&nbsp;&nbsp;&nbsp;',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
		);
	if  ( is_modified_content() ) {
		$date =  sprintf( '%1$s<i class="fa fa-repeat" aria-hidden="true"></i>&nbsp;<time class="entry-date date updated" datetime="%2$s">%3$s</time>&nbsp;&nbsp;&nbsp;',
			$date,
			esc_attr( get_the_modified_time('c')  ),
			esc_html( get_the_modified_date() )
			);
	}

    // Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name 5 is the modified date.
    //<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;
	 if ( $tag_list ) {
		$utility_text ='%4$s%3$s<br /><i class="fa fa-folder-open" aria-hidden="true"></i>&nbsp;%1$s&nbsp;&nbsp;&nbsp;<i class="fa fa-tag" aria-hidden="true"></i>&nbsp;%2$s&nbsp;&nbsp;&nbsp;' ;
	} elseif ( $categories_list ) {
		$utility_text = '%4$s%3$s<br /><i class="fa fa-folder-open" aria-hidden="true"></i>&nbsp;&nbsp;%1$s&nbsp;&nbsp;&nbsp;' ;
	}
 
	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$author,
		$date
	);
}

function sk_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentytwelve' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'First Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
	    'name' => __( 'Footer Widget Area 1', 'twentytwelve' ),
	    'id' => 'footer-widget-1',
	    'description' => __( 'Widget area is displayed on a footer portion', 'twentytwelve' ),
	    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	    'after_widget' => '</aside>',
	    'before_title' => '<h3 class="widget-title">',
	    'after_title' => '</h3>',
	) );

	register_sidebar( array(
	    'name' => __( 'Footer Widget Area 2', 'twentytwelve' ),
	    'id' => 'footer-widget-2',
	    'description' => __( 'Widget area is displayed on a footer portion', 'twentytwelve' ),
	    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	    'after_widget' => '</aside>',
	    'before_title' => '<h3 class="widget-title">',
	    'after_title' => '</h3>',
	    ) );

	register_sidebar( array(
	    'name' => __( 'Footer Widget Area 3', 'twentytwelve' ),
	    'id' => 'footer-widget-3',
	    'description' => __( 'Widget area is displayed on a footer portion', 'twentytwelve' ),
	    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	    'after_widget' => '</aside>',
	    'before_title' => '<h3 class="widget-title">',
	    'after_title' => '</h3>',
	) );

	register_sidebar( array(
	    'name' => __( 'Footer Widget Area 4', 'twentytwelve' ),
	    'id' => 'footer-widget-4',
	    'description' => __( 'Widget area is displayed on a footer portion', 'twentytwelve' ),
	    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	    'after_widget' => '</aside>',
	    'before_title' => '<h3 class="widget-title">',
	    'after_title' => '</h3>',
	    ) );

	register_sidebar( array(
		'name' => __( 'Sales Letter Sidebar', 'twentytwelve' ),
		'id' => 'sidebar-10',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}

function twentytwelve_content_nav( $html_id ) {
	the_posts_pagination( array(
	    'mid_size'           => 2,
	    'prev_text'          => '前へ',
	    'next_text'          => '次へ',
	    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page' ) . ' </span>',
	) );
}

function close_page_comment( $open, $post_id ) {
    $post = get_post( $post_id );
    if ( $post && $post->post_type == 'page' ) {
        return false;
    }
    return $open;
}
add_filter( 'comments_open', 'close_page_comment', 10, 2 );

function is_mobile() {
   return preg_match(
	'{iPhone|iPod|(?:Android.+?Mobile)|BlackBerry9500|BlackBerry9530|BlackBerry9520|BlackBerry9550|BlackBerry9800|Windows Phone|webOS|(?:Firefox.+?Mobile)|Symbian|incognito|webmate|dream|CPUCAKE}', 
   $_SERVER['HTTP_USER_AGENT']);
}

function is_sk_ktai() {
	if ( function_exists('is_ktai') ) {
		return is_ktai();
	} else {
		return false;
	}
}

/*
	for sales letter short code
*/

function attr_func( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => 'default',
	), $atts ) );

	$content = do_shortcode( $content);
		
	return '<span class="' . $class. '">' . $content . '</span>';
}
add_shortcode('attr', 'attr_func');


/*************************************************************/

function is_noad() {
	global $g_ad_enabled;
	
	return !$g_ad_enabled || is_page('product') || is_page('law') || is_page('malmag') ||  is_404() 
		|| is_page_template('page-templates/full-width.php') 
		|| is_page_template('page-templates/law.php') 
		|| is_page_template('page-templates/sales-letter.php');
}

function sk_get_ad( $ad_type, $ad_name = '') {
//	if ( $ad_type == 'adsense' )
//		return;

	if ( is_noad() )
		return;

	$filename = STYLESHEETPATH . DIRECTORY_SEPARATOR . 'ad'. DIRECTORY_SEPARATOR;
	
	if ( $ad_name == '' ) {
		$filename .= 'ad';
	} else {
		$filename .= $ad_type . DIRECTORY_SEPARATOR;
	}

	$filename .= $ad_name . '.php';
	if ( file_exists( $filename) ) {
		$text = file_get_contents( $filename);
	} else {
		$text = '';
	}
	return $text;
}

function sk_get_the_ad( $ad_type, $ad_name = '') {
	echo sk_get_ad( $ad_type, $ad_name );
}

function sk_get_access_analy_google() {
	global $is_localhost, $domain_name;
	
	if ( $is_localhost ) {
		return;
	}
	
	if ( $domain_name == 'komish.com' ) {
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-4079996-8', 'auto', {'allowLinker': true});
	ga('create', 'UA-4079996-8', 'auto', {'useAmpClientId': true});
	ga('require', 'linker');
	ga('linker:autoLink', ['infocart.jp'] );
	ga('require', 'linkid', 'linkid.js');
	ga('send', 'pageview');

</script>
<script type="text/javascript">jQuery(function() {  
    jQuery("a").click(function(e) {        
        var ahref = jQuery(this).attr('href');
        if (ahref.indexOf("komish.com") != -1 || ahref.indexOf("http") == -1 ) {
            ga('send', 'event', 'internal-link', 'click', ahref);} 
        else { 
            ga('send', 'event', 'external-link', 'click', ahref);}
        });
    });
</script>
<?php
/*
セカンダリ用
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-4079996-8', 'auto', {'allowLinker': true});
  ga('require', 'linker');
  ga('linker:autoLink', ['komish.com'] );
  ga('send', 'pageview');

</script>
*/

	} else if ( $domain_name == 'members.komish.com' ) {
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-4079996-23', 'auto', {'allowLinker': true});
	ga('create', 'UA-4079996-23', 'auto', {'useAmpClientId': true});
	ga('require', 'linker');
	ga('linker:autoLink', ['infocart.jp'] );
	ga('require', 'linkid', 'linkid.js');
	ga('send', 'pageview');

</script>
<script type="text/javascript">jQuery(function() {  
    jQuery("a").click(function(e) {        
        var ahref = jQuery(this).attr('href');
        if (ahref.indexOf("members.komish.com") != -1) {
            ga('send', 'event', 'internal-link', 'click', ahref);} 
        else { 
            ga('send', 'event', 'external-link', 'click', ahref);}
        });
    });
</script>
<?php
	}
}

function sk_get_johnson_box( $atts, $content = null ) {
	return '<div class="johnson-box">' . $content . '</div>';
	$content = do_shortcode( $content );
}
add_shortcode('johnson', 'sk_get_johnson_box');

// http://www.mag2.com/m/0000279189.html

function sk_get_admlmg() {
	return '<p>メルマガ読者の方は合わせてお読み下さい。</p><p>今日のメルマガ配信は終わっているため、今登録してもこの記事を読むことはできません。</p><p><a href="/checklist-detail?bmg=' . get_the_date('ymd') . '&amp;p=c">それでも次回のメルマガ専用記事を読みたい人はこちらから登録して下さい。</a></p>';
}
add_shortcode('admlmg', 'sk_get_admlmg');

function sk_get_my_malmag_info() {
	return '<p><strong><a href="/checklist-detail?bmg=' . get_the_date('ymd') . '&amp;p=c">メールマガジンの登録がまだの方はこちらから登録して下さい。</a></strong></p>';
}
add_shortcode('malmag', 'sk_get_my_malmag_info');

function sk_get_pccontent( $atts, $content = null ) {
	if ( is_mobile() || is_sk_ktai() ) {
		return "";
	} else {
		$content = do_shortcode( $content );
		return $content;
	}
}
add_shortcode('pccontent', 'sk_get_pccontent');

function sk_get_ktaicontent( $atts, $content = null ) {
	if ( is_mobile() ||  is_sk_ktai() ) {
		$content = do_shortcode( $content );
		return $content;
	} else {
		return "";
	}
}
add_shortcode('ktaicontent', 'sk_get_ktaicontent');

function get_random_ad($fname) {
	if ( $fname === null ) 
		return;
	$var_name = $fname . '_link';
	$class_name = 'random_ad_'. $fname;

	echo '<div id="' . $class_name . '"></div>';
?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() . '/ad/', $fname; ?>.ad" charset="utf-8"></script><script type="text/javascript" language="javascript">num = Math.floor( Math.random() * <? echo $var_name; ?>.length );document.getElementById("<?php echo $class_name; ?>").innerHTML = <? echo $var_name; ?>[num];</script>
<?php
}

function get_random_ad2() {
?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/js/ad_code.js" charset="utf-8"></script>
<?php
	echo '<div id="random_ad"></div>';
?>
<script type="text/javascript" language="javascript">
num = Math.floor( Math.random() * ad_link.length );
document.getElementById("random_ad").innerHTML = ad_link[num];
</script>
<?php
}

function sk_excerpt_more($more) {
	return  '... <a href="'. esc_url( get_permalink() ) . '">続きを読む <span class="meta-nav">&rarr;</span></a>';
}
add_filter('excerpt_more', 'sk_excerpt_more');

function sk_remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}
add_filter('the_content_more_link', 'sk_remove_more_jump_link');

//本文中の<!--more-->タグをアドセンスに置換
/*
function replace_more_tag($the_content){
    //広告（AdSense）タグを記入
    if ( !is_noad() ) {
		$ad = sk_get_ad('adsense', 'mg_in_content');
		$the_content = preg_replace( '/(<p>)?<span id="more-([0-9]+?)"><\/span>(.*?)(<\/p>)?/i', "$ad$0", $the_content );
	}
	return $the_content;
}
add_filter('the_content', 'replace_more_tag');
*/

add_theme_support('automatic-feed-links');

function twentytwelve_footer_widget_class() {
    $count = 0;
  
    if ( is_active_sidebar( 'footer-widget-1' ) )
        $count++;
  
    if ( is_active_sidebar( 'footer-widget-2' ) )
        $count++;
  
    if ( is_active_sidebar( 'footer-widget-3' ) )
        $count++;
  
    if ( is_active_sidebar( 'footer-widget-4' ) )
        $count++;
  
    $class = '';
  
    switch ( $count ) {
        case '1':
            $class = 'one';
            break;
        case '2':
            $class = 'two';
            break;
        case '3':
            $class = 'three';
            break;
        case '4':
            $class = 'four';
            break;
    }
  
    if ( $class )
        echo $class;
}

/*
function my_theme_deregister_plugin_assets_header() {
  wp_dequeue_style('yarppWidgetCss');
  wp_deregister_style('yarppRelatedCss');
}
add_action( 'wp_print_styles', 'my_theme_deregister_plugin_assets_header' );

function my_theme_deregister_plugin_assets_footer() {
  wp_dequeue_style('yarppRelatedCss');
}
add_action( 'wp_footer', 'my_theme_deregister_plugin_assets_footer' );
*/

// Add CSS class by filter
add_filter('body_class','twentytwelvechild_body_class_adapt',20);

function twentytwelvechild_body_class_adapt( $classes ) {
	// Apply 'sales-letter' class to form_page.php body
	if ( is_page_template( 'page-templates/sales-letter.php' ) )
		$classes[] = 'sales-letter';
		
	if ( is_page_template( 'page-templates/law.php' ) )
		$classes[] = 'law';
	
	if ( is_page_template( 'page-templates/education.php' ) )
		$classes[] = 'education';
	
	if ( is_page_template( 'page-templates/user-info.php' ) )
		$classes[] = 'user-info';
	
	return $classes;
}

function sk_get_custom_field( $atts ) {
	extract( shortcode_atts( array(
		'name' => '',
		), $atts));

	return get_post_meta(get_the_ID(), $name, true); 
}
add_shortcode('customval', 'sk_get_custom_field');

function sk_get_custom_field_array( $atts ) {
	extract( shortcode_atts( array(
		'name' => '',
		), $atts));

	return get_post_meta(get_the_ID(), $name, false); 
}

function sk_get_url_param($param) {

	$val = (isset($_GET[$param]) && $_GET[$param] != "") ? $_GET[$param] : null;
	if ( $val === null ) {
		$val = '';
	} else {
		$val = htmlspecialchars($val, ENT_QUOTES);
	}
	return $val;
}

function sk_get_post_param($param) {

	$val = (isset($_POST[$param]) && $_POST[$param] != "") ? $_POST[$param] : null;
	if ( $val === null ) {
		$val = '';
	} else {
		$val = htmlspecialchars($val, ENT_QUOTES);
	}
	return $val;
}

function sk_get_cookie_param($param) {
	$val = (isset($_COOKIE[$param]) && $_COOKIE[$param] != "") ? $_COOKIE[$param] : null;
	if ( $val === null ) {
		$val = '';
	} else {
		$val = htmlspecialchars($val, ENT_QUOTES);
	}
	return $val;
}

/*
https://localhost/wordpress/archives/2924?ds=20160201&de=20160331
*/

function sk_get_campaign_param() {

	$begin_val = "camp_begin";
	$end_val = "camp_end";
	
/*
	echo $begin_val . ';';
	echo $end_val . ';';
*/
	
	$begin = get_post_meta(get_the_ID(), $begin_val , true);
	$end = get_post_meta(get_the_ID(), $end_val, true);

	return array($begin, $end);
}

function char2digit($str) {

	$one_char2digit = function($ch) {

		switch($ch) {
			case 'r':
				return 0;
				break;
			case 'n':
				return 1;
				break;
			case 'w':
				return 2;
				break;
			case 'h':
				return 3;
				break;
			case 'f':
				return 4;
				break;
			case 'v':
			  	return 5;
				break;
			case  'x';
			 	return 6;
				break;
			case  's':
			 	return 7;
				break;
			case  'g':
			 	return 8;
				break;
			case  'e':
			 	return 9;
				break;
			default:
				return -1;
				break;
		}
	};
		
	$v = '';
	
	for ($i = 0; $i < strlen($str); $i++) {
		$ch = $str[$i];
		$v = $v . $one_char2digit($ch);
	}
			
	return intval($v);
}

function get_limit_date_value() {
	$stat = sk_get_url_param('tp');
	if ( $stat == '' )
		return -1;
		
	$limit_str = substr($stat, -2, 1);
	
	return char2digi($limit_str);
}

function sk_is_campaign_in( $begin, $end ) {
	date_default_timezone_set('Asia/Tokyo');

    if ( $begin == 0 || $end == 0 ) {
		list ($begin, $end) = sk_get_campaign_param();

		$open = date( "Y/m/d H:i:s", strtotime( $begin  ) );
		$close = date( "Y/m/d H:i:s", strtotime( $end . ' +1 day' ) );
	} else {
		$open = date( "Y/m/d H:i:s", strtotime( $begin  ) );
		$close = date( "Y/m/d H:i:s", strtotime( $end ) );
	}
	
    $now = date( "Y/m/d H:i:s" );


/*
	echo date( "Y/m/d H:i:s;", strtotime($open) )  . '<br>';
	echo date( "Y/m/d H:i:s;", strtotime($now) ) . '<br>';
	echo date( "Y/m/d H:i:s;", strtotime($close) ) . '<br>';
	echo "<br>";
*/

    if ( strtotime($open) <= strtotime($now)  && strtotime($now) <= strtotime($close) ) {
		return true;
	} else {
		return false;
	}
}

function sk_get_campaign_end_date( $attrs, $content = null ){
	$end = get_post_meta(get_the_ID(), 'camp_end', true);

	if ( empty( $end) )
		return '';
		
	$close = date( "Y/m/d H:i:s", strtotime( $end ) );
	$s = date( 'n月j日', strtotime( $close ) );
	return mb_convert_kana($s, 'A', "utf-8");
	
}
add_shortcode('camplastdate', 'sk_get_campaign_end_date');

function sk_get_campaign_end_date2( $attrs, $content = null ){
	$end = get_post_meta(get_the_ID(), 'camp_end2', true);

	if ( empty( $end) )
		return '';
		
	$close = date( "Y/m/d H:i:s", strtotime( $end ) );
	$s = date( 'n月j日', strtotime( $close ) );
	return mb_convert_kana($s, 'A', "utf-8");
	
}
add_shortcode('camplastdate2', 'sk_get_campaign_end_date2');

function sk_get_campaign_in( $atts, $content = null ) {
    extract( shortcode_atts( array(
    	'begin' => 0,
    	'end' => 0
    	), $atts ));

	if ( sk_is_campaign_in($begin, $end ) ) {
		$content = do_shortcode( $content );
		return $content;
	} else {
		return '';
	}
}
add_shortcode('campin', 'sk_get_campaign_in');

function sk_get_campaign_out( $atts, $content = null ) {
    extract( shortcode_atts( array(
    	'begin' => 0,
    	'end' => 0
    	), $atts ));

	if ( !sk_is_campaign_in($begin, $end ) ) {
	    $content = do_shortcode( $content );
		return $content;
	} else {
		return '';
	}
}
add_shortcode('campout', 'sk_get_campaign_out');

function sk_set_widelist($atts, $content = null) {
	$content = do_shortcode( $content );
	return '<div class="widelist">'.$content.'</div>';
}
add_shortcode('widelist', 'sk_set_widelist');

function sk_set_checklist($atts, $content = null) {
    extract( shortcode_atts( array(
    	'color' => 'blue'
        ), $atts ));

	$content = do_shortcode( $content );

	if ( $color == 'red' )
		return '<div class="checklist_red">'.$content.'</div>';
	else
		return '<div class="checklist_blue">'.$content.'</div>';
	
}
add_shortcode('checklist', 'sk_set_checklist');

/*
function sk_get_product_list($atts, $content = null) {
	return '<ul>' . 
		 wp_list_pages('child_of=900&depth=1&title_li=&sort_column=ID&sort_order=DESC') .
		 '</ul>';
}
add_shortcode('products', 'sk_get_product_list');
*/

function sk_get_page_list($atts, $content = null) {
    extract( shortcode_atts( array(
    	'depth' => '0'
        ), $atts ));

	global $post;

	return '<ul>' . 
		 wp_list_pages('depth=' . $depth . '&child_of=' . $post->ID . '&title_li=&post_type=page&page_status=publish&sort_column=menu_order&sort_order=ASC') .
		 '</ul>';
}	
add_shortcode('pagelist', 'sk_get_page_list');


function sk_single_page_custom_menu($atts, $content = null) {
    extract(shortcode_atts(array(  
        'menu'            => '', 
        'container'       => 'div', 
        'container_class' => '', 
        'container_id'    => '', 
        'menu_class'      => 'menu', 
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'depth'           => 0,
        'walker'          => '',
        'theme_location'  => ''), 
        $atts));
  
  
    return wp_nav_menu( array( 
        'menu'            => $menu, 
        'container'       => $container, 
        'container_class' => $container_class, 
        'container_id'    => $container_id, 
        'menu_class'      => $menu_class, 
        'menu_id'         => $menu_id,
        'echo'            => false,
        'fallback_cb'     => $fallback_cb,
        'before'          => $before,
        'after'           => $after,
        'link_before'     => $link_before,
        'link_after'      => $link_after,
        'depth'           => $depth,
        'walker'          => $walker,
        'theme_location'  => $theme_location));
}
add_shortcode("cmenu", "sk_single_page_custom_menu");

add_filter('protected_title_format', 'remove_protected');
function remove_protected($title) {
       return '%s';
}

function my_password_form() {
  return
    '<p>この記事を読むにはパスワードが必要です。<a href="/malmag?frm=pw">パスワードはこちらのメルマガに書いてあります。</a><p>
    <form class="post_password" action="' . home_url() . '/wp-login.php?action=postpass" method="post">
    <input name="post_password" type="password" size="24" />
    <input type="submit" name="Submit" value="' . esc_attr__("パスワード送信") . '" />
    </form>';
}
add_filter('the_password_form', 'my_password_form');

function custom_search( $search ) {
	global $domain_name;
	
	if ( $domain_name === 'komish.com' ) {
		if ( is_search() && ! is_admin() ) {
			$search .= " AND post_type = 'post'";
		}
	}
	return $search;
}

add_filter( 'posts_search', 'custom_search' );

function getPrevNext(){
	global $post;
	
	$parent_id = $post->post_parent;
	
	if ($parent_id == -1)
		return;
	
	$pagelist = get_pages('sort_column=menu_order&sort_order=asc&hierarchical=0&parent=' . $parent_id);
	$pages = array();
	foreach ($pagelist as $page) {
	   $pages[] += $page->ID;
	}

	$current = array_search(get_the_ID(), $pages);
	if ( $current - 1 >= 0 ) {
		$prevID = $pages[$current-1];
	} else {
		$prevID = -1;
	}
	
	if ( $current + 1 < count($pages) ) {
		$nextID = $pages[$current+1];
	} else {
		$nextID = -1;
	}
	
	echo '<nav class="education">';
	
	echo '<div class="alignleft">';
	if ($prevID != -1) {
		echo '<a href="';
		echo get_permalink($prevID);
		echo '" title="';
		echo get_the_title($prevID); 
		echo'">';
	}
	echo '前へ';
	if ($prevID != -1) {
		'</a>';
	}
	echo "</div>";

	echo '<div class="aligncenter">';
		echo '<a href="';
		echo get_permalink($parent_id);
		echo '" title="';
		echo get_the_title($parent_id); 
		echo'">目次へ</a>';
	echo '</div>';
	
	echo '<div class="alignright">';
	if ($nextID != -1) {
		echo '<a href="';
		echo get_permalink($nextID);
		echo '" title="';
		echo get_the_title($nextID); 
		echo'">';
	}
	echo '次へ';
	if ($nextID != -1) {
		echo '</a>';
	}
	echo "</div></nav>";		
}	
?>