<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cuhk_chi
 */

?>

    <div class="footer">
        <div class="section_center_content">
            <div class="footer_row_wrapper footer1">
                <div class="footer_row">
                    <div class="footer_menu_list_wrapper">
                        <div class="footer_menu_list footer_department_logo_wrapper">
                            <img src="<?php bloginfo('template_directory'); ?>/images/ccc.png" class="footer_department_logo">
                            <div class="t1">Address:</div>
                            <div class="t2 text7">
                                Room 131, 1/F, Fung King Hey Building,<br/>
                                The Chinese University of Hong Kong, <br/>
                                Shatin, New Territories, Hong Kong.
                            </div>
                        </div>
                        <div class="footer_menu_list">
                            <div class="t1 text6"><a href="#">About Us</a></div>
                            <ul>
                                <li><a href="#">About the Department</a></li>
                                <li><a href="#">Message From Chairman</a></li>
                                <li><a href="#">CUHK Historians</a></li>
                            </ul>
                        </div>
                        <div class="footer_menu_list">
                            <div class="t1 text6"><a href="#">People</a></div>
                            <ul>
                                <li><a href="#">Teaching Staff</a></li>
                                <li><a href="#">Administrative Staff</a></li>
                                <li><a href="#">Research Staff</a></li>
                                <li><a href="#">Research Students</a></li>
                                <li><a href="#">Student Association</a></li>
                                <li><a href="#">Alumni</a></li>
                            </ul>
                        </div>
                        <div class="footer_menu_list">
                            <div class="t1 text6"><a href="#">Programmes</a></div>
                            <ul>
                                <li><a href="#">B.A. Programme</a></li>
                                <li><a href="#">Summer Internship</a></li>
                                <li><a href="#">M.A. Programme</a></li>
                                <li><a href="#">M.Phil. Programme</a></li>
                                <li><a href="#">Ph.D. Programme</a></li>
                            </ul>
                        </div>
                        <div class="footer_menu_list">
                            <div class="t1 text6"><a href="#">Research</a></div>
                        </div>
                        <div class="footer_menu_list">
                            <div class="t1 text6"><a href="#">News</a></div>
                            <ul>
                                <li><a href="#">Announcements</a></li>
                                <li><a href="#">Events</a></li>
                                <li><a href="#">Newsletter</a></li>
                                <li><a href="#">Photo / Video</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_row_wrapper footer2">
                <div class="footer_row">
                    <div class="footer2_t_wrapper">
                        <div class="footer2_t footer2_t1 text8">
                            <div class="footer_bottom_nav">        
                                <ul>
                                    <li><a href="#" >Accessibility</a></li>
                                    <li><a href="#" >Privacy Policy</a></li>
                                    <li><a href="#" >Disclaimer</a></li>
                                </ul>
                            </div>
                            <div class="copyright">
                                © Copyright 2025<span class="copyright_line">|</span>The Chinese University of Hong Kong Department of Chinese Language & Literature
                            </div>
                        </div>
                        <div class="footer2_t footer2_t2">
                            <div class="footer_sns_title text8">Follow Department of Chinese Language & Literature</div>
                            <div class="footer_sns_wrapper">
                                <ul>
                                    <li><a href="#" class="sns_icon_fb"></a></li>
                                    <li><a href="#" class="sns_icon_ig"></a></li>
                                    <li><a href="#" class="sns_icon_yt"></a></li>
                                    <li><a href="#" class="sns_icon_in"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ink_bg ink_bg1"><img src="<?php bloginfo('template_directory'); ?>/images/ink_bg1.jpg"></div>
    </div>

    <div class="mobile_hide"></div>
    <div class="mobile_show"></div>
    <div class="loading"><img src="<?php bloginfo('template_directory'); ?>/images/oval.svg"></div>

<?php wp_footer(); ?>

</body>
</html>
