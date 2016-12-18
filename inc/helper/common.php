<?php

if( ! function_exists( 'magzimum_get_custom_background_options' ) ) :

  /**
   * Returns header image enable options.
   *
   * @since Magzimum 1.4
   */
  function magzimum_get_custom_background_options(){

    $choices = array(
      'entire-site'           => __( 'Entire Site', 'magzimum' ),
      'entire-site-page-post' => __( 'Entire Site, Page/Post Featured Image', 'magzimum' ),
      'disable'               => __( 'Disabled', 'magzimum' ),
    );
    $output = apply_filters( 'magzimum_get_custom_background_options', $choices );

    if ( ! empty( $output ) ) {
      ksort( $output );
    }
    return $output;
  }
endif;


if ( ! function_exists( 'magzimum_the_category_uno' ) ) :

  /**
   * Return one category link of a post.
   *
   * @since Magzimum 1.0
   */
  function magzimum_the_category_uno( $id = '' ){

    $output = magzimum_get_the_category_uno( $id );
    echo $output;

  }

endif;


if ( ! function_exists( 'magzimum_get_the_category_uno' ) ) :

  /**
   * Return one category link of a post.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_the_category_uno( $id = '' ){

    global $post;
    if ( empty( $id )) {
      if ( $post ) {
        $id = $post->ID;
      }
    }
    if ( empty( $id ) ) {
      return;
    }
    $categories = get_the_terms( $id, 'category' );
    if ( ! $categories || is_wp_error( $categories ) )
      $categories = array();

    $categories = array_values( $categories );
    $output = '';
    if ( ! empty( $categories ) && is_array( $categories ) ) {
      $cat = $categories[0];
      $output .= '<a href="' . esc_url( get_term_link( $cat ) ). '">' . esc_html( $cat->name ) . '</a>';
    }
    return $output;

  }

endif;


if( ! function_exists( 'magzimum_get_featured_slider_transition_effects' ) ) :

  /**
   * Returns the featured slider transition effects.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_featured_slider_transition_effects(){

    $choices = array(
      'fade'       => __( 'fade', 'magzimum' ),
      'fadeout'    => __( 'fadeout', 'magzimum' ),
      'none'       => __( 'none', 'magzimum' ),
      'scrollHorz' => __( 'scrollHorz', 'magzimum' ),
    );
    $output = apply_filters( 'magzimum_filter_featured_slider_transition_effects', $choices );
    if ( ! empty( $output ) ) {
      ksort( $output );
    }
    return $output;

  }

endif;


if( ! function_exists( 'magzimum_get_featured_slider_content_options' ) ) :

  /**
   * Returns the featured slider content options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_featured_slider_content_options(){

    $choices = array(
      'home-page'   => __( 'Home Page / Front Page', 'magzimum' ),
      'entire-site' => __( 'Entire Site', 'magzimum' ),
      'disabled'    => __( 'Disabled', 'magzimum' ),
    );
    $output = apply_filters( 'magzimum_filter_featured_slider_content_options', $choices );
    if ( ! empty( $output ) ) {
      ksort( $output );
    }
    return $output;


  }

endif;


if( ! function_exists( 'magzimum_get_featured_slider_type' ) ) :

  /**
   * Returns the featured slider type.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_featured_slider_type(){

    $choices = array(
      'featured-category' => __( 'Featured Category', 'magzimum' ),
    );
    $output = apply_filters( 'magzimum_filter_featured_slider_type', $choices );
    if ( ! empty( $output ) ) {
      ksort( $output );
    }
    return $output;


  }

endif;


if( ! function_exists( 'magzimum_get_global_layout_options' ) ) :

  /**
   * Returns global layout options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_global_layout_options(){

    $choices = array(
      'left-sidebar'  => __( 'Primary Sidebar - Content', 'magzimum' ),
      'right-sidebar' => __( 'Content - Primary Sidebar', 'magzimum' ),
      'three-columns' => __( 'Three Columns', 'magzimum' ),
      'no-sidebar'    => __( 'No Sidebar', 'magzimum' ),
    );
    $output = apply_filters( 'magzimum_filter_layout_options', $choices );
    return $output;

  }

endif;


if( ! function_exists( 'magzimum_get_site_layout_options' ) ) :

  /**
   * Returns site options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_site_layout_options(){

    $choices = array(
      'fluid' => __( 'Fluid', 'magzimum' ),
      'boxed' => __( 'Boxed', 'magzimum' ),
    );
    $output = apply_filters( 'magzimum_filter_site_layout_options', $choices );
    if ( ! empty( $output ) ) {
      ksort( $output );
    }
    return $output;

  }

endif;


if( ! function_exists( 'magzimum_get_archive_layout_options' ) ) :

  /**
   * Returns archive layout options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_archive_layout_options(){

    $choices = array(
      'full'          => __( 'Full Post', 'magzimum' ),
      'excerpt-thumb' => __( 'Excerpt and Thumbnail', 'magzimum' ),
    );
    $output = apply_filters( 'magzimum_filter_archive_layout_options', $choices );
    if ( ! empty( $output ) ) {
      ksort( $output );
    }
    return $output;


  }

endif;


if( ! function_exists( 'magzimum_get_image_sizes_options' ) ) :

  /**
   * Returns archive layout options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_image_sizes_options( $add_disable = true ){

    global $_wp_additional_image_sizes;
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
    $choices = array();
    if ( true == $add_disable ) {
      $choices['disable'] = __( 'No Image', 'magzimum' );
    }
    foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
      $choices[ $_size ] = $_size . ' ('. get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
    }
    $choices['full'] = __( 'full (original)', 'magzimum' );
    if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {

      foreach ($_wp_additional_image_sizes as $key => $size ) {
        $choices[ $key ] = $key . ' ('. $size['width'] . 'x' . $size['height'] . ')';
      }

    }
    return $choices;

  }

endif;



if( ! function_exists( 'magzimum_get_single_image_alignment_options' ) ) :

  /**
   * Returns single image options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_single_image_alignment_options(){

    $choices = array(
      'none'   => __( 'None', 'magzimum' ),
      'left'   => __( 'Left', 'magzimum' ),
      'center' => __( 'Center', 'magzimum' ),
      'right'  => __( 'Right', 'magzimum' ),
    );
    return $choices;

  }

endif;


if( ! function_exists( 'magzimum_get_pagination_type_options' ) ) :

  /**
   * Returns pagination type options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_pagination_type_options(){

    $choices = array(
      'default' => __( 'Default (Older Post / Newer Post)', 'magzimum' ),
      'numeric' => __( 'Numeric', 'magzimum' ),
    );
    return $choices;

  }

endif;


if( ! function_exists( 'magzimum_get_breadcrumb_type_options' ) ) :

  /**
   * Returns breadcrumb type options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_breadcrumb_type_options(){

    $choices = array(
      'disabled' => __( 'Disabled', 'magzimum' ),
      'simple'   => __( 'Simple', 'magzimum' ),
      'advanced' => __( 'Advanced', 'magzimum' ),
    );
    return $choices;

  }

endif;


if( ! function_exists( 'magzimum_get_featured_status_options' ) ) :

  /**
   * Returns featured status options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_featured_status_options(){

    $choices = array(
      'home-page-only' => __( 'Home Page Only', 'magzimum' ),
      'home-blog-page' => __( 'Home Page + Blog Page', 'magzimum' ),
      'entire-site'    => __( 'Entire Site', 'magzimum' ),
      'disabled'       => __( 'Disabled', 'magzimum' ),
    );
    $output = apply_filters( 'magzimum_filter_featured_status_options', $choices );
    if ( ! empty( $output ) ) {
      ksort( $output );
    }
    return $output;

  }

endif;


if( ! function_exists( 'magzimum_get_featured_content_type_options' ) ) :

  /**
   * Returns the featured content type options.
   *
   * @since Magzimum 1.0
   */
  function magzimum_get_featured_content_type_options(){

    $choices = array(
      'featured-category' => __( 'Featured Category', 'magzimum' ),
    );
    $output = apply_filters( 'magzimum_filter_featured_content_type', $choices );
    if ( ! empty( $output ) ) {
      ksort( $output );
    }
    return $output;


  }

endif;

if( ! function_exists( 'magzimum_is_social_menu_active' ) ) :

  /**
   * Check if social menu is active.
   *
   * @since magzimum 1.0.0
   * @return bool true/false
   */
  function magzimum_is_social_menu_active(){

    $is_menu_set = false;
    // Fetch nav
    $nav_menu_locations = get_nav_menu_locations();
    if ( isset( $nav_menu_locations['social'] ) && absint( $nav_menu_locations['social'] ) > 0 ) {
      $is_menu_set = true;
    }

    return $is_menu_set;

  }

endif;
