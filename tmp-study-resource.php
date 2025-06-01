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
		$resources_title = get_the_title();
		$resources_description = get_field('introduction');
		$resources_introduction = get_field('resources_introduction');
		$download_section_title = get_field('download_section_title');
?>

		<div class="section section_content resource_top_section">
			<div class="section_center_content small_section_center_content">
				<?php if ($resources_title): ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo esc_html($resources_title); ?></h1>
				<?php endif; ?>

				<?php if ($resources_description): ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo esc_html($resources_description); ?></div>
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

		<div class="section section_content filter_menu_section resource_filter_menu_section scrollin scrollinbottom">
			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				<?php if ($download_section_title): ?>
					<h2 class="section_title text1 scrollin scrollinbottom"><?php echo esc_html($download_section_title); ?></h2>
				<?php endif; ?>
			</div>

			<div class="filter_menu_wrapper">
				<div class="filter_menu filter_menu_left_bg section_center_content small_section_center_content scrollin scrollinbottom">
					<div class="filter_menu_content">
						<div class="filter_checkbox_wrapper text7 filter_switchable_wrapper">
							<?php if (have_rows('filter_categories')): ?>
								<?php
								$filter_index = 1;
								while (have_rows('filter_categories')): the_row();
									$category_name = get_sub_field('category_name');
									$filter_id = 'filter' . $filter_index;
									$is_first = ($filter_index === 1);
								?>
									<div class="filter_checkbox">
										<div class="checkbox">
											<input name="filter" type="radio" id="<?php echo esc_attr($filter_id); ?>" <?php echo $is_first ? 'checked' : ''; ?>>
											<label for="<?php echo esc_attr($filter_id); ?>">
												<span><?php echo esc_html($category_name); ?></span>
											</label>
										</div>
									</div>
								<?php
									$filter_index++;
								endwhile;
								?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="switchable_section_expandable_list_wrapper scrollin scrollinbottom">
				<?php if (have_rows('filter_categories')): ?>
					<?php
					$category_index = 1;
					while (have_rows('filter_categories')): the_row();
						$filter_id = 'filter' . $category_index;
						$is_first = ($category_index === 1);
					?>
						<div class="section_expandable_list switchable_section_expandable_list <?php echo $is_first ? 'active' : ''; ?>" data-id="<?php echo esc_attr($filter_id); ?>">
							<?php if (have_rows('download_groups')): ?>
								<?php while (have_rows('download_groups')): the_row(); ?>
									<?php
									$group_title = get_sub_field('group_title');
									$group_content = get_sub_field('group_content');
									?>
									<div class="expandable_item">
										<div class="section_center_content small_section_center_content">
											<div class="expandable_title text5"><?php echo esc_html($group_title); ?><div class="icon"></div>
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
						$category_index++;
					endwhile;
					?>
				<?php endif; ?>
			</div>
		</div>

<?php
	endwhile;
endif;

get_footer(); ?>