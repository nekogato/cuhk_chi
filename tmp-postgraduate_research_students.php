<?php

/**
 * Template Name: Postgraduate Research Students
 *
 * @package cuhk_chi
 */

get_header();
?>

<script>
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<?php get_template_part('template-parts/roll-menu'); ?>

<div x-data="studentList()">
	<div class="section section_content filter_menu_section">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<h1 class="section_title text1 scrollin scrollinbottom"><?php pll_e('研究生'); ?></h1>
		</div>
		<div class="filter_menu_wrapper">
			<div class="filter_menu section_center_content small_section_center_content scrollin scrollinbottom">
				<div class="alphabet_list_wrapper">
					<div class="title">alphabet order</div>
					<ul class="alphabet_list">
						<?php
						$alphabet = range('A', 'Z');
						foreach ($alphabet as $letter) :
						?>
							<li><a href="#" @click.prevent="filterByAlphabet('<?php echo strtolower($letter); ?>')" :class="{ 'active': selectedAlphabet === '<?php echo strtolower($letter); ?>' }"><?php echo $letter; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="filter_dropdown_wrapper">
					<a class="filter_dropdown_btn text5" href="#"><?php pll_e('Degree Programmes'); ?></a>
					<div class="filter_dropdown text5">
						<ul>
							<li><a href="#" @click.prevent="filterByDegree('MPhil')" :class="{ 'active': selectedDegree === 'MPhil' }">MPhil</a></li>
							<li><a href="#" @click.prevent="filterByDegree('PhD')" :class="{ 'active': selectedDegree === 'PhD' }">PhD</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section section_content student_list_section">
		<div class="section_center_content small_section_center_content scrollin scrollinopacity">
			<div class="student_list">
				<div class="student_list_item_wrapper">
					<template x-for="student in students" :key="student.id">
						<div class="student_list_item">
							<template x-if="student.photo">
								<div class="photo" @click="showStudentPopup(student)">
									<img :src="student.photo.sizes.s" :alt="student.photo.alt">
								</div>
							</template>
							<div class="text">
								<div class="name text5" x-text="student.title"></div>
								<div class="title" x-text="student.position"></div>
								<template x-if="student.contact_info">
									<div class="email" x-html="student.emails.join(' / ')" </div>
								</template>
							</div>
						</div>
					</template>
				</div>
			</div>

			<template x-if="hasMore">
				<div class="load_more_wrapper">
					<a class="load_more_btn text5" @click="loadMore">
						<div class="icon"></div>
						<div class="text"><?php pll_e('Load more'); ?></div>
					</a>
				</div>
			</template>
		</div>
	</div>

	<!-- Render Popup -->
	<div x-show="currentStudent" x-cloak style="display: none;">
		<template x-if="currentStudent">
			<div class="people_popup popup" :data-id="'student' + currentStudent.id">
				<div class="people_detail_content">
					<div class="people_detail_incontent">
						<template x-if="currentStudent.photo">
							<div class="people_detail_photo_wrapper">
								<div class="people_detail_photo">
									<img :src="currentStudent.photo.sizes.l" :alt="currentStudent.photo.alt">
								</div>
							</div>
						</template>
						<div class="people_detail_text">
							<div class="name text3" x-text="currentStudent.title"></div>
							<div class="position text5" x-text="currentStudent.position"></div>
							<template x-if="currentStudent.qualifications">
								<div class="qualifications text6">
									<ul>
										<template x-for="qualification in currentStudent.qualifications.split(',')" :key="qualification">
											<li x-text="qualification.trim()"></li>
										</template>
									</ul>
								</div>
							</template>
							<div class="info_table text6">
								<div class="table_flex_item_wrapper">
									<template x-if="currentStudent.emails && currentStudent.emails.length">
										<div class="table_flex_item">
											<div class="title text7"><?php pll_e('Email'); ?></div>
											<div class="text" x-html="currentStudent.emails.join(' / ')"></div>
										</div>
									</template>
									<template x-if="currentStudent.phones && currentStudent.phones.length">
										<div class="table_flex_item">
											<div class="title text7"><?php pll_e('Tel'); ?></div>
											<div class="text" x-text="currentStudent.phones.join(' / ')"></div>
										</div>
									</template>
									<template x-if="currentStudent.faxes && currentStudent.faxes.length">
										<div class="table_flex_item">
											<div class="title text7"><?php pll_e('Fax'); ?></div>
											<div class="text" x-text="currentStudent.faxes.join(' / ')"></div>
										</div>
									</template>
									<template x-if="currentStudent.address">
										<div class="table_flex_item">
											<div class="title text7"><?php pll_e('Address'); ?></div>
											<div class="text" x-text="currentStudent.address"></div>
										</div>
									</template>
								</div>
							</div>
							<template x-if="currentStudent.description">
								<div class="description">
									<div class="t1 text7"><?php pll_e('Description'); ?></div>
									<div class="t2 free_text" x-html="currentStudent.description"></div>
								</div>
							</template>
						</div>
					</div>
				</div>
				<a class="popup_close_btn" @click="hideStudentPopup"></a>
			</div>
		</template>
	</div>
</div>

<script>
	function studentList() {
		return {
			students: [],
			selectedAlphabet: '',
			selectedDegree: '',
			page: 1,
			hasMore: true,
			loading: false,
			currentStudent: null,

			init() {
				this.loadStudents();
				this.$watch('selectedAlphabet', () => this.filterStudents());
				this.$watch('selectedDegree', () => this.filterStudents());
			},

			async loadStudents() {
				if (this.loading) return;
				this.loading = true;

				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'load_postgraduate_students',
							nonce: '<?php echo wp_create_nonce('load_postgraduate_students_nonce'); ?>',
							page: this.page,
							alphabet: this.selectedAlphabet,
							degree: this.selectedDegree
						})
					});

					const data = await response.json();
					if (data.success) {
						const newStudents = data.data.students.map(student => ({
							...student,
							contact_info: this.formatContactInfo(student)
						}));

						if (this.page === 1) {
							this.students = newStudents;
						} else {
							this.students = [...this.students, ...newStudents];
						}

						this.hasMore = data.data.has_more;
					}
				} catch (error) {
					console.error('Error loading students:', error);
				} finally {
					this.loading = false;
				}
			},

			filterByAlphabet(alphabet) {
				this.selectedAlphabet = this.selectedAlphabet === alphabet ? '' : alphabet;
				this.page = 1;
				this.loadStudents();
			},

			filterByDegree(degree) {
				this.selectedDegree = this.selectedDegree === degree ? '' : degree;
				this.page = 1;
				this.loadStudents();
			},

			loadMore() {
				this.page++;
				this.loadStudents();
			},

			formatContactInfo(student) {
				const parts = [];

				if (student.emails && student.emails.length) {
					parts.push(student.emails.map(email =>
						`<a href="mailto:${email}">${email}</a>`
					).join(' / '));
				}

				if (student.phones && student.phones.length) {
					parts.push(student.phones.join(' / '));
				}

				if (student.faxes && student.faxes.length) {
					parts.push(student.faxes.join(' / '));
				}

				return parts.join(' / ');
			},

			showStudentPopup(student) {
				this.currentStudent = student;
				// Wait for Alpine to update the DOM
				this.$nextTick(() => {
					jQuery('.people_popup').fadeIn(300);
				});
			},

			hideStudentPopup() {
				jQuery('.people_popup').fadeOut(300, () => {
					this.currentStudent = null;
				});
			}
		}
	}
</script>

<?php
get_footer();
