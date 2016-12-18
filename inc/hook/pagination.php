<?php

if ( ! function_exists( 'magzimum_custom_posts_navigation' ) ) :

  /**
   * Posts navigation
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_custom_posts_navigation() {

    $pagination_type = magzimum_get_option( 'pagination_type' );

    switch ( $pagination_type ) {

      case 'default':
        the_posts_navigation();
        break;

      case 'numeric':
        if ( function_exists( 'wp_pagenavi' ) ){
          wp_pagenavi();
        }
        else{
          the_posts_navigation();
        }
        break;

      default:
        break;
    }

  }
endif;
add_action( 'magzimum_action_posts_navigation', 'magzimum_custom_posts_navigation' );

