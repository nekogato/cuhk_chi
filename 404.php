<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package cuhk_chi
 */

get_header();
// Include roll menu
get_template_part('template-parts/roll-menu');

if (have_posts()) :
	while (have_posts()) : the_post();

?>

	<div class="section section_content ">
			<div class="section_center_content xs_section_center_content">
				<?php if ($page_title): ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo cuhk_multilang_text("404找不到網頁。","","404 Page not found."); ?></h1>
				<?php endif; ?>

				<?php if ($page_description): ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo cuhk_multilang_text("很抱歉，我們未能提供你所找尋的路徑。該路徑也許不正確或已被移除。","","Sorry, the CUHK page you are looking for cannot be found. The URL address may be incorrect or the page may be outdated. "); ?></div>
				<?php endif; ?>

			</div>
		</div>


<?php
	endwhile;
endif;

get_footer(); ?>