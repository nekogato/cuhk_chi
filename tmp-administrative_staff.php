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
		<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
		<div class="section_description scrollin scrollinbottom col6"><?php the_field('introduction') ?></div>

		<div class="section_list">
			<?php
			$args = array(
				'post_type' => 'profile',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'people_category',
						'field' => 'term_id',
						'terms' => get_field('target_people_category')
					)
				)
			);
			$query = new WP_Query($args);

			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post();
					$title = get_field('position');
					$name = get_the_title();
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
							$phone_numbers[] = $phone['number'];
						}
					}
					$phone_display = $phone_numbers ? '(+852) ' . implode(' / ', $phone_numbers) : '';
			?>
					<div class="list_item_row scrollin scrollinbottom">
						<div class="list_item_col col2">
							<div><?php echo esc_html($title); ?></div>
						</div>
						<div class="list_item_col text_c1 col2 text5">
							<div><?php echo esc_html($name); ?></div>
						</div>
						<div class="list_item_col col8">
							<div class="inner_list_item_col col6">
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
							<div class="inner_list_item_col col6">
								<div><?php echo esc_html($phone_display); ?></div>
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

<?php
get_footer();
