<?php

/**
 * @package cuhk_chi
 */

get_header();

while (have_posts()) :
	the_post();
?>
<?php get_template_part('template-parts/roll-menu', null, array('target_page' => 'news-and-events/news')); ?>

	<div class="section top_photo_banner_section top_photo_banner_section_absolute">
		<div class="section_center_content small_section_center_content">
			<div class="col_wrapper xl_col_wrapper">
				<div class="flex row">
					<div class="col2 col">
						<div class="col_spacing scrollin scrollinbottom">
							<div class="text_wrapper vertical_text_wrapper">
								<div class="text vertical_text">
									<!-- <?php $news_category = get_the_terms(get_the_ID(), 'news_category');
									if ($news_category) {
										if ($news_category && ! is_wp_error($news_category)) {
									?>
											<h4 class="project_smalltitle ">
												<?php
												foreach ($news_category as $term) {
													$termid = $term->term_id;
													$termslug = $term->slug;
													$termlink = get_term_link($term);
													if (is_wp_error($termlink)) {
														continue;
													}
													if (pll_current_language() == 'tc') {
														$termname = get_field('tc_name', 'news_category_' . $termid);
													} elseif (pll_current_language() == 'sc') {
														$termname = get_field('sc_name', 'news_category_' . $termid);
													} else {
														$termname = get_field('en_name', 'news_category_' . $termid);
													};
												?>
													<span><?php echo $termname; ?></span>
												<?php
												};
												?>
											</h4>
									<?php
										};
									};
									?> -->

									<!-- <h1 class="project_title"><span><?php echo cuhk_multilang_text("學系消息", "", " News"); ?></span></h1> -->
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
					$news_banner = get_field("news_banner");
					$news_banner_caption = get_field("news_banner_caption");
					if (get_field("news_banner")) {
					?>

						<div class="col col5">
							<div class="col_spacing ">
								<div class="left_content free_text">
									<div class="flexible_layout_wrapper ">
										<div class="flexible_layout flexible_layout_photo scrollin scrollinleft">
											<div class="photo_wrapper">
												<div class="photo">
													<img src="<?php echo esc_url($news_banner["sizes"]["l"]); ?>" alt="<?php echo esc_attr($news_banner['alt']); ?>">
												</div>
												<?php if ($news_banner_caption) { ?>
													<div class="caption"><?php echo $news_banner_caption; ?></div>
												<?php }; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					<?php
					}; ?>
					<div class="col col5">
						<div class="col_spacing">
							<div class="right_content news_right_content">
								<div class="flexible_layout_wrapper ">
									<div class="news_title_wrapper">
									<?php $news_category = get_the_terms(get_the_ID(), 'news_category');
									if ($news_category) {
										if ($news_category && ! is_wp_error($news_category)) {
									?>

										<div class="news_cat text5">
											<?php
											foreach ($news_category as $term) {
												$termid = $term->term_id;
												$termslug = $term->slug;
												$termlink = get_term_link($term);
												if (is_wp_error($termlink)) {
													continue;
												}
												if (pll_current_language() == 'tc') {
													$termname = get_field('tc_name', 'news_category_' . $termid);
												} elseif (pll_current_language() == 'sc') {
													$termname = get_field('sc_name', 'news_category_' . $termid);
												} else {
													$termname = get_field('en_name', 'news_category_' . $termid);
												};
											?>
												<span><?php echo $termname; ?></span>
											<?php
											};
											?>
										</div>
									<?php
										};
									};
									?>

									<h1 class="news_title "><?php the_field("news_name"); ?></h1>
									</div>

									<?php if (get_field('start_date')) { ?>
										<div class="news_date scrollin scrollinbottom">
											<?php
											$start_date_raw = get_field('start_date'); // This is in Ymd format, e.g. 20250622
											if ($start_date_raw) {
												$date_obj = DateTime::createFromFormat('Ymd', $start_date_raw);
												echo $date_obj->format('j/n/Y'); // Outputs e.g., 22/6
											}
											?>
										</div>
									<?php }; ?>
									<?php
									if (have_rows('flexible_content')):
										$i = 0;
										while (have_rows('flexible_content')) : the_row();
											if (get_row_layout() == 'free_text'):
												$freetext = get_sub_field("free_text");
												if ($freetext) {
									?>
													<div class="flexible_layout flexible_layout_freetext scrollin scrollinbottom">
														<div class="free_text">
															<?php echo $freetext; ?>
														</div>
													</div>
												<?php
												};
											elseif (get_row_layout() == 'single_image'):
												$image = get_sub_field('image');
												$caption = get_sub_field('caption');
												if ($image) {
												?>
													<div class="flexible_layout flexible_layout_photo scrollin scrollinleft">
														<div class="photo_wrapper">
															<div class="photo">
																<img src="<?php echo esc_url($image['sizes']['l']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
															</div>
															<?php if ($caption) { ?>
																<div class="caption"><?php echo $caption; ?></div>
															<?php }; ?>
														</div>
													</div>
												<?php
												};
											elseif (get_row_layout() == 'video_upload'):
												$video = get_sub_field('video_upload');
												if ($video) {
												?>
													<div class="flexible_layout flexible_layout_video scrollin scrollinbottom">
														<div class="upload_video_wrapper">
															<video controls playsinline>
																<source src="<?php echo esc_url($video["url"]); ?>" type="video/mp4">
																Your browser does not support HTML5 video.
															</video>
														</div>
													</div>
												<?php
												};
											elseif (get_row_layout() == 'slider'):
												if (have_rows('image_list')):
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
																		<a href="<?php echo esc_url($image['sizes']['l']); ?>" class="photo" data-fancybox="gallery<?php echo $i; ?>" <?php if ($caption) { ?>data-caption="<?php echo esc_attr($caption); ?>" <?php }; ?>>
																			<img src="<?php echo esc_url($image['sizes']['l']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
																		</a>
																		<?php if ($caption) { ?>
																			<div class="caption"><?php echo $caption; ?></div>
																		<?php }; ?>
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
endwhile; // End of the loop.
?>


<?php
get_footer();
