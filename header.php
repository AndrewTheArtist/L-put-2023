<?php
/**
* The Header for our theme
**/
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
    <meta name="format-detection" content="telephone=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/theme/fonts/remixicon.woff2" as="font" type="font/woff2" crossorigin>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php $sitehome_url = apply_filters( 'wpml_home_url', get_option( 'home' ) ); ?>
<?php $acf_header_logo = get_field('acf_header_logo', 'option')?>
<?php $acf_header_transparent = get_field('acf_header_transparent', 'option')?>
<div id="wrapper">
<header id="header" class="fixed-top w-100">
    <div class="container">
        <div class="row row-main align-content-center justify-content-xl-between mobile-header_view__build">
            <div id="header-logo" class="col-auto col-xl col-nav d-flex flex-wrap justify-content-around mobile-nav_container">
            <div class="col-auto col-logo position-relative"><a href="<?php echo $sitehome_url; ?>">
            <?php
            if(is_front_page()){
                echo wp_get_attachment_image($acf_header_logo, 'full', '',  ['class' => 'regular-logo']);
                echo wp_get_attachment_image($acf_header_transparent, 'full', '',  ['class' => 'transparent-logo']);
            } else{
                echo wp_get_attachment_image($acf_header_logo, 'full');
            }
            ?>
            </a>
            </div>
                <?php 
                    if ( has_nav_menu( 'primary' ) ) :
                        echo '<div class="offcanvas-xl offcanvas-start" tabindex="-1" id="headerOffcanvas" aria-labelledby="headerOffcanvasLabel">';
                            echo '<div class="offcanvas-header"><p class="offcanvas-title" id="headerOffcanvasLabel">'. __('Menu', 'ama') .'</p><button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#headerOffcanvas" aria-label="Close"></button></div>';
                            echo '<div class="offcanvas-body">';
                                if(is_front_page()){
                                    wp_nav_menu( array(
                                        'theme_location'  => 'primary',
                                        'depth'           => 2,
                                        'container'       => 'nav',
                                        'container_class' => '',
                                        'container_id'    => 'primary-menu',
                                        'menu_class'      => 'ama-nav-menu',
                                        'walker'          => new AMA_Nav_Menu(),
                                    ));
                                } else{
                                    wp_nav_menu( array(
                                        'theme_location'  => 'primary',
                                        'depth'           => 2,
                                        'container'       => 'nav',
                                        'container_class' => '',
                                        'container_id'    => 'primary-menu-sub',
                                        'menu_class'      => 'ama-nav-menu-sub',
                                        'walker'          => new AMA_Nav_Menu(),
                                    ));
                                }
                            echo '</div>';
                        echo '</div>';
                    endif;
                ?>

            <div class="wp-block-button header-button"><a class="wp-block-button__link wp-element-button" href="https://test8.artmedia.ee/kiviluks/kontakt/"><?php echo __('Hinnapäring');?></a></div>
            <div class="col col-xl-auto col-actions d-flex flex-wrap align-items-center justify-content-end mobile_burger" style="padding-right:2rem;">
                <?php 
                    do_action('ama_theme_header');
                    if ( has_nav_menu( 'primary' ) ) :
                        echo '<button id="menu-toggle" class="d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#headerOffcanvas" aria-controls="headerOffcanvas"><span></span></button>';
                    endif;
                ?>
            </div>
            </div>
        </div>
    </div>
</header>
<main class="gutenberg-elements" role="main">