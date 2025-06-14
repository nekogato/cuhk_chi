<?php
/*
Template for single gallery posts
*/

get_header();

// Include the roll menu template part
get_template_part('template-parts/roll-menu', null, array(
	'target_page' => 'news-and-events/media-coverage' // Assuming this is the parent page slug
)); ?>


<?php get_template_part('template-parts/roll-menu', null, array('target_page' => 'news-and-events/events')); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="section section_content filter_menu_section">
			<div class="section_center_content small_section_center_content scrollin scrollinbottom">
				<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>

				<?php if (get_the_content()) : ?>
					<div class="section_description scrollin scrollinbottom col6">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="news_gallery_detail_section scrollin_p">
			<div class="news_box_wrapper">
				<div class="section_center_content small_section_center_content">
					<div class="col_wrapper big_col_wrapper">
						<div class="flex row">
							<?php
							// Get gallery images from ACF
							$gallery_images = get_field('gallery_images');

							if ($gallery_images) :
								foreach ($gallery_images as $image) :
									$image_url = $image['sizes']['medium'] ?? $image['url'];
									$full_image_url = $image['url'];
									$caption = $image['caption'] ?? get_the_title();
									$alt_text = $image['alt'] ?? get_the_title();
							?>
									<div class="gallery_detail_box col col3">
										<div class="col_spacing scrollin scrollinbottom">
											<a class="photo" href="<?php echo esc_url($full_image_url); ?>" data-fancybox="gallery" data-caption="<?php echo esc_attr($caption); ?>">
												<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>">
											</a>
										</div>
									</div>
								<?php
								endforeach;
							else :
								// Fallback: show featured image if no gallery images
								$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
								$featured_image_full = get_the_post_thumbnail_url(get_the_ID(), 'full');

								if ($featured_image) :
								?>
									<div class="gallery_detail_box col col3">
										<div class="col_spacing scrollin scrollinbottom">
											<a class="photo" href="<?php echo esc_url($featured_image_full); ?>" data-fancybox="gallery" data-caption="<?php the_title_attribute(); ?>">
												<img src="<?php echo esc_url($featured_image); ?>" alt="<?php the_title_attribute(); ?>">
											</a>
										</div>
									</div>
							<?php
								endif;
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php endwhile;
endif; ?>

<?php get_footer(); ?>