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
									<h1 class="project_title"><span><?php the_title(); ?></span></h1>
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
			<div class="col_wrapper">
				<div class="flex row">
					<div class="col6 col">
						<div class="col_spacing scrollin scrollinbottom">
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
								<?php
								// Get all unique funding years and max year
								$args = array(
									'post_type' => 'research_project',
									'post_status' => 'publish',
									'posts_per_page' => -1,
									'meta_key' => 'funding_end_year',
									'orderby' => 'meta_value_num',
									'order' => 'DESC',
									'fields' => 'ids'
								);
								$query = new WP_Query($args);

								$years = array();
								$max_year = 0;

								if ($query->have_posts()) :
									foreach ($query->posts as $post_id) :
										$year = get_field("funding_end_year", $post_id);
										if ($year && !in_array($year, $years)) {
											$years[] = $year;
											if ($year > $max_year) {
												$max_year = $year;
											}
										}
									endforeach;
									wp_reset_postdata();

									// Sort years in descending order
									rsort($years);

									// Get selected year from GET parameter or use max year
									$selected_year = isset($_GET['year']) ? intval($_GET['year']) : $max_year;

									// Output year slider items
									foreach ($years as $year) :
								?>
										<div class="swiper-slide">
											<div><a href="?year=<?php echo $year; ?>" <?php echo $year === $selected_year ? 'class="active"' : ''; ?>><?php echo $year; ?></a></div>
										</div>
								<?php
									endforeach;
								endif;
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="prev_btn"></div>
				<div class="next_btn"></div>
			</div>
		</div>

		<div class="project_item_wrapper">
			<div class="section_center_content small_section_center_content">
				<div class="section_expandable_list">
					<?php
					// Query projects for selected year
					$args = array(
						'post_type' => 'research_project',
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'meta_query' => array(
							array(
								'key' => 'funding_end_year',
								'value' => $selected_year,
								'compare' => '=',
								'type' => 'NUMERIC'
							)
						),
						'orderby' => 'title',
						'order' => 'ASC'
					);
					$query = new WP_Query($args);

					if ($query->have_posts()) :
						while ($query->have_posts()) : $query->the_post();
					?>
							<div class="year-group" data-year="<?php echo $selected_year; ?>">
								<div class="expandable_item scrollin scrollinbottom">
									<div class="section_center_content">
										<div class="expandable_title">
											<div class="cat"><?php echo get_field("funding_organization"); ?></div>
											<div class="text5"><?php echo get_field("project_title"); ?> (<?php echo get_field("funding_start_year"); ?>/<?php echo get_field("funding_end_year"); ?>)</div>
											<div class="icon"></div>
										</div>
										<div class="hidden">
											<div class="hidden_content">
												<div class="table_flex_item_wrapper">
													<div class="table_flex_item">
														<div class="title text7"><?php pll_e('計劃名稱'); ?></div>
														<div class="text"><?php echo get_field("project_title"); ?></div>
													</div>
													<div class="table_flex_item">
														<div class="title text7"><?php pll_e('撥款年份'); ?></div>
														<div class="text"><?php echo get_field("funding_start_year"); ?>/<?php echo get_field("funding_end_year"); ?></div>
													</div>
												</div>

												<div class="table_flex_item_wrapper">
													<div class="table_flex_item">
														<div class="title text7"><?php pll_e('計劃主持'); ?></div>
														<div class="text"><?php echo get_field("principal_investigator"); ?></div>
													</div>
													<div class="table_flex_item">
														<div class="title text7"><?php pll_e('其他研究成員'); ?></div>
														<div class="text"><?php echo get_field("other_investigator"); ?></div>
													</div>
													<div class="table_flex_item">
														<div class="title text7"><?php pll_e('撥款金額'); ?></div>
														<div class="text"><?php echo get_field("granted_amount"); ?></div>
													</div>
													<div class="table_flex_item">
														<div class="title text7"><?php pll_e('撥款機構'); ?></div>
														<div class="text"><?php echo get_field("funding_organization"); ?></div>
													</div>
												</div>

												<div class="table_flex_item_wrapper">
													<div class="table_flex_item">
														<div class="title text7"><?php pll_e('計劃概述'); ?></div>
														<div class="text free_text">
															<?php
															if (have_rows('flexible_content')):
																while (have_rows('flexible_content')) : the_row();
																	if (get_row_layout() == 'free_text'):
																		$freetext = get_sub_field("free_text");
																		if ($freetext):
																			echo $freetext;
																		endif;
																	endif;
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
					<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>
		</div>
	</div>

<?php
endwhile;
?>

<?php
get_footer();
