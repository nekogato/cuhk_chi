<?php

/**
 * The template for displaying single event posts
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu', null, array('target_page' => 'news-and-events/events')); ?>

<?php
while (have_posts()) :
	the_post();
    $newsletter_number = get_field("newsletter_number");
    $newsletter_footer = get_field("newsletter_footer");
?>

    <div class="ink_bg13_wrapper">
        <img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg13.jpg" class="ink_bg13 scrollin scrollinbottom" alt="Background">
    </div>
	<div class="section section_content section_newsletter">
		<div class="section_center_content small_section_center_content">
            <div class="">
                <div class="newsletter_col_wrapper scrollin scrollinbottom">
                    <div class="newsletter_col newsletter_main col8">
                        <center>
                            <table width="600" height="100%" align="center" cellspacing="0" cellpadding="0" border="0" style="font-family:'Open Sans','Arial','Verdana',sans-serif;font-size:12px;font-style:normal;font-weight:400;line-height:1.2;text-rendering:optimizeLegibility;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing: grayscale;-moz-font-feature-settings:'liga','kern';border-spacing:0;border-collapse:collapse;padding:0;margin:0 auto;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;width:600px;color:#4c4846;background-color:#ffffff;border:1px solid #4c4846;">
                                <tbody>
                                    <tr>
                                        <td align="left" valign="top" style="border-bottom:1px solid #4c4846;">
                                            <table width="600" class="enews_head_table" style="border-spacing:0;border-collapse:collapse;padding:0;margin:0 auto;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;width:600px;">
                                                <tbody>
                                                    <tr>
                                                        <td align="left" valign="top" style="width:475px; text-align:left;" class="enews_head">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/images/enews_head.png" style="dislay:block;width:475px;height:80px;margin:0px;mso-line-height-rule:at-least;">
                                                        </td>
                                                        <td align="right" valign="top" style="width:85px; text-align: right; font-size: 12px; padding: 20px;">
                                                            <?php
                                                            if (function_exists('pll_the_languages')) {
                                                                $i=0;
                                                                $languages = pll_the_languages(['raw' => 1, 'echo' => 0]);
                                                                foreach ($languages as $lang) {
                                                                    $i++;
                                                                    if($i>1){
                                                                        echo '| <a href="' . esc_url($lang['url']) . '" class="' . esc_attr($lang['classes']) . '" style="text-decoration: none; color:#4c4846;">' . esc_html($lang['name']) . '</a> ';
                                                                    }else{
                                                                        echo '<a href="' . esc_url($lang['url']) . '" class="' . esc_attr($lang['classes']) . '" style="text-decoration: none; color:#4c4846;">' . esc_html($lang['name']) . '</a> ';
                                                                    }
                                                                    
                                                                }
                                                            }
                                                            ?><br>
                                                            <div style="margin-top: 4px;"><?php echo $newsletter_number; ?></div>	
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                        if (have_rows('news_row')) : 
                                            while (have_rows('news_row')) : the_row();
                                                $title = get_sub_field('title');
                                                $image = get_sub_field('image');
                                                $displayimageURL = $image["sizes"]["m"];
                                                $description = get_sub_field('description');
                                                $url = get_sub_field('url');
                                                if($title||$image||$description){
                                                    ?>
                                                    <tr>
                                                        <td align="left" valign="top" style="padding:0px">
                                                            <table width="560" style="border-spacing:0;border-collapse:collapse;padding:0;margin:0 auto;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;width:560px; border-bottom:1px solid #4c4846;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="padding:30px 20px 30px 10px; width:350px; vertical-align: top;">
                                                                            <?php if ( $title ) { ?>
                                                                                <strong style="font-size:16px; font-weight:900;font-family:'Times New Roman',serif;"><?php echo $title; ?></strong>
                                                                            <?php }; ?>
                                                                            <?php if ( $description ) { ?>
                                                                                <div style="margin-top:15px;"><?php echo $description; ?></div>
                                                                            <?php }; ?>
                                                                            <?php if ( $url ) { ?>
                                                                                <div style="margin-top:20px;"><a href="<?php echo $url; ?>" style="display:inline-block; background-color:#fff; color:#4c4846; border:1px solid #4c4846; padding:5px 20px; text-decoration: none;"><?php echo cuhk_multilang_text("閱讀更多", "", "Read more"); ?></a></div>
                                                                            <?php }; ?>
                                                                        </td>
                                                                        <td style="padding:30px 10px 30px 20px; width:150px; vertical-align: top;">
                                                                            <?php if ( $displayimageURL ) { ?>
                                                                                <div><img src="<?php echo($displayimageURL); ?>" style="display:block;width:200px;height:auto;margin:0px;mso-line-height-rule:at-least;" alt=""></div>
                                                                            <?php }; ?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                };
                                            endwhile; 
                                        endif;
                                    ?>

                                    <tr>
                                        <td align="left" valign="top" style="text-align: center; font-size: 12px; padding:0px;">
                                            <table width="560" style="border-spacing:0;border-collapse:collapse;padding:0;margin:0 auto;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;width:560px;">
                                                <tbody>
                                                    <tr>
                                                        <td  style="text-align: center; font-size: 12px; padding: 40px 20px 40px 20px;">
                                                        <?php echo $newsletter_footer; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" style="text-align: center; background-color:#4c4846; color:#fff;">
                                            <table width="600" style="border-spacing:0;border-collapse:collapse;padding:0;margin:0 auto;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;width:600px;">
                                                <tbody>
                                                    <tr>
                                                        <td  align="center" valign="top" style="-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;width:600px;padding:20px 0px 0 0px; font-size:14px;line-height:20px;color:#ffffff;">
                                                            <a style="text-decoration:none; color:#fff;" href="<?php echo esc_url( home_url('/about/contact-us/') );?>" target="_blank"><?php echo cuhk_multilang_text("聯絡我們","","Contact Us"); ?></a><span style="display: inline-block;  margin-left: 12px; margin-right: 12px;">|</span><a style="text-decoration:none; color:#fff;" href="http://www.cuhk.edu.hk/english/privacy.html" target="_blank"><?php echo cuhk_multilang_text("私隱政策","","Privacy Policy"); ?></a><span style="display: inline-block;  margin-left: 12px; margin-right: 12px;">|</span><a style="text-decoration:none; color:#fff;" href="http://www.cuhk.edu.hk/english/disclaimer.html" target="_blank"><?php echo cuhk_multilang_text("免責聲明","","Disclaimer"); ?></a>
                                                        </td>

                                                        
                                                    </tr>
                                                    <tr>
                                                        <td width="600" align="center" valign="top" style="-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;width:600px;padding:20px 0px;color:#ffffff;"><?php echo cuhk_multilang_text(date('Y') ."版權所有","","© Copyright ".date('Y')); ?><span style="display: inline-block;  margin-left: 12px; margin-right: 12px;">|</span><?php echo cuhk_multilang_text("香港中文大學中國語言及文學系","","The Chinese University of Hong Kong Department of Chinese Language and Literature"); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                </body>
                            </table>
                        </center>
                    </div>

                    <div class="newsletter_col newsletter_side col4">
                        <div class="newsletter_side_content">
                            <div class="recent_newsletter_list_wrapper">
                            <div class="text6 newsletter_side_title"><?php echo cuhk_multilang_text("近期系訊","","Recent Newsletters"); ?></div>
                            <?php
                                $args = array(
                                'post_type'           => 'newsletter',   // change to your CPT slug if different
                                'post_status'         => 'publish',
                                'posts_per_page'      => 10
                                );

                                $news = new WP_Query( $args );

                                if ( $news->have_posts() ) :
                                    ?>
                                    <ul class="recent_newsletter_list">
                                    <?php
                                        while ( $news->have_posts() ) :
                                        $news->the_post();
                                        $newsletter_number = get_field("newsletter_number");
                                        ?>
                                            <li class="recent_newsletter_list_item">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php if ($newsletter_number) : ?>
                                                        <?php echo esc_html($newsletter_number); ?>
                                                    <?php endif; ?>
                                                </a>
                                            </li>
                                        <?php
                                        endwhile;
                                    ?>
                                    </ul>
                                    <?php
                                wp_reset_postdata();
                                endif;
                            ?>
                            </div>
                            <div class="newsletter_side_dropdown_wrapper">
                                <div class="newsletter_side_dropdown_menu_wrapper">
                                    <div class="year newsletter_side_dropdown_menu">
                                        <div class="filter_dropdown_wrapper newsletter_year_filter_dropdown_wrapper">
                                            <a class="filter_dropdown_btn text5" href="#" ></a>
                                            <div class="filter_dropdown text6">
                                                <ul>
                                                    <?php
                                                    $prev_year = null;
                                                    $opened    = false;

                                                    // Determine current language (Polylang)
                                                    $lang = function_exists('pll_current_language') ? pll_current_language() : '';

                                                    switch ( $lang ) {
                                                    case 'en':$date_format = 'j M Y';
                                                        break;

                                                    // Traditional Chinese
                                                    case 'tc':$date_format = 'Y年n月j日';
                                                        break;

                                                    // Simplified Chinese
                                                    case 'sc':$date_format = 'Y年n月j日';
                                                        break;

                                                    default:
                                                        $date_format = 'j M Y';
                                                    }

                                                    $args = array(
                                                    'post_type'      => 'newsletter',
                                                    'posts_per_page' => -1,
                                                    'meta_key' => 'date',
                                                    'orderby' => 'meta_value_num',
                                                    'order' => 'DESC',
                                                    'post_status' => 'publish'
                                                    );

                                                    // Restrict the query to the current language (explicit)
                                                    if ( function_exists('pll_current_language') ) {
                                                    $args['lang'] = $lang; // current Polylang language only
                                                    }

                                                    $query = new WP_Query( $args );

                                                    if ( $query->have_posts() ) :
                                                    while ( $query->have_posts() ) :
                                                        $query->the_post();
                                                        $start_date_raw = get_field('date'); // This is in Ymd format, e.g. 20250622
                                                        if ($start_date_raw) {
                                                            $this_year = DateTime::createFromFormat('Ymd', $start_date_raw);
                                                            $this_year = $this_year->format('Y');
                                                        }

                                                        // Open a new year group when the year changes
                                                        if ( $prev_year !== $this_year ) {
                                                            if ( $opened ) {
                                                            echo '</li>';
                                                            }
                                                            echo '<li><a data-val="'.$this_year.'">' . esc_html( $this_year ) . '</a>';
                                                            $opened = true;
                                                        }

                                                        $prev_year = $this_year;

                                                    endwhile;

                                                    // Close the last opened list, if any
                                                    if ( $opened ) {
                                                        echo '</li>';
                                                    }
                                                    endif;

                                                    wp_reset_postdata();
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="year newsletter_side_dropdown_item">
                                        <?php
                                            $args = array(
                                            'post_type'      => 'newsletter',
                                            'posts_per_page' => -1,
                                            'meta_key'       => 'date',           // ACF date stored as Ymd (e.g. 20240131)
                                            'orderby'        => 'meta_value_num',
                                            'order'          => 'DESC',
                                            'post_status'    => 'publish',
                                            'meta_query'     => array(
                                                array(
                                                'key'     => 'date',
                                                'compare' => 'EXISTS',
                                                ),
                                            ),
                                            );

                                            $q = new WP_Query($args);

                                            $current_year  = null;
                                            $wrapper_open  = false;

                                            if ($q->have_posts()) :
                                                while ($q->have_posts()) : $q->the_post();

                                                    // Get raw ACF date (Ymd). If your ACF return format is different, normalize here.
                                                    $raw = get_field('date');
                                                    if (!$raw) { continue; }

                                                    // Be safe: strip non-digits and validate length.
                                                    $raw = preg_replace('/\D/', '', $raw);
                                                    if (strlen($raw) !== 8) { continue; }

                                                    $year = substr($raw, 0, 4);

                                                    // Open a new wrapper when the year changes.
                                                    if ($year !== $current_year) {
                                                    if ($wrapper_open) {
                                                        // Close previous year wrapper.
                                                        echo '</ul></div></div>';
                                                    }

                                                    $current_year = $year;
                                                    $wrapper_open = true;

                                                    echo '<div class="filter_dropdown_wrapper" data-year="' . esc_attr($year) . '">';
                                                    echo '  <a class="filter_dropdown_btn text5" href="#">'.cuhk_multilang_text("期數","","Issue").'</a>';
                                                    echo '  <div class="filter_dropdown text6">';
                                                    echo '    <ul>';
                                                    }

                                                    // Format the label (change to your preferred format, e.g. "F j, Y").
                                                    $dt    = DateTime::createFromFormat('Ymd', $raw);
                                                    $label = $dt ? $dt->format('F j, Y') : $raw;
                                                    $newsletter_number = get_field("newsletter_number");

                                                    echo '      <li><a target="_blank" href="' . esc_url(get_the_permalink()) . '">' . $newsletter_number . '</a></li>';

                                                endwhile;

                                                // Close the final open wrapper, if any.
                                                if ($wrapper_open) {
                                                    echo '</ul></div></div>';
                                                }

                                                wp_reset_postdata();

                                            endif;
                                        ?>
                                    </div>
                                </div>

                                <div class="old_newsletter_menu">
                                    <a href="<?php echo pll_get_page_url("news-and-events/old_newsletter"); ?>" class="old_newsletter_btn text5 line_btn"><?php echo cuhk_multilang_text("系訊存檔","","Newsletter Archive"); ?></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
endwhile;
?>

<script>
    $(".newsletter_side_dropdown_menu .filter_dropdown_wrapper").each(function(){
        var $firstitem = $(this).find(".filter_dropdown ul li:first-child a");
        $(this).find(".filter_dropdown_btn").html($firstitem.html());
    })

    $(".newsletter_side_dropdown_menu .filter_dropdown a").click(function(){
        var year = $(this).data("val");
        if(year){
            $(".newsletter_side_dropdown_item .filter_dropdown_wrapper").each(function(){
                if($(this).data("year") == year){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            })
        }

        var $p = $(this).parents(".filter_dropdown_wrapper")
        $p.find(".filter_dropdown_btn").html(year);
		
    })

    $(".newsletter_side_dropdown_item .filter_dropdown_wrapper:first-child").show();

</script>
<?php
get_footer();
