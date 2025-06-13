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
			<img src="<?php bloginfo('template_directory'); ?>/images/cuhk_logo.svg" class="cuhk_logo ">
			<img src="<?php bloginfo('template_directory'); ?>/images/schoolart_logo.svg" class="school_logo ">
		</div>

		<ul class="header_menu scrollin scrollinbottom">
			<li><a href="#" class="menu_lang"></a></li>
			<li><a href="#" class="menu_search"></a></li>
			<li><a href="#" class="menu_dropdown"><div class="g g1"></div><div class="g g2"></div><div class="g g3"></div></a></li>
		</ul>
	</div>
	<div class="dropdown">
		<div class="dropdown_col_wrapper text7">
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
							<div class="t1 text5"><a><?php echo $group_name;?></a></div>
							<ul>
								<?php
								while( have_rows('menu') ) : the_row();
									$text = get_sub_field('text');
									$url = get_sub_field('url');
									?>
									<li><a href="<?php echo $url;?>"><?php echo $text;?></a></li>
									<?php
								endwhile;
								?>
							</ul>
							</div>
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
							<div class="t1 text5"><a><?php echo $group_name;?></a></div>
							<ul>
								<?php
								while( have_rows('menu') ) : the_row();
									$text = get_sub_field('text');
									$url = get_sub_field('url');
									?>
									<li><a href="<?php echo $url;?>"><?php echo $text;?></a></li>
									<?php
								endwhile;
								?>
							</ul>
							</div>
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
							<div class="t1 text5"><a><?php echo $group_name;?></a></div>
							<ul>
								<?php
								while( have_rows('menu') ) : the_row();
									$text = get_sub_field('text');
									$url = get_sub_field('url');
									?>
									<li><a href="<?php echo $url;?>"><?php echo $text;?></a></li>
									<?php
								endwhile;
								?>
							</ul>
							</div>
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
						<img src="<?php bloginfo('template_directory'); ?>/images/ccc.png" class="dropdown_department_logo">
						<div class="text text8">
							<div>香港中文大學中國語言及文學系</div>
							<div>The Chinese Universityof Hong Kong Department of Chinese Language & Literature</div>
						</div>
					</div>
					<div class="dropdown_department_bottom">
						
						<div class="dropdown_department_sns_wrapper">
							<ul>
								<li><a href="#" class="sns_icon_fb"></a></li>
								<li><a href="#" class="sns_icon_ig"></a></li>
								<li><a href="#" class="sns_icon_yt"></a></li>
							</ul>
						</div>
						<div class="text text8">
							<strong>Address:</strong><br>
							Rm 523, Fung King Hey Building
							The Chinese University of Hong Kong
						</div>
					</div>
				</div>
			</div>
		</div>
		<a href="#" class="menu_dropdown"><div class="g g1"></div><div class="g g2"></div><div class="g g3"></div></a>
	</div>

	<div class="header_bg"></div>
