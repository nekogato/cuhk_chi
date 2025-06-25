<?php
/*
Template Name: Announcements
*/

get_header(); ?>

<?php get_template_part('template-parts/roll-menu'); ?>

<div class="section section_content">
	<div class="section_center_content">
		<h1 class="section_title text1 scrollin scrollinbottom"><?php the_title(); ?></h1>
	</div>

	<div class="section_expandable_list">
		<?php
		$args = array(
			'post_type' => 'announcement',
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'DESC',
    		'post_status' => 'publish',
		);

		$announcements = new WP_Query($args);

		if ($announcements->have_posts()) :
			while ($announcements->have_posts()) : $announcements->the_post();
				// Get fields
				$announcement_title = get_the_title();

				// Force English date format using PHP DateTime directly
				$post_date = get_post_time('Y-m-d');
				$date_obj = new DateTime($post_date);
				$announcement_date = $date_obj->format('j F Y');

				$announcement_content = get_the_content();
		?>
				<div class="expandable_item">
					<div class="section_center_content small_section_center_content">
						<div class="expandable_title">
							<div class="announcement_title">
								<div class="text5 title"><?php echo esc_html($announcement_title); ?></div>
								<div class="date"><?php echo esc_html($announcement_date); ?></div>
							</div>
							<div class="icon"></div>
						</div>
						<div class="hidden">
							<div class="hidden_content">
								<div class="free_text">
									<?php echo wp_kses_post($announcement_content); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			endwhile;
			wp_reset_postdata();
		else :
			?>
			<div class="section_center_content">
				<p class="text5"><?php pll_e('No announcements'); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>