<?php

if ( ! function_exists( 'magzimum_doctype' ) ) :
  /**
   * Doctype Declaration
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_doctype() {
    ?><!DOCTYPE html> <html <?php language_attributes(); ?>><?php
  }
endif;
add_action( 'magzimum_action_doctype', 'magzimum_doctype', 10 );


if ( ! function_exists( 'magzimum_head' ) ) :
  /**
   * Header Codes
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_head() {
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php
  }
endif;
add_action( 'magzimum_action_head', 'magzimum_head', 10 );

if ( ! function_exists( 'magzimum_page_start' ) ) :
  /**
   * Page Start
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_page_start() {
    // Get site layout
    $site_layout = magzimum_get_option( 'site_layout' );
    ?>
    <?php if ( 'boxed' == $site_layout ): ?>
    <div id="page" class="hfeed site container">
    <?php else: ?>
    <div id="page" class="hfeed site container-fluid">
    <?php endif ?>
    <?php
  }
endif;
add_action( 'magzimum_action_before', 'magzimum_page_start' );


if ( ! function_exists( 'magzimum_skip_to_content' ) ) :
  /**
   * Skip to content
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_skip_to_content() {
    ?><a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'magzimum' ); ?></a><?php
  }
endif;
add_action( 'magzimum_action_before', 'magzimum_skip_to_content', 15 );


if ( ! function_exists( 'magzimum_page_end' ) ) :
  /**
   * Page Start
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_page_end() {
    ?></div><!-- #page --><?php
  }
endif;
add_action( 'magzimum_action_after', 'magzimum_page_end' );


if ( ! function_exists( 'magzimum_header_start' ) ) :
  /**
   * Header Start
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_header_start() {
    ?><header id="masthead" class="site-header" role="banner"><div class="container"><?php
  }
endif;
add_action( 'magzimum_action_before_header', 'magzimum_header_start' );

if ( ! function_exists( 'magzimum_header_end' ) ) :
  /**
   * Header End
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_header_end() {
    ?></div><!-- .container --></header><!-- #masthead --><?php
  }
endif;
add_action( 'magzimum_action_after_header', 'magzimum_header_end' );


if ( ! function_exists( 'magzimum_footer_start' ) ) :
  /**
   * Footer Start
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_footer_start() {
    ?><footer id="colophon" class="site-footer" role="contentinfo" ><div class="container"><?php
  }
endif;
add_action( 'magzimum_action_before_footer', 'magzimum_footer_start' );


if ( ! function_exists( 'magzimum_footer_end' ) ) :
  /**
   * Footer End
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_footer_end() {
    ?></div><!-- .container --></footer><!-- #colophon --><?php
  }
endif;
add_action( 'magzimum_action_after_footer', 'magzimum_footer_end' );


if ( ! function_exists( 'magzimum_content_start' ) ) :
  /**
   * Content Start
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_content_start() {
    ?><div id="content" class="site-content"><div class="container"><div class="row"><?php
  }
endif;
add_action( 'magzimum_action_before_content', 'magzimum_content_start' );


if ( ! function_exists( 'magzimum_content_end' ) ) :
  /**
   * Content End
   *
   * @since Magzimum 1.0
   *
   */
  function magzimum_content_end() {
    ?></div><!-- .row --></div><!-- .container --></div><!-- #content --><?php
  }
endif;
add_action( 'magzimum_action_after_content', 'magzimum_content_end' );

