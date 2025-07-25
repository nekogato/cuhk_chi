<?php
/*
Template Name: Home Page
*/

get_header(); ?>

<div class="bg_video_wrapper">
	<video id="video1" src="<?php bloginfo('template_directory'); ?>/video/ink3.mp4" muted playsinline loop></video>
</div>

<div class="section home_top_section" id="section1">
	<div class="section_center_content full_section_center_content scrollin scrollinbottom">
		<h1 class="text text0 scrollin scrollinbottom">
			<?php
			$home_title = get_field('home_title');
			if ($home_title) {
				echo $home_title;
			}
			?>
			<div class="logo scrollin scrollinbottom">
				<?php
				$department_logo = get_field('department_logo');
				if ($department_logo) {
				?>
					<img src="<?php echo $department_logo["url"]; ?>" alt="<?php echo $department_logo['alt']; ?>">
				<?php
				};
				?>
			</div>
		</h1>
	</div>
</div>

<div class="section home_about_slider_section ">
	<div class="section_center_content small_section_center_content">
		<div class="col_wrapper scrollin_p">
			<div class="flex row">
				<div class="col2 col">
					<div class="col_spacing scrollin scrollinbottom">
						<div class="text_wrapper vertical_text_wrapper">
							<div class="text vertical_text">
								<h1 class="project_title"><span><?php
																$about_section_title = get_field('about_section_title');
																if ($about_section_title) {
																	echo $about_section_title;
																}
																?></span></h1>
							</div>
						</div>
					</div>
				</div>
				<div class="col10 col">
					<div class="col_spacing scrollin scrollinbottom">
						<div class="home_about_slider">
							<div class="swiper-container swiper">
								<div class="swiper-wrapper">
									<?php
									if (have_rows('about_slider')) :
										while (have_rows('about_slider')) : the_row();
											$slide_title = get_sub_field('slide_title');
											$slide_content = get_sub_field('slide_content');
											$slide_image = get_sub_field('slide_image');
											$slide_button_text = get_sub_field('slide_button_text');
											$slide_button_link = get_sub_field('slide_button_link');
											$slide_ink_image = get_sub_field('slide_ink_image');
											$buttons = get_sub_field('buttons');
									?>
											<div class="swiper-slide">
												<div class="col_wrapper ">
													<div class="flex row">
														<div class="col6 col">
															<div class="col_spacing ">
																<div class="text_wrapper">
																	<div class="text free_text text5">
																		<?php if ($slide_title) : ?>
																			<h4><?php echo $slide_title; ?></h4>
																		<?php endif; ?>
																		<?php if ($slide_content) : ?>
																			<?php echo $slide_content; ?>
																		<?php endif; ?>
																		<?php if ($slide_image) : ?>
																			<p><img src="<?php echo $slide_image['url']; ?>" alt="<?php echo $slide_image['alt']; ?>"></p>
																		<?php endif; ?>
																	</div>
																	<?php if ($buttons) : ?>
																		<div class="btn_wrapper text6">
																			<?php foreach ($buttons as $button) : ?>
																				<?php if ($button['link']) : ?>
																					<div>
																						<a href="<?php echo $button['link']['url']; ?>" class="<?php echo $button['style'] ?: 'round_btn'; ?>" <?php if ($button['link']['target']) echo 'target="' . $button['link']['target'] . '"'; ?>>
																							<?php echo $button['text']; ?>
																						</a>
																					</div>
																				<?php endif; ?>
																			<?php endforeach; ?>
																		</div>
																	<?php endif; ?>
																</div>
															</div>
														</div>
														<div class="col6 col">
															<div class="col_spacing ">
																<div class="ink_image scrollin scrollinbottom">
																	<?php if ($slide_ink_image) : ?>
																		<img src="<?php echo $slide_ink_image['url']; ?>" alt="<?php echo $slide_ink_image['alt']; ?>">
																	<?php else : ?>
																		<img src="<?php bloginfo('template_directory'); ?>/images/home_slider_ink1.png" alt="<?php echo cuhk_multilang_text("水墨設計", "水墨设计", "Ink Design"); ?>">
																	<?php endif; ?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
									<?php
										endwhile;
									endif;
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="nav_wrapper scrollin scrollinbottom">
				<div class="prev_btn"></div>
				<div class="next_btn"></div>
				<div class="dot_wrapper"></div>
			</div>
		</div>
	</div>
</div>


<div class="section home_news_section scrollin_p" x-data="homeNewsSlider()">
	<?php
	$news_args = array(
		'post_type' => array('news', 'event'),
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'start_date',
				'compare' => 'EXISTS'
			)
		),
		'orderby' => 'meta_value',
		'meta_key' => 'start_date',
		'order' => 'DESC',
		'post_status' => 'publish'
	);

	$news_query = new WP_Query($news_args);
	$available_months = array();

	if ($news_query->have_posts()) {
		while ($news_query->have_posts()) {
			$news_query->the_post();
			$start_date = get_field('start_date');
			if (!$start_date) continue;

			// Extract month and year from YYYYMMDD format
			$month = intval(substr($start_date, 4, 2));
			$year = intval(substr($start_date, 0, 4));
			$month_key = $year . str_pad($month, 2, '0', STR_PAD_LEFT);

			if (!isset($available_months[$month_key])) {
				$available_months[$month_key] = array(
					'value' => $month,
					'year' => $year,
					'chinese' => date('n月', mktime(0, 0, 0, $month, 1)),
					'english' => date('F', mktime(0, 0, 0, $month, 1))
				);
			}
		}
	}
	wp_reset_postdata();

	// Sort months in descending order
	krsort($available_months);
	?>
	<img src="<?php bloginfo('template_directory'); ?>/images/ink_bg7.jpg" class="ink_bg7 scrollin scrollinbottom">
	<div class="section_center_content small_section_center_content">
		<div class="text_wrapper vertical_text_wrapper">
			<div class="text vertical_text scrollin scrollinbottom">
				<h1 class="project_title"><span><?php
												$news_section_title = get_field('news_section_title');
												if ($news_section_title) {
													echo $news_section_title;
												}
												?></span></h1>
			</div>
		</div>
	</div>


	<div class="home_news_slider_wrapper">
		<div class="home_news_year_slider">
			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				<button class="prev_btn" @click="monthNextSlide()"></button>
				<div class="t_wrapper">
					<div class="t1 text4">
						<?php
						if (pll_current_language() == 'tc' || pll_current_language() == 'sc') {
						?>
							<span x-text="getCurrentMonth('tc')"></span>
						<?php
						} else {
						?>
							<span x-text="getCurrentMonth('en')"></span>
						<?php
						}
						?>
					</div>
					<div class="t2 text2" x-text="selectedYear"></div>
				</div>
				<button class="next_btn" @click="monthPreviousSlide()"></button>

				<!-- <div class="swiper-container swiper">
					<div class="swiper-wrapper">
						<template x-for="(month, index) in availableMonths" :key="index">
							<div class="swiper-slide"
								:class="{ 'active': selectedMonth === month.value && selectedYear === month.year }">
								<div class="t_wrapper">
									<div class="t1 text4">
										
										<?php
										if (pll_current_language() == 'tc' || pll_current_language() == 'tc') {
										?>
												<span x-text="month.chinese"></span>
												<?php
											} else {
												?>
												<span x-text="month.english"></span>
												<?php
											}
												?>
									</div>
									<div class="t2 text2" x-text="month.year"></div>
								</div>
							</div>
						</template>

						
					</div>
				</div>

				<div class="prev_btn" @click="monthPreviousSlide()"></div>
				<div class="next_btn" @click="monthNextSlide()"></div> -->
			</div>

			<div class="all_news_btn_wrapper">
				<a href="<?php echo pll_get_page_url("news-and-events/events/"); ?>" class="round_btn"><?php echo cuhk_multilang_text("查閲最新動態", "", "View All Updates"); ?></a>
			</div>
		</div>
		
		<div class="home_news_date_slider_wrapper_wrapper">
		<!-- Loading indicator -->
			<div class="home_news_loading " :class="loading?'active':''">
				<div class="section_center_content small_section_center_content">
					<div class="date text4"><?php echo cuhk_multilang_text("載入中...", "载入中...", "Loading..."); ?></div>
					<div class="news_item_wrapper">
						<div class="news_item">
							<div class="news_item_spacing">
								<div class="text"><?php echo cuhk_multilang_text("正在載入消息...", "正在载入消息...", "Loading news..."); ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="home_news_date_slider_wrapper show">
				<div class="section_center_content small_section_center_content scrollin scrollinbottom">


					<div class="home_news_date_slider_inwrapper">
						<div class="home_news_date_slider">
							<div class="swiper-container swiper">
								<div class="swiper-wrapper">
									<!-- News slides - Each date is one slide -->
									<template x-for="(dateGroup, dateKey) in groupedNews" :key="dateKey">
										<div class="swiper-slide">
											<div class="date text4" x-html="formatDate(dateKey)"></div>
											<div class="news_item_wrapper">
												<template x-for="(newsItem, index) in dateGroup" :key="newsItem.id">
													<div class="news_item">
														<div class="news_item_spacing">
															<a :href="newsItem.link">
																<img :src="newsItem.image" :alt="newsItem.title">
																<div class="text" x-text="newsItem.title"></div>
															</a>
														</div>
													</div>
												</template>
											</div>
										</div>
									</template>

									<!-- No news message -->
									<template x-if="Object.keys(groupedNews).length === 0 && !loading">
										<div class="swiper-slide">
											<div class="date text4"><?php echo cuhk_multilang_text("暫無消息", "暂无消息", "No News"); ?></div>
											<div class="news_item_wrapper">
												<div class="news_item">
													<div class="news_item_spacing">
														<div class="text"><?php echo cuhk_multilang_text("本月暫無消息", "本月暂无消息", "No news this month"); ?></div>
													</div>
												</div>
											</div>
										</div>
									</template>
								</div>
							</div>
							<div class="prev_btn" @click="datePreviousSlide()"></div>
							<div class="next_btn" @click="dateNextSlide()"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<script>
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

	function homeNewsSlider() {
		return {
			selectedMonth: null, // Current month
			selectedYear: null, // Current year
			groupedNews: {},
			loading: false,
			yearSwiper: null,
			dateSwiper: null,
			availableMonths: <?php echo json_encode(array_values($available_months)); ?>,

			init() {
				this.selectedMonth = this.availableMonths[0].value;
				this.selectedYear = this.availableMonths[0].year;

				this.$nextTick(() => {
					this.initSwipers();
					this.loadNews();
				});
			},

			getCurrentMonth(lang) {

				const selectMonthObj = this.availableMonths.find(month => month.value == this.selectedMonth);
				if (lang == 'tc' || lang == 'sc') {
					return selectMonthObj.chinese;
				} else {
					return selectMonthObj.english;
				}
			},

			getCurrentYear() {

				return this.selectedMonth;
			},

			initSwipers() {
				// Initialize year slider
				/*
				this.yearSwiper = new Swiper('.home_news_year_slider .swiper-container', {
					effect : 'fade',
					fadeEffect: {
						crossFade: true,
					},
					autoplay: false,
					slidesPerView: 1,
					speed: 400,
					loop: false,
					spaceBetween: 100,
					on: {
						slideChange: () => {
							const activeSlide = this.yearSwiper.slides[this.yearSwiper.activeIndex];
							const monthData = this.availableMonths[this.yearSwiper.activeIndex];
							if (monthData) {
								this.selectMonth(monthData.value, monthData.year);
							}
						}
					}
				});*/

				// Initialize date slider
				this.dateSwiper = new Swiper('.home_news_date_slider .swiper-container', {
					autoplay: false,
					slidesPerView: 'auto',
					// freeMode: true,
					speed: 1600,
					loop: false,
					spaceBetween: 0,
					navigation: {
						nextEl: '.home_news_date_slider .next_btn',
						prevEl: '.home_news_date_slider .prev_btn',
					},
					on: {
						init: () => {
							dosize();
						}
					}
				});
			},

			formatDate(dateString) {
				// Parse YYYYMMDD format
				const year = dateString.substring(0, 4);
				const month = dateString.substring(4, 6);
				const day = parseInt(dateString.substring(6, 8));
				const date = new Date(year, month - 1, day);
				<?php if (pll_current_language() == 'tc' || pll_current_language() == 'sc') { ?>
					const days = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
				<?php } else { ?>
					const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
				<?php } ?>
				const dayName = days[date.getDay()];

				<?php if (pll_current_language() == 'tc' || pll_current_language() == 'sc') { ?>
					const formatter = new Intl.DateTimeFormat('zh-CN', {
					month: 'numeric',
					day: 'numeric'
					});
					let outputDate = formatter.format(date);
					outputDate = outputDate.replace(/\//g, '月').replace(/\s/g, '') + '日';
				<?php } else { ?>
					const outputDate = new Intl.DateTimeFormat('en-US', {
					month: 'short',
					day: 'numeric'
					}).format(date).toUpperCase().replace(',', '');
				<?php } ?>
				
				return `<div class='day'>${outputDate}</div><div class='dayName'>${dayName}</div>`;
			},

			async loadNews() {
				$(".home_news_loading").height($(".home_news_date_slider_inwrapper").outerHeight())
				$(".home_news_date_slider_wrapper").addClass("home_news_date_slider_wrapper_loading");
				$(".home_news_date_slider_wrapper").removeClass("show");
				$(".home_news_date_slider").height($(".home_news_date_slider_inwrapper").height())
				this.loading = true;
				
				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'load_home_news',
							nonce: '<?php echo wp_create_nonce('load_home_news_nonce'); ?>',
							month: this.selectedMonth,
							year: this.selectedYear
						})
					});

					const data = await response.json();
					if (data.success) {
						this.groupedNews = data.data.grouped_news;

						// Destroy existing swiper
						if (this.dateSwiper) {
							this.dateSwiper.destroy();
							this.dateSwiper = null;
						}
					}
				} catch (error) {
					console.error('Error loading news:', error);
				} finally {
					this.loading = false;

					this.$nextTick(async () => {
						// Wait until .swiper-container is in the DOM
						let container;
						while (!(container = document.querySelector('.home_news_date_slider .swiper-container'))) {
							await new Promise(resolve => requestAnimationFrame(resolve));
						}

						// Wait for Alpine transition (if any)
						await new Promise(resolve => requestAnimationFrame(resolve));

						// Wait for all images in container to load
						const images = container.querySelectorAll('img');
						await Promise.all(Array.from(images).map(img => {
							if (img.complete) return Promise.resolve();
							return new Promise(resolve => {
								img.addEventListener('load', resolve, { once: true });
								img.addEventListener('error', resolve, { once: true });
							});
						}));

						// Resize layout after Swiper initializes
						dosize();
						doscroll();

						// Initialize Swiper
						var swiper = this.dateSwiper
						swiper = new Swiper('.home_news_date_slider .swiper-container', {
							autoplay: false,
							slidesPerView: 'auto',
							// freeMode: true,
							speed: 1600,
							loop: false,
							spaceBetween: 0,
							navigation: {
								nextEl: '.home_news_date_slider .next_btn',
								prevEl: '.home_news_date_slider .prev_btn',
							},
							on: {
								init: () => {
									dosize();
									doscroll();
									setTimeout(function(){
										$(".home_news_date_slider").height("auto");
										$(".home_news_date_slider_wrapper").removeClass("home_news_date_slider_wrapper_loading");
										$(".home_news_date_slider_wrapper").addClass("show");
										swiper.update();
									},0);
								}
							}
						});

						// Resize layout after Swiper initializes
						dosize();
						doscroll();
					});
				}
			},

			selectMonth(month, year) {
				if (this.selectedMonth === month && this.selectedYear === year) return;
				this.selectedMonth = month;
				this.selectedYear = year;
				this.loadNews();
			},

			dateNextSlide() {
				if (this.dateSwiper) {
					this.dateSwiper.slideNext();
				}
			},

			datePreviousSlide() {
				if (this.dateSwiper) {
					this.dateSwiper.slidePrev();
				}
			},

			monthNextSlide() {
				const currentIndex = this.availableMonths.findIndex(month => month.value == this.selectedMonth);
				if (currentIndex < this.availableMonths.length - 1) {
					this.selectedMonth = this.availableMonths[currentIndex + 1].value;
					this.selectedYear = this.availableMonths[currentIndex + 1].year;
					this.loadNews();
				}
			},

			monthPreviousSlide() {
				const currentIndex = this.availableMonths.findIndex(month => month.value == this.selectedMonth);
				if (currentIndex > 0) {
					this.selectedMonth = this.availableMonths[currentIndex - 1].value;
					this.selectedYear = this.availableMonths[currentIndex - 1].year;
					this.loadNews();
				}
			}
		}
	}
</script>

<!-- Promotion Highlight Section with ACF Integration -->
<div class="section home_promotion_section scrollin_p">
	<div class="ink_bg9_wrapper">
		<img src="<?php bloginfo('template_directory'); ?>/images/ink_bg9.jpg" class="ink_bg9 scrollin scrollinbottom" alt="<?php echo cuhk_multilang_text("水墨背景", "", "Ink Background"); ?>">
	</div>
	<?php
	$promotion_title = get_field('promotion_section_title');
	if ($promotion_title) :
	?>
		<div class="home_promotion_section_title">
			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				<h1><?php echo $promotion_title; ?></h1>
			</div>
		</div>
	<?php endif; ?>
	<div class="home_promotion_box_wrapper">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<div class="home_promotion_box_inwrapper">
				<?php
				if (have_rows('promotion_highlights')) :
					$counter = 1;
					while (have_rows('promotion_highlights')) : the_row();
						$title = get_sub_field('title');
						$image = get_sub_field('image');
						$description = get_sub_field('description');
						$buttons = get_sub_field('buttons');
						$is_active = ($counter === 1) ? 'active anim_in' : '';
				?>
						<div class="home_promotion_box <?php echo $is_active; ?>">
							<div class="title">
								<div class="rotate_text_wrapper">
									<h3><span><?php echo $title; ?></span></h3>
								</div>
							</div>
							<div class="hidden_wrapper">
								<div class="hidden">
									<div class="hidden_content">
										<div class="col_wrapper ">
											<div class="flex row">
												<div class="col6 col">
													<div class="col_spacing <?php echo $counter === 1 ? 'scrollin scrollinbottom' : ''; ?>">
														<div class="image_wrapper">
															<?php if ($image) : ?>
																<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
															<?php endif; ?>
														</div>
													</div>
												</div>
												<div class="col6 col">
													<div class="col_spacing">
														<div class="t_wrapper">
															<div class="t t1 text4"><?php echo $title; ?></div>
															<div class="t t2 free_text">
																<?php echo $description; ?>
															</div>
															<?php if ($buttons) : ?>
																<div class="btn_wrapper text6">
																	<?php foreach ($buttons as $button) : ?>
																		<?php if ($button['link']) : ?>
																			<div>
																				<a href="<?php echo $button['link']['url']; ?>" class="<?php echo $button['style'] ?: 'round_btn'; ?>" <?php if ($button['link']['target']) echo 'target="' . $button['link']['target'] . '"'; ?>>
																					<?php echo $button['text']; ?>
																				</a>
																			</div>
																		<?php endif; ?>
																	<?php endforeach; ?>
																</div>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="big_num text2"><?php echo sprintf('%02d', $counter); ?></div>
							</div>
						</div>
				<?php
						$counter++;
					endwhile;
				endif;
				?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>