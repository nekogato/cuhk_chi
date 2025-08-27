<?php

/**
 * cuhk_chi functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cuhk_chi
 */

define('MPHIL_PHD_RESEARCH_MAX_POSTS', 20);
define('PUBLICATIONS_PER_PAGE', 20);
define('NEWS_PER_PAGE', 21);
define('EVENTS_PER_PAGE', 20);
define('MAX_POSTGRADUATE_STUDENTS_PER_PAGE', 20);
define('MAX_DEPARTMENT_NEWS', 21);

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cuhk_chi_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on cuhk_chi, use a find and replace
		* to change 'cuhk_chi' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('cuhk_chi', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'cuhk_chi'),
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
	add_theme_support('customize-selective-refresh-widgets');

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
	add_image_size('xl', 1920, 1080);
	add_image_size('l', 1600, 1200);
	add_image_size('m', 1200, 900);
	add_image_size('929x465', 929, 465, array('center', 'center'));
	add_image_size('392x202', 392, 202, array('center', 'center'));
	add_image_size('287x155', 287, 155, array('center', 'center'));
	add_image_size('s', 500, 500, array('center', 'center'));
	add_image_size('xs', 200, 200, array('center', 'center'));
	add_image_size('department-news-featured', 650, 366, array('center', 'center'));
	add_image_size('department-news-regular', 193, 9999); // 193px width, auto height
	add_image_size('testimonial-popup', 400, 9999); // 400px width, auto height for testimonial popups
}
add_action('after_setup_theme', 'cuhk_chi_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cuhk_chi_content_width()
{
	$GLOBALS['content_width'] = apply_filters('cuhk_chi_content_width', 640);
}
add_action('after_setup_theme', 'cuhk_chi_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cuhk_chi_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'cuhk_chi'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'cuhk_chi'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'cuhk_chi_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function cuhk_chi_scripts()
{
	wp_enqueue_style('cuhk_chi-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('cuhk_chi-style', 'rtl', 'replace');

	wp_enqueue_script('cuhk_chi-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	wp_enqueue_script('cuhk_chi-jquery', get_template_directory_uri() . '/script/lib/jquery-3.6.0.min.js', array(), '', false);
	wp_enqueue_script('cuhk_chi-ease', get_template_directory_uri() . '/script/lib/jquery.easing.min.js', array(), '', false);
	wp_enqueue_script('cuhk_chi-ScrollMagic', get_template_directory_uri() . '/script/lib/ScrollMagic.min.js', array(), '', false);
	wp_enqueue_script('cuhk_chi-gsap', get_template_directory_uri() . '/script/lib/gsap.min.js', array(), '', false);
	wp_enqueue_style('cuhk_chi-swiper-style', get_template_directory_uri() . '/script/lib/swiper/css/swiper.min.css', '', '', 'all');
	wp_enqueue_script('cuhk_chi-swiper', get_template_directory_uri() . '/script/lib/swiper/js/swiper.min.js', array('cuhk_chi-jquery'), '', false);
	wp_enqueue_style('cuhk_chi-fancy-style', get_template_directory_uri() . '/script/lib/fancybox/jquery.fancybox.min.css', '', '', 'all');
	wp_enqueue_script('cuhk_chi-fancy', get_template_directory_uri() . '/script/lib/fancybox/jquery.fancybox.min.js', array('cuhk_chi-jquery'), '', false);
	wp_enqueue_style('cuhk_chi-perfect-scrollbar-style', get_template_directory_uri() . '/script/lib/perfect-scrollbar.css', '', '', 'all');
	wp_enqueue_script('cuhk_chi-perfect-scrollbar', get_template_directory_uri() . '/script/lib/perfect-scrollbar.js', array('cuhk_chi-jquery'), '', false);

	// Add Alpine.js only for postgraduate research students template
	if (is_page_template('tmp-postgraduate_research_students.php') || is_page_template('tmp-teaching-staff.php') || is_page_template('tmp-course-index.php') || is_page_template('tmp-research_project.php') || is_page_template('tmp-events.php') || is_page_template('tmp-old_events_index.php') || is_page_template('tmp-languageevents.php') || is_page_template('tmp-home.php') || is_page_template('tmp-gallery.php') || is_page_template('tmp-news.php') || is_page_template('tmp-search.php')) {
		wp_enqueue_script('alpinejs', 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js', array(), '3.13.3', true);
		wp_script_add_data('alpinejs', 'defer', true);
	}

	// Add audio script for about song template
	if (is_page_template('tmp-about_song.php')) {
		wp_enqueue_script('cuhk_chi-audio', get_template_directory_uri() . '/script/audio.js', array('cuhk_chi-jquery'), '', false);
		wp_enqueue_style('cuhk_chi-audio-style', get_template_directory_uri() . '/audio.css', '', '', 'all');
	}

	wp_enqueue_style('cuhk_chi-adobe-font', 'https://use.typekit.net/gsi3slf.css', '', '', 'all');

	wp_enqueue_style('cuhk_chi-fonts', get_template_directory_uri() . '/fonts/stylesheet.css', '', '', 'all');
	wp_enqueue_style('cuhk_chi-main', get_template_directory_uri() . '/main.css', '', '', 'all');
	wp_enqueue_style('cuhk_chi-module', get_template_directory_uri() . '/module.css', '', '', 'all');

	wp_enqueue_script('cuhk_chi-script', get_template_directory_uri() . '/script/script.js', array('cuhk_chi-jquery'), '', false);


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'cuhk_chi_scripts');

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
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


function register_my_menu()
{
	register_nav_menus(array(
		'main-menu' => 'Main Menu',
	));
}

add_action('init', 'register_my_menu');




add_action('acf/init', function () {
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

function pll_get_page_id_by_slug($page_slug)
{
	if (empty($page_slug)) return false;

	// Get the base page object by slug
	$page = get_page_by_path($page_slug);
	if (empty($page)) return false;

	// Use Polylang to get the ID in the current language
	return function_exists('pll_get_post') ? pll_get_post($page->ID) : $page->ID;
}

function my_theme_add_editor_styles()
{
	add_editor_style('editor-style10.css');
	add_editor_style(get_stylesheet_directory_uri() . '/fonts/stylesheet.css');
}

add_action('after_setup_theme', 'my_theme_add_editor_styles');

// AJAX handler for loading more posts
function load_more_mphil_phd_research_post()
{
	check_ajax_referer('load_more_nonce', 'nonce');

	$page = $_POST['page'];

	$args = array(
		'post_type' => 'mphil_phd_research',
		'posts_per_page' => MPHIL_PHD_RESEARCH_MAX_POSTS,
		'orderby' => 'date',
		'order' => 'DESC',
		'paged' => $page,
		'post_status' => 'publish'
	);

	$query = new WP_Query($args);
	$html = '';

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			// Get custom fields
			$student_name = get_field('student_name');
			$degree = get_field('degree');
			$publish_year = get_field('publish_year');
			$programme = get_field('programme_specialties');
			$thesis_title = get_field('thesis_title');

			ob_start();
?>
			<div class="research_thesis_list scrollin scrollinbottom col_wrapper">
				<div class="row flex">
					<div class="col col2">
						<div class="col_spacing">
							<div class="t_wrapper">
								<div class="t">
									<div class="t1 text8"><?php echo pll__('Student Name'); ?></div>
									<div class="t2 text5"><?php echo esc_html($student_name); ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col col3">
						<div class="col_spacing">
							<div class="t_wrapper">
								<div class="t">
									<div class="t1 text8"><?php echo pll__('Degree'); ?></div>
									<div class="t2 text6"><?php echo esc_html($degree); ?></div>
								</div>
								<div class="t">
									<div class="t1 text8"><?php echo pll__('Publish Year'); ?></div>
									<div class="t2"><?php echo esc_html($publish_year); ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col col7">
						<div class="col_spacing">
							<div class="t_wrapper">
								<div class="t">
									<div class="t1 text8"><?php echo pll__('Programme/ Specialties'); ?></div>
									<div class="t2"><?php echo esc_html($programme); ?></div>
								</div>
								<div class="t">
									<div class="t1 text8"><?php echo pll__('Thesis Title'); ?></div>
									<div class="t2"><?php echo esc_html($thesis_title); ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
			$html .= ob_get_clean();
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_load_more_mphil_phd_research_post', 'load_more_mphil_phd_research_post');
add_action('wp_ajax_nopriv_load_more_mphil_phd_research_post', 'load_more_mphil_phd_research_post');

// AJAX handler for loading more publications
function load_more_publications()
{
	check_ajax_referer('load_more_publications_nonce', 'nonce');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;

	$args = array(
		'post_type' => 'publication',
		'posts_per_page' => PUBLICATIONS_PER_PAGE,
		'paged' => $page,
		'post_status' => 'publish'
	);

	$publications = new WP_Query($args);
	$html = '';

	if ($publications->have_posts()) {
		while ($publications->have_posts()) {
			$publications->the_post();

			// Get custom fields
			$author = get_field('author');
			$publisher = get_field('publisher');
			$publish_year = get_field('publish_year');
			$cover_image = get_field('cover_photo');

			ob_start();
		?>
			<div class="publication_box scrollin scrollinbottom">
				<div class="publication_thumb">
					<div class="thumb">
						<?php if ($cover_image) : ?>
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url($cover_image['url']); ?>" alt="<?php echo esc_attr($cover_image['alt']); ?>">
							</a>
						<?php endif; ?>
					</div>
				</div>
				<div class="publication_text">
					<div class="publication_text_item text5 book_name"><?php the_title(); ?></div>
					<?php if ($author) : ?>
						<div class="publication_text_item">
							<div class="title text7"><?php pll_e('作者'); ?></div>
							<div class="text text5"><?php echo esc_html($author); ?></div>
						</div>
					<?php endif; ?>
					<?php if ($publisher) : ?>
						<div class="publication_text_item">
							<div class="title text7"><?php pll_e('出版社'); ?></div>
							<div class="text text5"><?php echo esc_html($publisher); ?></div>
						</div>
					<?php endif; ?>
					<?php if ($publish_year) : ?>
						<div class="publication_text_item">
							<div class="title text7"><?php pll_e('出版年份'); ?></div>
							<div class="text text5"><?php echo esc_html($publish_year); ?></div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php
			$html .= ob_get_clean();
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'html' => $html,
		'has_more' => $page < $publications->max_num_pages
	));
}
add_action('wp_ajax_load_more_publications', 'load_more_publications');
add_action('wp_ajax_nopriv_load_more_publications', 'load_more_publications');

function load_more_news()
{
	check_ajax_referer('load_more_nonce', 'nonce');

	$page = $_POST['page'];
	$offset = ($page * NEWS_PER_PAGE); // Add 2 to account for featured posts

	$args = array(
		'post_type' => 'news',
		'posts_per_page' => NEWS_PER_PAGE,
		'offset' => $offset,
		'meta_key' => 'start_date',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'post_status' => 'publish'
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$news_banner = get_field('news_banner');
		?>
			<div class="news_box col col4">
				<div class="col_spacing scrollin scrollinbottom">
					<a class="photo" href="<?php the_permalink(); ?>">
						<?php if ($news_banner): ?>
							<img src="<?php echo esc_url($news_banner['url']); ?>" alt="<?php echo esc_attr($news_banner['alt']); ?>">
						<?php else: ?>
							<img src="<?php echo get_template_directory_uri(); ?>/images/schoolart_logo_bg.svg" alt="" />
						<?php endif; ?>
					</a>
					<div class="text_wrapper">
						<div class="date_wrapper text5">
							<?php
							$start_date_raw = get_field('start_date'); // This is in Ymd format, e.g. 20250622
							if ($start_date_raw) {
								$date_obj = DateTime::createFromFormat('Ymd', $start_date_raw);
								echo $date_obj->format('j/n/Y');
							}
							?>
						</div>
						<div class="title_wrapper">
							<div class="title text5"><?php the_title(); ?></div>
							<div class="btn_wrapper text7">
								<a href="<?php the_permalink(); ?>" class="round_btn"><?php pll_e('view more'); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		wp_reset_postdata();
	}

	die();
}
add_action('wp_ajax_load_more_news', 'load_more_news');
add_action('wp_ajax_nopriv_load_more_news', 'load_more_news');

function load_google_maps_script()
{
	if (is_page_template('tmp-about_contact.php')) {
		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBf7lvMAu5CR6kOUpRB3XVKjYixA8G9rec&callback=initMap', array(), null, true);
	}
}
add_action('wp_enqueue_scripts', 'load_google_maps_script');


/**
 * Convert English month abbreviation to Chinese month name
 *
 * @param string $month_abbr English month abbreviation (e.g., 'Jan', 'Feb')
 * @return string Chinese month name (e.g., '一月', '二月')
 */
function get_chinese_month($month_abbr)
{
	$chinese_months = array(
		'Jan' => '一月',
		'Feb' => '二月',
		'Mar' => '三月',
		'Apr' => '四月',
		'May' => '五月',
		'Jun' => '六月',
		'Jul' => '七月',
		'Aug' => '八月',
		'Sep' => '九月',
		'Oct' => '十月',
		'Nov' => '十一月',
		'Dec' => '十二月'
	);

	return isset($chinese_months[$month_abbr]) ? $chinese_months[$month_abbr] : $month_abbr;
}

/**
 * Format date with Chinese day names
 *
 * @param int|string $timestamp Unix timestamp or date string
 * @param string $format Date format (default: 'j/n/Y（{day}）')
 * @return string Formatted date with Chinese day name
 */
function format_chinese_date($timestamp = null, $format = 'j/n/Y（{day}）')
{
	// Use current post time if no timestamp provided
	if ($timestamp === null) {
		$timestamp = get_post_time('U');
	}

	// Convert to timestamp if it's a date string
	if (!is_numeric($timestamp)) {
		$timestamp = strtotime($timestamp);
	}

	$date_obj = DateTime::createFromFormat('U', $timestamp);

	$chinese_days = array(
		'Monday' => '星期一',
		'Tuesday' => '星期二',
		'Wednesday' => '星期三',
		'Thursday' => '星期四',
		'Friday' => '星期五',
		'Saturday' => '星期六',
		'Sunday' => '星期日'
	);

	$english_day = $date_obj->format('l');
	$chinese_day = $chinese_days[$english_day];

	// Replace {day} placeholder with temporary placeholder that won't conflict with PHP date formatting
	$temp_format = str_replace('{day}', '___', $format);

	// Format the date using PHP date formatting
	$formatted_date = $date_obj->format($temp_format);

	// Replace temporary placeholder with Chinese day name
	return str_replace('___', $chinese_day, $formatted_date);
}

// AJAX handler for loading postgraduate students
function load_postgraduate_students()
{
	check_ajax_referer('load_postgraduate_students_nonce', 'nonce');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$alphabet = isset($_POST['alphabet']) ? strtoupper(sanitize_text_field($_POST['alphabet'])) : '';
	$degree = isset($_POST['degree']) ? sanitize_text_field($_POST['degree']) : '';

	// Get the category ID for postgraduate-research-students
	$category = get_term_by('slug', 'postgraduate-research-students', 'people_category');

	if (!$category) {
		wp_send_json_error('Category not found');
		return;
	}

	$args = array(
		'post_type' => 'profile',
		'posts_per_page' => MAX_POSTGRADUATE_STUDENTS_PER_PAGE,
		'paged' => $page,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'people_category',
				'field' => 'term_id',
				'terms' => $category->term_id
			)
		)
	);

	// Add meta query for degree and alphabet if specified
	$meta_query = array('relation' => 'AND');

	if ($degree) {
		$meta_query[] = array(
			'key' => 'filter_degree',
			'value' => $degree,
			'compare' => '='
		);
	}

	if ($alphabet) {
		$meta_query[] = array(
			'key' => 'filter_alphabet',
			'value' => $alphabet,
			'compare' => '='
		);
	}

	if (count($meta_query) > 1) {
		$args['meta_query'] = $meta_query;
	}

	$query = new WP_Query($args);
	$students = array();

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			$photo = get_field('photo');
			$position = get_field('position');
			$description = get_field('description');
			$address = get_field('address');
			$qualifications = get_field('qualifications');

			// Get contact information
			$emails = array();
			$phones = array();
			$faxes = array();

			if (have_rows('email')) {
				while (have_rows('email')) {
					the_row();
					$emails[] = get_sub_field('email');
				}
			}

			if (have_rows('phone')) {
				while (have_rows('phone')) {
					the_row();
					$phones[] = get_sub_field('phone');
				}
			}

			if (have_rows('fax')) {
				while (have_rows('fax')) {
					the_row();
					$faxes[] = get_sub_field('fax');
				}
			}

			$student = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'position' => $position,
				'description' => $description,
				'address' => $address,
				'emails' => $emails,
				'phones' => $phones,
				'faxes' => $faxes,
				'qualifications' => $qualifications,
				'has_detail' => (bool) get_field('has_detail'),
				'permalink' => get_permalink(get_the_ID())
			);

			if ($photo) {
				$student['photo'] = array(
					'sizes' => array(
						's' => $photo['sizes']['s'],
						'l' => $photo['sizes']['l']
					),
					'alt' => $photo['alt']
				);
			}

			$students[] = $student;
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'students' => $students,
		'has_more' => $page < $query->max_num_pages
	));
}
add_action('wp_ajax_load_postgraduate_students', 'load_postgraduate_students');
add_action('wp_ajax_nopriv_load_postgraduate_students', 'load_postgraduate_students');

// AJAX handler for loading teaching staff
function load_teaching_staff()
{
	check_ajax_referer('load_teaching_staff_nonce', 'nonce');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$position = isset($_POST['position']) ? sanitize_text_field($_POST['position']) : '';
	$sort_order = isset($_POST['sort_order']) ? sanitize_text_field($_POST['sort_order']) : 'asc';

	// Get the parent term (teaching-staff)
	$category = get_term_by('slug', 'teaching-staff', 'people_category');

	if (!$category) {
		wp_send_json_error('Category not found');
		return;
	}

	// Build tax_query
	$tax_query = array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'people_category',
			'field' => 'term_id',
			'terms' => $category->term_id,
			'include_children' => true // this ensures we get all children of teaching-staff
		)
	);

	if ($position) {
		$tax_query[] = array(
			'taxonomy' => 'people_category',
			'field' => 'slug',
			'terms' => $position
		);
	}

	$args = array(
		'post_type' => 'profile',
		'posts_per_page' => -1,
		'paged' => $page,
		'order' => 'asc',
		'tax_query' => $tax_query,
		'post_status' => 'publish'
	);

	// Change ordering based on current language
	if (function_exists('pll_current_language')) {
		$current_lang = pll_current_language();

		if ($current_lang == 'tc') {
			// Order by number of strokes (numeric)
			$args['meta_key'] = 'strokes';
			$args['orderby'] = 'meta_value_num';
		} elseif ($current_lang == 'sc') {
			// Order by pinyin (text)
			$args['meta_key'] = 'pinyin';
			$args['orderby'] = 'meta_value';
		} else {
			// Order by English name (text)
			$args['meta_key'] = 'english_name';
			$args['orderby'] = 'meta_value';
		}
	} else {
		// Fallback to ordering by title if Polylang not available
		$args['orderby'] = 'title';
	}




	// No meta_query needed anymore

	$query = new WP_Query($args);

	$staff = array();

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			$photo = get_field('photo');
			$position = get_field('position');
			$description = get_field('description');
			$address = get_field('address');
			$qualifications = get_field('qualifications');
			$research_interests = get_field('research_interests');
			$office_hours = get_field('office_hours');

			// Get contact information
			$emails = array();
			$phones = array();
			$faxes = array();

			if (have_rows('email')) {
				while (have_rows('email')) {
					the_row();
					$emails[] = get_sub_field('email');
				}
			}

			if (have_rows('phone')) {
				while (have_rows('phone')) {
					the_row();
					$phones[] = get_sub_field('phone');
				}
			}

			if (have_rows('fax')) {
				while (have_rows('fax')) {
					the_row();
					$faxes[] = get_sub_field('fax');
				}
			}

			$staff_member = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'position' => $position,
				'description' => $description,
				'address' => $address,
				'emails' => $emails,
				'phones' => $phones,
				'faxes' => $faxes,
				'qualifications' => $qualifications,
				'research_interests' => $research_interests,
				'office_hours' => $office_hours,
				'has_detail' => (bool) get_field('has_detail'),
				'permalink' => get_permalink(get_the_ID())
			);

			if ($photo) {
				$staff_member['photo'] = array(
					'sizes' => array(
						's' => $photo['sizes']['s'],
						'l' => $photo['sizes']['l']
					),
					'alt' => $photo['alt']
				);
			}else{
				$staff_member['photo'] = array(
					'sizes' => array(
						's' => get_template_directory_uri()."/images/schoolart_logo_bg.svg",
						'l' => get_template_directory_uri()."/images/schoolart_logo_bg.svg",
					),
					'alt' => ""
				);
			}
			

			$staff[] = $staff_member;
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'staff' => $staff,
		'has_more' => $page < $query->max_num_pages
	));
}
add_action('wp_ajax_load_teaching_staff', 'load_teaching_staff');
add_action('wp_ajax_nopriv_load_teaching_staff', 'load_teaching_staff');

// AJAX handler for loading courses
function load_courses()
{
	// Verify nonce
	if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_courses_nonce')) {
		wp_send_json_error('Invalid nonce');
		return;
	}

	// Get parameters from $_POST
	$categories = isset($_POST['categories']) ? $_POST['categories'] : [];
	$academic_year = isset($_POST['academic_year']) ? sanitize_text_field($_POST['academic_year']) : '';
	$course_type = isset($_POST['course_type']) ? sanitize_text_field($_POST['course_type']) : '';

	// Log the received data for debugging
	error_log('Received POST data: ' . print_r($_POST, true));
	error_log('Categories: ' . print_r($categories, true));
	error_log('Academic year: ' . $academic_year);
	error_log('Course type: ' . $course_type);

	// Build taxonomy query for filtering
	$tax_query = array('relation' => 'AND');

	if ($academic_year) {
		$tax_query[] = array(
			'taxonomy' => 'course_year',
			'field'    => 'slug',
			'terms'    => sanitize_title($academic_year)
		);
	}

	if ($course_type) {
		$tax_query[] = array(
			'taxonomy' => 'course_type',
			'field'    => 'slug',
			'terms'    => sanitize_title($course_type)
		);
	}

	// Filter by course categories only if categories are selected
	if (!empty($categories)) {
		$tax_query[] = array(
			'taxonomy' => 'course_category',
			'field'    => 'slug',
			'terms'    => $categories,
			'operator' => 'IN'
		);
	}

	$args = array(
		'post_type' => 'course',
		'posts_per_page' => -1,
		'meta_key'       => 'course_code', // for ordering
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'tax_query' => $tax_query,
		'post_status' => 'publish'
	);

	$courses_query = new WP_Query($args);
	$course_sections = array();

	if ($courses_query->have_posts()) {
		$courses_by_category = array();

		while ($courses_query->have_posts()) {
			$courses_query->the_post();

			// Get ACF fields
			$course_code = get_field('course_code');
			$course_title = get_field('Course_Title');
			$course_unit = get_field('course_unit');
			$language = get_field('language');
			$lecture_time = get_field('lecture_time');
			$venue = get_field('venue');
			$quota = get_field('Quota');
			$course_description = get_field('course_description');
			$has_detail = get_field('has_detail');

			// Get lecturer
			$lecturer = get_field('lecturer');
			$lecturer_name = $lecturer ? get_the_title($lecturer->ID) : '';

			$course_pdfs = array();

			if (have_rows('course_pdf')) {
				while (have_rows('course_pdf')) {
					the_row();
					$course_pdfs[] = array(
						'url' => get_sub_field('file')['url'],
						'text' => get_sub_field('download_text')
					);
				}
			}

			// Prepare course data
			$course_data = array(
				'id' => get_the_ID(),
				'course_code' => $course_code,
				'course_title' => $course_title,
				'course_unit' => $course_unit,
				'lecturer_name' => $lecturer_name,
				'language' => $language,
				'lecture_time' => $lecture_time,
				'venue' => $venue,
				'quota' => $quota,
				'course_description' => $course_description,
				'has_detail' => (bool) $has_detail,
				'permalink' => get_permalink(),
				'course_pdfs' => $course_pdfs,
			);

			// Get course_semester terms
			$academic_terms = wp_get_post_terms(get_the_ID(), 'course_semester');

			if (!empty($academic_terms) && !is_wp_error($academic_terms)) {
				foreach ($academic_terms as $term) {
					$term_name = $term->name;

					if (function_exists('pll_current_language')) {
						if (pll_current_language() == 'tc') {
							$term_name = get_field('tc_name', 'course_semester_' . $term->term_id);
						} elseif (pll_current_language() == 'sc') {
							$term_name = get_field('sc_name', 'course_semester_' . $term->term_id);
						} else {
							$term_name = get_field('en_name', 'course_semester_' . $term->term_id);
						};
					}


					if (!isset($courses_by_category[$term_name])) {
						$courses_by_category[$term_name] = array();
					}
					$courses_by_category[$term_name][] = $course_data;
				}
			} else {
				// No term assigned
				// $other = cuhk_multilang_text("其他", "", "Other");
				// if (!isset($courses_by_category[$other])) {
				// 	$courses_by_category[$other] = array();
				// }
				// $courses_by_category[$other][] = $course_data;
			}
		}

		// ✅ Reorder $courses_by_category based on course_semester term menu_order
		$sorted_courses_by_category = [];
		$ordered_terms = get_terms(array(
			'taxonomy' => 'course_semester',
			'hide_empty' => false,
			'orderby' => 'term_order', // plugin must support this
			'order' => 'ASC'
		));

		foreach ($ordered_terms as $term) {
			$term_name = $term->name;
			if (function_exists('pll_current_language')) {
				if (pll_current_language() == 'tc') {
					$term_name = get_field('tc_name', 'course_semester_' . $term->term_id);
				} elseif (pll_current_language() == 'sc') {
					$term_name = get_field('sc_name', 'course_semester_' . $term->term_id);
				} else {
					$term_name = get_field('en_name', 'course_semester_' . $term->term_id);
				};
			}
			if (isset($courses_by_category[$term_name])) {
				$sorted_courses_by_category[$term_name] = $courses_by_category[$term_name];
			}
		}

		// // Add "Other" to the end if present
		// $other = cuhk_multilang_text("其他", "", "Other");
		// if (isset($courses_by_category[$other])) {
		// 	$sorted_courses_by_category[$other] = $courses_by_category[$other];
		// }


		// Convert to the format expected by Alpine.js
		foreach ($sorted_courses_by_category as $category_name => $courses) {
			$course_sections[] = array(
				'name' => $category_name,
				'courses' => $courses
			);
		}

		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'course_sections' => $course_sections
	));
}
add_action('wp_ajax_load_courses', 'load_courses');
add_action('wp_ajax_nopriv_load_courses', 'load_courses');

// AJAX handler for loading more department news
function load_more_department_news()
{
	check_ajax_referer('load_more_department_news_nonce', 'nonce');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;

	$args = array(
		'post_type' => 'department_news',
		'posts_per_page' => MAX_DEPARTMENT_NEWS,
		'paged' => $page + 1, // +1 because we're loading the next page
		'orderby' => 'date',
		'order' => 'DESC',
		'post_status' => 'publish',
		'offset' => ($page * MAX_DEPARTMENT_NEWS) // +2 to skip featured posts
	);

	$query = new WP_Query($args);
	$html = '';

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			$banner_url = get_the_post_thumbnail_url(get_the_ID(), 'm');
			$banner_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

			// Get category from taxonomy
			$categories = wp_get_post_terms(get_the_ID(), 'department-category');
			$category_name = !empty($categories) ? $categories[0]->name : '';

			ob_start();
		?>
			<div class="news_box col col4">
				<div class="col_spacing scrollin scrollinbottom">
					<a class="photo" href="<?php the_permalink(); ?>">
						<?php if ($banner_url): ?>
							<img src="<?php echo esc_url(banner_url); ?>" alt="<?php echo esc_attr($banner_alt); ?>">
						<?php else: ?>
							<img src="<?php echo get_template_directory_uri(); ?>/images/schoolart_logo_bg.svg" alt="" />
						<?php endif; ?>
					</a>
					<div class="text_wrapper">
						<div class="date_wrapper text5"><?php echo get_the_date('M d'); ?></div>
						<div class="title_wrapper">
							<div class="cat"><?php echo esc_html($category_name); ?></div>
							<div class="title text5"><?php the_title(); ?></div>
							<div class="btn_wrapper text7">
								<a href="<?php the_permalink(); ?>" class="round_btn"><?php pll_e('了解更多'); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php
			$html .= ob_get_clean();
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'html' => $html,
		'has_more' => $page + 1 < $query->max_num_pages
	));
}
add_action('wp_ajax_load_more_department_news', 'load_more_department_news');
add_action('wp_ajax_nopriv_load_more_department_news', 'load_more_department_news');

// AJAX handler for loading past events (Alpine.js version)
function load_events_with_year()
{
	check_ajax_referer('load_events_with_year_nonce', 'nonce');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
	$year = sanitize_text_field($_POST['year']);
	$today = date('Y-m-d');
	$pastonly = isset($_POST['pastonly']);

	// Build query args for past events (latest to oldest)
	$args = array(
		'post_type'      => 'event',
		'posts_per_page' => EVENTS_PER_PAGE,
		'paged'          => $page,
		'meta_key'       => 'start_date', // for ordering
		'orderby'        => 'meta_value',
		'order'          => 'DESC',
		'post_status' => 'publish'
	);

	$meta_query = array();

	if ($pastonly) {
		$meta_query[] = array(
			'key'     => 'start_date',
			'value'   => $today,
			'compare' => '<',
			'type'    => 'DATE',
		);
	}

	if ($year) {
		$meta_query[] = array(
			'key'     => 'start_date',
			'value'   => array($year . '0101', $year . '1231'),
			'compare' => 'BETWEEN',
			'type'    => 'NUMERIC',
		);
	}

	// Apply meta_query only if needed
	if (!empty($meta_query)) {
		$args['meta_query'] = array_merge(array('relation' => 'AND'), $meta_query);
	}

	// Add taxonomy query if category is not 'all'
	if ($category !== 'all') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'event_category',
				'field' => 'slug',
				'terms' => $category
			)
		);
	}

	$events_query = new WP_Query($args);
	$events = array();

	if ($events_query->have_posts()) {
		while ($events_query->have_posts()) {
			$events_query->the_post();

			$event_name = get_field('event_name');
			$photo = '';

			$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'm');
			$event_banner = get_field('event_banner');

			if ($featured_image) {
				$photo = $featured_image;
			} elseif ($event_banner && isset($event_banner['sizes']['m'])) {
				$photo = $event_banner['sizes']['m'];
			} else {
				$photo = get_template_directory_uri() . '/images/schoolart_logo_bg.svg';
			}

			$start_date = get_field('start_date');
			$end_date = get_field('end_date');
			$event_time = get_field('event_time');
			$event_venue = get_field('event_venue');

			// Format dates
			$start_date_obj = DateTime::createFromFormat('Ymd', $start_date);
			$end_date_obj = $end_date ? DateTime::createFromFormat('Ymd', $end_date) : null;

			// Check if event spans multiple days
			$has_date_range = $end_date && $start_date !== $end_date;

			// Format date display
			if ($has_date_range) {
				$date_display = $start_date_obj->format('j/n/Y') . '－' . $end_date_obj->format('j/n/Y');
			} else {
				$date_display = $start_date_obj->format('j/n/Y');
			}

			$event = array(
				'id' => get_the_ID(),
				'event_name' => $event_name,
				'permalink' => get_permalink(),
				'start_date_short' => $start_date_obj->format('j/n'),
				'end_date_short' => $end_date_obj ? $end_date_obj->format('j/n') : '',
				'has_date_range' => $has_date_range,
				'date_display' => $date_display,
				'event_time' => $event_time,
				'event_venue' => $event_venue,
				'event_banner' => $photo ? array(
					'url' => $photo,
					'alt' => $event_name
				) : null
			);

			$events[] = $event;
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'events' => $events,
		'has_more' => $page < $events_query->max_num_pages
	));
}
add_action('wp_ajax_load_events_with_year', 'load_events_with_year');
add_action('wp_ajax_nopriv_load_events_with_year', 'load_events_with_year');

// AJAX handler for loading research projects
function load_research_projects()
{
	check_ajax_referer('load_research_projects_nonce', 'nonce');

	$year = isset($_POST['year']) ? intval($_POST['year']) : 0;

	if (!$year) {
		wp_send_json_error('Invalid year');
		return;
	}

	// Query projects for selected year
	$args = array(
		'post_type' => 'research_project',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'funding_start_year',
				'value' => $year,
				'compare' => '=',
				'type' => 'NUMERIC'
			)
		),
		'orderby' => 'title',
		'order' => 'ASC',
		'post_status' => 'publish'
	);

	$query = new WP_Query($args);
	$projects = array();

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			// Get flexible content for description
			$description = '';
			if (have_rows('flexible_content')) {
				while (have_rows('flexible_content')) {
					the_row();
					if (get_row_layout() == 'free_text') {
						$freetext = get_sub_field("free_text");
						if ($freetext) {
							$description .= wp_kses_post($freetext);
						}
					}
				}
			}

			$project = array(
				'id' => get_the_ID(),
				'project_title' => get_field('project_title'),
				'funding_organization' => get_field('funding_organization'),
				'funding_start_year' => get_field('funding_start_year'),
				'funding_end_year_short' => substr(get_field('funding_end_year'), -2),
				'principal_investigator' => get_field('principal_investigator'),
				'other_investigator' => get_field('other_investigator'),
				'granted_amount' => get_field('granted_amount'),
				'description' => $description
			);

			$projects[] = $project;
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'projects' => $projects
	));
}
add_action('wp_ajax_load_research_projects', 'load_research_projects');
add_action('wp_ajax_nopriv_load_research_projects', 'load_research_projects');

// AJAX handler for filtering events by category
function filter_events()
{
	check_ajax_referer('filter_events_nonce', 'nonce');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
	$today = date('Y-m-d');

	// Build query args
	$args = array(
		'post_type'      => 'event',
		'posts_per_page' => EVENTS_PER_PAGE,
		'paged'          => $page,
		'meta_key'       => 'start_date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'post_status'    => 'publish',
		'meta_query'     => array(
			'relation' => 'OR', // 使用 OR 關聯，滿足任一條件
			array(
				// 條件 1: 未來的 event（start_date >= 今天）
				'key'     => 'start_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE'
			),
			array(
				// 條件 2: 尚未結束的 event（end_date >= 今天，且 end_date 存在）
				'key'     => 'end_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE'
			),
			array(
				// 條件 3: 只有 start_date 的單天 event（end_date 不存在或為空）
				'relation' => 'AND',
				array(
					'key'     => 'start_date',
					'value'   => $today,
					'compare' => '>=',
					'type'    => 'DATE'
				),
				array(
					'key'     => 'end_date',
					'compare' => 'NOT EXISTS', // 處理 end_date 為空的情況
				)
			)
		)
	);

	// Add taxonomy query if category is not 'all'
	if ($category !== 'all') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'event_category',
				'field' => 'slug',
				'terms' => $category
			)
		);
	}

	$events_query = new WP_Query($args);
	$events = array();

	if ($events_query->have_posts()) {
		while ($events_query->have_posts()) {
			$events_query->the_post();

			$event_name = get_field('event_name');
			$photo = '';

			$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'm');
			$event_banner = get_field('event_banner');

			if ($featured_image) {
				$photo = $featured_image;
			} elseif ($event_banner && isset($event_banner['sizes']['m'])) {
				$photo = $event_banner['sizes']['m'];
			} else {
				$photo = get_template_directory_uri() . '/images/schoolart_logo_bg.svg';
			}
			$start_date = get_field('start_date');
			$end_date = get_field('end_date');
			$event_time = get_field('event_time');
			$event_venue = get_field('event_venue');

			// Format dates
			$start_date_obj = DateTime::createFromFormat('Ymd', $start_date);
			$end_date_obj = $end_date ? DateTime::createFromFormat('Ymd', $end_date) : null;

			// Check if event spans multiple days
			$has_date_range = $end_date && $start_date !== $end_date;

			// Format date display
			if ($has_date_range) {
				$date_display = $start_date_obj->format('j/n/Y') . '－' . $end_date_obj->format('j/n/Y');
			} else {
				$date_display = $start_date_obj->format('j/n/Y');
			}

			$event = array(
				'id' => get_the_ID(),
				'event_name' => $event_name,
				'permalink' => get_permalink(),
				'start_date_short' => $start_date_obj->format('j/n'),
				'end_date_short' => $end_date_obj ? $end_date_obj->format('j/n') : '',
				'has_date_range' => $has_date_range,
				'date_display' => $date_display,
				'event_time' => $event_time,
				'event_venue' => $event_venue,
				'event_banner' => $event_banner ? array(
					'url' => $photo,
					'alt' => $event_name
				) : null
			);

			$events[] = $event;
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'events' => $events,
		'has_more' => $page < $events_query->max_num_pages
	));
}
add_action('wp_ajax_filter_events', 'filter_events');
add_action('wp_ajax_nopriv_filter_events', 'filter_events');

// AJAX handler for filtering publications by category
function filter_publications()
{
	check_ajax_referer('filter_publications_nonce', 'nonce');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';

	// Build query args
	$args = array(
		'post_type' => 'publication',
		'posts_per_page' => defined('PUBLICATIONS_PER_PAGE') ? PUBLICATIONS_PER_PAGE : 10,
		'paged' => $page,
		'orderby' => 'date',
		'order' => 'DESC',
		'post_status' => 'publish'
	);

	// Add taxonomy query if category is not 'all'
	if ($category !== 'all') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'publication_category',
				'field' => 'slug',
				'terms' => $category
			)
		);
	}

	$publications_query = new WP_Query($args);
	$publications = array();

	if ($publications_query->have_posts()) {
		while ($publications_query->have_posts()) {
			$publications_query->the_post();

			$author = get_field('author');
			$chief_editor = get_field('chief_editor');
			$publisher = get_field('publisher');
			$publish_year = get_field('year_and_month_of_publication');
			$cover_image = get_field('cover_photo');

			$publication = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'permalink' => get_permalink(),
				'author' => $author,
				'chief_editor' => $chief_editor,
				'publisher' => $publisher,
				'publish_year' => $publish_year,
				'cover_image' => $cover_image ? array(
					'url' => $cover_image['url'],
					'alt' => $cover_image['alt'] ?: ''
				) : null
			);

			$publications[] = $publication;
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'publications' => $publications,
		'has_more' => $page < $publications_query->max_num_pages
	));
}
add_action('wp_ajax_filter_publications', 'filter_publications');
add_action('wp_ajax_nopriv_filter_publications', 'filter_publications');

// AJAX handler for getting available years
function get_event_years_ajax()
{
	// Verify nonce
	if (!wp_verify_nonce($_POST['nonce'], 'get_event_years_nonce')) {
		wp_die('Security check failed');
	}

	global $wpdb;

	$meta_key = 'start_date'; // ACF field key (stored in Ymd format, e.g., 20240620)

	$years = $wpdb->get_col("
        SELECT DISTINCT 
            LEFT(meta_value, 4) AS year
        FROM {$wpdb->postmeta}
        INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
        WHERE meta_key = '{$meta_key}'
        AND {$wpdb->posts}.post_type = 'event'
        AND {$wpdb->posts}.post_status = 'publish'
        AND meta_value REGEXP '^[0-9]{8}$'
        ORDER BY year DESC
    ");

	wp_send_json_success(array(
		'years' => $years
	));
}
add_action('wp_ajax_get_event_years', 'get_event_years_ajax');
add_action('wp_ajax_nopriv_get_event_years', 'get_event_years_ajax');


/* chung */

function get_translated_page_by_slug($slug, $lang = null)
{
	if (empty($slug)) return false;

	// Default to current language if none is specified
	if (!$lang && function_exists('pll_current_language')) {
		$lang = pll_current_language();
	}

	// Query pages by slug (post_name), in all hierarchies
	$page = get_posts([
		'name'           => $slug,
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
	]);

	if (empty($page)) return false;

	$page_id = $page[0]->ID;

	// Return translated ID, or fallback to default
	if (function_exists('pll_get_post')) {
		$translated_id = pll_get_post($page_id, $lang);
		return $translated_id ? $translated_id : $page_id;
	}

	return $page_id;
}

add_action('template_redirect', function () {
	if (is_singular('research_project')) {
		$target_page_id = get_translated_page_by_slug('research-projects');
		if ($target_page_id) {
			wp_redirect(get_permalink($target_page_id), 301);
			exit;
		}
	}
	if (is_singular('mphil_phd_research')) {
		$target_page_id = get_translated_page_by_slug('mphil-phd-research');
		if ($target_page_id) {
			wp_redirect(get_permalink($target_page_id), 301);
			exit;
		}
	}
});


// 1. Add custom columns to each post type
add_filter('manage_research_project_posts_columns', function ($columns) {
	$columns['funding_start_year'] = 'Funding Start Year';
	return $columns;
});

add_filter('manage_news_posts_columns', function ($columns) {
	$columns['start_date'] = 'Start Date';
	return $columns;
});

add_filter('manage_event_posts_columns', function ($columns) {
	$columns['start_date'] = 'Start Date';
	return $columns;
});

// 2. Display ACF values in the columns
add_action('manage_research_project_posts_custom_column', function ($column, $post_id) {
	if ($column === 'funding_start_year') {
		$value = get_field('funding_start_year', $post_id);
		echo esc_html($value);
	}
}, 10, 2);

add_action('manage_news_posts_custom_column', function ($column, $post_id) {
	if ($column === 'start_date') {
		$value = get_field('start_date', $post_id);
		echo esc_html($value);
	}
}, 10, 2);

add_action('manage_event_posts_custom_column', function ($column, $post_id) {
	if ($column === 'start_date') {
		$value = get_field('start_date', $post_id);
		echo esc_html($value);
	}
}, 10, 2);

// 3. Make the columns sortable
add_filter('manage_edit-research_project_sortable_columns', function ($columns) {
	$columns['funding_start_year'] = 'funding_start_year';
	return $columns;
});

add_filter('manage_edit-news_sortable_columns', function ($columns) {
	$columns['start_date'] = 'start_date';
	return $columns;
});

add_filter('manage_edit-event_sortable_columns', function ($columns) {
	$columns['start_date'] = 'start_date';
	return $columns;
});

// 4. Add sorting logic for custom fields
add_action('pre_get_posts', function ($query) {
	if (!is_admin() || !$query->is_main_query()) {
		return;
	}

	$orderby = $query->get('orderby');

	if ($orderby === 'funding_start_year') {
		$query->set('meta_key', 'funding_start_year');
		$query->set('orderby', 'meta_value_num'); // or 'meta_value' if it's not a number
	}

	if ($orderby === 'start_date') {
		$query->set('meta_key', 'start_date');
		$query->set('orderby', 'meta_value'); // or 'meta_value_num' if it's a timestamp or Y-m-d
	}
});


function JTPYStr()
{
	return '万与丑专业丛东丝丢两严丧个爿丰临为丽举麽义乌乐乔习乡书买乱争於亏云亘亚产亩亲亵嚲亿仅从仑仓仪们价众优夥会伛伞伟传伤伥伦伧伪伫体馀佣佥侠侣侥侦侧侨侩侪侬俣俦俨俩俪俭债倾偬偻偾偿傥傧储傩儿兑兖党兰关兴兹养兽冁内冈册写军农冢冯冲决况冻净凄凉凌减凑凛几凤凫凭凯击氹凿刍划刘则刚创删别剗刭刽刿剀剂剐剑剥剧劝办务劢动励劲劳绩勋猛勩匀匦匮区医华协单卖卢卤卧卫却卺厂厅历厉压厌厍厕厢厣厦厨厩厮县参靉靆双发变叙叠叶号叹叽吁後吓吕吗吣吨听启吴呒呓呕呖呗员呙呛呜咏咔咙咛噝咤噅咸呱响哑哒哓哔哕哗哙哜哝哟唛嗊唠啢唢唕唤呼啧啬啭啮罗嘽啸喷喽喾嗫嗬嗳嘘嘤嘱噜劈嚣谑团园囱围囵国图圆圣圹场阪坏块坚坛坜坝坞坟坠垄垄垆垒垦垧垩垫垭墶壋垲堖埘埙埚垫埯堑堕壪墙壮声壳壶壼处备复够头夸夹夺奁奂奋奖奥妆妇妈妩妪妫姗姜娄娅娆娇娈娱娲娴嫿婴婵婶媪嫒嫔嫱嬷孙学孪宁宝实宠审宪宫宽宾寝对寻导寿将尔尘尧尴尸尽层屭屉届属屡屦屿岁岂岖岗岘岙岚岛岭岳岽岿嶨峄峡嶢峤峥峦崂崃嶮崭嵘嶔嵛嵝脊巅巩巯币帅师帏帐帘帜带帧帮帱帻帼幂幞干并广庄庆庐庑库应庙庞废廎廪开异弃张弥弪弯弹强归当录彠彦彻径徕御忆忏忧忾怀态怂怃怄怅怆怜总怼怿恋恳恶恸恹恺恻恼恽悦悫悬悭悯惊惧惨惩惫惬惭惮惯愍愠愤愦愿慑憖怵懑懒懔戆戋戏戗战戬户扎扑扡执扩扪扫扬扰抚抛抟抠抡抢护报担拟拢拣拥拦拧拨择挂挚挛掗挝挞挟挠挡挢挣挤挥撏捞损捡换捣据拈掳掴掷掸掺掼摣揽揿搀搁搂搅携摄摅摆摇摈摊撄撑撵撷撸撺擞攒敌敛数斋斓斗斩断无旧时旷暘昙昼曨显晋晒晓晔晕晖暂暧札术朴机杀杂权条来杨杩杰极构枞枢枣枥梘枨枪枫枭柜柠柽栀栅标栈栉栊栋栌栎栏树栖样栾棬桠桡桢档桤桥桦桧桨桩梦檮棶检棂椁椟椠椤椭楼榄榇榈榉檟槛槟槠横樯樱橥橱橹橼檐檩欢欤欧歼殁殇残殒殓殚殡殴毁毂毕毙毡毵氇气氢氩氲汇汉污汤汹沓沟没沣沤沥沦沧渢沩沪濔泞泪泶泷泸泺泻泼泽泾洁洒洼浃浅浆浇浈溮浊测浍济浏滻浑浒浓浔濜涂涌涛涝涞涟涠涡溳涣涤润涧涨涩淀渊渌渍渎渐渑渔渖渗温游湾湿溃溅溆漊滗滚滞滟滠满滢滤滥滦滨滩澦滥潆潇潋潍潜潴澜濑濒灏灭灯灵灾灿炀炉炖炜炝点炼炽烁烂烃烛烟烦烧烨烩烫烬热焕焖焘煅糊溜爱爷牍牦牵牺犊强状犷獁犹狈麅獮狞独狭狮狯狰狱狲猃猎猕猡猪猫猬献獭玑璵瑒玛玮环现瑲玺瑉珏珐珑璫珲璡琏琐琼瑶瑷璇璎瓒瓮瓯电画畅佘畴疖疗疟疠疡疬疮疯疱屙痈痉痒瘂痨痪痫痴瘅瘮瘗瘘瘪瘫瘾瘿癞癣癫臒皑皱皲盏盐监盖盗盘瞘眦矓着睁睐睑瞒瞩矫矶矾矿砀码砖砗砚碸砺砻砾础硜矽硕硖硗磑礄确硷碍碛碜碱镟滚礼禕祢祯祷祸禀禄禅离秃秆种积称秽穠稆税稣稳穑穷窃窍窑窜窝窥窦窭竖竞笃笋笔笕笺笼笾筑筚筛簹筝筹签简籙箦箧箨箩箪箫篑篓篮篱簖籁籴类籼粜粝粤粪粮糁糇紧絷纟纠纡红纣纤纥约级纨纩纪纫纬纭紘纯纰纱纲纳紝纵纶纷纸纹纺紵紖纽纾线绀绁绂练组绅细织终绉绊绋绌绍绎经绐绑绒结絝绕絰绗绘给绚绛络绝绞统绠绡绢绣綌绥绦继绨绩绪绫緓续绮绯绰緔绲绳维绵绶绷绸綯绺绻综绽绾绿缀缁缂缃缄缅缆缇缈缉縕缋缌缍缎缏线缑缒缓缔缕编缗缘缙缚缛缜缝縗缟缠缡缢缣缤缥缦缧缨缩缪缫缬缭缮缯缰缱缲缳缴缵罂网罗罚罢罴羁羟羡翘翽翬耮耧耸耻聂聋职聍联聩聪肃肠肤膁肾肿胀胁胆胜胧腖胪胫胶脉脍脏脐脑脓脔脚脱脶脸腊腌膕齶腻腼腽腾膑臢舆舣舰舱舻艰艳艹艺节芈芗芜芦苁苇苈苋苌苍苎苏檾苹茎茏茑茔茕茧荆荐薘荚荛荜荞荟荠荡荣荤荥荦荧荨荩荪荫蕒荭葤药莅蓧莱莲莳莴莶获莸莹莺莼蘀萝萤营萦萧萨葱蒇蒉蒋蒌蓝蓟蓠蓣蓥蓦蔷蔹蔺蔼蕲蕴薮槁藓虏虑虚虫虬虮虽虾虿蚀蚁蚂蚕蚝蚬蛊蛎蛏蛮蛰蛱蛲蛳蛴蜕蜗蜡蝇蝈蝉蝎蝼蝾螿蟎蠨衅衔补衬衮袄嫋褘袜袭襏装裆褌裢裣裤襇褛褴襁襴见观覎规觅视觇览觉觊觋觌覥觎觏觐觑觞触觯讋誉誊訁计订讣认讥讦讧讨让讪讫训议讯记訒讲讳讴讵讶讷许讹论訩讼讽设访诀证诂诃评诅识詗诈诉诊诋诌词诎诏詖译诒诓诔试诖诗诘诙诚诛诜话诞诟诠诡询诣诤该详诧诨诩譸诫诬语诮误诰诱诲诳说诵诶请诸诹诺读诼诽课诿谀谁谂调谄谅谆谇谈谊谋谌谍谎谏谐谑谒谓谔谕谖谗谘谙谚谛谜谝諝谟谠谡谢谣谤谥谦谧谨谩谪谫谬谭谮谯谰谱谲谳谴谵谶谷豶贝贞负貟贡财责贤败账货质贩贪贫贬购贮贯贰贱贲贳贴贵贶贷贸费贺贻贼贽贾贿赀赁赂赃资赅赆赇赈赉赊赋赌赍赎赏赐贔賙赓赔赕赖賵赘赙赚赛赜赝赞贇赠赡赢赣赬赵赶趋趱趸跃跄蹠跞践躂跷跸跹跻踊踌踪踬踯蹑蹒蹰蹿躏躜躯车轧轨軑轫转轭轮软轰軲轲轳轴轵轶軤轸轹轺轻轼载轾轿輈辁辂较辄辅辆辇辈辉辊辋輬辍辎辏辐辑轀输辔辕辖辗辘辙辚辞辩辫边辽达迁过迈运还这进远违连迟迩径迹适选逊递逦逻遗遥邓邝邬邮邹邺邻郁郄郏郐郑郓郦郧郸酝醱酱酽酾酿释里钜鉴銮錾钆钇针钉钊钋钌钍釺钏钐鈒钒钓钔钕鍚钗鈃钙鈈钛钝钞锺钠钡钢钣钤钥钦钧钨钩钪钫钬钭钮钯钰钱钲钳钴钵钶鉕钸钹钺钻钼钽钾钿铀铁铂铃铄铅铆铈铉铊铋铍铎鉶铐铑铒铕铗鋣铙銍铛铜铝銱铟铠铡铢铣铤铥銛铧铨铪铫铬铭铮铯铰铱铲铳铴铵银铷铸铹铺鋙铼铽链铿销锁锂鋥锄锅锆锇锈锉锊锋锌鋶鐦鐧锐锑锒锓锔锕锖锗错锚錡锞锟錩锡锢锣锤锥锦鍁锩錇锬锭键锯锰锱锲鍈锴锵锶锷锸锹锺锻锼鍠锾鎄镀镁镂鎡镆镇鎛镉镊镌镍鎿镏镐镑镒熔镖镗镙鏰镛镜镝镞镟鏐镡镢镣镤鑥镦镧镨鑹镪镫镬镭钚镯镰镱鑔镳鑞镶长门闩闪闫閈闭问闯闰闱闲闳间闵闶闷闸闹闺闻闼闽闾闓阀阁阂阃阄阅阆闍阈阉阊阋阌阍阎阏阐阑阒闠阔阕阖阗闒阙阚闤队阳阴阵阶际陆陇陈陉陕陧陨险随隐隶隽难雏雠雳雾霁霉霭靓静靥鞑鞽鞯鞴韦韧韍韔韪韫韬韵页顶顷顸项顺须顼顽顾顿颀颁颂颃预颅领颇颈颉颊頲颌颍熲颏颐频頮颓颔頴颖颗题顒颚颛颜额颞颟颠颡颢纇颤顬颦颧风扬颭飑飒飓颸飕颻飀飘飙飙飞飨餍飣饥飥饧饨饩饪饫饬饭饮饯饰饱饲飿饴饵饶饷餄餎饺餏饼饽餖饿馀馁餕餜馄馅馆餷馈餶馊馋饁馍餺馏馐馑馒饊馔饢马驭驮驯驰驱馹驳驴驵驶驷驸驹驺驻驼驽驾驿骀骁骂駰骄骅骆骇骈驫骊骋验騂駸骏骐骑骒骓騌驌骖骗骘騤骚骛骜骝骞骟骠骡骢骣骤骥驦骧髅髋髌鬓魇魉鱼魛魢鱿魨鲁鲂魺鮁鮃鲶鲈鮋鮓鲋鮊鲍鲎鮍鲐鲑鲒鮳鲔鲕鮦鰂鮜鱠鲚鲛鲜鮺鲞鲟鲠鲡鲢鲣鲤鲥鲦鲧鲨鲩鮶鲫鯒鲭鲮鯕鲰鲱鲲鲳鯝鲵鲶鲷鲸鯵鯴鲻鱝鲽鰏鱨鯷鰮鰃鳃鳄鳅鳆鳇鰁鱂鯿鰠鳌鳍鳎鳏鳐鰟鰜鳓鳔鳕鳖鳗鰵鱅鰼鳜鳝鳞鳟鱯鱤鳢鱣鸟鸠鸡鸢鸣鳲鸥鸦鶬鸨鸩鸪鸫鸬鸭鴞鸯鴒鸱鸲鸳鴬鸵鸶鸷鸸鸹鸺鴴鵃鸽鸾鸿鵐鹁鹂鹃鹄鹅鹆鹇鹈鹉鹊鶓鹌鶤鹎鹏鵮鹑鶊鵷鷫鹕鶡鹗鹘鹚鶥鹜鷊鹞鶲鶹鶺鷁鹣鹤鷖鹦鹧鹨鹩鹪鹫鹬鹭鸇鹰鸌鸏鹳鸘鹾麦麸黄黉黶黩黪黾鼋鼂鼍鞀鼹齇齐齑齿龀齕齗龃龄龅龆龇龈龉龊龋龌龙龚龛龟志制谘只里系范松冇尝尝哄面准钟别闲乾尽脏拚'; // Use full version
}

function FTPYStr()
{
	return '萬與醜專業叢東絲丟兩嚴喪個爿豐臨為麗舉麼義烏樂喬習鄉書買亂爭於虧雲亙亞產畝親褻嚲億僅從侖倉儀們價眾優夥會傴傘偉傳傷倀倫傖偽佇體餘傭僉俠侶僥偵側僑儈儕儂俁儔儼倆儷儉債傾傯僂僨償儻儐儲儺兒兌兗黨蘭關興茲養獸囅內岡冊寫軍農塚馮衝決況凍淨淒涼淩減湊凜幾鳳鳧憑凱擊氹鑿芻劃劉則剛創刪別剗剄劊劌剴劑剮劍剝劇勸辦務勱動勵勁勞勣勳猛勩勻匭匱區醫華協單賣盧鹵臥衛卻巹廠廳曆厲壓厭厙廁廂厴廈廚廄廝縣參靉靆雙發變敘疊葉號歎嘰籲後嚇呂嗎唚噸聽啟吳嘸囈嘔嚦唄員咼嗆嗚詠哢嚨嚀噝吒噅鹹呱響啞噠嘵嗶噦嘩噲嚌噥喲嘜嗊嘮啢嗩唕喚呼嘖嗇囀齧囉嘽嘯噴嘍嚳囁嗬噯噓嚶囑嚕劈囂謔團園囪圍圇國圖圓聖壙場阪壞塊堅壇壢壩塢墳墜壟壟壚壘墾坰堊墊埡墶壋塏堖塒塤堝墊垵塹墮壪牆壯聲殼壺壼處備複夠頭誇夾奪奩奐奮獎奧妝婦媽嫵嫗媯姍薑婁婭嬈嬌孌娛媧嫻嫿嬰嬋嬸媼嬡嬪嬙嬤孫學孿寧寶實寵審憲宮寬賓寢對尋導壽將爾塵堯尷屍盡層屭屜屆屬屢屨嶼歲豈嶇崗峴嶴嵐島嶺嶽崠巋嶨嶧峽嶢嶠崢巒嶗崍嶮嶄嶸嶔崳嶁脊巔鞏巰幣帥師幃帳簾幟帶幀幫幬幘幗冪襆幹並廣莊慶廬廡庫應廟龐廢廎廩開異棄張彌弳彎彈強歸當錄彠彥徹徑徠禦憶懺憂愾懷態慫憮慪悵愴憐總懟懌戀懇惡慟懨愷惻惱惲悅愨懸慳憫驚懼慘懲憊愜慚憚慣湣慍憤憒願懾憖怵懣懶懍戇戔戲戧戰戩戶紮撲扡執擴捫掃揚擾撫拋摶摳掄搶護報擔擬攏揀擁攔擰撥擇掛摯攣掗撾撻挾撓擋撟掙擠揮撏撈損撿換搗據撚擄摑擲撣摻摜摣攬撳攙擱摟攪攜攝攄擺搖擯攤攖撐攆擷擼攛擻攢敵斂數齋斕鬥斬斷無舊時曠暘曇晝曨顯晉曬曉曄暈暉暫曖劄術樸機殺雜權條來楊榪傑極構樅樞棗櫪梘棖槍楓梟櫃檸檉梔柵標棧櫛櫳棟櫨櫟欄樹棲樣欒棬椏橈楨檔榿橋樺檜槳樁夢檮棶檢欞槨櫝槧欏橢樓欖櫬櫚櫸檟檻檳櫧橫檣櫻櫫櫥櫓櫞簷檁歡歟歐殲歿殤殘殞殮殫殯毆毀轂畢斃氈毿氌氣氫氬氳彙漢汙湯洶遝溝沒灃漚瀝淪滄渢溈滬濔濘淚澩瀧瀘濼瀉潑澤涇潔灑窪浹淺漿澆湞溮濁測澮濟瀏滻渾滸濃潯濜塗湧濤澇淶漣潿渦溳渙滌潤澗漲澀澱淵淥漬瀆漸澠漁瀋滲溫遊灣濕潰濺漵漊潷滾滯灩灄滿瀅濾濫灤濱灘澦濫瀠瀟瀲濰潛瀦瀾瀨瀕灝滅燈靈災燦煬爐燉煒熗點煉熾爍爛烴燭煙煩燒燁燴燙燼熱煥燜燾煆糊溜愛爺牘犛牽犧犢強狀獷獁猶狽麅獮獰獨狹獅獪猙獄猻獫獵獼玀豬貓蝟獻獺璣璵瑒瑪瑋環現瑲璽瑉玨琺瓏璫琿璡璉瑣瓊瑤璦璿瓔瓚甕甌電畫暢佘疇癤療瘧癘瘍鬁瘡瘋皰屙癰痙癢瘂癆瘓癇癡癉瘮瘞瘺癟癱癮癭癩癬癲臒皚皺皸盞鹽監蓋盜盤瞘眥矓著睜睞瞼瞞矚矯磯礬礦碭碼磚硨硯碸礪礱礫礎硜矽碩硤磽磑礄確鹼礙磧磣堿镟滾禮禕禰禎禱禍稟祿禪離禿稈種積稱穢穠穭稅穌穩穡窮竊竅窯竄窩窺竇窶豎競篤筍筆筧箋籠籩築篳篩簹箏籌簽簡籙簀篋籜籮簞簫簣簍籃籬籪籟糴類秈糶糲粵糞糧糝餱緊縶糸糾紆紅紂纖紇約級紈纊紀紉緯紜紘純紕紗綱納紝縱綸紛紙紋紡紵紖紐紓線紺絏紱練組紳細織終縐絆紼絀紹繹經紿綁絨結絝繞絰絎繪給絢絳絡絕絞統綆綃絹繡綌綏絛繼綈績緒綾緓續綺緋綽緔緄繩維綿綬繃綢綯綹綣綜綻綰綠綴緇緙緗緘緬纜緹緲緝縕繢緦綞緞緶線緱縋緩締縷編緡緣縉縛縟縝縫縗縞纏縭縊縑繽縹縵縲纓縮繆繅纈繚繕繒韁繾繰繯繳纘罌網羅罰罷羆羈羥羨翹翽翬耮耬聳恥聶聾職聹聯聵聰肅腸膚膁腎腫脹脅膽勝朧腖臚脛膠脈膾髒臍腦膿臠腳脫腡臉臘醃膕齶膩靦膃騰臏臢輿艤艦艙艫艱豔艸藝節羋薌蕪蘆蓯葦藶莧萇蒼苧蘇檾蘋莖蘢蔦塋煢繭荊薦薘莢蕘蓽蕎薈薺蕩榮葷滎犖熒蕁藎蓀蔭蕒葒葤藥蒞蓧萊蓮蒔萵薟獲蕕瑩鶯蓴蘀蘿螢營縈蕭薩蔥蕆蕢蔣蔞藍薊蘺蕷鎣驀薔蘞藺藹蘄蘊藪槁蘚虜慮虛蟲虯蟣雖蝦蠆蝕蟻螞蠶蠔蜆蠱蠣蟶蠻蟄蛺蟯螄蠐蛻蝸蠟蠅蟈蟬蠍螻蠑螿蟎蠨釁銜補襯袞襖嫋褘襪襲襏裝襠褌褳襝褲襇褸襤繈襴見觀覎規覓視覘覽覺覬覡覿覥覦覯覲覷觴觸觶讋譽謄訁計訂訃認譏訐訌討讓訕訖訓議訊記訒講諱謳詎訝訥許訛論訩訟諷設訪訣證詁訶評詛識詗詐訴診詆謅詞詘詔詖譯詒誆誄試詿詩詰詼誠誅詵話誕詬詮詭詢詣諍該詳詫諢詡譸誡誣語誚誤誥誘誨誑說誦誒請諸諏諾讀諑誹課諉諛誰諗調諂諒諄誶談誼謀諶諜謊諫諧謔謁謂諤諭諼讒諮諳諺諦謎諞諝謨讜謖謝謠謗諡謙謐謹謾謫譾謬譚譖譙讕譜譎讞譴譫讖穀豶貝貞負貟貢財責賢敗賬貨質販貪貧貶購貯貫貳賤賁貰貼貴貺貸貿費賀貽賊贄賈賄貲賃賂贓資賅贐賕賑賚賒賦賭齎贖賞賜贔賙賡賠賧賴賵贅賻賺賽賾贗讚贇贈贍贏贛赬趙趕趨趲躉躍蹌蹠躒踐躂蹺蹕躚躋踴躊蹤躓躑躡蹣躕躥躪躦軀車軋軌軑軔轉軛輪軟轟軲軻轤軸軹軼軤軫轢軺輕軾載輊轎輈輇輅較輒輔輛輦輩輝輥輞輬輟輜輳輻輯轀輸轡轅轄輾轆轍轔辭辯辮邊遼達遷過邁運還這進遠違連遲邇逕跡適選遜遞邐邏遺遙鄧鄺鄔郵鄒鄴鄰鬱郤郟鄶鄭鄆酈鄖鄲醞醱醬釅釃釀釋裏钜鑒鑾鏨釓釔針釘釗釙釕釷釺釧釤鈒釩釣鍆釹鍚釵鈃鈣鈈鈦鈍鈔鍾鈉鋇鋼鈑鈐鑰欽鈞鎢鉤鈧鈁鈥鈄鈕鈀鈺錢鉦鉗鈷缽鈳鉕鈽鈸鉞鑽鉬鉭鉀鈿鈾鐵鉑鈴鑠鉛鉚鈰鉉鉈鉍鈹鐸鉶銬銠鉺銪鋏鋣鐃銍鐺銅鋁銱銦鎧鍘銖銑鋌銩銛鏵銓鉿銚鉻銘錚銫鉸銥鏟銃鐋銨銀銣鑄鐒鋪鋙錸鋱鏈鏗銷鎖鋰鋥鋤鍋鋯鋨鏽銼鋝鋒鋅鋶鐦鐧銳銻鋃鋟鋦錒錆鍺錯錨錡錁錕錩錫錮鑼錘錐錦鍁錈錇錟錠鍵鋸錳錙鍥鍈鍇鏘鍶鍔鍤鍬鍾鍛鎪鍠鍰鎄鍍鎂鏤鎡鏌鎮鎛鎘鑷鐫鎳鎿鎦鎬鎊鎰鎔鏢鏜鏍鏰鏞鏡鏑鏃鏇鏐鐔钁鐐鏷鑥鐓鑭鐠鑹鏹鐙鑊鐳鐶鐲鐮鐿鑔鑣鑞鑲長門閂閃閆閈閉問闖閏闈閑閎間閔閌悶閘鬧閨聞闥閩閭闓閥閣閡閫鬮閱閬闍閾閹閶鬩閿閽閻閼闡闌闃闠闊闋闔闐闒闕闞闤隊陽陰陣階際陸隴陳陘陝隉隕險隨隱隸雋難雛讎靂霧霽黴靄靚靜靨韃鞽韉韝韋韌韍韔韙韞韜韻頁頂頃頇項順須頊頑顧頓頎頒頌頏預顱領頗頸頡頰頲頜潁熲頦頤頻頮頹頷頴穎顆題顒顎顓顏額顳顢顛顙顥纇顫顬顰顴風颺颭颮颯颶颸颼颻飀飄飆飆飛饗饜飣饑飥餳飩餼飪飫飭飯飲餞飾飽飼飿飴餌饒餉餄餎餃餏餅餑餖餓餘餒餕餜餛餡館餷饋餶餿饞饁饃餺餾饈饉饅饊饌饢馬馭馱馴馳驅馹駁驢駔駛駟駙駒騶駐駝駑駕驛駘驍罵駰驕驊駱駭駢驫驪騁驗騂駸駿騏騎騍騅騌驌驂騙騭騤騷騖驁騮騫騸驃騾驄驏驟驥驦驤髏髖髕鬢魇魎魚魛魢魷魨魯魴魺鮁鮃鯰鱸鮋鮓鮒鮊鮑鱟鮍鮐鮭鮚鮳鮪鮞鮦鰂鮜鱠鱭鮫鮮鮺鯗鱘鯁鱺鰱鰹鯉鰣鰷鯀鯊鯇鮶鯽鯒鯖鯪鯕鯫鯡鯤鯧鯝鯢鯰鯛鯨鯵鯴鯔鱝鰈鰏鱨鯷鰮鰃鰓鱷鰍鰒鰉鰁鱂鯿鰠鼇鰭鰨鰥鰩鰟鰜鰳鰾鱈鱉鰻鰵鱅鰼鱖鱔鱗鱒鱯鱤鱧鱣鳥鳩雞鳶鳴鳲鷗鴉鶬鴇鴆鴣鶇鸕鴨鴞鴦鴒鴟鴝鴛鴬鴕鷥鷙鴯鴰鵂鴴鵃鴿鸞鴻鵐鵓鸝鵑鵠鵝鵒鷳鵜鵡鵲鶓鵪鶤鵯鵬鵮鶉鶊鵷鷫鶘鶡鶚鶻鶿鶥鶩鷊鷂鶲鶹鶺鷁鶼鶴鷖鸚鷓鷚鷯鷦鷲鷸鷺鸇鷹鸌鸏鸛鸘鹺麥麩黃黌黶黷黲黽黿鼂鼉鞀鼴齇齊齏齒齔齕齗齟齡齙齠齜齦齬齪齲齷龍龔龕龜誌製谘隻裡係範鬆冇嚐嘗鬨麵準鐘彆閒乾儘臟拚'; // Use full version
}

function tc_to_sc($text)
{
	static $map = null;
	if ($map === null) {
		$tc = preg_split('//u', FTPYStr(), -1, PREG_SPLIT_NO_EMPTY);
		$sc = preg_split('//u', JTPYStr(), -1, PREG_SPLIT_NO_EMPTY);
		$map = array_combine($tc, $sc);
	}
	return strtr($text, $map);
}

function cuhk_multilang_text($tc_text, $sc_text = '', $en_text = '')
{
	$lang = function_exists('pll_current_language') ? pll_current_language() : 'en';

	if ($sc_text === '') {
		$sc_text = tc_to_sc($tc_text);
	}

	switch ($lang) {
		case 'tc':
			return $tc_text;
		case 'sc':
			return $sc_text;
		default:
			return $en_text;
	}
}

add_filter('manage_profile_posts_columns', 'add_profile_photo_column');
function add_profile_photo_column($columns)
{
	// Insert "Photo" column just before "Title" (optional)
	$new_columns = [];

	foreach ($columns as $key => $value) {
		if ($key === 'cb') {
			$new_columns[$key] = $value;
			$new_columns['photo'] = 'Photo'; // Insert photo after checkbox
		} else {
			$new_columns[$key] = $value;
		}
	}

	return $new_columns;
}


add_action('manage_profile_posts_custom_column', 'show_profile_photo_column', 10, 2);
function show_profile_photo_column($column, $post_id)
{
	if ($column === 'photo') {
		$image = get_field('photo', $post_id);
		if ($image) {
			$url = is_array($image) ? $image['sizes']['thumbnail'] : wp_get_attachment_image_url($image, 'thumbnail');
			echo '<img src="' . esc_url($url) . '" style="max-height: 50px;" />';
		} else {
			echo '—';
		}
	}
}

// ===== GALLERY AND HOME NEWS AJAX HANDLERS =====

// AJAX handler for filtering galleries
function filter_galleries_ajax()
{
	// Verify nonce
	if (!wp_verify_nonce($_POST['nonce'], 'filter_galleries_nonce')) {
		wp_die('Security check failed');
	}

	$page = intval($_POST['page']);
	$category = sanitize_text_field($_POST['category']);
	$year = sanitize_text_field($_POST['year']);
	$posts_per_page = 12;

	$args = array(
		'post_type' => 'gallery',
		'post_status' => 'publish',
		'posts_per_page' => $posts_per_page,
		'paged' => $page,
		'orderby' => 'date',
		'order' => 'DESC',
		'post_status' => 'publish'
	);

	// Add category filter
	if ($category && $category !== 'all') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'gallery_category',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	// Add year filter using ACF "date" field (format: d/m/Y)
	if ($year) {
		$args['meta_query'][] = array(
			'key'     => 'date',
			'value'   => array($year . '0101', $year . '1231'),
			'compare' => 'BETWEEN',
			'type'    => 'NUMERIC',
		);
	}

	$query = new WP_Query($args);
	$galleries = array();

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'm');
			if (!$featured_image) {
				$featured_image = get_template_directory_uri() . '/images/schoolart_logo_bg.svg';
			}

			$gallery_categories = get_the_terms(get_the_ID(), 'gallery_category');
			$category_name = '';
			if ($gallery_categories && !is_wp_error($gallery_categories)) {
				$category_name = $gallery_categories[0]->name;
			}

			$galleries[] = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'permalink' => get_permalink(),
				'featured_image' => $featured_image,
				'category_name' => $category_name
			);
		}
	}

	wp_reset_postdata();

	$has_more = $page < $query->max_num_pages;

	wp_send_json_success(array(
		'galleries' => $galleries,
		'has_more' => $has_more,
		'current_page' => $page,
		'max_pages' => $query->max_num_pages
	));
}
add_action('wp_ajax_filter_galleries', 'filter_galleries_ajax');
add_action('wp_ajax_nopriv_filter_galleries', 'filter_galleries_ajax');

// AJAX handler for getting available years
function get_gallery_years_ajax()
{
	// Verify nonce
	if (!wp_verify_nonce($_POST['nonce'], 'get_gallery_years_nonce')) {
		wp_die('Security check failed');
	}

	global $wpdb;

	$meta_key = 'date'; // ACF field key (stored in Ymd format, e.g., 20240620)

	$years = $wpdb->get_col("
        SELECT DISTINCT 
            LEFT(meta_value, 4) AS year
        FROM {$wpdb->postmeta}
        INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
        WHERE meta_key = '{$meta_key}'
        AND {$wpdb->posts}.post_type = 'gallery'
        AND {$wpdb->posts}.post_status = 'publish'
        AND meta_value REGEXP '^[0-9]{8}$'
        ORDER BY year DESC
    ");

	wp_send_json_success(array(
		'years' => $years
	));
}
add_action('wp_ajax_get_gallery_years', 'get_gallery_years_ajax');
add_action('wp_ajax_nopriv_get_gallery_years', 'get_gallery_years_ajax');

// AJAX handler for loading home news
function load_home_news_ajax()
{
	// Verify nonce
	if (!wp_verify_nonce($_POST['nonce'], 'load_home_news_nonce')) {
		wp_die('Security check failed');
	}

	$month = intval($_POST['month']);
	$year = intval($_POST['year']);

	// Validate month and year
	if ($month < 1 || $month > 12 || $year < 2000 || $year > 2100) {
		wp_send_json_error('Invalid month or year');
		return;
	}

	$news_args = array(
		'post_type' => array('news', 'event'),
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'start_date',
				'value' => array(
					date('Ymd', strtotime("$year-$month-01")),
					date('Ymd', strtotime("$year-$month-" . date('t', strtotime("$year-$month-01"))))
				),
				'compare' => 'BETWEEN',
				'type' => 'NUMERIC'
			)
		),
		'orderby' => 'meta_value',
		'meta_key' => 'start_date',
		'order' => 'DESC',
		'post_status' => 'publish'
	);

	$news_query = new WP_Query($news_args);
	$grouped_news = array();

	if ($news_query->have_posts()) {
		while ($news_query->have_posts()) {
			$news_query->the_post();

			$start_date = get_field('start_date');
			if (!$start_date) continue;

			if (!isset($grouped_news[$start_date])) {
				$grouped_news[$start_date] = array();
			}

			$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'm');
			if (!$featured_image) {
				$featured_image = get_template_directory_uri() . '/images/news1.jpg';
			}

			$grouped_news[$start_date][] = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'link' => get_permalink(),
				'image' => $featured_image,
				'post_type' => get_post_type()
			);
		}
	}

	wp_reset_postdata();

	wp_send_json_success(array(
		'grouped_news' => $grouped_news,
		'month' => $month,
		'year' => $year,
		'total_posts' => $news_query->found_posts
	));
}
add_action('wp_ajax_load_home_news', 'load_home_news_ajax');
add_action('wp_ajax_nopriv_load_home_news', 'load_home_news_ajax');

// ===========================================
// ACF AUTO-TRANSLATION FROM TC TO SC
// ===========================================

/**
 * Auto-translate Traditional Chinese ACF fields to Simplified Chinese
 * Triggered when saving ACF fields
 * DISABLED: Only manual translation via button is allowed
 */
// add_action('acf/save_post', 'auto_translate_tc_to_sc_acf_fields', 20);

function auto_translate_tc_to_sc_acf_fields($post_id)
{
	// Skip if not using Polylang
	if (!function_exists('pll_get_post_language') || !function_exists('pll_get_post')) {
		return;
	}

	// Skip for autosave, revisions, etc.
	if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
		return;
	}

	// Check if this is a Traditional Chinese post
	$post_language = pll_get_post_language($post_id);
	if ($post_language !== 'tc') {
		return;
	}

	// Get the Simplified Chinese version of this post
	$sc_post_id = pll_get_post($post_id, 'sc');
	if (!$sc_post_id) {
		return;
	}

	// Get all ACF field groups for this post type
	$post_type = get_post_type($post_id);
	$field_groups = acf_get_field_groups(array('post_id' => $post_id));

	if (empty($field_groups)) {
		return;
	}

	// Remove this hook temporarily to prevent infinite loop
	remove_action('acf/save_post', 'auto_translate_tc_to_sc_acf_fields', 20);

	// Process each field group
	foreach ($field_groups as $field_group) {
		$fields = acf_get_fields($field_group);
		if ($fields) {
			translate_acf_fields_recursive($fields, $post_id, $sc_post_id);
		}
	}

	// Also translate post title and content if they exist
	$tc_post = get_post($post_id);
	if ($tc_post) {
		$update_data = array('ID' => $sc_post_id);

		if (!empty($tc_post->post_title)) {
			$update_data['post_title'] = tc_to_sc($tc_post->post_title);
		}

		if (!empty($tc_post->post_content)) {
			$update_data['post_content'] = tc_to_sc($tc_post->post_content);
		}

		if (!empty($tc_post->post_excerpt)) {
			$update_data['post_excerpt'] = tc_to_sc($tc_post->post_excerpt);
		}

		if (count($update_data) > 1) {
			wp_update_post($update_data);
		}
	}

	// Re-add the hook (DISABLED: Only manual translation allowed)
	// add_action('acf/save_post', 'auto_translate_tc_to_sc_acf_fields', 20);
}

/**
 * Recursively translate ACF fields
 */
function translate_acf_fields_recursive($fields, $tc_post_id, $sc_post_id)
{
	foreach ($fields as $field) {
		$field_name = $field['name'];
		$field_type = $field['type'];

		// Get the Traditional Chinese value
		$tc_value = get_field($field_name, $tc_post_id, false);

		if (empty($tc_value)) {
			continue;
		}

		// Translate based on field type
		$sc_value = translate_acf_field_value($tc_value, $field_type, $field);

		// Update the Simplified Chinese post
		if ($sc_value !== null) {
			update_field($field_name, $sc_value, $sc_post_id);
		}
	}
}

/**
 * Translate ACF field value based on field type
 */
function translate_acf_field_value($value, $field_type, $field = null)
{
	if (empty($value)) {
		return null;
	}

	switch ($field_type) {
		case 'text':
		case 'textarea':
		case 'email':
		case 'url':
		case 'password':
			return is_string($value) ? tc_to_sc($value) : $value;

		case 'wysiwyg':
			return is_string($value) ? tc_to_sc($value) : $value;

		case 'select':
		case 'radio':
		case 'button_group':
			// For choice fields, translate the value if it's a string
			return is_string($value) ? tc_to_sc($value) : $value;

		case 'checkbox':
			// For checkbox, translate each selected value
			if (is_array($value)) {
				return array_map(function ($item) {
					return is_string($item) ? tc_to_sc($item) : $item;
				}, $value);
			}
			return is_string($value) ? tc_to_sc($value) : $value;

		case 'repeater':
			if (is_array($value)) {
				$translated_repeater = array();
				foreach ($value as $row) {
					$translated_row = array();
					foreach ($row as $sub_field_name => $sub_value) {
						// Get sub field info
						$sub_field = null;
						if ($field && isset($field['sub_fields'])) {
							foreach ($field['sub_fields'] as $sf) {
								if ($sf['name'] === $sub_field_name) {
									$sub_field = $sf;
									break;
								}
							}
						}

						$sub_field_type = $sub_field ? $sub_field['type'] : 'text';
						$translated_row[$sub_field_name] = translate_acf_field_value($sub_value, $sub_field_type, $sub_field);
					}
					$translated_repeater[] = $translated_row;
				}
				return $translated_repeater;
			}
			break;

		case 'flexible_content':
			if (is_array($value)) {
				$translated_flexible = array();
				foreach ($value as $layout) {
					$translated_layout = array(
						'acf_fc_layout' => $layout['acf_fc_layout']
					);

					foreach ($layout as $layout_field_name => $layout_value) {
						if ($layout_field_name === 'acf_fc_layout') {
							continue;
						}

						// Find the field type for this layout field
						$layout_field_type = 'text'; // default
						if ($field && isset($field['layouts'])) {
							foreach ($field['layouts'] as $layout_config) {
								if ($layout_config['name'] === $layout['acf_fc_layout']) {
									foreach ($layout_config['sub_fields'] as $layout_sub_field) {
										if ($layout_sub_field['name'] === $layout_field_name) {
											$layout_field_type = $layout_sub_field['type'];
											break 2;
										}
									}
								}
							}
						}

						$translated_layout[$layout_field_name] = translate_acf_field_value($layout_value, $layout_field_type);
					}
					$translated_flexible[] = $translated_layout;
				}
				return $translated_flexible;
			}
			break;

		case 'group':
			if (is_array($value)) {
				$translated_group = array();
				foreach ($value as $group_field_name => $group_value) {
					// Get sub field info
					$group_field_type = 'text'; // default
					if ($field && isset($field['sub_fields'])) {
						foreach ($field['sub_fields'] as $gsf) {
							if ($gsf['name'] === $group_field_name) {
								$group_field_type = $gsf['type'];
								break;
							}
						}
					}

					$translated_group[$group_field_name] = translate_acf_field_value($group_value, $group_field_type);
				}
				return $translated_group;
			}
			break;

		case 'image':
		case 'file':
		case 'gallery':
		case 'post_object':
		case 'page_link':
		case 'relationship':
		case 'taxonomy':
		case 'user':
		case 'date_picker':
		case 'date_time_picker':
		case 'time_picker':
		case 'color_picker':
		case 'number':
		case 'range':
		case 'true_false':
			// These field types don't need translation
			return $value;

		default:
			// For unknown field types, try to translate if it's a string
			return is_string($value) ? tc_to_sc($value) : $value;
	}

	return $value;
}

/**
 * Optional: Add admin notice to inform about auto-translation
 * DISABLED: Only manual translation via button is allowed
 */
// add_action('acf/save_post', 'show_translation_notice', 21);

function show_translation_notice($post_id)
{
	if (!function_exists('pll_get_post_language') || !function_exists('pll_get_post')) {
		return;
	}

	$post_language = pll_get_post_language($post_id);
	if ($post_language === 'tc') {
		$sc_post_id = pll_get_post($post_id, 'sc');
		if ($sc_post_id) {
			// Store a transient to show notice on next page load
			set_transient('acf_translation_notice_' . get_current_user_id(), 'TC content has been automatically translated to SC.', 30);
		}
	}
}

/**
 * Display the translation notice
 * DISABLED: Only manual translation via button is allowed
 */
// add_action('admin_notices', 'display_translation_notice');

function display_translation_notice()
{
	$notice = get_transient('acf_translation_notice_' . get_current_user_id());
	if ($notice) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html($notice) . '</p></div>';
		delete_transient('acf_translation_notice_' . get_current_user_id());
	}
}

// ===========================================
// END ACF AUTO-TRANSLATION
// ===========================================

/**
 * Manual translation function for existing posts
 * Usage: translate_existing_post_tc_to_sc($tc_post_id);
 */
function translate_existing_post_tc_to_sc($tc_post_id)
{
	if (!function_exists('pll_get_post_language') || !function_exists('pll_get_post')) {
		return false;
	}

	// Check if this is a Traditional Chinese post
	$post_language = pll_get_post_language($tc_post_id);
	if ($post_language !== 'tc') {
		return false;
	}

	// Get the Simplified Chinese version of this post
	$sc_post_id = pll_get_post($tc_post_id, 'sc');
	if (!$sc_post_id) {
		return false;
	}

	// Get all ACF field groups for this post type
	$field_groups = acf_get_field_groups(array('post_id' => $tc_post_id));

	if (!empty($field_groups)) {
		// Process each field group
		foreach ($field_groups as $field_group) {
			$fields = acf_get_fields($field_group);
			if ($fields) {
				translate_acf_fields_recursive($fields, $tc_post_id, $sc_post_id);
			}
		}
	}

	// Also translate post title and content
	$tc_post = get_post($tc_post_id);
	if ($tc_post) {
		$update_data = array('ID' => $sc_post_id);

		if (!empty($tc_post->post_title)) {
			$update_data['post_title'] = tc_to_sc($tc_post->post_title);
		}

		if (!empty($tc_post->post_content)) {
			$update_data['post_content'] = tc_to_sc($tc_post->post_content);
		}

		if (!empty($tc_post->post_excerpt)) {
			$update_data['post_excerpt'] = tc_to_sc($tc_post->post_excerpt);
		}

		if (count($update_data) > 1) {
			wp_update_post($update_data);
		}
	}

	return true;
}

/**
 * Bulk translate all Traditional Chinese posts to Simplified Chinese
 * Usage: bulk_translate_all_tc_to_sc(['post', 'page', 'custom_post_type']);
 */
function bulk_translate_all_tc_to_sc($post_types = array('post', 'page'))
{
	if (!function_exists('pll_get_post_language') || !function_exists('pll_get_post')) {
		return array('error' => 'Polylang not available');
	}

	$results = array(
		'success' => 0,
		'skipped' => 0,
		'errors' => array()
	);

	foreach ($post_types as $post_type) {
		$posts = get_posts(array(
			'post_type' => $post_type,
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'lang' => 'tc' // Polylang parameter to get only TC posts
		));

		foreach ($posts as $post) {
			$success = translate_existing_post_tc_to_sc($post->ID);
			if ($success) {
				$results['success']++;
			} else {
				$results['skipped']++;
				$results['errors'][] = "Failed to translate post ID: {$post->ID}";
			}
		}
	}

	return $results;
}



/**
 * Add meta box with translate button to post edit screens
 */
add_action('add_meta_boxes', 'add_tc_to_sc_translate_meta_box');

function add_tc_to_sc_translate_meta_box()
{
	// Get all public post types
	$post_types = get_post_types(array('public' => true), 'names');

	foreach ($post_types as $post_type) {
		add_meta_box(
			'tc_to_sc_translate',
			'Traditional to Simplified Chinese Translation',
			'tc_to_sc_translate_meta_box_callback',
			$post_type,
			'side',
			'default'
		);
	}
}

function tc_to_sc_translate_meta_box_callback($post)
{
	// Only show for Traditional Chinese posts
	if (!function_exists('pll_get_post_language') || !function_exists('pll_get_post')) {
		echo '<p>Polylang not available.</p>';
		return;
	}

	$post_language = pll_get_post_language($post->ID);

	if ($post_language !== 'tc') {
		echo '<p>This feature is only available for Traditional Chinese posts.</p>';
		return;
	}

	// Check if SC version exists
	$sc_post_id = pll_get_post($post->ID, 'sc');
	if (!$sc_post_id) {
		echo '<p>No Simplified Chinese version found. Please create a linked SC post first.</p>';
		return;
	}

	$sc_post = get_post($sc_post_id);
	$sc_edit_link = get_edit_post_link($sc_post_id);

	wp_nonce_field('tc_to_sc_translate_single', 'tc_to_sc_translate_nonce');
	?>
	<div id="tc-to-sc-translate-container">
		<p><strong>SC Post:</strong> <a href="<?php echo esc_url($sc_edit_link); ?>" target="_blank"><?php echo esc_html($sc_post->post_title); ?></a></p>

		<p>
			<button type="button" id="tc-to-sc-translate-btn" class="button button-secondary button-large" style="width: 100%;">
				<span class="dashicons dashicons-translation" style="vertical-align: middle;"></span>
				Translate to Simplified Chinese
			</button>
		</p>

		<div id="tc-to-sc-translate-status" style="display: none;">
			<p class="notice-success" style="padding: 10px; margin: 10px 0;">
				<span class="dashicons dashicons-yes-alt"></span>
				Translation completed successfully!
			</p>
		</div>

		<div id="tc-to-sc-translate-error" style="display: none;">
			<p class="notice-error" style="padding: 10px; margin: 10px 0;">
				<span class="dashicons dashicons-warning"></span>
				<span id="error-message">Translation failed.</span>
			</p>
		</div>

		<p class="description">
			This will translate all ACF fields, title, content, and excerpt from this Traditional Chinese post to the linked Simplified Chinese post.
		</p>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#tc-to-sc-translate-btn').on('click', function() {
				var button = $(this);
				var container = $('#tc-to-sc-translate-container');
				var statusDiv = $('#tc-to-sc-translate-status');
				var errorDiv = $('#tc-to-sc-translate-error');

				// Reset status
				statusDiv.hide();
				errorDiv.hide();

				// Disable button and show loading
				button.prop('disabled', true);
				button.html('<span class="dashicons dashicons-update spin" style="vertical-align: middle;"></span> Translating...');

				// Make AJAX request
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'tc_to_sc_translate_single_post',
						post_id: <?php echo $post->ID; ?>,
						nonce: $('#tc_to_sc_translate_nonce').val()
					},
					success: function(response) {
						if (response.success) {
							statusDiv.show();
							button.html('<span class="dashicons dashicons-yes-alt" style="vertical-align: middle;"></span> Translation Completed');

							// Re-enable button after 3 seconds
							setTimeout(function() {
								button.prop('disabled', false);
								button.html('<span class="dashicons dashicons-translation" style="vertical-align: middle;"></span> Translate to Simplified Chinese');
							}, 3000);
						} else {
							errorDiv.find('#error-message').text(response.data || 'Translation failed.');
							errorDiv.show();
							button.prop('disabled', false);
							button.html('<span class="dashicons dashicons-translation" style="vertical-align: middle;"></span> Translate to Simplified Chinese');
						}
					},
					error: function() {
						errorDiv.find('#error-message').text('AJAX request failed.');
						errorDiv.show();
						button.prop('disabled', false);
						button.html('<span class="dashicons dashicons-translation" style="vertical-align: middle;"></span> Translate to Simplified Chinese');
					}
				});
			});
		});
	</script>

	<style>
		.dashicons.spin {
			animation: rotation 1s infinite linear;
		}

		@keyframes rotation {
			from {
				transform: rotate(0deg);
			}

			to {
				transform: rotate(359deg);
			}
		}
	</style>
<?php
}

/**
 * AJAX handler for single post translation
 */
add_action('wp_ajax_tc_to_sc_translate_single_post', 'handle_tc_to_sc_translate_single_post');

function handle_tc_to_sc_translate_single_post()
{
	// Verify nonce
	if (!wp_verify_nonce($_POST['nonce'], 'tc_to_sc_translate_single')) {
		wp_send_json_error('Security check failed.');
		return;
	}

	// Check permissions
	if (!current_user_can('edit_posts')) {
		wp_send_json_error('Insufficient permissions.');
		return;
	}

	$post_id = intval($_POST['post_id']);

	if (!$post_id) {
		wp_send_json_error('Invalid post ID.');
		return;
	}

	// Use the existing translation function
	$success = translate_existing_post_tc_to_sc($post_id);

	if ($success) {
		wp_send_json_success('Translation completed successfully.');
	} else {
		wp_send_json_error('Translation failed. Please check if this is a TC post with a linked SC version.');
	}
}


function hide_polylang_language_ui()
{
	echo '
    <style>
        /* Hide the <p> with "Language" */
        #ml_box .inside > p:first-of-type {
            display: none !important;
        }

        /* Hide the screen-reader label */
        #ml_box .inside > label.screen-reader-text {
            display: none !important;
        }

        /* Hide the language dropdown */
        #select-post-language {
            display: none !important;
        }
    </style>';
}
add_action('admin_head', 'hide_polylang_language_ui');



/**
 * Add styles/classes to the "Styles" drop-down
 */

add_filter('tiny_mce_before_init', 'fb_mce_before_init');

function fb_mce_before_init($settings)
{
	// Set to true to include the default settings.
	$settings['style_formats_merge'] = false;

	$style_formats = [
		[
			'title' => 'Paragraph',
			'format' => 'p',
		],
		[
			'title' => 'Super Title',
			'format' => 'h4',
		],
		[
			'title' => 'Title',
			'format' => 'h5',
		],
		[
			'title' => 'Subtitle',
			'format' => 'h6',
		],
		[
			'title' => 'Small',
			'format' => 'small',
		],
		[
			'title' => 'Round Button',
			'selector' => 'a',
			'classes' => 'round_btn',
		],
		[
			'title' => 'Border Table',
			'selector' => 'table',
			'classes' => 'border_table',
		],
		[
			'title' => 'Table with Gradient Bg',
			'selector' => 'table',
			'classes' => 'table-bg',
		],
		[
			'title' => 'Arrow Bullet',
			'selector' => 'ul',
			'classes' => 'arrow_bullet',
		],


	];

	$settings['style_formats'] = json_encode($style_formats);
	unset($settings['preview_styles']);
	return $settings;
}

add_action('wp_ajax_get_search', 'get_search');
add_action('wp_ajax_nopriv_get_search', 'get_search');

function get_search()
{
    $posts_per_page = 20;

    $current_page = isset($_POST['pager']) ? $_POST['pager'] : 0;

    $args = ['post_type' => 'any', 'posts_per_page' => '-1', 'posts_per_page' => '-1', 'post_status' => 'publish'];

    if (isset($_POST['keyword']) && $_POST['keyword'] != '') {
        $args['s'] = $_POST['keyword'];
    }

    $total_q = new WP_Query($args);
    $total = ceil(count($total_q->posts) / $posts_per_page);

    $args['posts_per_page'] = $posts_per_page;
    $args['paged'] = $current_page;

    $query_q = new WP_Query($args);

    $items = [];

    while ($query_q->have_posts()):
        $query_q->the_post();
        $parent_title = '';
        $current = $post->ID;
        $parent = $post->post_parent;
        $grandparent_get = get_post($parent);
        $grandparent = $grandparent_get->post_parent;
        if (
            $root_parent =
                get_the_title($grandparent) !==
                ($root_parent = get_the_title($current))
        ) {
            $parent_title = get_the_title($grandparent);
        } elseif (get_the_title($current) !== get_the_title($parent)) {
            $parent_title = get_the_title($parent);
        }

        $type = '';
        if ('news' == get_post_type()) {
            $type = cuhk_multilang_text("學系消息", "", "News");
        } elseif ('event' == get_post_type()) {
            $type = cuhk_multilang_text("學系活動", "", "Events");
        } elseif ('publication' == get_post_type()) {
            $type = cuhk_multilang_text("出版刊物", "", "Publication");
        } elseif ('gallery' == get_post_type()) {
            $type = cuhk_multilang_text("學系剪影", "", "Snapshots");
        }elseif ('research_project' == get_post_type()) {
            $type = cuhk_multilang_text("研究計劃", "", "Research Projects");
        }elseif ('profile' == get_post_type()) {
            $type = cuhk_multilang_text("學系成員", "", "People");
        }elseif ('course' == get_post_type()) {
            $type = cuhk_multilang_text("科目", "", "Course");
        }elseif ('teaching_project' == get_post_type()) {
            $type = cuhk_multilang_text("教學計劃", "", "Teaching Projects");
        }

        $local = [
            'title' => get_the_title(),
            'link' => get_the_permalink(),
            'parent_title' => $parent_title,
            'type' => $type,
        ];

        $items[] = $local;
    endwhile;

    $test = count($total_q->posts);

    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {
        $result = json_encode([
            'type' => 'success',
            'data' => $items,
            'total' => $total,
            'test' => $test,
        ]);
        echo $result;
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    die();
}


// AJAX handler for getting available years for news
function get_news_years_ajax()
{
	// Verify nonce
	if (!wp_verify_nonce($_POST['nonce'], 'get_news_years_nonce')) {
		wp_die('Security check failed');
	}

	global $wpdb;

	$meta_key = 'start_date'; // ACF field key (stored in Ymd format, e.g., 20240620)

	$years = $wpdb->get_col("
        SELECT DISTINCT 
            LEFT(meta_value, 4) AS year
        FROM {$wpdb->postmeta}
        INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
        WHERE meta_key = '{$meta_key}'
        AND {$wpdb->posts}.post_type = 'news'
        AND {$wpdb->posts}.post_status = 'publish'
        AND meta_value REGEXP '^[0-9]{8}$'
        ORDER BY year DESC
    ");

	wp_send_json_success(array(
		'years' => $years
	));
}
add_action('wp_ajax_get_news_years', 'get_news_years_ajax');
add_action('wp_ajax_nopriv_get_news_years', 'get_news_years_ajax');


// AJAX handler for filtering news
function filter_news_ajax()
{
	// Verify nonce
	if (!wp_verify_nonce($_POST['nonce'], 'filter_news_nonce')) {
		wp_die('Security check failed');
	}

	$page = intval($_POST['page']);
	$category = sanitize_text_field($_POST['category']);
	$year = sanitize_text_field($_POST['year']);
	$posts_per_page = 12;

	$args = array(
		'post_type' => 'news',
		'post_status' => 'publish',
		'posts_per_page' => $posts_per_page,
		'paged' => $page,
		'meta_key' => 'start_date',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'post_status' => 'publish'
	);

	// Add category filter
	if ($category && $category !== 'all') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'news_category',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	// Add year filter using ACF "date" field (format: d/m/Y)
	if ($year) {
		$args['meta_query'][] = array(
			'key'     => 'date',
			'value'   => array($year . '0101', $year . '1231'),
			'compare' => 'BETWEEN',
			'type'    => 'NUMERIC',
		);
	}

	$query = new WP_Query($args);
	$news = array();

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			
			$photo = '';

			$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'm');
			$news_banner = get_field('news_banner');

			if ($featured_image) {
				$photo = $featured_image;
			} elseif ($news_banner && isset($news_banner['sizes']['m'])) {
				$photo = $news_banner['sizes']['m'];
			} else {
				$photo = get_template_directory_uri() . '/images/schoolart_logo_bg.svg';
			}

			$news_categories = get_the_terms(get_the_ID(), 'news_category');
			$category_name = '';


			// Default to current language if none is specified
			if (!$lang && function_exists('pll_current_language')) {
				$lang = pll_current_language();
			}

			if ($news_categories && !is_wp_error($news_categories)) {
				$category_name = get_field($lang.'_name', 'news_category_'.$news_categories[0]->term_id);
			}

			$start_date_raw = get_field('start_date'); // This is in Ymd format, e.g. 20250622
			if (!$start_date_raw) continue;
			if ($start_date_raw) {
				$date_obj = DateTime::createFromFormat('Ymd', $start_date_raw);
				$date = $date_obj->format('j/n/Y');
			}
			

			$news[] = array(
				'id' => get_the_ID(),
				'title' => get_field('news_name'),
				'permalink' => get_permalink(),
				'date' => $date,
				'featured_image' => $photo,
				'category_name' => $category_name
			);
		}
	}

	wp_reset_postdata();

	$has_more = $page < $query->max_num_pages;

	wp_send_json_success(array(
		'news' => $news,
		'has_more' => $has_more,
		'current_page' => $page,
		'max_pages' => $query->max_num_pages
	));
}
add_action('wp_ajax_filter_news', 'filter_news_ajax');
add_action('wp_ajax_nopriv_filter_news', 'filter_news_ajax');


// AJAX handler for getting available years
function get_language_event_years_ajax() {
    // Verify nonce
    if ( empty($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'get_language_event_years_nonce') ) {
        wp_die('Security check failed');
    }

    global $wpdb;

    $meta_key = 'start_date';          // ACF date in Ymd (e.g. 20240620)
    $taxonomy = 'event_category';      // your taxonomy
    $term_slug = 'language-events';    // the slug to filter by

    $sql = $wpdb->prepare("
        SELECT DISTINCT LEFT(pm.meta_value, 4) AS year
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        INNER JOIN {$wpdb->term_relationships} tr ON tr.object_id = p.ID
        INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
        INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id
        WHERE pm.meta_key = %s
          AND pm.meta_value REGEXP '^[0-9]{8}$'
          AND p.post_type = 'event'
          AND p.post_status = 'publish'
          AND tt.taxonomy = %s
          AND t.slug = %s
        ORDER BY year DESC
    ", $meta_key, $taxonomy, $term_slug);

    $years = $wpdb->get_col($sql);

    wp_send_json_success([
        'years' => $years,
    ]);
}
add_action('wp_ajax_get_language_event_years', 'get_language_event_years_ajax');
add_action('wp_ajax_nopriv_get_language_event_years', 'get_language_event_years_ajax');

// AJAX handler for loading events grouped by coming/old (Alpine.js version)
function load_all_events_with_year()
{
	check_ajax_referer('load_all_events_with_year_nonce', 'nonce');

	$page_coming = isset($_POST['page_coming']) ? intval($_POST['page_coming']) : 1;
	$page_old    = isset($_POST['page_old']) ? intval($_POST['page_old']) : 1;

	$category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
	$year     = isset($_POST['year']) ? sanitize_text_field($_POST['year']) : '';

	$pastonly = isset($_POST['pastonly']);

	$today    = date('Y-m-d');

	// Build query args
	$coming_args = array(
		'post_type'      => 'event',
		'posts_per_page' => EVENTS_PER_PAGE,
		'paged'          => $page_coming,
		'meta_key'       => 'start_date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'post_status'    => 'publish',
		'meta_query'     => array(
			'relation' => 'OR', // 使用 OR 關聯，滿足任一條件
			array(
				// 條件 1: 未來的 event（start_date >= 今天）
				'key'     => 'start_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE'
			),
			array(
				// 條件 2: 尚未結束的 event（end_date >= 今天，且 end_date 存在）
				'key'     => 'end_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE'
			),
			array(
				// 條件 3: 只有 start_date 的單天 event（end_date 不存在或為空）
				'relation' => 'AND',
				array(
					'key'     => 'start_date',
					'value'   => $today,
					'compare' => '>=',
					'type'    => 'DATE'
				),
				array(
					'key'     => 'end_date',
					'compare' => 'NOT EXISTS', // 處理 end_date 為空的情況
				)
			)
		)
	);

	// your existing OR block already in $coming_args['meta_query']
	$base_or = $coming_args['meta_query'];

	// build the year clause (skip when empty or "all")
	$year_clause = array();
	if (!empty($year) && strtolower($year) !== 'all') {
		$year_clause[] = array(
			'key'     => 'start_date',
			'value'   => array($year . '0101', $year . '1231'),
			'compare' => 'BETWEEN',
			'type'    => 'NUMERIC',
		);
	}

	// only merge if we actually have a year clause
	if (!empty($year_clause)) {
		$coming_args['meta_query'] = array_merge(
			array('relation' => 'AND', $base_or), // keep the original OR group
			$year_clause                  // add the year filter(s)
		);
	}

	// Add taxonomy query if category is not 'all'
	if ($category !== 'all') {
		$coming_args['tax_query'] = array(
			array(
				'taxonomy' => 'event_category',
				'field' => 'slug',
				'terms' => $category
			)
		);
	}

	/**
	 * OLD EVENTS
	 */
	$pastonly = isset($_POST['pastonly']);

	// Build query args for past events (latest to oldest)
	$old_args = array(
		'post_type'      => 'event',
		'posts_per_page' => EVENTS_PER_PAGE,
		'paged'          => $page_old,
		'meta_key'       => 'start_date', // for ordering
		'orderby'        => 'meta_value',
		'order'          => 'DESC',
		'post_status' => 'publish'
	);

	$meta_query = array();

		$meta_query[] = array(
			'key'     => 'start_date',
			'value'   => $today,
			'compare' => '<',
			'type'    => 'DATE',
		);

	if ($year) {
		$meta_query[] = array(
			'key'     => 'start_date',
			'value'   => array($year . '0101', $year . '1231'),
			'compare' => 'BETWEEN',
			'type'    => 'NUMERIC',
		);
	}

	// Apply meta_query only if needed
	if (!empty($meta_query)) {
		$old_args['meta_query'] = array_merge(array('relation' => 'AND'), $meta_query);
	}

	// Add taxonomy query if category is not 'all'
	if ($category !== 'all') {
		$old_args['tax_query'] = array(
			array(
				'taxonomy' => 'event_category',
				'field' => 'slug',
				'terms' => $category
			)
		);
	}

	// Run both queries
	$coming_query = new WP_Query($coming_args);
	$old_query    = new WP_Query($old_args);

	$build_event = function () {
		$event_name = get_field('event_name');
		$photo = '';

		$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'm');
		$event_banner   = get_field('event_banner');

		if ($featured_image) {
			$photo = $featured_image;
		} elseif ($event_banner && isset($event_banner['sizes']['m'])) {
			$photo = $event_banner['sizes']['m'];
		} else {
			$photo = get_template_directory_uri() . '/images/schoolart_logo_bg.svg';
		}

		$start_date  = get_field('start_date'); // Ymd
		$end_date    = get_field('end_date');   // Ymd or empty
		$event_time  = get_field('event_time');
		$event_venue = get_field('event_venue');

		$start_date_obj = DateTime::createFromFormat('Ymd', $start_date);
		$end_date_obj   = $end_date ? DateTime::createFromFormat('Ymd', $end_date) : null;

		$has_date_range = $end_date && $start_date !== $end_date;

		if ($has_date_range) {
			$date_display = $start_date_obj->format('j/n/Y') . '－' . $end_date_obj->format('j/n/Y');
		} else {
			$date_display = $start_date_obj->format('j/n/Y');
		}

		return array(
			'id'               => get_the_ID(),
			'event_name'       => $event_name,
			'permalink'        => get_permalink(),
			'start_date_short' => $start_date_obj->format('j/n'),
			'end_date_short'   => $end_date_obj ? $end_date_obj->format('j/n') : '',
			'has_date_range'   => (bool) $has_date_range,
			'date_display'     => $date_display,
			'event_time'       => $event_time,
			'event_venue'      => $event_venue,
			'event_banner'     => $photo ? array(
				'url' => $photo,
				'alt' => $event_name
			) : null,
		);
	};

	$coming_events = array();
	if ($coming_query->have_posts()) {
		while ($coming_query->have_posts()) {
			$coming_query->the_post();
			$coming_events[] = $build_event();
		}
		wp_reset_postdata();
	}

	$old_events = array();
	if ($old_query->have_posts()) {
		while ($old_query->have_posts()) {
			$old_query->the_post();
			$old_events[] = $build_event();
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'coming_events'   => $coming_events,
		'has_more_coming' => $page_coming < $coming_query->max_num_pages,
		'old_events'      => $old_events,
		'has_more_old'    => $page_old < $old_query->max_num_pages,
	));
}
add_action('wp_ajax_load_all_events_with_year', 'load_all_events_with_year');
add_action('wp_ajax_nopriv_load_all_events_with_year', 'load_all_events_with_year');
