<?php

/**
 * Template Name: Course Index
 * Template for displaying course listings with filtering
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu', null, array('target_page' => 'study'));

// Get filter options from taxonomies
$course_categories = get_terms(array(
	'taxonomy' => 'course_category',
	'hide_empty' => false,
));

$academic_years = get_terms(array(
	'taxonomy' => 'course_year',
	'hide_empty' => false,
	'orderby' => 'name',
	'order' => 'DESC'
));

$course_type = get_terms(array(
	'taxonomy' => 'course_type',
	'hide_empty' => false,
));

if (have_posts()) :
	while (have_posts()) : the_post();
?>

		<div class="ink_bg13_wrapper">
			<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg13.jpg" class="ink_bg13 scrollin scrollinbottom" alt="Background">
		</div>

		<div x-data="courseFilter()">
			<div class="section section_content filter_menu_section">

				<div class="section_center_content small_section_center_content scrollin scrollinbottom">
					<h1 class="section_title text1 scrollin scrollinbottom"><?php the_field("page_title"); ?></h1>
				</div>

				<div class="filter_menu_wrapper">
					<div class="filter_menu filter_menu_left_bg section_center_content small_section_center_content scrollin scrollinbottom">
						<div class="filter_menu_content">
							<div class="filter_checkbox_wrapper text7">
								<template x-for="category in courseCategories" :key="category.slug">
									<div class="filter_checkbox">
										<div class="checkbox">
											<input type="radio"
												:id="category.slug"
												x-model="filters.category"
												:value="category.slug"
												@change="filterCourses()">
											<label :for="category.slug">
												<span x-text="category.displayName"></span>
											</label>
										</div>
									</div>
								</template>
							</div>
						</div>
					</div>
					<div class="filter_menu filter_menu_left_bg filter_menu_bottom section_center_content small_section_center_content scrollin scrollinbottom">
						<div class="filter_menu_content">
							<div class="filter_dropdown_wrapper">
								<a class="filter_dropdown_btn text5" @click="dropdowns.year = !dropdowns.year" x-text="filters.academicYearName"></a>
								<div class="filter_dropdown text5"  @click.away="dropdowns.year = false">
									<ul>
										<template x-for="year in academicYears" :key="year.slug">
											<li>
												<a
													@click="selectFilter('academicYear', year.slug, year.name)"
													:class="filters.academicYear === year.slug ? 'active' : ''"
													x-text="year.name">
												</a>
											</li>
										</template>
									</ul>
								</div>
							</div>
							<div class="filter_dropdown_wrapper" style="display: none;">
								<a class="filter_dropdown_btn text5" @click="dropdowns.type = !dropdowns.type" x-text="filters.courseTypeName || '<?php echo cuhk_multilang_text("所有分類", "", "All Course Type"); ?>'"></a>
								<div class="filter_dropdown text5"  @click.away="dropdowns.type = false">
									<ul>
										<template x-for="type in courseTypes" :key="type.slug">
											<li>
												<a
													@click="selectFilter('courseType', type.slug, type.displayName)"
													:class="filters.courseType === type.slug ? 'active' : ''"
													x-text="type.displayName">
												</a>
											</li>
										</template>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Loading indicator -->
				<div x-show="loading" class="ajax_loading">
				</div>
			</div>

			<!-- Course sections - each course type gets its own section -->
			<template x-for="section in courseSections" :key="section.name">
				<div class="section section_content filter_detail_section scrollin scrollinbottom" x-show="section.courses.length > 0">
					<div class="filter_course_type_name section_center_content  small_section_center_content text3" x-text="section.name"></div>

					<div class="section_center_content small_section_center_content  filter_detail_flex_head mobile_hide2">
						<div class="filter_detail_flex text7">
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("課程編號", "", "Course Code"); ?></div>
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("課程名稱", "", "Course Title"); ?></div>
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("學分", "", "Units"); ?></div>
						</div>
					</div>

					<div class="section_expandable_list   filter_detail_flex_body">
						<template x-for="course in section.courses" :key="course.id">
							<div class="expandable_item "
								:class="expandedCourses.includes(course.id) ? 'active' : ''">
								<div class="section_center_content small_section_center_content">
									<div class="expandable_title filter_detail_flex" :class="course.has_detail || course.course_description  || course.course_pdfs.length > 0 ? '' : 'disable'">
										<div class="filter_detail_flex_item text5 text_c1 filter_detail_flex_item_title">
											<div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("課程編號", "", "Course Code"); ?></div>
											<span x-text="course.course_code"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("課程名稱", "", "Course Title"); ?></div>
											<span x-html="course.course_title"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title" x-show="course.course_unit"><?php echo cuhk_multilang_text("學分", "", "Course Units"); ?></div>
											<span x-text="course.course_unit" x-show="course.course_unit"></span>
										</div>
										<div class="icon" x-show="course.has_detail || course.course_description || course.course_pdfs.length > 0"></div>
									</div>
									<div class="hidden">
										<div class="hidden_content">
											<div class="filter_detail_description_title text7" x-show="course.course_description"><?php echo cuhk_multilang_text("簡介", "", "Description"); ?></div>
											<div class="filter_detail_description free_text" x-show="course.course_description" x-html="course.course_description"></div>

											<div x-show="course.has_detail || course.course_pdfs.length > 0" class="btn_wrapper text7">
												<a :href="course.permalink" class="round_btn" x-show="course.has_detail"><?php echo cuhk_multilang_text("課程內容", "", "Course detail"); ?></a>

												<template x-for="pdf in course.course_pdfs" :key="pdf.url">
													<a :href="pdf.url" class="round_btn" x-show="pdf.url" x-text="pdf.text"></a>
												</template>

											</div>

										</div>
									</div>
								</div>
							</div>
						</template>
					</div>
				</div>
			</template>

			<!-- No courses found message -->
			<div x-show="!loading && courseSections.length === 0"
				class="section section_content" style="text-align: center; padding: 60px 0;">
				<div class="section_center_content small_section_center_content">
					<p class="text5"><?php pll_e(''); ?><?php echo cuhk_multilang_text("未找到符合所選條件的課程。", "", "No courses found matching the selected criteria."); ?></p>
				</div>
			</div>
		</div>

		<script>
			function courseFilter() {
				return {
					courseCategories: [
						<?php if (!empty($course_categories)) : ?>
							<?php foreach ($course_categories as $category) : ?> {
									slug: '<?php echo esc_js($category->slug); ?>',
									name: '<?php echo esc_js($category->name); ?>',
									displayName: '<?php
													if (pll_current_language() == 'tc') {
														$ctermfullname = get_field('tc_name', 'course_category_' . $category->term_id);
													} elseif (pll_current_language() == 'sc') {
														$ctermfullname = get_field('sc_name', 'course_category_' . $category->term_id);
													} else {
														$ctermfullname = get_field('en_name', 'course_category_' . $category->term_id);
													};
													echo esc_js($ctermfullname);
													?>'
								},
							<?php endforeach; ?>
						<?php endif; ?>
					],
					academicYears: [
						<?php if (!empty($academic_years)) : ?>
							<?php foreach ($academic_years as $year) : ?> {
									slug: '<?php echo esc_js($year->slug); ?>',
									name: '<?php echo esc_js($year->name); ?>'
								},
							<?php endforeach; ?>
						<?php endif; ?>
					],
					courseTypes: [{
							slug: '',
							name: '<?php echo cuhk_multilang_text("所有分類", "", "All Course Type"); ?>',
							displayName: '<?php echo cuhk_multilang_text("所有分類", "", "All Course Type"); ?>'
						},
						<?php if (!empty($course_type)) : ?>
							<?php foreach ($course_type as $type) : ?> {
									slug: '<?php echo esc_js($type->slug); ?>',
									name: '<?php echo esc_js($type->name); ?>',
									displayName: '<?php
													if (pll_current_language() == 'tc') {
														$ctermfullname = get_field('tc_name', 'course_type_' . $type->term_id);
													} elseif (pll_current_language() == 'sc') {
														$ctermfullname = get_field('sc_name', 'course_type_' . $type->term_id);
													} else {
														$ctermfullname = get_field('en_name', 'course_type_' . $type->term_id);
													};
													echo esc_js($ctermfullname);
													?>'
								},
							<?php endforeach; ?>
						<?php endif; ?>
					],
					filters: {
						category: '',
						academicYear: '<?php echo !empty($academic_years) ? esc_js($academic_years[0]->slug) : ''; ?>',
						academicYearName: '<?php echo !empty($academic_years) ? esc_js($academic_years[0]->name) : ''; ?>',
						courseType: '',
						courseTypeName: '<?php echo cuhk_multilang_text("所有分類", "", "All Course Type"); ?>'
					},
					dropdowns: {
						year: false,
						type: false
					},
					courseSections: [],
					expandedCourses: [],
					loading: false,

					init() {
						// Set the first category as selected by default
						if (this.courseCategories.length > 0) {
							this.filters.category = [this.courseCategories[0].slug];
						}
						this.loadCourses();
					},

					selectFilter(type, value, name) {
						if (type === 'academicYear') {
							this.filters.academicYear = value;
							this.filters.academicYearName = name;
							this.dropdowns.year = false;
						} else if (type === 'courseType') {
							this.filters.courseType = value;
							this.filters.courseTypeName = name;
							this.dropdowns.type = false;
						}
						this.filterCourses();
					},

					filterCourses() {
						this.loadCourses();
					},

					async loadCourses() {
						try {
							this.loading = true;
							const formData = new FormData();
							formData.append('action', 'load_courses');
							formData.append('nonce', '<?php echo wp_create_nonce("load_courses_nonce"); ?>');

							// Handle categories array
							if (this.filters.category) {
								formData.append('categories[]', this.filters.category);
							}

							if (this.filters.academicYear) {
								formData.append('academic_year', this.filters.academicYear);
							}

							if (this.filters.courseType) {
								formData.append('course_type', this.filters.courseType);
							}

							const response = await fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
								method: 'POST',
								body: formData
							});

							const data = await response.json();

							if (data.success) {
								this.courseSections = data.data.course_sections;
								setTimeout(() => {
									doscroll();
								}, 300);
							} else {
								console.error('Error loading courses:', data);
								this.courseSections = [];
								setTimeout(() => {
									doscroll();
								}, 300);
							}
						} catch (error) {
							console.error('Error loading courses:', error);
							this.courseSections = [];
							setTimeout(() => {
								doscroll();
							}, 300);
						} finally {
							this.loading = false;
							setTimeout(() => {
								doscroll();
							}, 300);
						}
					}


					// toggleCourse(courseId, event) {
					// 	event.preventDefault();

					// 	const expandableItem = event.target.closest('.expandable_item');
					// 	const hidden = expandableItem.querySelector('.hidden');

					// 	if (this.expandedCourses.includes(courseId)) {
					// 		// Remove from expanded courses
					// 		this.expandedCourses = this.expandedCourses.filter(id => id !== courseId);
					// 		expandableItem.classList.remove('active');
					// 		if (hidden) {
					// 			hidden.style.maxHeight = '0px';
					// 			hidden.style.opacity = '0';
					// 		}
					// 	} else {
					// 		// Add to expanded courses
					// 		this.expandedCourses.push(courseId);
					// 		expandableItem.classList.add('active');
					// 		if (hidden) {
					// 			hidden.style.maxHeight = hidden.scrollHeight + 'px';
					// 			hidden.style.opacity = '1';
					// 		}
					// 	}
					// }
				}
			}
		</script>

<?php
	endwhile;
endif;

get_footer();
?>