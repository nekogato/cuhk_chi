<?php
/**
 * cuhk_chi functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cuhk_chi
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cuhk_chi_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on cuhk_chi, use a find and replace
		* to change 'cuhk_chi' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'cuhk_chi', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'cuhk_chi' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'cuhk_chi_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);


	/* chung add - register image size */
	add_image_size( 'xl', 1920, 1080 );
	add_image_size( 'l', 1600, 1200 );
	add_image_size( 'm', 1200, 900 );
	add_image_size( 's', 500, 500, array( 'center', 'center' ) );
	add_image_size( 'xs', 200, 200, array( 'center', 'center' ) );
}
add_action( 'after_setup_theme', 'cuhk_chi_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cuhk_chi_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cuhk_chi_content_width', 640 );
}
add_action( 'after_setup_theme', 'cuhk_chi_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cuhk_chi_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'cuhk_chi' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'cuhk_chi' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'cuhk_chi_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cuhk_chi_scripts() {
	wp_enqueue_style( 'cuhk_chi-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'cuhk_chi-style', 'rtl', 'replace' );

	wp_enqueue_script( 'cuhk_chi-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'cuhk_chi-jquery', get_template_directory_uri() . '/script/lib/jquery-3.6.0.min.js', array(), '', false );
	wp_enqueue_script( 'cuhk_chi-ScrollMagic', get_template_directory_uri() . '/script/lib/ScrollMagic.min.js', array(), '', false );
	wp_enqueue_script( 'cuhk_chi-gsap', get_template_directory_uri() . '/script/lib/gsap.min.js', array(), '', false );
	wp_enqueue_style( 'cuhk_chi-swiper-style', get_template_directory_uri() . '/script/lib/swiper/css/swiper.min.css', '', '', 'all' );
	wp_enqueue_script( 'cuhk_chi-swiper', get_template_directory_uri() . '/script/lib/swiper/js/swiper.min.js', array('cuhk_chi-jquery'), '', false );
	wp_enqueue_style( 'cuhk_chi-fancy-style', get_template_directory_uri() . '/script/lib/fancybox/jquery.fancybox.min.css', '', '', 'all' );
	wp_enqueue_script( 'cuhk_chi-fancy', get_template_directory_uri() . '/script/lib/fancybox/jquery.fancybox.min.js', array('cuhk_chi-jquery'), '', false );
    
	wp_enqueue_style( 'cuhk_chi-adobe-font', 'https://use.typekit.net/gsi3slf.css', '', '', 'all' );
	
	wp_enqueue_style( 'cuhk_chi-fonts', get_template_directory_uri() . '/fonts/stylesheet.css', '', '', 'all' );
	wp_enqueue_style( 'cuhk_chi-main', get_template_directory_uri() . '/main.css', '', '', 'all' );
	wp_enqueue_style( 'cuhk_chi-module', get_template_directory_uri() . '/module.css', '', '', 'all' );
	
	wp_enqueue_script( 'cuhk_chi-script', get_template_directory_uri() . '/script/script.js', array('cuhk_chi-jquery'), '', false );
    

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cuhk_chi_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


function register_my_menu() {
	register_nav_menus( array(
		  'main-menu' => 'Main Menu',
	) );
}

add_action( 'init', 'register_my_menu' );
	

	

add_action('acf/init', function() { 
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
});


/**
 * This function returns a page permalink
 * for the current website language.
 *
 * @author  Mauricio Gelves <mg@maugelves.com>
 * @param   $page_slug      string          WordPress page slug
 * @return                  string|false    Page Permalink or false if the page is not found
 */
function pll_get_page_url( $page_slug ) {

	// Check parameter
	if( empty( $page_slug ) ) return false;
	
	// Get the page
	$page = get_page_by_path( $page_slug );

	// Check if the page exists
	if( empty( $page ) || is_null( $page ) ) return false;

	// Get the URL
	$page_ID_current_lang = pll_get_post( $page->ID );

	// Return the current language permalink
	return empty($page_ID_current_lang) ? get_permalink( $page->ID ) : get_permalink( $page_ID_current_lang );

}

add_action('wp_footer', 'pll_get_page_url');


function my_theme_add_editor_styles()
{
    add_editor_style('editor-style.css');
    add_editor_style(get_stylesheet_directory_uri() . '/fonts/stylesheet.css');
}

add_action('after_setup_theme', 'my_theme_add_editor_styles');