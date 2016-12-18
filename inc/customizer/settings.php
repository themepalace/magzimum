<?php
add_filter( 'magzimum_filter_default_theme_options', 'magzimum_theme_settings_default_options' );
/**
 * Theme Settings defaults.
 *
 * @since  Magzimum 1.0
 */
if( ! function_exists( 'magzimum_theme_settings_default_options' ) ):

  function magzimum_theme_settings_default_options( $input ){

    // Header
    $input['site_logo']        = '';
    $input['show_tagline']     = true;
    $input['social_in_header'] = false;

    // Footer
    $input['copyright_text']  = __( 'Copyright. All rights reserved.', 'magzimum' );

    //Scroll Up
    $input['go_to_top']       = true;

    // Home Page
    $input['show_blog_listing_in_front'] = true;

    // Blog
    $input['excerpt_length']       = 40;
    $input['read_more_text']       = __( 'Read More ...', 'magzimum' );
    $input['exclude_categories']   = '';
    $input['author_bio_in_single'] = false;
    $input['post_meta_on_blog'] = true; 
    $input['image_on_blog'] = true;

    // Breadcrumb
    $input['breadcrumb_type']      = 'disabled';
    $input['breadcrumb_separator'] = '&gt;';

    // Pagination
    $input['pagination_type']       = 'default';

    // Layout
    $input['site_layout']            = 'fluid';
    $input['global_layout']          = 'right-sidebar';
    $input['archive_layout']         = 'excerpt-thumb';
    $input['single_image']           = 'large';

    return $input;
  }

endif;

add_filter( 'magzimum_theme_options_args', 'magzimum_settings_theme_options_args' );
/**
 * Theme settings.
 *
 * @since  Magzimum 1.0
 */
if( ! function_exists( 'magzimum_settings_theme_options_args' ) ):

  function magzimum_settings_theme_options_args( $args ){
    if ( function_exists( 'has_custom_logo' ) ) {
    $args['panels']['theme_option_panel']['sections']['section_header'] = array(
      'title'    => __( 'Header', 'magzimum' ),
      'priority' => 40,
      'fields'   => array(
        'site_logo' => array(
          'title'             => __( 'Logo', 'magzimum' ),
          'type'              => 'image',
          'sanitize_callback' => 'esc_url_raw',
        )
        )
        );
      }
    // Header Section
    $args['panels']['theme_option_panel']['sections']['section_header'] = array(
      'title'    => __( 'Header', 'magzimum' ),
      'priority' => 40,
      'fields'   => array(
        'show_tagline' => array(
          'title'   => __( 'Show Tagline', 'magzimum' ),
          'type'    => 'checkbox',
        ),
        'social_in_header' => array(
          'title'   => __( 'Show Social Icons', 'magzimum' ),
          'type'    => 'checkbox',
        ),
      )
    );

    // Footer Section
    $args['panels']['theme_option_panel']['sections']['section_footer'] = array(
      'title'    => __( 'Footer', 'magzimum' ),
      'priority' => 80,
      'fields'   => array(
        'copyright_text' => array(
          'title' => __( 'Copyright Text', 'magzimum' ),
          'type'  => 'text',
        ),
      )
    );

    //Scroll Up Section
    $args['panels']['theme_option_panel']['sections']['scroll_up'] = array(
      'title'    => __( 'Scroll Up', 'magzimum' ),
      'priority' => 80,
      'fields'   => array(
        'go_to_top' => array(
          'title' => __( 'Check to Show Go To Top', 'magzimum' ),
          'type'  => 'checkbox',
        ),
      )
    );

    // Blog Section
    $args['panels']['theme_option_panel']['sections']['section_blog'] = array(
      'title'    => __( 'Blog', 'magzimum' ),
      'priority' => 80,
      'fields'   => array(
        'excerpt_length' => array(
          'title'             => __( 'Excerpt Length (words)', 'magzimum' ),
          'description'       => __( 'Default is 40 words', 'magzimum' ),
          'type'              => 'number',
          'sanitize_callback' => 'magzimum_sanitize_excerpt_length',
          'input_attrs'       => array(
                                  'min'   => 1,
                                  'max'   => 200,
                                  'style' => 'width: 55px;'
                                ),
        ),
        'read_more_text' => array(
          'title'             => __( 'Read More Text', 'magzimum' ),
          'type'              => 'text',
          'sanitize_callback' => 'sanitize_text_field',
        ),
        'exclude_categories' => array(
          'title'             => __( 'Exclude Categories in Blog', 'magzimum' ),
          'description'       => __( 'Enter category ID to exclude in Blog Page. Separate with comma if more than one', 'magzimum' ),
          'type'              => 'text',
          'sanitize_callback' => 'sanitize_text_field',
        ),
        'author_bio_in_single' => array(
          'title'             => __( 'Show Author Bio', 'magzimum' ),
          'type'              => 'checkbox',
        ),
         'post_meta_on_blog' => array(
          'title'             => __( 'Show Post Meta', 'magzimum' ),
          'description'       => __('This will remove the post meta on post listings ', 'magzimum'),
          'type'              => 'checkbox',
        ),
           'image_on_blog' => array(
          'title'             => __( 'Show Post Images', 'magzimum' ),
          'description'       => __('This will remove the post featured image on post listings ', 'magzimum'),
          'type'              => 'checkbox',
        ),
      )
    );

    // Homepage Section
    $args['panels']['theme_option_panel']['sections']['section_home_page'] = array(
      'title'    => __( 'Home Page', 'magzimum' ),
      'priority' => 65,
      'fields'   => array(
        'show_blog_listing_in_front' => array(
          'title'             => __( 'Show Blog Listing', 'magzimum' ),
          'description'       => __( 'Check to show blog listing in home page.', 'magzimum' ),
          'type'              => 'checkbox',
          'sanitize_callback' => 'esc_attr',
        ),
      )
    );

    // Breadcrumb Section
    $args['panels']['theme_option_panel']['sections']['section_breadcrumb'] = array(
      'title'    => __( 'Breadcrumb', 'magzimum' ),
      'priority' => 80,
      'fields'   => array(
        'breadcrumb_type' => array(
          'title'             => __( 'Breadcrumb Type', 'magzimum' ),
          'description'       => sprintf( __( 'Advanced: Requires %sBreadcrumb NavXT%s plugin', 'magzimum' ), '<a href="https://wordpress.org/plugins/breadcrumb-navxt/" target="_blank">','</a>' ),
          'type'              => 'select',
          'choices'           => magzimum_get_breadcrumb_type_options(),
          'sanitize_callback' => 'sanitize_key',
        ),
        'breadcrumb_separator' => array(
          'title'       => __( 'Separator', 'magzimum' ),
          'type'        => 'text',
          'input_attrs' => array('style' => 'width: 55px;'),
        ),
      )
    );

    // Pagination Section
    $args['panels']['theme_option_panel']['sections']['section_pagination'] = array(
      'title'    => __( 'Pagination', 'magzimum' ),
      'priority' => 70,
      'fields'   => array(
        'pagination_type' => array(
          'title'             => __( 'Pagination Type', 'magzimum' ),
          'description'       => sprintf( __( 'Numeric: Requires %sWP-PageNavi%s plugin', 'magzimum' ), '<a href="https://wordpress.org/plugins/wp-pagenavi/" target="_blank">','</a>' ),
          'type'              => 'select',
          'sanitize_callback' => 'sanitize_key',
          'choices'           => magzimum_get_pagination_type_options(),
        ),
      )
    );

    // Layout Section
    $args['panels']['theme_option_panel']['sections']['section_layout'] = array(
      'title'    => __( 'Layout', 'magzimum' ),
      'priority' => 70,
      'fields'   => array(
        'site_layout' => array(
          'title'             => __( 'Site Layout', 'magzimum' ),
          'type'              => 'select',
          'choices'           => magzimum_get_site_layout_options(),
          'sanitize_callback' => 'sanitize_key',
        ),
        'global_layout' => array(
          'title'             => __( 'Global Layout', 'magzimum' ),
          'type'              => 'select',
          'choices'           => magzimum_get_global_layout_options(),
          'sanitize_callback' => 'sanitize_key',
        ),
        'archive_layout' => array(
          'title'             => __( 'Archive Layout', 'magzimum' ),
          'type'              => 'select',
          'choices'           => magzimum_get_archive_layout_options(),
          'sanitize_callback' => 'sanitize_key',
        ),
        'single_image' => array(
          'title'             => __( 'Image in Single Post/Page', 'magzimum' ),
          'type'              => 'select',
          'choices'           => magzimum_get_image_sizes_options(),
          'sanitize_callback' => 'sanitize_key',
        ),
      )
    );





    return $args;
  }

endif;


/**
 * Sanitize excerpt length
 *
 * @since  Magzimum 1.0
 */
if( ! function_exists( 'magzimum_sanitize_excerpt_length' ) ) :

  function magzimum_sanitize_excerpt_length( $input ) {

    $input = absint( $input );

    if ( $input < 1 ) {
      $input = 40;
    }
    return $input;

  }

endif;
