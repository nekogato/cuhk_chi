<?php

/**
 * Template Name: Student Committee
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu');

if (have_posts()) :
	while (have_posts()) : the_post();
?>

		<div class="section section_content section_intro">
			<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg6.jpg" class="ink_bg6 scrollin scrollinbottom">
			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				<h1 class="section_title text1"><?php the_title(); ?></h1>
				<div class="section_description col6"><?php the_field('introduction'); ?></div>
			</div>
		</div>

		<div class="section section_content section_committee">
			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				<div class="col10 center_content">
					<div class="committee_list free_text">
						<h3 class="section_smalltitle"><?php echo cuhk_multilang_text("學生組織", "", "Student Associations"); ?></h3>
						<?php if (have_rows('organization_list')): ?>
							<ol>
								<?php while (have_rows('organization_list')): the_row(); ?>
									<li><?php the_sub_field('organization_name'); ?></li>
								<?php endwhile; ?>
							</ol>
						<?php endif; ?>
					</div>

					<div class="committee_list_slider">
						<div class="swiper-container swiper">
							<div class="swiper-wrapper">
								<?php if (have_rows('organization_list')): ?>
									<?php while (have_rows('organization_list')): the_row(); ?>
										<div class="swiper-slide">
											<div class="name text5"><?php the_sub_field('organization_name'); ?></div>
											<div class="description">
												<div class="free_text">
													<table>
														<thead>
															<tr>
																<td><?php echo cuhk_multilang_text("職位", "", "Position"); ?></td>
																<td><?php echo cuhk_multilang_text("姓名", "", "Name"); ?></td>
															</tr>
														</thead>
														<tbody>
															<?php if (have_rows('committee_members')): ?>
																<?php while (have_rows('committee_members')): the_row(); ?>
																	<tr>
																		<td><?php the_sub_field('position'); ?></td>
																		<td><?php the_sub_field('name'); ?></td>
																	</tr>
																<?php endwhile; ?>
															<?php endif; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									<?php endwhile; ?>
								<?php endif; ?>
							</div>
						</div>
						<div class="prev_btn"></div>
						<div class="next_btn"></div>
					</div>
				</div>
			</div>
		</div>

		<?php if (have_rows('photo_albums')): ?>
			<div class="section section_content section_committee_album">
				<div class="section_center_content small_section_center_content scrollin scrollinbottom">
					<div class="col10 center_content">
						<h3 class="section_smalltitle"><?php echo cuhk_multilang_text("學生活動", "", "Activities"); ?></h3>
						<div class="committee_albums_slider">
							<div class="swiper-container swiper">
								<div class="swiper-wrapper">
									<?php while (have_rows('photo_albums')): the_row(); ?>
										<div class="swiper-slide">
											<div class="album_title text5"><?php the_sub_field('album_title'); ?></div>
											<div class="committee_album_slider">
												<div class="swiper-container swiper">
													<div class="swiper-wrapper">
														<?php
														$gallery = get_sub_field('album_photos');
														if ($gallery): ?>
															<?php foreach ($gallery as $image): ?>
																<div class="swiper-slide">
																	<a href="<?php echo esc_url($image['url']); ?>"
																		data-fancybox="gallery<?php echo get_row_index(); ?>"
																		data-caption="<?php the_sub_field('album_title'); ?>">
																		<img src="<?php echo esc_url($image['sizes']['929x465']); ?>"
																			alt="<?php echo esc_attr($image['alt']); ?>">
																	</a>
																</div>
															<?php endforeach; ?>
														<?php endif; ?>
													</div>
												</div>
												<div class="dot_wrapper"></div>
											</div>
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
			</div>
		<?php endif; ?>

		<?php
		$facebook_url = get_field('facebook_url');
		$instagram_url = get_field('instagram_url');
		$youtube_url = get_field('youtube_url');
		$linkedin_url = get_field('linkedin_url');

		if ($facebook_url || $instagram_url || $youtube_url || $linkedin_url): ?>
			<div class="section section_content section_committee_sns">
				<div class="section_center_content small_section_center_content scrollin scrollinbottom">
					<div class="col10 center_content">
						<h3 class="section_smalltitle"><?php echo cuhk_multilang_text("社交媒體","","Social Media"); ?></h3>
						<ul>
							<?php if ($facebook_url): ?>
								<li>
									<a href="<?php echo esc_url($facebook_url); ?>"
										class="sns_icon_fb"
										target="_blank"
										rel="noopener noreferrer">
									</a>
								</li>
							<?php endif; ?>

							<?php if ($instagram_url): ?>
								<li>
									<a href="<?php echo esc_url($instagram_url); ?>"
										class="sns_icon_ig"
										target="_blank"
										rel="noopener noreferrer">
									</a>
								</li>
							<?php endif; ?>

							<?php if ($youtube_url): ?>
								<li>
									<a href="<?php echo esc_url($youtube_url); ?>"
										class="sns_icon_yt"
										target="_blank"
										rel="noopener noreferrer">
									</a>
								</li>
							<?php endif; ?>

							<?php if ($linkedin_url): ?>
								<li>
									<a href="<?php echo esc_url($linkedin_url); ?>"
										class="sns_icon_in"
										target="_blank"
										rel="noopener noreferrer">
									</a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		<?php endif; ?>

<?php
	endwhile;
endif;

get_footer(); ?>