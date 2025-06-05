<?php /* Template Name: General Flexible Content */ ?>
<?php
/**
 * The template for displaying pages with flexible content layouts
 * Supports multiple content sections including free text and expandable FAQ sections
 * Can be used for Further Study & Employment, FAQ, Admission, and other content types
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

	<div class="section section_content admission_section scrollin scrollinbottom onscreen startani resource_top_section">
		<div class="section_center_content small_section_center_content">

			<?php if ($page_title) : ?>
				<h1 class="section_title text1 scrollin scrollinbottom"><?php echo esc_html($page_title); ?></h1>
			<?php endif; ?>
			<?php if ($page_description) : ?>
				<div class="section_description scrollin scrollinbottom"><?php echo wp_kses_post($page_description); ?></div>
			<?php endif; ?>

			<?php if (have_rows('content_sections')) : ?>
				<?php while (have_rows('content_sections')) : the_row(); ?>

					<?php if (get_row_layout() == 'free_text') : ?>
						<?php $content = get_sub_field('content'); ?>
						<?php if ($content) : ?>
							<!-- Free Text Content Section -->
							<div class="section_introduction scrollin scrollinbottom onscreen startani">
								<div class="free_text">
									<?php echo apply_filters('the_content', $content); ?>
								</div>
							</div>
						<?php endif; ?>

					<?php elseif (get_row_layout() == 'expandable_section') : ?>
						<?php
						$introduction = get_sub_field('introduction');
						$expandable_items = get_sub_field('expandable_items');
						?>
						<!-- Expandable FAQ/Admission Style Content Section -->
						<div class="section_expandable_list">
							<?php if ($expandable_items) : ?>
								<?php $first_item = true; ?>
								<?php foreach ($expandable_items as $item) : ?>
									<?php
									$question = $item['question'];
									$answer = $item['answer'];
									$is_active = $item['is_active'];
									$active_class = ($is_active) ? ' active' : '';
									$first_item = false;
									?>
									<div class="expandable_item<?php echo $active_class; ?>">
										<div class="section_center_content small_section_center_content">
											<div class="expandable_title text5"><?php echo esc_html($question); ?><div class="icon"></div>
											</div>
											<div class="hidden">
												<div class="hidden_content">
													<div class="free_text">
														<?php echo apply_filters('the_content', $answer); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>

					<?php endif; ?>

				<?php endwhile; ?>
			<?php endif; ?>

		<?php
	endwhile;
		?>
		</div>
	</div>

	<?php
	get_footer();
