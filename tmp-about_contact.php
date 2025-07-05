<?php /* Template Name: About Contact */ ?>
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

<div class="section section_contact scrollin_p">
	<div class="contact_banner">
		<div class="section_center_content small_section_center_content">
			<?php
			$contact_banner = get_field("contact_banner");
			if ($contact_banner): ?>
				<div class="photo scrollin scrollinopacity"><img src="<?php echo esc_url($contact_banner['sizes']['l']); ?>"></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="contact_intro">
		<div class="section_center_content small_section_center_content">
			<?php if (get_field("contact_title")): ?>
				<h1 class="section_title text1 scrollin scrollinbottom"><?php the_field("contact_title"); ?></h1>
			<?php endif; ?>
			<?php if (get_field("contact_description")): ?>
				<div class="section_description scrollin scrollinbottom col6"><?php the_field("contact_description"); ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="contact_bottom">
		<div class="section_center_content small_section_center_content">
			<div class="col_wrapper">
				<div class="flex row">
					<div class="col col7">
						<div class="col_spacing">
							<div class="contact_map_wrapper">
								<div class="map"
									data-lng="<?php echo get_field('map_longitude'); ?>"
									data-lat="<?php echo get_field('map_latitude'); ?>"
									data-zoom="<?php echo get_field('map_zoom'); ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="col col5">
						<div class="col_spacing">
							<div class="flexible_layout_wrapper">
								<?php if (get_field("free_text")): ?>
									<div class="flexible_layout flexible_layout_freetext scrollin scrollinbottom">
										<div class="free_text">
											<?php the_field("free_text"); ?>
										</div>
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

<?php
get_footer();
