<?php

if( ! function_exists( 'magzimum_implement_excerpt_length' ) ) :

  /**
   * Implement excerpt length
   *
   * @since  Magzimum 1.0
   */
  function magzimum_implement_excerpt_length( $length ){

    $excerpt_length = magzimum_get_option( 'excerpt_length' );
    if ( empty( $excerpt_length) ) {
      $excerpt_length = $length;
    }
    return apply_filters( 'magzimum_filter_excerpt_length', esc_attr( $excerpt_length ) );

  }

endif;
add_filter( 'excerpt_length', 'magzimum_implement_excerpt_length', 999 );


if( ! function_exists( 'magzimum_implement_read_more' ) ) :

  /**
   * Implement read more in excerpt
   *
   * @since  Magzimum 1.0
   */
  function magzimum_implement_read_more( $more ){

    $flag_apply_excerpt_read_more = apply_filters( 'magzimum_filter_excerpt_read_more', true );
    if ( true != $flag_apply_excerpt_read_more ) {
      return $more;
    }

    $output = $more;
    $read_more_text = magzimum_get_option( 'read_more_text' );
    if ( ! empty( $read_more_text ) ) {
      $output = ' <a href="'. esc_url( get_permalink() ) . '" class="read-more">' . sprintf( __( '%s', 'magzimum' ) , esc_html( $read_more_text ) ) . '</a>';
      $output = apply_filters( 'magzimum_filter_read_more_link' , $output );
    }
    return $output;

  }

endif;
add_filter( 'excerpt_more', 'magzimum_implement_read_more' );


if( ! function_exists( 'magzimum_content_more_link' ) ) :

  /**
   * Implement read more in content
   *
   * @since  Magzimum 1.0
   */
  function magzimum_content_more_link( $more_link, $more_link_text ) {

    $flag_apply_excerpt_read_more = apply_filters( 'magzimum_filter_excerpt_read_more', true );
    if ( true != $flag_apply_excerpt_read_more ) {
      return $more_link;
    }

    $read_more_text = magzimum_get_option( 'read_more_text' );
    if ( ! empty( $read_more_text ) ) {
      $more_link =  str_replace( $more_link_text, $read_more_text, $more_link );
    }
    return $more_link;

  }

endif;

add_filter( 'the_content_more_link', 'magzimum_content_more_link', 10, 2 );


if( ! function_exists( 'magzimum_exclude_category_in_blog_page' ) ) :

  /**
   * Exclude category in blog page
   *
   * @since  Magzimum 1.0
   */
  function magzimum_exclude_category_in_blog_page( $query ) {

    if( $query->is_home && $query->is_main_query()   ) {
      $exclude_categories = magzimum_get_option( 'exclude_categories' );
      if ( ! empty( $exclude_categories ) ) {
        $cats = explode( ',', $exclude_categories );
        $cats = array_filter( $cats, 'is_numeric' );
        $string_exclude = '';
        if ( ! empty( $cats ) ) {
          $string_exclude = '-' . implode( ',-', $cats);
          $query->set( 'cat', $string_exclude );
        }
      }
    }
    return $query;

  }

endif;

add_filter( 'pre_get_posts', 'magzimum_exclude_category_in_blog_page' );
