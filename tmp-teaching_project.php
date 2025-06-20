<?php
/*
Template Name: Teaching Project Archive
*/

get_header();

// Include the roll menu template part
get_template_part('template-parts/roll-menu', null, array('target_page' => 'study/chinese-language-courses')); ?>



<div >
	<div class="section section_content filter_menu_section">
		<div class="section_center_content small_section_center_content small_section_center_content scrollin scrollinbottom">

            <div class="intro_btn_wrapper">
                <?php
                $current_id = get_the_ID();
                $parent_id = wp_get_post_parent_id($current_id);

                // If the page has a parent, get its children (siblings)
                if ($parent_id) {
                    $related_pages = get_pages(array(
                        'parent' => $parent_id,
                        'sort_column' => 'menu_order',
                        'sort_order' => 'ASC',
                    ));
                } else {
                    // Otherwise, get direct children of the current page
                    $related_pages = get_pages(array(
                        'parent' => $current_id,
                        'sort_column' => 'menu_order',
                        'sort_order' => 'ASC',
                    ));
                }

                // Output the links
                foreach ($related_pages as $related_page) :
                    $is_active = ($related_page->ID === $current_id) ? ' active' : '';
                    ?>
                    <a href="<?php echo get_permalink($related_page->ID); ?>" class="round_btn text5<?php echo $is_active; ?>">
                        <?php echo get_field("page_title", $related_page->ID) ?: get_the_title($related_page->ID); ?>
                    </a>
                <?php endforeach; ?>
            </div>


            <h1 class="section_title text1 scrollin scrollinbottom"><?php echo get_field("page_title"); ?></h1>
            <div class="section_description scrollin scrollinbottom col6"><?php echo get_field('introduction'); ?></div>

		</div>
	</div>

	<div class="section news_box_section news_gallery_box_section scrollin_p">
		<div class="news_box_wrapper">
			<div class="section_center_content small_section_center_content">
				<div class="col_wrapper big_col_wrapper">
					<div class="flex row">

						<?php
                        $args = array(
                            'post_type' => 'teaching_project',
                            'posts_per_page' => -1, // or any number you want
                        );

                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post();
                                $title = get_the_title();
                                $permalink = get_permalink();
                                $thumbnail_id = get_post_thumbnail_id();
                                $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium'); // or 'full'
                                $alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                                ?>
                                
                                <div class="news_box col col3">
                                    <div class="col_spacing scrollin scrollinbottom">
                                        <a class="photo" href="<?php echo esc_url($permalink); ?>">
                                            <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($alt_text ?: $title); ?>">
                                        </a>
                                        <div class="text_wrapper">
                                            <div class="title_wrapper">
                                                <div class="title text5"><?php echo esc_html($title); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>

					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>