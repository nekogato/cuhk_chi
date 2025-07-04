<?php /* Template Name: Research Project  */ ?>
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

<script>
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<?php get_template_part('template-parts/roll-menu'); ?>

<?php
// Get all unique funding years
$args = array(
	'post_type' => 'research_project',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'meta_key' => 'funding_end_year',
	'orderby' => 'meta_value_num',
	'order' => 'DESC',
	'fields' => 'ids',
	'post_status' => 'publish'
);
$query = new WP_Query($args);

$years = array();
$max_year = 0;

if ($query->have_posts()) :
	foreach ($query->posts as $post_id) :
		$year = get_field("funding_end_year", $post_id);
		// Validate year: must be 4-digit number between 1900-2100
		if ($year && is_numeric($year) && strlen($year) == 4 && $year >= 1900 && $year <= 2100 && !in_array($year, $years)) {
			$years[] = intval($year);
			if ($year > $max_year) {
				$max_year = $year;
			}
		}
	endforeach;
	wp_reset_postdata();

	// Sort years in descending order
	rsort($years);
	// Ensure all years are integers for JSON output
	$years = array_map('intval', $years);
endif;

// Get initial selected year
$initial_year = isset($_GET['active_year']) ? intval($_GET['active_year']) : $max_year;
?>

<div x-data="researchProjects(<?php echo json_encode($years); ?>, <?php echo $initial_year; ?>)">
	<?php
	while (have_posts()) :
		the_post();
	?>
		<div class="section top_photo_banner_section">
			<div class="section_center_content small_section_center_content">
				<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg4.jpg" class="ink_bg4 scrollin scrollinbottom" alt="Background">
				<div class="col_wrapper">
					<div class="flex row">
						<div class="col4 col">
							<div class="col_spacing scrollin scrollinbottom">
								<div class="text_wrapper vertical_text_wrapper">
									<div class="text vertical_text">
										<h1 class="project_title"><span><?php the_field("page_title"); ?></span></h1>
									</div>
								</div>
							</div>
						</div>
						<div class="col8 col">
							<div class="col_spacing scrollin scrollinbottom scrollin scrollinleft">
								<div class="swiper-container swiper photo_wrapper top_photo_slider">
									<div class="swiper-wrapper">
										<?php
										if (have_rows('page_banner_slider')):
											while (have_rows('page_banner_slider')) : the_row();
												$banner_image = get_sub_field('page_banner');
												$banner_caption = get_sub_field('page_banner_caption');
										?>
												<div class="swiper-slide">
													<div class="photo">
														<img src="<?php echo esc_url($banner_image['url']); ?>" alt="<?php echo esc_attr($banner_image['alt']); ?>">
													</div>
													<?php if ($banner_caption): ?>
														<div class="caption"><?php echo $banner_caption; ?></div>
													<?php endif; ?>
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
			</div>
		</div>

		<div class="section plain_text_section">
			<div class="section_center_content small_section_center_content">
				<div class="col_wrapper ">
					<div class="flex row">
						<div class="col6 col">
							<div class="col_spacing scrollin scrollinbottom scrollin scrollinbottom">
								<!-- introduction -->
								<div class="free_text">
									<?php echo get_field("introduction") ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="section year_list_section scrollin_p">
			<div class="year_list_slider_wrapper scrollin scrollinbottom">
				<div class="section_center_content small_section_center_content">
					<div class="year_list_slider_inwrapper">
						<div class="year_list_slider text3">
							<div class="swiper-container swiper year_list_slider">
								<div class="swiper-wrapper">
									<template x-for="year in years" :key="year">
										<div class="swiper-slide">
											<div>
												<a href="#"
													@click.prevent="filterByYear(year)"
													:class="{ 'active': activeYear === year }"
													x-text="year">
												</a>
											</div>
										</div>
									</template>
								</div>
							</div>
						</div>
					</div>
					<div class="prev_btn"></div>
					<div class="next_btn"></div>
				</div>
			</div>

			<div class="project_item_wrapper" x-show="!loading">
				<div class="">
					<div class="section_expandable_list">
						<template x-for="project in projects" :key="project.id">
							<div class="year-group" :data-year="activeYear">
								<div class="expandable_item scrollin scrollinbottom">
									<div class="section_center_content small_section_center_content">
										<div class="expandable_title">
											<div class="cat" x-text="project.funding_organization"></div>
											<div class="text5" x-text="`${project.project_title} (${project.funding_start_year}/${project.funding_end_year_short})`"></div>
											<div class="icon"></div>
										</div>
										<div class="hidden">
											<div class="hidden_content">
												<div class="table_flex_item_wrapper">
													<div class="table_flex_item" x-show="project.project_title">
														<div class="title text7"><?php echo cuhk_multilang_text("計劃名稱", "", "Project Name"); ?></div>
														<div class="text" x-text="project.project_title"></div>
													</div>
													<div class="table_flex_item" x-show="project.funding_end_year_short">
														<div class="title text7"><?php echo cuhk_multilang_text("撥款年份", "", "Funding Year"); ?></div>
														<div class="text" x-text="`${project.funding_start_year}/${project.funding_end_year_short}`"></div>
													</div>
												</div>

												<div class="table_flex_item_wrapper">
													<div class="table_flex_item" x-show="project.principal_investigator">
														<div class="title text7"><?php echo cuhk_multilang_text("計劃主持", "", "Principal Investigator"); ?></div>
														<div class="text" x-text="project.principal_investigator"></div>
													</div>
													<div class="table_flex_item" x-show="project.other_investigator">
														<div class="title text7"><?php echo cuhk_multilang_text("其他研究成員", "", "Other Investigator"); ?></div>
														<div class="text" x-text="project.other_investigator"></div>
													</div>
													<div class="table_flex_item" x-show="project.granted_amount">
														<div class="title text7"><?php echo cuhk_multilang_text("撥款金額", "", "Granted Amount"); ?></div>
														<div class="text" x-text="project.granted_amount"></div>
													</div>
													<div class="table_flex_item" x-show="project.funding_organization">
														<div class="title text7"><?php echo cuhk_multilang_text("撥款機構", "", "Funding Organization"); ?></div>
														<div class="text" x-text="project.funding_organization"></div>
													</div>
												</div>

												<div class="table_flex_item_wrapper">
													<div class="table_flex_item" x-show="project.description">
														<div class="title text7"><?php echo cuhk_multilang_text("計劃概述", "", "Description"); ?></div>
														<div class="text free_text" x-html="project.description"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</template>
					</div>
				</div>
			</div>

			<!-- Loading indicator -->
			<div class="project_item_wrapper" x-show="loading" x-cloak>
				<div class="section_center_content small_section_center_content">
					<div class="loading-indicator" style="text-align: center; padding: 40px;">
						<p><?php echo cuhk_multilang_text("載入計劃中...", "", "Loading projects..."); ?></p>
					</div>
				</div>
			</div>
		</div>

	<?php
	endwhile;
	?>
</div>

<script>
	function researchProjects(years, initialYear) {
		return {
			projects: [],
			years: years,
			activeYear: initialYear,
			loading: false,
			firstLoad: 0,

			init() {
				// Load initial projects for the default year
				this.loadProjects(this.activeYear);
			},

			async loadProjects(year) {
				this.loading = true;

				try {
					const response = await fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: new URLSearchParams({
							action: 'load_research_projects',
							nonce: '<?php echo wp_create_nonce('load_research_projects_nonce'); ?>',
							year: year
						})
					});

					const data = await response.json();
					if (data.success) {
						this.projects = data.data.projects;
						this.firstLoad++;
						console.log('firstLoad counter:', this.firstLoad);
						// Reinitialize jQuery expandable functionality after Alpine updates DOM
						this.$nextTick(() => {
							

							// Add animation classes after 100ms delay
							if (this.firstLoad > 1) {
								setTimeout(() => {
									doscroll();
									//$(".expandable_item.scrollin.scrollinbottom").addClass("onscreen startani");
								}, 100);
							}
						});
					}
				} catch (error) {
					console.error('Error loading projects:', error);
				} finally {
					this.loading = false;
					dosize();
					doscroll();
				}
			},

			filterByYear(year) {
				if (this.activeYear === year) return;
				this.activeYear = year;
				this.loadProjects(year);
			}
		}
	}
</script>

<?php
get_footer();
