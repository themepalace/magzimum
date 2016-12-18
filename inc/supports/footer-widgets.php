<?php
$support = get_theme_support( 'footer-widgets' );
if ( empty( $support ) ){
  return;
}
// Number of footer widgets
$footer_widgets_number = absint( $support[0] );

if ( $footer_widgets_number < 1 || $footer_widgets_number > 4 ) {
  return;
}

// Hook footer widgets functions

// Init widgets
add_action( 'widgets_init', 'magzimum_footer_widgets_init' );
add_action( 'magzimum_action_before_footer', 'magzimum_add_footer_widgets', 5 );
add_filter( 'magzimum_filter_footer_widgets', 'magzimum_check_footer_widgets_status' );
add_filter( 'magzimum_filter_footer_widget_class', 'magzimum_custom_footer_widget_class', 10, 2 );



/**
 * Register footer widgets.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_footer_widgets_init' ) ):

  function magzimum_footer_widgets_init() {

    $support = get_theme_support( 'footer-widgets' );

    if ( empty( $support ) ){
      return;
    }
    // Number of footer widgets
    $footer_widgets_number = absint( $support[0] );

    if ( $footer_widgets_number < 1 ) {
      return;
    }

    for( $i = 1; $i <= $footer_widgets_number; $i++ ) {
      register_sidebar( array(
        'name'          => sprintf( __( 'Footer Widget %d', 'magzimum' ), $i ),
        'id'            => sprintf( 'footer-%d', $i ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
      ) );
    } //end for

  }

endif;

/**
 * Add footer widgets.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_add_footer_widgets' ) ):

  function magzimum_add_footer_widgets() {

    $flag_apply_footer_widgets_content = apply_filters( 'magzimum_filter_footer_widgets', false );

    if ( true != $flag_apply_footer_widgets_content ) {
      return false;
    }

    $support = get_theme_support( 'footer-widgets' );

    if ( empty( $support ) ){
      return;
    }
    // Number of footer widgets
    $footer_widgets_number = absint( $support[0] );

    if ( $footer_widgets_number < 1 ) {
      return;
    }

    $args = array(
      'container' => 'div',
      'before'    => '<div class="container"><div class="row">',
      'after'     => '</div><!-- .row --></div><!-- .container -->',
    );
    $footer_widgets_content = magzimum_get_footer_widgets_content( $footer_widgets_number, $args );
    echo $footer_widgets_content;
    return;

  }

endif;


/**
 * Render footer widgets content.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_get_footer_widgets_content' ) ):

  function magzimum_get_footer_widgets_content( $number, $args = array() ) {

    $number = absint( $number );
    if ( $number < 1 ) {
      return;
    }
    //Defaults
    $args = wp_parse_args( (array) $args, array(
      'container'       => 'div',
      'container_class' => '',
      'container_id'    => 'footer-widgets',
      'wrap_class'      => 'footer-widget-area',
      'before'          => '',
      'after'           => '',
      ) );
    $args = apply_filters( 'magzimum_filter_footer_widgets_args', $args );
    ob_start();
    ///////
    $container_open = '';
    $container_close = '';

    if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
      $container_open = sprintf(
        '<%s %s %s>',
        $args['container'],
        ( $args['container_class'] ) ? 'class="' . $args['container_class'] . '"':'',
        ( $args['container_id'] ) ? 'id="' . $args['container_id'] . '"':''
        );
    }
    if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
      $container_close = sprintf(
        '</%s>',
        $args['container']
        );
    }

    echo $container_open;

    echo $args['before'];

    for($i = 1; $i <= $number ;$i++){

      $sidebar_name = "footer-$i";
      if ( is_active_sidebar( $sidebar_name ) ) {
        $item_class = apply_filters( 'magzimum_filter_footer_widget_class', '', $i );
        $div_classes = implode(' ', array( $item_class, $args['wrap_class'] ) );

        echo '<div class="' . $div_classes .  '">';
        dynamic_sidebar( $sidebar_name );
        echo '</div><!-- .' . $args['wrap_class'] . ' -->';
      }

    } // end for loop

    echo $args['after'];

    echo $container_close;

    ///////
    $output = ob_get_contents();
    ob_end_clean();
    return $output;

  }

endif;



/**
 * Check status of footer widgets.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_check_footer_widgets_status' ) ):

  function magzimum_check_footer_widgets_status( $input ){

    $number_of_active_widgets = magzimum_get_number_of_active_widgets();

    if ( $number_of_active_widgets > 0 ) {
      $input = true;
    }

    return $input;

  }

endif;

/**
 * Custom footer widget class.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_custom_footer_widget_class' ) ):

  function magzimum_custom_footer_widget_class( $input, $col ){

    $number_of_active_widgets = magzimum_get_number_of_active_widgets();
    if ( $number_of_active_widgets < 1 ) {
      return $input;
    }

    switch ( $number_of_active_widgets ) {

      case 1:
        $input .= 'col-sm-12';
        break;

      case 2:
        $input .= 'col-sm-6';
        break;

      case 3:
        $input .= 'col-sm-4';
        break;

      case 4:
        switch ( $col ) {
          case 1:
          case 4:
            $input .= 'col-sm-4';
            break;
          case 2:
          case 3:
            $input .= 'col-sm-2';
            break;
          default:
            break;
        }
        break;

      default:
        break;
    }

    return $input;

  }

endif;

/**
 * Returns number of active widgets.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_get_number_of_active_widgets' ) ):

  function magzimum_get_number_of_active_widgets(){

    $count = 0;

    $support = get_theme_support( 'footer-widgets' );
    if ( ! empty( $support ) ){
      $footer_widgets_number = absint( $support[0] );
      if ( $footer_widgets_number > 0 ){

        for( $i = 1; $i <= $footer_widgets_number; $i++ ){

          if ( is_active_sidebar( 'footer-' . $i ) ) {
            $count++;
          }

        } // end for

      } // end if
    }

    return $count;

  }

endif;
