<?php

/**
 * The template for displaying single event posts
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu', null, array('target_page' => 'news-and-events/events')); ?>

<?php
while (have_posts()) :
	the_post();
?>

	<div class="section top_photo_banner_section top_photo_banner_section_absolute">
		<div class="section_center_content small_section_center_content">
			<div class="col_wrapper xl_col_wrapper">
				<div class="flex row">
					<div class="col2 col">
						<div class="col_spacing scrollin scrollinbottom">
							<div class="text_wrapper vertical_text_wrapper">
								<div class="text vertical_text">
									<?php
									$event_category = get_the_terms(get_the_ID(), 'event_category');
									if ($event_category && !is_wp_error($event_category)) :
										foreach ($event_category as $term) :
											$term_id = $term->term_id;
											if (pll_current_language() == 'tc') {
												$term_name = get_field('tc_name', 'event_category_' . $term_id);
											} elseif (pll_current_language() == 'sc') {
												$term_name = get_field('sc_name', 'event_category_' . $term_id);
											} else {
												$term_name = get_field('en_name', 'event_category_' . $term_id);
											}
									?>
											<h4 class="project_smalltitle"><span><?php echo esc_html($term_name); ?></span></h4>
									<?php
										endforeach;
									endif;
									?>
									<h1 class="project_title"><span><?php echo esc_html(get_field('event_name')); ?></span></h1>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section section_left_right_content section_left_right_content2 scrollin_p">
		<div class="section_center_content small_section_center_content">
			<div class="col_wrapper xl_col_wrapper">
				<div class="flex row">
					<?php
					$event_banner = get_field('event_banner');
					$event_banner_caption = get_field('event_banner_caption');
					if ($event_banner) :
					?>
						<div class="col col5">
							<div class="col_spacing">
								<div class="left_content free_text">
									<div class="flexible_layout_wrapper">
										<div class="flexible_layout flexible_layout_photo scrollin scrollinleft">
											<div class="photo_wrapper">
												<div class="photo">
													<img src="<?php echo esc_url($event_banner['sizes']['l']); ?>" alt="<?php echo esc_attr($event_banner['alt']); ?>">
												</div>
												<?php if ($event_banner_caption) : ?>
													<div class="caption"><?php echo esc_html($event_banner_caption); ?></div>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<div class="col col5">
						<div class="col_spacing">
							<div class="right_content">
								<div class="flexible_layout_wrapper">
									<div class="info_item_wrapper scrollin scrollinbottom">
										<?php if (get_field('start_date')) : ?>
											<div class="info_item">
												<div class="t1 text5"><?php echo cuhk_multilang_text("日期","","Date"); ?></div>
												<div class="t2 text6">
													<?php
													$start_date = get_field('start_date');
													$end_date = get_field('end_date');
													$start_date_obj = DateTime::createFromFormat('Y-m-d', $start_date);
													$end_date_obj = DateTime::createFromFormat('Y-m-d', $end_date);

													if ($start_date && $end_date && $start_date !== $end_date) {
														echo esc_html($start_date_obj->format('j/n/Y') . '－' . $end_date_obj->format('j/n/Y'));
													} else {
														echo esc_html($start_date_obj->format('j/n/Y'));
													}
													?>
												</div>
											</div>
										<?php endif; ?>

										<?php if (get_field('event_time')) : ?>
											<div class="info_item">
												<div class="t1 text5"><?php echo cuhk_multilang_text("時間","","Time"); ?></div>
												<div class="t2 text6"><?php echo esc_html(get_field('event_time')); ?></div>
											</div>
										<?php endif; ?>

										<?php if (get_field('event_venue')) : ?>
											<div class="info_item big_info_item">
												<div class="t1 text5"><?php echo cuhk_multilang_text("地點","","Venue"); ?></div>
												<div class="t2 text6"><?php echo esc_html(get_field('event_venue')); ?></div>
											</div>
										<?php endif; ?>
									</div>

									<?php
									if (have_rows('flexible_content')) :
										$i = 0;
										while (have_rows('flexible_content')) : the_row();
											if (get_row_layout() == 'free_text') :
												$free_text = get_sub_field('free_text');
												if ($free_text) :
									?>
													<div class="flexible_layout flexible_layout_freetext scrollin scrollinbottom">
														<div class="free_text">
															<?php echo wp_kses_post($free_text); ?>
														</div>
													</div>
												<?php
												endif;
											elseif (get_row_layout() == 'single_image') :
												$image = get_sub_field('image');
												$caption = get_sub_field('caption');
												if ($image) :
												?>
													<div class="flexible_layout flexible_layout_photo scrollin scrollinleft">
														<div class="photo_wrapper">
															<div class="photo">
																<img src="<?php echo esc_url($image['sizes']['l']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
															</div>
															<?php if ($caption) : ?>
																<div class="caption"><?php echo esc_html($caption); ?></div>
															<?php endif; ?>
														</div>
													</div>
												<?php
												endif;
											elseif (get_row_layout() == 'video_upload') :
												$video = get_sub_field('video_upload');
												if ($video) :
												?>
													<div class="flexible_layout flexible_layout_video scrollin scrollinbottom">
														<div class="upload_video_wrapper">
															<video controls playsinline>
																<source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
																<?php pll_e('Your browser does not support HTML5 video.'); ?>
															</video>
														</div>
													</div>
												<?php
												endif;
											elseif (get_row_layout() == 'slider') :
												if (have_rows('image_list')) :
													$i++;
												?>
													<div class="flexible_layout flexible_layout_slider scrollin scrollinbottom">
														<div class="swiper-container swiper">
															<div class="swiper-wrapper">
																<?php
																while (have_rows('image_list')) : the_row();
																	$image = get_sub_field('image');
																	$caption = get_sub_field('caption');
																?>
																	<div class="swiper-slide">
																		<a href="<?php echo esc_url($image['sizes']['l']); ?>" class="photo" data-fancybox="gallery<?php echo $i; ?>" <?php if ($caption) : ?>data-caption="<?php echo esc_attr($caption); ?>" <?php endif; ?>>
																			<img src="<?php echo esc_url($image['sizes']['l']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
																		</a>
																		<?php if ($caption) : ?>
																			<div class="caption"><?php echo esc_html($caption); ?></div>
																		<?php endif; ?>
																	</div>
																<?php
																endwhile;
																?>
															</div>
														</div>
														<div class="prev_btn"></div>
														<div class="next_btn"></div>
													</div>
									<?php
												endif;
											endif;
										endwhile;
									endif;
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
endwhile;
?>

<?php
get_footer();
