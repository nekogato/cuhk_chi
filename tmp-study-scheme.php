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

<?php get_template_part('template-parts/roll-menu'); ?>

<?php
while (have_posts()) :
	the_post();
	$section_title = get_field("section_title");
	$programme_name = get_field("programme_name");
	$scheme_description = get_field("scheme_description");
	$show_required_units = get_field("show_required_units");
	$course_list = get_field("course_list");
?>

	<div class="section section_content section_scheme">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">

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
        </div>
    </div>

	<div class="section section_content filter_detail_section scrollin scrollinbottom">

        <?php if (have_rows('scheme_groups')) :
            $group_index = 0;
            ?>
            <div class="scheme_groups_dropdown">
                <div class="section_center_content small_section_center_content">
                    <ul>
                    <?php while (have_rows('scheme_groups')) : the_row(); 
                    $group_index++;
                    $group_title = get_sub_field('group_title');
                    ?>
                        <li class="<?php if($group_index==1){echo"active";};?>"><a href="#" data-target="group_<?php echo $group_index; ?>">
                            <?php echo $group_title; ?>
                        </a></li>
                    <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>


        <?php if (have_rows('scheme_groups')) : 
            $group_index = 0;
            ?>
            <div class="scheme_group_wrapper">
                <?php
                while (have_rows('scheme_groups')) : the_row();
                    $group_index++;
                    $group_total_units = get_sub_field('group_total_units');
                    $scheme_pdf = get_sub_field('scheme_pdf');
                    $expandable_items = get_sub_field('expandable_items');
                    $remarks = get_sub_field('remarks');

                ?>
                    <div class="scheme_group <?php if($group_index==1){echo"active";};?>" data-id="group_<?php echo $group_index; ?>">
                        <?php 
                            if($scheme_pdf):
                                ?>
                                <div class="scheme_pdf_btn">
                                    <a href="<?php echo $scheme_pdf["url"]; ?>" target="_blank"><?php echo cuhk_multilang_text("社交媒體","","Download Study Scheme"); ?></a>
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
                            <div class="expandable_item">
                                <div class="title">
                                    <div class="left_title text5"><?php echo wp_kses_post($title); ?></div>
                                    <div class="right_title">
                                        <?php if($show_required_units):?>
                                            <div class="num text2"><?php echo wp_kses_post($course_units); ?></div>
                                            <div class="unit text5"><?php echo cuhk_multilang_text("學分","",($course_units != 1) ? 'Units' : 'Unit'); ?></div>
                                        <?php endif; ?>
                                        <div class="icon_wrapper"><a href="#" class="icon"></a></div>
                                    </div>
                                </div>
                                <div class="hidden">
                                    <div class="hidden_content">
                                        <?php if ($courses) : ?>
                                            <div class="free_text"><?php echo wp_kses_post($course_units); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            endwhile;
                        endif;
                        ?>
                        <?php 
                            if($group_total_units):
                                ?>
                                <div class="group_total_units">
                                    <?php echo $group_total_units; ?>
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
                <?php 
                endwhile; 
                ?>
            </div>
        <?php endif; ?>
    
        <?php if($course_list){?>
        <div class="section_expandable_list   filter_detail_flex_body">

            <?php 
            $query = new WP_Query([
                'post_type' => 'course',
                'tax_query' => [
                    [
                        'taxonomy' => 'course_category',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id,
                    ],
                ],
            ]);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $course_code = get_field("course_code");
                    $course_title = get_field("course_title");
                    $has_detail = get_field("has_detail");
                    $course_description = get_field("course_description");
                    $course_pdfs = get_field("course_pdfs");
                    $course_unit = get_field("course_unit");
                    ?>
                    <div class="expandable_item ">
                        <div class="section_center_content small_section_center_content">
                            <div class="expandable_title filter_detail_flex <?php if($has_detail || $course_description || have_rows('course_pdfs')){ echo "disable"; }; ?>" >
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
        <?php }; ?>
    </div>
<?php
endwhile;
?>

<?php
get_footer();
