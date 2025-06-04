<?php

/**
 * Template for displaying single department news posts
 *
 * @package cuhk_chi
 */

get_header(); ?>

<?php get_template_part('template-parts/roll-menu', null, array('target_page' => 'news-and-events/department-in-the-news')); ?>

<?php while (have_posts()) : the_post(); ?>

	<div class="section top_photo_banner_section top_photo_banner_section_absolute">
		<div class="section_center_content small_section_center_content">
			<div class="col_wrapper xl_col_wrapper">
				<div class="flex row">
					<div class="col2 col">
						<div class="col_spacing scrollin scrollinbottom">
							<div class="text_wrapper vertical_text_wrapper">
								<div class="text vertical_text">
									<?php
									// Get category from taxonomy
									$categories = wp_get_post_terms(get_the_ID(), 'department-category');
									$category_name = !empty($categories) ? $categories[0]->name : '';
									?>
									<?php if ($category_name) : ?>
										<h4 class="project_smalltitle"><span><?php echo esc_html($category_name); ?></span></h4>
									<?php endif; ?>
									<h1 class="project_title"><span><?php the_title(); ?></span></h1>
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
					<div class="col col5">
						<div class="col_spacing">
							<div class="left_content free_text">
								<div class="flexible_layout_wrapper">
									<div class="flexible_layout flexible_layout_photo scrollin scrollinleft">
										<div class="photo_wrapper">
											<div class="photo">
												<?php if (has_post_thumbnail()) : ?>
													<?php the_post_thumbnail('department-news-featured'); ?>
												<?php endif; ?>
											</div>
											<?php if (has_post_thumbnail()) :
												$thumbnail_id = get_post_thumbnail_id();
												$attachment = get_post($thumbnail_id);

												// Get caption from WordPress CMS fields
												$caption = '';

												// Try Caption field (post_excerpt)
												if ($attachment && !empty($attachment->post_excerpt)) {
													$caption = $attachment->post_excerpt;
												}

												// Try Description field (post_content) if caption is empty
												if (empty($caption) && $attachment && !empty($attachment->post_content)) {
													$caption = $attachment->post_content;
												}

												if (!empty($caption)) :
											?>
													<div class="caption"><?php echo esc_html($caption); ?></div>
											<?php endif;
											endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col col5">
						<div class="col_spacing">
							<div class="right_content">
								<div class="flexible_layout_wrapper">
									<div class="news_date scrollin scrollinbottom">
										<?php echo pll__('發報日期') . '：' . format_chinese_date(get_post_time('U')); ?>
									</div>
									<div class="flexible_layout flexible_layout_freetext scrollin scrollinbottom">
										<div class="free_text">
											<?php the_content(); ?>
										</div>
									</div>
									<?php
									// Check if there's a gallery or additional images
									$gallery_images = get_field('gallery_images');
									if ($gallery_images && is_array($gallery_images) && count($gallery_images) > 1) :
									?>
										<div class="flexible_layout flexible_layout_slider scrollin scrollinbottom">
											<div class="swiper-container swiper">
												<div class="swiper-wrapper">
													<?php foreach ($gallery_images as $image) : ?>
														<div class="swiper-slide">
															<a href="<?php echo esc_url($image['url']); ?>" data-fancybox="gallery" data-caption="<?php echo esc_attr($image['caption']); ?>" class="photo">
																<img src="<?php echo esc_url($image['sizes']['department-news-featured']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
															</a>
															<?php if ($image['caption']) : ?>
																<div class="caption"><?php echo esc_html($image['caption']); ?></div>
															<?php endif; ?>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
											<div class="prev_btn"></div>
											<div class="next_btn"></div>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>