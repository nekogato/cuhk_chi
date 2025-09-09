<?php

/**
 * Template for displaying single research project
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu', null, array('target_page' => 'research-and-publication/research-projects')); ?>

<?php
while (have_posts()) :
	the_post();
	$funding_start_year = get_field('funding_start_year');
	$funding_end_year = get_field('funding_end_year');
	$principal_investigator = get_field('principal_investigator');
	$other_investigator = get_field('other_investigator');
	$granted_amount = get_field('granted_amount');
	$funding_organization = get_field('funding_organization');
?>



	<div class="section top_photo_banner_section top_photo_banner_section_absolute">
		<div class="section_center_content small_section_center_content">
			<div class="col10 center_content">
				<div class="col_wrapper xl_col_wrapper">
					<div class="flex row">
						<div class="col2 col">
							<div class="col_spacing scrollin scrollinbottom">
								<div class="text_wrapper vertical_text_wrapper">
									<div class="text vertical_text">

										<div class="news_title_wrapper mobile_show2">
											<?php $project_category = get_the_terms(get_the_ID(), 'project_category');
											if ($project_category) {
												if ($project_category && ! is_wp_error($project_category)) {
											?>

												<div class="news_cat text5">
													<?php
														$termid = $project_category[0]->term_id;
														$termslug = $project_category[0]->slug;
														$termlink = get_term_link($project_category[0]);
														if (is_wp_error($termlink)) {
															continue;
														}
														if (pll_current_language() == 'tc') {
															$termname = get_field('tc_name', 'project_category_' . $termid);
														} elseif (pll_current_language() == 'sc') {
															$termname = get_field('sc_name', 'project_category_' . $termid);
														} else {
															$termname = get_field('en_name', 'project_category_' . $termid);
														};
													?>
													<span><?php echo $termname; ?></span>
												</div>
											<?php
												};
											};
											?>

											<h1 class="news_title text4"><?php the_field("project_title"); ?></h1>
											
										</div>

									</div>
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
			<div class="col10 center_content">
				<div class="col_wrapper xl_col_wrapper">
					<div class="flex row">
						<?php
						$event_banner = get_field('banner_image');
						$event_banner_caption = get_field('banner_caption');
						if ($event_banner) :
						?>
							<div class="col col5">
								<div class="col_spacing">
									<div class="left_content free_text">
										<div class="flexible_layout_wrapper">
											<div class="flexible_layout flexible_layout_photo scrollin scrollinleft">
												<div class="photo_wrapper">
													<div class="photo">
														<a href="<?php echo esc_url($event_banner['sizes']['l']); ?>" data-fancybox>
														<img src="<?php echo esc_url($event_banner['sizes']['l']); ?>" alt="<?php echo esc_attr($event_banner['alt']); ?>">
														</a>
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

						<div class="col <?php if($event_banner){echo "col5"; }else{ echo "col7"; }; ?>">
							<div class="col_spacing">
								<div class="right_content news_right_content">
									<div class="flexible_layout_wrapper">

										<div class="news_title_wrapper mobile_hide2 scrollin scrollinbottom">
											<?php $project_category = get_the_terms(get_the_ID(), 'project_category');
											if ($project_category) {
												if ($project_category && ! is_wp_error($project_category)) {
											?>

												<div class="news_cat text5">
													<?php
														$termid = $project_category[0]->term_id;
														$termslug = $project_category[0]->slug;
														$termlink = get_term_link($project_category[0]);
														if (is_wp_error($termlink)) {
															continue;
														}
														if (pll_current_language() == 'tc') {
															$termname = get_field('tc_name', 'project_category_' . $termid);
														} elseif (pll_current_language() == 'sc') {
															$termname = get_field('sc_name', 'project_category_' . $termid);
														} else {
															$termname = get_field('en_name', 'project_category_' . $termid);
														};
													?>
													<span><?php echo $termname; ?></span>
												</div>
											<?php
												};
											};
											?>

											<h1 class="news_title text4"><?php the_field("project_title"); ?></h1>

										</div>

										<div class="info_item_wrapper scrollin scrollinbottom">
											<?php if ($funding_start_year || $funding_end_year) : ?>
												<div class="info_item">
													<div class="t1 "><?php echo cuhk_multilang_text("撥款年份", "", "Funding Year"); ?></div>
													<div class="t2 text6">
														<?php
														if ($funding_start_year && $funding_end_year) {
															echo esc_html($funding_start_year . ' - ' . $funding_end_year);
														} elseif ($funding_start_year) {
															echo esc_html($funding_start_year);
														} elseif ($funding_end_year) {
															echo esc_html($funding_end_year);
														}
														?>
													</div>
												</div>
											<?php endif; ?>

											<?php if ($principal_investigator) : ?>
												<div class="info_item">
													<div class="t1 "><?php echo cuhk_multilang_text("計劃主持", "", "Principal Investigator"); ?></div>
													<div class="t2 text6"><?php echo esc_html($principal_investigator); ?></div>
												</div>
											<?php endif; ?>

											<?php if ($other_investigator) : ?>
												<div class="info_item">
													<div class="t1 "><?php echo cuhk_multilang_text("其他研究成員", "", "Other Investigator"); ?></div>
													<div class="t2 text6"><?php echo esc_html($other_investigator); ?></div>
												</div>
											<?php endif; ?>

											<?php if ($granted_amount) : ?>
												<div class="info_item">
													<div class="t1 "><?php echo cuhk_multilang_text("撥款金額", "", "Granted Amount"); ?></div>
													<div class="t2 text6"><?php echo esc_html($granted_amount); ?></div>
												</div>
											<?php endif; ?>

											<?php if ($funding_organization) : ?>
												<div class="info_item">
													<div class="t1 "><?php echo cuhk_multilang_text("撥款機構", "", "Funding Organization"); ?></div>
													<div class="t2 text6"><?php echo esc_html($funding_organization); ?></div>
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
														<div class="flexible_layout flexible_layout_photo scrollin scrollinbottom">
															<div class="photo_wrapper">
																<div class="photo">
																	<a href="<?php echo esc_url($image['sizes']['l']); ?>" data-fancybox data-caption="<?php echo $caption; ?>">
																	<img src="<?php echo esc_url($image['sizes']['l']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
																	</a>
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
	</div>

<?php
endwhile;
get_footer();
