<?php

/**
 * cuhk_chi functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cuhk_chi
 */

define('MPHIL_PHD_RESEARCH_MAX_POSTS', 6);
define('PUBLICATIONS_PER_PAGE', 6);
define('NEWS_PER_PAGE', 4);
define('EVENTS_PER_PAGE', 4);
define('MAX_POSTGRADUATE_STUDENTS_PER_PAGE', 6);

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
	add_image_size('s', 500, 500, array('center', 'center'));
	add_image_size('xs', 200, 200, array('center', 'center'));
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
	wp_enqueue_script('cuhk_chi-ScrollMagic', get_template_directory_uri() . '/script/lib/ScrollMagic.min.js', array(), '', false);
	wp_enqueue_script('cuhk_chi-gsap', get_template_directory_uri() . '/script/lib/gsap.min.js', array(), '', false);
	wp_enqueue_style('cuhk_chi-swiper-style', get_template_directory_uri() . '/script/lib/swiper/css/swiper.min.css', '', '', 'all');
	wp_enqueue_script('cuhk_chi-swiper', get_template_directory_uri() . '/script/lib/swiper/js/swiper.min.js', array('cuhk_chi-jquery'), '', false);
	wp_enqueue_style('cuhk_chi-fancy-style', get_template_directory_uri() . '/script/lib/fancybox/jquery.fancybox.min.css', '', '', 'all');
	wp_enqueue_script('cuhk_chi-fancy', get_template_directory_uri() . '/script/lib/fancybox/jquery.fancybox.min.js', array('cuhk_chi-jquery'), '', false);

	// Add Alpine.js only for postgraduate research students template
	if (is_page_template('tmp-postgraduate_research_students.php')) {
		wp_enqueue_script('alpinejs', 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js', array(), '3.13.3', true);
		wp_script_add_data('alpinejs', 'defer', true);
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
function pll_get_page_url($page_slug)
{

	// Check parameter
	if (empty($page_slug)) return false;

	// Get the page
	$page = get_page_by_path($page_slug);

	// Check if the page exists
	if (empty($page) || is_null($page)) return false;

	// Get the URL
	$page_ID_current_lang = pll_get_post($page->ID);

	// Return the current language permalink
	return empty($page_ID_current_lang) ? get_permalink($page->ID) : get_permalink($page_ID_current_lang);
}

add_action('wp_footer', 'pll_get_page_url');


function my_theme_add_editor_styles()
{
	add_editor_style('editor-style.css');
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
		'paged' => $page
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
		'orderby' => 'date',
		'order' => 'DESC'
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
	$offset = ($page * NEWS_PER_PAGE) + 2; // Add 2 to account for featured posts

	$args = array(
		'post_type' => 'news',
		'posts_per_page' => NEWS_PER_PAGE,
		'offset' => $offset,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$news_banner = get_field('news_banner');
		?>
			<div class="news_box col col4">
				<div class="col_spacing scrollin scrollinbottom">
					<div class="photo">
						<?php if ($news_banner): ?>
							<img src="<?php echo esc_url($news_banner['url']); ?>" alt="<?php echo esc_attr($news_banner['alt']); ?>">
						<?php endif; ?>
					</div>
					<div class="text_wrapper">
						<div class="date_wrapper text5"><?php echo get_the_date('M d'); ?></div>
						<div class="title_wrapper">
							<div class="title text5"><?php the_title(); ?></div>
							<div class="btn_wrapper text8">
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

// AJAX handler for loading more events
function load_more_events()
{
	check_ajax_referer('load_more_events_nonce', 'nonce');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;

	$args = array(
		'post_type' => 'event',
		'posts_per_page' => EVENTS_PER_PAGE,
		'paged' => $page,
		'orderby' => 'meta_value',
		'meta_key' => 'start_date',
		'order' => 'ASC'
	);

	$events = new WP_Query($args);
	$html = '';

	if ($events->have_posts()) {
		while ($events->have_posts()) {
			$events->the_post();

			$event_name = get_field('event_name');
			$event_banner = get_field('event_banner');
			$start_date = get_field('start_date');
			$end_date = get_field('end_date');
			$event_time = get_field('event_time');
			$event_venue = get_field('event_venue');

			// Format dates
			$start_date_obj = new DateTime($start_date);
			$end_date_obj = new DateTime($end_date);

			ob_start();
		?>
			<div class="event_list_item flex">
				<div class="date">
					<div class="d_wrapper">
						<?php if ($start_date && $end_date && $start_date !== $end_date) : ?>
							<div class="d">
								<div class="d1 text3"><?php echo get_chinese_month($start_date_obj->format('M')); ?></div>
								<div class="d2 text5"><?php echo $start_date_obj->format('d'); ?></div>
							</div>
							<div class="d">
								<div class="d1 text3"><?php echo get_chinese_month($end_date_obj->format('M')); ?></div>
								<div class="d2 text5"><?php echo $end_date_obj->format('d'); ?></div>
							</div>
						<?php else : ?>
							<div class="d">
								<div class="d1 text3"><?php echo get_chinese_month($start_date_obj->format('M')); ?></div>
								<div class="d2 text5"><?php echo $start_date_obj->format('d'); ?></div>
							</div>
						<?php endif; ?>
					</div>
					<div class="btn_wrapper">
						<a href="<?php the_permalink(); ?>" class="reg_btn round_btn text7"><?php pll_e('了解更多'); ?></a>
					</div>
				</div>
				<div class="title_wrapper">
					<div class="title text5"><?php echo esc_html($event_name); ?></div>
					<div class="info_item_wrapper">
						<div class="info_item">
							<div class="t1"><?php pll_e('日期'); ?></div>
							<div class="t2 text6">
								<?php
								if ($start_date && $end_date && $start_date !== $end_date) {
									echo esc_html($start_date_obj->format('Y年m月d日') . '－' . $end_date_obj->format('Y年m月d日'));
								} else {
									echo esc_html($start_date_obj->format('Y年m月d日'));
								}
								?>
							</div>
						</div>
						<?php if ($event_time) : ?>
							<div class="info_item">
								<div class="t1"><?php pll_e('時間'); ?></div>
								<div class="t2 text6"><?php echo esc_html($event_time); ?></div>
							</div>
						<?php endif; ?>
						<?php if ($event_venue) : ?>
							<div class="info_item big_info_item">
								<div class="t1"><?php pll_e('地點'); ?></div>
								<div class="t2 text6"><?php echo esc_html($event_venue); ?></div>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php if ($event_banner) : ?>
					<div class="photo">
						<img src="<?php echo esc_url($event_banner['sizes']['l']); ?>" alt="<?php echo esc_attr($event_banner['alt']); ?>">
					</div>
				<?php endif; ?>
			</div>
<?php
			$html .= ob_get_clean();
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'html' => $html,
		'has_more' => $page < $events->max_num_pages
	));
}
add_action('wp_ajax_load_more_events', 'load_more_events');
add_action('wp_ajax_nopriv_load_more_events', 'load_more_events');

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

// AJAX handler for loading postgraduate students
function load_postgraduate_students()
{
	check_ajax_referer('load_postgraduate_students_nonce', 'nonce');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$alphabet = isset($_POST['alphabet']) ? sanitize_text_field($_POST['alphabet']) : '';
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
				'qualifications' => $qualifications
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
