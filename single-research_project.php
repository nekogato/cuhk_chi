<?php
/**
 * @package cuhk_chi
 */

get_header();
?>


<?php
while ( have_posts() ) :
	the_post();
?>
    <?php $project_category = get_the_terms(get_the_ID(),'project_category'); 
    if ( $project_category ) {
        if ( $project_category && ! is_wp_error( $project_category ) ) {
            foreach ( $project_category as $term ) {
                $termid = $term->term_id;
                $termslug = $term->slug;
                $termlink = get_term_link( $term );
                if ( is_wp_error( $termlink ) ) {
                    continue;
                }
                if(pll_current_language() == 'tc') {
                    $termname = get_field('tc_name', 'project_category_' .$termid);
                }elseif(pll_current_language() == 'sc'){
                    $termname = get_field('sc_name', 'project_category_' .$termid);
                }else{
                    $termname = get_field('en_name', 'project_category_' .$termid);
                };
                ?>
                <div>project_category: <?php echo $termname;?></div>
                <?php
            };
                   
        };
    };
    ?>
    <?php if(get_field("project_title")): ?>
        <div>project_title: <?php the_field("project_title"); ?></div>
    <?php endif; ?>
    <?php if(get_field("funding_start_year")): ?>
        <div>funding_start_year: <?php the_field("funding_start_year"); ?></div>
    <?php endif; ?>
    <?php if(get_field("funding_end_year")): ?>
        <div>funding_end_year: <?php the_field("funding_end_year"); ?></div>
    <?php endif; ?>
    <?php if(get_field("principal_investigator")): ?>
        <div>principal_investigator: <?php the_field("principal_investigator"); ?></div>
    <?php endif; ?>
    <?php if(get_field("other_investigator")): ?>
        <div>other_investigator: <?php the_field("other_investigator"); ?></div>
    <?php endif; ?>
    <?php if(get_field("granted_amount")): ?>
        <div>granted_amount: <?php the_field("granted_amount"); ?></div>
    <?php endif; ?>
    <?php if(get_field("funding_organization")): ?>
        <div>funding_organization: <?php the_field("funding_organization"); ?></div>
    <?php endif; ?>
    <?php
    if( have_rows('flexible_content') ):?>
        <div class="flexible_layout_wrapper ">
            flexible_content:
            <?php while ( have_rows('flexible_content') ) : the_row();
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
            endwhile;?>
        </div>
    <?php
    endif;
    ?>

<?php
endwhile; // End of the loop.
?>


<?php
get_footer();
