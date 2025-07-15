<?php /* Template Name: About Department */ ?>
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

<div class="section top_photo_banner_section top_photo_banner_section_absolute">
	<div class="section_center_content small_section_center_content">
		<div class="col_wrapper xl_col_wrapper">
			<div class="flex row">
				<div class="col3 col">
					<div class="col_spacing scrollin scrollinbottom">
						<div class="text_wrapper vertical_text_wrapper">
							<div class="text vertical_text">
								<?php if (get_field("small_headline")): ?>
									<h4 class="project_smalltitle"><span><?php the_field("small_headline"); ?></span></h4>
								<?php endif; ?>
								<?php if (get_field("headline")): ?>
									<h1 class="project_title"><span><?php the_field("headline"); ?></span></h1>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="section section_left_right_content section_left_right_content2 scrollin_p">
	<div class="ink_bg11_wrapper">
		<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg11.jpg" class="ink_bg11 scrollin scrollinbottom">
	</div>

	<div class="section_center_content small_section_center_content">
		<div class="col_wrapper xl_col_wrapper">
			<div class="flex row">
				<div class="col col5">
					<div class="col_spacing">
						<div class="left_content free_text">
							<div class="flexible_layout_wrapper">
								<?php
								$department_image = get_field("department_image");
								if ($department_image): ?>
									<div class="flexible_layout flexible_layout_photo scrollin scrollinleft">
										<div class="photo_wrapper">
											<div class="photo">
												<img src="<?php echo esc_url($department_image['sizes']['l']); ?>">
											</div>
											<?php if (get_field("department_image_caption")): ?>
												<div class="caption"><?php the_field("department_image_caption"); ?></div>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col col5">
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
												<div class="photo">
													<img src="<?php echo esc_url($image['sizes']['l']); ?>">
												</div>
												<?php if ($caption): ?>
													<div class="caption"><?php echo $caption; ?></div>
												<?php endif; ?>
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

<?php
get_footer();
