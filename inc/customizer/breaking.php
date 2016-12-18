<?php

add_filter( 'magzimum_filter_default_theme_options', 'magzimum_breaking_default_options' );

/**
 * Breaking defaults.
 *
 * @since  Magzimum 1.0
 */
if( ! function_exists( 'magzimum_breaking_default_options' ) ):

  function magzimum_breaking_default_options( $input ){

    $input['breaking_status']           = 'home-page-only';
    $input['breaking_title']            = __( 'Breaking News', 'magzimum' );
    $input['breaking_number']           = 5;
    $input['breaking_category']         = '';
    $input['breaking_show_date']        = true;
    $input['breaking_transition_delay'] = 3;

    return $input;
  }

endif;



add_filter( 'magzimum_theme_options_args', 'magzimum_breaking_theme_options_args' );


/**
 * Add breaking options.
 *
 * @since  Magzimum 1.0
 */

if( ! function_exists( 'magzimum_breaking_theme_options_args' ) ):

  function magzimum_breaking_theme_options_args( $args ){

    // Create breaking option panel
    $args['panels']['breaking_panel']['title'] = __( 'Breaking News', 'magzimum' );

    // Settings Section
    $args['panels']['breaking_panel']['sections']['section_breaking_settings'] = array(
      'title'    => __( 'Breaking News Settings', 'magzimum' ),
      'priority' => 70,
      'fields'   => array(

        'breaking_status' => array(
          'title'   => __( 'Enable for', 'magzimum' ),
          'type'    => 'select',
          'choices' => magzimum_get_featured_status_options(),
        ),
        'breaking_title' => array(
          'title' => __( 'Title', 'magzimum' ),
          'type'  => 'text',
        ),
        'breaking_category' => array(
          'title' => __( 'Category', 'magzimum' ),
          'type'  => 'dropdown-taxonomies',
        ),
        'breaking_show_date' => array(
          'title' => __( 'Show Date', 'magzimum' ),
          'type'  => 'checkbox',
        ),
        'breaking_number' => array(
          'title'             => __( 'Number of Posts', 'magzimum' ),
          'type'              => 'number',
          'sanitize_callback' => 'absint',
          'input_attrs'       => array(
                                'min'   => 1,
                                'max'   => 10,
                                'step'  => 1,
                                'style' => 'width: 50px;'
                                ),
        ),
        'breaking_transition_delay' => array(
          'title'             => __( 'Transition Delay', 'magzimum' ),
          'description'       => __( 'In second(s)', 'magzimum' ),
          'type'              => 'number',
          'sanitize_callback' => 'absint',
          'input_attrs'       => array(
                                'min'   => 1,
                                'max'   => 10,
                                'step'  => 1,
                                'style' => 'width: 50px;'
                                ),
        ),

      )
    );

    return $args;
  }

endif;
