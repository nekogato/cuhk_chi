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

<body <?php body_class(); ?>>
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
			<div class="dropdown_col">
				<div class="dropdown_menu_list">
					<div class="t1 text5"><a href="#">Research & Publications</a></div>
					<ul>
						<li><a href="#">Research Strengths</a></li>
						<li><a href="#">Research Projects</a></li>
						<li><a href="#">MPhil / PhD Research</a></li>
						<li><a href="#">Publications</a></li>
						<li><a href="#">Research Centres & Units</a></li>
					</ul>
				</div>
				<div class="dropdown_menu_list">
					<div class="t1 text5"><a href="#">News</a></div>
					<ul>
						<li><a href="#">Announcements</a></li>
						<li><a href="#">Events</a></li>
						<li><a href="#">News</a></li>
						<li><a href="#">Newsletter</a></li>
						<li><a href="#">Media Gallery</a></li>
					</ul>
				</div>
			</div>
			<div class="dropdown_col">
				<div class="dropdown_menu_list">
					<div class="t1 text5"><a href="#">Study</a></div>
					<ul>
						<li><a href="#">Undergraduate</a></li>
						<li><a href="#">BA in XXX</a></li>
						<li><a href="#">Double Degree Programme</a></li>
						<li><a href="#">Minor Programme</a></li>
						<li><a href="#">Taught Postgraduate</a></li>
						<li><a href="#">Research Postgraduate</a></li>
						<li><a href="#">Courses Offerings</a></li>
						<li><a href="#">Support and Opportunities</a></li>
						<li><a href="#">Resources</a></li>
						<li><a href="#">Academic Calendar</a></li>
					</ul>
				</div>
			</div>
			<div class="dropdown_col">
				<div class="dropdown_menu_list">
					<div class="t1 text5"><a href="#">About Us</a></div>
					<ul>
						<li><a href="#">About the Department</a></li>
						<li><a href="#">Message From Chairman</a></li>
						<li><a href="#">CUHK Historians</a></li>
						<li><a href="#">Contact Us</a></li>
					</ul>
				</div>
				<div class="dropdown_menu_list">
					<div class="t1 text5"><a href="#">People</a></div>
					<ul>
						<li><a href="#">Academic Staff
						</a></li>
						<li><a href="#">Research Staff</a></li>
						<li><a href="#">Department Office / Admin Staff</a></li>
						<li><a href="#">Teaching Assistants / Instructors</a></li>
						<li><a href="#">Graduate Students</a></li>
						<li><a href="#">Student Committee</a></li>
						<li><a href="#">Alumni</a></li>
					</ul>
				</div>
			</div>
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
