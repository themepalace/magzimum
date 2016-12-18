<?php
/**
 * Include base
 */
require trailingslashit( get_template_directory() ) . 'inc/base.php';

/**
 * Include Helper functions
 */
require trailingslashit( get_template_directory() ) . 'inc/helper/common.php';

/**
 * Include Metabox
 */
require trailingslashit( get_template_directory() ) . 'inc/metabox.php';

/**
 * Include Widgets
 */
require trailingslashit( get_template_directory() ) . 'inc/widgets.php';

/**
 * Include Customizer options
 */
require trailingslashit( get_template_directory() ) . 'inc/customizer/core.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/settings.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/slider.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/featured-content.php';
require trailingslashit( get_template_directory() ) . 'inc/customizer/breaking.php';
// Load customizer theme pro link
require trailingslashit( get_template_directory() ) .'inc/customizer/upgrade-to-pro/class-customize.php';

/**
 * Include Hooks
 */
require trailingslashit( get_template_directory() ) . 'inc/hook/structure.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/header.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/blog.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/footer.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/slider.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/featured-content.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/breaking.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/sidebar.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/layout.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/pagination.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/custom.php';
require trailingslashit( get_template_directory() ) . 'inc/hook/breadcrumb.php';
require trailingslashit( get_template_directory() ) . 'inc/tgm-plugin/tgm-hook.php';

function magzimum_options_setup() {

  global $magzimum_default_theme_options;
  global $magzimum_customizer_object;

  $custom_settings = array();
  $custom_settings = apply_filters( 'magzimum_theme_options_args', $custom_settings );


  $magzimum_customizer_object = new Magzimum_Customizer( $custom_settings, $magzimum_default_theme_options );

}
add_action( 'after_setup_theme', 'magzimum_options_setup', 20 );

add_action( 'init', 'magzimum_add_editor_styles' );

if ( ! function_exists( 'magzimum_add_editor_styles' ) ) :
    function magzimum_add_editor_styles() {
        add_editor_style( 'editor-style.css' );
    }
endif;