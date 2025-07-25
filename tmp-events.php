<?php /* Template Name: Events Index */ ?>
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

		<div class="ink_bg13_wrapper">
			<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg8.jpg" class="ink_bg13 scrollin scrollinbottom" alt="Background">
		</div>
	<div x-data="eventFilter()">

		<div class="section section_content filter_menu_section">
			<div class="section_center_content small_section_center_content small_section_center_content scrollin scrollinbottom">
				<?php if ($page_title) : ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo ($page_title); ?></h1>
				<?php endif; ?>
				<?php if ($page_description) : ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo ($page_description); ?></div>
				<?php endif; ?>
				<?php
				$related_pages = get_field('related_page');
				if ($related_pages) : ?>
					<div class="intro_btn_wrapper">
						<?php foreach ($related_pages as $related_page) : ?>
							<a href="<?php echo get_permalink($related_page->ID); ?>" class="round_btn text5"><?php echo get_field("page_title",$related_page->ID); ?></a>
						<?php endforeach; ?>
					</div>
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
									<label for="all"><span><?php echo cuhk_multilang_text("所有活動","","All Events"); ?></span></label>
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
												<span>
												<?php 
													if(pll_current_language() == 'tc') {
														$ctermfullname = get_field('tc_name', 'event_category_' .$category->term_id);
													}elseif(pll_current_language() == 'sc'){
														$ctermfullname = get_field('sc_name', 'event_category_' .$category->term_id);
													}else{
														$ctermfullname = get_field('en_name', 'event_category_' .$category->term_id);
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
			</div>
		</div>

		<div class="section event_list_section scrollin_p">
			<div class="section_center_content small_section_center_content">
				<div class="event_list_item_wrapper" x-show="!loading">
					<template x-for="event in events" :key="event.id">
						<div class="event_list_item flex  scrollin scrollinbottom">
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

									<template x-if="event.event_banner">
										<div class="info_item big_info_item mobile_show2">
											<a :href="event.permalink"><img :src="event.event_banner.url" :alt="event.event_banner.alt"></a>
										</div>
									</template>
								</div>
							</div>
							<template x-if="event.event_banner">
								<div class="photo mobile_hide2">
									<a :href="event.permalink" ><img :src="event.event_banner.url" :alt="event.event_banner.alt"></a>
								</div>
							</template>
						</div>
					</template>

					<template x-if="hasMore && !loading">
						<div class="load_more_wrapper scrollin scrollinbottom">
							<a @click.prevent="loadMore()" class="load_more_btn text5">
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

				<!-- No events found message -->
				<div x-show="!loading && events.length === 0" style="text-align: center; padding: 60px 0;">
                    <p class="text5"><?php pll_e(''); ?><?php echo cuhk_multilang_text("未找到符合所選條件的活動。","","No events found matching the selected criteria."); ?></p>
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
						setTimeout(() => {
							doscroll();
						}, 300);
					}
				} catch (error) {
					console.error('Error loading events:', error);
				} finally {
					this.loading = false;
					dosize();
					doscroll();
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
