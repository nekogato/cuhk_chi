<?php

/**
 * Template Name: Study Abroad
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu');

if (have_posts()) :
	while (have_posts()) : the_post();

		// Get ACF fields
		$past_activities_title = get_field('past_activities_title');
		$past_activities_description = get_field('past_activities_description');
?>

		<div class="section section_content">
			<div class="section_center_content small_section_center_content">
				<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
			</div>

			<?php if (have_rows('exchange_programs')): ?>
				<div class="section_expandable_list">
					<?php while (have_rows('exchange_programs')): the_row(); ?>
						<?php
						$program_title = get_sub_field('program_title');
						$institution_partner = get_sub_field('institution_partner');
						$target_student = get_sub_field('target_student');
						$application_period = get_sub_field('application_period');
						$description = get_sub_field('description');
						$download_files = get_sub_field('download_files');
						?>
						<div class="expandable_item scrollin scrollinbottom">
							<div class="section_center_content small_section_center_content">
								<div class="expandable_title text5"><?php echo esc_html($program_title); ?><div class="icon"></div>
								</div>
								<div class="hidden">
									<div class="hidden_content">
										<div class="table_flex_item_wrapper">
											<?php if ($institution_partner): ?>
												<div class="table_flex_item">
													<div class="title text7"><?php pll_e('Institution Partner'); ?></div>
													<div class="text"><?php echo esc_html($institution_partner); ?></div>
												</div>
											<?php endif; ?>
											<?php if ($target_student): ?>
												<div class="table_flex_item">
													<div class="title text7"><?php pll_e('Target Student'); ?></div>
													<div class="text"><?php echo esc_html($target_student); ?></div>
												</div>
											<?php endif; ?>
											<?php if ($application_period): ?>
												<div class="table_flex_item">
													<div class="title text7"><?php pll_e('Application Period'); ?></div>
													<div class="text"><?php echo esc_html($application_period); ?></div>
												</div>
											<?php endif; ?>
											<?php if ($description): ?>
												<div class="table_flex_item">
													<div class="title text7"><?php pll_e('Description'); ?></div>
													<div class="text free_text"><?php echo wp_kses_post($description); ?></div>
												</div>
											<?php endif; ?>
										</div>
										<?php if ($download_files): ?>
											<div class="download_btn_wrapper text7">
												<?php foreach ($download_files as $file): ?>
													<?php if ($file['file']): ?>
														<a href="<?php echo esc_url($file['file']['url']); ?>" class="border_button" target="_blank">
															<?php echo $file['file_label'] ? esc_html($file['file_label']) : pll_e('Download PDF'); ?>
														</a>
													<?php endif; ?>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if (have_rows('past_activities')): ?>
			<div class="section section_content">
				<div class="section_center_content small_section_center_content scrollin scrollinbottom">
					<?php if ($past_activities_title): ?>
						<h1 class="section_title text1"><?php echo esc_html($past_activities_title); ?></h1>
					<?php endif; ?>
					<?php if ($past_activities_description): ?>
						<div class="section_description"><?php echo esc_html($past_activities_description); ?></div>
					<?php endif; ?>
				</div>
				<div class="thumb_text_box_slider_wrapper scrollin scrollinbottom">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<?php
							$activity_index = 1;
							while (have_rows('past_activities')): the_row();
							?>
								<?php
								$activity_image = get_sub_field('activity_image');
								$activity_category = get_sub_field('activity_category');
								$activity_title = get_sub_field('activity_title');
								$activity_description = get_sub_field('activity_description');
								$activity_name = get_sub_field('activity_name');
								$popup_id = 'popup' . $activity_index;
								?>
								<div class="swiper-slide popup_btn" data-target="<?php echo esc_attr($popup_id); ?>">
									<div class="thumb thumb2">
										<?php if ($activity_image): ?>
											<img src="<?php echo esc_url($activity_image['sizes']['medium']); ?>"
												alt="<?php echo esc_attr($activity_image['alt']); ?>">
										<?php endif; ?>
									</div>
									<div class="text">
										<div class="text_spacing">
											<?php if ($activity_category): ?>
												<div class="cat"><?php echo esc_html($activity_category); ?></div>
											<?php endif; ?>
											<?php if ($activity_title): ?>
												<div class="title text5"><?php echo esc_html($activity_title); ?></div>
											<?php endif; ?>
											<?php if ($activity_description): ?>
												<div class="description"><?php echo esc_html($activity_description); ?></div>
											<?php endif; ?>
											<?php if ($activity_name): ?>
												<div class="name text8"><?php echo esc_html($activity_name); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php
								$activity_index++;
							endwhile;
							?>
						</div>
					</div>
					<div class="prev_btn"></div>
					<div class="next_btn"></div>
				</div>
			</div>
		<?php endif; ?>

		<?php if (have_rows('past_activities')): ?>
			<?php
			$activity_index = 1;
			while (have_rows('past_activities')): the_row();
			?>
				<?php
				$activity_category = get_sub_field('activity_category');
				$activity_title = get_sub_field('activity_title');
				$activity_description = get_sub_field('activity_description');
				$activity_name = get_sub_field('activity_name');
				$activity_video_url = get_sub_field('activity_video_url');
				$popup_id = 'popup' . $activity_index;
				?>
				<div class="people_popup scholarship_popup popup" data-id="<?php echo esc_attr($popup_id); ?>">
					<div class="people_detail_content">
						<div class="people_detail_incontent">
							<div class="people_detail_photo_wrapper">
								<?php if ($activity_video_url): ?>
									<div class="video_wrapper">
										<iframe class="youtube-video"
											src="<?php echo esc_url($activity_video_url); ?>"
											title="YouTube video player"
											frameborder="0"
											allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
											allowfullscreen>
										</iframe>
									</div>
								<?php endif; ?>
							</div>
							<div class="people_detail_text scrollin scrollinbottom">
								<?php if ($activity_category): ?>
									<div class="title1 text6"><?php echo esc_html($activity_category); ?></div>
								<?php endif; ?>
								<?php if ($activity_title): ?>
									<div class="title2 text4"><?php echo esc_html($activity_title); ?></div>
								<?php endif; ?>
								<div class="description">
									<?php if ($activity_description): ?>
										<div class="t2 free_text"><?php echo esc_html($activity_description); ?></div>
									<?php endif; ?>
									<?php if ($activity_name): ?>
										<div class="t3 text8"><?php echo esc_html($activity_name); ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<a class="popup_close_btn"></a>
				</div>
			<?php
				$activity_index++;
			endwhile;
			?>
		<?php endif; ?>

<?php
	endwhile;
endif;

get_footer(); ?>