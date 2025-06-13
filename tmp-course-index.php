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
								<?php if (!empty($course_categories)) : ?>
									<?php foreach ($course_categories as $category) : ?>
										<div class="filter_checkbox">
											<div class="checkbox">
												<input type="checkbox"
													id="<?php echo esc_attr($category->slug); ?>"
													x-model="filters.categories"
													value="<?php echo esc_attr($category->slug); ?>"
													@change="filterCourses()">
												<label for="<?php echo esc_attr($category->slug); ?>">
													<span>
													<?php 
														if(pll_current_language() == 'tc') {
															$ctermfullname = get_field('tc_name', 'course_category_' .$category->term_id);
														}elseif(pll_current_language() == 'sc'){
															$ctermfullname = get_field('sc_name', 'course_category_' .$category->term_id);
														}else{
															$ctermfullname = get_field('en_name', 'course_category_' .$category->term_id);
														};
														echo ($ctermfullname); 
													?></span>
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
								<a class="filter_dropdown_btn text5"  @click="dropdowns.year = !dropdowns.year" x-text="filters.academicYearName"></a>
								<div class="filter_dropdown text5" x-show="dropdowns.year" @click.away="dropdowns.year = false">
									<ul>
										<?php if (!empty($academic_years)) : ?>
											<?php foreach ($academic_years as $year) : ?>
												<li>
													<a 
														@click="selectFilter('academicYear', '<?php echo esc_js($year->slug); ?>', '<?php echo esc_js($year->name); ?>')"
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
								<a class="filter_dropdown_btn text5"  @click="dropdowns.type = !dropdowns.type" x-text="filters.courseTypeName || '<?php echo cuhk_multilang_text("所有分類","","All Course Type"); ?>'"></a>
								<div class="filter_dropdown text5" x-show="dropdowns.type" @click.away="dropdowns.type = false">
									<ul>
										<?php if (!empty($course_type)) : ?>
											<li>
												<a 
													@click="selectFilter('courseType', '', '<?php echo cuhk_multilang_text("所有分類","","All Course Type"); ?>')"
													:class="filters.courseType === '' ? 'active' : ''">
													<?php echo cuhk_multilang_text("所有分類","","All Course Type"); ?>
												</a>
											</li>
											<?php foreach ($course_type as $type) : ?>
												<li>
													<a 
														@click="selectFilter('courseType', '<?php echo esc_js($type->slug); ?>', '<?php echo esc_js($type->name); ?>')"
														:class="filters.courseType === '<?php echo esc_js($type->slug); ?>' ? 'active' : ''">
														<?php 
															if(pll_current_language() == 'tc') {
																$ctermfullname = get_field('tc_name', 'course_type_' .$type->term_id);
															}elseif(pll_current_language() == 'sc'){
																$ctermfullname = get_field('sc_name', 'course_type_' .$type->term_id);
															}else{
																$ctermfullname = get_field('en_name', 'course_type_' .$type->term_id);
															};
															echo ($ctermfullname); 
														?>
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
			</div>

			<!-- Course sections - each course type gets its own section -->
			<template x-for="section in courseSections" :key="section.name">
				<div class="section section_content filter_detail_section scrollin_p" x-show="section.courses.length > 0">
					<div class="filter_course_type_name section_center_content scrollin scrollinbottom small_section_center_content text3" x-text="section.name"></div>

					<div class="section_center_content small_section_center_content scrollin scrollinbottom filter_detail_flex_head mobile_hide2">
						<div class="filter_detail_flex text7">
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("課程編號","","Course Code"); ?></div>
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("課程名稱","","Course Title"); ?></div>
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("講師","","Lecturer"); ?></div>
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("語言","","Language"); ?></div>
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("時間","","Lecture Time"); ?></div>
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("地點","","Venue"); ?></div>
							<div class="filter_detail_flex_item"><?php echo cuhk_multilang_text("人數","","Quota"); ?></div>
						</div>
					</div>

					<div class="section_expandable_list  scrollin scrollinbottom filter_detail_flex_body">
						<template x-for="course in section.courses" :key="course.id">
							<div class="expandable_item "
								:class="expandedCourses.includes(course.id) ? 'active' : ''">
								<div class="section_center_content small_section_center_content">
									<div class="expandable_title filter_detail_flex">
										<div class="filter_detail_flex_item text5 text_c1 filter_detail_flex_item_title">
											<div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("課程編號","","Course Code"); ?></div>
											<span x-text="course.course_code"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("課程名稱","","Course Title"); ?></div>
											<span x-text="course.course_title"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("講師","","Lecturer"); ?></div>
											<span x-text="course.lecturer_name"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("語言","","Language"); ?></div>
											<span x-text="course.language"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("時間","","Lecture Time"); ?></div>
											<span x-text="course.lecture_time"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("地點","","Venue"); ?></div>
											<span x-text="course.venue"></span>
										</div>
										<div class="filter_detail_flex_item">
											<div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("人數","","Quota"); ?></div>
											<span x-text="course.quota"></span>
										</div>
										<div class="icon"></div>
									</div>
									<div class="hidden">
										<div class="hidden_content">
											<div class="filter_detail_description_title text7"><?php echo cuhk_multilang_text("簡介","","Description"); ?></div>
											<div class="filter_detail_description free_text" x-html="course.course_description"></div>

											<div x-show="course.has_detail" class="btn_wrapper text7">
												<a href="<?php the_permalink();?>" class="round_btn"><?php echo cuhk_multilang_text("課程內容","","Course detail"); ?></a>
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
					<p class="text5"><?php pll_e(''); ?><?php echo cuhk_multilang_text("未找到符合所選條件的課程。","","No courses found matching the selected criteria."); ?></p>
				</div>
			</div>
		</div>

		<script>
			function courseFilter() {
				return {
					filters: {
						categories: [],
						academicYear: '<?php echo !empty($academic_years) ? esc_js($academic_years[0]->slug) : ''; ?>',
						academicYearName: '<?php echo !empty($academic_years) ? esc_js($academic_years[0]->name) : ''; ?>',
						courseType: '<?php echo !empty($course_type) ? "" : ''; ?>',
						courseTypeName: '<?php echo !empty($course_type) ? "" : ''; ?>'
					},
					dropdowns: {
						year: false,
						type: false
					},
					courseSections: [],
					expandedCourses: [],
					loading: false,

					init() {
						// Don't set default category filter - show all courses initially
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
							if (this.filters.categories.length > 0) {
								this.filters.categories.forEach(category => {
									formData.append('categories[]', category);
								});
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
							} else {
								console.error('Error loading courses:', data);
								this.courseSections = [];
							}
						} catch (error) {
							console.error('Error loading courses:', error);
							this.courseSections = [];
						} finally {
							this.loading = false;
						}
					},


					$(document).on("click", ".expandable_item .expandable_title", function () {
						var $p = $(this).parents(".expandable_item")
						if($p.hasClass("active")){
							$p.removeClass("active").find(".hidden").show();
							setTimeout(function(){
							$p.find(".hidden").stop().slideUp();
							},0)
						}else{
							$p.addClass("active").find(".hidden").hide();
							setTimeout(function(){
							$p.find(".hidden").stop().slideDown();
							},0)
						}
					})


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