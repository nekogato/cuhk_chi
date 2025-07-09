<?php

/**
 * Template Name: Study Resource
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu');

if (have_posts()) :
	while (have_posts()) : the_post();

		// Get ACF fields
		$resources_title = get_field('page_title');
		$resources_description = get_field('introduction');
		$resources_introduction = get_field('resources_introduction');
		$download_section_title = get_field('download_section_title');
?>
		<div class="ink_bg13_wrapper">
			<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg13.jpg" class="ink_bg13 scrollin scrollinbottom" alt="Background">
		</div>
		<div class="section section_content resource_top_section">
			<div class="section_center_content small_section_center_content">
				<?php if ($resources_title): ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo wp_kses_post($resources_title); ?></h1>
				<?php endif; ?>

				<?php if ($resources_description): ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo wp_kses_post($resources_description); ?></div>
				<?php endif; ?>

				<?php if ($resources_introduction): ?>
					<div class="section_introduction col6 scrollin scrollinbottom">
						<div class="free_text">
							<?php echo wp_kses_post($resources_introduction); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="section section_content resource_content_section scrollin scrollinbottom">
			

				<?php if (have_rows('filter_categories')): ?>
					<?php
					while (have_rows('filter_categories')): the_row();
						$category_name = get_sub_field('category_name');
					?>

						<div class="section_expandable_list" >
							<div class="section_expandable_list_title">
								<div class="section_center_content small_section_center_content">
									<h3><?php echo $category_name;?></h3>
								</div>
							</div>
							<?php if (have_rows('download_groups')): ?>
								<?php while (have_rows('download_groups')): the_row(); ?>
									<?php
									$group_title = get_sub_field('group_title');
									$group_content = get_sub_field('group_content');
									?>
									<div class="expandable_item">
										<div class="section_center_content small_section_center_content">
											<div class="expandable_title text5"><?php echo wp_kses_post($group_title); ?><div class="icon"></div>
											</div>
											<div class="hidden">
												<div class="hidden_content">
													<div class="free_text">
														<?php echo wp_kses_post($group_content); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
						</div>
					<?php
					endwhile;
					?>
				<?php endif; ?>
		</div>

<?php
	endwhile;
endif;

get_footer(); ?>