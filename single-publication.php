<?php

/**
 * @package cuhk_chi
 */

get_header();
?>

<div class="header_bg"></div>
<?php get_template_part('template-parts/roll-menu'); ?>

<div class="section section_content people_detail_section">
	<div class="section_center_content small_section_center_content">
		<div class="people_detail_content">
			<div class="people_detail_incontent">
				<?php
				while (have_posts()) :
					the_post();
					$author = get_field('author');
					$publisher = get_field('publisher');
					$publish_year = get_field('publish_year');
					$cover_image = get_field('cover_photo');
					$chief_editor = get_field('chief_editor');
					$editor = get_field('editors');
					$isbn = get_field('isbn');
					$abstract = get_field('abstract');
					$composition = get_field('composition');
				?>
					<div class="people_detail_photo_wrapper scrollin scrollinbottom">
						<?php if ($cover_image) : ?>
							<div class="people_detail_photo people_detail_photo_shadow">
								<a href="<?php echo esc_url($cover_image['url']); ?>">
									<img src="<?php echo esc_url($cover_image['url']); ?>" alt="<?php echo esc_attr($cover_image['alt']); ?>">
								</a>
							</div>
						<?php endif; ?>
					</div>
					<div class="people_detail_text scrollin scrollinbottom">
						<div class="name text3"><?php the_title(); ?></div>
						<div class="info_table text6">
							<div class="table_flex_item_wrapper">
								<?php if ($author) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php pll_e('作者'); ?></div>
										<div class="text text6"><?php echo esc_html($author); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($publisher) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php pll_e('出版社'); ?></div>
										<div class="text text6"><?php echo esc_html($publisher); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($publish_year) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php pll_e('出版年份'); ?></div>
										<div class="text text6"><?php echo esc_html($publish_year); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($chief_editor) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php pll_e('主編'); ?></div>
										<div class="text text6"><?php echo esc_html($chief_editor); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($editor) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php pll_e('編輯'); ?></div>
										<div class="text text6"><?php echo esc_html($editor); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($composition) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php pll_e('排版印刷'); ?></div>
										<div class="text text6"><?php echo esc_html($composition); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($isbn) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php pll_e('ISBN / ISSN'); ?></div>
										<div class="text text6"><?php echo esc_html($isbn); ?></div>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<?php if ($abstract) : ?>
							<div class="description">
								<div class="t1 text7"><?php pll_e('撮要'); ?></div>
								<div class="t2 free_text">
									<?php echo wpautop($abstract); ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
