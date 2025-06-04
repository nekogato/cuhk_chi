<?php /* Template Name: FAQ */ ?>
<?php
/**
 * The template for displaying the FAQ page
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

	<div class="section section_content admission_section scrollin scrollinbottom">
		<div class="section_center_content small_section_center_content">
			<?php if ($page_title) : ?>
				<h1 class="section_title text1 scrollin scrollinbottom"><?php echo esc_html($page_title); ?></h1>
			<?php endif; ?>
			<?php if ($page_description) : ?>
				<div class="section_description scrollin scrollinbottom"><?php echo wp_kses_post($page_description); ?></div>
			<?php endif; ?>
		</div>
		<div class="section_expandable_list">
			<?php if (have_rows('faq_items')) : ?>
				<?php while (have_rows('faq_items')) : the_row();
					$question = get_sub_field('question');
					$answer = get_sub_field('answer');
				?>
					<div class="expandable_item">
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
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>

<?php
endwhile;
?>

<?php
get_footer();
