<?php

$g_domain_name = $_SERVER["SERVER_NAME"];
$is_localhost = $g_domain_name == 'localhost';

if ( $is_localhost ) {
	$g_analy_g_acount = 'UA-4079996-8';
	$g_domain_name = 'komish.com';
	$g_category_nav = false;
	$g_ad_enabled = false;
	$is_localhost = false;
} else {
	if ( $g_domain_name === 'komish.com' ) {
		$g_analy_g_acount = 'UA-4079996-8';
		$g_category_nav = false;
		$g_ad_enabled = true;
	} else if ( $g_domain_name === 'plus.komish.com' ) {
		$g_analy_g_acount = 'UA-4079996-23';
		$g_category_nav = true;
		$g_ad_enabled = false;
	}
}

// for debug
$g_ad_enabled = true;

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
	global $is_localhost, $g_analy_g_acount;
	
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
                'account' => $g_analy_g_acount
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
add_filter('protected_title_format', 'remove_protected');
function remove_protected($title) {
       return '%s';
}

/*
function my_password_form() {
  return
    '<p>この記事を読むにはパスワードが必要です。<p>
    <form class="post_password" action="' . home_url() . '/wp-login.php?action=postpass" method="post">
    <input name="post_password" type="password" size="24" />
    <input type="submit" name="Submit" value="' . esc_attr__("パスワード送信") . '" />
    </form>';
}
add_filter('the_password_form', 'my_password_form');
*/

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