<?php

// Check slider status
add_filter( 'magzimum_filter_slider_status', 'magzimum_check_slider_status' );

// Slider details
add_filter( 'magzimum_filter_slider_details', 'magzimum_get_slider_details' );

if ( ! function_exists( 'magzimum_add_featured_slider' ) ) :
  /**
   * Add featured slider
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_add_featured_slider() {

    $flag_apply_slider = apply_filters( 'magzimum_filter_slider_status', true );
    if ( true != $flag_apply_slider ) {
      return false;
    }

    $slider_details = array();
    $slider_details = apply_filters( 'magzimum_filter_slider_details', $slider_details );

    if ( empty( $slider_details ) ) {
      return;
    }

    // Render slider now
    magzimum_render_featured_slider( $slider_details );

  }
endif;
add_action( 'magzimum_action_before_content', 'magzimum_add_featured_slider', 5 );


/**
 * Render featured slider.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_render_featured_slider' ) ):

  function magzimum_render_featured_slider( $slider_details = array() ){

    if ( empty( $slider_details ) ) {
      return;
    }

    $featured_slider_transition_effect      = magzimum_get_option( 'featured_slider_transition_effect' );
    $featured_slider_enable_caption         = magzimum_get_option( 'featured_slider_enable_caption' );
    $featured_slider_enable_arrow           = magzimum_get_option( 'featured_slider_enable_arrow' );
    $featured_slider_enable_pager           = magzimum_get_option( 'featured_slider_enable_pager' );
    $featured_slider_enable_autoplay        = magzimum_get_option( 'featured_slider_enable_autoplay' );
    $featured_slider_enable_clickable_image = magzimum_get_option( 'featured_slider_enable_clickable_image' );
    $featured_slider_transition_duration    = magzimum_get_option( 'featured_slider_transition_duration' );
    $featured_slider_transition_delay       = magzimum_get_option( 'featured_slider_transition_delay' );

    // Cycle data
    $slide_data = array(
      'fx'             => esc_attr( $featured_slider_transition_effect ),
      'speed'          => esc_attr( $featured_slider_transition_duration ) * 1000,
      'pause-on-hover' => 'true',
      'log'            => 'false',
      'swipe'          => 'true',
      'auto-height'    => 'container',
    );
    if ( $featured_slider_enable_caption ) {
      $slide_data['caption-template'] = '<h3><a href="{{url}}">{{title}}</a></h3><p>{{excerpt}}</p>';
    }

    if ( $featured_slider_enable_pager ) {
      $slide_data['pager-template'] = '<span class="pager-box"></span>';
    }
    if ( $featured_slider_enable_autoplay ) {
      $slide_data['timeout'] = esc_attr( $featured_slider_transition_delay ) * 1000;
    }
    else{
      $slide_data['timeout'] = 0;
    }

    $slide_data['slides'] = 'li';

    $slide_attributes_text = '';
    foreach ($slide_data as $key => $item) {

      $slide_attributes_text .= ' ';
      $slide_attributes_text .= ' data-cycle-'.esc_attr( $key );
      $slide_attributes_text .= '="'.esc_attr( $item ).'"';

    }

    ?>
    <div id="featured-slider-section">
      <div class="container">

        <div class="row">
          <div class="col-sm-8">
            <ul class="cycle-slideshow" id="main-slider" <?php echo $slide_attributes_text; ?>>

              <?php if ( $featured_slider_enable_arrow ): ?>
                <!-- prev/next links -->
                <div class="cycle-prev"></div>
                <div class="cycle-next"></div>
              <?php endif ?>

              <?php if ( $featured_slider_enable_caption ): ?>
                <!-- empty element for caption -->
                <div class="cycle-caption"></div>
              <?php endif ?>

                <?php $cnt = 1; ?>

                <?php foreach ($slider_details as $key => $slide): ?>

                  <?php $class_text = ( 1 == $cnt ) ? ' class="first" ' : ''; ?>

                  <li data-cycle-title="<?php echo esc_attr( $slide['title'] ); ?>"  data-cycle-url="<?php echo esc_url( $slide['url'] ); ?>"  data-cycle-excerpt="<?php echo esc_attr( $slide['excerpt'] ); ?>" <?php echo $class_text; ?> >
                    <?php if (true == $featured_slider_enable_clickable_image ): ?>
                      <a href="<?php echo esc_url( $slide['url'] ); ?>">
                    <?php endif ?>
                      <img src="<?php echo esc_url( $slide['images'][0] ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>"  />
                    <?php if (true == $featured_slider_enable_clickable_image ): ?>
                    </a>
                    <?php endif ?>
                  </li>

                  <?php $cnt++; ?>

                <?php endforeach ?>

                <?php if ( $featured_slider_enable_pager ): ?>
                  <!-- pager -->
                  <div class="cycle-pager"></div>
                <?php endif ?>

            </ul> <!-- #main-slider -->

          </div><!-- .col-sm-8 -->
          <div class="col-sm-4">
          <div class="sidebar-slider-right">
            <?php if ( is_active_sidebar( 'sidebar-slider-right-widget-area' ) ): ?>
              <?php dynamic_sidebar( 'sidebar-slider-right-widget-area' ); ?>
            <?php else: ?>
              <?php
                $widget = 'Magzimum_Special_Posts_Widget';
                $instance = array(
                  'show_category' => 1,
                );
                $args = array(
                  'before_title'  => '<h3 class="widget-title">',
                  'after_title'   => '</h3>',
                );
                the_widget( $widget, $instance, $args );
              ?>

            <?php endif ?>
          </div><!-- .sidebar-slider-right -->

          </div><!-- .col-sm-4 -->
        </div><!-- .row -->


      </div><!-- .container -->
    </div><!-- #featured-slider -->

    <?php


  }

endif;


/**
 * Check status of slider.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_check_slider_status' ) ):

  function magzimum_check_slider_status( $input ){

    // Slider status
    $featured_slider_status = magzimum_get_option( 'featured_slider_status' );

    // Initial
    $status = false;

    switch ( $featured_slider_status ) {

      case 'entire-site':
        $status = true;
        break;

      case 'home-page-only':
        if ( is_front_page() ) {
          $status = true;
        }
        break;

      case 'home-blog-page':
        if ( is_front_page() || is_home() ) {
          $status = true;
        }
        break;

      case 'disabled':
      default:
        $status = false;
        break;

    }

    return $status;

  }

endif;


/**
 * Return slider details.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_get_slider_details' ) ):

  function magzimum_get_slider_details( $input ){

    $featured_slider_type = magzimum_get_option( 'featured_slider_type' );

    switch ( $featured_slider_type ) {

      case 'featured-category':

        $featured_slider_number   = magzimum_get_option( 'featured_slider_number' );
        $featured_slider_category = magzimum_get_option( 'featured_slider_category' );
        $qargs = array(
          'posts_per_page' => esc_attr( $featured_slider_number ),
          'no_found_rows'  => true,
          'meta_query'     => array(
              array( 'key' => '_thumbnail_id' ), //Show only posts with featured images
            )
          );

        if ( absint( $featured_slider_category ) > 0  ) {
          $qargs['category'] = esc_attr( $featured_slider_category );
        }

        // Fetch posts
        $all_posts = get_posts( $qargs );

        $slides = array();

        if ( ! empty( $all_posts ) ){

          $cnt = 0;
          foreach ( $all_posts as $key => $post ){

            if ( has_post_thumbnail( $post->ID ) ) {
              $image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'magzimum-slider' );
              $slides[$cnt]['images']     = $image_array;
              $slides[$cnt]['title']       = esc_html( $post->post_title );
              $slides[$cnt]['url']         = esc_url( get_permalink( $post->ID ) );
              $slides[$cnt]['excerpt']     = magzimum_get_the_excerpt( 20, $post );

              $cnt++;
            }

          }

        }
        if ( ! empty( $slides ) ) {
          $input = $slides;
        }
        break;

      default:
        break;
    }
    return $input;

  }

endif;



/**
 * Load slider scripts.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_featured_slider_scripts' ) ):

  function magzimum_featured_slider_scripts(){

    global $post, $wp_query;

    // Slider status
    $featured_slider_status = magzimum_get_option( 'featured_slider_status' );

    // Get Page ID outside Loop
    $page_id = $wp_query->get_queried_object_id();

    // Front page displays in Reading Settings
    $page_on_front  = get_option( 'page_on_front' ) ;
    $page_for_posts = get_option( 'page_for_posts' );

    if ( $featured_slider_status == 'entire-site' || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $featured_slider_status == 'home-page' ) ){

      wp_enqueue_script( 'magzimum-cycle2-script', get_template_directory_uri() . '/third-party/cycle2/js/jquery.cycle2.min.js', array( 'jquery' ), '2.1.6', true );
    }

  }

endif;
