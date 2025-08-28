<?php

/**
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu', null, array('target_page' => 'research/publications')); ?>

<div class="section section_content people_detail_section">
	<div class="section_center_content small_section_center_content">
		<div class="col10 center_content">
			<div class="people_detail_content">
				<div class="back_btn_wrapper scrollin scrollinbottom "><a href="javascript:history.back()" class="back_btn"><?php echo cuhk_multilang_text("返回","","Back"); ?></a></div>
				<div class="people_detail_incontent">
					<?php
					while (have_posts()) :
						the_post();
						$author = get_field('author');
						$publisher = get_field('publisher');
						$publish_year = get_field('year_and_month_of_publication');
						$cover_image = get_field('cover_photo');
						$chief_editor = get_field('chief_editor');
						$editor = get_field('editors');
						$isbn = get_field('isbn__issn');
						$abstract = get_field('abstract');
						$composition = get_field('composition');
						$external_link = get_field('external_link');
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
							<div class="name text3"><?php the_field("title"); ?></div>
							<div class="info_table text6">
								<div class="table_flex_item_wrapper">
									<?php if ($author) : ?>
										<div class="table_flex_item col6">
											<div class="title text7"><?php echo cuhk_multilang_text("作者","","Author"); ?></div>
											<div class="text text6"><?php echo ($author); ?></div>
										</div>
									<?php endif; ?>
									<?php if ($publisher) : ?>
										<div class="table_flex_item col6">
											<div class="title text7"><?php echo cuhk_multilang_text("出版社","","Publisher"); ?></div>
											<div class="text text6"><?php echo ($publisher); ?></div>
										</div>
									<?php endif; ?>
									<?php if ($publish_year) : ?>
										<div class="table_flex_item col6">
											<div class="title text7"><?php echo cuhk_multilang_text("出版年份","","Publish Year"); ?></div>
											<div class="text text6"><?php echo ($publish_year); ?></div>
										</div>
									<?php endif; ?>
									<?php if ($chief_editor) : ?>
										<div class="table_flex_item col6">
											<div class="title text7"><?php echo cuhk_multilang_text("主編","","Chief Editor"); ?></div>
											<div class="text text6"><?php echo ($chief_editor); ?></div>
										</div>
									<?php endif; ?>
									<?php if ($editor) : ?>
										<div class="table_flex_item col6">
											<div class="title text7"><?php echo cuhk_multilang_text("編輯","","Editor"); ?></div>
											<div class="text text6"><?php echo ($editor); ?></div>
										</div>
									<?php endif; ?>
									<?php if ($composition) : ?>
										<div class="table_flex_item col6">
											<div class="title text7"><?php echo cuhk_multilang_text("排版印刷","","Composition"); ?></div>
											<div class="text text6"><?php echo ($composition); ?></div>
										</div>
									<?php endif; ?>
									<?php if ($isbn) : ?>
										<div class="table_flex_item col6">
											<div class="title text7"><?php echo cuhk_multilang_text("ISBN / ISSN","","ISBN / ISSN"); ?></div>
											<div class="text text6"><?php echo ($isbn); ?></div>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<?php if ($abstract) : ?>
								<div class="description">
									<div class="t1 text7"><?php echo cuhk_multilang_text("撮要","","Abstract"); ?></div>
									<div class="t2 free_text">
										<?php echo ($abstract); ?>
									</div>
								</div>
							<?php endif; ?>
							<?php if ($external_link) : ?>
								<div class="description">
									<div class="t2 free_text">
										<a href="<?php echo ($external_link); ?>" target="_blank" class="round_btn"><?php echo cuhk_multilang_text("點擊查看目錄","","Click here to view contents"); ?></a>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
