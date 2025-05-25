<?php /* Template Name: About Contact */ ?>
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

<?php

while ( have_posts() ) :
    the_post();
?>

    <?php $contact_banner = get_field("contact_banner");
        echo $contact_banner ? '<div>'.esc_url($contact_banner['sizes']['xl']).'</div>' : '';
    ?>
    <?php if(get_field("contact_title")): ?>
        <div><?php the_field("contact_title"); ?></div>
    <?php endif; ?>
    <?php if(get_field("contact_description")): ?>
        <div><?php the_field("contact_description"); ?></div>
    <?php endif; ?>
    <?php if(get_field("map_latitude")): ?>
        <div><?php the_field("map_latitude"); ?></div>
    <?php endif; ?>
    <?php if(get_field("map_longitude")): ?>
        <div><?php the_field("map_longitude"); ?></div>
    <?php endif; ?>
    <?php if(get_field("map_zoom")): ?>
        <div><?php the_field("map_zoom"); ?></div>
    <?php endif; ?>
    <?php if(get_field("free_text")): ?>
        <div><?php the_field("free_text"); ?></div>
    <?php endif; ?>
    
<?php
endwhile; // End of the loop.
?>


<?php
get_footer();
