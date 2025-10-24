<?php /* Template Name: Study Overview */ ?>
<?php
/**
 * The template for displaying study overview pages
 * Features hero banner, flexible content sections, testimonials, and student experience
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php
while (have_posts()) :
	the_post();
?>

	<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg3.jpg" class="ink_bg3 scrollin scrollinbottom" alt="">
	<?php
	$hero_banner = get_field('hero_banner');
	if ($hero_banner) : ?>
		<div class="section top_photo_banner_section top_photo_banner_section_hidden">
			<div class="section_center_content small_section_center_content">
				<div class="col_wrapper xl_col_wrapper">
					<div class="flex row">
						<div class="col4 col">
							<div class="col_spacing scrollin scrollinbottom">
								<div class="text_wrapper">
									<div class="text">
										<div class="title_bg_wrapper">
											<h1 class="project_title text_c1"><span><?php echo esc_html($hero_banner['main_title']); ?></span></h1>
										</div>
										<div class="description free_text">
											<?php echo apply_filters('the_content', $hero_banner['description']); ?>
										</div>
										<?php if ($hero_banner['buttons']) : ?>
											<div class="border_btn_wrapper">
												<div class="btn_title "><?php echo cuhk_multilang_text("下載檔案","","Download PDF"); ?></div>
												
												<?php foreach ($hero_banner['buttons'] as $button) : ?>
													<?php if ($button['button_link']) : ?>
														<a class="btn" target="_blank" href="<?php echo esc_url($button['button_link']['url']); ?>">
															<div class="btn_text"><?php echo esc_html($button['button_text']); ?></div>
														</a>
													<?php endif; ?>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col8 col">
							<div class="col_spacing scrollin scrollinleft">
								<div class="photo_wrapper">
									<div class="photo">
										<?php if ($hero_banner['hero_image']) : ?>
											<?php
											$image_id = $hero_banner['hero_image']['ID'];
											$image_src = wp_get_attachment_image_src($image_id, 'm');
											$image_url = $image_src ? $image_src[0] : $hero_banner['hero_image']['url'];
											?>
											<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($hero_banner['hero_image']['alt']); ?>">
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if (have_rows('content_sections')) : ?>
		<?php while (have_rows('content_sections')) : the_row(); ?>

			<?php if (get_row_layout() == 'plain_text_section') : ?>
				<?php
				$background_style = get_sub_field('background_style');
				$layouts = get_sub_field('flexible_layouts');
				?>
				<div class="section plain_text_section border_layout_section <?php if ($background_style == 'top_green_gradient'){echo "top_green_gradient";}; ?>">
					<?php if ($background_style == 'ink') : ?>
						<div class="brush_bg"></div>
					<?php endif; ?>
					<div class="section_center_content small_section_center_content ">
						<div class="flexible_layout_wrapper">
							<?php if ($layouts) : ?>
								<?php foreach ($layouts as $layout) : ?>
									<div class="flexible_layout flexible_layout_<?php echo esc_attr($layout['layout_type']); ?> scrollin scrollinbottom">
										<?php if ($layout['section_title']) : ?>
											<h4 class="text_c3 center_text flexible_layout_small_title"><?php echo esc_html($layout['section_title']); ?></h4>
										<?php endif; ?>
										<div class="col_wrapper xl_col_wrapper">
											<div class="flex row flex_h_center">
												<?php if ($layout['layout_type'] == 'one_column') : ?>
													<div class="col10 col">
														<div class="col_spacing">
															<div class="free_text">
																<?php echo apply_filters('the_content', $layout['content']); ?>
															</div>
														</div>
													</div>
												<?php elseif ($layout['layout_type'] == 'two_column') : ?>
													<div class="col5 col">
														<div class="col_spacing">
															<div class="free_text">
																<?php echo apply_filters('the_content', $layout['left_content']); ?>
															</div>
														</div>
													</div>
													<div class="col5 col">
														<div class="col_spacing">
															<div class="free_text">
																<?php echo apply_filters('the_content', $layout['right_content']); ?>
															</div>
														</div>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>

			<?php elseif (get_row_layout() == 'testimonials_section') : ?>
				<?php
				$section_title = get_sub_field('section_title');
				$section_description = get_sub_field('section_description');
				$testimonials = get_sub_field('testimonials');
				?>
				<div class="section section_content top_green_gradient">
					<div class="section_center_content small_section_center_content scrollin scrollinbottom">
						<?php if ($section_title) : ?>
							<h3 class="section_title text3 text_c3"><?php echo esc_html($section_title); ?></h3>
						<?php endif; ?>
						<?php if ($section_description) : ?>
							<div class="section_description"><?php echo wp_kses_post($section_description); ?></div>
						<?php endif; ?>
					</div>
					<?php if ($testimonials) : ?>
						<div class="thumb_text_box_slider_wrapper scrollin scrollinbottom">
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<?php foreach ($testimonials as $index => $testimonial) : ?>
										<div class="swiper-slide popup_btn" data-target="popup<?php echo ($index + 1); ?>">
											<?php if ($testimonial['photo']) : ?>
												<div class="thumb thumb2">
													<?php
													$image_id = $testimonial['photo']['ID'];
													$image_src = wp_get_attachment_image_src($image_id, 'm');
													$image_url = $image_src ? $image_src[0] : $testimonial['photo']['url'];
													?>
													<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($testimonial['photo']['alt']); ?>">
												</div>
											<?php endif; ?>
											<div class="text">
												<div class="text_spacing">
													<?php if ($testimonial['category']) : ?>
														<div class="cat"><?php echo esc_html($testimonial['category']); ?></div>
													<?php endif; ?>
													<?php if ($testimonial['title']) : ?>
														<div class="title text5"><?php echo esc_html($testimonial['title']); ?></div>
													<?php endif; ?>
													<?php if ($testimonial['description']) : ?>
														<div class="description"><?php echo wp_kses_post($testimonial['description']); ?></div>
													<?php endif; ?>
													<?php if ($testimonial['name']) : ?>
														<div class="name text8"><?php echo esc_html($testimonial['name']); ?></div>
													<?php endif; ?>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="prev_btn"></div>
							<div class="next_btn"></div>
						</div>
					<?php endif; ?>
				</div>

			<?php elseif (get_row_layout() == 'student_experience_section') : ?>
				<?php
				$section_title = get_sub_field('section_title');
				$section_description = get_sub_field('section_description');
				$experiences = get_sub_field('experiences');
				?>
				<div class="section section_content">
					<div class="section_center_content small_section_center_content scrollin scrollinbottom">
						<?php if ($section_title) : ?>
							<h3 class="section_title text3 text_c3"><?php echo esc_html($section_title); ?></h3>
						<?php endif; ?>
						<?php if ($section_description) : ?>
							<div class="section_description"><?php echo wp_kses_post($section_description); ?></div>
						<?php endif; ?>
					</div>
					<?php if ($experiences) : ?>
						<div class="border_thumb_text_box_slider_wrapper scrollin scrollinbottom">
							<div class="border_thumb_text_box_slider_inwrapper">
								<div class="swiper-container">
									<div class="swiper-wrapper">
										<?php foreach ($experiences as $index => $experience) : ?>
											<div class="swiper-slide">
												<div class="border_thumb_text_box f_btn">
													<div class="text">
														<?php echo wp_kses_post($experience['text']); ?>
														<div class="icon"></div>
													</div>
													<?php if ($experience['image']) : ?>
														<div class="thumb">
															<?php
															$image_id = $experience['image']['ID'];
															$image_src = wp_get_attachment_image_src($image_id, 's');
															$image_url = $image_src ? $image_src[0] : $experience['image']['url'];
															?>
															<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($experience['image']['alt']); ?>">
														</div>
													<?php endif; ?>
												</div>
												<?php if ($experience['gallery']) : ?>
													<div style="display: none;">
														<?php foreach ($experience['gallery'] as $gallery_index => $gallery_image) : ?>
															<a href="<?php echo esc_url($gallery_image['url']); ?>" data-fancybox="gallery<?php echo ($index + 1); ?>" class="fancybox"></a>
														<?php endforeach; ?>
													</div>
												<?php endif; ?>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
							<div class="dot_wrapper scrollin scrollinbottom"></div>
						</div>
					<?php endif; ?>
				</div>
			<?php elseif (get_row_layout() == 'middle_roll_menu_section') : ?>
			<?php get_template_part('template-parts/roll-menu'); ?>	
			<?php elseif (get_row_layout() == 'roll_menu_section') : ?>
				<?php
				// Get top menu from ACF field
				$top_menu_items = get_sub_field('top_menu_repeater');

				// Get sibling pages for roll_bottom_menu
				$current_page = get_the_ID();
				$parent_id = wp_get_post_parent_id($current_page);
				if ($parent_id) {
					$sibling_pages = get_pages(array(
						'parent' => $parent_id,
						'sort_column' => 'menu_order',
						'sort_order' => 'ASC'
					));
				} else {
					// If no parent, get child pages of current page
					$sibling_pages = get_pages(array(
						'parent' => $current_page,
						'sort_column' => 'menu_order',
						'sort_order' => 'ASC'
					));
				}
				?>
				<div class="section roll_menu_section sticky_section">
					<div class="roll_menu scrollin scrollinbottom">
						<?php if ($top_menu_items) : ?>
							<div class="roll_top_menu text7">
								<div class="section_center_content">
									<div class="breadcrumb">
										<?php foreach ($top_menu_items as $index => $item) : ?>
											<?php if ($item['menu_type'] == 'dropdown' && $item['sub_items']) : ?>
												<div class="scrollinbottom_dropdown_wrapper">
													<a href="#" class="scrollinbottom_dropdown">
														<span><?php echo esc_html($item['title']); ?></span>
													</a>
													<div class="hidden">
														<ul>
															<?php foreach ($item['sub_items'] as $sub_item) : ?>
																<?php if ($sub_item['link']) : ?>
																	<li>
																		<a href="<?php echo esc_url($sub_item['link']['url']); ?>" <?php if ($sub_item['link']['target']) echo 'target="' . esc_attr($sub_item['link']['target']) . '"'; ?>>
																			<?php echo esc_html($sub_item['title']); ?>
																		</a>
																	</li>
																<?php endif; ?>
															<?php endforeach; ?>
														</ul>
													</div>
												</div>
											<?php elseif ($item['menu_type'] == 'single' && $item['link']) : ?>
												<a href="<?php echo esc_url($item['link']['url']); ?>" <?php if ($item['link']['target']) echo 'target="' . esc_attr($item['link']['target']) . '"'; ?>>
													<?php echo esc_html($item['title']); ?>
												</a>
											<?php endif; ?>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($sibling_pages) : ?>
							<div class="roll_bottom_menu text7">
								<div class="section_center_content">
									<div class="swiper-container swiper">
										<div class="swiper-wrapper">
											<?php foreach ($sibling_pages as $page) : ?>
												<div class="swiper-slide">
													<div>
														<a href="<?php echo esc_url(get_permalink($page->ID)); ?>" <?php echo ($page->ID == $current_page) ? 'class="active"' : ''; ?>>
															<?php echo esc_html($page->post_title); ?>
														</a>
													</div>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>

			<?php endif; ?>

		<?php endwhile; ?>
	<?php endif; ?>

	<?php
	// Add testimonial popups
	if (have_rows('content_sections')) :
		while (have_rows('content_sections')) : the_row();
			if (get_row_layout() == 'testimonials_section') :
				$testimonials = get_sub_field('testimonials');
				if ($testimonials) :
					foreach ($testimonials as $index => $testimonial) : ?>
						<div class="people_popup scholarship_popup popup" data-id="popup<?php echo ($index + 1); ?>">
							<div class="people_detail_content">
								<div class="people_detail_incontent">
									<?php if ($testimonial['video_url']) : ?>
										<div class="people_detail_photo_wrapper">
											<div class="video_wrapper">
												<iframe class="youtube-video" src="<?php echo esc_url($testimonial['video_url']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
											</div>
										</div>
									<?php elseif ($testimonial['popup_image']) : ?>
										<div class="people_detail_photo_wrapper">
											<div class="photo_wrapper">
												<?php
												$image_id = $testimonial['popup_image']['ID'];
												$image_src = wp_get_attachment_image_src($image_id, 'm');
												$image_url = $image_src ? $image_src[0] : $testimonial['popup_image']['url'];
												?>
												<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($testimonial['popup_image']['alt']); ?>">
											</div>
										</div>
									<?php endif; ?>
									<div class="people_detail_text scrollin scrollinbottom">
										<?php if ($testimonial['category']) : ?>
											<div class="title1 text6"><?php echo esc_html($testimonial['category']); ?></div>
										<?php endif; ?>
										<?php if ($testimonial['title']) : ?>
											<div class="title2 text4"><?php echo esc_html($testimonial['title']); ?></div>
										<?php endif; ?>
										<div class="description">
											<?php if ($testimonial['description']) : ?>
												<div class="t2 free_text"><?php echo wp_kses_post($testimonial['description']); ?></div>
											<?php endif; ?>
											<?php if ($testimonial['name']) : ?>
												<div class="t3 text8"><?php echo esc_html($testimonial['name']); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
							<a class="popup_close_btn"></a>
						</div>
	<?php endforeach;
				endif;
			endif;
		endwhile;
	endif;
	?>

<?php
endwhile;
?>

<?php
get_footer();
