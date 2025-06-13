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
        'hide_empty' => false,
        'parent' => $teaching_staff_term->term_id,
    ));
}
?>

<script>
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
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
							<div class="title"><?php echo cuhk_multilang_text("職位分類","","Category"); ?></div>
							<?php if (!empty($child_terms) && !is_wp_error($child_terms)) : ?>
							<ul class="alphabet_list">
								<?php foreach ($child_terms as $term): ?>
									<li>
										<a 
										@click.prevent="filterByPosition('<?php echo esc_attr($term->slug); ?>')"
										:class="{ 'active': selectedPosition === '<?php echo esc_js($term->slug); ?>' }">
										<?php
											$lang = pll_current_language();
											$ctermfullname = get_field("{$lang}_name", 'people_category_' . $term->term_id);
											echo esc_html($ctermfullname);
										?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
							<?php endif; ?>
						</div>
					</div>
				</div>
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
		<div class="section_center_content small_section_center_content scrollin scrollinopacity">
			<div class="student_list">
				<div class="student_list_item_wrapper">
					<template x-for="staff in staffMembers" :key="staff.id">
						<template x-if="staff.has_detail">
							<div class="student_list_item scrollin scrollinopacity ">
								<!-- If staff has detail page, make entire item clickable to detail page -->
								<template x-if="staff.photo">
									<a class="photo" :href="staff.permalink">
										<img :src="staff.photo.sizes.s" :alt="staff.photo.alt" />
									</a>
								</template>
								<div class="text">
									<div class="name text5">
										<a x-text="staff.title"></a>
									</div>
									<div class="title" x-text="staff.position"></div>
									<template x-if="staff.contact_info">
										<div class="email" x-html="staff.emails.join(' / ')"></div>
									</template>
								</div>
							</div>
						</template>

						<!-- If staff has no detail page, make entire item clickable to show popup -->
						<template x-if="!staff.has_detail">
							<div class="student_list_item scrollin scrollinbottom">
								<template x-if="staff.photo">
									<div class="photo" @click="showStaffPopup(staff)" x-if="staff.photo">
										<img :src="staff.photo.sizes.s" :alt="staff.photo.alt">
									</div>
								</template>
								<div class="text" @click="showStaffPopup(staff)">
									<div class="name text5" x-text="staff.title"></div>
									<div class="title" x-text="staff.position"></div>
									<template x-if="staff.contact_info">
										<div class="email" x-html="staff.emails.join(' / ')"></div>
									</template>
								</div>
							</div>
						</template>
					</template>
				</div>
			</div>

			<template x-if="hasMore">
				<div class="load_more_wrapper">
					<a class="load_more_btn text5" @click="loadMore">
						<div class="icon"></div>
						<div class="text"><?php echo cuhk_multilang_text("載入更多","","Load more"); ?></div>
					</a>
				</div>
			</template>
		</div>
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
							<div class="position text5" x-text="currentStaff.position"></div>
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
											<div class="title text7"><?php echo cuhk_multilang_text("電郵","","Email"); ?></div>
											<div class="text" x-html="currentStaff.emails.join(' / ')"></div>
										</div>
									</template>
									<template x-if="currentStaff.phones && currentStaff.phones.length">
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("電話","","Tel"); ?></div>
											<div class="text" x-text="currentStaff.phones.join(' / ')"></div>
										</div>
									</template>
									<template x-if="currentStaff.faxes && currentStaff.faxes.length">
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("傳真","","Fax"); ?></div>
											<div class="text" x-text="currentStaff.faxes.join(' / ')"></div>
										</div>
									</template>
									<template x-if="currentStaff.address">
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("地址","","Address"); ?></div>
											<div class="text" x-text="currentStaff.address"></div>
										</div>
									</template>
									<template x-if="currentStaff.office_hours">
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("辦工時間","","Office Hours"); ?></div>
											<div class="text" x-text="currentStaff.office_hours"></div>
										</div>
									</template>
								</div>
							</div>
							<template x-if="currentStaff.research_interests">
								<div class="description">
									<div class="t1 text7"><?php echo cuhk_multilang_text("研究專長","","Research Interests"); ?></div>
									<div class="t2 free_text" x-html="currentStaff.research_interests"></div>
								</div>
							</template>
							<template x-if="currentStaff.description">
								<div class="description">
									<div class="t1 text7"><?php echo cuhk_multilang_text("簡介","","Description"); ?></div>
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
			selectedPosition: '',
			sortOrder: 'asc',
			page: 1,
			hasMore: true,
			loading: false,
			currentStaff: null,

			init() {
				this.loadStaff();
				this.$watch('selectedPosition', () => this.filterStaff());
				this.$watch('sortOrder', () => this.filterStaff());
			},

			async loadStaff() {
				if (this.loading) return;
				this.loading = true;

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
						setTimeout(function(){
							doscroll();
						},300)
					}
				} catch (error) {
					console.error('Error loading teaching staff:', error);
						setTimeout(function(){
							doscroll();
						},300)
				} finally {
					this.loading = false;
						setTimeout(function(){
							doscroll();
						},300)
				}
			},

			filterByPosition(position) {
				this.selectedPosition = this.selectedPosition === position ? '' : position;
				this.page = 1;
				this.loadStaff();
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
