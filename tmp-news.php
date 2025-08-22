<?php /* Template Name: News Index */ ?>
<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cuhk_chi
 */

get_header();

?>

<?php get_template_part('template-parts/roll-menu'); ?>

<?php

while (have_posts()) :
	the_post();
?>
	

<div class="ink_bg13_wrapper">
	<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg9.jpg" class="ink_bg13 scrollin scrollinbottom" alt="Background">
</div>

<div x-data="newsFilter()">
	<div class="section section_content filter_menu_section">
		<div class="section_center_content">
			<h1 class="section_title text1 scrollin scrollinbottom"><?php echo get_field("page_title"); ?></h1>
			<div class="section_description scrollin scrollinbottom col6"><?php echo get_field('introduction'); ?></div>
		</div>

		<div class="filter_menu_wrapper full_filter_menu_wrapper">
			<div class="filter_menu filter_menu_left_bg section_center_content small_section_center_content scrollin scrollinbottom">
				<div class="filter_menu_content full_filter_menu_content">
					<div class="filter_checkbox_wrapper text7 filter_switchable_wrapper">
						<div class="filter_checkbox">
							<div class="checkbox">
								<input name="filter" type="radio" id="all"
									@change="filterByCategory('all')"
									:checked="activeCategory === 'all'">
								<label for="all"><span><?php echo cuhk_multilang_text("所有類型", "", "All Categories"); ?></span></label>
							</div>
						</div>
						<?php
						// Get news categories
						$news_categories = get_terms(array(
							'taxonomy' => 'news_category',
							'hide_empty' => true,
							'orderby' => 'name',
							'order' => 'ASC'
						));

						if ($news_categories && !is_wp_error($news_categories)) :
							foreach ($news_categories as $category) :
						?>
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
						<?php
							endforeach;
						endif;
						?>
					</div>
					<div class="filter_dropdown_wrapper right_filter_dropdown_wrapper">
						<a class="filter_dropdown_btn text5" href="#" @click.prevent="toggleYearDropdown()" x-text="selectedYearText"><?php echo cuhk_multilang_text("年份", "", "Year"); ?></a>
						<div class="filter_dropdown text5">
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

	<!-- Regular News Section -->
	<div class="section news_box_section scrollin_p ">
		<div class="news_box_wrapper">
			<div class="section_center_content">
				<div class="col_wrapper">
					<div class="flex row" id="news-container">
						<template x-for="news_item in news" :key="news_item.id">
							<div class="news_box col col4">
								<div class="col_spacing scrollin scrollinbottom">
									<a class="photo" :href="news_item.permalink">
										<img :src="news_item.featured_image" :alt="news_item.title">
									</a>
									<div class="text_wrapper">
										<div class="date_wrapper text5" x-html="news_item.date"></div>
										<div class="title_wrapper">
											<div class="cat" x-html="news_item.category_name"></div>
											<div class="title text5" x-html="news_item.title"></div>
											<div class="btn_wrapper text7">
												<a :href="news_item.permalink" class="round_btn"><?php echo cuhk_multilang_text("查看更多","","View more"); ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>

						</template>
					</div>
				</div>

				<template x-if="hasMore && !loading">
					<div class="load_more_wrapper scrollin scrollinbottom">
						<a @click.prevent="loadMore()" class="load_more_btn text5">
							<div class="icon"></div>
							<div class="text"><?php echo cuhk_multilang_text("載入更多", "", "Load more"); ?></div>
						</a>
					</div>
				</template>

				<!-- Loading indicator -->
				<div class="col_wrapper big_col_wrapper" x-show="loading" x-cloak>
					<div class="loading-indicator" style="text-align: center; padding: 40px;">
						<p><?php echo cuhk_multilang_text("載入學系消息中...", "", "Loading news..."); ?></p>
					</div>
				</div>

				<!-- No results message -->
				<div class="col_wrapper big_col_wrapper" x-show="!loading && news.length === 0" x-cloak>
					<div class="no-results" style="text-align: center; padding: 40px;">
						<p><?php echo cuhk_multilang_text("沒有找到學系消息", "", "No news found"); ?></p>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script>
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

	function newsFilter() {
		return {
			news: [],
			activeCategory: 'all',
			selectedYear: '',
			selectedYearText: '<?php echo cuhk_multilang_text("年份", "", "Year"); ?>',
			showYearDropdown: false,
			availableYears: [],
			loading: false,
			currentPage: 1,
			hasMore: true,

			init() {
				this.loadNews();
				this.loadNewsAvailableYears();
			},

			async loadNews(page = 1, category = 'all', year = '', append = false) {
				this.loading = true;

				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'filter_news',
							nonce: '<?php echo wp_create_nonce('filter_news_nonce'); ?>',
							page: page,
							category: category,
							year: year
						})
					});

					const data = await response.json();
					if (data.success) {
						console.log(data);
						if (append) {
							this.news = [...this.news, ...data.data.news];
						} else {
							this.news = data.data.news;
						}
						this.hasMore = data.data.has_more;
						this.currentPage = page;
					}
				} catch (error) {
					console.error('Error loading news:', error);
				} finally {
					this.loading = false;
					this.$nextTick(async () => {
						setTimeout(() => {
							dosize();
							doscroll();
						}, 300);
					});
				}
			},

			async loadNewsAvailableYears() {
				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'get_news_years',
							nonce: '<?php echo wp_create_nonce('get_news_years_nonce'); ?>'
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

			filterByCategory(category) {
				if (this.activeCategory === category) return;
				this.activeCategory = category;
				this.currentPage = 1;
				this.loadNews(1, category, this.selectedYear, false);
			},

			filterByYear(year) {
				this.selectedYear = year;
				this.selectedYearText = year || '<?php echo cuhk_multilang_text("年份", "", "Year"); ?>';
				this.showYearDropdown = false;
				this.currentPage = 1;
				this.loadNews(1, this.activeCategory, year, false);
			},

			toggleYearDropdown() {
				this.showYearDropdown = !this.showYearDropdown;
			},

			loadMore() {
				if (!this.hasMore || this.loading) return;
				this.loadNews(this.currentPage + 1, this.activeCategory, this.selectedYear, true);
			}
		}
	}
</script>

<?php
endwhile;
get_footer();
