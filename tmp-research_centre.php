<?php /* Template Name: Research Centre  */ ?>
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

while (have_posts()) :
	the_post();
?>
	<?php get_template_part('template-parts/roll-menu'); ?>

	<div class="section section_content section_intro">
		<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg6.jpg" class="ink_bg6 scrollin scrollinbottom" alt="Background">

		<div class="section_center_content small_section_center_content">
			<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
			<div class="section_description scrollin scrollinbottom col6"><?php echo get_field('introduction'); ?></div>
		</div>
	</div>

	<div class="section section_content">
		<div class="section_center_content small_section_center_content">
			<div class="research_centre_box_list">
				<?php if (have_rows('research_centres_list')): ?>
					<?php while (have_rows('research_centres_list')): the_row();
						$logo = get_sub_field('logo');
						$name = get_sub_field('name');
						$website = get_sub_field('website');
						$director = get_sub_field('director');
						$email = get_sub_field('email');
						$tel = get_sub_field('tel');
						$description = get_sub_field('description');
					?>
						<div class="research_centre_box scrollin scrollinbottom col_wrapper">
							<div class="row flex">
								<div class="research_centre_logo col col4">
									<div class="col_spacing">
										<div class="thumb">
											<?php if ($logo): ?>
												<img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="research_centre_text col col8">
									<div class="col_spacing">
										<div class="research_centre_text_item_wrapper">
											<?php if ($name): ?>
												<div class="research_centre_text_item">
													<div class="t1 text5"><?php echo ($name); ?></div>
												</div>
												<div class="break"></div>
											<?php endif; ?>
											<?php if ($website): ?>
												<div class="research_centre_text_item">
													<div class="t1"><?php echo cuhk_multilang_text("網站","","Website"); ?></div>
													<div class="t2 text6"><a href="<?php echo($website); ?>" target="_blank"><?php echo($website); ?></a></div>
												</div>
											<?php endif; ?>
											<?php if ($director): ?>
												<div class="research_centre_text_item">
													<div class="t1"><?php echo cuhk_multilang_text("中心主任","","Director"); ?></div>
													<div class="t2 text6"><?php echo ($director); ?></div>
												</div>
											<?php endif; ?>
											<div class="break"></div>
											<?php if ($email): ?>
												<div class="research_centre_text_item">
													<div class="t1"><?php echo cuhk_multilang_text("電郵","","Email"); ?></div>
													<div class="t2 text6"><a href="mailto:<?php echo($email); ?>"><?php echo($email); ?></a></div>
												</div>
											<?php endif; ?>
											<?php if ($tel): ?>
												<div class="research_centre_text_item">
													<div class="t1"><?php echo cuhk_multilang_text("電話","","Tel"); ?></div>
													<div class="t2 text6"><?php echo ($tel); ?></div>
												</div>
											<?php endif; ?>
											<div class="break"></div>
											<?php if ($description): ?>
												<div class="research_centre_text_item col12">
													<div class="t1"><?php echo cuhk_multilang_text("簡介","","Description"); ?></div>
													<div class="t2 text6"><?php echo ($description); ?></div>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>

<?php
endwhile;
get_footer();
