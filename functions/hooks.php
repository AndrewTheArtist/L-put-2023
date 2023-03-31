<?php
/* =============================================================================
   plugin check
   ========================================================================== */
function main_is_plugin_active( $plugin ) {
	$network_active = false;
	if ( is_multisite() ) {
		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( isset( $plugins[$plugin] ) ) {
			$network_active = true;
		}
	}
	return in_array( $plugin, get_option( 'active_plugins' ) ) || $network_active;
}

function run_activate_plugin( $plugin ) {
    $current = get_option( 'active_plugins' );
    $plugin = plugin_basename( trim( $plugin ) );
    if ( !in_array( $plugin, $current ) ) {
        $current[] = $plugin;
        sort( $current );
        do_action( 'activate_plugin', trim( $plugin ) );
        update_option( 'active_plugins', $current );
        do_action( 'activate_' . trim( $plugin ) );
        do_action( 'activated_plugin', trim( $plugin) );
    }
    return null;
}
run_activate_plugin( 'ari-fancy-lightbox/ari-fancy-lightbox.php' );
run_activate_plugin( 'advanced-custom-fields-pro/acf.php' );
run_activate_plugin( 'fly-dynamic-image-resizer/fly-dynamic-image-resizer.php' );
run_activate_plugin( 'svg-support/svg-support.php' );

add_filter( 'plugin_action_links', 'disable_plugin_deactivation', 10, 4 );
function disable_plugin_deactivation( $actions, $plugin_file, $plugin_data, $context ) {
    if ( array_key_exists( 'deactivate', $actions ) && in_array( $plugin_file, array(
        'ari-fancy-lightbox/ari-fancy-lightbox.php',
        'advanced-custom-fields-pro/acf.php',
        'fly-dynamic-image-resizer/fly-dynamic-image-resizer.php',
        'svg-support/svg-support.php',
    )))
    unset( $actions['deactivate'] );
    return $actions;
}

/* =============================================================================
   acf
   ========================================================================== */
/* icon (must be ID) */
function ama_get_icon($ama_icon){
    $attachment_type = get_post_mime_type($ama_icon);
	if( $attachment_type == 'image/svg+xml' ){
        $attachment_url = wp_get_attachment_url($ama_icon);
		$attachment_output = '<img src="'. $attachment_url .'" alt="" />';
	} else {
		$attachment_output = fly_get_attachment_image( $ama_icon, array(100, 100), false );
	}

	return $attachment_output;
}

/* button */
function ama_get_btn($ama_btn, $btn_class = 'wp-block-button'){
    $amaBtn = $ama_btn;
    echo '<div class="'. $btn_class .'"><a href="'. $amaBtn['url'] .'" class="wp-block-button__link" target="'. $amaBtn['target'] .'">';
        echo $amaBtn['title'] ? $amaBtn['title'] : _e('Read more', 'ama');
    echo '</a></div>';
}

/* contact form 7 */
function ama_get_form( $ama_form ){
    echo '<div class="wp-block-contact-form-7-contact-form-selector">'. do_shortcode('[contact-form-7 id="'. $ama_form->ID .'" title="'. $ama_form->post_title .'"]') .'</div>';
}

/* social media */
function ama_icons($icon){	
	$svgs = array(
		'icon_fb' => '<svg xmlns="http://www.w3.org/2000/svg" width="9" height="18" viewBox="0 0 9 18"><path d="M1250.25,2859H1248v3h2.25v9H1254v-9h2.731l.269-3h-3v-1.25c0-.717.144-1,.837-1H1257V2853h-2.856c-2.7,0-3.894,1.187-3.894,3.461Z" transform="translate(-1248 -2853)"/></svg>',

		'icon_ig' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M1320.3,2856.116a1.08,1.08,0,1,0,1.08,1.08A1.08,1.08,0,0,0,1320.3,2856.116Zm-4.8,8.884a3,3,0,1,1,3-3A3,3,0,0,1,1315.5,2865Zm0-7.622a4.622,4.622,0,1,0,4.621,4.621A4.621,4.621,0,0,0,1315.5,2857.378Zm0-4.379c-2.444,0-2.75.011-3.711.055-3.269.149-5.085,1.963-5.235,5.235-.044.959-.054,1.266-.054,3.71s.01,2.751.054,3.711c.15,3.269,1.964,5.085,5.235,5.235.96.044,1.266.054,3.711.054s2.751-.01,3.711-.054c3.265-.149,5.086-1.963,5.234-5.235.044-.96.054-1.267.054-3.711s-.01-2.75-.054-3.71c-.147-3.266-1.963-5.085-5.234-5.235C1318.251,2853.01,1317.944,2853,1315.5,2853Zm0,1.623c2.4,0,2.688.009,3.637.052,2.439.111,3.578,1.268,3.689,3.689.043.949.052,1.233.052,3.636s-.009,2.688-.052,3.637c-.111,2.418-1.248,3.578-3.689,3.689-.949.043-1.233.052-3.637.052s-2.688-.009-3.636-.052c-2.446-.111-3.579-1.274-3.689-3.689-.043-.949-.053-1.233-.053-3.637s.01-2.687.053-3.636c.112-2.42,1.248-3.578,3.689-3.689C1312.813,2854.631,1313.1,2854.622,1315.5,2854.622Z" transform="translate(-1306.5 -2853)"/></svg>',

		'icon_yt' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>',
	);

	return $svgs[$icon];
}

function ama_get_socialmedia( $ama_src, $methodClass = '', $labelShow = false, $rowStyle = 'acf_repeater' ){
    if( $ama_src ) {
        echo '<div class="d-flex flex-wrap d-flex-socialmedia'. $methodClass .'">';
            foreach( $ama_src as $repeater_row ) {
                $acf_repeater_icon = $repeater_row[$rowStyle.'_icon'];
                $acf_repeater_link = $repeater_row[$rowStyle.'_link'];
                $icon = ama_icons($acf_repeater_icon);
                if( $labelShow == true ){
                    $acf_repeater_label = '<span>'. $acf_repeater_link['title'] .'</span>';
                } else {
                    $acf_repeater_label = '';
                }
                echo '<a href="'. $acf_repeater_link['url'] .'" class="social-icon d-flex align-items-center" target="'. $acf_repeater_link['target'] .'">'. $icon . $acf_repeater_label .'</a>';
            }
        echo '</div>';
    }
}

/* contact methods */
function ama_get_contact_methods( $ama_contact_repeater, $methodClass = '', $methodLabels = false ){
    if( $ama_contact_repeater ) {
		$labels = array(
			'repeater_email' => __('E-mail', 'ama'),
			'repeater_phone' => __('Telefon', 'ama'),
			'repeater_homepage' => __('Homepage', 'ama'),
		);
        echo '<div class="contact-methods'. $methodClass .'">';
			$method_output = array();
            foreach( $ama_contact_repeater as $repeater_row ) {
                $acf_repeater_method = $repeater_row['acf_repeater_method'];
                $acf_repeater_value = $repeater_row['acf_'. $acf_repeater_method];

                if( $acf_repeater_method == 'repeater_email' ){					
					$value = '<a href="mailto:'. $acf_repeater_value .'" class="d-inline-flex flex-wrap align-items-center" id="secondary_link">'. $acf_repeater_value .'</a>';
					$method_output['repeater_email'][] = $value;
                } elseif( $acf_repeater_method == 'repeater_phone' ){					
                    $phonecode = $repeater_row['acf_repeater_code'];
                    $phonenumber = preg_replace('/\s+/', '', $acf_repeater_value);
					$value = '<a href="tel:'. $phonecode . $phonenumber .'" id="secondary_link" class="d-inline-flex flex-wrap align-items-center">'. $phonecode .' '. $acf_repeater_value .'</a>';
					$method_output['repeater_phone'][] = $value;
                } elseif( $acf_repeater_method == 'repeater_homepage' ){
					$method_output['repeater_homepage'][] = '<a href="'. $acf_repeater_value['url'] .'" target="'. $acf_repeater_value['target'] .'">'. $acf_repeater_value['title'] .'</a>';
                } elseif( $acf_repeater_method == 'repeater_link' ){
					$method_output['repeater_link'][] = '<a href="'. $acf_repeater_value['url'] .'" target="'. $acf_repeater_value['target'] .'">'. $acf_repeater_value['title'] .'</a>';                    
                } elseif( $acf_repeater_method == 'repeater_txt' ){
                    $method_output[][] = $acf_repeater_value;
                }
            }
			echo ama_display_contact_methods($method_output, $methodLabels ? $labels : array());
        echo '</div>';
    }
}

function ama_display_contact_methods($methods, $labels){
	$html = '';
	foreach ($methods as $key => $method_values){
		$html .= '<p>';
		if (!empty($labels[$key])) $html .= $labels[$key] . ': ';
		$html .= implode(', ', $method_values);
		$html .= '</p>';
	}
	return $html;
}

/* fallback */
function ama_get_fallback($ama_fallback, $fallback_size = 'thumbnail'){
    $fallback_img = wp_get_attachment_image( $ama_fallback, $fallback_size );
	return $fallback_img;
}

/* =============================================================================
   contact form 7
   ========================================================================== */
add_filter('wpcf7_autop_or_not', '__return_false');

/* =============================================================================
   swiper
   ========================================================================== */
function ama_splide_arrows( $arrows_class = '', $splide_prev = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16"><path d="M8269.068-578.337a1.118,1.118,0,0,0,0-1.614l-5.052-4.906h14.808A1.159,1.159,0,0,0,8280-586a1.161,1.161,0,0,0-1.176-1.142h-14.8l5.048-4.9a1.123,1.123,0,0,0,0-1.618,1.2,1.2,0,0,0-1.663,0l-7.061,6.859A1.122,1.122,0,0,0,8260-586a1.119,1.119,0,0,0,.345.807l7.061,6.856a1.185,1.185,0,0,0,.834.337A1.185,1.185,0,0,0,8269.068-578.337Z" transform="translate(-8260 594)" fill="currentColor"/></svg>', $splide_next = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16"><path d="M8270.932-578.337a1.118,1.118,0,0,1,0-1.614l5.052-4.906h-14.808A1.159,1.159,0,0,1,8260-586a1.161,1.161,0,0,1,1.176-1.142h14.8l-5.048-4.9a1.123,1.123,0,0,1,0-1.618,1.2,1.2,0,0,1,1.663,0l7.061,6.859A1.122,1.122,0,0,1,8280-586a1.119,1.119,0,0,1-.345.807l-7.061,6.856a1.185,1.185,0,0,1-.834.337A1.185,1.185,0,0,1,8270.932-578.337Z" transform="translate(-8260 594)" fill="currentColor"/></svg>' ){
    $splide_arrows = '<div class="splide__arrows'. $arrows_class .'"><button class="splide__arrow splide__arrow--prev">'. $splide_prev .'</button><button class="splide__arrow splide__arrow--next">'. $splide_next .'</button></div>';

    return $splide_arrows;
}

/* =============================================================================
   header
   ========================================================================== */

   


/* =============================================================================
   footer
   ========================================================================== */


function theme_footer_content() {
    // Meta Data
    $acf_footer_text = get_field('acf_footer_text', 'option');
    $acf_footer_address = get_field('acf_footer_address', 'option');
    $acf_footer_address_link = get_field('acf_footer_address_link', 'option');
    $acf_footer_metadata = get_field('acf_footer_metadata', 'option');
    $acf_footer_phone_number = get_field('acf_footer_phone_number', 'option');
    $acf_footer_contact_mail = get_field('acf_footer_contact_mail', 'option');
    $acf_footer_billing_mail = get_field('acf_footer_billing_mail', 'option');
    $acf_footer_link = get_field('acf_footer_link', 'option');
    // Meta pre-text
    $metadata_pretext = __('Kontor avatud');
    $phone_pretext = __('Telefon: ');
    $mail_pretext_billing = __('E-arved: ');
    $mail_pretext = __('E-post: ');
    // Logos
    $acf_footer_logo = get_field('acf_footer_logo', 'option');
    $acf_gallery_logos = get_field('acf_gallery_logos', 'option');
    $sliderAttr = ['type' => 'loop','perPage' => 4,'pagination' => false, 'arrows' => false,'autoplay' => true, 'breakpoints' => [1024 => ['perPage' => 3], 726 =>['perPage' => 2], 425 => ['perPage' => 1]]];
    echo '<footer id="footer">';

        echo '<section class="options-slider splide container" data-splide='.json_encode($sliderAttr).'>';
            echo '<div class="splide__track">';
                echo '<ul class="splide__list options-slider-builder footer-silde-ul">';
                    foreach ($acf_gallery_logos as $acf_gallery_logo) :
                        echo '<li class="splide__slide">'.wp_get_attachment_image($acf_gallery_logo, 'full').'</li>';
                    endforeach;
                echo '</ul>';
            echo '</div>';
        echo '</section>';


        // Meta Start
        echo '<section class="alignmax bg-light meta-columns">';
            echo '<div class="row justify-content-between">';
                echo '<div class="meta-data-box col-12 col-md-8">';
                    echo '<p class="fw-bold">'.$acf_footer_text.'</p>';
                    echo '<a href="'.$acf_footer_address_link.'" class=""><p>'.$acf_footer_address.'</p></a>';
                    if ($acf_footer_metadata){echo '<p>'.$metadata_pretext.' '.$acf_footer_metadata.'</p>';} 
                    if($acf_footer_phone_number){echo '<p>'.$phone_pretext.'<a href="tel:'.$acf_footer_phone_number.'">'.$acf_footer_phone_number.'</a></p>';}     
                    if($acf_footer_contact_mail){echo '<p>'.$mail_pretext.' <a href="mailto:'.$acf_footer_contact_mail.'">'.$acf_footer_contact_mail.'</a></p>';}  
                    if($acf_footer_billing_mail){echo '<p>'.$mail_pretext_billing.'<a href="mailto:'.$acf_footer_billing_mail.'">'.$acf_footer_billing_mail.'</a></p>';}
                echo '</div>';

            // Needs Extra Work 
                echo '<div class="wp-block-button is-style-third col-6 col-md-4 wp-button-border">';
                    echo '<a href="https://test8.artmedia.ee/kiviluks/?page_id=38" class="wp-block-button__link has-primary-background-color has-background wp-element-button footer-button">Esita hinnapäring</a>';
                echo '</div>';

            echo '</div>';
        echo '</section>';


        echo '<div class="container footer-nav">';;
            if($acf_footer_logo){
                $image = wp_get_attachment_image( $acf_footer_logo, 'medium');
                echo '<div class="footer-logo">'.$image.'</div>'; 
            }
        // Footer Menu Pull-In
        wp_nav_menu( array( 
            'theme_location' => 'secondary', 
            'container_class' => 'footer-menu-class container' 
        ) );

        echo '<div style="justify-self: right; align-self: center;"><a href="https://www.artmedia.ee/" target="_blank" style="color: #000; text-decoration:none;"><p>AMA</p></a></div>';

        echo '</div>'; 
        
    echo '</footer>';

echo '<div class="scroll-to-top" className="scroll-to-top"><i class="ri-font ri-arrow-up-s-line scroll-to-top__btn d-flex flex-wrap align-items-center justify-content-center"></i></div>';
}
add_action('ama_theme_footer', 'theme_footer_content');

/* =============================================================================
   general blocks
   ========================================================================== */
function ama_general_blocks( $ama_src ){
    if( $ama_src ){
        $args = array(
            'post_type'   => array('ama-blocks'),
            'post_status' => array('publish'),
            'post__in'    => $ama_src,
            'orderby'     => 'post__in',
        );
        $general_blocks_loop = new WP_Query( $args );
        if ( $general_blocks_loop->have_posts() ) {
            while ( $general_blocks_loop->have_posts() ) {
                $general_blocks_loop->the_post();
                the_content();
            }
        }
        wp_reset_postdata();
    }
}
