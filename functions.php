<?php

/**
 * Include Customizer
 */
require trailingslashit( get_template_directory() ) . 'magzimum-customizer/init.php';

/**
 * Init customizer
 */
require trailingslashit( get_template_directory() ) . 'inc/init.php';


/**
 * Magzimum functions and definitions
 *
 * @package Magzimum
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
}

if ( ! function_exists( 'magzimum_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function magzimum_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Magzimum, use a find and replace
	 * to change 'magzimum' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'magzimum', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );


 /**
      * Setup Custom Logo Support for theme
      * Supported from WordPress version 4.5 onwards
      * More Info: https://make.wordpress.org/core/2016/03/10/custom-logo/
      */
  if ( function_exists( 'has_custom_logo' ) ) {
     
      add_theme_support( 'custom-logo' );
    }
  


	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

  // Register image size for featured slider
  add_image_size( 'magzimum-slider', 750, 315, true );
  add_image_size( 'magzimum-thumb', 360, 150, true ); // Ratio 12:5

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
    'primary'  => __( 'Primary Menu', 'magzimum' ),
    'top'      => __( 'Top Menu', 'magzimum' ),
    'social'   => __( 'Social Menu', 'magzimum' ),
    'notfound' => __( '404 Menu', 'magzimum' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'magzimum_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
    'wp-head-callback'    => 'magzimum_custom_background'
	) ) );


  /**
   * Enable support for footer widgets
   */
  add_theme_support( 'footer-widgets', 4 );

  // Include supports
  require get_template_directory() . '/inc/supports.php';

  global $magzimum_default_theme_options;
  $magzimum_default_theme_options = magzimum_get_default_theme_options();

}
endif; // magzimum_setup
add_action( 'after_setup_theme', 'magzimum_setup' );


function magzimum_logo_migrate() {
  $ver = get_theme_mod( 'logo_version', false );

  // Return if update has already been run
  if ( version_compare( $ver, '2' ) >= 0 ) {
    return;
  }
  /**
   * Get Theme Options Values
   */
  $options = magzimum_get_option( 'site_logo' );
  // If a logo has been set previously, update to use logo feature introduced in WordPress 4.5
  if ( function_exists( 'the_custom_logo' ) ) {
    if( isset( $options) && '' != $options) {
      // Since previous logo was stored a URL, convert it to an attachment ID
      $logo = attachment_url_to_postid( $options);

      if ( is_int( $logo ) ) {
        set_theme_mod( 'custom_logo', $logo );
      }
    }

      // Update to match logo_version so that script is not executed continously
    set_theme_mod( 'logo_version', '2' );
  }

}
add_action( 'after_setup_theme', 'magzimum_logo_migrate' );
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function magzimum_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Primary Sidebar', 'magzimum' ),
    'id'            => 'sidebar-1',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
  register_sidebar( array(
    'name'          => __( 'Secondary Sidebar', 'magzimum' ),
    'id'            => 'sidebar-2',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
  register_sidebar( array(
    'name'          => __( 'Header Right Widget Area', 'magzimum' ),
    'id'            => 'sidebar-header-right-widget-area',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
  register_sidebar( array(
    'name'          => __( 'Slider Right Widget Area', 'magzimum' ),
    'id'            => 'sidebar-slider-right-widget-area',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
	register_sidebar( array(
		'name'          => __( 'Front Page Widget Area', 'magzimum' ),
		'id'            => 'sidebar-front-page-widget-area',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'magzimum_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function magzimum_scripts() {
  wp_enqueue_style( 'magzimum-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', '', '3.3.4' );

  wp_enqueue_style( 'magzimum-fontawesome', get_template_directory_uri() . '/third-party/font-awesome/css/font-awesome.min.css', '', '4.3' );

  wp_enqueue_style( 'magzinum-google-fonts-arvo', '//fonts.googleapis.com/css?family=Arvo:400,700');
  wp_enqueue_style( 'magzinum-google-fonts-balthazar', '//fonts.googleapis.com/css?family=Balthazar:400,700');

	wp_enqueue_style( 'magzimum-style', get_stylesheet_uri() );

  wp_enqueue_style( 'magzimum-mmenu-style', get_template_directory_uri() .'/third-party/mmenu/css/jquery.mmenu.css', '', '4.7.5' );

  wp_enqueue_style( 'magzimum-owl-carousel-style', get_template_directory_uri() .'/third-party/owl-carousel/css/owl.carousel.css', '', '2.0' );

  wp_enqueue_style( 'magzimum-responsive-style', get_template_directory_uri() .'/assets/css/responsive.css', '', '1.0.0' );

  wp_enqueue_script( 'magzimum-placeholder', get_template_directory_uri() . '/assets/js/jquery.placeholder.js', array( 'jquery' ), '2.0.9', true );

  wp_enqueue_script( 'magzimum-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20120206', true );

  $go_to_top = magzimum_get_option( 'go_to_top' );
  if ( 1 == $go_to_top ) {
  	wp_enqueue_script( 'magzimum-goto-top', get_template_directory_uri() . '/assets/js/goto-top.js', array( 'jquery' ), '1.0.0', true );
  }

  wp_enqueue_script( 'magzimum-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );

  wp_enqueue_script( 'magzimum-cycle2-script', get_template_directory_uri() . '/third-party/cycle2/js/jquery.cycle2.min.js', array( 'jquery' ), '2.1.6', true );

  wp_enqueue_script( 'magzimum-easytabs-script', get_template_directory_uri() . '/third-party/easytabs/js/jquery.easytabs.min.js', array( 'jquery' ), '3.2.0', true );

  wp_enqueue_script( 'magzimum-ticker-script', get_template_directory_uri() . '/third-party/ticker/jquery.easy-ticker.min.js', array( 'jquery' ), '2.0', true );

  wp_enqueue_script( 'magzimum-owl-carousel-script', get_template_directory_uri() . '/third-party/owl-carousel/js/owl.carousel.min.js', array( 'jquery' ), '2.0', true );

  wp_enqueue_script( 'magzimum-mmenu-script', get_template_directory_uri() . '/third-party/mmenu/js/jquery.mmenu.min.js', array( 'jquery' ), '4.7.5', true );

	wp_enqueue_script( 'magzimum-custom-js', get_template_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'magzimum_scripts' );


/**
 * Enqueue admin scripts and styles.
 */
function magzimum_admin_scripts( $hook ) {

  if ( 'widgets.php' == $hook ) {
    wp_enqueue_media();
    wp_enqueue_style( 'magzimum-widgets-style', get_template_directory_uri() .'/assets/css/widgets.css', '', '1.0.0' );
    wp_enqueue_script( 'magzimum-widgets-script', get_template_directory_uri() . '/assets/js/widgets.js', array( 'jquery' ), '1.0.0' );
  }

}
add_action( 'admin_enqueue_scripts', 'magzimum_admin_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * custom css  additions.
 */
require get_template_directory() . '/inc/hook/core.php';
