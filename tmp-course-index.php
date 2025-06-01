<?php

/**
 * Template Name: Course Index
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu', null, array('target_page' => 'study'));

// Get filter options from taxonomies
$programmes = get_terms(array(
	'taxonomy' => 'course_type',
	'hide_empty' => false,
));

$academic_years = get_terms(array(
	'taxonomy' => 'course_year',
	'hide_empty' => false,
));

$academic_terms = get_terms(array(
	'taxonomy' => 'course_semester',
	'hide_empty' => false,
));

if (have_posts()) :
	while (have_posts()) : the_post();
?>

		<div class="ink_bg13_wrapper">
			<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg13.jpg" class="ink_bg13 scrollin scrollinbottom" alt="Background">
		</div>

		<div class="section section_content filter_menu_section"
			x-data="courseFilter()">

			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
			</div>

			<div class="filter_menu_wrapper">
				<div class="filter_menu filter_menu_left_bg section_center_content small_section_center_content scrollin scrollinbottom">
					<div class="filter_menu_content">
						<div class="filter_checkbox_wrapper text7">
							<?php if (!empty($programmes)): ?>
								<?php foreach ($programmes as $programme): ?>
									<div class="filter_checkbox">
										<div class="checkbox">
											<input type="checkbox"
												id="<?php echo esc_attr($programme->slug); ?>"
												x-model="filters.programmes"
												value="<?php echo esc_attr($programme->slug); ?>"
												@change="filterCourses()">
											<label for="<?php echo esc_attr($programme->slug); ?>">
												<span><?php echo esc_html($programme->name); ?></span>
											</label>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="filter_menu filter_menu_left_bg filter_menu_bottom section_center_content small_section_center_content scrollin scrollinbottom">
					<div class="filter_menu_content">
						<div class="filter_dropdown_wrapper">
							<a class="filter_dropdown_btn text5" href="#" @click="dropdowns.year = !dropdowns.year"
								x-text="'Academic Years (' + filters.academicYear + ')'"></a>
							<div class="filter_dropdown text5" x-show="dropdowns.year" @click.away="dropdowns.year = false">
								<ul>
									<?php if (!empty($academic_years)): ?>
										<?php foreach ($academic_years as $year): ?>
											<li>
												<a href="#"
													@click="selectFilter('academicYear', '<?php echo esc_js($year->slug); ?>')"
													:class="filters.academicYear === '<?php echo esc_js($year->slug); ?>' ? 'active' : ''">
													<?php echo esc_html($year->name); ?>
												</a>
											</li>
										<?php endforeach; ?>
									<?php endif; ?>
								</ul>
							</div>
						</div>
						<div class="filter_dropdown_wrapper">
							<a class="filter_dropdown_btn text5" href="#" @click="dropdowns.term = !dropdowns.term"
								x-text="'Academic Terms (' + filters.academicTerm + ')'"></a>
							<div class="filter_dropdown text5" x-show="dropdowns.term" @click.away="dropdowns.term = false">
								<ul>
									<?php if (!empty($academic_terms)): ?>
										<?php foreach ($academic_terms as $term): ?>
											<li>
												<a href="#"
													@click="selectFilter('academicTerm', '<?php echo esc_js($term->slug); ?>')"
													:class="filters.academicTerm === '<?php echo esc_js($term->slug); ?>' ? 'active' : ''">
													<?php echo esc_html($term->name); ?>
												</a>
											</li>
										<?php endforeach; ?>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Loading indicator -->
			<div x-show="loading" class="loading-wrapper" style="text-align: center; padding: 40px;">
				<div class="loading">
					<img src="<?php echo get_template_directory_uri(); ?>/images/oval.svg" alt="Loading">
				</div>
			</div>

			<!-- Course sections -->
			<template x-for="section in courseSections" :key="section.name">
				<div class="section section_content filter_detail_section scrollin_p" x-show="section.courses.length > 0">
					<div class="filter_course_type_name section_center_content scrollin scrollinbottom small_section_center_content text3" x-text="section.name"></div>

					<div class="section_center_content small_section_center_content filter_detail_flex_head mobile_hide2">
						<div class="filter_detail_flex text7 scrollin scrollinbottom">
							<div class="filter_detail_flex_item"><?php pll_e('Course Code'); ?></div>
							<div class="filter_detail_flex_item"><?php pll_e('Course Title'); ?></div>
							<div class="filter_detail_flex_item"><?php pll_e('Lecturer'); ?></div>
							<div class="filter_detail_flex_item"><?php pll_e('Language'); ?></div>
							<div class="filter_detail_flex_item"><?php pll_e('Lecture Time'); ?></div>
							<div class="filter_detail_flex_item"><?php pll_e('Venue'); ?></div>
							<div class="filter_detail_flex_item"><?php pll_e('Quota'); ?></div>
						</div>
					</div>

					<div class="section_expandable_list scrollin_p filter_detail_flex_body">
						<template x-for="course in section.courses" :key="course.id">
							<div class="expandable_item scrollin scrollinbottom">
								<div class="section_center_content small_section_center_content">
									<div class="expandable_title filter_detail_flex">
										<div class="filter_detail_flex_item text5 text_c1 filter_detail_flex_item_title">
											<div class="text8 mobile_show2 mobile_title"><?php pll_e('Course Code'); ?></div>
											<span x-text="course.course_code"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php pll_e('Course Title'); ?></div>
											<span x-text="course.course_title"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php pll_e('Lecturer'); ?></div>
											<span x-text="course.lecturer_name"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php pll_e('Language'); ?></div>
											<span x-text="course.language"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php pll_e('Lecture Time'); ?></div>
											<span x-text="course.lecture_time"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php pll_e('Venue'); ?></div>
											<span x-text="course.venue"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php pll_e('Quota'); ?></div>
											<span x-text="course.quota"></span>
										</div>
										<div class="icon"></div>
									</div>
									<div class="hidden">
										<div class="hidden_content">
											<div class="filter_detail_description_title text7"><?php pll_e('Description'); ?></div>
											<div class="filter_detail_description free_text" x-html="course.course_description"></div>
											<div x-show="course.teaching_assistant_name" class="filter_detail_description_title text7" style="margin-top: 20px;"><?php pll_e('Teaching Assistant'); ?></div>
											<div x-show="course.teaching_assistant_name" class="filter_detail_description" x-text="course.teaching_assistant_name"></div>
										</div>
									</div>
								</div>
							</div>
						</template>
					</div>
				</div>
			</template>

			<!-- No results message -->
			<div x-show="!loading && courseSections.length === 0"
				class="section section_content" style="text-align: center; padding: 60px 0;">
				<div class="section_center_content small_section_center_content">
					<p class="text5"><?php pll_e('No courses found matching the selected criteria.'); ?></p>
				</div>
			</div>
		</div>

		<script>
			function courseFilter() {
				return {
					loading: false,
					courseSections: [],
					filters: {
						programmes: [],
						academicYear: '<?php echo !empty($academic_years) ? esc_js($academic_years[0]->slug) : ''; ?>',
						academicTerm: '<?php echo !empty($academic_terms) ? esc_js($academic_terms[0]->slug) : ''; ?>'
					},
					dropdowns: {
						year: false,
						term: false
					},

					init() {
						// Set default programme filter
						<?php if (!empty($programmes)): ?>
							this.filters.programmes = ['<?php echo esc_js($programmes[0]->slug); ?>'];
						<?php endif; ?>
						this.loadCourses();
					},

					selectFilter(type, value) {
						this.filters[type] = value;
						this.dropdowns.year = false;
						this.dropdowns.term = false;
						this.filterCourses();
					},

					filterCourses() {
						this.loadCourses();
					},

					async loadCourses() {
						this.loading = true;

						try {
							const requestData = {
								action: 'load_courses',
								nonce: '<?php echo wp_create_nonce("load_courses_nonce"); ?>',
								programmes: this.filters.programmes,
								academic_year: this.filters.academicYear,
								academic_term: this.filters.academicTerm
							};

							const response = await fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
								method: 'POST',
								headers: {
									'Content-Type': 'application/json',
									'Accept': 'application/json'
								},
								body: JSON.stringify(requestData)
							});

							const data = await response.json();

							if (data.success) {
								this.courseSections = data.data.course_sections;
							} else {
								console.error('Error loading courses:', data.data);
								this.courseSections = [];
							}
						} catch (error) {
							console.error('Error loading courses:', error);
							this.courseSections = [];
						} finally {
							this.loading = false;
						}
					}
				}
			}
		</script>

<?php
	endwhile;
endif;

get_footer();
?>