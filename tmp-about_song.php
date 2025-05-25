<?php /* Template Name: About Song */ ?>
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
    <?php $banner_image = get_field("banner_image");
        echo $banner_image ? '<div>'.esc_url($banner_image['sizes']['xl']).'</div>' : '';
    ?>
    <?php $song_thumb = get_field("song_thumb");
        echo $song_thumb ? '<div>'.esc_url($song_thumb['sizes']['xl']).'</div>' : '';
    ?>
    <?php if(get_field("song_small_title")): ?>
        <div><?php the_field("song_small_title"); ?></div>
    <?php endif; ?>
    <?php if(get_field("song_short_info")): ?>
        <div><?php the_field("song_short_info"); ?></div>
    <?php endif; ?>
    <?php
    if( have_rows('song_repeater') ):
        while ( have_rows('song_repeater') ) : the_row();
        ?>
        <div>
            <?php
                $version_name = get_sub_field("version_name");
                $song_name = get_sub_field("song_name");
                $song_file = get_field('song_file');
                echo $song_title ? '<div>'.$song_title.'</div>' : '';
                echo $song_name ? '<div>'.$song_name.'</div>' : '';
                echo $song_file ? '<div>'.esc_url($song_file['url']).'</div>' : '';
            ?>
        </div>
        <?php
        endwhile;
    endif;
    ?>
    <?php if(get_field("section_name")): ?>
        <div><?php the_field("section_name"); ?></div>
    <?php endif; ?>
    <?php if(get_field("section_description")): ?>
        <div><?php the_field("section_description"); ?></div>
    <?php endif; ?>
    <?php if(get_field("song_info")): ?>
        <div><?php the_field("song_info"); ?></div>
    <?php endif; ?>
    <?php if(get_field("song_lyrics")): ?>
        <div><?php the_field("song_lyrics"); ?></div>
    <?php endif; ?>
    <?php $song_img = get_field("song_img");
        echo $song_img ? '<div>'.esc_url($song_img['sizes']['xl']).'</div>' : '';
    ?>
    <?php if(get_field("song_img_caption")): ?>
        <div><?php the_field("song_img_caption"); ?></div>
    <?php endif; ?>
    <?php if(get_field("song_remark")): ?>
        <div><?php the_field("song_remark"); ?></div>
    <?php endif; ?>
<?php
endwhile; // End of the loop.
?>


<?php
get_footer();
