<?php /* Template Name: Events Index */ ?>
<?php
/**
 * The template for displaying the events index page
 *
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu'); ?>

<?php
while (have_posts()) :
	the_post();
	$page_title = get_the_title();
	$page_description = get_field("introduction");
?>

	<div class="section section_content section_intro">
		<div class="section_center_content">
			<?php if ($page_title) : ?>
				<h1 class="section_title text1 scrollin scrollinbottom"><?php echo esc_html($page_title); ?></h1>
			<?php endif; ?>
			<?php if ($page_description) : ?>
				<div class="section_description scrollin scrollinbottom col6"><?php echo wp_kses_post($page_description); ?></div>
			<?php endif; ?>
		</div>
	</div>

	<?php
	$args = array(
		'post_type' => 'event',
		'posts_per_page' => EVENTS_PER_PAGE,
		'orderby' => 'meta_value',
		'meta_key' => 'start_date',
		'order' => 'ASC'
	);
	$query = new WP_Query($args);

	if ($query->have_posts()) :
	?>
		<div class="section event_list_section scrollin_p">
			<div class="section_center_content">
				<div class="event_list_item_wrapper">
					<?php
					while ($query->have_posts()) :
						$query->the_post();

						$event_name = get_field('event_name');
						$event_banner = get_field('event_banner');
						$start_date = get_field('start_date');
						$end_date = get_field('end_date');
						$event_time = get_field('event_time');
						$event_venue = get_field('event_venue');

						// Format dates
						$start_date_obj = DateTime::createFromFormat('d/m/Y', $start_date);
						$end_date_obj = DateTime::createFromFormat('d/m/Y', $end_date);
					?>
						<div class="event_list_item flex">
							<div class="date">
								<div class="d_wrapper">
									<?php if ($start_date && $end_date && $start_date !== $end_date) : ?>
										<div class="d">
											<div class="d1 text3"><?php echo $start_date_obj->format('M'); ?></div>
											<div class="d2 text5"><?php echo $start_date_obj->format('d'); ?></div>
										</div>
										<div class="d">
											<div class="d1 text3"><?php echo $end_date_obj->format('M'); ?></div>
											<div class="d2 text5"><?php echo $end_date_obj->format('d'); ?></div>
										</div>
									<?php else : ?>
										<div class="d">
											<div class="d1 text3"><?php echo $start_date_obj->format('M'); ?></div>
											<div class="d2 text5"><?php echo $start_date_obj->format('d'); ?></div>
										</div>
									<?php endif; ?>
								</div>
								<div class="btn_wrapper">
									<a href="<?php the_permalink(); ?>" class="reg_btn round_btn text7"><?php pll_e('了解更多'); ?></a>
								</div>
							</div>
							<div class="title_wrapper">
								<div class="title text5"><?php echo esc_html($event_name); ?></div>
								<div class="info_item_wrapper">
									<div class="info_item">
										<div class="t1"><?php pll_e('日期'); ?></div>
										<div class="t2 text6">
											<?php
											if ($start_date && $end_date && $start_date !== $end_date) {
												echo esc_html($start_date_obj->format('Y年m月d日') . '－' . $end_date_obj->format('Y年m月d日'));
											} else {
												echo esc_html($start_date_obj->format('Y年m月d日'));
											}
											?>
										</div>
									</div>
									<?php if ($event_time) : ?>
										<div class="info_item">
											<div class="t1"><?php pll_e('時間'); ?></div>
											<div class="t2 text6"><?php echo esc_html($event_time); ?></div>
										</div>
									<?php endif; ?>
									<?php if ($event_venue) : ?>
										<div class="info_item big_info_item">
											<div class="t1"><?php pll_e('地點'); ?></div>
											<div class="t2 text6"><?php echo esc_html($event_venue); ?></div>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<?php if ($event_banner) : ?>
								<div class="photo">
									<img src="<?php echo esc_url($event_banner['sizes']['l']); ?>" alt="<?php echo esc_attr($event_banner['alt']); ?>">
								</div>
							<?php endif; ?>
						</div>
					<?php
					endwhile;
					wp_reset_postdata();
					?>

					<?php if ($query->max_num_pages > 1) : ?>
						<div class="load_more_wrapper scrollin scrollinbottom">
							<a href="#" class="load_more_btn text5" data-page="1" data-max-pages="<?php echo esc_attr($query->max_num_pages); ?>">
								<div class="icon"></div>
								<div class="text"><?php pll_e('Load more'); ?></div>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
<?php
	endif;
endwhile;
?>

<script>
	jQuery(document).ready(function($) {
		var loading = false;
		var page = 1;
		var maxPages = $('.load_more_btn').data('max-pages');

		$('.load_more_btn').on('click', function(e) {
			e.preventDefault();

			if (loading || page >= maxPages) return;

			loading = true;
			page++;

			var $btn = $(this);
			var $wrapper = $('.event_list_item_wrapper');

			$.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				type: 'POST',
				data: {
					action: 'load_more_events',
					nonce: '<?php echo wp_create_nonce('load_more_events_nonce'); ?>',
					page: page
				},
				success: function(response) {
					if (response.success) {
						$wrapper.find('.load_more_wrapper').before(response.data.html);

						if (page >= maxPages) {
							$btn.parent().remove();
						}
					}
					loading = false;
				},
				error: function() {
					loading = false;
				}
			});
		});
	});
</script>

<?php
get_footer();
