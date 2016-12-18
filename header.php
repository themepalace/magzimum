<?php
/**
 * The default template for displaying header
 *
 * @package Magzimum
 * @since Magzimum 1.0
 */

  /**
   * magzimum_action_doctype hook
   *
   * @hooked magzimum_doctype -  10
   *
   */
  do_action( 'magzimum_action_doctype' );?>

<head>
<?php
  /**
   * magzimum_action_head hook
   *
   * @hooked magzimum_head -  10
   *
   */
  do_action( 'magzimum_action_head' );
?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
  /**
   * magzimum_action_before hook
   *
   * @hooked magzimum_page_start - 10
   *
   */
  do_action( 'magzimum_action_before' );
?>

  <?php
    /**
     * magzimum_action_before_header hook
     *
     * @hooked magzimum_add_header_top_bar - 5
     * @hooked magzimum_header_start - 10
     *
     */
    do_action( 'magzimum_action_before_header' );
  ?>
    <?php
      /**
       * magzimum_action_header hook
       *
       * @hooked magzimum_site_branding - 10
       *
       */
      do_action( 'magzimum_action_header' );
    ?>
  <?php
    /**
     * magzimum_action_after_header hook
     *
     * @hooked magzimum_header_end - 10
     * @hooked magzimum_primary_navigation - 50
     *
     */
    do_action( 'magzimum_action_after_header' );
  ?>

  <?php
    /**
     * magzimum_action_before_content hook
     *
     * @hooked magzimum_add_featured_slider - 5
     * @hooked magzimum_add_breadcrumb - 7
     * @hooked magzimum_content_start - 10
     *
     */
    do_action( 'magzimum_action_before_content' );
  ?>
    <?php
      /**
       * magzimum_action_content hook
       *
       */
      do_action( 'magzimum_action_content' );
    ?>

