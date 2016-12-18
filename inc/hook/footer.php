<?php

if( ! function_exists( 'magzimum_footer_navigation' ) ) :

  /**
   * Footer navigation
   *
   * @since  Magzimum 1.0
   */
  function magzimum_footer_navigation(){

    $footer_menu_content = wp_nav_menu( array(
      'theme_location' => 'footer' ,
      'container'      => 'div' ,
      'container_id'   => 'footer-navigation' ,
      'depth'          => 1 ,
      'fallback_cb'    => false ,
      'echo'           => false ,
    ) );
    if ( empty( $footer_menu_content ) ) {
      return;
    }
    echo $footer_menu_content;
    return;

  }

endif;

add_action( 'magzimum_action_footer', 'magzimum_footer_navigation', 5 );

if( ! function_exists( 'magzimum_footer_copyright' ) ) :

  /**
   * Footer copyright
   *
   * @since  Magzimum 1.0
   */
  function magzimum_footer_copyright(){

    $copyright_text = magzimum_get_option( 'copyright_text' );
    $copyright_text = apply_filters( 'magzimum_filter_copyright_text', $copyright_text );
    if ( empty( $copyright_text ) ) {
      return;
    }
    ?>
    <div class="copyright">
      <?php echo esc_html( $copyright_text ); ?>
    </div><!-- .copyright -->
    <?php

  }

endif;

add_action( 'magzimum_action_footer', 'magzimum_footer_copyright', 10 );


if( ! function_exists( 'magzimum_site_info' ) ) :

  /**
   * Site info
   *
   * @since  Magzimum 1.0
   */
  function magzimum_site_info(){

    ?>
    <div class="site-info">
      <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'magzimum' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'magzimum' ), 'WordPress' ); ?></a>
      <span class="sep"> | </span>
      <?php printf( __( 'Theme: %1$s by %2$s.', 'magzimum' ), 'Magzimum', '<a href="' . esc_url( "http://themepalace.com/" ) . '" rel="designer">Theme Palace</a>' ); ?>
    </div><!-- .site-info -->
    <?php

  }

endif;

add_action( 'magzimum_action_footer', 'magzimum_site_info', 20 );


if( ! function_exists( 'magzimum_footer_goto_top' ) ) :

  /**
   * Go to top
   *
   * @since  Magzimum 1.0
   */
  function magzimum_footer_goto_top(){

    $go_to_top = magzimum_get_option( 'go_to_top' );
    if ( 1 != $go_to_top ) {
      return;
    }
    echo '<a href="#" class="scrollup" id="btn-scrollup"><i class="fa fa-chevron-circle-up"></i></a>';

  }

endif;

add_action( 'magzimum_action_after', 'magzimum_footer_goto_top', 20 );

