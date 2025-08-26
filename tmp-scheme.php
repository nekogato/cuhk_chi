<?php /* Template Name: Curriculum Scheme */ ?>
<?php
/**
 * The template for displaying curriculum scheme pages
 * Shows programme requirements with unit boxes and expandable course details
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu'); ?>

<?php
while (have_posts()) :
	the_post();
	$section_title = get_field("section_title");
	$programme_name = get_field("programme_name");
	$scheme_description = get_field("scheme_description");
	$show_required_units = get_field("show_required_units");
?>

	<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg7.jpg" class="ink_bg6 scrollin scrollinbottom">
	<div class="section section_content section_scheme">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">

			<?php if ($section_title) : ?>
				<h1 class="section_title text1 scrollin scrollinbottom"><?php echo wp_kses_post($section_title); ?></h1>
			<?php endif; ?>

			<?php if ($programme_name) : ?>
				<div class="section_scheme_prog_name text5 col8"><?php echo wp_kses_post($programme_name); ?></div>
			<?php endif; ?>

			<?php if ($scheme_description) : ?>
				<div class="section_scheme_description free_text text6 col8">
					<?php echo apply_filters('the_content', $scheme_description); ?>
				</div>
			<?php endif; ?>

			<?php if (have_rows('course_groups')) : ?>
				<?php if($show_required_units): ?>
				<div class="scheme_unit_box_wrapper">
					<div class="scheme_unit_box_inwrapper">
						<?php
						$total_programme_units = 0;
						$group_index = 0;
						while (have_rows('course_groups')) : the_row();
							$group_index++;
							$group_title = get_sub_field('group_title');
							$group_style = get_sub_field('group_style');
							$group_required_unit = get_sub_field('group_required_unit');
							$courses = get_sub_field('courses');

							// Calculate total units for this group
							$total_programme_units += intval($group_required_unit);
						?>
							<div class="scheme_unit_box <?php echo esc_attr($group_style); ?>">
								<div class="scheme_unit_box_left">
									<!-- <div class="t1 text4"><?php echo wp_kses_post($group_index); ?></div> -->
									<div class="t2 text5"><?php echo wp_kses_post($group_title); ?></div>
								</div>
								<div class="scheme_unit_box_right">
									<div class="t1 text2"><?php echo wp_kses_post($group_required_unit); ?></div>
									<div class="t2"><?php echo cuhk_multilang_text("學分","",($group_required_unit != 1) ? 'Units' : 'Unit'); ?></div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>

					<?php
					if ($total_programme_units) : ?>
						<div class="scheme_unit_box_total">
							<div class="scheme_unit_box_left">
								<div class="t2"><?php echo cuhk_multilang_text("總學分","",'Total Units'); ?></div>
							</div>
							<div class="scheme_unit_box_right">
								<div class="t1 text1"><?php echo wp_kses_post($total_programme_units); ?></div>
								<div class="t2"><?php echo cuhk_multilang_text("學分","",($total_programme_units != 1) ? 'Units' : 'Unit'); ?></div>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<div class="scheme_unit_expandable_box_wrapper">
					<?php
					$group_index = 0;
					while (have_rows('course_groups')) : the_row();
						$group_index++;
						$group_title = get_sub_field('group_title');
						$group_style = get_sub_field('group_style');
						$group_required_unit = get_sub_field('group_required_unit');
						$courses = get_sub_field('courses');

					?>
						<div class="scheme_unit_expandable_box">
							<div class="title <?php echo esc_attr($group_style); ?>">
								<div class="left_title text5">
									<!-- <?php echo wp_kses_post($group_index); ?>.  -->
									<?php echo wp_kses_post($group_title); ?>
								</div>
								<div class="right_title">
									<?php if($show_required_units):?>
										<div class="num text2"><?php echo wp_kses_post($group_required_unit); ?></div>
										<div class="unit text5"><?php echo cuhk_multilang_text("學分","",($group_required_unit != 1) ? 'Units' : 'Unit'); ?></div>
									<?php endif; ?>
									<div class="icon_wrapper"><a href="#" class="icon"></a></div>
								</div>
							</div>
							<div class="hidden">
								<div class="hidden_content">
									<?php if ($courses) : ?>
										<table>
											<?php foreach ($courses as $course) : ?>
												<tr>
													<td>
														<?php if ($course['course_link']) : ?>
															<a href="<?php echo esc_url($course['course_link']); ?>"><?php echo wp_kses_post($course['course_code']); ?></a>
														<?php else : ?>
															<?php echo wp_kses_post($course['course_code']); ?>
														<?php endif; ?>
													</td>
													<td>
														<?php echo wp_kses_post($course['course_title']); ?>
														<?php if ($course['course_short_description']) : ?>
														<div class="course_short_description"><?php echo wp_kses_post($course['course_short_description']); ?></div>
														<?php endif; ?>
													</td>
													<td><?php echo wp_kses_post($course['course_units']); ?> <?php echo cuhk_multilang_text("學分","",($course['course_units'] != 1) ? 'Units' : 'Unit'); ?></td>
												</tr>
											<?php endforeach; ?>
										</table>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>

			<?php
			if (get_field("remarks")) : ?>
				<div class="scheme_remark free_text">
					<?php the_field("remarks"); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>

<?php
endwhile;
?>

<?php
get_footer();
