<?php /* Template Name: Administrative Staff */ ?>
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

<div class="section section_content">
	<div class="section_center_content small_section_center_content">
		<div class="col10 center_content">
			<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
			<div class="section_description scrollin scrollinbottom col6"><?php the_field('introduction') ?></div>
			
			<!-- <div class="filter_menu_wrapper">
				<div class="filter_menu filter_menu_left_bg filter_menu_bottom  scrollin scrollinbottom ">
					<div class="filter_remark"><?php echo cuhk_multilang_text("按姓名繁體筆劃排序", "按姓名拼音排序", "In alphabetical order"); ?></div>
				</div>
			</div> -->

			<div class="section_list scrollin scrollinbottom">
				<?php
				$args = array(
					'post_type' => 'profile',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'tax_query' => array(
						array(
							'taxonomy' => 'people_category',
							'field' => 'term_id',
							'terms' => get_field('target_people_category')
						)
					)
				);

				// // Change ordering based on current language
				// if (function_exists('pll_current_language')) {
				// 	$current_lang = pll_current_language();

				// 	if ($current_lang == 'tc') {
				// 		// Order by number of strokes (numeric)
				// 		$args['meta_key'] = 'strokes';
				// 		$args['orderby'] = 'meta_value_num';
				// 	} elseif ($current_lang == 'sc') {
				// 		// Order by pinyin (text)
				// 		$args['meta_key'] = 'pinyin';
				// 		$args['orderby'] = 'meta_value';
				// 	} else {
				// 		// Order by English name (text)
				// 		$args['meta_key'] = 'english_name';
				// 		$args['orderby'] = 'meta_value';
				// 	}
				// } else {
				// 	// Fallback to ordering by title if Polylang not available
				// 	$args['orderby'] = 'title';
				// }
				
				$query = new WP_Query($args);

				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
						$title = get_field('position');
						$name = get_the_title();
						$has_detail = get_field('has_detail');
						$emails = get_field('email');
						$email_addresses = array();
						if ($emails) {
							foreach ($emails as $email) {
								$email_addresses[] = $email['email'];
							}
						}
						$phones = get_field('phone');
						$phone_numbers = array();
						if ($phones) {
							foreach ($phones as $phone) {
								$phone_numbers[] = $phone['phone'];
							}
						}
						$phone_display = $phone_numbers ? '(+852) ' . implode(' / ', $phone_numbers) : '';
				?>
						<div class="list_item_row ">
							<div class="list_item_col col3">
								<div><?php echo esc_html($title); ?></div>
							</div>
							<div class="list_item_col text_c1 col3 text5">
								<div>
									<?php if ($has_detail): ?>
										<a href="<?php the_permalink(); ?>"><?php echo esc_html($name); ?></a>
									<?php else: ?>
										<?php echo esc_html($name); ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="list_item_col col6">
								<?php if ($email_addresses): ?>
								<div class="inner_list_item_col <?php echo !empty($phone_display) ? 'col6' : 'col12 right_text'; ?>">
									<div>
										<?php
										if ($email_addresses):
											$email_links = array();
											foreach ($email_addresses as $email) {
												$email_links[] = '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
											}
											echo implode(' / ', $email_links);
										endif;
										?>
									</div>
								</div>
								<?php endif; ?>
								<?php if ($phone_display): ?>
								<div class="inner_list_item_col <?php echo !empty($email_addresses) ? 'col6' : 'col12 right_text'; ?>">
									<div><?php echo esc_html($phone_display); ?></div>
								</div>
								<?php endif; ?>
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
get_footer();
