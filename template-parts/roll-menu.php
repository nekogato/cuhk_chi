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

function get_ancestor_with_menu_repeater_id($repeater_field = 'top_level_menus_repeater') {
    global $post;

    if (!$post || !is_page()) {
        return false;
    }

    $parent_id = $post->post_parent;

    while ($parent_id) {
        // Check if the repeater field has rows
        if (have_rows($repeater_field, $parent_id)) {
            // Return translated ID if using Polylang
            return function_exists('pll_get_post') ? pll_get_post($parent_id) : $parent_id;
        }

        $parent = get_post($parent_id);
        $parent_id = $parent->post_parent;
    }

    return false;
}

$ancestor_id = get_ancestor_with_menu_repeater_id();

// Now use it
if (!empty($ancestor_id)) {
?>

<div class="sentinel"></div>
<div class="section roll_menu_section sticky_section scrollin scrollinopacity">
    <div class="roll_menu_inwrapper">
		<div class="roll_menu">
			<div class="roll_top_menu center_roll_top_menu text7">
				<div class="horizontal-scroll-wrapper">
					<div class="js-drag-scroll">
						<div class="scroll-inner">
							<?php 

							if ($ancestor_id && have_rows('top_level_menus_repeater', $ancestor_id)) {
								while (have_rows('top_level_menus_repeater', $ancestor_id)) {
									the_row();

									$page = get_sub_field('page');
									$show_dropdown = get_sub_field('show_child_as_dropdown');

									if (!$page) {
										continue;
									}

									$related_id = is_object($page) ? $page->ID : $page;

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

									$class = $is_active ? 'active' : '';

									// Add class if dropdown is enabled
									$slide_class = 'menu-item';
									if ($show_dropdown) {
										$slide_class .= ' has_dropdown';
									}

									echo '<div class="' . esc_attr($slide_class) . '">';
									echo '<div class="a_wrapper"><a href="' . esc_url(get_permalink($related_id)) . '" class="' . esc_attr($class) . '">';
									$page_title = get_field('page_title', $related_id);
									echo esc_html($page_title ? $page_title : get_the_title($related_id));
									echo '</a>';
									if ($show_dropdown) {
										echo '<span class="dropdown_arrow"></span>';
									};
									echo '</div>';

									// If show_child_as_dropdown is true, output direct children
									if ($show_dropdown) {
										$children = get_pages([
											'parent' => $related_id,
											'sort_column' => 'menu_order',
											'post_status' => 'publish'
										]);

										if (!empty($children)) {
											echo '<div class="swiper_dropdown">';
											foreach ($children as $child) {
												$page_title = get_field('page_title', $child->ID);
												$title_to_display = $page_title ? $page_title : get_the_title($child->ID);

												$is_selected = (get_the_ID() === $child->ID || in_array($child->ID, get_post_ancestors(get_the_ID()))) ? 'selected' : '';

												echo '<div><a href="' . esc_url(get_permalink($child->ID)) . '" class="' . esc_attr($is_selected) . '">';
												echo esc_html($title_to_display);
												echo '</a></div>';
											}
											echo '</div>';
										}
									}

									echo '</div>'; // close .swiper-slide
								}
							}
							
							?>
							
						</div>
					</div>
				</div>
			</div>

			<?php 
			$parent_id = wp_get_post_parent_id(get_the_ID());
			$current_id = get_the_ID();

			// Check if current page has children
			$children_query = new WP_Query([
				'post_type'      => 'page',
				'post_parent'    => $current_id,
				'posts_per_page' => 1,
				'post_status'    => 'publish',
				'lang'           => '', // empty means current Polylang language
			]);

			$has_children = $children_query->have_posts();
			wp_reset_postdata();

			if ($ancestor_id !== $parent_id || $has_children) {
			?>
			<div class="roll_bottom_menu text7">
				<div class="horizontal-scroll-wrapper">
					<div class="js-drag-scroll">
						<div class="scroll-inner">
							<?php


							if (!$parent_id || $has_children) {
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
									<div class="menu-item">
										<div class="a_wrapper"><a href="<?php the_permalink(); ?>" class="<?php echo $is_active; ?>"><?php the_title(); ?></a></div>
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
			<?php
			};
			?>
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
<div class="section roll_menu_section sticky_section scrollin scrollinopacity">
	<div class="roll_menu_inwrapper">
		<div class="roll_menu">
			<div class="roll_top_menu text7">
				<div class="scroll-inner">
					<div class="menu-item">
						<div class="a_wrapper"><a href="#" class="active"><?php echo get_the_title($parent_id); ?></a></div>
					</div>
				</div>
			</div>
			<div class="roll_bottom_menu text7">
				<div class="horizontal-scroll-wrapper">
					<div class="js-drag-scroll">
						<div class="scroll-inner">
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
									<div class="menu-item">
										<div class="a_wrapper"><a href="<?php the_permalink(); ?>" class="<?php echo $is_active; ?>"><?php the_title(); ?></a></div>
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
</div>

<?php }; ?>