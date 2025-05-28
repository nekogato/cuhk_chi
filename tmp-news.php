<?php /* Template Name: News Index */ ?>
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

while (have_posts()) :
	the_post();
?>

	<div class="section section_content section_intro">
		<div class="section_center_content">
			<h1 class="section_title text1 scrollin scrollinbottom"><?php echo the_title(); ?></h1>
			<div class="section_description scrollin scrollinbottom col6"><?php echo get_field('introduction'); ?></div>
		</div>
	</div>

	<!-- Featured News Section -->
	<div class="section featured_news_box_section scrollin_p">
		<div class="news_box_wrapper">
			<div class="section_center_content">
				<div class="col_wrapper big_col_wrapper">
					<div class="flex row">
						<?php
						$featured_args = array(
							'post_type' => 'news',
							'posts_per_page' => 2,
							'orderby' => 'date',
							'order' => 'DESC'
						);
						$featured_query = new WP_Query($featured_args);

						if ($featured_query->have_posts()) :
							while ($featured_query->have_posts()) : $featured_query->the_post();
								$news_banner = get_field('news_banner');
						?>
								<div class="news_box col col6">
									<div class="col_spacing scrollin scrollinbottom">
										<div class="photo">
											<?php if ($news_banner): ?>
												<img src="<?php echo esc_url($news_banner['url']); ?>" alt="<?php echo esc_attr($news_banner['alt']); ?>">
											<?php endif; ?>
										</div>
										<div class="text_wrapper">
											<div class="date_wrapper text2"><?php echo get_the_date('M d'); ?></div>
											<div class="title_wrapper">
												<div class="title text5"><?php the_title(); ?></div>
												<div class="btn_wrapper text8">
													<a href="<?php the_permalink(); ?>" class="round_btn"><?php pll_e('view more'); ?></a>
												</div>
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

	<!-- Regular News Section -->
	<div class="section news_box_section scrollin_p">
		<div class="news_box_wrapper">
			<div class="section_center_content">
				<div class="col_wrapper">
					<div class="flex row" id="news-container">
						<?php
						$args = array(
							'post_type' => 'news',
							'posts_per_page' => NEWS_PER_PAGE,
							'offset' => 2,
							'orderby' => 'date',
							'order' => 'DESC'
						);
						$query = new WP_Query($args);

						if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post();
								$news_banner = get_field('news_banner');
						?>
								<div class="news_box col col4">
									<div class="col_spacing scrollin scrollinbottom">
										<div class="photo">
											<?php if ($news_banner): ?>
												<img src="<?php echo esc_url($news_banner['url']); ?>" alt="<?php echo esc_attr($news_banner['alt']); ?>">
											<?php endif; ?>
										</div>
										<div class="text_wrapper">
											<div class="date_wrapper text5"><?php echo get_the_date('M d'); ?></div>
											<div class="title_wrapper">
												<div class="title text5"><?php the_title(); ?></div>
												<div class="btn_wrapper text8">
													<a href="<?php the_permalink(); ?>" class="round_btn"><?php pll_e('view more'); ?></a>
												</div>
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
					<?php if ($query->max_num_pages > 1) : ?>
						<div class="load_more_wrapper scrollin scrollinbottom">
							<a href="#" class="load_more_btn text5" data-page="1" data-max-pages="<?php echo $query->max_num_pages; ?>">
								<div class="icon"></div>
								<div class="text"><?php pll_e('Load more'); ?></div>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<script>
		jQuery(document).ready(function($) {
			$('.load_more_btn').on('click', function(e) {
				e.preventDefault();
				var button = $(this);
				var page = parseInt(button.data('page'));
				var maxPages = parseInt(button.data('max-pages'));

				$.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					type: 'POST',
					data: {
						action: 'load_more_news',
						nonce: '<?php echo wp_create_nonce('load_more_nonce'); ?>',
						page: page + 1
					},
					beforeSend: function() {
						button.addClass('loading');
					},
					success: function(response) {
						if (response) {
							$('#news-container').append(response);
							button.data('page', page + 1);

							if (page + 1 >= maxPages) {
								button.parent().hide();
							}
						}
					},
					complete: function() {
						button.removeClass('loading');
					}
				});
			});
		});
	</script>

<?php
endwhile;
get_footer();
