<?php /* Template Name: Publication  */ ?>
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
<?php get_template_part('template-parts/roll-menu'); ?>

<div class="section section_content">
	<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg5.jpg" class="ink_bg5 scrollin scrollinbottom" alt="Background Image">

	<div class="section_center_content small_section_center_content">
		<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
		<div class="section_description scrollin scrollinbottom col6"><?php echo get_field('introduction'); ?></div>

		<div class="publication_box_list scrollin_p">
			<?php
			$args = array(
				'post_type' => 'publication',
				'posts_per_page' => PUBLICATIONS_PER_PAGE,
				'orderby' => 'date',
				'order' => 'DESC'
			);

			$publications = new WP_Query($args);

			if ($publications->have_posts()) :
				while ($publications->have_posts()) : $publications->the_post();
					// Get custom fields
					$author = get_field('author');
					$chief_editor = get_field('chief_editor');
					$publisher = get_field('publisher');
					$publish_year = get_field('year_and_month_of_publication');
					$cover_image = get_field('cover_photo');
			?>
					<div class="publication_box scrollin scrollinbottom">
						<div class="publication_thumb">
							<div class="thumb">
								<?php if ($cover_image) : ?>
									<a href="<?php the_permalink(); ?>">
										<img src="<?php echo esc_url($cover_image['url']); ?>" alt="<?php echo esc_attr($cover_image['alt']); ?>">
									</a>
								<?php endif; ?>
							</div>
						</div>
						<div class="publication_text">
							<div class="publication_text_item text5 book_name"><?php the_title(); ?></div>
							<?php if ($author) : ?>
								<div class="publication_text_item">
									<div class="title text7">
										<?php 
										echo cuhk_multilang_text("作者","","Author");
										?>
									</div>
									<div class="text text5"><?php echo ($author); ?></div>
								</div>
							<?php elseif ($chief_editor) : ?>
								<div class="publication_text_item">
									<div class="title text7"><?php echo cuhk_multilang_text("主編","","Chief Editor"); ?></div>
									<div class="text text5"><?php echo ($chief_editor); ?></div>
								</div>
							<?php endif; ?>
						</div>
					</div>
			<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>

		<?php if ($publications->max_num_pages > 1) : ?>
			<div class="load_more_wrapper scrollin scrollinbottom">
				<a href="#" class="load_more_btn text6" data-page="1" data-max-pages="<?php echo $publications->max_num_pages; ?>">
					<div class="icon"></div>
					<div class="text"><?php echo cuhk_multilang_text("載入更多","","Load more"); ?></div>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>

<script>
	jQuery(document).ready(function($) {
		$('.load_more_btn').on('click', function(e) {
			e.preventDefault();

			var button = $(this);
			var currentPage = parseInt(button.data('page'));
			var maxPages = parseInt(button.data('max-pages'));

			$.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				type: 'POST',
				data: {
					action: 'load_more_publications',
					page: currentPage + 1,
					nonce: '<?php echo wp_create_nonce('load_more_publications_nonce'); ?>'
				},
				beforeSend: function() {
					button.find('.text').text('<?php pll_e('Loading...'); ?>');
					button.addClass('loading');
				},
				success: function(response) {
					if (response.success) {
						$('.publication_box_list').append(response.data.html);
						button.data('page', currentPage + 1);

						if (currentPage + 1 >= maxPages) {
							button.parent().hide();
						}

						// Reinitialize scroll animations
						if (typeof initScrollAnimations === 'function') {
							initScrollAnimations();
						}
					}
				},
				complete: function() {
					button.find('.text').text('<?php echo cuhk_multilang_text("載入更多","","Load more"); ?>');
					button.removeClass('loading');
				}
			});
		});
	});
</script>

<?php
get_footer();
