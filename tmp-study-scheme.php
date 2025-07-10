<?php /* Template Name: Study Scheme */ ?>
<?php
/**
 * The template for displaying study scheme pages
 * Shows programme requirements with unit boxes and expandable course details
 *
 * @package cuhk_chi
 */

get_header();


?>


<?php
while (have_posts()) :
	the_post();
    $post_object = get_field('target_page'); // returns a WP_Post object

    if ($post_object) {
        $full_url = get_permalink($post_object); // full URL
        $home_url = home_url('/'); // with trailing slash

        // Remove home URL from the full URL
        $relative_url = str_replace($home_url, '', $full_url);
    }
    get_template_part('template-parts/roll-menu', null, array('target_page' => $relative_url));

	$section_title = get_field("section_title");
	$programme_name = get_field("programme_name");
	$scheme_description = get_field("scheme_description");
	$how_to_show_course_list = get_field("how_to_show_course_list");
	$courses = get_field("courses");
?>

    <div class="ink_bg13_wrapper">
        <img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg13.jpg" class="ink_bg13 scrollin scrollinbottom" alt="Background">
    </div>
    
	<div class="section section_content section_scheme">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom section_scheme_title_wrapper">

            <?php
            global $post;

            // Get the parent ID
            $parent_id = $post->post_parent ? $post->post_parent : $post->ID;

            // Get all child pages of that parent
            $sibling_pages = get_pages([
                'parent'     => $parent_id,
                'sort_column'=> 'menu_order',
                'sort_order' => 'ASC',
            ]);

            if ($sibling_pages) : ?>
                <ul class="sibling-pages-menu">
                    <?php foreach ($sibling_pages as $page) : ?>
                        <li class="sibling-page-item <?php if ($page->ID == $post->ID) echo 'current'; ?>">
                            <a href="<?php echo get_permalink($page->ID); ?>">
                                <?php echo esc_html(get_field('section_title', $page->ID)); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

			<?php if ($section_title) : ?>
				<h1 class="section_title text1"><?php echo wp_kses_post($section_title); ?></h1>
			<?php endif; ?>

			<?php if ($programme_name) : ?>
				<div class="section_scheme_prog_name text5 col8"><?php echo wp_kses_post($programme_name); ?></div>
			<?php endif; ?>

			<?php if ($scheme_description) : ?>
				<div class="section_scheme_description free_text text6 col8">
					<?php echo apply_filters('the_content', $scheme_description); ?>
				</div>
			<?php endif; ?>

        </div>



            
        <?php if (have_rows('scheme_repeater')) : ?>
            <div class="scheme_item_wrapper">
                <?php while (have_rows('scheme_repeater')) : the_row();  
                    $scheme_title = get_sub_field('scheme_title');
                    $scheme_courses = get_sub_field('courses');
                ?>
                    <div class="scheme_item  scrollin scrollinbottom">
                        <div class="section_center_content small_section_center_content">
                            <div class="scheme_title text2"><?php echo $scheme_title; ?></div>
                            <?php if (have_rows('scheme_year')) :
                                $group_index = 0;

                                // Get the first row's group_title
                                the_row(); // move to first row
                                $first_group_title = get_sub_field('year_title');
                                reset_rows(); // reset the pointer to start loop again
                            ?>
                            <div class="scheme_groups_dropdown_wrapper">
                                <div class="scheme_groups_dropdown">
                                    <div class="selected text5"><span class="text"><?php echo esc_html($first_group_title); ?></span><div class="arrow"></div></div>

                                    <ul class="hidden text5">
                                        <?php while (have_rows('scheme_year')) : the_row(); 
                                            $group_index++;
                                            $group_title = get_sub_field('year_title');
                                        ?>
                                            <li class="<?php if ($group_index == 1) echo 'active'; ?>">
                                                <a href="#" data-target="group_<?php echo $group_index; ?>">
                                                    <?php echo esc_html($group_title); ?>
                                                </a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if (have_rows('scheme_year')) : 
                            $group_index = 0;
                            ?>
                            <div class="scheme_group_wrapper scrollin scrollinbottom">
                                <?php
                                while (have_rows('scheme_year')) : the_row();
                                    $group_index++;
                                    $group_introduction = get_sub_field('year_introduction');
                                    $group_total_units = get_sub_field('year_total_units');
                                    $group_pdf = get_sub_field('year_pdf');
                                    $expandable_items = get_sub_field('expandable_items');
                                    $group_remarks = get_sub_field('remarks');
                                    $group_courses = get_sub_field('courses');
                                ?>
                                    <div class="scheme_group <?php if($group_index==1){echo"active";};?>" data-id="group_<?php echo $group_index; ?>">
                                        <div class="section_center_content small_section_center_content ">
                                            <?php 
                                                if($group_introduction):
                                                    ?>
                                                    <div class="group_introduction text4">
                                                        <div class="section_scheme_description free_text col8">
                                                            <?php echo $group_introduction; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                endif; 
                                            ?>

                                            <?php 
                                                if($group_pdf):
                                                    ?>
                                                    <div class="scheme_pdf_btn_wrapper text6">
                                                        <a class=" scheme_pdf_btn" href="<?php echo $group_pdf["url"]; ?>" target="_blank"><?php echo cuhk_multilang_text("下載修讀辦法PDF","","Download Study Scheme PDF"); ?><span class="arrow"></span></a>
                                                    </div>
                                                    <?php
                                                endif; 
                                            ?>
                                            <?php 
                                            if (have_rows('expandable_items')) : 
                                                while (have_rows('expandable_items')) : the_row();
                                                
                                                $title = get_sub_field('title');
                                                $course_units = get_sub_field('course_units');
                                                $content = get_sub_field('content');
                                                
                                                ?>
                                                <div class="scheme_group_expandable_item">
                                                    <div class="title">
                                                        <div class="left_title text5"><?php echo wp_kses_post($title); ?></div>
                                                        <div class="right_title">
                                                            <div class="num text2">
                                                                <?php echo wp_kses_post($course_units); ?>
                                                        
                                                                <span class="unit text5"><?php echo cuhk_multilang_text("學分","",($course_units != 1) ? 'Units' : 'Unit'); ?></span>
                                                            </div>
                                                            <div class="icon_wrapper"><a class="icon"></a></div>
                                                        </div>
                                                    </div>
                                                    <?php if ($content) : ?>
                                                    <div class="hidden">
                                                        <div class="hidden_content">
                                                                <div class="free_text"><?php echo wp_kses_post($content); ?></div>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php 
                                                endwhile;
                                            endif;
                                            ?>
                                            <?php 
                                                if($group_total_units):
                                                    ?>
                                                    <div class="group_total_units ">
                                                        <span class="title text4"><?php echo cuhk_multilang_text("總學分：","",'Total:'); ?></span>
                                                        <span class="num text2"><?php echo $group_total_units; ?></span>
                                                    </div>
                                                    <?php
                                                endif; 
                                            ?>
                                            <?php 
                                                if($group_remarks):
                                                    ?>
                                                    <div class="scheme_remark free_text">
                                                        <?php echo $group_remarks; ?>
                                                    </div>
                                                    <?php
                                                endif; 
                                            ?>

                                            <?php 
                                            if($how_to_show_course_list==3) : 
                                                if (have_rows('courses')) : 
                                                    while (have_rows('courses')) : the_row();
                                                    
                                                    $course_code = get_sub_field('course_code');
                                                    $course_title = get_sub_field('course_title');
                                                    $course_short_description = get_sub_field('course_short_description');
                                                    $course_units = get_sub_field('course_units');
                                                    $course_link = get_sub_field('course_link');
                                                    
                                                    ?>
                                                    <div class="scheme_group_expandable_item">
                                                        <div class="title">
                                                            <div class="left_title text5">
                                                                <?php if($course_link){?>
                                                                    <?php echo wp_kses_post($course_code); ?>
                                                                <?php }else{ ?>
                                                                    <a href="<?php echo wp_kses_post($course_link); ?>"><?php echo wp_kses_post($course_code); ?></a>
                                                                <?php }; ?>
                                                            </div>
                                                            <div class="left_title text5">
                                                                <?php echo wp_kses_post($course_units); ?>
                                                                <span class="unit text5"><?php echo cuhk_multilang_text("學分","",($course_units != 1) ? 'Units' : 'Unit'); ?></span>
                                                            </div>
                                                            <div class="right_title">
                                                                <?php echo wp_kses_post($course_title); ?>
                                                                <div class="icon_wrapper"><a class="icon"></a></div>
                                                            </div>
                                                        </div>
                                                        <?php if ($course_short_description) : ?>
                                                        <div class="hidden">
                                                            <div class="hidden_content">
                                                                    <div class="free_text"><?php echo wp_kses_post($course_short_description); ?></div>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php 
                                                    endwhile;
                                                endif;
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                <?php 
                                endwhile; 
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php 
                            if($how_to_show_course_list==2) : 
                                if (have_rows('courses')) : 
                                    while (have_rows('courses')) : the_row();
                                    
                                    $course_code = get_sub_field('course_code');
                                    $course_title = get_sub_field('course_title');
                                    $course_short_description = get_sub_field('course_short_description');
                                    $course_units = get_sub_field('course_units');
                                    $course_link = get_sub_field('course_link');
                                    
                                    ?>
                                    <div class="scheme_group_expandable_item">
                                        <div class="title">
                                            <div class="left_title text5">
                                                <?php if($course_link){?>
                                                    <?php echo wp_kses_post($course_code); ?>
                                                <?php }else{ ?>
                                                    <a href="<?php echo wp_kses_post($course_link); ?>"><?php echo wp_kses_post($course_code); ?></a>
                                                <?php }; ?>
                                            </div>
                                            <div class="left_title text5">
                                                <?php echo wp_kses_post($course_units); ?>
                                                <span class="unit text5"><?php echo cuhk_multilang_text("學分","",($course_units != 1) ? 'Units' : 'Unit'); ?></span>
                                            </div>
                                            <div class="right_title">
                                                <?php echo wp_kses_post($course_title); ?>
                                                <div class="icon_wrapper"><a class="icon"></a></div>
                                            </div>
                                        </div>
                                        <?php if ($course_short_description) : ?>
                                        <div class="hidden">
                                            <div class="hidden_content">
                                                    <div class="free_text"><?php echo wp_kses_post($course_short_description); ?></div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php 
                                    endwhile;
                                endif;
                            endif;
                        ?>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        
        <?php 
                echo "1";
                var_dump(get_field("courses"));

            if($how_to_show_course_list==1) : 
                echo "2";
                var_dump(get_field("courses"));
                if (have_rows('courses')) : 
                    while (have_rows('courses')) : the_row();
                    
                    $course_code = get_sub_field('course_code');
                    $course_title = get_sub_field('course_title');
                    $course_short_description = get_sub_field('course_short_description');
                    $course_units = get_sub_field('course_units');
                    $course_link = get_sub_field('course_link');
                    
                    ?>
                    <div class="scheme_group_expandable_item">
                        <div class="title">
                            <div class="left_title text5">
                                <?php if($course_link){?>
                                    <?php echo wp_kses_post($course_code); ?>
                                <?php }else{ ?>
                                    <a href="<?php echo wp_kses_post($course_link); ?>"><?php echo wp_kses_post($course_code); ?></a>
                                <?php }; ?>
                            </div>
                            <div class="left_title text5">
                                <?php echo wp_kses_post($course_units); ?>
                                <span class="unit text5"><?php echo cuhk_multilang_text("學分","",($course_units != 1) ? 'Units' : 'Unit'); ?></span>
                            </div>
                            <div class="right_title">
                                <?php echo wp_kses_post($course_title); ?>
                                <div class="icon_wrapper"><a class="icon"></a></div>
                            </div>
                        </div>
                        <?php if ($course_short_description) : ?>
                        <div class="hidden">
                            <div class="hidden_content">
                                    <div class="free_text"><?php echo wp_kses_post($course_short_description); ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php 
                    endwhile;
                endif;
            endif;
        ?>
    </div>
<?php
endwhile;
?>

<?php
get_footer();
