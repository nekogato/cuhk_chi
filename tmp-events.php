<?php /* Template Name: Events Index */ ?>
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
    $page_title = get_field("page_title");
    $page_description = get_field("page_description");
?>


    <div class="section section_content section_intro">

        <div class="section_center_content">
            <?php if($page_title): ?>
                <h1 class="section_title text1 scrollin scrollinbottom"><?php echo $page_title; ?></h1>
            <?php endif; ?>
            <?php if($page_description): ?>
                <div class="section_description scrollin scrollinbottom col6"><?php echo $page_description; ?></div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $args = array(
        'post_type' => 'events',
        'post_status' => 'publish',
    );
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) { 
        ?>

        <div class="section event_list_section scrollin_p">
			<div class="section_center_content">
            	<div class="event_list_item_wrapper">
                    <?php
                    while ( $query->have_posts() ) { 
                        $query->the_post();
                        ?>
                        <div class="event_list_item flex ">
                            <div class="date">
                                <div class="d_wrapper">
                                    <div class="d1 text3">Mar</div>
                                    <div class="d2 text5">23</div>
                                </div>
                                <div class="btn_wrapper"><div class="reg_btn round_btn text7">Register Now</div></div>
                            </div>
                            <div class="title_wrapper">
                                <div class="title text5"><?php the_field("event_title");?> </div>
                                <div class="info_item_wrapper">
                                    <div class="info_item">
                                        <div class="t1">日期</div>
                                        <div class="t2 text6">2025年3月20日（星期四）</div>
                                    </div>
                                    <div class="info_item">
                                        <div class="t1">時間</div>
                                        <div class="t2 text6">第一場：10:00 AM – 12:15 PM</div>
                                    </div>
                                    <div class="info_item big_info_item">
                                        <div class="t1">地點</div>
                                        <div class="t2 text6">香港中文大學利黃瑤璧樓LT4</div>
                                    </div>
                                </div>
                            </div>
                            <div class="photo">
                                <img src="images/news2.jpg" >
                            </div>
                        </div>
                        <?php
                    };
                    ?>
                </div>
            </div>
        </div>
                            
        <?php
    };
endwhile; // End of the loop.
?>


<?php
get_footer();
