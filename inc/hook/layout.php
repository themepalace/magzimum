<?php

if( ! function_exists( 'magzimum_add_image_in_single_display' ) ) :

  /**
   * Add image in single post
   *
   * @since  Magzimum 1.0
   */
  function magzimum_add_image_in_single_display(){

    global $post;

    if ( has_post_thumbnail() ){

      $values = get_post_meta( $post->ID, 'theme_settings', true );
      $theme_settings_single_image = isset( $values['single_image'] ) ? esc_attr( $values['single_image'] ) : '';
      $theme_settings_single_image_alignment = 'center';

      if ( ! $theme_settings_single_image ) {
        $theme_settings_single_image = magzimum_get_option( 'single_image' );
      }

      if ( 'disable' != $theme_settings_single_image ) {
        $args = array(
          'class' => 'align' . $theme_settings_single_image_alignment,
        );
        the_post_thumbnail( $theme_settings_single_image, $args );
      }

    }

  }

endif;
add_action( 'magzimum_single_image', 'magzimum_add_image_in_single_display' );



