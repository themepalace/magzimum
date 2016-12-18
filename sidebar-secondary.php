<?php
/**
 * Sidebar Secondary widget area.
 *
 * @package Magzimum
 */
?>

<?php
/**
 * magzimum_action_before_sidebar_secondary hook
 */
do_action( 'magzimum_action_before_sidebar_secondary' );?>

<div id="sidebar-secondary" role="complementary" <?php magzimum_sidebar_secondary_class( 'widget-area sidebar' ); ?> >
  <?php if ( is_active_sidebar( 'sidebar-2' ) ): ?>

    <?php dynamic_sidebar( 'sidebar-2' ); ?>

  <?php else: ?>
    <?php
      $widget = 'WP_Widget_Text';
      $instance = array(
        'title' => __( 'Secondary Sidebar', 'magzimum' ),
        'text'  => __( "Widgets of Secondary Sidebar will be displayed here. To add widgets go to 'Appearance' -> 'Widgets'.", 'magzimum' ),
      );
      $args = array(
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
      );
      the_widget( $widget, $instance, $args );
    ?>
  <?php endif ?>
</div><!-- #sidebar-secondary -->
<?php
/**
 * magzimum_action_after_sidebar_secondary hook
 */
do_action( 'magzimum_action_after_sidebar_secondary' );?>

