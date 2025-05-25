<?php /* Template Name: About Chair */ ?>
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
    <?php if(get_field("small_headline")): ?>
        <div><?php the_field("small_headline"); ?></div>
    <?php endif; ?>
    <?php if(get_field("headline")): ?>
        <div><?php the_field("headline"); ?></div>
    <?php endif; ?>
    <?php $chair_image = get_field("chair_image");
        echo $chair_image ? '<div>'.esc_url($chair_image['sizes']['xl']).'</div>' : '';
    ?>
    <?php if(get_field("chair_name")): ?>
        <div><?php the_field("chair_name"); ?></div>
    <?php endif; ?>
    <?php if(get_field("chair_title")): ?>
        <div><?php the_field("chair_title"); ?></div>
    <?php endif; ?>
    
    
    <?php
    if( have_rows('flexible_content') ):
        while ( have_rows('flexible_content') ) : the_row();
            if( get_row_layout() == 'free_text' ):
                $freetext = get_sub_field("free_text");
                if($freetext){
                ?>
                    <div class="flexible_layout flexible_layout_freetext scrollin scrollinbottom">
                        <div class="free_text">
                            <?php echo $freetext; ?>
                        </div>
                    </div>
                <?php
                };
            elseif( get_row_layout() == 'single_image' ):
                $image = get_sub_field('image');
                $caption = get_sub_field('caption');
                if($image){
                ?>
                    <div class="flexible_layout flexible_layout_photo scrollin scrollinleft">
                        <div class="photo_wrapper">
                            <div class="photo">
                                <img src="<?php echo esc_url($image['sizes']['l']); ?>" >
                            </div>
                            <?php if($caption){?>
                            <div class="caption"><?php echo $caption;?></div>
                            <?php };?>
                        </div>
                    </div>
                <?php
                };
            elseif( get_row_layout() == 'video_upload' ):
                $video = get_sub_field('video_upload');
                if($video){
                ?>
                    <div class="flexible_layout flexible_layout_video scrollin scrollinbottom">
                        <div class="upload_video_wrapper">
                            <video controls playsinline>
                                <source src="<?php echo $video["url"];?>" type="video/mp4">
                                Your browser does not support HTML5 video.
                            </video>
                        </div>
                    </div>
                <?php
                };
            elseif( get_row_layout() == 'slider' ):
                if( have_rows('image_list') ):
                    ?>
                    <div class="flexible_layout flexible_layout_slider scrollin scrollinbottom">
                        <div class="swiper-container swiper">
                            <div class="swiper-wrapper">
                                <?php
                                while( have_rows('image_list') ) : the_row();
                                    $image = get_sub_field('image');
                                    $caption = get_sub_field('caption');
                                    ?>
                                        <div class="swiper-slide">
                                            <div class="photo">
                                                <img src="<?php echo esc_url($image['sizes']['l']); ?>" >
                                            </div>
                                            <?php if($caption){ ?>
                                                <div class="caption"><?php echo $caption; ?></div>
                                            <?php }; ?>
                                        </div>
                                    <?php
                                endwhile;
                                ?>
                            </div>
                        </div>
                        <div class="prev_btn"></div>
                        <div class="next_btn"></div>
                    </div>
                    <?php
                endif;
            endif;
        endwhile;
    endif;
    ?>
<?php
endwhile; // End of the loop.
?>


<?php
get_footer();
