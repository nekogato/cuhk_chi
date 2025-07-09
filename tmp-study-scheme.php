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
	$show_required_units = get_field("show_required_units");
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
				<h1 class="section_title text1 scrollin scrollinbottom"><?php echo wp_kses_post($section_title); ?></h1>
			<?php endif; ?>

			<?php if ($programme_name) : ?>
				<div class="section_scheme_prog_name text5 col8"><?php echo wp_kses_post($programme_name); ?></div>
			<?php endif; ?>

			<?php if ($scheme_description) : ?>
				<div class="section_scheme_description free_text text6 col8">
					<?php echo apply_filters('the_content', $scheme_description); ?>
				</div>
			<?php endif; ?>

            <?php if (have_rows('scheme_groups')) :
                $group_index = 0;

                // Get the first row's group_title
                the_row(); // move to first row
                $first_group_title = get_sub_field('group_title');
                reset_rows(); // reset the pointer to start loop again
            ?>
                <div class="scheme_groups_dropdown_wrapper">
                    <div class="scheme_groups_dropdown">
                        <div class="selected text5"><span class="text"><?php echo esc_html($first_group_title); ?></span><div class="arrow"></div></div>

                        <ul class="hidden text5">
                            <?php while (have_rows('scheme_groups')) : the_row(); 
                                $group_index++;
                                $group_title = get_sub_field('group_title');
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


        <?php if (have_rows('scheme_groups')) : 
            $group_index = 0;
            ?>
            <div class="scheme_group_wrapper scrollin scrollinbottom">
                <?php
                while (have_rows('scheme_groups')) : the_row();
                    $group_index++;
                    $group_total_units = get_sub_field('group_total_units');
                    $scheme_pdf = get_sub_field('scheme_pdf');
                    $expandable_items = get_sub_field('expandable_items');
                    $remarks = get_sub_field('remarks');
                    $course_category = get_sub_field('course_category');
                    $course_year = get_sub_field('course_year');
                ?>
                    <div class="scheme_group <?php if($group_index==1){echo"active";};?>" data-id="group_<?php echo $group_index; ?>">
                        <div class="section_center_content small_section_center_content ">
                            <?php 
                                if($scheme_pdf):
                                    ?>
                                    <div class="scheme_pdf_btn_wrapper text6">
                                        <a class=" scheme_pdf_btn" href="<?php echo $scheme_pdf["url"]; ?>" target="_blank"><?php echo cuhk_multilang_text("下載修讀辦法PDF","","Download Study Scheme PDF"); ?><span class="arrow"></span></a>
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
                                if($remarks):
                                    ?>
                                    <div class="scheme_remark free_text">
                                        <?php echo $remarks; ?>
                                    </div>
                                    <?php
                                endif; 
                            ?>

                        </div>
                        

                        <?php if($course_category || $course_year){?>

                            <?php 
                            $tax_query = [];

                            // Handle course_category
                            if ($course_category) {
                                $term_ids = is_array($course_category)
                                    ? wp_list_pluck($course_category, 'term_id')
                                    : [$course_category->term_id];

                                $tax_query[] = [
                                    'taxonomy' => 'course_category',
                                    'field'    => 'term_id',
                                    'terms'    => $term_ids,
                                ];
                            }

                            // Handle course_year
                            if ($course_year) {
                                $term_ids = is_array($course_year)
                                    ? wp_list_pluck($course_year, 'term_id')
                                    : [$course_year->term_id];

                                $tax_query[] = [
                                    'taxonomy' => 'course_year',
                                    'field'    => 'term_id',
                                    'terms'    => $term_ids,
                                ];
                            }

                            // Build the query
                            $args = [
                                'post_type' => 'course',
                                'orderby' => 'title',
                                'order' => 'ASC',
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                            ];

                            // Only add tax_query if any conditions exist
                            if (!empty($tax_query)) {
                                $args['tax_query'] = $tax_query;
                            }

                            $query = new WP_Query($args);

                            if ($query->have_posts()) {
                            ?>
                            <div class="filter_detail_section ">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg4.jpg" class="ink_bg4 scrollin scrollinbottom" alt="Background">

                                <div class="filter_course_type_name section_center_content  small_section_center_content text3" ><?php echo cuhk_multilang_text("科目表","","Course List"); ?></div>

                                <div class="section_expandable_list   filter_detail_flex_body">

                                    <?php
                                        while ($query->have_posts()) {
                                            $query->the_post();
                                            $course_code = get_field("course_code");
                                            $course_title = get_field("Course_Title");
                                            $has_detail = get_field("has_detail");
                                            $course_description = get_field("course_description");
                                            $course_pdfs = get_field("course_pdfs");
                                            $course_unit = get_field("course_unit");
                                            ?>
                                            <div class="expandable_item ">
                                                <div class="section_center_content small_section_center_content">
                                                    <div class="expandable_title filter_detail_flex <?php if(!($has_detail || $course_description || have_rows('course_pdfs'))){ echo "disable"; }; ?>" >
                                                        <div class="filter_detail_flex_item text5 text_c1 filter_detail_flex_item_title">
                                                            <div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("課程編號","","Course Code"); ?></div>
                                                            <span><?php echo $course_code; ?></span>
                                                        </div>
                                                        <div class="filter_detail_flex_item">
                                                            <div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("課程名稱","","Course Title"); ?></div>
                                                            <span><?php echo $course_title; ?></span>
                                                        </div>
                                                        <div class="filter_detail_flex_item">
                                                            <div class="text8 mobile_show2 mobile_title"><?php echo cuhk_multilang_text("學分","","Course Units"); ?></div>
                                                            <span><?php echo $course_unit; ?></span>
                                                        </div>
                                                        <?php if($has_detail || $course_description || have_rows('course_pdfs')){ ?>
                                                        <div class="icon"></div>
                                                        <?php }; ?>
                                                    </div>
                                                    <div class="hidden">
                                                        <div class="hidden_content">
                                                            <?php if($course_description){ ?>
                                                            <div class="filter_detail_description_title text7"><?php echo cuhk_multilang_text("簡介","","Description"); ?></div>
                                                            <div class="filter_detail_description free_text"><?php echo $course_description; ?></div>
                                                            <?php }; ?>

                                                            <?php if($has_detail || have_rows('course_pdfs')){ ?>
                                                            <div class="btn_wrapper text7">
                                                                <?php if($has_detail){ ?>
                                                                    <a href="<?php the_permalink(); ?>" class="round_btn"><?php echo cuhk_multilang_text("課程內容","","Course detail"); ?></a>
                                                                <?php }; ?>

                                                                <?php if( have_rows('course_pdfs') ): ?>
                                                                    <?php while( have_rows('course_pdfs') ): the_row(); 
                                                                        $download_text = get_sub_field('download_text');
                                                                        $file = get_sub_field('file');
                                                                        ?>
                                                                        <a href="<?php echo $file["url"];?>" class="round_btn"><?php echo $download_text;?></a>
                                                                    <?php endwhile; ?>
                                                                <?php endif; ?>

                                                            </div>
                                                            <?php }; ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        wp_reset_postdata();
                                    }

                                    ?>
                                </div>
                            </div>
                        <?php }; ?>
                    </div>
                <?php 
                endwhile; 
                ?>
            </div>
        <?php endif; ?>
    </div>
<?php
endwhile;
?>

<?php
get_footer();
