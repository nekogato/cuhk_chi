<?php

/**
 * Template Name: Scholarships & Opportunities
 * Template for displaying scholarships and opportunities
 */

get_header();

// Include roll menu for Study section
get_template_part('template-parts/roll-menu', null, array('target_page' => 'study'));

if (have_posts()) :
	while (have_posts()) : the_post();
?>

		<div class="ink_bg13_wrapper">
			<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg13.jpg" class="ink_bg13 scrollin scrollinbottom" alt="Background">
		</div>

		<div class="section section_content">
			<div class="section_center_content small_section_center_content">
				<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
			</div>

			<div class="filter_menu_wrapper">
				<div class="filter_menu filter_menu_left_bg section_center_content small_section_center_content scrollin scrollinbottom">
					<div class="filter_menu_content">
						<div class="filter_checkbox_wrapper text7 scholarship_filter">
							<div class="filter_checkbox">
								<div class="checkbox"><input type="radio" name="filter" id="all" checked><label for="all"><span><?php pll_e('All'); ?></span></label></div>
							</div>
							<div class="filter_checkbox">
								<div class="checkbox"><input type="radio" name="filter" id="ba_programme"><label for="ba_programme"><span><?php pll_e('BA programme'); ?></span></label></div>
							</div>
							<div class="filter_checkbox">
								<div class="checkbox"><input type="radio" name="filter" id="ma_programme"><label for="ma_programme"><span><?php pll_e('MA programme'); ?></span></label></div>
							</div>
							<div class="filter_checkbox">
								<div class="checkbox"><input type="radio" name="filter" id="mphil_programme"><label for="mphil_programme"><span><?php pll_e('MPhil programme'); ?></span></label></div>
							</div>
							<div class="filter_checkbox">
								<div class="checkbox"><input type="radio" name="filter" id="phd_programme"><label for="phd_programme"><span><?php pll_e('PhD programme'); ?></span></label></div>
							</div>
							<div class="filter_checkbox">
								<div class="checkbox"><input type="radio" name="filter" id="general_education"><label for="general_education"><span><?php pll_e('General Education'); ?></span></label></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
			// Get scholarships/opportunities from custom post type or ACF fields
			$scholarships = get_field('scholarships');

			if ($scholarships) :
			?>
				<div class="section_expandable_list scrollin scrollinbottom">
					<?php foreach ($scholarships as $scholarship) :
						$target_programmes = $scholarship['target_programmes'] ?? array();
						$programme_classes = '';
						if ($target_programmes) {
							$programme_classes = implode(' ', $target_programmes);
						}
					?>
						<div class="expandable_item <?php echo esc_attr($programme_classes); ?>">
							<div class="section_center_content small_section_center_content">
								<div class="expandable_title text5">
									<?php echo esc_html($scholarship['title'] ?? ''); ?>
									<div class="icon"></div>
								</div>
								<div class="hidden">
									<div class="hidden_content">
										<div class="table_flex_item_wrapper">
											<?php if ($scholarship['scholarship_title']) : ?>
												<div class="table_flex_item">
													<div class="title text7"><?php pll_e('Title of scholarship'); ?></div>
													<div class="text"><?php echo esc_html($scholarship['scholarship_title']); ?></div>
												</div>
											<?php endif; ?>

											<?php if ($scholarship['amount']) : ?>
												<div class="table_flex_item">
													<div class="title text7"><?php pll_e('Amount'); ?></div>
													<div class="text"><?php echo esc_html($scholarship['amount']); ?></div>
												</div>
											<?php endif; ?>

											<?php if ($scholarship['application_period']) : ?>
												<div class="table_flex_item">
													<div class="title text7"><?php pll_e('Application period'); ?></div>
													<div class="text"><?php echo esc_html($scholarship['application_period']); ?></div>
												</div>
											<?php endif; ?>

											<?php if ($scholarship['target_student']) : ?>
												<div class="table_flex_item">
													<div class="title text7"><?php pll_e('Target Student'); ?></div>
													<div class="text"><?php echo wp_kses_post($scholarship['target_student']); ?></div>
												</div>
											<?php endif; ?>

											<?php if ($scholarship['description']) : ?>
												<div class="table_flex_item">
													<div class="title text7"><?php pll_e('Description'); ?></div>
													<div class="text free_text"><?php echo wp_kses_post($scholarship['description']); ?></div>
												</div>
											<?php endif; ?>
										</div>

										<?php if ($scholarship['download_files']) : ?>
											<div class="download_btn_wrapper text7">
												<?php foreach ($scholarship['download_files'] as $file) : ?>
													<a href="<?php echo esc_url($file['url']); ?>" class="border_button" target="_blank">
														<?php echo esc_html($file['title'] ?: 'Download PDF'); ?>
													</a>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php
		// Get student stories/testimonials if available
		$student_stories = get_field('student_stories');
		$student_stories_title = get_field('student_stories_title');
		$student_stories_description = get_field('student_stories_description');
		if ($student_stories) :
		?>
			<div class="section section_content" id="section_stories">
				<div class="section_center_content small_section_center_content scrollin scrollinbottom">
					<h1 class="section_title text1"><?php echo esc_html($student_stories_title); ?></h1>
					<div class="section_description"><?php echo esc_html($student_stories_description); ?></div>
				</div>
				<div class="thumb_text_box_slider_wrapper scrollin scrollinbottom">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<?php foreach ($student_stories as $index => $story) :
								$story_id = 'story_' . $index;
							?>
								<div class="swiper-slide popup_btn" data-target="popup<?php echo $story_id; ?>">
									<div class="thumb thumb2">
										<?php if ($story['photo']) :
											// Get 392x202 thumbnail size for swiper slides
											$image_id = $story['photo']['ID'];
											$thumbnail = wp_get_attachment_image_src($image_id, '392x202');
											$thumbnail_url = $thumbnail ? $thumbnail[0] : $story['photo']['url'];
											$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $story['photo']['alt'];
										?>
											<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($alt_text); ?>">
										<?php endif; ?>
										<?php if ($story['video_url']) : ?>
											<div class="video_play_btn"></div>
										<?php endif; ?>
									</div>
									<div class="text">
										<div class="text_spacing">
											<div class="cat"><?php echo esc_html($story['category']); ?></div>
											<div class="title text5"><?php echo esc_html($story['title']); ?></div>
											<div class="description"><?php echo esc_html($story['description']); ?></div>
											<div class="name text8"><?php echo esc_html($story['student_name']); ?></div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="prev_btn"></div>
					<div class="next_btn"></div>
				</div>
			</div>

			<!-- Popups for student stories -->
			<?php foreach ($student_stories as $index => $story) :
				$story_id = 'story_' . $index;
			?>
				<div class="people_popup scholarship_popup popup" data-id="popup<?php echo $story_id; ?>">
					<div class="people_detail_content">
						<div class="people_detail_incontent">
							<div class="people_detail_photo_wrapper">
								<?php if ($story['video_url']) : ?>
									<div class="video_wrapper">
										<iframe class="youtube-video" src="<?php echo esc_url($story['video_url']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									</div>
								<?php elseif ($story['photo']) : ?>
									<div class="people_detail_photo">
										<?php
										// Get 400px wide thumbnail
										$image_id = $story['photo']['ID'];
										$thumbnail = wp_get_attachment_image_src($image_id, array(400, 9999));
										$thumbnail_url = $thumbnail ? $thumbnail[0] : $story['photo']['url'];
										$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $story['photo']['alt'];
										?>
										<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($alt_text); ?>">
									</div>
								<?php endif; ?>
							</div>
							<div class="people_detail_text scrollin scrollinbottom">
								<div class="title1 text6"><?php echo esc_html($story['category']); ?></div>
								<div class="title2 text4"><?php echo esc_html($story['title']); ?></div>
								<div class="description">
									<div class="t2 free_text"><?php echo wp_kses_post($story['description']); ?></div>
									<div class="t3 text8"><?php echo esc_html($story['student_name']); ?></div>
								</div>
							</div>
						</div>
					</div>
					<a class="popup_close_btn"></a>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>

<?php
	endwhile;
endif;

get_footer();
?>