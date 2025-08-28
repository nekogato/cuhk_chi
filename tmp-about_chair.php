<?php /* Template Name: About Chair */ ?>
<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu'); ?>

<div class="ink_bg10_1_wrapper">
	<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg10_1.jpg" class="ink_bg10_1 scrollin scrollinbottom">
</div>
<div class="ink_bg10_2_wrapper">
	<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg10_2.jpg" class="ink_bg10_2 scrollin scrollinbottom">
</div>
<div class="section top_photo_banner_section banner_bg2">
	<div class="section_center_content small_section_center_content">
		<div class="col_wrapper">
			<div class="flex row">
				<div class="col3 col">
					<div class="col_spacing scrollin scrollinbottom">
						<div class="text_wrapper vertical_text_wrapper absolute_vertical_text_wrapper">
							<div class="text vertical_text">
								<?php if (get_field("small_headline")): ?>
									<h4 class="project_smalltitle"><span><?php the_field("small_headline"); ?></span></h4>
								<?php endif; ?>
								<?php if (get_field("headline")): ?>
									<h1 class="project_title no_max_height"><span><?php the_field("headline"); ?></span></h1>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col8 col">
					<div class="col_spacing scrollin scrollinleft">
						<div class="chair_photo_wrapper">
							<?php
							$chair_image = get_field("chair_image");
							if ($chair_image): ?>
								<div class="photo_wrapper col10">
									<div class="photo">
										<img src="<?php echo esc_url($chair_image['sizes']['l']); ?>">
									</div>
									<?php if (get_field("chair_image_caption")): ?>
										<div class="caption"><?php the_field("chair_image_caption"); ?></div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<div class="chair_name">
								<?php if (get_field("chair_name")): ?>
									<div class="t1 text5"><?php the_field("chair_name"); ?></div>
								<?php endif; ?>
								<?php if (get_field("chair_title")): ?>
									<div class="t2"><?php the_field("chair_title"); ?></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="section section_left_right_content scrollin_p">
	<div class="section_center_content small_section_center_content">
		<div class="col10 center_content">
			<div class="col_wrapper">
				<div class="flex row">
					<div class="col7 col">
						<div class="col_spacing scrollin scrollinbottom">
							<?php if (get_field("left_free_text")): ?>
								<div class="free_text">
									<?php the_field("left_free_text"); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="col_wrapper">
				<div class="flex row">
					<div class="col col5"></div>
					<div class="col col7">
						<div class="col_spacing">
							<div class="right_content">
								<?php
								if (have_rows('flexible_content')):
									while (have_rows('flexible_content')): the_row();
										if (get_row_layout() == 'free_text'):
											$freetext = get_sub_field("free_text");
											if ($freetext):
								?>
												<div class="flexible_layout flexible_layout_freetext scrollin scrollinbottom">
													<div class="free_text">
														<?php echo $freetext; ?>
													</div>
												</div>
											<?php
											endif;
										elseif (get_row_layout() == 'single_image'):
											$image = get_sub_field('image');
											$caption = get_sub_field('caption');
											if ($image):
											?>
												<div class="flexible_layout flexible_layout_photo scrollin scrollinbottom">
													<div class="photo_wrapper">
														<div class="photo">
															<img src="<?php echo esc_url($image['sizes']['l']); ?>">
														</div>
														<?php if ($caption): ?>
															<div class="caption"><?php echo $caption; ?></div>
														<?php endif; ?>
													</div>
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
get_footer();
