<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cuhk_chi
 */

?>

    <div class="footer">
        <div class="section_center_content">
            <div class="footer_row_wrapper footer1">
                <div class="footer_row">
                    <div class="footer_menu_list_wrapper">
                        <div class="footer_menu_list footer_department_logo_wrapper">
                            <img src="<?php bloginfo('template_directory'); ?>/images/ccc_color.png" class="footer_department_logo">
                            <div class="t2 text7 footer_info">
                                <?php the_field('footer_info', 'option'); ?>
                            </div>
                        </div>
                        <?php
                        if( have_rows('column_1_menu', 'option') ):
                            while( have_rows('column_1_menu', 'option') ) : the_row();
                                $group_name = get_sub_field('group_name');
                                if( have_rows('menu') ):
                                    ?>
                                    <div class="footer_menu_list">
                                        <div class="t1 text6"><span><?php echo $group_name;?></span></div>
                                        <ul>
                                            <?php 
                                            while (have_rows('menu')) : the_row();
                                                $title_only = get_sub_field('title_only');
                                                $text       = get_sub_field('text');
                                                $url        = get_sub_field('url');
                                                $page       = get_sub_field('page');

                                                // If all fields are empty, show spacer
                                                if (empty($title_only) && empty($text) && empty($url) && empty($page)) {
                                                    echo '<li class="t_spacer"></li>';
                                                    continue;
                                                }

                                                if ($title_only) :
                                                ?>
                                                <li class="t2"><?php echo esc_html($text); ?></li>
                                                <?php 
                                                else:
                                                    // Default title and link fallback
                                                    $link_title = '';
                                                    $link_href  = '';

                                                    if ($page) {
                                                        $link_title = get_the_title($page);
                                                        $link_href  = get_permalink($page);
                                                    }

                                                    // Override title if text is given
                                                    if ($text) {
                                                        $link_title = $text;
                                                    }

                                                    // Override URL if given
                                                    if ($url) {
                                                        $link_href = $url;
                                                    }

                                                    // Only show if we have a title and a link
                                                    if ($link_title && $link_href) :
                                                ?>
                                                    <li><a href="<?php echo esc_url($link_href); ?>"><?php echo esc_html($link_title); ?></a></li>
                                                    <?php 
                                                    endif;
                                                endif;
                                            endwhile; 
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                endif;
                            endwhile;
                        endif;
                        ?>
                        <?php
                        if( have_rows('column_2_menu', 'option') ):
                            while( have_rows('column_2_menu', 'option') ) : the_row();
                                $group_name = get_sub_field('group_name');
                                if( have_rows('menu') ):
                                    ?>
                                    <div class="footer_menu_list">
                                        <div class="t1 text6"><span><?php echo $group_name;?></span></div>
                                        <ul>
                                            <?php 
                                            while (have_rows('menu')) : the_row();
                                                $title_only = get_sub_field('title_only');
                                                $text       = get_sub_field('text');
                                                $url        = get_sub_field('url');
                                                $page       = get_sub_field('page');

                                                // If all fields are empty, show spacer
                                                if (empty($title_only) && empty($text) && empty($url) && empty($page)) {
                                                    echo '<li class="t_spacer"></li>';
                                                    continue;
                                                }

                                                if ($title_only) :
                                                ?>
                                                <li class="t2"><?php echo esc_html($text); ?></li>
                                                <?php 
                                                else:
                                                    // Default title and link fallback
                                                    $link_title = '';
                                                    $link_href  = '';

                                                    if ($page) {
                                                        $link_title = get_the_title($page);
                                                        $link_href  = get_permalink($page);
                                                    }

                                                    // Override title if text is given
                                                    if ($text) {
                                                        $link_title = $text;
                                                    }

                                                    // Override URL if given
                                                    if ($url) {
                                                        $link_href = $url;
                                                    }

                                                    // Only show if we have a title and a link
                                                    if ($link_title && $link_href) :
                                                ?>
                                                    <li><a href="<?php echo esc_url($link_href); ?>"><?php echo esc_html($link_title); ?></a></li>
                                                    <?php 
                                                    endif;
                                                endif;
                                            endwhile; 
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                endif;
                            endwhile;
                        endif;
                        ?>
                        <?php
                        if( have_rows('column_3_menu', 'option') ):
                            while( have_rows('column_3_menu', 'option') ) : the_row();
                                $group_name = get_sub_field('group_name');
                                if( have_rows('menu') ):
                                    ?>
                                    <div class="footer_menu_list">
                                        <div class="t1 text6"><span><?php echo $group_name;?></span></div>
                                        <ul>
                                            <?php 
                                            while (have_rows('menu')) : the_row();
                                                $title_only = get_sub_field('title_only');
                                                $text       = get_sub_field('text');
                                                $url        = get_sub_field('url');
                                                $page       = get_sub_field('page');

                                                // If all fields are empty, show spacer
                                                if (empty($title_only) && empty($text) && empty($url) && empty($page)) {
                                                    echo '<li class="t_spacer"></li>';
                                                    continue;
                                                }

                                                if ($title_only) :
                                                ?>
                                                <li class="t2"><?php echo esc_html($text); ?></li>
                                                <?php 
                                                else:
                                                    // Default title and link fallback
                                                    $link_title = '';
                                                    $link_href  = '';

                                                    if ($page) {
                                                        $link_title = get_the_title($page);
                                                        $link_href  = get_permalink($page);
                                                    }

                                                    // Override title if text is given
                                                    if ($text) {
                                                        $link_title = $text;
                                                    }

                                                    // Override URL if given
                                                    if ($url) {
                                                        $link_href = $url;
                                                    }

                                                    // Only show if we have a title and a link
                                                    if ($link_title && $link_href) :
                                                ?>
                                                    <li><a href="<?php echo esc_url($link_href); ?>"><?php echo esc_html($link_title); ?></a></li>
                                                    <?php 
                                                    endif;
                                                endif;
                                            endwhile; 
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                endif;
                            endwhile;
                        endif;
                        ?>

                    </div>
                </div>
            </div>
            <div class="footer_row_wrapper footer2">
                <div class="footer_row">
                    <div class="footer2_t_wrapper">
                        <div class="footer2_t footer2_t1 text7">
                            <?php
                            if( have_rows('footer_menu', 'option') ):
                            ?>
                            <div class="footer_bottom_nav">        
                                <ul>
                                    <?php 
                                    while (have_rows('footer_menu', 'option')) : the_row();
                                        $text       = get_sub_field('text');
                                        $url        = get_sub_field('url');
                                        $page       = get_sub_field('page');
                                        
                                        // Default title and link fallback
                                        $link_title = '';
                                        $link_href  = '';

                                        if ($page) {
                                            $link_title = get_the_title($page);
                                            $link_href  = get_permalink($page);
                                        }

                                        // Override title if text is given
                                        if ($text) {
                                            $link_title = $text;
                                        }

                                        // Override URL if given
                                        if ($url) {
                                            $link_href = $url;
                                        }

                                        // Only show if we have a title and a link
                                        if ($link_title && $link_href) :
                                        ?>
                                            <li><a href="<?php echo esc_url($link_href); ?>"><?php echo esc_html($link_title); ?></a></li>
                                        <?php 
                                        endif;
                                    endwhile; 
                                    ?>
                                </ul>
                                
                            </div>
                            <?php
                                endif;
                            ?>
                            <div class="copyright">
                                <?php echo cuhk_multilang_text(date('Y') ."版權所有","","© Copyright ".date('Y')); ?><span class="copyright_line">|</span><?php echo cuhk_multilang_text("香港中文大學中國語言及文學系","","The Chinese University of Hong Kong Department of Chinese Language & Literature"); ?>
                            </div>
                        </div>
                        <div class="footer2_t footer2_t2">
                            <!-- <div class="footer_sns_title text7"><?php echo cuhk_multilang_text("追蹤中國語言及文學系","","Follow Department of Chinese Language & Literature"); ?></div> -->
                            <div class="footer_sns_wrapper">
                                <ul>
                                    <?php if(get_field("fb_url","option")){?>
                                        <li><a href="<?php the_field("fb_url","option"); ?>" class="sns_icon_fb" target="_blank"></a></li>
                                    <?php }; ?>
                                    <?php if(get_field("ig_url","option")){?>
                                        <li><a href="<?php the_field("ig_url","option"); ?>" class="sns_icon_ig" target="_blank"></a></li>
                                    <?php }; ?>
                                    <?php if(get_field("youtube_url","option")){?>
                                        <li><a href="<?php the_field("youtube_url","option"); ?>" class="sns_icon_yt" target="_blank"></a></li>
                                    <?php }; ?>
                                    <?php if(get_field("linkedin_url","option")){?>
                                        <li><a href="<?php the_field("linkedin_url","option"); ?>" class="sns_icon_in" target="_blank"></a></li>
                                    <?php }; ?>
                                    <?php if(get_field("weibo_url","option")){?>
                                        <li><a href="<?php the_field("weibo_url","option"); ?>" class="sns_icon_weibo" target="_blank"></a></li>
                                    <?php }; ?>
                                    <!-- <?php if(get_field("xiaohongshu_url","option")){?>
                                        <li><a href="<?php the_field("xiaohongshu_url","option"); ?>" class="sns_icon_xiaohongshu" target="_blank"></a></li>
                                    <?php }; ?> -->
                                    <?php if(get_field("xiaohongshu_qr_code","option")){?>
                                        <li><a href="<?php echo(get_field("xiaohongshu_qr_code","option"))["url"]; ?>" data-fancybox class="sns_icon_xiaohongshu"></a></li>
                                    <?php }; ?>
                                    <?php if(get_field("wechat_qr_code","option")){?>
                                        <li><a href="<?php echo(get_field("wechat_qr_code","option"))["url"]; ?>" data-fancybox class="sns_icon_wechat"></a></li>
                                    <?php }; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ink_bg ink_bg1"><img src="<?php bloginfo('template_directory'); ?>/images/ink_bg1.jpg"></div>

    <div class="mobile_hide"></div>
    <div class="mobile_show"></div>
    <div class="loading"><img src="<?php bloginfo('template_directory'); ?>/images/oval.svg"></div>

<?php wp_footer(); ?>

</body>
</html>
