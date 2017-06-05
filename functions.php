<?php
/**
 * Near Perfection functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Near_Perfection
 */

/**
 * AUTO DEV MODE - Define you local hostname
 */
$devEnv = (gethostname() == 'Ryans-MacBook-Pro.local' ? true : false);
$templatePath = get_template_directory_uri();
$currentFile = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

/**
 * Preload links
 */
if (!is_admin() && $currentFile != 'wp-login.php') {
	header("Link: <".$GLOBALS['templatePath']."/script.js>; rel=preload; as=script", false);
	header("Link: <./wp-includes/js/wp-embed.min.js?ver=".get_bloginfo('version').">; rel=preload; as=script", false);
	header("Link: <".$GLOBALS['templatePath']."/fonts/fontawesome-webfont.woff2?v=4.7.0>; rel=preload; as=font; crossorigin; type=font/woff2", false);
}

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/maillogo.png);
        }
        #login h1::after, .login h1::after{
        	content: '<?=bloginfo( 'name' )?>';
        }
        #login::after{
        	content: 'A Cutter May Site';
        	width: 100%;
        	text-align: center;
        	float: left;
        	margin-top: 0.5em;
        }

        #login .message, #login_error{
        	margin-top: 2em;
        }
        #nav a, #backtoblog a{
        	display: block;
        	text-align: center;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_custom_admin_head() { ?>
	<style type="text/css">
		#wpbody-content{
			margin-top: 80px;
		}

		#wpbody-content::before{
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/maillogo.png);
			background-repeat: no-repeat;
			position: absolute;
			left: 0;
			margin-top: -55px;
			height: 60px;
			width: 60px;
			content: '';
		}
	</style>
<? }
add_action( 'admin_head', 'my_custom_admin_head' );


if ( ! function_exists( 'near_perfection_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function near_perfection_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Near Perfection, use a find and replace
	 * to change 'near_perfection' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'near_perfection', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'near_perfection-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'near_perfection' ),
		'footer' => esc_html__( 'Footer', 'near_perfection' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'near_perfection_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'near_perfection_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function near_perfection_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'near_perfection_content_width', 640 );
}
add_action( 'after_setup_theme', 'near_perfection_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function near_perfection_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'near_perfection' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'near_perfection' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'near_perfection_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function defer_parsing_of_js ( $url ) {
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    // return "$url' defer ";
    return "$url' defer onload='";
}
add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );

function near_perfection_scripts() {
	wp_enqueue_script( 'near_perfection-script', $GLOBALS['templatePath'] . '/script.js', array(), null, true );
	add_action( 'wp_footer', function(){echo '<script>var templateUrl ="'.$GLOBALS['templatePath'].'" </script>';} );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'near_perfection_scripts' );

function inline_style() {
	if($GLOBALS['devEnv']){
		$output="<link rel='stylesheet' id='near_perfection-style-css' href='".$GLOBALS['templatePath']."/style.css' type='text/css' media='all'>";
	}else{
		ob_start();
		include 'style.css';
		$inlineStyle = ob_get_clean();
		$inlineStyle = str_replace("fonts/", get_template_directory_uri()."/fonts/", $inlineStyle);
		$inlineStyle = str_replace("./img/", get_template_directory_uri()."/img/", $inlineStyle);
		$output='<style type="text/css">'.$inlineStyle.'</style>';
	}
	echo $output;
}
add_action('wp_head','inline_style');

function add_google_analytics() {
	if(!$GLOBALS['devEnv']){
		include_once("analytics.php");
	}
}
add_action('wp_head', 'add_google_analytics');


/**
 * Favicon Links
 */
function blog_favicon() {
echo
'<link rel="apple-touch-icon" sizes="180x180" href="'.$GLOBALS['templatePath'].'/favicons/apple-touch-icon.png">',
'<link rel="icon" type="image/png" href="'.$GLOBALS['templatePath'].'/favicons/favicon-32x32.png" sizes="32x32">',
'<link rel="icon" type="image/png" href="'.$GLOBALS['templatePath'].'/favicons/favicon-16x16.png" sizes="16x16">',
'<link rel="manifest" href="'.$GLOBALS['templatePath'].'/favicons/manifest.json">',
'<link rel="mask-icon" href="'.$GLOBALS['templatePath'].'/favicons/safari-pinned-tab.svg" color="#5bbad5">',
'<link rel="shortcut icon" href="'.$GLOBALS['templatePath'].'/favicon.ico">',
'<meta name="msapplication-config" content="'.$GLOBALS['templatePath'].'/favicons/browserconfig.xml">',
'<meta name="theme-color" content="#ffffff">';
}

add_action('wp_head', 'blog_favicon');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';