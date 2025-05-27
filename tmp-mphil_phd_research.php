<?php /* Template Name: MPhil / PhD Research  */ ?>
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

<div class="section section_content section_intro">
	<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg6.jpg" class="ink_bg6 scrollin scrollinbottom" alt="Background Image">

	<div class="section_center_content small_section_center_content">
		<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
		<div class="section_description scrollin scrollinbottom col6"><?php echo get_field("introduction"); ?></div>
	</div>
</div>

<div class="section section_content">
	<div class="section_center_content small_section_center_content">
		<div class="research_thesis_list_wrapper">
			<?php
			$args = array(
				'post_type' => 'mphil_phd_research',
				'posts_per_page' => -1,
				'orderby' => 'date',
				'order' => 'DESC'
			);

			$query = new WP_Query($args);

			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post();
					// Get custom fields
					$student_name = get_field('student_name');
					$degree = get_field('degree');
					$publish_year = get_field('publish_year');
					$programme = get_field('programme_specialties');
					$thesis_title = get_field('thesis_title');
			?>
					<div class="research_thesis_list scrollin scrollinbottom col_wrapper">
						<div class="row flex">
							<div class="col col2">
								<div class="col_spacing">
									<div class="t_wrapper">
										<div class="t">
											<div class="t1 text8"><?php echo pll__('Student Name'); ?></div>
											<div class="t2 text5"><?php echo esc_html($student_name); ?></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col col3">
								<div class="col_spacing">
									<div class="t_wrapper">
										<div class="t">
											<div class="t1 text8"><?php echo pll__('Degree'); ?></div>
											<div class="t2 text6"><?php echo esc_html($degree); ?></div>
										</div>
										<div class="t">
											<div class="t1 text8"><?php echo pll__('Publish Year'); ?></div>
											<div class="t2"><?php echo esc_html($publish_year); ?></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col col7">
								<div class="col_spacing">
									<div class="t_wrapper">
										<div class="t">
											<div class="t1 text8"><?php echo pll__('Programme/ Specialties'); ?></div>
											<div class="t2"><?php echo esc_html($programme); ?></div>
										</div>
										<div class="t">
											<div class="t1 text8"><?php echo pll__('Thesis Title'); ?></div>
											<div class="t2"><?php echo esc_html($thesis_title); ?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>

			<div class="load_more_wrapper scrollin scrollinbottom">
				<a class="load_more_btn text5">
					<div class="icon"></div>
					<div class="text"><?php echo pll__('Load more'); ?></div>
				</a>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
