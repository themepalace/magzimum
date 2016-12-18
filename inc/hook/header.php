<?php
if( ! function_exists( 'magzimum_site_branding' ) ) :

  /**
   * Site branding
   *
   * @since  Magzimum 1.0
   */
  function magzimum_site_branding(){

    ?>
    <div class="site-branding">
      <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <?php
          
            if ( function_exists( 'has_custom_logo' ) ) {
                  $site_logo = get_custom_logo(); 
                  }
               elseif ( !function_exists( 'has_custom_logo' ) ) {
                $site_logo = magzimum_get_option( 'site_logo' );
               }
             else{
                 $site_logo = '';
               }
          
          if ( ! empty( $site_logo) && !function_exists('has_custom_logo') ): ?>
          
          <img src="<?php echo esc_url( $site_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
         
        
         <?php elseif(!empty( $site_logo) && function_exists('has_custom_logo') ): ?>
          <?php echo $site_logo; ?>
          <?php else: ?>
          <?php bloginfo( 'name' ); ?>
        <?php endif ?>
      </a></h1>
      <?php
        $show_tagline = magzimum_get_option( 'show_tagline' );
       ?>
       <?php if ( 1 == $show_tagline ): ?>
        <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
       <?php endif ?>
    </div><!-- .site-branding -->

    <?php if ( is_active_sidebar( 'sidebar-header-right-widget-area' ) ): ?>
      <div class="sidebar-header-right">
        <?php dynamic_sidebar( 'sidebar-header-right-widget-area' ); ?>
      </div><!-- .sidebar-header-right -->
    <?php endif ?>
    <?php

  }

endif;
add_action( 'magzimum_action_header', 'magzimum_site_branding' );


if( ! function_exists( 'magzimum_primary_navigation' ) ) :

  /**
   * Primary navigation
   *
   * @since  Magzimum 1.0
   */
  function magzimum_primary_navigation(){

    ?>
    <div id="site-navigation" role="navigation">
      <div class="container">

        <?php
          wp_nav_menu( array(
            'theme_location'  => 'primary' ,
            'container'       => 'nav' ,
            'container_class' => 'main-navigation' ,
            )
          );
        ?>

      </div><!-- .container -->
    </div><!-- #site-navigation -->
    <?php

  }

endif;
add_action( 'magzimum_action_after_header', 'magzimum_primary_navigation', 50 );


if( ! function_exists( 'magzimum_mobile_navigation' ) ) :

  /**
   * Mobile menu
   *
   * @since  Magzimum 1.0
   */
  function magzimum_mobile_navigation(){

    ?>
    <a href="#mob-menu" id="mobile-trigger"><i class="fa fa-bars"></i></a>
    <div style="display:none;">
      <div id="mob-menu">
          <?php
            wp_nav_menu( array(
              'theme_location'  => 'primary',
              'container'       => '',
            ) );
          ?>
      </div><!-- #mob-menu -->
    </div>
    <?php if ( has_nav_menu( 'top' ) ): ?>
      <a href="#mob-menu-top" id="mobile-trigger-top"><i class="fa fa-bars"></i></a>
      <div style="display:none;">
        <div id="mob-menu-top">
            <?php
              wp_nav_menu( array(
                'theme_location'  => 'top',
                'container'       => '',
              ) );
            ?>
        </div><!-- #mob-menu-top -->
      </div>
    <?php endif ?>

    <?php

  }

endif;
add_action( 'magzimum_action_before', 'magzimum_mobile_navigation', 20 );


if( ! function_exists( 'magzimum_add_header_top_bar' ) ) :

  /**
   * Header Top Bar
   *
   * @since  Magzimum 1.0
   */
  function magzimum_add_header_top_bar(){

    // Top menu
    $top_menu_content = wp_nav_menu( array(
      'theme_location'  => 'top' ,
      'container'       => 'div' ,
      'container_id'    => 'top-navigation' ,
      'container_class' => 'top-navigation' ,
      'fallback_cb'     => false ,
      'echo'            => false ,
    ) );

    $social_in_header = magzimum_get_option( 'social_in_header' );
    ?>
    <div id="site-top-bar">
      <div class="container">

        <?php
          echo $top_menu_content;
         ?>
         <div class="header-top-icons-wrap">
           <?php if ( 1 == $social_in_header ): ?>
             <?php the_widget( 'Magzimum_Social_Widget' ); ?>
           <?php endif ?>
          
            <a href="#" class="fa fa-search" id="btn-search-icon"><span class="screen-reader-text"><?php _e( 'Search', 'magzimum' )?></span></a>

           <div id="header-search-form">
             <?php get_search_form(); ?>
           </div><!-- #header-search-form -->

        </div><!-- .header-top-icons-wrap -->

      </div><!-- .container -->
    </div><!-- #site-top-bar -->
    <?php

  }

endif;
add_action( 'magzimum_action_before_header', 'magzimum_add_header_top_bar', 5 );

