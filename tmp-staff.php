<?php /* Template Name: Staff */ ?>
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
    			'post_status' => 'publish',
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
					$has_detail = get_field('has_detail');
					$emails = get_field('email');
					$email_addresses = array();
					if ($emails) {
						foreach ($emails as $email) {
							$email_addresses[] = $email['email'];
						}
					}
					$research_interests = get_field('research_interests');
			?>
					<div class="list_item_row scrollin scrollinbottom">
						<div class="list_item_col col2">
							<div><?php echo esc_html($title); ?></div>
						</div>
						<div class="list_item_col text_c1 col2 text5">
							<div>
								<?php if ($has_detail): ?>
									<a href="<?php the_permalink(); ?>"><?php echo esc_html($name); ?></a>
								<?php else: ?>
									<?php echo esc_html($name); ?>
								<?php endif; ?>
							</div>
						</div>
						<div class="list_item_col col8">
							<?php if ($email_addresses): ?>
							<div class="inner_list_item_col <?php echo !empty($research_interests) ? 'col6' : 'col12 right_text'; ?>">
								<div>
									<?php
									$email_links = array();
									foreach ($email_addresses as $email) {
										$email_links[] = '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
									}
									echo implode(' / ', $email_links);
									?>
								</div>
							</div>
							<?php endif; ?>
							<?php if ($research_interests): ?>
							<div class="inner_list_item_col <?php echo !empty($email_addresses) ? 'col6' : 'col12 right_text'; ?>">
								<div class="free_text">
									<?php echo wp_kses_post($research_interests); ?>
								</div>
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

<?php
get_footer();
