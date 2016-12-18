<?php

// Check breaking status
add_filter( 'magzimum_filter_breaking_status', 'magzimum_check_breaking_status' );

/**
 * Check status of breaking news.
 *
 * @since Magzimum 1.0
 *
 */
if( ! function_exists( 'magzimum_check_breaking_status' ) ):

  function magzimum_check_breaking_status( $input ){

    global $post, $wp_query;

    // Breaking status
    $breaking_status = magzimum_get_option( 'breaking_status' );

    // Initial
    $status = false;

    switch ( $breaking_status ) {

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

    $input = $status;

    return $input;

  }

endif;


add_action( 'magzimum_action_before_content', 'magzimum_add_breaking_news', 4 );


if ( ! function_exists( 'magzimum_add_breaking_news' ) ) :
  /**
   * Add breaking news
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_add_breaking_news() {

    $flag_apply_breaking = apply_filters( 'magzimum_filter_breaking_status', false );
    if ( true != $flag_apply_breaking ) {
      return false;
    }
    ?>
    <div id="breaking-news-wrap">
      <div class="container">
        <div class="breaking-news-inner">
          <?php magzimum_render_breaking_news(); ?>
        </div><!-- .breaking-news-inner -->
      </div><!-- .container -->
    </div><!-- #breaking-news-wrap -->
    <?php

  }

endif;

if ( ! function_exists( 'magzimum_render_breaking_news' ) ) :
  /**
   * Render breaking news
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_render_breaking_news() {


    $breaking_title    = magzimum_get_option( 'breaking_title' );
    $breaking_number   = magzimum_get_option( 'breaking_number' );
    $breaking_category = magzimum_get_option( 'breaking_category' );
    $breaking_show_date = magzimum_get_option( 'breaking_show_date' );
    $breaking_transition_delay = magzimum_get_option( 'breaking_transition_delay' );
    $breaking_delay = $breaking_transition_delay * 1000;

    $qargs = array(
      'posts_per_page' => esc_attr( $breaking_number ),
      'no_found_rows'  => true,
    );

    if ( absint( $breaking_category ) > 0  ) {
      $qargs['category'] = esc_attr( $breaking_category );
    }

    // Fetch posts
    $all_posts = get_posts( $qargs );

    ?>
    <div class="breaking-title"><?php echo esc_html( $breaking_title ); ?></div><!-- .breaking-title -->
    <div id="breaking-ticker" data-delay="<?php echo esc_attr( $breaking_delay ); ?>">
      <div class="innerWrap">
        <?php if ( ! empty( $all_posts ) ): ?>
          <?php foreach ( $all_posts as $key => $breaking ): ?>
            <div class="list">
              <a href="<?php echo esc_url(  get_permalink( $breaking->ID ) ); ?>">
                <?php echo esc_html( $breaking->post_title ); ?>
              </a>
              <?php if ( true == $breaking_show_date ): ?>
                <span class="date">(<?php echo date( get_option( 'date_format' ), strtotime( $breaking->post_date ) ); ?>)</span>
              <?php endif ?>
            </div>
          <?php endforeach ?>
        <?php endif ?>
      </div>
    </div>
    <?php

  }
endif;

