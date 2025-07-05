<?php

/**
 * Template part for displaying the roll menu section
 *
 * @package cuhk_chi
 */

function is_descendant_of_study_page( $page_id = null ) {
	global $post;

    if (!$post || !is_page()) {
        return false;
    }

    // If no page ID is provided, use the current page ID
    if ( ! $page_id ) {
        $page_id = get_the_ID();
    }

    // Get the page with slug 'study'
    $study_page = get_page_by_path( 'study' );

    // Check if the study page exists
    if ( ! $study_page ) {
        return false;
    }

    // Get the ancestors of the current page
    $ancestors = get_ancestors( $page_id, 'page' );

    // Check if the study page ID is in the ancestors array
    return in_array( $study_page->ID, $ancestors );
}

// Now use it
if (is_descendant_of_study_page()) {

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
								'posts_per_page' => -1,
								'post_status' => 'publish'
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