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
	'meta_key' => 'funding_start_year',
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
		$year = get_field("funding_start_year", $post_id);
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
		<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg4.jpg" class="ink_bg4 scrollin scrollinbottom" alt="Background">

		<div class="section section_content">
			<div class="section_center_content small_section_center_content">
				<h1 class="section_title text1 scrollin scrollinbottom"><?php the_field("page_title"); ?></h1>
				<?php if (get_field('introduction')): ?>
					<div class="section_description scrollin scrollinbottom col6 free_text"><?php the_field('introduction'); ?></div>
				<?php endif; ?>
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
										<div class="col10 center_content">
											<div class="expandable_title">
												<div class="cat"><?php echo cuhk_multilang_text("", "", "Funded by "); ?><span x-text="project.category_name"></span><?php echo cuhk_multilang_text("", "", ""); ?></div>
												<div class="text5" x-html="`${project.project_title} (${project.funding_start_year}/${project.funding_end_year_short})`"></div>
												<div class="icon"></div>
											</div>
											<div class="hidden">
												<div class="hidden_content">
													<div class="table_flex_item_wrapper table_flex_item_wrapper2">
														<div class="table_flex_item" x-show="project.project_title">
															<div class="title text6"><?php echo cuhk_multilang_text("計劃名稱", "", "Project Name"); ?></div>
															<div class="text" x-html="project.project_title"></div>
														</div>
														<div class="table_flex_item" x-show="project.funding_end_year_short">
															<div class="title text6"><?php echo cuhk_multilang_text("撥款年份", "", "Funding Year"); ?></div>
															<div class="text" x-html="`${project.funding_start_year}/${project.funding_end_year_short}`"></div>
														</div>
														<div class="table_flex_item" x-show="project.principal_investigator">
															<div class="title text6"><?php echo cuhk_multilang_text("計劃主持", "", "Principal Investigator"); ?></div>
															<div class="text" x-html="project.principal_investigator"></div>
														</div>
														<div class="table_flex_item" x-show="project.other_investigator">
															<div class="title text6"><?php echo cuhk_multilang_text("其他研究成員", "", "Other Investigator"); ?></div>
															<div class="text" x-html="project.other_investigator"></div>
														</div>
														<div class="table_flex_item" x-show="project.granted_amount">
															<div class="title text6"><?php echo cuhk_multilang_text("撥款金額", "", "Granted Amount"); ?></div>
															<div class="text" x-html="project.granted_amount"></div>
														</div>
														<div class="table_flex_item" x-show="project.funding_organization">
															<div class="title text6"><?php echo cuhk_multilang_text("撥款機構", "", "Funding Organization"); ?></div>
															<div class="text" x-html="project.funding_organization"></div>
														</div>
													</div>

													<div class="table_flex_item_wrapper">
														<div class="table_flex_item" x-show="project.description">
															<div class="title text6"><?php echo cuhk_multilang_text("計劃概述", "", "Description"); ?></div>
															<div class="text free_text" x-html="project.description"></div>
														</div>
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
	function getCurrentLangFromBody() {
		// Map your body classes to the *Polylang* language slugs you use in WP
		// Adjust the right-hand side if your PLL slugs are different (e.g. "zh-tw"/"zh-cn")
		const map = {
		'tc_body': 'tc',
		'sc_body': 'sc',
		'en_body': 'en'
		};

		const cls = document.body.classList;
		if (cls.contains('tc_body')) return map['tc_body'];
		if (cls.contains('sc_body')) return map['sc_body'];
		if (cls.contains('en_body')) return map['en_body'];

		// Fallback (choose one that makes sense for you)
		return 'en';
	}

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
							year: year,
							lang: getCurrentLangFromBody()
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
									dosize();
									doscroll();
									//$(".expandable_item.scrollin.scrollinbottom").addClass("onscreen startani");
								}, 300);
							}
						});
					}
				} catch (error) {
					console.error('Error loading projects:', error);
				} finally {
					this.loading = false;
					dosize();
					doscroll();
					this.$nextTick(async () => {
						setTimeout(() => {
							dosize();
							doscroll();
						}, 300);
					});
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
