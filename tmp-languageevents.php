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

	<div x-data="eventFilter()">

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
								<div class="title text5" x-text="event.event_name"></div>
								<div class="info_item_wrapper">
									<div class="info_item">
										<div class="t1"><?php echo cuhk_multilang_text("日期","","Date"); ?></div>
										<div class="t2 text6" x-text="event.date_display"></div>
									</div>
									<template x-if="event.event_time">
										<div class="info_item">
											<div class="t1"><?php echo cuhk_multilang_text("時間","","Time"); ?></div>
											<div class="t2 text6" x-text="event.event_time"></div>
										</div>
									</template>
									<template x-if="event.event_venue">
										<div class="info_item big_info_item">
											<div class="t1"><?php echo cuhk_multilang_text("地點","","Venue"); ?></div>
											<div class="t2 text6" x-text="event.event_venue"></div>
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

	function eventFilter() {
		return {
			events: [],
			activeCategory: 'language-events',
			loading: false,
			currentPage: 1,
			hasMore: true,

			init() {
				this.loadEvents();
			},

			async loadEvents(page = 1, category = 'language-events', append = false) {
				this.loading = true;

				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'filter_events',
							nonce: '<?php echo wp_create_nonce('filter_events_nonce'); ?>',
							page: page,
							category: category
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

			loadMore() {
				if (!this.hasMore || this.loading) return;
				this.loadEvents(this.currentPage + 1, this.activeCategory, true);
			}
		}
	}
</script>


<?php
get_footer();
