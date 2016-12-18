<?php

// Check slider status
add_filter( 'magzimum_filter_featured_content_status', 'magzimum_check_featured_content_status' );

// Featured content details
add_filter( 'magzimum_filter_featured_content_details', 'magzimum_get_featured_content_details' );


add_action( 'magzimum_action_before_content', 'magzimum_add_featured_content', 6 );


if ( ! function_exists( 'magzimum_add_featured_content' ) ) :
  /**
   * Add featured content
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_add_featured_content() {

    $flag_apply_featured_content = apply_filters( 'magzimum_filter_featured_content_status', true );
    if ( true != $flag_apply_featured_content ) {
      return false;
    }

    $featured_content_details = array();
    $featured_content_details = apply_filters( 'magzimum_filter_featured_content_details', $featured_content_details );

    if ( empty( $featured_content_details ) ) {
      return;
    }

    // Render featured content now
    magzimum_render_featured_content( $featured_content_details );

  }
endif;


/**
 * Return featured_content details.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_get_featured_content_details' ) ):

  function magzimum_get_featured_content_details( $input ){

    $featured_content_type = magzimum_get_option( 'featured_content_type' );

    switch ( $featured_content_type ) {

      case 'featured-category':

        $featured_content_number   = magzimum_get_option( 'featured_content_number' );
        $featured_content_category = magzimum_get_option( 'featured_content_category' );
        $qargs = array(
          'posts_per_page' => esc_attr( $featured_content_number ),
          'no_found_rows'  => true,
          );

        if ( absint( $featured_content_category ) > 0  ) {
          $qargs['category'] = esc_attr( $featured_content_category );
        }

        // Fetch posts
        $all_posts = get_posts( $qargs );

        $contents = array();

        if ( ! empty( $all_posts ) ){

          $cnt = 0;
          foreach ( $all_posts as $key => $post ){

            if ( has_post_thumbnail( $post->ID ) ) {
              $image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
              if ( ! empty( $image_array ) ) {
                $contents[$cnt]['images'] = $image_array;
              }
            } //end if
            $contents[$cnt]['title']      = esc_html( $post->post_title );
            $contents[$cnt]['url']        = esc_url( get_permalink( $post->ID ) );
            $contents[$cnt]['date']       = get_the_time( get_option( 'date_format' ), $post->ID );
            $contents[$cnt]['categories'] = magzimum_get_the_category_uno( $post->ID );

            $cnt++;

          }

        }
        if ( ! empty( $contents ) ) {
          $input = $contents;
        }
        break;

      default:
        break;
    }
    return $input;

  }

endif;


/**
 * Render featured content.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_render_featured_content' ) ):

  function magzimum_render_featured_content( $content_details = array() ){

    if ( empty( $content_details ) ) {
      return;
    }

    $featured_content_show_arrow     = esc_attr( magzimum_get_option( 'featured_content_show_arrow' ) );
    $featured_content_show_thumbnail = esc_attr( magzimum_get_option( 'featured_content_show_thumbnail' ) );
    $featured_content_show_date      = esc_attr( magzimum_get_option( 'featured_content_show_date' ) );
    $featured_content_show_category  = esc_attr( magzimum_get_option( 'featured_content_show_category' ) );
    $featured_content_enable_autoplay  = esc_attr( magzimum_get_option( 'featured_content_enable_autoplay' ) );
    $featured_content_transition_delay  = absint( magzimum_get_option( 'featured_content_transition_delay' ) );

    ?>
    <div id="featured-content">
      <div class="container">

        <?php
          $data_text = '';
          if ( 1 == $featured_content_show_arrow ) {
            $data_text .= ' data-show_arrow="1" ';
          }
          if ( 1 == $featured_content_enable_autoplay ) {
            $data_text .= ' data-enable_autoplay="1" ';
          }
          if ( absint( $featured_content_transition_delay ) > 0 ) {
            $data_text .= ' data-transition_delay="' . $featured_content_transition_delay * 1000 . '" ';
          }
         ?>

        <div id="main-featured-content" class="owl-carousel" <?php echo $data_text; ?>>

            <?php foreach ( $content_details as $key => $content ): ?>

              <div class="item">
              <?php if ( 1 == $featured_content_show_thumbnail && isset( $content['images'] ) ): ?>
                  <img src="<?php echo esc_url( $content['images'][0] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>" class="alignleft" />
              <?php endif ?>
              <?php if ( 1 == $featured_content_show_category && ! empty( $content['categories'] )  ): ?>
                <span class="cat-links"><?php echo $content['categories']; ?></span>
              <?php endif ?>
                <h3><a href="<?php echo esc_url( $content['url']); ?>"><?php echo esc_html( $content['title']); ?></a></h3>
                <?php if ( 1 == $featured_content_show_date ): ?>
                  <span class="date"><?php echo esc_html( $content['date']); ?></span>
                <?php endif ?>
              </div>

            <?php endforeach ?>

        </div> <!-- #main-featured-content -->

      </div><!-- .container -->
    </div><!-- #featured-content -->

    <?php
  }

endif;


/**
 * Check status of featured content.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_check_featured_content_status' ) ):

  function magzimum_check_featured_content_status( $input ){

    // Featured status
    $featured_content_status = magzimum_get_option( 'featured_content_status' );

    // Initial
    $status = false;

    switch ( $featured_content_status ) {

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
