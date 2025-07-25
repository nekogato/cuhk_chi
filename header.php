<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cuhk_chi
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>
<?php
global $style_class;
if (pll_current_language() == 'sc' || pll_current_language() == 'tc') {
    $style_class .= ' zh_body';
}else{
    $style_class .= ' en_body';
}

if (pll_current_language() == 'sc') {
    $style_class .= ' sc_body';
}

?>
<body <?php body_class($style_class); ?>>
<?php wp_body_open(); ?>

	<div class="plain_bg"></div>
	<div class="header">
		<div class="scrollin scrollinbottom">
			<?php 
				if(pll_current_language() == 'tc') {
					$cu_link = 'https://www.cuhk.edu.hk/chinese/';
				}else if(pll_current_language() == 'sc') {
					$cu_link = 'https://translate.itsc.cuhk.edu.hk/uniTS/www.cuhk.edu.hk/chinese/';
				}else{
					$cu_link = 'https://www.cuhk.edu.hk/english/';
				}
			?>
			<a href="<?php echo $cu_link; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/cuhk_logo.svg" class="cuhk_logo "></a>
			<a href="<?php echo esc_url( pll_home_url() ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/schoolart_logo.svg" class="school_logo "></a>
		</div>

		<ul class="header_menu scrollin scrollinbottom">
			<li class="hidden_lang_wrapper">
				<a href="#" class="menu_lang"></a>
				<div class="hidden_lang">
					<ul>
						<?php $translations = pll_the_languages(['raw' => 1]); ?>
						<?php foreach ($translations as $translation): ?>
						<li <?php echo $translation['current_lang']
							? 'class="current-lang"'
							: ''; ?>>
							<a href="<?php echo $translation['url']; ?>"><?php echo $translation['name']; ?></a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</li>
			<li><a href="#" class="menu_search"></a></li>
			<li><a href="#" class="menu_dropdown"><div class="g g1"></div><div class="g g2"></div><div class="g g3"></div></a></li>
		</ul>
	</div>
	<div class="dropdown">
		<div class="dropdown_col_wrapper text6">
			<?php
			if( have_rows('column_1_menu', 'option') ):
				?>
				<div class="dropdown_col">
				<?php
				while( have_rows('column_1_menu', 'option') ) : the_row();
					$group_name = get_sub_field('group_name');
					if( have_rows('menu') ):
						?>

						<div class="dropdown_menu_list">
							<div class="t1 text5"><span><?php echo $group_name;?></span></div>
							<ul>
								<?php 
								while (have_rows('menu')) : the_row();
									$title_only = get_sub_field('title_only');
									$text       = get_sub_field('text');
									$url        = get_sub_field('url');
									$page       = get_sub_field('page');

									// If all fields are empty, show spacer
									if (empty($title_only) && empty($text) && empty($url) && empty($page)) {
										echo '<li class="t_spacer"></li>';
										continue;
									}

									if ($title_only) :
									?>
									<li class="t2"><?php echo esc_html($text); ?></li>
									<?php 
									else:
										// Default title and link fallback
										$link_title = '';
										$link_href  = '';

										if ($page) {
											$link_title = get_the_title($page);
											$link_href  = get_permalink($page);
										}

										// Override title if text is given
										if ($text) {
											$link_title = $text;
										}

										// Override URL if given
										if ($url) {
											$link_href = $url;
										}

										// Only show if we have a title and a link
										if ($link_title && $link_href) :
									?>
										<li><a href="<?php echo esc_url($link_href); ?>"><?php echo esc_html($link_title); ?></a></li>
										<?php 
										endif;
									endif;
								endwhile; 
								?>
							</ul>
						</div>

						<?php
					endif;
				endwhile;
				?>
				</div>
				<?php
			endif;
			?>
			<?php
			if( have_rows('column_2_menu', 'option') ):
				?>
				<div class="dropdown_col">
				<?php
				while( have_rows('column_2_menu', 'option') ) : the_row();
					$group_name = get_sub_field('group_name');
					if( have_rows('menu') ):
						?>

						<div class="dropdown_menu_list">
							<div class="t1 text5"><span><?php echo $group_name;?></span></div>
							<ul>
								<?php 
								while (have_rows('menu')) : the_row();
									$title_only = get_sub_field('title_only');
									$text       = get_sub_field('text');
									$url        = get_sub_field('url');
									$page       = get_sub_field('page');

									// If all fields are empty, show spacer
									if (empty($title_only) && empty($text) && empty($url) && empty($page)) {
										echo '<li class="t_spacer"></li>';
										continue;
									}

									if ($title_only) :
									?>
									<li class="t2"><?php echo esc_html($text); ?></li>
									<?php 
									else:
										// Default title and link fallback
										$link_title = '';
										$link_href  = '';

										if ($page) {
											$link_title = get_the_title($page);
											$link_href  = get_permalink($page);
										}

										// Override title if text is given
										if ($text) {
											$link_title = $text;
										}

										// Override URL if given
										if ($url) {
											$link_href = $url;
										}

										// Only show if we have a title and a link
										if ($link_title && $link_href) :
									?>
										<li><a href="<?php echo esc_url($link_href); ?>"><?php echo esc_html($link_title); ?></a></li>
										<?php 
										endif;
									endif;
								endwhile; 
								?>
							</ul>
						</div>

						<?php
					endif;
				endwhile;
				?>
				</div>
				<?php
			endif;
			?>
			<?php
			if( have_rows('column_3_menu', 'option') ):
				?>
				<div class="dropdown_col">
				<?php
				while( have_rows('column_3_menu', 'option') ) : the_row();
					$group_name = get_sub_field('group_name');
					if( have_rows('menu') ):
						?>

						<div class="dropdown_menu_list">
							<div class="t1 text5"><span><?php echo $group_name;?></span></div>
							<ul>
								<?php 
								while (have_rows('menu')) : the_row();
									$title_only = get_sub_field('title_only');
									$text       = get_sub_field('text');
									$url        = get_sub_field('url');
									$page       = get_sub_field('page');

									// If all fields are empty, show spacer
									if (empty($title_only) && empty($text) && empty($url) && empty($page)) {
										echo '<li class="t_spacer"></li>';
										continue;
									}

									if ($title_only) :
									?>
									<li class="t2"><?php echo esc_html($text); ?></li>
									<?php 
									else:
										// Default title and link fallback
										$link_title = '';
										$link_href  = '';

										if ($page) {
											$link_title = get_the_title($page);
											$link_href  = get_permalink($page);
										}

										// Override title if text is given
										if ($text) {
											$link_title = $text;
										}

										// Override URL if given
										if ($url) {
											$link_href = $url;
										}

										// Only show if we have a title and a link
										if ($link_title && $link_href) :
									?>
										<li><a href="<?php echo esc_url($link_href); ?>"><?php echo esc_html($link_title); ?></a></li>
										<?php 
										endif;
									endif;
								endwhile; 
								?>
							</ul>
						</div>

						<?php
					endif;
				endwhile;
				?>
				</div>
				<?php
			endif;
			?>
			<div class="dropdown_col">
				<div class="dropdown_department">
					<div class="dropdown_department_top">
						<img src="<?php bloginfo('template_directory'); ?>/images/ccc_color.png" class="dropdown_department_logo">
						<div class="text text7">
							<div>香港中文大學中國語言及文學系</div>
							<div>Department of Chinese Language & Literature, CUHK</div>
						</div>
					</div>
					<div class="dropdown_department_bottom">
						<!-- <div class="footer_sns_title text7"><?php echo cuhk_multilang_text("追蹤中國語言及文學系","","Follow Department of Chinese Language & Literature"); ?></div> -->
						<div class="footer_sns_wrapper">
							<ul>
								<?php if(get_field("fb_url","option")){?>
									<li><a href="<?php the_field("fb_url","option"); ?>" class="sns_icon_fb" target="_blank"></a></li>
								<?php }; ?>
								<?php if(get_field("ig_url","option")){?>
									<li><a href="<?php the_field("ig_url","option"); ?>" class="sns_icon_ig" target="_blank"></a></li>
								<?php }; ?>
								<?php if(get_field("youtube_url","option")){?>
									<li><a href="<?php the_field("youtube_url","option"); ?>" class="sns_icon_yt" target="_blank"></a></li>
								<?php }; ?>
								<?php if(get_field("linkedin_url","option")){?>
									<li><a href="<?php the_field("linkedin_url","option"); ?>" class="sns_icon_in" target="_blank"></a></li>
								<?php }; ?>
								<?php if(get_field("weibo_url","option")){?>
									<li><a href="<?php the_field("weibo_url","option"); ?>" class="sns_icon_weibo" target="_blank"></a></li>
								<?php }; ?>
								<?php if(get_field("xiaohongshu_url","option")){?>
									<li><a href="<?php the_field("xiaohongshu_url","option"); ?>" class="sns_icon_xiaohongshu" target="_blank"></a></li>
								<?php }; ?>
								<?php if(get_field("wechat_qr_code","option")){?>
									<li><a href="<?php echo(get_field("wechat_qr_code","option"))["url"]; ?>" data-fancybox class="sns_icon_wechat"></a></li>
								<?php }; ?>
							</ul>
						</div>
						
						<div class="text text7 footer_info">
							<?php if(get_field('footer_info', 'option')){
								?>
								<?php
								the_field('footer_info', 'option');
							}; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<a href="#" class="menu_dropdown"><div class="g g1"></div><div class="g g2"></div><div class="g g3"></div></a>
	</div>

	<div class="header_bg"></div>
