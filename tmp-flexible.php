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
?>

	<?php if ($page_title) : ?>
		<div class="section section_content">
			<div class="section_center_content small_section_center_content">
				<h1 class="section_title text1 scrollin scrollinbottom"><?php echo esc_html($page_title); ?></h1>
			</div>
		</div>
	<?php endif; ?>

	<?php if (have_rows('content_sections')) : ?>
		<?php while (have_rows('content_sections')) : the_row(); ?>

			<?php if (get_row_layout() == 'free_text') : ?>
				<?php $content = get_sub_field('content'); ?>
				<?php if ($content) : ?>
					<!-- Free Text Content Section -->
					<div class="section section_content resource_top_section">
						<div class="section_center_content small_section_center_content">
							<div class="section_introduction scrollin scrollinbottom">
								<div class="free_text">
									<?php echo wp_kses_post($content); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

			<?php elseif (get_row_layout() == 'expandable_section') : ?>
				<?php
				$introduction = get_sub_field('introduction');
				$expandable_items = get_sub_field('expandable_items');
				?>
				<!-- Expandable FAQ/Admission Style Content Section -->
				<div class="section section_content admission_section scrollin scrollinbottom">
					<div class="section_center_content small_section_center_content">
						<?php if ($introduction) : ?>
							<div class="section_description scrollin scrollinbottom"><?php echo wp_kses_post($introduction); ?></div>
						<?php endif; ?>
					</div>
					<div class="section_expandable_list">
						<?php if ($expandable_items) : ?>
							<?php $first_item = true; ?>
							<?php foreach ($expandable_items as $item) : ?>
								<?php
								$question = $item['question'];
								$answer = $item['answer'];
								$is_active = $item['is_active'];
								$active_class = ($is_active || $first_item) ? ' active' : '';
								$first_item = false;
								?>
								<div class="expandable_item<?php echo $active_class; ?>">
									<div class="section_center_content small_section_center_content">
										<div class="expandable_title text5"><?php echo esc_html($question); ?><div class="icon"></div>
										</div>
										<div class="hidden">
											<div class="hidden_content">
												<div class="free_text">
													<?php echo wp_kses_post($answer); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

			<?php endif; ?>

		<?php endwhile; ?>
	<?php endif; ?>

<?php
endwhile;
?>

<?php
get_footer();
