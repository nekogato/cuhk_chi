<?php

/**
 * Template Name: General
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu');

if (have_posts()) :
	while (have_posts()) : the_post();

		// Get ACF fields
		$page_title = get_field('page_title');
		$page_description = get_field('description');
		$page_freetext = get_field('free_text');
?>

		<div class="section section_content resource_top_section">
			<div class="section_center_content small_section_center_content">
				<?php if ($page_title): ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo wp_kses_post($page_title); ?></h1>
				<?php endif; ?>

				<?php if ($page_description): ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo wp_kses_post($description); ?></div>
				<?php endif; ?>

				<?php if ($page_freetext): ?>
					<div class="section_introduction col6 scrollin scrollinbottom">
						<div class="free_text">
							<?php echo wp_kses_post($page_freetext); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>


<?php
	endwhile;
endif;

get_footer(); ?>