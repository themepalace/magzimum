<?php
/**
 * Sidebar Primary widget area.
 *
 * @package Magzimum
 */
?>

<?php
/**
 * magzimum_action_before_sidebar_primary hook
 */
do_action( 'magzimum_action_before_sidebar_primary' );?>

<div id="sidebar-primary" role="complementary" <?php magzimum_sidebar_primary_class( 'widget-area sidebar' ); ?> >
  <?php if ( is_active_sidebar( 'sidebar-1' ) ): ?>

    <?php dynamic_sidebar( 'sidebar-1' ); ?>

  <?php else: ?>
    <?php
      $widget = 'WP_Widget_Text';
      $instance = array(
        'title' => __( 'Primary Sidebar', 'magzimum' ),
        'text'  => __( "Widgets of Primary Sidebar will be displayed here. To add widgets go to 'Appearance' -> 'Widgets'.", 'magzimum' ),
      );
      $args = array(
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
      );
      the_widget( $widget, $instance, $args );
    ?>
  <?php endif ?>
</div><!-- #sidebar-primary -->
<?php
/**
 * magzimum_action_after_sidebar_primary hook
 */
do_action( 'magzimum_action_after_sidebar_primary' );?>

