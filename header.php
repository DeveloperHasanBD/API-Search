<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Safety
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<?php get_template_part('header', 'assets'); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page">
		<div class="search-box">
			<div class="container"> 
				<?php //echo do_shortcode('[fibosearch]'); ?>
				
				 <div class="sp_api_search_form search-box">
				    <div class="api_search_box">
                    <div class="api_search_top">
                        <form action="<?php echo site_url()?>/results/" method="GET">
                            <div class="input-group">
                                <input name="title" type="text" class="form-control api_search_info">
                                <span class="input-group-text">
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                            <g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path d="M225.474,0C101.151,0,0,101.151,0,225.474c0,124.33,101.151,225.474,225.474,225.474    c124.33,0,225.474-101.144,225.474-225.474C450.948,101.151,349.804,0,225.474,0z M225.474,409.323    c-101.373,0-183.848-82.475-183.848-183.848S124.101,41.626,225.474,41.626s183.848,82.475,183.848,183.848    S326.847,409.323,225.474,409.323z" fill="#cb0021" data-original="#cb0021"></path>
                                                    </g>
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path d="M505.902,476.472L386.574,357.144c-8.131-8.131-21.299-8.131-29.43,0c-8.131,8.124-8.131,21.306,0,29.43l119.328,119.328    c4.065,4.065,9.387,6.098,14.715,6.098c5.321,0,10.649-2.033,14.715-6.098C514.033,497.778,514.033,484.596,505.902,476.472z" fill="#cb0021" data-original="#cb0021"></path>
                                                    </g>
                                                </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                                <g xmlns="http://www.w3.org/2000/svg"> </g>
                                            </g>
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="api_search_bottom">
                        <div class="spinner-position">
                            <div class="spinner-border" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
			    </div>
			</div>
		</div>
		<header id="header-main" class="header-main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="brand"> <a href="<?php echo get_home_url(); ?>"> <img class="logo-default" src="<?php echo  wp_get_attachment_url(get_theme_mod('custom_logo')); ?>" alt="Logo" /> </a> </div>
						<nav class="main-menu navbar-expand-lg" aria-label="Main navigation">

							<?php
							wp_nav_menu(array(
								'theme_location' => 'primary-menu',
								'container_class' => 'desktop-navigation'
							));
							?>

							<div class="search">
								<div class="search-open">
									<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
										<g>
											<g xmlns="http://www.w3.org/2000/svg">
												<g>
													<path d="M225.474,0C101.151,0,0,101.151,0,225.474c0,124.33,101.151,225.474,225.474,225.474    c124.33,0,225.474-101.144,225.474-225.474C450.948,101.151,349.804,0,225.474,0z M225.474,409.323    c-101.373,0-183.848-82.475-183.848-183.848S124.101,41.626,225.474,41.626s183.848,82.475,183.848,183.848    S326.847,409.323,225.474,409.323z" fill="#cb0021" data-original="#cb0021"></path>
												</g>
											</g>
											<g xmlns="http://www.w3.org/2000/svg">
												<g>
													<path d="M505.902,476.472L386.574,357.144c-8.131-8.131-21.299-8.131-29.43,0c-8.131,8.124-8.131,21.306,0,29.43l119.328,119.328    c4.065,4.065,9.387,6.098,14.715,6.098c5.321,0,10.649-2.033,14.715-6.098C514.033,497.778,514.033,484.596,505.902,476.472z" fill="#cb0021" data-original="#cb0021"></path>
												</g>
											</g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
											<g xmlns="http://www.w3.org/2000/svg"> </g>
										</g>
									</svg>
								</div>
							</div>
							<div class="responsive-navigation">
								<button class="menu-icon navbar-toggler" type="button" id="navbarSideCollapse" aria-label="Toggle navigation" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
									<img src="<?php echo get_template_directory_uri() ?>/img/pppot.png" alt="">
								</button>
								<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasExampleLabel">
									<div class="offcanvas-header">
										<div class="brand"> <a href="<?php echo get_home_url(); ?>"> <img class="logo-default" src="<?php echo  wp_get_attachment_url(get_theme_mod('custom_logo')); ?>" alt="Logo" /> </a> </div>
										<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="288" height="288" viewBox="0 0 16 16">
												<path fill="#d33" d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z" class="color000 svgShape" />
											</svg></button>
									</div>
									<div class="offcanvas-body">
										<div class="mobile-navigation" role="navigation">
											<div class="nav-toggle"> <span class="nav-back"></span> <span class="nav-title">Menu</span> <span class="nav-close"></span> </div>
											<?php
											wp_nav_menu(array(
												'theme_location' => 'primary-menu'
											));
											?>
										</div>
									</div>
								</div>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</header>
		<!-- #masthead -->