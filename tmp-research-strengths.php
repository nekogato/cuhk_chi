<?php

/**
 * Template Name: Research Strengths
 *
 * @package cuhk_chi
 */

get_header();

// Include roll menu with research target
get_template_part('template-parts/roll-menu');

if (have_posts()) :
	while (have_posts()) : the_post();
?>

		<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg6.jpg" class="ink_bg6 scrollin scrollinbottom" alt="Background">
		

		<div class="section section_content section_intro">
			<div class="section_center_content small_section_center_content">
				<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
				<?php if (get_field('introduction')): ?>
					<div class="section_description scrollin scrollinbottom col6"><?php the_field('introduction'); ?></div>
				<?php endif; ?>
			</div>
		</div>

		<div class="section section_content">
			<div class="section_center_content small_section_center_content">
				<div class="col10 center_content">
					<div class="research_centre_box_list research_centre_box_list2">
						<?php if (have_rows('research_strengths')): ?>
							<?php $popup_index = 1; ?>
							<?php while (have_rows('research_strengths')): the_row(); ?>
								<?php
								$image = get_sub_field('image');
								$title = get_sub_field('title');
								$description = get_sub_field('description');
								$detailed_description = get_sub_field('detailed_description');
								$popup_id = 'popup' . $popup_index;
								?>
								<div class="research_centre_box scrollin scrollinbottom col_wrapper">
									<div class="row flex">
										<div class="research_centre_logo col col4">
											<div class="col_spacing">
												<div class="thumb">
													<?php if ($image): ?>
														<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
													<?php endif; ?>
												</div>
											</div>
										</div>
										<div class="research_centre_text col col8">
											<div class="col_spacing">
												<div class="description">
													<?php if ($title): ?>
														<div class="t1 text6"><?php echo esc_html($title); ?></div>
													<?php endif; ?>
													<?php if ($description): ?>
														<div class="t2 text6"><?php echo wp_kses_post($description); ?></div>
													<?php endif; ?>
													<?php if ($detailed_description): ?>
														<div class="btn_wrapper">
															<a href="#" class="round_btn text7 popup_btn" data-target="<?php echo esc_attr($popup_id); ?>"><?php pll_e('了解更多'); ?></a>
														</div>
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php $popup_index++; ?>
							<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Render Popups -->
		<?php if (have_rows('research_strengths')): ?>
			<?php $popup_index = 1; ?>
			<?php while (have_rows('research_strengths')): the_row(); ?>
				<?php
				$image = get_sub_field('image');
				$title = get_sub_field('title');
				$detailed_description = get_sub_field('detailed_description');
				$popup_id = 'popup' . $popup_index;
				?>
				<?php if ($detailed_description): ?>
					<div class="people_popup scholarship_popup popup" data-id="<?php echo esc_attr($popup_id); ?>">
						<div class="people_detail_content">
							<div class="people_detail_incontent">
								<?php if ($image): ?>
									<div class="people_detail_photo_wrapper scrollin scrollinbottom">
										<div class="popup_left_photo">
											<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
										</div>
									</div>
								<?php endif; ?>
								<div class="people_detail_text scrollin scrollinbottom">
									<?php if ($title): ?>
										<div class="title2 text4"><?php echo esc_html($title); ?></div>
									<?php endif; ?>
									<div class="description">
										<div class="t2 free_text"><?php echo wp_kses_post($detailed_description); ?></div>
									</div>
								</div>
							</div>
						</div>
						<a class="popup_close_btn"></a>
					</div>
				<?php endif; ?>
				<?php $popup_index++; ?>
			<?php endwhile; ?>
		<?php endif; ?>

<?php
	endwhile;
endif;

get_footer(); ?>