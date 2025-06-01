<?php

/**
 * Template for displaying single course posts
 *
 * @package cuhk_chi
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu', null, array('target_page' => 'study/course-list'));

while (have_posts()) :
	the_post();

	// Get course fields
	$course_code = get_field('course_code');
	$course_title = get_field('course_title');
	$language = get_field('language');
	$lecture_time = get_field('lecture_time');
	$venue = get_field('venue');
	$quota = get_field('quota');
	$course_description = get_field('course_description');
	$syllabus = get_field('syllabus');
	$assessment_assignments = get_field('assessment_assignments');
	$tutorials = get_field('tutorials');
	$references = get_field('references');
	$others = get_field('others');

	// Get lecturer (post object)
	$lecturer = get_field('lecturer');
	$lecturer_name = '';
	$lecturer_email = '';
	$lecturer_phone = '';
	if ($lecturer) {
		$lecturer_name = get_the_title($lecturer->ID);
		// Get lecturer contact info
		$lecturer_emails = get_field('email', $lecturer->ID);
		$lecturer_phones = get_field('phone', $lecturer->ID);
		if ($lecturer_emails && is_array($lecturer_emails)) {
			$lecturer_email = $lecturer_emails[0]['email'] ?? '';
		}
		if ($lecturer_phones && is_array($lecturer_phones)) {
			$lecturer_phone = $lecturer_phones[0]['phone'] ?? '';
		}
	}

	// Get teaching assistant (post object)
	$teaching_assistant = get_field('teaching_assistant');
	$ta_name = '';
	$ta_email = '';
	$ta_phone = '';
	if ($teaching_assistant) {
		$ta_name = get_the_title($teaching_assistant->ID);
		// Get TA contact info
		$ta_emails = get_field('email', $teaching_assistant->ID);
		$ta_phones = get_field('phone', $teaching_assistant->ID);
		if ($ta_emails && is_array($ta_emails)) {
			$ta_email = $ta_emails[0]['email'] ?? '';
		}
		if ($ta_phones && is_array($ta_phones)) {
			$ta_phone = $ta_phones[0]['phone'] ?? '';
		}
	}

	// Get academic year and term from taxonomies
	$academic_years = wp_get_post_terms(get_the_ID(), 'course_year');
	$academic_terms = wp_get_post_terms(get_the_ID(), 'course_semester');
	$academic_year_name = !empty($academic_years) ? $academic_years[0]->name : '';
	$academic_term_name = !empty($academic_terms) ? $academic_terms[0]->name : '';
?>

	<div class="section section_content">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<div class="section_title">
				<div class="text1">
					<?php echo esc_html($course_code); ?>
					<?php if ($course_title) : ?>
						<?php echo esc_html($course_title); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php if ($academic_year_name || $academic_term_name) : ?>
				<div class="section_subtitle">
					<div class="text5">
						<?php
						$subtitle_parts = array();
						if ($academic_year_name) $subtitle_parts[] = $academic_year_name;
						if ($academic_term_name) $subtitle_parts[] = '（' . $academic_term_name . '）';
						echo esc_html(implode('', $subtitle_parts));
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="section section_content section_course_detail">
		<div class="course_detail_info_box_wrapper section_center_content small_section_center_content scrollin scrollinbottom">

			<?php if ($lecturer_name) : ?>
				<div class="course_detail_info_box">
					<div class="text7 t1"><?php pll_e('Teacher'); ?></div>
					<div class="text5 t2">
						<?php echo esc_html($lecturer_name); ?>
						<?php
						$contact_parts = array();
						if ($lecturer_phone) $contact_parts[] = esc_html($lecturer_phone);
						if ($lecturer_email) $contact_parts[] = '<a href="mailto:' . esc_attr($lecturer_email) . '">' . esc_html($lecturer_email) . '</a>';
						if (!empty($contact_parts)) {
							echo ' (' . implode(' / ', $contact_parts) . ')';
						}
						?>
					</div>
					<?php if ($lecturer) : ?>
						<div class="btn_wrapper text7">
							<a href="<?php echo get_permalink($lecturer->ID); ?>" class="round_btn"><?php pll_e('individual profile'); ?></a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ($ta_name) : ?>
				<div class="course_detail_info_box">
					<div class="text7 t1"><?php pll_e('Teaching Assistant'); ?></div>
					<div class="text5 t2">
						<?php echo esc_html($ta_name); ?>
						<?php
						$ta_contact_parts = array();
						if ($ta_phone) $ta_contact_parts[] = esc_html($ta_phone);
						if ($ta_email) $ta_contact_parts[] = '<a href="mailto:' . esc_attr($ta_email) . '">' . esc_html($ta_email) . '</a>';
						if (!empty($ta_contact_parts)) {
							echo ' (' . implode(' / ', $ta_contact_parts) . ')';
						}
						?>
					</div>
					<?php if ($teaching_assistant) : ?>
						<div class="btn_wrapper text7">
							<a href="<?php echo get_permalink($teaching_assistant->ID); ?>" class="round_btn"><?php pll_e('individual profile'); ?></a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ($language) : ?>
				<div class="course_detail_info_box">
					<div class="text7 t1"><?php pll_e('Language'); ?></div>
					<div class="text5 t2"><?php echo esc_html($language); ?></div>
				</div>
			<?php endif; ?>

			<?php if ($lecture_time) : ?>
				<div class="course_detail_info_box">
					<div class="text7 t1"><?php pll_e('Lecture Time'); ?></div>
					<div class="text5 t2"><?php echo esc_html($lecture_time); ?></div>
				</div>
			<?php endif; ?>

			<?php if ($venue) : ?>
				<div class="course_detail_info_box">
					<div class="text7 t1"><?php pll_e('Venue'); ?></div>
					<div class="text5 t2"><?php echo esc_html($venue); ?></div>
				</div>
			<?php endif; ?>

			<?php if ($quota) : ?>
				<div class="course_detail_info_box">
					<div class="text7 t1"><?php pll_e('Quota'); ?></div>
					<div class="text5 t2"><?php echo esc_html($quota); ?></div>
				</div>
			<?php endif; ?>

		</div>

		<div class="section_expandable_list course_detail_expandable_list">

			<?php if ($course_description) : ?>
				<div class="expandable_item scrollin scrollinbottom">
					<div class="section_center_content small_section_center_content">
						<div class="expandable_title text5"><?php pll_e('Course Description'); ?> <div class="icon"></div>
						</div>
						<div class="hidden">
							<div class="hidden_content">
								<div class="free_text">
									<?php echo wp_kses_post($course_description); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($syllabus) : ?>
				<div class="expandable_item scrollin scrollinbottom">
					<div class="section_center_content small_section_center_content">
						<div class="expandable_title text5"><?php pll_e('Syllabus'); ?><div class="icon"></div>
						</div>
						<div class="hidden">
							<div class="hidden_content">
								<div class="free_text">
									<?php echo wp_kses_post($syllabus); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($assessment_assignments) : ?>
				<div class="expandable_item scrollin scrollinbottom">
					<div class="section_center_content small_section_center_content">
						<div class="expandable_title text5"><?php pll_e('Assessment & Assignments'); ?><div class="icon"></div>
						</div>
						<div class="hidden">
							<div class="hidden_content">
								<div class="free_text">
									<?php echo wp_kses_post($assessment_assignments); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($tutorials) : ?>
				<div class="expandable_item scrollin scrollinbottom">
					<div class="section_center_content small_section_center_content">
						<div class="expandable_title text5"><?php pll_e('Tutorials'); ?><div class="icon"></div>
						</div>
						<div class="hidden">
							<div class="hidden_content">
								<div class="free_text">
									<?php echo wp_kses_post($tutorials); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($references) : ?>
				<div class="expandable_item scrollin scrollinbottom">
					<div class="section_center_content small_section_center_content">
						<div class="expandable_title text5"><?php pll_e('References'); ?><div class="icon"></div>
						</div>
						<div class="hidden">
							<div class="hidden_content">
								<div class="free_text">
									<?php echo wp_kses_post($references); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($others) : ?>
				<div class="expandable_item scrollin scrollinbottom">
					<div class="section_center_content small_section_center_content">
						<div class="expandable_title text5"><?php pll_e('Others'); ?><div class="icon"></div>
						</div>
						<div class="hidden">
							<div class="hidden_content">
								<div class="free_text">
									<?php echo wp_kses_post($others); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>

<?php
endwhile;

get_footer();
?>