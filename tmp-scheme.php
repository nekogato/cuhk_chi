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
?>

	<div class="section section_content section_scheme">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">

			<?php if ($section_title) : ?>
				<div class="section_scheme_title text3"><?php echo esc_html($section_title); ?></div>
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
				<div class="scheme_unit_box_wrapper">
					<div class="scheme_unit_box_inwrapper">
						<?php
						$total_programme_units = 0;
						$group_index = 0;
						while (have_rows('course_groups')) : the_row();
							$group_index++;
							$group_title = get_sub_field('group_title');
							$group_style = get_sub_field('group_style');
							$courses = get_sub_field('courses');

							// Calculate total units for this group
							$group_total_units = 0;
							if ($courses) {
								foreach ($courses as $course) {
									$group_total_units += intval($course['course_units']);
								}
							}
							$total_programme_units += $group_total_units;
						?>
							<div class="scheme_unit_box <?php echo esc_attr($group_style); ?>">
								<div class="scheme_unit_box_left">
									<div class="t1 text4"><?php echo esc_html($group_index); ?></div>
									<div class="t2 text5"><?php echo esc_html($group_title); ?></div>
								</div>
								<div class="scheme_unit_box_right">
									<div class="t1 text2"><?php echo esc_html($group_total_units); ?></div>
									<div class="t2">Units</div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>

					<?php
					$manual_total_units = get_field('total_units');
					$display_total = $manual_total_units ? $manual_total_units : $total_programme_units;
					if ($display_total) : ?>
						<div class="scheme_unit_box_total">
							<div class="scheme_unit_box_left">
								<div class="t2">Total Units</div>
							</div>
							<div class="scheme_unit_box_right">
								<div class="t1 text1"><?php echo esc_html($display_total); ?></div>
								<div class="t2">Units</div>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<div class="scheme_unit_expandable_box_wrapper">
					<?php
					$group_index = 0;
					while (have_rows('course_groups')) : the_row();
						$group_index++;
						$group_title = get_sub_field('group_title');
						$group_style = get_sub_field('group_style');
						$courses = get_sub_field('courses');

						// Calculate total units for this group
						$group_total_units = 0;
						if ($courses) {
							foreach ($courses as $course) {
								$group_total_units += intval($course['course_units']);
							}
						}
					?>
						<div class="scheme_unit_expandable_box">
							<div class="title <?php echo esc_attr($group_style); ?>">
								<div class="left_title text5"><?php echo esc_html($group_index); ?>. <?php echo esc_html($group_title); ?></div>
								<div class="right_title">
									<div class="num text2"><?php echo esc_html($group_total_units); ?></div>
									<div class="unit text5">Unit<?php echo ($group_total_units != 1) ? 's' : ''; ?></div>
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
															<a href="<?php echo esc_url($course['course_link']); ?>"><?php echo esc_html($course['course_code']); ?></a>
														<?php else : ?>
															<?php echo esc_html($course['course_code']); ?>
														<?php endif; ?>
													</td>
													<td><?php echo esc_html($course['course_title']); ?></td>
													<td><?php echo esc_html($course['course_units']); ?> UNITS</td>
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
			if (get_the_content()) : ?>
				<div class="scheme_remark free_text">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>

<?php
endwhile;
?>

<?php
get_footer();
