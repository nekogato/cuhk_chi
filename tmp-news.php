<?php /* Template Name: News Index */ ?>
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
    $featured_news = get_field("featured_news");
    $excluded_ids = [];
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


    <!-- show latest two news here -->
    <div class="section featured_news_box_section scrollin_p">
        <div class="news_box_wrapper">
            <div class="section_center_content">
                <div class="col_wrapper big_col_wrapper">
                    <div class="flex row">
                        <div class="news_box col col6">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image9.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text2">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="news_box col col6">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image9.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text2">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- show other news here -->
    <div class="section news_box_section scrollin_p">
        <div class="news_box_wrapper">
            <div class="section_center_content">
                <div class="col_wrapper">
                    <div class="flex row">
                        <div class="news_box col col4">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image4.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text5">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="news_box col col4">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image8.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text5">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="news_box col col4">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image6.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text5">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="news_box col col4">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image4.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text5">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="news_box col col4">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image6.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text5">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="news_box col col4">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image4.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text5">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="news_box col col4">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image6.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text5">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="news_box col col4">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image4.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text5">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="news_box col col4">
                            <div class="col_spacing scrollin scrollinbottom">
                                <div class="photo">
                                    <img src="images/dummy_image8.jpg" >
                                </div>
                                <div class="text_wrapper">
                                    <div class="date_wrapper text5">Mar 04</div>
                                    <div class="title_wrapper">
                                        <div class="title text5">祝賀本系林麗玲博士榮獲香港中文大學</div>
                                        <div class="btn_wrapper text8"><span class="round_btn">view more</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="load_more_wrapper scrollin scrollinbottom">
                    <a class="load_more_btn text5">
                        <div class="icon"></div>
                        <div class="text">Load more</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

       
    <?php
    
endwhile; // End of the loop.
?>


<?php
get_footer();
