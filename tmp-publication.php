<?php /* Template Name: Publication  */ ?>
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
	$page_title = get_field("page_title");
	$page_description = get_field("introduction");
?>

	<div>

		<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg5.jpg" class="ink_bg5 scrollin scrollinbottom" alt="Background Image">
		<div class="section section_content filter_menu_section">
			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				
				<?php if ($page_title) : ?>
					<h1 class="section_title text1 scrollin scrollinbottom"><?php echo ($page_title); ?></h1>
				<?php endif; ?>
				<?php if ($page_description) : ?>
					<div class="section_description scrollin scrollinbottom col6"><?php echo ($page_description); ?></div>
				<?php endif; ?>
			</div>

			<?php
			// Get publication categories
			$publication_categories = get_terms(array(
				'taxonomy' => 'publication_category',
				'hide_empty' => true,
				'orderby' => 'name',
				'order' => 'ASC'
			));
			?>

			<?php if (!empty($publication_categories)) : ?>
				<div class="filter_menu_wrapper">
					<div class="filter_menu filter_menu_no_flex">
						<div class="section_center_content small_section_center_content scrollin scrollinbottom">
							<div class="filter_menu_content full_filter_menu_content">
								<div class="alphabet_list_wrapper big_alphabet_list_wrapper">
									<?php if (!empty($publication_categories) && !is_wp_error($publication_categories)) : ?>
									<ul class="alphabet_list">
										<?php foreach ($publication_categories as $term): ?>
											<li>
												<a class="publication_filter_btn" data-link="<?php echo esc_attr($term->slug); ?>">
												<?php
													$lang = pll_current_language();
													$ctermfullname = get_field("{$lang}_name", 'publication_category_' . $term->term_id);
													echo esc_html($ctermfullname);
												?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<div class="section section_content filter_result_section">

			<div class="section_center_content small_section_center_content">
				
			<?php

			// Check if categories exist and are not an error
			if (!empty($publication_categories) && !is_wp_error($publication_categories)) {
				// Loop through each category
				foreach ($publication_categories as $category) {
					// Set up WP_Query arguments for the current category
					$lang = pll_current_language();
					$ctermfullname = get_field("{$lang}_name", 'publication_category_' . $category->term_id);
					$ctermslug = $category->slug;
					$args = [
						'post_type' => 'publication', // Replace with your actual post type
						'posts_per_page' => -1, // Get all posts; adjust as needed
						'tax_query' => [
							[
								'taxonomy' => 'publication_category',
								'field' => 'slug',
								'terms' => $category->slug,
							],
						],
					];

					// Create a new WP_Query instance
					$query = new WP_Query($args);

					// Check if the query has posts
					if ($query->have_posts()) {
						?>
						<div class="publication_box_list_wrapper scrollin scrollinbottom" data-id="<?php echo $ctermslug; ?>">
							<div class="publication_box_list_title text3">
								<?php echo esc_html($ctermfullname); ?>
							</div>
							<div class="publication_box_list">
								<?php 
								// Loop through posts
								while ($query->have_posts()) {
									$query->the_post();
									$coverimage = get_field("cover_photo");
									$title = get_field("title");
									$author = get_field("author");
									$chief_editor = get_field("chief_editor");
									$publisher = get_field("publisher");
									$publish_year = get_field("year_and_month_of_publication");
									?>
									<div class="publication_box ">
										<?php if($coverimage){?>
										<div class="publication_thumb">
											<div class="thumb">
												<a href="<?php the_permalink(); ?>">
													<img src="<?php echo $coverimage["url"]; ?>" alt="<?php echo $coverimage["alt"]; ?>">
												</a>
											</div>
										</div>
										<?php }; ?>
										<div class="publication_text">
											<div class="publication_text_item text6 book_name">
												<?php echo $title; ?>
											</div>
											<?php if($author){?>
												<div class="publication_text_item">
													<div class="title text7">
														<?php echo cuhk_multilang_text("作者", "", "Author"); ?>
													</div>
													<div class="text"><?php echo $author; ?></div>
												</div>
											<?php }; ?>
											<?php if(!$author && $chief_editor){?>
												<div class="publication_text_item">
													<div class="title text7"><?php echo cuhk_multilang_text("主編", "", "Chief Editor"); ?></div>
													<div class="text "><?php echo $chief_editor; ?></div>
												</div>
											<?php }; ?>
											<?php if($publisher){?>
												<div class="publication_text_item">
													<div class="title text7"><?php echo cuhk_multilang_text("出版商", "", "Publisher"); ?></div>
													<div class="text "><?php echo $publisher; ?></div>
												</div>
											<?php }; ?>
											<?php if($publish_year){?>
												<div class="publication_text_item">
													<div class="title text7"><?php echo cuhk_multilang_text("出版年份", "", "Publication Year"); ?></div>
													<div class="text "><?php echo $publish_year; ?></div>
												</div>
											<?php }; ?>
										</div>
									</div>
									<?php
								};
								?>
							</div>
						</div>
						<?php
						// Reset post data to prevent conflicts
						wp_reset_postdata();
					}
				}
			} else {
				// Handle case where no categories are found or there's an error
				echo '<p>No publication categories found.</p>';
			}
			?>
				
			</div>
		</div>

	</div>

<?php
endwhile;
?>


<?php
get_footer();
