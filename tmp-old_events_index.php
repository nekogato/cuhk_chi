<?php /* Template Name: Past Events Index */ ?>
<?php
/**
 * The template for displaying the past events index page
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu'); ?>

<?php
while (have_posts()) :
	the_post();
	$page_title = get_the_title();
	$page_description = get_field("introduction");
?>

	<div x-data="pastEventFilter()">

		<div class="section section_content filter_menu_section">
			<div class="section_center_content small_section_center_content small_section_center_content scrollin scrollinbottom">
				<?php
				$related_pages = get_field('related_page');
				if ($related_pages) : ?>
					<div class="intro_btn_wrapper">
						<?php foreach ($related_pages as $related_page) : ?>
							<a href="<?php echo get_permalink($related_page->ID); ?>" class="round_btn text5"><?php echo get_the_title($related_page->ID); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<?php if ($page_title) : ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo esc_html($page_title); ?></h1>
				<?php endif; ?>
				<?php if ($page_description) : ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo wp_kses_post($page_description); ?></div>
				<?php endif; ?>
			</div>

			<?php
			// Get event categories
			$event_categories = get_terms(array(
				'taxonomy' => 'event_category',
				'hide_empty' => true,
				'orderby' => 'name',
				'order' => 'ASC'
			));
			?>

			<div class="filter_menu_wrapper">
				<div class="filter_menu filter_menu_left_bg section_center_content small_section_center_content scrollin scrollinbottom">
					<div class="filter_menu_content">
						<div class="filter_checkbox_wrapper text7 filter_switchable_wrapper">
							<div class="filter_checkbox">
								<div class="checkbox">
									<input name="filter" type="radio" id="all"
										@change="filterByCategory('all')"
										:checked="activeCategory === 'all'">
									<label for="all"><span><?php pll_e('活動分類'); ?></span></label>
								</div>
							</div>
							<?php if (!empty($event_categories)) : ?>
								<?php foreach ($event_categories as $category) : ?>
									<div class="filter_checkbox">
										<div class="checkbox">
											<input name="filter" type="radio" id="category-<?php echo esc_attr($category->term_id); ?>"
												@change="filterByCategory('<?php echo esc_attr($category->slug); ?>')"
												:checked="activeCategory === '<?php echo esc_attr($category->slug); ?>'">
											<label for="category-<?php echo esc_attr($category->term_id); ?>">
												<span><?php echo esc_html($category->name); ?></span>
											</label>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
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
								<div class="d_wrapper">
									<template x-if="event.has_date_range">
										<div>
											<div class="d">
												<div class="d1 text3" x-text="event.start_date_short"></div>
											</div>
											<div class="d">
												<div class="d1 text3" x-text="event.end_date_short"></div>
											</div>
										</div>
									</template>
									<template x-if="!event.has_date_range">
										<div class="d">
											<div class="d1 text3" x-text="event.start_date_short"></div>
										</div>
									</template>
								</div>
								<div class="btn_wrapper">
									<a :href="event.permalink" class="reg_btn round_btn text7"><?php pll_e('了解更多'); ?></a>
								</div>
							</div>
							<div class="title_wrapper">
								<div class="title text5" x-text="event.event_name"></div>
								<div class="info_item_wrapper">
									<div class="info_item">
										<div class="t1"><?php pll_e('日期'); ?></div>
										<div class="t2 text6" x-text="event.date_display"></div>
									</div>
									<template x-if="event.event_time">
										<div class="info_item">
											<div class="t1"><?php pll_e('時間'); ?></div>
											<div class="t2 text6" x-text="event.event_time"></div>
										</div>
									</template>
									<template x-if="event.event_venue">
										<div class="info_item big_info_item">
											<div class="t1"><?php pll_e('地點'); ?></div>
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
								<div class="text"><?php pll_e('Load more'); ?></div>
							</a>
						</div>
					</template>
				</div>

				<!-- Loading indicator -->
				<div class="event_list_item_wrapper" x-show="loading" x-cloak>
					<div class="loading-indicator" style="text-align: center; padding: 40px;">
						<p><?php pll_e('Loading events...'); ?></p>
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

	function pastEventFilter() {
		return {
			events: [],
			activeCategory: 'all',
			loading: false,
			currentPage: 1,
			hasMore: true,

			init() {
				this.loadEvents();
			},

			async loadEvents(page = 1, category = 'all', append = false) {
				this.loading = true;

				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'load_past_events',
							nonce: '<?php echo wp_create_nonce('load_past_events_nonce'); ?>',
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

			filterByCategory(category) {
				if (this.activeCategory === category) return;
				this.activeCategory = category;
				this.currentPage = 1;
				this.loadEvents(1, category, false);
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
