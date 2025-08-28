<?php /* Template Name: About Song */ ?>
<?php
/**
 * The template for displaying the about song page
 *
 * @package cuhk_chi
 */

get_header();
?>


<?php get_template_part('template-parts/roll-menu'); ?>

	<div class="ink_bg12_wrapper">
		<img src="<?php echo get_template_directory_uri(); ?>/images/ink_bg6.jpg" class="ink_bg12 scrollin scrollinbottom">
	</div>
<div class="section section_song scrollin_p">
	<div class="main_song_content">
		<div class="main_song_wrapper scrollin scrollinbottom">
			<div class="section_center_content small_section_center_content">
				<div class="col10 center_content">
					<?php if (have_rows('song_repeater')) : ?>
						<div class="main_song_btn_wrapper">
							<ul>
								<?php
								$firsttext;
								$first = true;
								while (have_rows('song_repeater')) : the_row();
									$version_name = get_sub_field('version_name');
									$song_file = get_sub_field('song_file');
									$firsttext = $version_name;
									if ($song_file) :
								?>
										<li>
											<a href="#" data-song="<?php echo esc_url($song_file['url']); ?>" class="song_btn <?php echo $first ? 'active' : ''; ?>">
												<?php echo esc_html($version_name); ?>
											</a>
										</li>
								<?php
										$first = false;
									endif;
								endwhile;
								?>
							</ul>
						</div>
					<?php endif; ?>

					<div class="main_song">
						<?php
						$song_thumb = get_field('song_thumb');
						if ($song_thumb) :
						?>
							<div class="song_thumb">
								<a href="<?php echo esc_url($song_thumb['url']); ?>" data-fancybox>
									<img src="<?php echo esc_url($song_thumb['sizes']['xl']); ?>" alt="<?php echo esc_attr($song_thumb['alt']); ?>">
								</a>
							</div>
						<?php endif; ?>

						<div class="song_text">
							<div class="song_text_top">
								<div class="name">
									<?php if (get_field('song_small_title')) : ?>
										<div class="t1 text5"><?php the_field('song_small_title'); ?></div>
									<?php endif; ?>
									<?php if (get_field('song_name')) : ?>
										<div class="t2 text2"><?php the_field('song_name'); ?> - <span class="version_name"><?php echo $firsttext;?></span></div>
									<?php endif; ?>
								</div>
								<?php if (get_field('song_short_info')) : ?>
									<div class="info"><?php the_field('song_short_info'); ?></div>
								<?php endif; ?>
							</div>

							<div class="song_player_wrapper">
								<div class="audio-player">
									<table>
										<tbody>
											<tr>
												<td class="play-btn-td">
													<div class="play-btn"></div>
													<div class="pause-btn active"></div>
												</td>
												<td>
													<div class="audio-wrapper player-container" href="javascript:;">
														<audio class="player">
															<?php
															if (have_rows('song_repeater')) :
																while (have_rows('song_repeater')) : the_row();
																	$song_file = get_sub_field('song_file');
																	if ($song_file) :
															?>
																		<source src="<?php echo esc_url($song_file['url']); ?>" type="audio/mp3">
															<?php
																		break;
																	endif;
																endwhile;
															endif;
															?>
														</audio>
													</div>
													<div class="player-controls scrubber">
														<div class="seekObjContainer">
															<progress class="seekObj" value="0" max="1"></progress>
														</div>
														<div class="pbg"></div>
														<div class="pbar"></div>
													</div>
												</td>
												<td class="time-td">
													<span class="start-time">00:00</span> / <span class="end-time">00:00</span>
												</td>
											</tr>
										</tbody>
									</table>
									<div class="loader"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if (get_field('section_name') || get_field('section_description')) : ?>
		<div class="song_section_intro scrollin scrollinbottom">
			<div class="section_center_content small_section_center_content">
				<div class="col10 center_content">
					<?php if (get_field('section_name')) : ?>
						<h1 class="section_title text1 scrollin scrollinbottom"><?php echo wp_kses_post(get_field('section_name')); ?></h1>
					<?php endif; ?>
					<?php if (get_field('section_description')) : ?>
						<div class="section_description scrollin scrollinbottom col6"><?php echo wp_kses_post(get_field('section_description')); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="song_section_text">
		<div class="section_center_content small_section_center_content scrollin scrollinbottom">
			<div class="col10 center_content">
				<?php if (get_field('song_info')) : ?>
					<div class="basic_description free_text" style="color:#6f6ea6">
						<?php echo wp_kses_post(get_field('song_info')); ?>
					</div>
				<?php endif; ?>

				<div class="col_wrapper">
					<div class="flex row">
						<div class="col col5">
							<div class="col_spacing">
								<div class="left_content free_text" style="color:#6f6ea6">
									<?php if (get_field('song_lyrics')) : ?>
										<?php echo wp_kses_post(get_field('song_lyrics')); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="col col6">
							<div class="col_spacing">
								<div class="right_content">
									<div class="flexible_layout_wrapper">
										<?php
										$song_img = get_field('song_img');
										if ($song_img) :
										?>
											<div class="flexible_layout flexible_layout_photo scrollin scrollinbottom">
												<div class="photo">
													<img src="<?php echo esc_url($song_img['sizes']['xl']); ?>" alt="<?php echo esc_attr($song_img['alt']); ?>">
												</div>
												<?php if (get_field('song_img_caption')) : ?>
													<div class="caption"><?php echo wp_kses_post(get_field('song_img_caption')); ?></div>
												<?php endif; ?>
											</div>
										<?php endif; ?>

										<?php if (get_field('song_remark')) : ?>
											<div class="flexible_layout flexible_layout_freetext scrollin scrollinbottom">
												<div class="free_text text8">
													<?php echo wp_kses_post(get_field('song_remark')); ?>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
