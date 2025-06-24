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
                            <div class="t1"><?php echo cuhk_multilang_text("地址：","地址：","Address:"); ?></div>
                            <div class="t2 text7">
                                <?php the_field('address', 'option'); ?>
                            </div>
                        </div>
                        <?php
                        if( have_rows('column_1_menu', 'option') ):
                            while( have_rows('column_1_menu', 'option') ) : the_row();
                                $group_name = get_sub_field('group_name');
                                if( have_rows('menu') ):
                                    ?>
                                    <div class="footer_menu_list">
                                        <div class="t1 text6"><a><?php echo $group_name;?></a></div>
                                        <ul>
                                            <?php
                                            while( have_rows('menu') ) : the_row();
                                                $text = get_sub_field('text');
                                                $url = get_sub_field('url');
                                                ?>
                                                <li><a href="<?php echo $url;?>"><?php echo $text;?></a></li>
                                                <?php
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
                                        <div class="t1 text6"><a><?php echo $group_name;?></a></div>
                                        <ul>
                                            <?php
                                            while( have_rows('menu') ) : the_row();
                                                $text = get_sub_field('text');
                                                $url = get_sub_field('url');
                                                ?>
                                                <li><a href="<?php echo $url;?>"><?php echo $text;?></a></li>
                                                <?php
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
                                        <div class="t1 text6"><a><?php echo $group_name;?></a></div>
                                        <ul>
                                            <?php
                                            while( have_rows('menu') ) : the_row();
                                                $text = get_sub_field('text');
                                                $url = get_sub_field('url');
                                                ?>
                                                <li><a href="<?php echo $url;?>"><?php echo $text;?></a></li>
                                                <?php
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
                        <div class="footer2_t footer2_t1 text8">
                            <?php
                            if( have_rows('footer_menu', 'option') ):
                            ?>
                            <div class="footer_bottom_nav">        
                                <ul>
                                <?php
                                    while( have_rows('footer_menu', 'option') ) : the_row();
                                    $text = get_sub_field('text');
                                    $url = get_sub_field('url');
                                    ?>
                                    <li><a href="<?php echo $url;?>"><?php echo $text;?></a></li>
                                    <?php
                                    endwhile;
                                    ?>
                                </ul>
                            </div>
                            <?php
                                endif;
                            ?>
                            <div class="copyright">
                                <?php echo cuhk_multilang_text(date('Y') ."版權所有",date('Y') ."版權所有","© Copyright ".date('Y')); ?><span class="copyright_line">|</span><?php echo cuhk_multilang_text("香港中文大學中國語言及文學系","香港中文大學中國語言及文學系","The Chinese University of Hong Kong Department of Chinese Language & Literature"); ?>
                            </div>
                        </div>
                        <div class="footer2_t footer2_t2">
                            <div class="footer_sns_title text8"><?php echo cuhk_multilang_text("追蹤中國語言及文學系","追蹤中國語言及文學系","Follow Department of Chinese Language & Literature"); ?></div>
                            <div class="footer_sns_wrapper">
                                <ul>
                                    <?php if(get_field("fb_url","option")){?>
                                        <li><a href="<?php the_field("fb_url","option"); ?>" class="sns_icon_fb"></a></li>
                                    <?php }; ?>
                                    <?php if(get_field("ig_url","option")){?>
                                        <li><a href="<?php the_field("ig_url","option"); ?>" class="sns_icon_ig"></a></li>
                                    <?php }; ?>
                                    <?php if(get_field("youtube_url","option")){?>
                                        <li><a href="<?php the_field("youtube_url","option"); ?>" class="sns_icon_yt"></a></li>
                                    <?php }; ?>
                                    <?php if(get_field("linkedin_url","option")){?>
                                        <li><a href="<?php the_field("linkedin_url","option"); ?>" class="sns_icon_in"></a></li>
                                    <?php }; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ink_bg ink_bg1"><img src="<?php bloginfo('template_directory'); ?>/images/ink_bg1.jpg"></div>
    </div>

    <div class="mobile_hide"></div>
    <div class="mobile_show"></div>
    <div class="loading"><img src="<?php bloginfo('template_directory'); ?>/images/oval.svg"></div>

<?php wp_footer(); ?>

</body>
</html>
