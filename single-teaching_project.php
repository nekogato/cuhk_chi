<?php

/**
 * @package cuhk_chi
 */

get_header();
?>

<?php get_template_part('template-parts/roll-menu', null, array('target_page' => 'study/chinese-language-courses')); ?>

<div class="section section_content people_detail_section">
	<div class="section_center_content small_section_center_content">
		<div class="people_detail_content">
			<div class="people_detail_incontent">
				<?php
				while (have_posts()) :
					the_post();
					$funded_by = get_field('funded_by');
					$title = get_field('project_title');
					$start_year = get_field('start_year');
					$end_year = get_field('end_year');
					$principle_investigator = get_field('principle_investigator');
					$other_investigator = get_field('other_investigator');
					$granted_amount = get_field('granted_amount');
					$funding_organization = get_field('funding_organization');
					$description = get_field('description');
					$other_information = get_field('other_information');

                    $thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    $alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'l');
				?>
					<div class="people_detail_photo_wrapper scrollin scrollinbottom">
						<?php if ($image_url) : ?>
                            
							<div class="people_detail_photo people_detail_photo_shadow">
								<a href="<?php echo $image_url; ?>">
									<img src="<?php echo $image_url; ?>" alt="<?php echo $alt_text; ?>">
								</a>
							</div>
						<?php endif; ?>
					</div>
					<div class="people_detail_text scrollin scrollinbottom">
						<?php if ($funded_by) : ?>
						<div class="funded_by text3"><?php echo $funded_by; ?></div>
						<?php endif; ?>
						<div class="name text3"><?php echo $title; ?></div>
						<div class="info_table text6">
							<div class="table_flex_item_wrapper">
								<?php if ($author) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php echo cuhk_multilang_text("作者","","Author"); ?></div>
										<div class="text text6"><?php echo ($author); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($start_year) {
                                    if ($end_year) {
                                        $formatted_year = $start_year . '/' . substr($end_year, -2);
                                    } else {
                                        $formatted_year = $start_year;
                                    }
                                    ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php echo cuhk_multilang_text("年份","","Year"); ?></div>
										<div class="text text6"><?php echo ($formatted_year); ?></div>
									</div>
                                    <?php
                                } ?>
								<?php if ($principle_investigator) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php echo cuhk_multilang_text("計劃主持","","Principle Investigator"); ?></div>
										<div class="text text6"><?php echo ($principle_investigator); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($other_investigator) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php echo cuhk_multilang_text("其他研究員","","Other Investigator"); ?></div>
										<div class="text text6"><?php echo ($other_investigator); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($granted_amount) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php echo cuhk_multilang_text("撥款金額","","Granted Amount"); ?></div>
										<div class="text text6"><?php echo ($granted_amount); ?></div>
									</div>
								<?php endif; ?>
								<?php if ($funding_organization) : ?>
									<div class="table_flex_item col6">
										<div class="title text7"><?php echo cuhk_multilang_text("撥款機構","","Funding Organization"); ?></div>
										<div class="text text6"><?php echo ($funding_organization); ?></div>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<?php if ($description) : ?>
							<div class="description">
								<div class="t1 text7"><?php echo cuhk_multilang_text("計劃概述","","Description"); ?></div>
								<div class="t2 free_text">
									<?php echo ($description); ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($other_information) : ?>
							<div class="description">
								<div class="t1 text7"><?php echo cuhk_multilang_text("其他資料","","Other Information"); ?></div>
								<div class="t2 free_text">
									<?php echo ($other_information); ?>
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
