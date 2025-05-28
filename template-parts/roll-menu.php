<?php

/**
 * Template part for displaying the roll menu section
 *
 * @package cuhk_chi
 */

$args = get_query_var('args');
$target_page = $args['target_page'] ?? '';

if ($target_page) {
	// Get the page by slug
	$page = get_page_by_path($target_page);
	if ($page) {
		$parent_id = $page->post_parent;
		$current_id = $page->ID;
	}
} else {
	$parent_id = wp_get_post_parent_id(get_the_ID());
	$current_id = get_the_ID();
}
?>

<div class="sentinel"></div>
<div class="section roll_menu_section sticky_section">
	<div class="roll_menu scrollin scrollinbottom">
		<div class="roll_top_menu text7">
			<div class="section_center_content">
				<div class="swiper-container swiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div><a href="#" class="active"><?php echo get_the_title($parent_id); ?></a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="roll_bottom_menu text7">
			<div class="section_center_content">
				<div class="swiper-container swiper">
					<div class="swiper-wrapper">
						<?php
						$args = array(
							'post_type' => 'page',
							'post_parent' => $parent_id,
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'posts_per_page' => -1
						);
						$child_pages = new WP_Query($args);

						if ($child_pages->have_posts()) :
							while ($child_pages->have_posts()) : $child_pages->the_post();
								$is_active = (get_the_ID() === $current_id) ? 'active' : '';
						?>
								<div class="swiper-slide">
									<div><a href="<?php the_permalink(); ?>" class="<?php echo $is_active; ?>"><?php the_title(); ?></a></div>
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
	</div>
</div>