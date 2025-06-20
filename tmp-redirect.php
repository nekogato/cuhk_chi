<?php
/*
Template Name: Redirect to First Child
*/

// Get the current page ID
$current_page_id = get_the_ID();

// Get child pages
$child_pages = get_children(array(
	'post_parent' => $current_page_id,
	'post_type' => 'page',
	'post_status' => 'publish',
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'numberposts' => 1
));

// If there are child pages, redirect to the first one
if (!empty($child_pages)) {
	$first_child = array_shift($child_pages);
	$redirect_url = get_permalink($first_child->ID);

	// Perform the redirect
	wp_redirect($redirect_url, 301);
	exit;
} else {
	// If no child pages exist, return 404
	status_header(404);
	global $wp_query;
	$wp_query->set_404();
	include(get_404_template());
	exit;
}
