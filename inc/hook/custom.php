<?php

if ( ! function_exists( 'magzimum_custom_body_class' ) ) :
  /**
   * Custom body class
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_custom_body_class( $input ) {

    // Site layout
    $site_layout = magzimum_get_option( 'site_layout' );
    $input[] = 'site-layout-' . esc_attr( $site_layout );

    // Global layout
    global $post;
    $global_layout = magzimum_get_option( 'global_layout' );
    // Check if single
    if ( $post  && is_singular() ) {
      $post_options = get_post_meta( $post->ID, 'theme_settings', true );
      if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
        $global_layout = $post_options['post_layout'];
      }
    }

    $input[] = 'global-layout-' . esc_attr( $global_layout );

    return $input;
  }
endif;
add_filter( 'body_class', 'magzimum_custom_body_class' );


if ( ! function_exists( 'magzimum_custom_content_class' ) ) :

  /**
   * Custom Primary class
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_custom_content_class( $input ) {

    global $post;
    $global_layout = magzimum_get_option( 'global_layout' );
    // Check if single
    if ( $post  && is_singular() ) {
      $post_options = get_post_meta( $post->ID, 'theme_settings', true );
      if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
        $global_layout = $post_options['post_layout'];
      }
    }

    $new_class = '';

    switch ( $global_layout ) {
      case 'three-columns':
        $new_class = 'col-sm-6';
        break;

      case 'no-sidebar':
        $new_class = 'col-sm-12';
        break;

      case 'left-sidebar':
      case 'right-sidebar':
        $new_class = 'col-sm-8';
        break;

      default:
        break;
    }
    if ( ! empty( $new_class ) ) {
      $input[] = $new_class;
    }

    return $input;
  }
endif;
add_filter( 'magzimum_filter_content_class', 'magzimum_custom_content_class' );


if ( ! function_exists( 'magzimum_custom_sidebar_primary_class' ) ) :
  /**
   * Custom Sidebar Primary class
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_custom_sidebar_primary_class( $input ) {


    global $post;
    $global_layout = magzimum_get_option( 'global_layout' );
    // Check if single
    if ( $post && is_singular() ) {
      $post_options = get_post_meta( $post->ID, 'theme_settings', true );
      if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
        $global_layout = $post_options['post_layout'];
      }
    }

    $new_class = '';

    switch ( $global_layout ) {
      case 'three-columns':
        $new_class = 'col-sm-3';
        break;

      case 'left-sidebar':
      case 'right-sidebar':
        $new_class = 'col-sm-4';
        break;

      default:
        break;
    }
    if ( ! empty( $new_class ) ) {
      $input[] = $new_class;
    }

    return $input;
  }
endif;
add_filter( 'magzimum_filter_sidebar_primary_class', 'magzimum_custom_sidebar_primary_class' );


if ( ! function_exists( 'magzimum_custom_sidebar_secondary_class' ) ) :

  /**
   * Custom Sidebar Secondary class
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_custom_sidebar_secondary_class( $input ) {

    global $post;
    $global_layout = magzimum_get_option( 'global_layout' );
    // Check if single
    if ( $post  && is_singular() ) {
      $post_options = get_post_meta( $post->ID, 'theme_settings', true );
      if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
        $global_layout = $post_options['post_layout'];
      }
    }

    $new_class = '';

    switch ( $global_layout ) {
      case 'three-columns':
        $new_class = 'col-sm-3';
        break;

      default:
        break;
    }
    if ( ! empty( $new_class ) ) {
      $input[] = $new_class;
    }

    return $input;
  }
endif;

add_filter( 'magzimum_filter_sidebar_secondary_class', 'magzimum_custom_sidebar_secondary_class' );



if ( ! function_exists( 'magzimum_custom_content_width' ) ) :

  /**
   * Custom Content Width
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_custom_content_width( $input ) {

    global $post, $wp_query, $content_width;

    $global_layout = magzimum_get_option( 'global_layout' );

    // Check if single
    if ( $post  && is_singular() ) {
      $post_options = get_post_meta( $post->ID, 'theme_settings', true );
      if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
        $global_layout = $post_options['post_layout'];
      }
    }
    switch ( $global_layout ) {

      case 'no-sidebar':
        $content_width = 1140;
        break;

      case 'three-columns':
        $content_width = 555;
        break;

      case 'left-sidebar':
      case 'right-sidebar':
        $content_width = 750;
        break;

      default:
        break;
    }

  }
endif;

add_filter( 'template_redirect', 'magzimum_custom_content_width' );


if ( ! function_exists( 'magzimum_implement_front_page_widget_area' ) ) :

  /**
   * Implement front page widget area
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_implement_front_page_widget_area(){

    if ( is_active_sidebar( 'sidebar-front-page-widget-area' ) ) {
      // Sidebar active
      echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
        dynamic_sidebar( 'sidebar-front-page-widget-area' );
      echo '</div><!-- #sidebar-front-page-widget-area -->';
    }

  }

endif;

add_action( 'magzimum_action_front_page', 'magzimum_implement_front_page_widget_area' );



if ( ! function_exists( 'magzimum_add_author_bio_in_single' ) ) :

  /**
   * Display Author bio
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_add_author_bio_in_single() {

    $author_bio_in_single = magzimum_get_option( 'author_bio_in_single' );
    if ( 1 != $author_bio_in_single ) {
      return;
    }
    get_template_part( 'template-parts/single-author', 'bio' );

  }
endif;

add_action( 'magzimum_author_bio', 'magzimum_add_author_bio_in_single' );


if ( ! function_exists( 'magzimum_add_ie_fix_scripts' ) ) :

  /**
   * Add IE hack scripts.
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_add_ie_fix_scripts(){

    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?php echo get_template_directory_uri();?>/assets/js/html5shiv.js"></script>
      <script src="<?php echo get_template_directory_uri();?>/assets/js/respond.js"></script>
    <![endif]-->
    <?php

  }
endif;
add_action( 'wp_head', 'magzimum_add_ie_fix_scripts' );



if ( ! function_exists( 'magzimum_featured_image_instruction' ) ) :

  /**
   * Message to show in the Featured Image Meta box.
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_featured_image_instruction( $content, $post_id ) {

    if ( 'post' == get_post_type( $post_id ) ) {
      $content .= '<strong>' . __( 'Recommended Image Sizes', 'magzimum' ) . ':</strong><br/>';
      $content .= __( 'Slider Image', 'magzimum' ).' : 1600px X 440px';
    }

    return $content;

  }

endif;
add_filter( 'admin_post_thumbnail_html', 'magzimum_featured_image_instruction', 10, 2 );
