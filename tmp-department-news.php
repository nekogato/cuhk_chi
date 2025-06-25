<?php
/*
Template Name: Department News
*/

get_header(); ?>

<?php get_template_part('template-parts/roll-menu'); ?>

<div class="section section_content section_intro">
	<div class="section_center_content small_section_center_content">
		<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
		<div class="section_description scrollin scrollinbottom col6">
			<?php
			$page_description = get_field('introduction');
			if ($page_description) {
				echo esc_html($page_description);
			}
			?>
		</div>
	</div>
</div>

<?php
// Query to get department news
$args = array(
	'post_type' => 'department_news',
	'posts_per_page' => MAX_DEPARTMENT_NEWS,
	'orderby' => 'date',
	'order' => 'DESC',
    'post_status' => 'publish',
);

$all_news = new WP_Query($args);
$featured_news = array();
$regular_news = array();

if ($all_news->have_posts()) {
	$count = 0;
	while ($all_news->have_posts()) {
		$all_news->the_post();

		// Get category from taxonomy
		$categories = wp_get_post_terms(get_the_ID(), 'department-category');
		$category_name = !empty($categories) ? $categories[0]->name : '';

		$news_data = array(
			'id' => get_the_ID(),
			'title' => get_the_title(),
			'permalink' => get_permalink(),
			'date' => DateTime::createFromFormat('U', get_post_time('U'))->format('M d'),
			'banner_url' => '', // Will be set based on featured/regular
			'banner_alt' => get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true),
			'category' => $category_name
		);

		// First 2 posts are featured
		if ($count < 2) {
			$news_data['banner_url'] = get_the_post_thumbnail_url(get_the_ID(), 'department-news-featured');
			$featured_news[] = $news_data;
		} else {
			$news_data['banner_url'] = get_the_post_thumbnail_url(get_the_ID(), 'department-news-regular');
			$regular_news[] = $news_data;
		}
		$count++;
	}
	wp_reset_postdata();
}
?>

<?php if (!empty($featured_news)) : ?>
	<div class="section featured_news_box_section scrollin_p">
		<div class="news_box_wrapper">
			<div class="section_center_content small_section_center_content">
				<div class="col_wrapper big_col_wrapper">
					<div class="flex row">
						<?php foreach ($featured_news as $news) : ?>
							<div class="news_box col col6">
								<div class="col_spacing scrollin scrollinbottom">
									<div class="photo">
										<?php if ($news['banner_url']) : ?>
											<img src="<?php echo esc_url($news['banner_url']); ?>" alt="<?php echo esc_attr($news['banner_alt']); ?>">
										<?php endif; ?>
									</div>
									<div class="text_wrapper">
										<div class="date_wrapper text2"><?php echo esc_html($news['date']); ?></div>
										<div class="title_wrapper">
											<div class="cat"><?php echo esc_html($news['category']); ?></div>
											<div class="title text5"><?php echo esc_html($news['title']); ?></div>
											<div class="btn_wrapper text8">
												<a href="<?php echo esc_url($news['permalink']); ?>" class="round_btn"><?php pll_e('了解更多'); ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if (!empty($regular_news)) : ?>
	<div class="section news_box_section scrollin_p">
		<div class="news_box_wrapper">
			<div class="section_center_content small_section_center_content">
				<div class="col_wrapper">
					<div class="flex row" id="department-news-container">
						<?php
						// Show first batch of regular news (first MAX_DEPARTMENT_NEWS items)
						$displayed = 0;
						foreach ($regular_news as $news) :
							if ($displayed >= MAX_DEPARTMENT_NEWS) break;
						?>
							<div class="news_box col col4">
								<div class="col_spacing scrollin scrollinbottom">
									<div class="photo">
										<?php if ($news['banner_url']) : ?>
											<img src="<?php echo esc_url($news['banner_url']); ?>" alt="<?php echo esc_attr($news['banner_alt']); ?>">
										<?php endif; ?>
									</div>
									<div class="text_wrapper">
										<div class="date_wrapper text5"><?php echo esc_html($news['date']); ?></div>
										<div class="title_wrapper">
											<div class="cat"><?php echo esc_html($news['category']); ?></div>
											<div class="title text5"><?php echo esc_html($news['title']); ?></div>
											<div class="btn_wrapper text8">
												<a href="<?php echo esc_url($news['permalink']); ?>" class="round_btn"><?php pll_e('了解更多'); ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php
							$displayed++;
						endforeach; ?>
					</div>
				</div>

				<?php if (count($regular_news) > MAX_DEPARTMENT_NEWS) : ?>
					<div class="load_more_wrapper scrollin scrollinbottom">
						<a class="load_more_btn text5" id="load-more-department-news"
							data-page="1"
							data-nonce="<?php echo wp_create_nonce('load_more_department_news_nonce'); ?>">
							<div class="icon"></div>
							<div class="text"><?php echo cuhk_multilang_text("載入更多","","Load more"); ?></div>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<script>
	jQuery(document).ready(function($) {
		$('#load-more-department-news').on('click', function(e) {
			e.preventDefault();

			var button = $(this);
			var page = button.data('page');
			var nonce = button.data('nonce');

			$.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				type: 'POST',
				data: {
					action: 'load_more_department_news',
					page: page,
					nonce: nonce
				},
				beforeSend: function() {
					button.find('.text').text('<?php pll_e('Loading...'); ?>');
				},
				success: function(response) {
					if (response.success) {
						$('#department-news-container .row').append(response.data.html);
						button.data('page', page + 1);
						button.find('.text').text('<?php echo cuhk_multilang_text("載入更多","","Load more"); ?>');

						if (!response.data.has_more) {
							button.hide();
						}
					} else {
						button.find('.text').text('<?php pll_e('No more posts'); ?>');
					}
				},
				error: function() {
					button.find('.text').text('<?php echo cuhk_multilang_text("載入更多","","Load more"); ?>');
				}
			});
		});
	});
</script>

<?php get_footer(); ?>