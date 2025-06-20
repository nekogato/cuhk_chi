<?php
/*
Template Name: Redirect to First Child
*/

/**
 * Recursively find the final redirect destination
 * @param int $page_id The page ID to check
 * @param array $visited Array of visited page IDs to prevent infinite loops
 * @return string|false The final URL or false if no valid destination found
 */
function find_final_redirect_destination($page_id, $visited = array())
{
	// Prevent infinite loops
	if (in_array($page_id, $visited)) {
		return false;
	}

	// Add current page to visited array
	$visited[] = $page_id;

	// Check if current page uses redirect template
	$page_template = get_page_template_slug($page_id);

	// If not a redirect template, return this page's URL
	if ($page_template !== 'tmp-redirect.php') {
		return get_permalink($page_id);
	}

	// Get child pages of current page
	$child_pages = get_children(array(
		'post_parent' => $page_id,
		'post_type' => 'page',
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'numberposts' => 1
	));

	// If no child pages, return false
	if (empty($child_pages)) {
		return false;
	}

	// Get first child and recursively check it
	$first_child = array_shift($child_pages);
	return find_final_redirect_destination($first_child->ID, $visited);
}

// Get the current page ID
$current_page_id = get_the_ID();

// Find the final redirect destination
$final_url = find_final_redirect_destination($current_page_id);

// If we found a valid destination, redirect to it
if ($final_url) {
	wp_redirect($final_url, 301);
	exit;
} else {
	// If no valid destination found (no child pages or infinite loop detected), return 404
	status_header(404);
	global $wp_query;
	$wp_query->set_404();
	include(get_404_template());
	exit;
}
