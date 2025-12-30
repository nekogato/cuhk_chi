<?php

/**
 * Template Name: Newsletter
 */

get_header();

echo "test";

$latest = get_posts([
  'post_type'      => 'newsletter',
  'post_status'    => 'publish',
  'posts_per_page' => 1,
  'no_found_rows'  => true,
]);

var_dump($latest);

if (!empty($latest)) {
  wp_safe_redirect(get_permalink($latest[0]->ID), 302);
  exit;
}

// If there are no published newsletters, fall back somewhere sensible:
wp_safe_redirect(home_url('/'), 302);
exit;

// Include roll menu
get_template_part('template-parts/roll-menu');

if (have_posts()) :
	while (have_posts()) : the_post();

	
?>

		<div class="section section_content ">
			<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg9.jpg" class="ink_bg9 scrollin scrollinbottom" alt="Background">
			<div class="section_center_content xs_section_center_content">
				<?php if ($page_title): ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo wp_kses_post($page_title); ?></h1>
				<?php endif; ?>

				<?php if ($page_description): ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo wp_kses_post($description); ?></div>
				<?php endif; ?>

				<div class="section_introduction col12 scrollin scrollinbottom">
					<div class="free_text">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>


<?php
	endwhile;
endif;

get_footer(); ?>