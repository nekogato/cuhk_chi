<?php
/*
Template Name: Gallery Archive
*/

get_header();

// Include the roll menu template part
get_template_part('template-parts/roll-menu'); ?>

<div class="ink_bg13_wrapper">
	<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg13.jpg" class="ink_bg13 scrollin scrollinbottom" alt="Background">
</div>

<div x-data="galleryFilter()">
	<div class="section section_content filter_menu_section">

		<div class="section_center_content small_section_center_content small_section_center_content scrollin scrollinbottom">
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
						// Get gallery categories
						$gallery_categories = get_terms(array(
							'taxonomy' => 'gallery_category',
							'hide_empty' => true,
							'orderby' => 'name',
							'order' => 'ASC'
						));

						if ($gallery_categories && !is_wp_error($gallery_categories)) :
							foreach ($gallery_categories as $category) :
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

	<div class="section news_box_section news_gallery_box_section scrollin_p">
		<div class="news_box_wrapper scrollin scrollinbottom">
			<div class="section_center_content small_section_center_content">
				<div class="col_wrapper big_col_wrapper">
					<div class="flex row" x-show="!loading">
						<template x-for="gallery in galleries" :key="gallery.id">
							<div class="news_box col col3">
								<div class="col_spacing ">
									<a class="photo" :href="gallery.permalink">
										<img :src="gallery.featured_image" :alt="gallery.title">
									</a>
									<div class="text_wrapper">
										<div class="title_wrapper">
											<template x-if="gallery.category_name">
												<div class="cat" x-text="gallery.category_name"></div>
											</template>
											<div class="title text5" x-html="gallery.title"></div>
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
						<p><?php echo cuhk_multilang_text("載入相片集中...", "", "Loading galleries..."); ?></p>
					</div>
				</div>

				<!-- No results message -->
				<div class="col_wrapper big_col_wrapper" x-show="!loading && galleries.length === 0" x-cloak>
					<div class="no-results" style="text-align: center; padding: 40px;">
						<p><?php echo cuhk_multilang_text("沒有找到相片集", "", "No galleries found"); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

	function galleryFilter() {
		return {
			galleries: [],
			activeCategory: 'all',
			selectedYear: '',
			selectedYearText: '<?php echo cuhk_multilang_text("年份", "", "Year"); ?>',
			showYearDropdown: false,
			availableYears: [],
			loading: false,
			currentPage: 1,
			hasMore: true,

			init() {
				this.loadGalleries();
				this.loadAvailableYears();
			},

			async loadGalleries(page = 1, category = 'all', year = '', append = false) {
				this.loading = true;

				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'filter_galleries',
							nonce: '<?php echo wp_create_nonce('filter_galleries_nonce'); ?>',
							page: page,
							category: category,
							year: year
						})
					});

					const data = await response.json();
					if (data.success) {
						if (append) {
							const existing = this.galleries.map(g => ({
								...g,
								_isNew: false
							}));
							this.galleries = [...existing, ...data.data.galleries];
						} else {
							this.galleries = data.data.galleries;
						}
						this.hasMore = data.data.has_more;
						this.currentPage = page;
					}
				} catch (error) {
					console.error('Error loading galleries:', error);
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

			async loadAvailableYears() {
				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'get_gallery_years',
							nonce: '<?php echo wp_create_nonce('get_gallery_years_nonce'); ?>'
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
				this.loadGalleries(1, category, this.selectedYear, false);
			},

			filterByYear(year) {
				this.selectedYear = year;
				this.selectedYearText = year || '<?php echo cuhk_multilang_text("年份", "", "Year"); ?>';
				this.showYearDropdown = false;
				this.currentPage = 1;
				this.loadGalleries(1, this.activeCategory, year, false);
			},

			toggleYearDropdown() {
				this.showYearDropdown = !this.showYearDropdown;
			},

			loadMore() {
				if (!this.hasMore || this.loading) return;
				this.loadGalleries(this.currentPage + 1, this.activeCategory, this.selectedYear, true);
			}
		}
	}
</script>

<?php get_footer(); ?>