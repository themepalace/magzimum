<?php
/**
 * Get default theme options
 *
 * @since  Magzimum 1.0
 */

if ( ! function_exists( 'magzimum_get_default_theme_options' ) ) :

  function magzimum_get_default_theme_options(){
    $defaults = array();
    $defaults = apply_filters( 'magzimum_filter_default_theme_options', $defaults );
    return $defaults;
  }

endif;

/**
 * Get theme option
 *
 * @since  Magzimum 1.0
 */
if ( ! function_exists( 'magzimum_get_option' ) ) :

  function magzimum_get_option( $key='' ){

    global $magzimum_default_theme_options;
    if ( empty( $key ) ) {
      return;
    }

    $default = ( isset( $magzimum_default_theme_options[ $key ] ) ) ? $magzimum_default_theme_options[ $key ] : '';
    $theme_options = get_theme_mod( 'theme_options', $magzimum_default_theme_options );
    $theme_options = array_merge( $magzimum_default_theme_options, $theme_options );
    $value = '';
    if ( isset( $theme_options[ $key ] ) ) {
      $value = $theme_options[ $key ];
    }
    return $value;

  }

endif; // magzimum_get_option


/**
 * Returns excerpt.
 *
 * @since Magzimum 1.0
 */
if ( ! function_exists( 'magzimum_get_the_excerpt' ) ) :

  function magzimum_get_the_excerpt( $length = 40, $post_obj = null ) {

    global $post;
    if ( is_null( $post_obj ) ) {
      $post_obj = $post;
    }
    $length = absint( $length );
    if ( $length < 1 ) {
      $length = 40;
    }
    $source_content = $post_obj->post_content;
    if ( ! empty( $post_obj->post_excerpt ) ) {
      $source_content = $post_obj->post_excerpt;
    }
    $source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
    $trimmed_content = wp_trim_words( $source_content, $length, '...' );
    return $trimmed_content;

  }

endif;


if ( ! function_exists( 'magzimum_content_class' ) ) :

  /**
   * Print content class.
   *
   * @since Magzimum 1.0
   */
  function magzimum_content_class( $class = '' ){

    $classes = array();
    if ( ! empty( $class ) ) {
      if ( !is_array( $class ) )
        $class = preg_split( '#\s+#', $class );
      $classes = array_merge( $classes, $class );
    } else {
      // Ensure that we always coerce class to being an array.
      $class = array();
    }

    $classes = array_map( 'esc_attr', $classes );
    $classes = apply_filters( 'magzimum_filter_content_class', $classes, $class );
    echo ' class="' . join( ' ', $classes ) . '" ';

  }

endif;

if ( ! function_exists( 'magzimum_sidebar_primary_class' ) ) :

  /**
   * Print sidebar primary class.
   *
   * @since Magzimum 1.0
   */
  function magzimum_sidebar_primary_class( $class = '' ){

    $classes = array();
    if ( ! empty( $class ) ) {
      if ( !is_array( $class ) )
        $class = preg_split( '#\s+#', $class );
      $classes = array_merge( $classes, $class );
    } else {
      // Ensure that we always coerce class to being an array.
      $class = array();
    }

    $classes = array_map( 'esc_attr', $classes );
    $classes = apply_filters( 'magzimum_filter_sidebar_primary_class', $classes, $class );
    echo ' class="' . join( ' ', $classes ) . '" ';

  }

endif;

if ( ! function_exists( 'magzimum_sidebar_secondary_class' ) ) :

  /**
   * Print sidebar secondary class.
   *
   * @since Magzimum 1.0
   */
  function magzimum_sidebar_secondary_class( $class = '' ){

    $classes = array();
    if ( ! empty( $class ) ) {
      if ( !is_array( $class ) )
        $class = preg_split( '#\s+#', $class );
      $classes = array_merge( $classes, $class );
    } else {
      // Ensure that we always coerce class to being an array.
      $class = array();
    }

    $classes = array_map( 'esc_attr', $classes );
    $classes = apply_filters( 'magzimum_filter_sidebar_secondary_class', $classes, $class );
    echo ' class="' . join( ' ', $classes ) . '" ';

  }

endif;
