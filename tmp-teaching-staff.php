<?php

/**
 * Template Name: Teaching Staff
 *
 * @package cuhk_chi
 */

get_header();

$teaching_staff_term = get_term_by('slug', 'teaching-staff', 'people_category');

if ($teaching_staff_term) {
	$child_terms = get_terms(array(
		'taxonomy' => 'people_category',
		'hide_empty' => true,
		'parent' => $teaching_staff_term->term_id,
	));
}
?>

<script>
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	var childTermsData = <?php
							if (!empty($child_terms) && !is_wp_error($child_terms)) {
								$terms_with_names = array();
								foreach ($child_terms as $term) {
									$lang = pll_current_language();
									$term_name = get_field("{$lang}_name", 'people_category_' . $term->term_id);
									$terms_with_names[] = array(
										'term_id' => $term->term_id,
										'slug' => $term->slug,
										'name' => $term->name,
										'localized_name' => $term_name ?: $term->name
									);
								}
								echo json_encode($terms_with_names);
							} else {
								echo '[]';
							}
							?>;
</script>

<?php get_template_part('template-parts/roll-menu'); ?>

<div x-data="teachingStaffList()" x-init="init()">
	<div class="section section_content filter_menu_section">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<h1 class="section_title text1 scrollin scrollinbottom"><?php the_field('page_title'); ?></h1>
		</div>
		<div class="filter_menu_wrapper">
			<div class="filter_menu filter_menu_no_flex">
				<div class="section_center_content small_section_center_content scrollin scrollinbottom">
					<div class="filter_menu_content full_filter_menu_content">
						<div class="alphabet_list_wrapper big_alphabet_list_wrapper">
							<div class="title text5"><?php echo cuhk_multilang_text("職位分類", "", "Category"); ?></div>
							<template x-if="childTerms && childTerms.length">
								<ul class="alphabet_list">
									<template x-for="term in childTerms" :key="term.term_id">
										<li>
											<a
												@click.prevent="filterByPosition(term.slug)"
												:class="{ 'active': selectedPosition === term.slug }"
												x-text="getTermName(term)">
											</a>
										</li>
									</template>
								</ul>
							</template>
						</div>
						
					</div>
				</div>
			</div>

			<div class="filter_menu filter_menu_left_bg filter_menu_bottom section_center_content small_section_center_content scrollin scrollinbottom ">
				<div class="filter_remark"><?php echo cuhk_multilang_text("按姓名繁體筆劃排序", "按姓名拼音排序", "In alphabetical order"); ?></div>
			</div>

			<!-- <div class="filter_menu filter_menu_left_bg filter_menu_bottom section_center_content small_section_center_content scrollin scrollinbottom">
				<div class="filter_menu_content">
					<div class="filter_checkbox_wrapper text7">
						<div class="filter_checkbox">
							<div class="checkbox">
								<input type="radio" name="order" id="ascending" @change="setSortOrder('asc')" :checked="sortOrder === 'asc'">
								<label for="ascending"><span><?php pll_e('Title Ascending'); ?></span></label>
							</div>
						</div>
						<div class="filter_checkbox">
							<div class="checkbox">
								<input type="radio" name="order" id="descending" @change="setSortOrder('desc')" :checked="sortOrder === 'desc'">
								<label for="descending"><span><?php pll_e('Title Descending'); ?></span></label>
							</div>
						</div>
					</div>
				</div>
			</div> -->
		</div>
	</div>

	<div class="section section_content student_list_section">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<div class="student_list">
				<div class="student_list_item_wrapper">
					<template x-for="staff in staffMembers" :key="staff.id">
						<div class="student_list_item ">
							<template x-if="staff.has_detail">
								<a class="photo" :href="staff.permalink" x-show="staff.photo">
									<img :src="staff.photo.sizes.s" :alt="staff.photo.alt" />
								</a>
							</template>

							<template x-if="!staff.has_detail">
								<div class="photo" @click="showStaffPopup(staff)" x-show="staff.photo">
									<img :src="staff.photo.sizes.s" :alt="staff.photo.alt">
								</div>
							</template>

							<div class="text" @click="!staff.has_detail && showStaffPopup(staff)">
								<div class="name text5">
									<a x-text="staff.title" :href="staff.has_detail ? staff.permalink : null"></a>
								</div>
								<div class="title" x-html="staff.position"></div>
								<template x-if="staff.emails && staff.emails.length">
									<div class="email">
										<template x-for="(email, index) in staff.emails" :key="email">
											<span>
												<a class="email_link" :href="'mailto:' + email" x-text="email"></a>
												<span x-show="index < staff.emails.length - 1"> / </span>
											</span>
										</template>
									</div>
								</template>
							</div>
						</div>
					</template>
				</div>
			</div>

			<template x-if="!loading && staffMembers.length === 0">
				<div class="no_result text5">
					<?php echo cuhk_multilang_text("沒有資料", "", "No staff found."); ?>
				</div>
			</template>

			<template x-if="hasMore">
				<div class="load_more_wrapper">
					<a class="load_more_btn text5" @click="loadMore">
						<div class="icon"></div>
						<div class="text"><?php echo cuhk_multilang_text("載入更多", "", "Load more"); ?></div>
					</a>
				</div>
			</template>
		</div>

			<div class="ajax_loading"></div>
	</div>

	<!-- Render Popup -->
	<div x-show="currentStaff" x-cloak style="display: none;">
		<template x-if="currentStaff">
			<div class="people_popup popup" :data-id="'staff' + currentStaff.id">
				<div class="people_detail_content">
					<div class="people_detail_incontent">
						<template x-if="currentStaff.photo">
							<div class="people_detail_photo_wrapper">
								<div class="people_detail_photo">
									<img :src="currentStaff.photo.sizes.l" :alt="currentStaff.photo.alt">
								</div>
							</div>
						</template>
						<div class="people_detail_text">
							<div class="name text3" x-text="currentStaff.title"></div>
							<div class="position text5" x-html="currentStaff.position"></div>
							<template x-if="currentStaff.qualifications">
								<div class="qualifications text6">
									<ul>
										<template x-for="qualification in currentStaff.qualifications.split(',')" :key="qualification">
											<li x-text="qualification.trim()"></li>
										</template>
									</ul>
								</div>
							</template>
							<div class="info_table text6">
								<div class="table_flex_item_wrapper">
									<template x-if="currentStaff.emails && currentStaff.emails.length">
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("電郵", "", "Email"); ?></div>
											<div class="text" x-html="currentStaff.emails.join(' / ')"></div>
										</div>
									</template>
									<template x-if="currentStaff.phones && currentStaff.phones.length">
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("電話", "", "Tel"); ?></div>
											<div class="text" x-text="currentStaff.phones.join(' / ')"></div>
										</div>
									</template>
									<template x-if="currentStaff.faxes && currentStaff.faxes.length">
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("傳真", "", "Fax"); ?></div>
											<div class="text" x-text="currentStaff.faxes.join(' / ')"></div>
										</div>
									</template>
									<template x-if="currentStaff.address">
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("地址", "", "Address"); ?></div>
											<div class="text" x-text="currentStaff.address"></div>
										</div>
									</template>
									<template x-if="currentStaff.office_hours">
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("辦工時間", "", "Office Hours"); ?></div>
											<div class="text" x-text="currentStaff.office_hours"></div>
										</div>
									</template>
								</div>
							</div>
							<template x-if="currentStaff.research_interests">
								<div class="description">
									<div class="t1 text7"><?php echo cuhk_multilang_text("研究專長", "", "Research Interests"); ?></div>
									<div class="t2 free_text" x-html="currentStaff.research_interests"></div>
								</div>
							</template>
							<template x-if="currentStaff.description">
								<div class="description">
									<div class="t1 text7"><?php echo cuhk_multilang_text("簡介", "", "Description"); ?></div>
									<div class="t2 free_text" x-html="currentStaff.description"></div>
								</div>
							</template>
						</div>
					</div>
				</div>
				<a class="popup_close_btn" @click="hideStaffPopup"></a>
			</div>
		</template>
	</div>
</div>

<script>
	function teachingStaffList() {
		return {
			staffMembers: [],
			childTerms: childTermsData || [],
			selectedPosition: '',
			sortOrder: 'asc',
			page: 1,
			hasMore: true,
			loading: false,
			currentStaff: null,

			init() {
				// Check for URL parameter first
				const urlParams = new URLSearchParams(window.location.search);
				const positionFromURL = urlParams.get('people_category');

				if (positionFromURL) {
					this.selectedPosition = positionFromURL;
				} else if (this.childTerms && this.childTerms.length > 0) {
					// Fallback to first term if no URL param
					this.selectedPosition = this.childTerms[0].slug;
				}

				this.loadStaff();

				this.$watch('selectedPosition', () => this.filterStaff());
				this.$watch('sortOrder', () => this.filterStaff());
			},

			getTermName(term) {
				// Use the localized name that was prepared in PHP
				return term.localized_name || term.name || term.slug;
			},

			async loadStaff() {
				if (this.loading) return;
				this.loading = true;
				$(".ajax_loading").stop().fadeIn();
				// $(".student_list_item_wrapper").height($(".student_list_item_wrapper").height());

				// $(".student_list_item").css({
				// 	"-webkit-transition-delay": 0 + "ms",
				// 	"transition-delay": 0 + "ms",
				// })

				// setTimeout(function() {
				// 	$(".student_list_item").removeClass("startani")
				// }, 0);
				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'load_teaching_staff',
							nonce: '<?php echo wp_create_nonce('load_teaching_staff_nonce'); ?>',
							page: this.page,
							position: this.selectedPosition,
							sort_order: this.sortOrder
						})
					});

					const data = await response.json();
					if (data.success) {
						const newStaff = data.data.staff.map(staff => ({
							...staff,
							contact_info: this.formatContactInfo(staff)
						}));

						if (this.page === 1) {
							this.staffMembers = newStaff;
						} else {
							this.staffMembers = [...this.staffMembers, ...newStaff];
						}

						this.hasMore = data.data.has_more;
						$(".ajax_loading").stop().fadeOut();
						setTimeout(function() {
							doscroll();
							//$(".student_list_item_wrapper").height("auto")
						}, 300)
					}
				} catch (error) {
					console.error('Error loading teaching staff:', error);
					$(".ajax_loading").stop().fadeOut();
					setTimeout(function() {
						doscroll();
						//$(".student_list_item_wrapper").height("auto")
					}, 300)
				} finally {
					this.loading = false;

					$(".ajax_loading").stop().fadeOut();
					setTimeout(function() {
						doscroll();
						//$(".student_list_item_wrapper").height("auto")
					}, 300)
				}
			},

			filterByPosition(position) {
				this.selectedPosition = position;
				this.page = 1;
				this.loadStaff();

				// Update the URL without reloading the page
				const url = new URL(window.location);
				url.searchParams.set('people_category', position);
				window.history.pushState({}, '', url);
			},

			setSortOrder(order) {
				this.sortOrder = order;
				this.page = 1;
				this.loadStaff();
			},

			filterStaff() {
				this.page = 1;
				this.loadStaff();
			},

			loadMore() {
				this.page++;
				this.loadStaff();
			},

			formatContactInfo(staff) {
				const parts = [];

				if (staff.emails && staff.emails.length) {
					parts.push(staff.emails.map(email =>
						`<a href="mailto:${email}">${email}</a>`
					).join(' / '));
				}

				if (staff.phones && staff.phones.length) {
					parts.push(staff.phones.join(' / '));
				}

				if (staff.faxes && staff.faxes.length) {
					parts.push(staff.faxes.join(' / '));
				}

				return parts.join(' / ');
			},

			showStaffPopup(staff) {
				this.currentStaff = staff;
				// Wait for Alpine to update the DOM

				this.$nextTick(() => {
					$(".people_detail_text").each(function() {
						var $this = $(this);

						var ps = new PerfectScrollbar($(this)[0], {
							suppressScrollX: true,
							scrollYMarginOffset: 20
						});

						scrollArr.push(ps)
					});

					jQuery('.people_popup').fadeIn(300);
				});
			},

			hideStaffPopup() {
				jQuery('.people_popup').fadeOut(300, () => {
					this.currentStaff = null;
				});
			}
		}
	}
</script>

<?php
get_footer();
