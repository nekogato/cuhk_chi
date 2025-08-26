<?php

/**
 * Template for displaying single profile posts
 */

get_header();

// Get the first people category this post belongs to
$people_categories = get_the_terms(get_the_ID(), 'people_category');
$target_page = '';

if ($people_categories && !is_wp_error($people_categories)) {
	foreach ($people_categories as $term) {
		$top_term = $term;

		// Climb up the hierarchy until we find a term with no parent
		while ($top_term->parent != 0) {
			$top_term = get_term($top_term->parent, 'people_category');
		}

		// You can break or use other logic here depending on your goal
		$target_page = "people/" . $top_term->slug;
		break; // if you only care about the first top-most term
	}
}


$terms = get_the_terms(get_the_ID(), 'people_category');

if (!empty($terms) && !is_wp_error($terms)) {
    // Build an array of all assigned term IDs
    $assigned_ids = wp_list_pluck($terms, 'term_id');

    // Find the deepest (most specific) terms: i.e., those whose parent is also in the assigned terms
    $specific_terms = array_filter($terms, function($term) use ($assigned_ids) {
        return !in_array($term->parent, $assigned_ids);
    });

    // Pick the first specific term (or fallback)
    if (!empty($specific_terms)) {
        $term_to_show = array_shift($specific_terms);
    } else {
        $term_to_show = $terms[0];
    }

    echo esc_html($term_to_show->name);
}


// Include roll menu
get_template_part('template-parts/roll-menu', null, array('target_page' => $target_page));

if (have_posts()) :
	while (have_posts()) : the_post();

		// Get ACF fields
		$photo = get_field('photo');
		$position = get_field('position');
		$qualifications = get_field('qualifications');
		$description = get_field('description');

		// Contact information
		$emails = get_field('email');
		$phones = get_field('phone');
		$faxes = get_field('fax');
		$address = get_field('address');

		// Expandable sections
		$research_interests = get_field('research_interests');
		$teaching = get_field('teaching');
		$selected_publications = get_field('selected_publications');
		$research_projects = get_field('research_projects');
		$other_positions_held = get_field('other_positions_held');
		$awards_and_honors = get_field('awards_and_honors');
?>

		<div class="section section_content people_detail_section">
			<div class="section_center_content small_section_center_content">

				<div class="people_detail_content">
					<div class="back_btn_wrapper scrollin scrollinbottom">
						<a href="<?php echo pll_get_page_url("people/teaching-staff")."?people_category=".$parent_slug ?>" class="back_btn"><?php echo cuhk_multilang_text("返回","","Back"); ?></a>
					</div>
					<div class="people_detail_incontent">
						<div class="people_detail_photo_wrapper scrollin scrollinbottom">
							<div class="people_detail_photo">
								<?php if ($photo): ?>
									<img src="<?php echo esc_url($photo['sizes']['large']); ?>"
										alt="<?php echo esc_attr($photo['alt']); ?>">
								<?php endif; ?>
							</div>
						</div>
						<div class="people_detail_text scrollin scrollinbottom">
							<div class="name text4"><?php the_title(); ?></div>
							<?php if ($position): ?>
								<div class="position text5"><?php echo esc_html($position); ?></div>
							<?php endif; ?>

							<?php if ($qualifications): ?>
								<div class="qualifications text6">
									<ul>
										<?php
										$qualification_items = explode(';', $qualifications);
										foreach ($qualification_items as $item):
											$item = trim($item);
											if (!empty($item)):
										?>
												<li><?php echo esc_html($item); ?></li>
										<?php
											endif;
										endforeach;
										?>
									</ul>
								</div>
							<?php endif; ?>

							<div class="info_table text6">
								<div class="table_flex_item_wrapper">
									<?php if ($emails): ?>
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("電郵","","Email"); ?></div>
											<div class="text text6">
												<?php if (is_array($emails)): ?>
													<?php foreach ($emails as $email): ?>
														<a href="mailto:<?php echo esc_attr($email['email']); ?>">
															<?php echo esc_html($email['email']); ?>
														</a><br>
													<?php endforeach; ?>
												<?php endif; ?>
											</div>
										</div>
									<?php endif; ?>

									<?php if ($phones): ?>
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("電話","","Tel"); ?></div>
											<div class="text text6">
												<?php if (is_array($phones)): ?>
													<?php foreach ($phones as $phone): ?>
														<?php echo esc_html($phone['phone']); ?><br>
													<?php endforeach; ?>
												<?php endif; ?>
											</div>
										</div>
									<?php endif; ?>

									<?php if ($faxes): ?>
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("傳真","","Fax"); ?></div>
											<div class="text text6">
												<?php if (is_array($faxes)): ?>
													<?php foreach ($faxes as $fax): ?>
														<?php echo esc_html($fax['fax']); ?><br>
													<?php endforeach; ?>
												<?php endif; ?>
											</div>
										</div>
									<?php endif; ?>

									<?php if ($address): ?>
										<div class="table_flex_item">
											<div class="title text7"><?php echo cuhk_multilang_text("地址","","Address"); ?></div>
											<div class="text text6"><?php echo esc_html($address); ?></div>
										</div>
									<?php endif; ?>
								</div>
							</div>

							<?php if ($description): ?>
								<div class="description">
									<div class="t1 text7"><?php echo cuhk_multilang_text("簡介","","Description"); ?></div>
									<div class="t2 free_text"><?php echo wp_kses_post($description); ?></div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="section_expandable_list scrollin scrollinbottom">
				<?php if ($research_interests): ?>
					<div class="expandable_item">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php echo cuhk_multilang_text("研究興趣","","Research Interests"); ?><div class="icon"></div>
							</div>
							<div class="hidden">
								<div class="hidden_content">
									<div class="free_text">
										<?php echo wp_kses_post($research_interests); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($teaching): ?>
					<div class="expandable_item">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php echo cuhk_multilang_text("任教科目","","Teaching"); ?><div class="icon"></div>
							</div>
							<div class="hidden">
								<div class="hidden_content">
									<div class="free_text">
										<?php echo wp_kses_post($teaching); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($selected_publications): ?>
					<div class="expandable_item">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php echo cuhk_multilang_text("著作選錄","著作选录","Selected Publications"); ?><div class="icon"></div>
							</div>
							<div class="hidden">
								<div class="hidden_content">
									<div class="free_text">
										<?php echo wp_kses_post($selected_publications); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if (have_rows('research_projects')): ?>
					<div class="expandable_item">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php echo cuhk_multilang_text("研究計劃","","Research Projects"); ?><div class="icon"></div>
							</div>
							<div class="hidden">
								<div class="hidden_content">
									<div class="people_detail_content_year_list">
										<table>
											<thead>
												<tr>
													<td class="year"><?php echo cuhk_multilang_text("年度","","Year"); ?></td>
													<td class="free_text"><?php echo cuhk_multilang_text("研究","","Research"); ?></td>
												</tr>
											</thead>
											<tbody>
												<?php while (have_rows('research_projects')): the_row(); ?>
													<tr>
														<td class="year text5"><?php the_sub_field('year'); ?></td>
														<td class="free_text">
															<?php echo wp_kses_post(get_sub_field('free_text')); ?>
														</td>
													</tr>
												<?php endwhile; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($other_positions_held): ?>
					<div class="expandable_item">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php echo cuhk_multilang_text("其他職銜","","Other Positions Held"); ?><div class="icon"></div>
							</div>
							<div class="hidden">
								<div class="hidden_content">
									<div class="free_text">
										<?php echo wp_kses_post($other_positions_held); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if (have_rows('awards_and_honors')): ?>
					<div class="expandable_item">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php echo cuhk_multilang_text("獎項與榮譽","","Awards and Honors"); ?><div class="icon"></div>
							</div>
							<div class="hidden">
								<div class="hidden_content">
									<div class="people_detail_content_year_list">
										<table>
											<thead>
												<tr>
													<td class="year"><?php echo cuhk_multilang_text("年度","","Year"); ?></td>
													<td class="free_text"><?php echo cuhk_multilang_text("獎項","","Awards"); ?></td>
												</tr>
											</thead>
											<tbody>
												<?php while (have_rows('awards_and_honors')): the_row(); ?>
													<tr>
														<td class="year text5"><?php the_sub_field('year'); ?></td>
														<td class="free_text">
															<?php echo wp_kses_post(get_sub_field('free_text')); ?>
														</td>
													</tr>
												<?php endwhile; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

<?php
	endwhile;
endif;

get_footer(); ?>