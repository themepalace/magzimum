<?php

add_action( 'widgets_init', 'magzimum_load_widgets' );

if ( ! function_exists( 'magzimum_load_widgets' ) ) :

  /**
   * Load widgets
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_load_widgets()
  {

    // Social widget
    register_widget( 'Magzimum_Social_Widget' );

    // Ad widget
    register_widget( 'Magzimum_Ad_Widget' );

    // Tabbed widget
    register_widget( 'Magzimum_Tabbed_Widget' );

    // Latest News widget
    register_widget( 'Magzimum_Latest_News_Widget' );

    // Special Post widget
    register_widget( 'Magzimum_Special_Posts_Widget' );

    // Categorized News widget
    register_widget( 'Magzimum_Categorized_News_Widget' )
;
  }

endif;


if ( ! class_exists( 'Magzimum_Social_Widget' ) ) :

  /**
   * Social Widget Class
   *
   * @since Magzimum 1.0
   *
   */
  class Magzimum_Social_Widget extends WP_Widget {

    function __construct() {
      parent::__construct(
        'magzimum_widget_social', // Base ID
        'Magzimum Social', // Name
        array( 'description' => __( 'Social Icons Widget', 'magzimum' ) ) // Args
      );
    }

    function widget( $args, $instance ) {
        extract( $args );

        $title        = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $icon_size    = empty($instance['icon_size']) ? 'medium' : $instance['icon_size'];
        $custom_class = apply_filters( 'widget_custom_class', empty( $instance['custom_class'] ) ? '' : $instance['custom_class'], $instance, $this->id_base );


        if ( $custom_class ) {
          $before_widget = str_replace('class="', 'class="'. $custom_class . ' ', $before_widget);
        }

        echo $before_widget;

        // Title
        if ( $title ) echo $before_title . $title . $after_title;

        //
        $nav_menu_locations = get_nav_menu_locations();
        $menu_id = 0;
        if ( isset( $nav_menu_locations['social'] ) && absint( $nav_menu_locations['social'] ) > 0 ) {
          $menu_id = absint( $nav_menu_locations['social'] );
        }
        if ( $menu_id > 0) {

          $menu_items = wp_get_nav_menu_items( $menu_id );

          if ( ! empty( $menu_items ) ) {
            echo '<ul>';
            foreach ( $menu_items as $m_key => $m ) {
              echo '<li>';
              echo '<a href="' . esc_url( $m->url ) . '" target="_blank" title="' . esc_attr( $m->title ) . '" >';
              echo '<span class="title screen-reader-text">' . esc_attr( $m->title ) . '</span>';
              echo '</a>';
              echo '</li>';

            }
            echo '</ul>';
          }
        }
        //
        echo $after_widget;

    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']        =   esc_html( strip_tags($new_instance['title']) );
        $instance['custom_class'] =   esc_attr( $new_instance['custom_class'] );

        return $instance;
    }

      function form( $instance ) {

        //Defaults
        $instance = wp_parse_args( (array) $instance, array(
          'title'        => '',
          'custom_class' => '',
        ) );
        $title        = esc_attr( $instance['title'] );
        $custom_class = esc_attr( $instance['custom_class'] );

        // Fetch nav
        $nav_menu_locations = get_nav_menu_locations();
        $is_menu_set = false;
        if ( isset( $nav_menu_locations['social'] ) && absint( $nav_menu_locations['social'] ) > 0 ) {
          $is_menu_set = true;
        }
        ?>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e('Title:', 'magzimum'); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>"><?php _e( 'Custom Class:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'custom_class') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_class' ) ); ?>" type="text" value="<?php echo esc_attr( $custom_class ); ?>" />
        </p>

        <?php if ( $is_menu_set ): ?>
          <?php
              $menu_id = $nav_menu_locations['social'];
              $social_menu_object = get_term( $menu_id, 'nav_menu' );
              $args = array(
                  'action' => 'edit',
                  'menu'   => $menu_id,
                  );
              $menu_edit_url = add_query_arg( $args, admin_url( 'nav-menus.php' ) );
           ?>
            <p>
                <?php echo __( 'Social Menu is currently set to', 'magzimum' ) . ': '; ?>
                <strong><a href="<?php echo esc_url( $menu_edit_url );  ?>" ><?php echo esc_attr( $social_menu_object->name ); ?></a></strong>
            </p>

          <?php else: ?>
          <?php
              $args = array(
                  'action' => 'locations',
                  );
              $menu_manage_url = add_query_arg( $args, admin_url( 'nav-menus.php' ) );
              $args = array(
                  'action' => 'edit',
                  'menu'   => 0,
                  );
              $menu_create_url = add_query_arg( $args, admin_url( 'nav-menus.php' ) );
           ?>
            <p>
              <?php echo __( 'Social menu is not set.', 'magzimum' ) . ' '; ?><br />
              <strong><a href="<?php echo esc_url( $menu_manage_url );  ?>"><?php echo __( 'Click here to set menu', 'magzimum' ); ?></a></strong>
              <?php echo ' '._x( 'or', 'Social Widget', 'magzimum' ) . ' '; ?>
              <strong><a href="<?php echo esc_url( $menu_create_url );  ?>"><?php echo __( 'Create menu now', 'magzimum' ); ?></a></strong>
            </p>

          <?php endif ?>

        <?php
      }

  }

endif;

if ( ! class_exists( 'Magzimum_Latest_News_Widget' ) ) :

  /**
   * Latest News Widget Class
   *
   * @since Magzimum 1.0
   *
   */
  class Magzimum_Latest_News_Widget extends WP_Widget {

    function __construct() {
      parent::__construct(
        'magzimum_widget_latest_news', // Base ID
        'Magzimum Latest News', // Name
        array( 'description' => __( 'Latest News Widget', 'magzimum' ) ) // Args
      );
    }


    function widget( $args, $instance ) {
        extract( $args );

        $title          = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base );
        $post_category     = ! empty( $instance['post_category'] ) ? $instance['post_category'] : 0;
        $post_column       = ! empty( $instance['post_column'] ) ? $instance['post_column'] : 2;
        $featured_image    = ! empty( $instance['featured_image'] ) ? $instance['featured_image'] : 'magzimum-thumb';
        $post_number       = ! empty( $instance['post_number'] ) ? $instance['post_number'] : 4;
        $excerpt_length    = ! empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 20;
        $disable_date      = ! empty( $instance['disable_date'] ) ? $instance['disable_date'] : false ;
        $disable_comment   = ! empty( $instance['disable_comment'] ) ? $instance['disable_comment'] : false ;
        $disable_excerpt   = ! empty( $instance['disable_excerpt'] ) ? true : false ;
        $disable_category   = ! empty( $instance['disable_category'] ) ? true : false ;
        $custom_class   = apply_filters( 'widget_custom_class', empty( $instance['custom_class'] ) ? '' : $instance['custom_class'], $instance, $this->id_base );

        // Column class
        switch ( $post_column ) {
          case 1:
            $column_class = 'col-sm-12';
            break;
          case 2:
            $column_class = 'col-sm-6';
            break;
          default:
            $column_class = '';
            break;
        }


        // Add Custom class
        if ( $custom_class ) {
          $before_widget = str_replace( 'class="', 'class="'. $custom_class . ' ', $before_widget );
        }

        echo $before_widget;

        // Title
        if ( $title ) echo $before_title . $title . $after_title;

        //
        ?>
        <?php
          $qargs = array(
            'posts_per_page' => $post_number,
            'no_found_rows'  => true,
            );
          if ( absint( $post_category ) > 0  ) {
            $qargs['category'] = $post_category;
          }

          $all_posts = get_posts( $qargs );
        ?>
        <?php if ( ! empty( $all_posts ) ): ?>


          <?php global $post; ?>

          <div class="latest-news-widget">

            <div class="row">

              <?php foreach ( $all_posts as $key => $post ): ?>
                <?php setup_postdata( $post ); ?>

                <div class="latest-news-item <?php echo esc_attr( $column_class ); ?>">

                <?php if ( 'disable' != $featured_image && has_post_thumbnail() ): ?>
                  <div class="latest-news-thumb">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                      <?php
                        $img_attributes = array( 'class' => 'aligncenter' );
                        the_post_thumbnail( $featured_image, $img_attributes );
                      ?>
                    </a>
                  </div><!-- .latest-news-thumb -->
                <?php endif ?>
                <div class="latest-news-text-wrap">
                  <h3 class="latest-news-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                  </h3><!-- .latest-news-title -->

                  <?php if ( false == $disable_excerpt ): ?>
                    <div class="latest-news-summary">
                      <p><?php echo absint( magzimum_get_the_excerpt( $excerpt_length, $post ) ); ?></p>
                    </div><!-- .latest-news-summary -->
                  <?php endif ?>

                  <?php if ( false == $disable_date || false == $disable_category || ( false == $disable_comment ) ): ?>
                    <ul class="news-meta">

                      <?php if ( false == $disable_date ): ?>
                        <li class="date-meta"><?php the_time( get_option('date_format') ); ?></li><!-- .latest-news-date -->
                      <?php endif ?>

                      <?php if ( false == $disable_comment ): ?>
                        <?php
                          echo '<li class="comment-meta">';
                          comments_popup_link( '<span class="leave-reply">' . __( 'No Comment', 'magzimum' ) . '</span>', __( '1 Comment', 'magzimum' ), __( '% Comments', 'magzimum' ) );
                          echo '</li>';
                        ?>
                      <?php endif ?>

                      <?php if ( false == $disable_category ): ?>
                        <li class="category-meta"><?php magzimum_the_category_uno(); ?></li>
                      <?php endif ?>

                    </ul><!-- .latest-news-meta -->
                  <?php endif ?>

                </div><!-- .latest-news-text-wrap -->

                </div><!-- .latest-news-item .col-sm-3 -->

              <?php endforeach ?>

            </div><!-- .row -->

          </div><!-- .latest-news-widget -->

          <?php wp_reset_postdata(); // Reset ?>

        <?php endif; ?>
        <?php
        //
        echo $after_widget;

    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']            = strip_tags($new_instance['title']);
        $instance['post_category']    = absint( $new_instance['post_category'] );
        $instance['post_number']      = absint( $new_instance['post_number'] );
        $instance['post_column']      = absint( $new_instance['post_column'] );
        $instance['excerpt_length']   = absint( $new_instance['excerpt_length'] );
        $instance['featured_image']   = esc_attr( $new_instance['featured_image'] );
        $instance['disable_date']     = isset( $new_instance['disable_date'] );
        $instance['disable_comment']  = isset( $new_instance['disable_comment'] );
        $instance['disable_excerpt']  = isset( $new_instance['disable_excerpt'] );
        $instance['disable_category'] = isset( $new_instance['disable_category'] );
        $instance['custom_class']     = esc_attr( $new_instance['custom_class'] );

        return $instance;
    }

      function form( $instance ) {

        //Defaults
        $instance = wp_parse_args( (array) $instance, array(
          'title'            => '',
          'post_category'    => '',
          'post_column'      => 2,
          'featured_image'   => 'magzimum-thumb',
          'post_number'      => 4,
          'excerpt_length'   => 20,
          'disable_date'     => 0,
          'disable_comment'  => 0,
          'disable_excerpt'  => 0,
          'disable_category' => 0,
          'custom_class'     => '',
        ) );
        $title            = strip_tags( $instance['title'] );
        $post_category    = absint( $instance['post_category'] );
        $post_column      = absint( $instance['post_column'] );
        $featured_image   = esc_attr( $instance['featured_image'] );
        $post_number      = absint( $instance['post_number'] );
        $excerpt_length   = absint( $instance['excerpt_length'] );
        $disable_date     = esc_attr( $instance['disable_date'] );
        $disable_comment  = esc_attr( $instance['disable_comment'] );
        $disable_excerpt  = esc_attr( $instance['disable_excerpt'] );
        $disable_category = esc_attr( $instance['disable_category'] );
        $custom_class     = esc_attr( $instance['custom_class'] );

        ?>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php _e( 'Category:', 'magzimum' ); ?></label>
          <?php
            $cat_args = array(
                'orderby'         => 'name',
                'hide_empty'      => 0,
                'taxonomy'        => 'category',
                'name'            => $this->get_field_name('post_category'),
                'id'              => $this->get_field_id('post_category'),
                'selected'        => $post_category,
                'show_option_all' => __( 'All Categories','magzimum' ),
              );
            wp_dropdown_categories( $cat_args );
          ?>
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'post_column' ) ); ?>"><?php _e('Number of Columns:', 'magzimum' ); ?></label>
          <?php
            $this->dropdown_post_columns( array(
              'id'       => $this->get_field_id( 'post_column' ),
              'name'     => $this->get_field_name( 'post_column' ),
              'selected' => $post_column,
              )
            );
          ?>
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'featured_image' ) ); ?>"><?php _e( 'Featured Image:', 'magzimum' ); ?></label>
          <?php
            $this->dropdown_image_sizes( array(
              'id'       => $this->get_field_id( 'featured_image' ),
              'name'     => $this->get_field_name( 'featured_image' ),
              'selected' => $featured_image,
              )
            );
          ?>
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>"><?php _e('Number of Posts:', 'magzimum' ); ?></label>
          <input class="widefat1" id="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>" type="number" value="<?php echo absint( $post_number ); ?>" min="1" style="max-width:50px;" />
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php _e('Excerpt Length:', 'magzimum' ); ?></label>
          <input class="widefat1" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" value="<?php echo absint( $excerpt_length ); ?>" min="1" style="max-width:50px;" />
        </p>
        <p>
          <input id="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_excerpt' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_excerpt']) ? $instance['disable_excerpt'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt' ) ); ?>"><?php _e( 'Disable Excerpt', 'magzimum' ); ?>
          </label>
        </p>
        <p><input id="<?php echo esc_attr( $this->get_field_id( 'disable_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_date' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_date']) ? $instance['disable_date'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_date' ) ); ?>"><?php _e( 'Disable Date', 'magzimum' ); ?>
          </label>
        </p>
        <p><input id="<?php echo esc_attr( $this->get_field_id( 'disable_comment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_comment' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_comment']) ? $instance['disable_comment'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_comment' ) ); ?>"><?php _e( 'Disable Comment', 'magzimum' ); ?>
          </label>
        </p>
        <p>
          <input id="<?php echo esc_attr( $this->get_field_id( 'disable_category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_category' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_category']) ? $instance['disable_category'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_category' ) ); ?>"><?php _e( 'Disable Category', 'magzimum' ); ?>
          </label>
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>"><?php _e( 'Custom Class:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'custom_class') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_class' ) ); ?>" type="text" value="<?php echo esc_attr( $custom_class ); ?>" />
        </p>
        <?php
      }


    function dropdown_post_columns( $args ){
      $defaults = array(
        'id'       => '',
        'name'     => '',
        'selected' => 0,
        'echo'     => 1,
      );

      $r = wp_parse_args( $args, $defaults );
      $output = '';

      $choices = array(
        '1' => sprintf( __( '%d Column','magzimum' ), 1 ),
        '2' => sprintf( __( '%d Columns','magzimum' ), 2 ),
      );

      if ( ! empty( $choices ) ) {

        $output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
        foreach ( $choices as $key => $choice ) {
          $output .= '<option value="' . esc_attr( $key ) . '" ';
          $output .= selected( $r['selected'], $key, false );
          $output .= '>' . esc_html( $choice ) . '</option>\n';
        }
        $output .= "</select>\n";
      }

      if ( $r['echo'] ) {
        echo $output;
      }
      return $output;

    }

    function dropdown_image_sizes( $args ){
      $defaults = array(
        'id'       => '',
        'name'     => '',
        'selected' => 0,
        'echo'     => 1,
      );

      $r = wp_parse_args( $args, $defaults );
      $output = '';

      $choices = magzimum_get_image_sizes_options();

      if ( ! empty( $choices ) ) {

        $output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
        foreach ( $choices as $key => $choice ) {
          $output .= '<option value="' . esc_attr( $key ) . '" ';
          $output .= selected( $r['selected'], $key, false );
          $output .= '>' . esc_html( $choice ) . '</option>\n';
        }
        $output .= "</select>\n";
      }

      if ( $r['echo'] ) {
        echo $output;
      }
      return $output;

    }

  }

endif;


if ( ! class_exists( 'Magzimum_Ad_Widget' ) ) :

  /**
   * Ad Widget Class
   *
   * @since Magzimum 1.0
   *
   */
  class Magzimum_Ad_Widget extends WP_Widget {

    function __construct() {
      parent::__construct(
        'magzimum_widget_ad', // Base ID
        'Magzimum Ad', // Name
        array( 'description' => __( 'Ad Icons Widget', 'magzimum' ) ) // Args
      );
    }


    function widget( $args, $instance ) {
        extract( $args );

        $title              = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $ad_code           = ! empty( $instance['ad_code'] ) ? $instance['ad_code'] : '';
        $image_url          = empty($instance['image_url']) ? '' : $instance['image_url'];
        $link_url           = empty($instance['link_url']) ? '' : $instance['link_url'];
        $open_in_new_window = empty($instance['open_in_new_window']) ? '' : $instance['open_in_new_window'];
        $alt_text           = empty($instance['alt_text']) ? '' : $instance['alt_text'];
        $custom_class       = apply_filters( 'widget_custom_class', empty( $instance['custom_class'] ) ? '' : $instance['custom_class'], $instance, $this->id_base );


        if ( $custom_class ) {
          $before_widget = str_replace('class="', 'class="'. $custom_class . ' ', $before_widget);
        }

        echo $before_widget;

        // Title
        if ( $title ) echo $before_title . $title . $after_title;
        //
        $ad_content = '';
        if ( ! empty( $ad_code ) ) {
          $ad_content = $ad_code;
        }
        if ( empty( $ad_code ) && ! empty( $image_url ) ) {
          // make html
          $html = '';
          $img_html = '<img src="' . esc_url( $image_url ) . '" alt="'. esc_attr( $alt_text ) . '" />';
          $link_open = '';
          $link_close = '';
          if ( ! empty( $link_url ) ) {
            $target_text = ( true == $open_in_new_window ) ? ' target="_blank" ' : '';
            $link_open = '<a href="' . esc_url( $link_url ) . '" ' . $target_text . '>';
            $link_close = '</a>';
          }
          $ad_content = $link_open . $img_html .  $link_close;
        }
        if ( ! empty( $ad_content ) ) {
          echo '<div class="ad-widget">';
          echo $ad_content;
          echo '</div>';
        }
        //
        echo $after_widget;

    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']        =   esc_html( strip_tags($new_instance['title']) );
        if ( current_user_can( 'unfiltered_html' ) ){
          $instance['ad_code'] =  $new_instance['ad_code'];
        }
        else{
          $instance['ad_code'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['ad_code']) ) ); // wp_filter_post_kses() expects slashed
        }
        $instance['image_url']          =   esc_url( $new_instance['image_url'] );
        $instance['link_url']           =   esc_url( $new_instance['link_url'] );
        $instance['alt_text']           =   esc_attr( $new_instance['alt_text'] );
        $instance['open_in_new_window'] = isset( $new_instance['open_in_new_window'] );
        $instance['custom_class']       =   esc_attr( $new_instance['custom_class'] );

        return $instance;
    }

      function form( $instance ) {

        //Defaults
        $instance = wp_parse_args( (array) $instance, array(
          'title'              => '',
          'ad_code'            => '',
          'image_url'          => '',
          'link_url'           => '',
          'open_in_new_window' => true,
          'alt_text'           => '',
          'custom_class'       => '',
        ) );
        $title              = esc_attr( $instance['title'] );
        $ad_code            = esc_textarea( $instance['ad_code'] );
        $image_url          = esc_url( $instance['image_url'] );
        $link_url           = esc_url( $instance['link_url'] );
        $open_in_new_window = esc_attr( $instance['open_in_new_window'] );
        $alt_text           = esc_attr( $instance['alt_text'] );
        $custom_class       = esc_attr( $instance['custom_class'] );

        ?>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <hr />
        <h4><?php _e( 'Option 1 : Ad Code', 'magzimum' ); ?></h4>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'ad_code' ) ); ?>"><?php _e( 'Adv Code:', 'magzimum' ); ?></label>
           <textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( 'ad_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_code' ) ); ?>"><?php echo html_entity_decode( $ad_code ); ?></textarea>
        </p>
        <hr />
        <h4><?php _e( 'Option 2 : Image', 'magzimum' ); ?></h4>
        <div>
          <label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php _e( 'Image URL:', 'magzimum' ); ?></label><br/>
          <input id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="text" value="<?php echo esc_url( $image_url ); ?>" class="img" />
          <input type="button" class="select-img button button-primary" value="<?php _e('Upload', 'magzimum' ); ?>" data-uploader_title="<?php _e( 'Select Image', 'magzimum' ); ?>" data-uploader_button_text="<?php _e( 'Choose Image', 'magzimum' ); ?>" />
          <?php
            $full_image_url = '';
            if (! empty( $image_url ) ){
              $full_image_url = $image_url;
            }
            $wrap_style = '';
            if ( empty( $full_image_url ) ) {
              $wrap_style = ' style="display:none;" ';
            }
          ?>
          <div class="ad-preview-wrap" <?php echo $wrap_style; ?>>
            <img src="<?php echo esc_url( $full_image_url ); ?>" alt="<?php _e( 'Preview', 'magzimum' ); ?>" style="max-width: 100%;"  />
          </div><!-- .ad-preview-wrap -->

        </div>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>"><?php _e( 'Link URL:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_url' ) ); ?>" type="text" value="<?php echo esc_attr( $link_url ); ?>" />
        </p>
        <p><input id="<?php echo esc_attr( $this->get_field_id( 'open_in_new_window' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'open_in_new_window' ) ); ?>" type="checkbox" <?php checked( isset( $instance['open_in_new_window'] ) ? $instance['open_in_new_window'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'open_in_new_window' ) ); ?>"><?php _e( 'Open in new window', 'magzimum' ); ?></label>
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'alt_text' ) ); ?>"><?php _e( 'Alt Text:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'alt_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alt_text' ) ); ?>" type="text" value="<?php echo esc_attr( $alt_text ); ?>" />
        </p>
        <hr />
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>"><?php _e( 'Custom Class:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_class' ) ); ?>" type="text" value="<?php echo esc_attr( $custom_class ); ?>" />
        </p>
        <p>
          <em><strong><?php _e( 'Note:', 'magzimum' ); ?></strong>&nbsp;<?php _e( 'Option 2 will be ignored if Ad Code is available.', 'magzimum' ); ?></em>
        </p>

        <?php
      }

  }

endif;


if ( ! class_exists( 'Magzimum_Tabbed_Widget' ) ) :

  /**
   * Tabbed Widget Class
   *
   * @since Magzimum 1.0
   *
   */
  class Magzimum_Tabbed_Widget extends WP_Widget {

    function __construct() {
      parent::__construct(
        'magzimum_widget_tabbed', // Base ID
        'Magzimum Tabbed Widget', // Name
        array( 'description' => __( 'Tabbed Widget', 'magzimum' ) ) // Args
      );
    }


    function widget( $args, $instance ) {
        extract( $args );

        $title        = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base );
        $text         = apply_filters( 'widget_welcome_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance, $this->id_base);
        $popular_title = ! empty( $instance['popular_title'] ) ? $instance['popular_title'] : __( 'Popular', 'magzimum' );
        $popular_number = ! empty( $instance['popular_number'] ) ? $instance['popular_number'] : 5;
        $popular_show_date = isset( $instance['popular_show_date'] ) ? $instance['popular_show_date'] : true;
        $popular_show_comment = isset( $instance['popular_show_comment'] ) ? $instance['popular_show_comment'] : false;
        $popular_show_thumbnail = isset( $instance['popular_show_thumbnail'] ) ? $instance['popular_show_thumbnail'] : true;
        $popular_show_category = isset( $instance['popular_show_category'] ) ? $instance['popular_show_category'] : false;
        $recent_title = ! empty( $instance['recent_title'] ) ? $instance['recent_title'] : __( 'Recent', 'magzimum' );
        $recent_number = ! empty( $instance['recent_number'] ) ? $instance['recent_number'] : 5;
        $recent_show_date = isset( $instance['recent_show_date'] ) ? $instance['recent_show_date'] : true;
        $recent_show_comment = isset( $instance['recent_show_comment'] ) ? $instance['recent_show_comment'] : false;
        $recent_show_thumbnail = isset( $instance['recent_show_thumbnail'] ) ? $instance['recent_show_thumbnail'] : true;
        $recent_show_category = isset( $instance['recent_show_category'] ) ? $instance['recent_show_category'] : false;
        $comment_title = ! empty( $instance['comment_title'] ) ? $instance['comment_title'] : __( 'Comment', 'magzimum' );
        $comment_number = ! empty( $instance['comment_number'] ) ? $instance['comment_number'] : 5;
        $comment_show_date = isset( $instance['comment_show_date'] ) ? $instance['comment_show_date'] : true;
        $custom_class = apply_filters( 'widget_custom_class', empty( $instance['custom_class'] ) ? '' : $instance['custom_class'], $instance, $this->id_base );

        if ( $custom_class ) {
          $before_widget = str_replace( 'class="', 'class="'. $custom_class . ' ', $before_widget );
        }

        $settings_args = array(

          'popular_title'          => $popular_title,
          'popular_number'         => $popular_number,
          'popular_show_date'      => $popular_show_date,
          'popular_show_comment'   => $popular_show_comment,
          'popular_show_thumbnail' => $popular_show_thumbnail,
          'popular_show_category'  => $popular_show_category,

          'recent_title'           => $recent_title,
          'recent_number'          => $recent_number,
          'recent_show_date'       => $recent_show_date,
          'recent_show_comment'    => $recent_show_comment,
          'recent_show_thumbnail'  => $recent_show_thumbnail,
          'recent_show_category'   => $recent_show_category,

          'comment_title'          => $comment_title,
          'comment_number'         => $comment_number,
          'comment_show_date'      => $comment_show_date,
        );

        echo $before_widget;
        //
        $this->render_content( $settings_args );
        //
        echo $after_widget;

    }

    function render_content( $settings ){
      $active_tabs = array(
        'popular' => $settings['popular_title'],
        'recent'  => $settings['recent_title'],
        'comment' => $settings['comment_title'],
      );
      $widget_id = $this->id;
      ?>
      <div id="<?php echo esc_attr( $widget_id ); ?>" class="tab-container">
        <ul class='etabs'>
          <?php foreach ($active_tabs as $key => $tab): ?>
            <?php
              $li_class = 'tab tab-' . $key;
            ?>
            <li class='<?php echo esc_attr( $li_class); ?>'><a href="#<?php echo esc_attr( $widget_id . '-' . $key ); ?>"><?php echo esc_html( $tab ); ?></a></li>
          <?php endforeach ?>
        </ul>
        <?php foreach ($active_tabs as $key => $tab): ?>
          <div id="<?php echo esc_attr( $widget_id . '-' . $key ); ?>">
            <?php
              $method_name = 'render_tab_' .  $key;
              $output = call_user_func_array( array( $this, $method_name ), array( $settings ) );
            ?>
          </div>
        <?php endforeach ?>
      </div>
      <script>
      jQuery(document).ready(function($){
        $('#<?php echo esc_attr( $widget_id ); ?>').easytabs({
          updateHash: false,
          animate: false
        });
      });
      </script>
      <?php
    }

    function render_tab_popular( $settings ){
      $args = array(
        'posts_per_page'      => $settings['popular_number'],
        'no_found_rows'       => true,
        'post_status'         => 'publish',
        'orderby'             => 'comment_count',
        'order'               => 'DESC',
        'ignore_sticky_posts' => true,
      );
      $popular = new WP_Query( $args );
      if ( $popular->have_posts() ){
        echo '<div class="tab-popular">';

        while ( $popular->have_posts() ) : $popular->the_post();
          global $post;
          ?>
          <div class="popular">
          <?php if ( has_post_thumbnail() && 1 == $settings['popular_show_thumbnail'] ): ?>
            <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) ); ?>
          <?php endif ?>
            <h3>
              <a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
            </h3>

            <ul class="news-meta">
              <?php if ( $settings['popular_show_date'] ): ?>
                <li class="date-meta"><?php the_date(); ?></li>
              <?php endif ?>

              <?php
              if ( 1 == $settings['popular_show_comment'] ) {
                $num_comments = get_comments_number();
                if( 1 == $num_comments ){
                  $comment_text = sprintf( __( '%d comment', 'magzimum' ) , $num_comments );
                }
                else{
                  $comment_text = sprintf( __( '%d comments', 'magzimum' ) , $num_comments );
                }
                echo $comment_link = '<li class="comment-meta"><a href="' . get_comments_link() . '" class="s">' . $comment_text .  '</a></li>';
              }
              ?>
              <?php if ( 1 == $settings['popular_show_category'] ): ?>
                <li class="category-meta">
                  <?php magzimum_the_category_uno( $post->ID ); ?>
                </li><!-- .category-meta -->
              <?php endif ?>

              </ul><!-- .news-meta -->

          </div>
          <?php
        endwhile;

        echo '</div>';
      }
      // Reset the global $the_post
      wp_reset_postdata();

    }

    function render_tab_recent( $settings ){
      $args = array(
        'posts_per_page'      => $settings['recent_number'],
        'no_found_rows'       => true,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
      );
      $recent = new WP_Query( $args );
      if ( $recent->have_posts() ){
        echo '<div class="tab-recent">';
        while ( $recent->have_posts() ) : $recent->the_post();
          global $post;
          ?>
          <div class="recent">
          <?php if ( has_post_thumbnail() && 1 == $settings['recent_show_thumbnail'] ): ?>
              <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) ); ?>
            <?php endif ?>

            <h3>
              <a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
            </h3>
            <ul class="news-meta">
              <?php if ( $settings['recent_show_date'] ): ?>
                <li class="date-meta"><?php echo get_the_date(); ?></li>
              <?php endif ?>

              <?php
              if ( 1 == $settings['recent_show_comment'] ) {
                $num_comments = get_comments_number();
                if( 1 == $num_comments ){
                  $comment_text = sprintf( __( '%d comment', 'magzimum' ) , $num_comments );
                }
                else{
                  $comment_text = sprintf( __( '%d comments', 'magzimum' ) , $num_comments );
                }
                echo $comment_link = '<li class="comment-meta"><a href="' . get_comments_link() . '" >' . $comment_text .  '</a></li>';
              }
              ?>
              <?php if ( 1 == $settings['recent_show_category'] ): ?>
                <li class="category-meta"><?php magzimum_the_category_uno( $post->ID ); ?></li><!-- .category-meta -->
              <?php endif ?>

            </ul><!-- .news-meta -->

          </div>
          <?php
        endwhile;
        echo '</div>';

      }
      // Reset the global $the_post
      wp_reset_postdata();

    }
    function render_tab_comment( $settings ){
      $comment_args = array(
        'number'      => $settings['comment_number'],
        'status'      => 'approve',
        'post_status' => 'publish',
      );
      $comments = get_comments( $comment_args );
      if ( ! empty( $comments ) ) {
        echo '<div class="tab-comment">';
        foreach ( $comments as $key => $comment ) {
          ?>
          <div class="comment">
            <?php echo get_comment_author_link( $comment->comment_ID ); ?>
            <?php echo _x( 'on', 'Tabbed Widget', 'magzimum' ); ?>
            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php echo esc_attr( get_the_title( $comment->comment_post_ID ) ); ?></a>
            <?php if ( $settings['comment_show_date'] ): ?>
              <ul class="news-meta">
                <li class="date-meta"><?php echo date( get_option('date_format'), strtotime( $comment->comment_date ) ) ?></li>
              </ul><!-- .news-meta -->
            <?php endif ?>
          </div><!-- .comment -->
          <?php
        }
        echo '</div>';
      }
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['popular_title'] = strip_tags( $new_instance['popular_title'] );
        if ( empty( $instance['popular_title'] ) ) {
          $instance['popular_title'] = __( 'Popular', 'magzimum' );
        }
        $instance['popular_number']       = absint( $new_instance['popular_number'] );
        $instance['popular_show_date']    = isset( $new_instance['popular_show_date'] );
        $instance['popular_show_comment'] = isset( $new_instance['popular_show_comment'] );
        $instance['popular_show_thumbnail'] = isset( $new_instance['popular_show_thumbnail'] );
        $instance['popular_show_category'] = isset( $new_instance['popular_show_category'] );

        $instance['recent_title']  = strip_tags( $new_instance['recent_title'] );
        if ( empty( $instance['recent_title'] ) ) {
          $instance['recent_title'] = __( 'Recent', 'magzimum' );
        }
        $instance['recent_number']       = absint( $new_instance['recent_number'] );
        $instance['recent_show_date']    = isset( $new_instance['recent_show_date'] );
        $instance['recent_show_comment'] = isset( $new_instance['recent_show_comment'] );
        $instance['recent_show_thumbnail'] = isset( $new_instance['recent_show_thumbnail'] );
        $instance['recent_show_category'] = isset( $new_instance['recent_show_category'] );

        $instance['comment_title'] = strip_tags( $new_instance['comment_title'] );
        if ( empty( $instance['comment_title'] ) ) {
          $instance['comment_title'] = __( 'Comment', 'magzimum' );
        }
        $instance['comment_number']    = absint( $new_instance['comment_number'] );
        $instance['comment_show_date'] = isset( $new_instance['comment_show_date'] );

        $instance['filter'] = isset( $new_instance['filter'] );

        $instance['custom_class']  = esc_attr( $new_instance['custom_class'] );

        return $instance;
    }

      function form( $instance ) {

        //Defaults
        $instance = wp_parse_args( (array) $instance, array(
          'popular_title'          => __( 'Popular', 'magzimum' ),
          'popular_number'         => 5,
          'popular_show_date'      => 1,
          'popular_show_comment'   => 0,
          'popular_show_thumbnail' => 1,
          'popular_show_category'  => 0,

          'recent_title'           => __( 'Recent', 'magzimum' ),
          'recent_number'          => 5,
          'recent_show_date'       => 1,
          'recent_show_comment'    => 0,
          'recent_show_thumbnail'  => 1,
          'recent_show_category'   => 0,

          'comment_title'          => __( 'Comment', 'magzimum' ),
          'comment_number'         => 5,
          'comment_show_date'      => 1,
          'filter'                 => 0,
          'custom_class'           => '',
        ) );
        $popular_title          = strip_tags( $instance['popular_title'] );
        $popular_number         = absint( $instance['popular_number'] );
        $popular_show_date      = esc_attr( $instance['popular_show_date'] );
        $popular_show_comment   = esc_attr( $instance['popular_show_comment'] );
        $popular_show_thumbnail = esc_attr( $instance['popular_show_thumbnail'] );
        $popular_show_category  = esc_attr( $instance['popular_show_category'] );

        $recent_title           = strip_tags( $instance['recent_title'] );
        $recent_number          = absint( $instance['recent_number'] );
        $recent_show_date       = esc_attr( $instance['recent_show_date'] );
        $recent_show_comment    = esc_attr( $instance['recent_show_comment'] );
        $recent_show_thumbnail  = esc_attr( $instance['recent_show_thumbnail'] );
        $recent_show_category   = esc_attr( $instance['recent_show_category'] );

        $comment_title          = strip_tags( $instance['comment_title'] );
        $comment_number         = absint( $instance['comment_number'] );
        $comment_show_date      = esc_attr( $instance['comment_show_date'] );
        $filter                 = esc_attr( $instance['filter'] );
        $custom_class           = esc_attr( $instance['custom_class'] );

        ?>
        <div class="custom-theme-accordion">
          <h4 class="accordion-toggle opened"><?php _e( 'Popular Posts', 'magzimum' ); ?></h4>
          <div class="accordion-content active">
            <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'popular_title' ) ); ?>"><?php _e( 'Tab Title:', 'magzimum' ); ?></label>
              <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'popular_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popular_title' ) ); ?>" type="text" value="<?php echo esc_attr( $popular_title ); ?>" />
            </p>
            <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'popular_number' ) ); ?>"><?php _e( 'Number of Posts:', 'magzimum' ); ?></label>
              <input id="<?php echo esc_attr( $this->get_field_id( 'popular_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popular_number' ) ); ?>" type="number" min="1" value="<?php echo esc_attr( $popular_number ); ?>" style="max-width:50px;"/>
            </p>
            <p>
              <input id="<?php echo esc_attr( $this->get_field_id( 'popular_show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popular_show_date' ) ); ?>" type="checkbox" <?php checked( isset( $instance['popular_show_date'] ) ? $instance['popular_show_date'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'popular_show_date' ) ); ?>"><?php _e( 'Show Date', 'magzimum' ); ?></label>
            </p>
            <p>
              <input id="<?php echo esc_attr( $this->get_field_id( 'popular_show_comment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popular_show_comment' ) ); ?>" type="checkbox" <?php checked( isset( $instance['popular_show_comment'] ) ? $instance['popular_show_comment'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'popular_show_comment' ) ); ?>"><?php _e( 'Show Comment', 'magzimum' ); ?></label>
            </p>
            <p>
              <input id="<?php echo esc_attr( $this->get_field_id( 'popular_show_thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popular_show_thumbnail' ) ); ?>" type="checkbox" <?php checked( isset( $instance['popular_show_thumbnail'] ) ? $instance['popular_show_thumbnail'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'popular_show_thumbnail' ) ); ?>"><?php _e( 'Show Thumbnail', 'magzimum' ); ?></label>
            </p>
            <p>
              <input id="<?php echo esc_attr( $this->get_field_id( 'popular_show_category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popular_show_category' ) ); ?>" type="checkbox" <?php checked( isset( $instance['popular_show_category'] ) ? $instance['popular_show_category'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'popular_show_category' ) ); ?>"><?php _e( 'Show Category', 'magzimum' ); ?></label>
            </p>
          </div>
          <h4 class="accordion-toggle"><?php _e( 'Recent Posts', 'magzimum' ); ?></h4>
          <div class="accordion-content">
            <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'recent_title' ) ); ?>"><?php _e( 'Tab Title:', 'magzimum' ); ?></label>
              <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'recent_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recent_title' ) ); ?>" type="text" value="<?php echo esc_attr( $recent_title ); ?>" />
            </p>
            <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'recent_number' ) ); ?>"><?php _e( 'Number of Posts:', 'magzimum' ); ?></label>
              <input id="<?php echo esc_attr( $this->get_field_id( 'recent_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recent_number' ) ); ?>" type="number" min="1" value="<?php echo esc_attr( $recent_number ); ?>" style="max-width:50px;"/>
            </p>
            <p>
              <input id="<?php echo esc_attr( $this->get_field_id( 'recent_show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recent_show_date' ) ); ?>" type="checkbox" <?php checked( isset( $instance['recent_show_date'] ) ? $instance['recent_show_date'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'recent_show_date' ) ); ?>"><?php _e( 'Show Date', 'magzimum' ); ?></label>
            </p>
            <p>
              <input id="<?php echo esc_attr( $this->get_field_id( 'recent_show_comment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recent_show_comment' ) ); ?>" type="checkbox" <?php checked( isset( $instance['recent_show_comment'] ) ? $instance['recent_show_comment'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'recent_show_comment' ) ); ?>"><?php _e( 'Show Comment', 'magzimum' ); ?></label>
            </p>
            <p>
              <input id="<?php echo esc_attr( $this->get_field_id( 'recent_show_thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recent_show_thumbnail' ) ); ?>" type="checkbox" <?php checked( isset( $instance['recent_show_thumbnail'] ) ? $instance['recent_show_thumbnail'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'recent_show_thumbnail' ) ); ?>"><?php _e( 'Show Thumbnail', 'magzimum' ); ?></label>
            </p>
            <p>
              <input id="<?php echo esc_attr( $this->get_field_id( 'recent_show_category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recent_show_category' ) ); ?>" type="checkbox" <?php checked( isset( $instance['recent_show_category'] ) ? $instance['recent_show_category'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'recent_show_category' ) ); ?>"><?php _e( 'Show Category', 'magzimum' ); ?></label>
            </p>
          </div>
          <h4 class="accordion-toggle"><?php _e( 'Comments', 'magzimum' ); ?></h4>
          <div class="accordion-content">
            <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'comment_title' ) ); ?>"><?php _e( 'Tab Title:', 'magzimum' ); ?></label>
              <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'comment_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comment_title' ) ); ?>" type="text" value="<?php echo esc_attr( $comment_title ); ?>" />
            </p>
            <p>
              <label for="<?php echo esc_attr( $this->get_field_id( 'comment_number' ) ); ?>"><?php _e( 'Number of Comments:', 'magzimum' ); ?></label>
              <input id="<?php echo esc_attr( $this->get_field_id( 'comment_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comment_number' ) ); ?>" type="number" min="1" value="<?php echo esc_attr( $comment_number ); ?>" style="max-width:50px;"/>
            </p>
            <p>
              <input id="<?php echo esc_attr( $this->get_field_id( 'comment_show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comment_show_date' ) ); ?>" type="checkbox" <?php checked( isset( $instance['comment_show_date'] ) ? $instance['comment_show_date'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'comment_show_date' ) ); ?>"><?php _e( 'Show Date', 'magzimum' ); ?></label>
            </p>

          </div>
        </div>
        <hr />
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>"><?php _e( 'Custom Class:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'custom_class') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_class' ) ); ?>" type="text" value="<?php echo esc_attr( $custom_class ); ?>" />
        </p>
        <?php
      }
  }

endif;


if ( ! class_exists( 'Magzimum_Special_Posts_Widget' ) ) :

  /**
   * Special Posts Widget Class
   *
   * @since Magzimum 1.0
   *
   */
  class Magzimum_Special_Posts_Widget extends WP_Widget {

    function __construct() {
      parent::__construct(
        'magzimum_widget_special_posts', // Base ID
        'Magzimum Special Posts', // Name
        array( 'description' => __( 'Special Posts Widget', 'magzimum' ) ) // Args
      );
    }


    function widget( $args, $instance ) {
        extract( $args );

        $post_id       = empty( $instance['post_id'] ) ? '' : $instance['post_id'];
        $post_id_2     = empty( $instance['post_id_2'] ) ? '' : $instance['post_id_2'];
        $post_category = empty( $instance['post_category'] ) ? '' : $instance['post_category'];
        $custom_class  = apply_filters( 'widget_custom_class', empty( $instance['custom_class'] ) ? '' : $instance['custom_class'], $instance, $this->id_base );

        if ( $custom_class ) {
          $before_widget = str_replace( 'class="', 'class="'. $custom_class . ' ', $before_widget );
        }

        echo $before_widget;

        //
        $qargs = array(
          'posts_per_page' => 2,
          'no_found_rows'  => true,
          );
        if ( absint( $post_id ) > 0 && absint( $post_id_2 ) > 0 ) {
          $qargs['post__in'] = array ( absint( $post_id ), absint( $post_id_2 ) );
          $qargs['post_type'] = 'any';
        }
        else if ( absint( $post_category ) > 0  ) {
          $qargs['category']  = $post_category;
          $qargs['post_type'] = 'post';
        }

        $obj_special_posts = get_posts( $qargs );
        global $post;
        if ( ! empty( $obj_special_posts ) ) {
          foreach( $obj_special_posts as $post ) :
            setup_postdata($post);
            ?>
            <div class="special-posts-widget">
              <?php if ( has_post_thumbnail() ): ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                  <?php the_post_thumbnail( 'magzimum-thumb', array( 'class' => 'aligncenter' ) ); ?>
                </a>
              <?php endif ?>
              <div class="special-overlay">
                <h3 class="special-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3><!-- .special-title -->

              </div><!-- .special-overlay -->

            </div><!-- .special-posts-widget -->
            <?php
          endforeach;
          ?>
          <?php
          // Reset postdata
          wp_reset_postdata();
          ?>
          <?php
        }
        //
        echo $after_widget;

    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        if ( absint( $new_instance['post_id'] ) > 0 ) {
          $instance['post_id'] = absint( $new_instance['post_id'] );
        }
        else{
          $instance['post_id'] = '';
        }
        if ( absint( $new_instance['post_id_2'] ) > 0 ) {
          $instance['post_id_2'] = absint( $new_instance['post_id_2'] );
        }
        else{
          $instance['post_id_2'] = '';
        }

        $instance['post_category'] = absint( $new_instance['post_category'] );
        $instance['custom_class']  = esc_attr( $new_instance['custom_class'] );

        return $instance;
    }

      function form( $instance ) {

        //Defaults
        $instance = wp_parse_args( (array) $instance, array(
          'post_id'        => '',
          'post_id_2'      => '',
          'post_category'  => '',
          'custom_class'   => '',
        ) );
        $post_id        = esc_attr( $instance['post_id'] );
        $post_id_2      = esc_attr( $instance['post_id_2'] );
        $post_category  = esc_attr( $instance['post_category'] );
        $custom_class   = esc_attr( $instance['custom_class'] );

        ?>

        <p><strong><?php _e( 'Enter two Post IDs or choose Category to display latest posts from.', 'magzimum' ); ?></strong></p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'post_id' ) ); ?>"><?php _e( 'Enter Post ID:', 'magzimum' ); ?></label>
          <input id="<?php echo esc_attr( $this->get_field_id( 'post_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_id' ) ); ?>" type="text" value="<?php echo esc_attr( $post_id ); ?>"  style="max-width:60px;" />
          <input id="<?php echo esc_attr( $this->get_field_id( 'post_id_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_id_2' ) ); ?>" type="text" value="<?php echo esc_attr( $post_id_2 ); ?>" style="max-width:60px;" />
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php _e( 'Category:', 'magzimum' ); ?></label>
          <?php
            $cat_args = array(
                'orderby'         => 'name',
                'hide_empty'      => 1,
                'taxonomy'        => 'category',
                'name'            => $this->get_field_name( 'post_category' ),
                'id'              => $this->get_field_id( 'post_category' ),
                'selected'        => $post_category,
                'show_option_all' => __( 'All Categories', 'magzimum' ),
              );
            wp_dropdown_categories( $cat_args );
          ?>
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>"><?php _e( 'Custom Class:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'custom_class') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_class' ) ); ?>" type="text" value="<?php echo esc_attr( $custom_class ); ?>" />
        </p>
        <?php
      }

  }

endif;

if ( ! class_exists( 'Magzimum_Categorized_News_Widget' ) ) :

  /**
   * Categorized News Widget Class
   *
   * @since Magzimum 1.0
   *
   */
class Magzimum_Categorized_News_Widget extends WP_Widget {

    function __construct() {
      parent::__construct(
        'magzimum_widget_categorized_news', // Base ID
        'Magzimum Categorized News', // Name
        array( 'description' => __( 'Categorized News Widget', 'magzimum' ) ) // Args
      );
    }


    function widget( $args, $instance ) {
        extract( $args );

        $title                 = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base );
        $post_category         = ! empty( $instance['post_category'] ) ? $instance['post_category'] : 0;
        $show_more_icon        = ! empty( $instance['show_more_icon'] ) ? true : false ;

        $featured_image        = ! empty( $instance['featured_image'] ) ? $instance['featured_image'] : 'magzimum-thumb';
        $excerpt_length_main   = ! empty( $instance['excerpt_length_main'] ) ? $instance['excerpt_length_main'] : 40;
        $disable_excerpt_main  = ! empty( $instance['disable_excerpt_main'] ) ? true : false ;
        $disable_date_main     = ! empty( $instance['disable_date_main'] ) ? $instance['disable_date_main'] : false ;
        $disable_comment_main  = ! empty( $instance['disable_comment_main'] ) ? $instance['disable_comment_main'] : false ;
        $disable_category_main = ! empty( $instance['disable_category_main'] ) ? true : false ;

        $post_number           = ! empty( $instance['post_number'] ) ? $instance['post_number'] : 3;
        $thumbnail_size        = ! empty( $instance['thumbnail_size'] ) ? $instance['thumbnail_size'] : 80;
        $excerpt_length_side   = ! empty( $instance['excerpt_length_side'] ) ? $instance['excerpt_length_side'] : 10;
        $disable_excerpt_side  = ! empty( $instance['disable_excerpt_side'] ) ? true : false ;
        $disable_date_side     = ! empty( $instance['disable_date_side'] ) ? $instance['disable_date_side'] : false ;
        $disable_comment_side  = ! empty( $instance['disable_comment_side'] ) ? $instance['disable_comment_side'] : false ;
        $disable_category_side = ! empty( $instance['disable_category_side'] ) ? true : false ;

        $custom_class          = apply_filters( 'widget_custom_class', empty( $instance['custom_class'] ) ? '' : $instance['custom_class'], $instance, $this->id_base );

        // Add Custom class
        if ( $custom_class ) {
          $before_widget = str_replace( 'class="', 'class="'. $custom_class . ' ', $before_widget );
        }

        echo $before_widget;

        // Title
        if ( $title ) {
          echo $before_title . $title;
          if ( absint( $post_category ) > 0 && true == $show_more_icon ) {
            $cat_obj = get_the_category_by_ID( $post_category );
            $cat_obj = get_term_by( 'id', $post_category, 'category' ) ;
            if ( $cat_obj ) {
              $more_link = get_term_link( $cat_obj );
              $more_title = __( 'View more from', 'magzimum' ). ' ' . $cat_obj->name;
              echo '<span class="category-more">';
              echo '<a href="' . esc_url( $more_link ) . '" title="' . esc_attr( $more_title ) . '"><i class="fa fa-folder-open"></i></a>';
              echo '</span>';
            }
          }
          echo $after_title;
        }

        global $post;

        //
        ?>

          <div class="categorized-news-widget">

            <div class="row">
              <div class="col-sm-6">

                <?php
                  $qargs = array(
                    'posts_per_page' => 1,
                    'no_found_rows'  => true,
                    );
                  if ( absint( $post_category ) > 0  ) {
                    $qargs['category'] = $post_category;
                  }

                  $all_posts = get_posts( $qargs );
                  // nspre($all_posts);
                ?>
                <?php if ( ! empty( $all_posts ) ): ?>
                  <?php
                    $post = $all_posts[0];
                    setup_postdata( $post );
                  ?>
                  <?php if ( has_post_thumbnail() ): ?>
                    <a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
                      <?php
                      $thumb_args = array( 'class' => 'aligncenter' );
                      the_post_thumbnail( $featured_image, $thumb_args );
                      ?>
                    </a>
                  <?php endif ?>
                  <h3 class="categorized-news-title">
                    <a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
                      <?php the_title(); ?>
                    </a>
                  </h3><!-- .categorized-news-title -->
                  <?php if ( false == $disable_excerpt_main ): ?>
                    <p><?php echo absint( magzimum_get_the_excerpt( $excerpt_length_main, $post ) ); ?></p>
                  <?php endif ?>

                  <ul class="news-meta">

                    <?php if ( false == $disable_date_main ): ?>
                      <li class="date-meta"><?php the_time( get_option('date_format') ); ?></li><!-- .categorized-news-date -->
                    <?php endif ?>

                      <?php if ( false == $disable_comment_main ): ?>
                        <?php
                          echo '<li class="comment-meta">';
                          comments_popup_link( '<span class="leave-reply">' . __( 'No Comment', 'magzimum' ) . '</span>', __( '1 Comment', 'magzimum' ), __( '% Comments', 'magzimum' ) );
                          echo '</li>';
                        ?>
                      <?php endif ?>

                      <?php if ( false == $disable_category_main ): ?>
                        <li class="category-meta"><?php magzimum_the_category_uno( $post->ID ); ?></li><!-- .category-meta -->
                      <?php endif ?>

                  </ul><!-- .categorized-news-meta -->

                  <?php
                    // Reset
                    wp_reset_postdata();
                  ?>
                <?php endif ?>


              </div><!-- .col-sm-6 -->
              <div class="col-sm-6">

                <?php
                  $qargs = array(
                    'posts_per_page' => $post_number,
                    'no_found_rows'  => true,
                    'offset'         => 1,
                    );
                  if ( absint( $post_category ) > 0  ) {
                    $qargs['category'] = $post_category;
                  }

                  $all_posts = get_posts( $qargs );
                ?>

                <?php if ( ! empty( $all_posts ) ): ?>


                  <?php global $post; ?>

                  <div class="categorized-news-right">


                    <?php foreach ( $all_posts as $key => $post ): ?>
                      <?php setup_postdata( $post ); ?>

                      <div class="categorized-news-item">

                      <?php if ( has_post_thumbnail() ): ?>
                        <div class="categorized-news-thumb">
                          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php
                              $img_attributes = array();
                              if ( absint( $thumbnail_size ) > 0 ) {
                                $img_attributes['style'] = 'max-width: '. esc_attr( absint( $thumbnail_size ) ) . 'px;';
                              }
                              the_post_thumbnail( 'thumbnail', $img_attributes );
                            ?>
                          </a>
                        </div><!-- .categorized-news-thumb -->
                      <?php endif ?>
                      <div class="categorized-news-text-wrap">
                        <h3 class="categorized-news-title">
                          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                        </h3><!-- .categorized-news-title -->

                        <?php if ( false == $disable_excerpt_side ): ?>
                          <p><?php echo absint( magzimum_get_the_excerpt( $excerpt_length_side, $post ) ); ?></p>
                        <?php endif ?>

                        <?php if ( false == $disable_date_side || ( false == $disable_comment_side && comments_open( $post->ID ) ) ): ?>
                          <ul class="news-meta">

                            <?php if ( false == $disable_date_side ): ?>
                              <li class="date-meta"><?php the_time( get_option('date_format') ); ?></li>
                            <?php endif ?>

                            <?php if ( false == $disable_comment_side ): ?>
                              <?php
                                echo '<li class="comment-meta">';
                                comments_popup_link( '<span class="leave-reply">' . __( 'No Comment', 'magzimum' ) . '</span>', __( '1 Comment', 'magzimum' ), __( '% Comments', 'magzimum' ) );
                                echo '</li>';
                              ?>
                            <?php endif ?>

                            <?php if ( false == $disable_category_side ): ?>
                              <li class="category-meta"><?php magzimum_the_category_uno( $post->ID ); ?></li><!-- .category-meta -->
                            <?php endif ?>


                          </ul><!-- .categorized-news-meta -->
                        <?php endif ?>

                      </div><!-- .categorized-news-text-wrap -->

                      </div><!-- .categorized-news-item .col-sm-3 -->

                    <?php endforeach ?>

                  </div><!-- .categorized-news-right -->

                  <?php wp_reset_postdata(); // Reset ?>

                <?php endif; // end if all_posts ?>


              </div><!-- .col-sm-6 -->
            </div><!-- .row -->

          </div><!-- .categorized-news-widget -->

        <?php
        //
        echo $after_widget;

    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']                 = strip_tags($new_instance['title']);
        $instance['post_category']         = absint( $new_instance['post_category'] );
        $instance['show_more_icon']        = isset( $new_instance['show_more_icon'] );

        $instance['featured_image']        = esc_attr( $new_instance['featured_image'] );
        $instance['excerpt_length_main']   = absint( $new_instance['excerpt_length_main'] );
        $instance['disable_excerpt_main']  = isset( $new_instance['disable_excerpt_main'] );
        $instance['disable_date_main']     = isset( $new_instance['disable_date_main'] );
        $instance['disable_comment_main']  = isset( $new_instance['disable_comment_main'] );
        $instance['disable_category_main'] = isset( $new_instance['disable_category_main'] );

        $instance['post_number']           = absint( $new_instance['post_number'] );
        $instance['thumbnail_size']        = absint( $new_instance['thumbnail_size'] );
        $instance['excerpt_length_side']   = absint( $new_instance['excerpt_length_side'] );
        $instance['disable_excerpt_side']  = isset( $new_instance['disable_excerpt_side'] );
        $instance['disable_date_side']     = isset( $new_instance['disable_date_side'] );
        $instance['disable_comment_side']  = isset( $new_instance['disable_comment_side'] );
        $instance['disable_category_side'] = isset( $new_instance['disable_category_side'] );

        $instance['custom_class']          = esc_attr( $new_instance['custom_class'] );

        return $instance;
    }

      function form( $instance ) {

        //Defaults
        $instance = wp_parse_args( (array) $instance, array(

          'title'                 => '',
          'post_category'         => '',
          'show_more_icon'        => 0,

          'featured_image'        => 'magzimum-thumb',
          'excerpt_length_main'   => 40,
          'disable_excerpt_main'  => 0,
          'disable_date_main'     => 0,
          'disable_comment_main'  => 0,
          'disable_category_main' => 1,

          'post_number'           => 3,
          'thumbnail_size'        => 80,
          'excerpt_length_side'   => 10,
          'disable_excerpt_side'  => 0,
          'disable_date_side'     => 0,
          'disable_comment_side'  => 0,
          'disable_category_side' => 1,
          'custom_class'          => '',

        ) );
        $title                 = strip_tags( $instance['title'] );
        $post_category         = absint( $instance['post_category'] );
        $show_more_icon        = esc_attr( $instance['show_more_icon'] );

        $featured_image        = esc_attr( $instance['featured_image'] );
        $excerpt_length_main   = absint( $instance['excerpt_length_main'] );
        $disable_excerpt_main  = esc_attr( $instance['disable_excerpt_main'] );
        $disable_date_main     = esc_attr( $instance['disable_date_main'] );
        $disable_comment_main  = esc_attr( $instance['disable_comment_main'] );
        $disable_category_main = esc_attr( $instance['disable_category_main'] );

        $post_number           = absint( $instance['post_number'] );
        $thumbnail_size        = absint( $instance['thumbnail_size'] );
        $excerpt_length_side   = absint( $instance['excerpt_length_side'] );
        $disable_excerpt_side  = esc_attr( $instance['disable_excerpt_side'] );
        $disable_date_side     = esc_attr( $instance['disable_date_side'] );
        $disable_comment_side  = esc_attr( $instance['disable_comment_side'] );
        $disable_category_side = esc_attr( $instance['disable_category_side'] );

        $custom_class          = esc_attr( $instance['custom_class'] );

        ?>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php _e( 'Select Category:', 'magzimum' ); ?></label>
          <?php
            $cat_args = array(
                'orderby'         => 'name',
                'hide_empty'      => 0,
                'taxonomy'        => 'category',
                'name'            => $this->get_field_name('post_category'),
                'id'              => $this->get_field_id('post_category'),
                'selected'        => $post_category,
                'show_option_all' => __( 'All Categories','magzimum' ),
              );
            wp_dropdown_categories( $cat_args );
          ?>
        </p>
        <p>
          <input id="<?php echo esc_attr( $this->get_field_id( 'show_more_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_more_icon' ) ); ?>" type="checkbox" <?php checked(isset($instance['show_more_icon']) ? $instance['show_more_icon'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'show_more_icon' ) ); ?>"><?php _e( 'Show View More Icon', 'magzimum' ); ?><br/><small><?php _e( 'Icon will be displayed only if Category is selected.', 'magzimum' ); ?></small>
          </label>
        </p>


        <h4><?php _e( 'For Main Block', 'magzimum' ); ?></h4>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'featured_image' ) ); ?>"><?php _e( 'Select Image Size:', 'magzimum' ); ?></label>
          <?php
            $this->dropdown_image_sizes( array(
              'id'       => $this->get_field_id( 'featured_image' ),
              'name'     => $this->get_field_name( 'featured_image' ),
              'selected' => $featured_image,
              )
            );
          ?>
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length_main' ) ); ?>"><?php _e('Excerpt Length:', 'magzimum' ); ?></label>
          <input class="widefat1" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length_main' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length_main' ) ); ?>" type="number" value="<?php echo esc_attr( $excerpt_length_main ); ?>" min="1" style="max-width:50px;" />&nbsp;<small><?php _e( 'in words', 'magzimum' ); ?></small>
        </p>
        <p>
          <input id="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt_main' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_excerpt_main' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_excerpt_main']) ? $instance['disable_excerpt_main'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt_main' ) ); ?>"><?php _e( 'Disable Excerpt', 'magzimum' ); ?>
          </label>
        </p>
        <p>
          <input id="<?php echo esc_attr( $this->get_field_id( 'disable_date_main' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_date_main' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_date_main']) ? $instance['disable_date_main'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_date_main' ) ); ?>"><?php _e( 'Disable Date', 'magzimum' ); ?>
          </label>
        </p>
        <p>
          <input id="<?php echo esc_attr( $this->get_field_id( 'disable_comment_main' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_comment_main' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_comment_main']) ? $instance['disable_comment_main'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_comment_main' ) ); ?>"><?php _e( 'Disable Comment', 'magzimum' ); ?>
          </label>
        </p>
        <p>
          <input id="<?php echo esc_attr( $this->get_field_id( 'disable_category_main' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_category_main' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_category_main']) ? $instance['disable_category_main'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_category_main' ) ); ?>"><?php _e( 'Disable Category', 'magzimum' ); ?>
          </label>
        </p>

        <h4><?php _e( 'For Side Block', 'magzimum' ); ?></h4>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>"><?php _e( 'Number of Posts:', 'magzimum' ); ?></label>
          <input id="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>" type="number" value="<?php echo esc_attr( $post_number ); ?>" min="1" style="max-width:50px;" />
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'thumbnail_size' ) ); ?>"><?php _e( 'Thumbnail Width:', 'magzimum' ); ?></label>
          <input id="<?php echo esc_attr( $this->get_field_id( 'thumbnail_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumbnail_size' ) ); ?>" type="number" value="<?php echo esc_attr( $thumbnail_size ); ?>" min="1" style="max-width:50px;" />&nbsp;<small><?php _e( 'in px', 'magzimum' ); ?></small>
        </p>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length_side' ) ); ?>"><?php _e('Excerpt Length:', 'magzimum' ); ?></label>
          <input class="widefat1" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length_side' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length_side' ) ); ?>" type="number" value="<?php echo esc_attr( $excerpt_length_side ); ?>" min="1" style="max-width:50px;" />&nbsp;<small><?php _e( 'in words', 'magzimum' ); ?></small>
        </p>
        <p>
          <input id="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt_side' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_excerpt_side' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_excerpt_side']) ? $instance['disable_excerpt_side'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt_side' ) ); ?>"><?php _e( 'Disable Excerpt', 'magzimum' ); ?>
          </label>
        </p>
        <p><input id="<?php echo esc_attr( $this->get_field_id( 'disable_date_side' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_date_side' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_date_side']) ? $instance['disable_date_side'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_date_side' ) ); ?>"><?php _e( 'Disable Date', 'magzimum' ); ?>
          </label>
        </p>
        <p><input id="<?php echo esc_attr( $this->get_field_id( 'disable_comment_side' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_comment_side' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_comment_side']) ? $instance['disable_comment_side'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_comment_side' ) ); ?>"><?php _e( 'Disable Comment', 'magzimum' ); ?>
          </label>
        </p>
        <p><input id="<?php echo esc_attr( $this->get_field_id( 'disable_category_side' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_category_side' ) ); ?>" type="checkbox" <?php checked(isset($instance['disable_category_side']) ? $instance['disable_category_side'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'disable_category_side' ) ); ?>"><?php _e( 'Disable Category', 'magzimum' ); ?>
          </label>
        </p>

        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'custom_class' ) ); ?>"><?php _e( 'Custom Class:', 'magzimum' ); ?></label>
          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'custom_class') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_class' ) ); ?>" type="text" value="<?php echo esc_attr( $custom_class ); ?>" />
        </p>
        <?php
      }

    function dropdown_image_sizes( $args ){
      $defaults = array(
        'id'       => '',
        'name'     => '',
        'selected' => 0,
        'echo'     => 1,
      );

      $r = wp_parse_args( $args, $defaults );
      $output = '';

      $choices = magzimum_get_image_sizes_options( false );

      if ( ! empty( $choices ) ) {

        $output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
        foreach ( $choices as $key => $choice ) {
          $output .= '<option value="' . esc_attr( $key ) . '" ';
          $output .= selected( $r['selected'], $key, false );
          $output .= '>' . esc_html( $choice ) . '</option>\n';
        }
        $output .= "</select>\n";
      }

      if ( $r['echo'] ) {
        echo $output;
      }
      return $output;

    }

  }

endif;
