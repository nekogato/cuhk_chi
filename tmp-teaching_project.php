<?php
/*
Template Name: Teaching Project Archive
*/

get_header();

// Include the roll menu template part
get_template_part('template-parts/roll-menu'); ?>



<div >
	<div class="section section_content filter_menu_section">
		<div class="section_center_content small_section_center_content small_section_center_content scrollin scrollinbottom">

            

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
                            'posts_per_page' => -1,
		                    'post_status' => 'publish'
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