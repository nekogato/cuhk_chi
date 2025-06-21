<?php

/**
 * Template part for displaying the roll menu section
 *
 * @package cuhk_chi
 */

function get_ancestor_with_menu_field_id($relationship_field = 'top_level_menus') {
    global $post;

    if (!$post || !is_page()) {
        return false;
    }

    $parent_id = $post->post_parent;

    while ($parent_id) {
        $related_pages = get_field($relationship_field, $parent_id);

        if (!empty($related_pages) && is_array($related_pages)) {
            // Return the translated ID (if Polylang is active)
            return function_exists('pll_get_post') ? pll_get_post($parent_id) : $parent_id;
        }

        $parent = get_post($parent_id);
        $parent_id = $parent->post_parent;
    }

    return false;
}

$ancestor_id = get_ancestor_with_menu_field_id();

// Now use it
if (!empty($ancestor_id)) {
?>

<div class="sentinel"></div>
<div class="section roll_menu_section sticky_section">
	<div class="roll_menu scrollin scrollinbottom">
		<div class="roll_top_menu text7">
			<div class="section_center_content">
				<div class="swiper-container swiper">
					<div class="swiper-wrapper">
						<?php 

						$related_pages = get_field('top_level_menus', $ancestor_id);

						if (!empty($related_pages) && is_array($related_pages)) {
							foreach ($related_pages as $related_page) {
								$related_id = is_object($related_page) ? $related_page->ID : $related_page;

								// Determine if current page is the related page or its descendant
								$is_active = false;
								if (get_the_ID() === $related_id) {
									$is_active = true;
								} else {
									$ancestors = get_post_ancestors(get_the_ID());
									if (in_array($related_id, $ancestors)) {
										$is_active = true;
									}
								}

								// Build class string
								$class = $is_active ? 'active' : '';

								// Output HTML
								echo '<div class="swiper-slide">';
								echo '<div><a href="' . esc_url(get_permalink($related_id)) . '" class="' . esc_attr($class) . '">';
								$page_title = get_field('page_title', $related_id);
								echo esc_html($page_title ? $page_title : get_the_title($related_id));
								echo '</a></div>';
								echo '</div>';
							}
						}
						
						?>
						
					</div>
				</div>
			</div>
		</div>
		<div class="roll_bottom_menu text7">
			<div class="section_center_content">
				<div class="swiper-container swiper">
					<div class="swiper-wrapper">
						<?php

						$parent_id = wp_get_post_parent_id(get_the_ID());
						$current_id = get_the_ID();

						// If no parent found, use current page as parent
						if (!$parent_id) {
							$parent_id = $current_id;
						}

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
								if(!get_field("hide_in_submenu")){
						?>
								<div class="swiper-slide">
									<div><a href="<?php the_permalink(); ?>" class="<?php echo $is_active; ?>"><?php the_title(); ?></a></div>
								</div>
						<?php

								};
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

<?php
}else{

$target_page = $args['target_page'] ?? '';


if ($target_page) {
	// Get the page by slug
	$page = get_page_by_path($target_page);
	if ($page) {
		$parent_id = $page->post_parent;
		$current_id = $page->ID;
	} else {
		// If page not found, fallback to current page
		$parent_id = wp_get_post_parent_id(get_the_ID());
		$current_id = get_the_ID();
	}
} else {
	$parent_id = wp_get_post_parent_id(get_the_ID());
	$current_id = get_the_ID();
}

// If no parent found, use current page as parent
if (!$parent_id) {
	$parent_id = $current_id;
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
								if(!get_field("hide_in_submenu")){
						?>
								<div class="swiper-slide">
									<div><a href="<?php the_permalink(); ?>" class="<?php echo $is_active; ?>"><?php the_title(); ?></a></div>
								</div>
						<?php

								};
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

<?php }; ?>