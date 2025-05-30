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
	$project_category = get_the_terms(get_the_ID(), 'project_category');
	$project_title = get_field('project_title');
	$funding_start_year = get_field('funding_start_year');
	$funding_end_year = get_field('funding_end_year');
	$principal_investigator = get_field('principal_investigator');
	$other_investigator = get_field('other_investigator');
	$granted_amount = get_field('granted_amount');
	$funding_organization = get_field('funding_organization');
	$banner_image = get_field('banner_image');
	$banner_caption = get_field('banner_caption');
?>

	<div class="section top_photo_banner_section banner_bg">
		<div class="section_center_content small_section_center_content">
			<div class="col_wrapper">
				<div class="flex row">
					<div class="col4 col">
						<div class="col_spacing scrollin scrollinbottom">
							<div class="text_wrapper vertical_text_wrapper">
								<div class="text vertical_text">
									<?php if ($project_category) : ?>
										<h4 class="project_smalltitle">
											<span><?php echo esc_html($project_category[0]->name); ?></span>
										</h4>
									<?php endif; ?>
									<?php if ($project_title) : ?>
										<h1 class="project_title">
											<span><?php echo esc_html($project_title); ?></span>
										</h1>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col8 col">
						<div class="col_spacing scrollin scrollinleft">
							<div class="photo_wrapper">
								<?php if ($banner_image) : ?>
									<div class="photo">
										<img src="<?php echo esc_url($banner_image['url']); ?>" alt="<?php echo esc_attr($banner_image['alt']); ?>">
									</div>
								<?php endif; ?>
								<?php if ($banner_caption) : ?>
									<div class="caption"><?php echo esc_html($banner_caption); ?></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section section_left_right_content scrollin_p">
		<div class="section_center_content small_section_center_content">
			<div class="col_wrapper">
				<div class="flex row">
					<div class="col col4">
						<div class="col_spacing scrollin scrollinbottom">
							<div class="left_content free_text">
								<?php if ($funding_start_year || $funding_end_year) : ?>
									<h5><?php pll_e('撥款年份'); ?></h5>
									<p>
										<?php
										if ($funding_start_year && $funding_end_year) {
											echo esc_html($funding_start_year . ' - ' . $funding_end_year);
										} elseif ($funding_start_year) {
											echo esc_html($funding_start_year);
										} elseif ($funding_end_year) {
											echo esc_html($funding_end_year);
										}
										?>
									</p>
								<?php endif; ?>

								<?php if ($principal_investigator) : ?>
									<h5><?php pll_e('計劃主持'); ?></h5>
									<p><?php echo esc_html($principal_investigator); ?></p>
								<?php endif; ?>

								<?php if ($other_investigator) : ?>
									<h5><?php pll_e('其他研究員'); ?></h5>
									<p><?php echo esc_html($other_investigator); ?></p>
								<?php endif; ?>

								<?php if ($granted_amount) : ?>
									<h5><?php pll_e('撥款金額'); ?></h5>
									<p><?php echo esc_html($granted_amount); ?></p>
								<?php endif; ?>

								<?php if ($funding_organization) : ?>
									<h5><?php pll_e('撥款機構'); ?></h5>
									<p><?php echo esc_html($funding_organization); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="col col8">
						<div class="col_spacing">
							<div class="right_content">
								<div class="flexible_layout_wrapper">
									<?php
									if (have_rows('flexible_content')) :
										while (have_rows('flexible_content')) : the_row();
											if (get_row_layout() == 'free_text') :
												$freetext = get_sub_field('free_text');
												if ($freetext) :
									?>
													<div class="flexible_layout flexible_layout_freetext scrollin scrollinbottom">
														<div class="free_text">
															<?php echo wp_kses_post($freetext); ?>
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
													static $i = 0;
													$i++;
												?>
													<div class="flexible_layout flexible_layout_slider scrollin scrollinbottom">
														<div class="swiper-container swiper">
															<div class="swiper-wrapper">
																<?php
																while (have_rows('image_list')) : the_row();
																	$image = get_sub_field('image');
																	$caption = get_sub_field('caption');
																	if ($image) :
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
																	endif;
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
get_footer();
