<?php

/**
 * Template Name: Alumni
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu'); ?>

<div class="section section_content section_intro">
	<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg6.jpg" class="ink_bg6 scrollin scrollinbottom">
	<div class="section_center_content small_section_center_content">
		<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
		<?php if (get_field('introduction')): ?>
			<div class="section_description scrollin scrollinbottom col6"><?php the_field('introduction'); ?></div>
		<?php endif; ?>
	</div>
</div>

<!-- Alumni Connection Buttons Section -->
<?php if (have_rows('alumni_connection_links')): ?>
	<div class="section section_content section_alumni_btn scrollin_p">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<?php if (get_field('connection_section_title')): ?>
				<h3 class="section_smalltitle"><?php the_field('connection_section_title'); ?></h3>
			<?php endif; ?>
			<ul>
				<?php while (have_rows('alumni_connection_links')): the_row();
					$link = get_sub_field('link');
					if ($link): ?>
						<li><a href="<?php echo esc_url($link['url']); ?>" class="round_btn" <?php echo $link['target'] ? ' target="' . esc_attr($link['target']) . '"' : ''; ?>><?php echo esc_html($link['title']); ?></a></li>
					<?php endif; ?>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>

<!-- Alumni Activities Section -->
<?php
$alumni_events = get_field('alumni_events');
if ($alumni_events): ?>
	<div class="section featured_news_box_section alumni_news_box_section scrollin_p">
		<div class="news_box_wrapper">
			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				<?php if (get_field('activities_section_title')): ?>
					<h3 class="section_smalltitle"><?php the_field('activities_section_title'); ?></h3>
				<?php endif; ?>
				<div class="col_wrapper big_col_wrapper">
					<div class="flex row">
						<?php foreach ($alumni_events as $event): ?>
							<div class="news_box col col6">
								<div class="col_spacing scrollin scrollinbottom">
									<?php
									$event_image = get_the_post_thumbnail_url($event->ID, 'l');
									if ($event_image): ?>
										<div class="photo">
											<img src="<?php echo esc_url($event_image); ?>" alt="<?php echo esc_attr($event->post_title); ?>">
										</div>
									<?php endif; ?>
									<div class="text_wrapper">
										<?php
										$start_date = get_field('start_date', $event->ID);
										$end_date = get_field('end_date', $event->ID);
										$start_time = get_field('start_time', $event->ID);
										$end_time = get_field('end_time', $event->ID);

										if ($start_date): ?>
											<div class="date_wrapper">
												<?php
												$start_datetime = new DateTime($start_date);
												echo $start_datetime->format('j/n/Y');
												if ($start_time || $end_time): ?>
													<br><?php echo $start_time; ?><?php echo $end_time ? '-' . $end_time : ''; ?>
												<?php endif; ?>
											</div>
										<?php endif; ?>
										<div class="title_wrapper">
											<div class="title text5"><?php echo esc_html($event->post_title); ?></div>
											<?php if ($event->post_excerpt): ?>
												<div class="description"><?php echo esc_html($event->post_excerpt); ?></div>
											<?php endif; ?>
											<div class="btn_wrapper text7">
												<a href="<?php echo get_permalink($event->ID); ?>" class="round_btn"><?php echo cuhk_multilang_text("了解更多", "", "Details"); ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<!-- Alumni Success Stories Section -->
<?php if (have_rows('alumni_success_stories')): ?>
	<div class="section section_content alumni_story_section scrollin_p">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<?php if (get_field('success_stories_title')): ?>
				<h3 class="section_smalltitle"><?php the_field('success_stories_title'); ?></h3>
			<?php endif; ?>
		</div>
		<div class="thumb_text_box_slider_wrapper scrollin scrollinbottom">
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<?php while (have_rows('alumni_success_stories')): the_row();
						$story_photo = get_sub_field('photo');
						$story_name = get_sub_field('name');
						$story_credentials = get_sub_field('credentials');
						$story_description = get_sub_field('description');
						$story_author = get_sub_field('author');
						$story_content = get_sub_field('full_story');
					?>
						<div class="swiper-slide popup_btn" data-target="story-<?php echo get_row_index(); ?>">
							<?php if ($story_photo): ?>
								<div class="thumb">
									<img src="<?php echo esc_url($story_photo['sizes']['medium_large']); ?>" alt="<?php echo esc_attr($story_name); ?>">
								</div>
							<?php endif; ?>
							<div class="text">
								<div class="text_spacing">
									<div class="title text5"><?php echo esc_html($story_name); ?></div>
									<?php if ($story_credentials): ?>
										<div class="sub_title text6"><?php echo ($story_credentials); ?></div>
									<?php endif; ?>
									<?php if ($story_description): ?>
										<div class="description"><?php echo esc_html($story_description); ?></div>
									<?php endif; ?>
									<?php if ($story_author): ?>
										<div class="name author text8"><?php echo esc_html($story_author); ?></div>
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

<!-- Alumni Associations Section -->
<?php if (have_rows('alumni_associations')): ?>
	<div class="section section_content border_box_list_section scrollin_p">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<?php if (get_field('associations_section_title')): ?>
				<h3 class="section_smalltitle"><?php the_field('associations_section_title'); ?></h3>
			<?php endif; ?>

			<div class="border_box_item_wrapper">
				<div class="border_box_item_inwrapper">
					<div class="swiper-container">
						<div class="border_box_item_row swiper-wrapper">
							<?php while (have_rows('alumni_associations')): the_row();
								$association_name = get_sub_field('name');
								$association_image = get_sub_field('image');
								$association_description = get_sub_field('description');
								$association_link = get_sub_field('link');
							?>
								<div class="border_box_item swiper-slide">
									<div class="t1 text4"><?php echo esc_html($association_name); ?></div>
									<?php if ($association_image): ?>
										<div class="photo">
											<img src="<?php echo esc_url($association_image['sizes']['medium']); ?>" alt="<?php echo esc_attr($association_name); ?>">
										</div>
									<?php endif; ?>
									<?php if ($association_description): ?>
										<div class="t2"><?php echo esc_html($association_description); ?></div>
									<?php endif; ?>
									<?php if ($association_link): ?>
										<div class="btn_wrapper">
											<a href="<?php echo esc_url($association_link['url']); ?>" class="round_btn text8" <?php echo $association_link['target'] ? ' target="' . esc_attr($association_link['target']) . '"' : ''; ?>><?php echo cuhk_multilang_text("了解更多", "", "Details"); ?></a>
										</div>
									<?php endif; ?>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
				<div class="dot_wrapper"></div>
			</div>
		</div>
	</div>
<?php endif; ?>

<!-- Alumni Photo Albums Section -->
<?php if (have_rows('alumni_photo_albums')): ?>
	<div class="section section_content section_committee_album scrollin_p">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<?php if (get_field('photo_albums_title')): ?>
				<h3 class="section_smalltitle"><?php the_field('photo_albums_title'); ?></h3>
			<?php endif; ?>
			<div class="committee_albums_slider">
				<div class="swiper-container swiper">
					<div class="swiper-wrapper">
						<?php while (have_rows('alumni_photo_albums')): the_row();
							$album_title = get_sub_field('album_title');
							$album_photos = get_sub_field('photos');
							$gallery_id = 'gallery' . get_row_index();
						?>
							<div class="swiper-slide">
								<div class="album_title text5"><?php echo esc_html($album_title); ?></div>
								<?php if ($album_photos): ?>
									<div class="committee_album_slider">
										<div class="swiper-container swiper">
											<div class="swiper-wrapper">
												<?php foreach ($album_photos as $photo): ?>
													<div class="swiper-slide">
														<a href="<?php echo esc_url($photo['sizes']['large']); ?>" data-fancybox="<?php echo esc_attr($gallery_id); ?>" data-caption="<?php echo esc_attr($album_title); ?>">
															<img src="<?php echo esc_url($photo['sizes']['medium']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>">
														</a>
													</div>
												<?php endforeach; ?>
												<div class="swiper-slide"></div>
											</div>
										</div>
										<div class="dot_wrapper"></div>
									</div>
								<?php endif; ?>
							</div>
						<?php endwhile; ?>
						<div class="swiper-slide"></div>
					</div>
				</div>
				<div class="prev_btn"></div>
				<div class="next_btn"></div>
			</div>
		</div>
	</div>
<?php endif; ?>

<!-- Alumni Success Stories Popups -->
<?php if (have_rows('alumni_success_stories')): ?>
	<?php while (have_rows('alumni_success_stories')): the_row();
		$story_photo = get_sub_field('photo');
		$story_name = get_sub_field('name');
		$story_credentials = get_sub_field('credentials');
		$story_content = get_sub_field('full_story');
		$story_author = get_sub_field('author');
		$popup_id = 'story-' . get_row_index();
	?>
		<div class="people_popup popup" data-id="<?php echo esc_attr($popup_id); ?>">
			<div class="people_detail_content">
				<div class="people_detail_incontent">
					<?php if ($story_photo): ?>
						<div class="people_detail_photo_wrapper">
							<div class="people_detail_photo">
								<img src="<?php echo esc_url($story_photo['sizes']['large']); ?>" alt="<?php echo esc_attr($story_name); ?>">
							</div>
						</div>
					<?php endif; ?>
					<div class="people_detail_text scrollin scrollinbottom">
						<div class="title1">
							<div class="text4"><?php echo esc_html($story_name); ?></div>
							<?php if ($story_credentials): ?>
								<div class="text6"><?php echo ($story_credentials); ?></div>
							<?php endif; ?>
						</div>
						<?php if ($story_content): ?>
							<div class="description">
								<div class="t2 free_text"><?php echo wp_kses_post($story_content); ?></div>
								<?php if ($story_author): ?>
									<div class="author t3 text6"><?php echo esc_html($story_author); ?></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<a class="popup_close_btn"></a>
		</div>
	<?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
