<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Magzimum
 */
?>


  <?php
    /**
     * magzimum_action_after_content hook
     *
     * @hooked magzimum_content_end - 10
     *
     */
    do_action( 'magzimum_action_after_content' );
  ?>


  <?php
    /**
     * magzimum_action_before_footer hook
     *
     * @hooked magzimum_footer_start - 10
     *
     */
    do_action( 'magzimum_action_before_footer' );
  ?>
    <?php
      /**
       * magzimum_action_footer hook
       *
       * @hooked magzimum_site_info - 10
       *
       */
      do_action( 'magzimum_action_footer' );
    ?>
  <?php
    /**
     * magzimum_action_after_footer hook
     *
     * @hooked magzimum_footer_end - 10
     *
     */
    do_action( 'magzimum_action_after_footer' );
  ?>


<?php
  /**
   * magzimum_action_after hook
   *
   * @hooked magzimum_page_end - 10
   * @hooked magzimum_footer_goto_top - 20
   *
   */
  do_action( 'magzimum_action_after' );
?>


<?php wp_footer(); ?>
</body>
</html>
