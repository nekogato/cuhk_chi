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
											<h1 class="project_title text_c2"><span><?php echo esc_html($hero_banner['main_title']); ?></span></h1>
											<h4 class="project_smalltitle text_c2"><span><?php echo esc_html($hero_banner['subtitle']); ?></span></h4>
										</div>
										<div class="description free_text">
											<?php echo apply_filters('the_content', $hero_banner['description']); ?>
										</div>
										<?php if ($hero_banner['buttons']) : ?>
											<div class="border_btn_wrapper">
												<?php if ($hero_banner['buttons_title']) : ?>
													<div class="btn_title"><?php echo esc_html($hero_banner['buttons_title']); ?></div>
												<?php endif; ?>
												<?php foreach ($hero_banner['buttons'] as $button) : ?>
													<?php if ($button['button_link']) : ?>
														<a class="btn" href="<?php echo esc_url($button['button_link']['url']); ?>" <?php if ($button['button_link']['target']) echo 'target="' . esc_attr($button['button_link']['target']) . '"'; ?>>
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
											$image_src = wp_get_attachment_image_src($image_id, '929x465');
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
				<div class="section plain_text_section <?php echo ($background_style == 'border') ? 'border_layout_section' : ''; ?>">
					<?php if ($background_style == 'ink') : ?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg3.jpg" class="ink_bg3 scrollin scrollinbottom" alt="">
					<?php elseif ($background_style == 'border') : ?>
						<div class="brush_bg"></div>
					<?php endif; ?>
					<div class="section_center_content small_section_center_content">
						<div class="flexible_layout_wrapper">
							<?php if ($layouts) : ?>
								<?php foreach ($layouts as $layout) : ?>
									<div class="flexible_layout flexible_layout_<?php echo esc_attr($layout['layout_type']); ?> scrollin scrollinbottom">
										<?php if ($layout['section_title']) : ?>
											<h5 class="text_c3"><?php echo esc_html($layout['section_title']); ?></h5>
										<?php endif; ?>
										<div class="col_wrapper">
											<div class="flex row">
												<?php if ($layout['layout_type'] == 'one_column') : ?>
													<div class="col8 col">
														<div class="col_spacing">
															<div class="free_text">
																<?php echo apply_filters('the_content', $layout['content']); ?>
															</div>
														</div>
													</div>
												<?php elseif ($layout['layout_type'] == 'two_column') : ?>
													<div class="col6 col">
														<div class="col_spacing">
															<div class="free_text">
																<?php echo apply_filters('the_content', $layout['left_content']); ?>
															</div>
														</div>
													</div>
													<div class="col6 col">
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
									<?php foreach ($testimonials as $testimonial) : ?>
										<div class="swiper-slide">
											<?php if ($testimonial['photo']) : ?>
												<div class="thumb">
													<img src="<?php echo esc_url($testimonial['photo']['url']); ?>" alt="<?php echo esc_attr($testimonial['photo']['alt']); ?>">
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
										<?php foreach ($experiences as $experience) : ?>
											<div class="swiper-slide">
												<div class="border_thumb_text_box">
													<div class="text">
														<?php echo wp_kses_post($experience['text']); ?>
														<div class="icon"></div>
													</div>
													<?php if ($experience['image']) : ?>
														<div class="thumb">
															<?php
															$image_id = $experience['image']['ID'];
															$image_src = wp_get_attachment_image_src($image_id, '287x155');
															$image_url = $image_src ? $image_src[0] : $experience['image']['url'];
															?>
															<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($experience['image']['alt']); ?>">
														</div>
													<?php endif; ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
							<div class="dot_wrapper scrollin scrollinbottom"></div>
						</div>
					<?php endif; ?>
				</div>

			<?php elseif (get_row_layout() == 'roll_menu_section') : ?>
				<?php
				// Get sibling pages for roll_top_menu
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

				// Get sub menu from ACF field
				$sub_menu_items = get_sub_field('sub_menu_repeater');
				?>
				<div class="section roll_menu_section sticky_section">
					<div class="roll_menu scrollin scrollinbottom">
						<div class="roll_top_menu text7">
							<div class="section_center_content">
								<div class="swiper-container swiper">
									<div class="swiper-wrapper">
										<?php if ($sibling_pages) : ?>
											<?php foreach ($sibling_pages as $page) : ?>
												<div class="swiper-slide">
													<div>
														<a href="<?php echo esc_url(get_permalink($page->ID)); ?>" <?php echo ($page->ID == $current_page) ? 'class="active"' : ''; ?>>
															<?php echo esc_html($page->post_title); ?>
														</a>
													</div>
												</div>
											<?php endforeach; ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<?php if ($sub_menu_items) : ?>
							<div class="roll_bottom_menu text7">
								<div class="section_center_content">
									<div class="swiper-container swiper">
										<div class="swiper-wrapper">
											<?php foreach ($sub_menu_items as $index => $item) : ?>
												<?php if ($item['link']) : ?>
													<div class="swiper-slide">
														<div>
															<a href="<?php echo esc_url($item['link']['url']); ?>" <?php echo ($index == 0) ? 'class="active"' : ''; ?> <?php if ($item['link']['target']) echo 'target="' . esc_attr($item['link']['target']) . '"'; ?>>
																<?php echo esc_html($item['title']); ?>
															</a>
														</div>
													</div>
												<?php endif; ?>
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
endwhile;
?>

<?php
get_footer();
