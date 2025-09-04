<?php

/**
 * Template Name: Study Internship
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu');

if (have_posts()) :
	while (have_posts()) : the_post();

		// Get ACF fields
		$section_title = get_the_title();
		$section_description = get_field('introduction');
		$section_introduction = get_field('intership_introduction');
		$internship_list_title = get_field('internship_list_title');
		$photo_album_title = get_field('photo_album_title');
		$award_section_title = get_field('award_section_title');
		$feedback_section_title = get_field('feedback_section_title');
?>

		<div class="section section_content resource_top_section">
			<div class="section_center_content small_section_center_content ">
				<?php if ($section_title): ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo esc_html($section_title); ?></h1>
				<?php endif; ?>

				<?php if ($section_description): ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo esc_html($section_description); ?></div>
				<?php endif; ?>

				<?php if ($section_introduction): ?>
					<div class="section_introduction col6 scrollin scrollinbottom">
						<div class="free_text">
							<?php echo wp_kses_post($section_introduction); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="section section_content filter_menu_section resource_filter_menu_section">
			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				<?php if ($internship_list_title): ?>
					<h3 class="section_smalltitle"><?php echo esc_html($internship_list_title); ?></h3>
				<?php endif; ?>
			</div>

			<?php if (have_rows('internship_list')): ?>
				<div class="filter_menu_wrapper">
					<div class="filter_menu filter_menu_left_bg section_center_content small_section_center_content scrollin scrollinbottom">
						<div class="filter_menu_content">
							<div class="filter_checkbox_wrapper text7 filter_switchable_wrapper">
								<?php
								$category_index = 1;
								while (have_rows('internship_list')): the_row();
									$category_name = get_sub_field('category_name');
									$filter_id = 'filter' . $category_index;
									$is_first = ($category_index === 1) ? 'checked' : '';
								?>
									<div class="filter_checkbox">
										<div class="checkbox">
											<input name="filter" type="radio" id="<?php echo esc_attr($filter_id); ?>" <?php echo $is_first; ?>>
											<label for="<?php echo esc_attr($filter_id); ?>">
												<span><?php echo esc_html($category_name); ?></span>
											</label>
										</div>
									</div>
								<?php
									$category_index++;
								endwhile;
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="switchable_section_expandable_list_wrapper scrollin scrollinbottom">
					<?php
					$category_index = 1;
					while (have_rows('internship_list')): the_row();
						$filter_id = 'filter' . $category_index;
						$is_active = ($category_index === 1) ? 'active' : '';
					?>
						<div class="section_expandable_list switchable_section_expandable_list <?php echo $is_active; ?>" data-id="<?php echo esc_attr($filter_id); ?>">
							<?php 
							
							if (have_rows('expandable_items')): ?>
								<?php
								$item_index = 1;
								while (have_rows('expandable_items')): the_row();
									$item_title = get_sub_field('item_title');
									$item_content = get_sub_field('item_content');
									$is_first_active = ($item_index === 1) ? 'active' : '';
								?>
									<div class="expandable_item <?php echo $is_first_active; ?> scrollin scrollinbottom">
										<div class="section_center_content small_section_center_content">
											<div class="expandable_title text5"><?php echo esc_html($item_title); ?><div class="icon"></div>
											</div>
											<div class="hidden">
												<div class="hidden_content">
													<div class="free_text">
														<?php echo wp_kses_post($item_content); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
									$item_index++;
								endwhile;
								?>
							<?php endif; ?>
						</div>
					<?php
						$category_index++;
					endwhile;
					?>
				</div>
			<?php endif; ?>
		</div>

		<?php if (have_rows('photo_albums')): ?>
			<div class="section section_content section_committee_album">
				<div class="section_center_content small_section_center_content scrollin scrollinbottom">
					<?php if ($photo_album_title): ?>
						<h3 class="section_smalltitle"><?php echo esc_html($photo_album_title); ?></h3>
					<?php endif; ?>
					<div class="committee_albums_slider">
						<div class="swiper-container swiper">
							<div class="swiper-wrapper">
								<?php
								$album_index = 1;
								while (have_rows('photo_albums')): the_row();
									$album_title = get_sub_field('album_title');
									$album_photos = get_sub_field('album_photos');
									$gallery_id = 'gallery' . $album_index;
								?>
									<div class="swiper-slide">
										<div class="album_title text5"><?php echo esc_html($album_title); ?></div>
										<div class="committee_album_slider">
											<div class="swiper-container swiper">
												<div class="swiper-wrapper">
													<?php if ($album_photos): ?>
														<?php foreach ($album_photos as $photo): ?>
															<div class="swiper-slide">
																<a href="<?php echo esc_url($photo['url']); ?>"
																	data-fancybox="<?php echo esc_attr($gallery_id); ?>"
																	data-caption="<?php echo esc_attr($album_title); ?>">
																	<img src="<?php echo esc_url($photo['sizes']['medium']); ?>"
																		alt="<?php echo esc_attr($photo['alt']); ?>">
																</a>
															</div>
														<?php endforeach; ?>
													<?php endif; ?>
												</div>
											</div>
											<div class="dot_wrapper"></div>
										</div>
									</div>
								<?php
									$album_index++;
								endwhile;
								?>
								<div class="swiper-slide"></div>
							</div>
						</div>
						<div class="prev_btn"></div>
						<div class="next_btn"></div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if (have_rows('award_winners')): ?>
			<div class="section section_content alumni_story_section">
				<div class="section_center_content small_section_center_content scrollin scrollinbottom">
					<?php if ($award_section_title): ?>
						<h3 class="section_smalltitle"><?php echo esc_html($award_section_title); ?></h3>
					<?php endif; ?>
				</div>
				<div class="thumb_text_box_slider_wrapper scrollin scrollinbottom">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<?php while (have_rows('award_winners')): the_row(); ?>
								<?php
								$winner_photo = get_sub_field('winner_photo');
								$winner_year = get_sub_field('winner_year');
								$winner_name = get_sub_field('winner_name');
								$winner_organization = get_sub_field('winner_organization');
								$winner_description = get_sub_field('winner_description');
								$winner_link = get_sub_field('winner_link');
								?>
								<div class="swiper-slide">
									<div class="thumb">
										<?php if ($winner_photo): ?>
											<img src="<?php echo esc_url($winner_photo['sizes']['medium']); ?>"
												alt="<?php echo esc_attr($winner_photo['alt']); ?>">
										<?php endif; ?>
									</div>
									<div class="text">
										<div class="text_spacing">
											<?php if ($winner_year): ?>
												<div class="year"><?php echo esc_html($winner_year); ?></div>
											<?php endif; ?>
											<?php if ($winner_name): ?>
												<div class="title text5"><?php echo esc_html($winner_name); ?></div>
											<?php endif; ?>
											<?php if ($winner_organization): ?>
												<div class="title2"><?php echo esc_html($winner_organization); ?></div>
											<?php endif; ?>
											<?php if ($winner_description): ?>
												<div class="description"><?php echo esc_html($winner_description); ?></div>
											<?php endif; ?>
											<?php if ($winner_link): ?>
												<div class="btn_wrapper text7">
													<a href="<?php echo esc_url($winner_link['url']); ?>" class="round_btn">
														<?php echo cuhk_multilang_text("了解更多", "", "Details"); ?>
													</a>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
					<div class="prev_btn"></div>
					<div class="next_btn"></div>
				</div>
			</div>
		<?php endif; ?>

		<?php if (have_rows('feedback_testimonials')): ?>
			<div class="section section_content alumni_story_section">
				<div class="section_center_content small_section_center_content scrollin scrollinbottom">
					<?php if ($feedback_section_title): ?>
						<h3 class="section_smalltitle"><?php echo esc_html($feedback_section_title); ?></h3>
					<?php endif; ?>
				</div>

				<div class="thumb_text_box_slider_wrapper2">
					<div class="section_center_content small_section_center_content scrollin scrollinbottom">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php while (have_rows('feedback_testimonials')): the_row(); ?>
									<?php
									$testimonial_photo = get_sub_field('testimonial_photo');
									$testimonial_name = get_sub_field('testimonial_name');
									$testimonial_organization = get_sub_field('testimonial_organization');
									$testimonial_year = get_sub_field('testimonial_year');
									$testimonial_description = get_sub_field('testimonial_description');
									$testimonial_link = get_sub_field('testimonial_link');
									?>
									<div class="swiper-slide">
										<div class="thumb">
											<?php if ($testimonial_photo): ?>
												<img src="<?php echo esc_url($testimonial_photo['sizes']['medium']); ?>"
													alt="<?php echo esc_attr($testimonial_photo['alt']); ?>">
											<?php endif; ?>
										</div>
										<div class="text">
											<div class="text_spacing">
												<div class="title_wrapper">
													<?php if ($testimonial_name): ?>
														<div class="title text5"><?php echo esc_html($testimonial_name); ?></div>
													<?php endif; ?>
													<?php if ($testimonial_organization): ?>
														<div class="title2"><?php echo esc_html($testimonial_organization); ?></div>
													<?php endif; ?>
													<?php if ($testimonial_year): ?>
														<div class="year"><?php echo esc_html($testimonial_year); ?></div>
													<?php endif; ?>
												</div>
												<?php if ($testimonial_description): ?>
													<div class="description"><?php echo esc_html($testimonial_description); ?></div>
												<?php endif; ?>
												<?php if ($testimonial_link): ?>
													<div class="btn_wrapper text7">
														<a href="<?php echo esc_url($testimonial_link['url']); ?>" class="round_btn">
															<?php echo cuhk_multilang_text("了解更多", "", "Details"); ?>
														</a>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
						<div class="prev_btn"></div>
						<div class="next_btn"></div>
					</div>
				</div>
			</div>
		<?php endif; ?>

<?php
	endwhile;
endif;

get_footer(); ?>