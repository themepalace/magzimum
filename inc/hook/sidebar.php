<?php

  /**
   * Add sidebar
   *
   * @since  Magzimum 1.0
   */
if( ! function_exists( 'magzimum_add_sidebar' ) ) :
  function magzimum_add_sidebar(){

    global $post;

    $global_layout       = magzimum_get_option( 'global_layout' );

    // Check if single
    if ( $post && is_singular() ) {
      $post_options = get_post_meta( $post->ID, 'theme_settings', true );
      if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
        $global_layout = $post_options['post_layout'];
      }
    }

    // Include sidebar
    if ( 'no-sidebar' != $global_layout ) {
      get_sidebar();
    }
    if ( 'three-columns' == $global_layout ) {
      get_sidebar( 'secondary' );
    }

  }

endif;
add_action( 'magzimum_action_sidebar', 'magzimum_add_sidebar' );



