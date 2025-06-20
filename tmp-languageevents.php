<?php /* Template Name: Language Events Index */ ?>
<?php
/**
 * The template for displaying the events index page
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu'); ?>

<?php
while (have_posts()) :
	the_post();
	$page_title = get_field("page_title");
	$page_description = get_field("introduction");
?>

	<div x-data="langEventFilter()">

		<div class="section section_content filter_menu_section">
			<div class="section_center_content small_section_center_content small_section_center_content scrollin scrollinbottom">
				<?php if ($page_title) : ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo ($page_title); ?></h1>
				<?php endif; ?>
				<?php if ($page_description) : ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo ($page_description); ?></div>
				<?php endif; ?>
			</div>

			<div class="filter_menu_wrapper">
				<div class="filter_menu filter_menu_left_bg section_center_content small_section_center_content scrollin scrollinbottom">
					<div class="filter_menu_content full_filter_menu_content">
						<div class="filter_dropdown_wrapper right_filter_dropdown_wrapper">
							<a class="filter_dropdown_btn text5" href="#" @click.prevent="toggleYearDropdown()" x-text="selectedYearText"><?php echo cuhk_multilang_text("所有年份", "", "All Years"); ?></a>
							<div class="filter_dropdown text5" x-show="showYearDropdown" @click.away="showYearDropdown = false">
								<ul>
									<li><a href="#" @click.prevent="filterByYear('')" data-val=""><?php echo cuhk_multilang_text("所有年份", "", "All Years"); ?></a></li>
									<template x-for="year in availableYears" :key="year">
										<li><a href="#" @click.prevent="filterByYear(year)" :data-val="year" x-text="year"></a></li>
									</template>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="section event_list_section scrollin_p">
			<div class="section_center_content small_section_center_content">
				<div class="event_list_item_wrapper" x-show="!loading">
					<template x-for="event in events" :key="event.id">
						<div class="event_list_item flex">
							<div class="date">
								<template x-if="event.has_date_range">
									<div class="d_wrapper">
										<div class="d">
											<div class="d1 text3" x-text="event.start_date_short"></div>
										</div>
										<div class="d">
											<div class="d1 text3" x-text="event.end_date_short"></div>
										</div>
									</div>
								</template>
								<template x-if="!event.has_date_range">
									<div class="d_wrapper">
										<div class="d">
											<div class="d1 text3" x-text="event.start_date_short"></div>
										</div>
									</div>
								</template>
								<div class="btn_wrapper">
									<a :href="event.permalink" class="reg_btn round_btn text7"><?php echo cuhk_multilang_text("查看更多","","View more"); ?></a>
								</div>
							</div>
							<div class="title_wrapper">
								<div class="title text4" x-html="event.event_name"></div>
								<div class="info_item_wrapper">
									<div class="info_item">
										<div class="t1"><?php echo cuhk_multilang_text("日期","","Date"); ?></div>
										<div class="t2 text6" x-html="event.date_display"></div>
									</div>
									<template x-if="event.event_time">
										<div class="info_item">
											<div class="t1"><?php echo cuhk_multilang_text("時間","","Time"); ?></div>
											<div class="t2 text6" x-html="event.event_time"></div>
										</div>
									</template>
									<template x-if="event.event_venue">
										<div class="info_item big_info_item">
											<div class="t1"><?php echo cuhk_multilang_text("地點","","Venue"); ?></div>
											<div class="t2 text6" x-html="event.event_venue"></div>
										</div>
									</template>
								</div>
							</div>
							<template x-if="event.event_banner">
								<div class="photo">
									<img :src="event.event_banner.url" :alt="event.event_banner.alt">
								</div>
							</template>
						</div>
					</template>

					<template x-if="hasMore && !loading">
						<div class="load_more_wrapper scrollin scrollinbottom">
							<a href="#" @click.prevent="loadMore()" class="load_more_btn text5">
								<div class="icon"></div>
								<div class="text"><?php echo cuhk_multilang_text("載入更多","","Load more"); ?></div>
							</a>
						</div>
					</template>
				</div>

				<!-- Loading indicator -->
				<div class="event_list_item_wrapper" x-show="loading" x-cloak>
					<div class="loading-indicator" style="text-align: center; padding: 40px;">
						<p><?php echo cuhk_multilang_text("戴入活動中","","Loading events..."); ?></p>
					</div>
				</div>
			</div>
		</div>

	</div>

<?php
endwhile;
?>

<script>
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

	function langEventFilter() {
		return {
			events: [],
			activeCategory: 'all',
			selectedYear: '',
			selectedYearText: '<?php echo cuhk_multilang_text("所有年份", "", "All Years"); ?>',
			showYearDropdown: false,
			availableYears: [],
			loading: false,
			currentPage: 1,
			hasMore: true,

			init() {
				this.loadEvents();
				this.loadAvailableYears();
			},

			async loadEvents(page = 1, category = 'all', year = '', pastonly = false, append = false) {
				this.loading = true;

				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'load_events_with_year',
							nonce: '<?php echo wp_create_nonce('load_events_with_year_nonce'); ?>',
							page: page,
							category: category,
							year: year,
							pastonly : pastonly
						})
					});

					const data = await response.json();
					if (data.success) {
						if (append) {
							this.events = [...this.events, ...data.data.events];
						} else {
							this.events = data.data.events;
						}
						this.hasMore = data.data.has_more;
						this.currentPage = page;
					}
				} catch (error) {
					console.error('Error loading events:', error);
				} finally {
					this.loading = false;
				}
			},

			async loadAvailableYears() {
				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'get_old_event_years',
							nonce: '<?php echo wp_create_nonce('get_old_event_years_nonce'); ?>'
						})
					});

					const data = await response.json();
					if (data.success) {
						this.availableYears = data.data.years;
					}
				} catch (error) {
					console.error('Error loading years:', error);
				}
			},

			filterByYear(year) {
				this.selectedYear = year;
				this.selectedYearText = year || '<?php echo cuhk_multilang_text("所有年份", "", "All Year"); ?>';
				this.showYearDropdown = false;
				this.currentPage = 1;
				this.loadEvents(1, this.activeCategory, year, false);
			},

			toggleYearDropdown() {
				this.showYearDropdown = !this.showYearDropdown;
			},

			loadMore() {
				if (!this.hasMore || this.loading) return;
				this.loadEvents(this.currentPage + 1, this.activeCategory, this.selectedYear, true);
			}
		}
	}
</script>

<?php
get_footer();
