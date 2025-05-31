<?php

/**
 * Template for displaying single profile posts
 */

get_header();

// Include roll menu
get_template_part('template-parts/roll-menu');

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
							<div class="name text3"><?php the_title(); ?></div>
							<?php if ($position): ?>
								<div class="position text5"><?php echo esc_html($position); ?></div>
							<?php endif; ?>

							<?php if ($qualifications): ?>
								<div class="qualifications text6">
									<?php echo wp_kses_post($qualifications); ?>
								</div>
							<?php endif; ?>

							<div class="info_table text6">
								<div class="table_flex_item_wrapper">
									<?php if ($emails): ?>
										<div class="table_flex_item">
											<div class="title text7"><?php pll_e('Email'); ?></div>
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
											<div class="title text7"><?php pll_e('Tel'); ?></div>
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
											<div class="title text7"><?php pll_e('Fax'); ?></div>
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
											<div class="title text7"><?php pll_e('Address'); ?></div>
											<div class="text text6"><?php echo esc_html($address); ?></div>
										</div>
									<?php endif; ?>
								</div>
							</div>

							<?php if ($description): ?>
								<div class="description">
									<div class="t1 text7"><?php pll_e('Description'); ?></div>
									<div class="t2 free_text"><?php echo wp_kses_post($description); ?></div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="section_expandable_list scrollin_p">
				<?php if ($research_interests): ?>
					<div class="expandable_item scrollin scrollinbottom">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php pll_e('研究專長'); ?><div class="icon"></div>
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
					<div class="expandable_item scrollin scrollinbottom">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php pll_e('任教科目'); ?><div class="icon"></div>
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
					<div class="expandable_item scrollin scrollinbottom">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php pll_e('著作選錄'); ?><div class="icon"></div>
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
					<div class="expandable_item scrollin scrollinbottom">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php pll_e('研究計劃'); ?><div class="icon"></div>
							</div>
							<div class="hidden">
								<div class="hidden_content">
									<div class="people_detail_content_year_list">
										<table>
											<thead>
												<tr>
													<td class="year"><?php pll_e('年份'); ?></td>
													<td class="free_text"><?php pll_e('研究'); ?></td>
												</tr>
											</thead>
											<tbody>
												<?php while (have_rows('research_projects')): the_row(); ?>
													<tr>
														<td class="year text5"><?php the_sub_field('year'); ?></td>
														<td class="free_text">
															<?php echo wp_kses_post(get_sub_field('project_description')); ?>
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
					<div class="expandable_item scrollin scrollinbottom">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php pll_e('其他職銜'); ?><div class="icon"></div>
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
					<div class="expandable_item scrollin scrollinbottom">
						<div class="section_center_content small_section_center_content">
							<div class="expandable_title text5"><?php pll_e('獎項與榮譽'); ?><div class="icon"></div>
							</div>
							<div class="hidden">
								<div class="hidden_content">
									<div class="people_detail_content_year_list">
										<table>
											<thead>
												<tr>
													<td class="year"><?php pll_e('年份'); ?></td>
													<td class="free_text"><?php pll_e('獎項'); ?></td>
												</tr>
											</thead>
											<tbody>
												<?php while (have_rows('awards_and_honors')): the_row(); ?>
													<tr>
														<td class="year text5"><?php the_sub_field('year'); ?></td>
														<td class="free_text">
															<?php echo wp_kses_post(get_sub_field('award_description')); ?>
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