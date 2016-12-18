<?php

/**
 * Add custom CSS
 *
 * @since  Magzimum 1.0
 */

if( ! function_exists( 'magzimum_add_custom_css' ) ) :

  function magzimum_add_custom_css(){

    $magzimum_custom_css = '';
    $magzimum_css = '';
    $css = '';

    // Check if the custom CSS feature of 4.7 exists
    if ( function_exists( 'wp_update_custom_css_post' ) ) {
        // Migrate any existing theme CSS to the core option added in WordPress 4.7.
        if( !empty( magzimum_get_option( 'custom_css' ) ) )
            $css = magzimum_get_option( 'custom_css' );
        
        if ( $css ) {
            $core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
            $return = wp_update_custom_css_post( $core_css . $css );
        
            if ( ! is_wp_error( $return ) ) {
                // Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
            $input['custom_css']         = '';
            set_theme_mod( 'theme_options', $input );
            }
        }
    } else {
        // Back-compat for WordPress < 4.7.
        $magzimum_css = magzimum_get_option( 'custom_css' );
        if ( isset( $magzimum_css ) ) {
            $magzimum_custom_css = magzimum_get_option( 'custom_css' );
        }
    }
    wp_add_inline_style( 'magzimum-style', $magzimum_custom_css );
  }

endif;
add_action( 'wp_enqueue_scripts', 'magzimum_add_custom_css', 10 );

