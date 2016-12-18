<?php
if ( ! function_exists( 'magzimum_add_theme_meta_box' ) ) :

  /**
   * Add the Meta Box
   *
   * @since  Magzimum 1.0
   */
  function magzimum_add_theme_meta_box() {

    $apply_metabox_post_types = array( 'post', 'page' );

    foreach ( $apply_metabox_post_types as $key => $type ) {
      add_meta_box(
        'theme-settings',
        __( 'Theme Settings', 'magzimum' ),
        'magzimum_render_theme_settings_metabox',
        $type
      );
    }

  }

endif;

add_action( 'add_meta_boxes', 'magzimum_add_theme_meta_box' );

if ( ! function_exists( 'magzimum_render_theme_settings_metabox' ) ) :

  /**
   * Render theme settings meta box
   *
   * @since  Magzimum 1.0
   */
  function magzimum_render_theme_settings_metabox() {

    global $post;
    $post_id = $post->ID;

    // Meta box nonce for verification
    wp_nonce_field( basename( __FILE__ ), 'magzimum_theme_settings_meta_box_nonce' );

    // Fetch Options list
    $global_layout_options = magzimum_get_global_layout_options();
    $image_size_options    = magzimum_get_image_sizes_options();
    $image_alignment_options    = magzimum_get_single_image_alignment_options();

    // Fetch values of current post meta
    $values = get_post_meta( $post_id, 'theme_settings', true );
    $theme_settings_post_layout = isset( $values['post_layout'] ) ? esc_attr( $values['post_layout'] ) : '';
    $theme_settings_single_image = isset( $values['single_image'] ) ? esc_attr( $values['single_image'] ) : '';
    ?>
    <!-- Layout option -->
    <p><strong><?php echo __( 'Choose Layout', 'magzimum' ); ?></strong></p>
    <select name="theme_settings[post_layout]" id="theme_settings_post_layout">
      <option value=""><?php echo __( 'Default', 'magzimum' ); ?></option>
      <?php if ( ! empty( $global_layout_options ) ): ?>
        <?php foreach ( $global_layout_options as $key => $val ): ?>

          <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $theme_settings_post_layout, $key ); ?> ><?php echo esc_html( $val ); ?></option>

        <?php endforeach ?>
      <?php endif ?>
    </select>
    <!-- Image in single post/page -->
    <p><strong><?php echo __( 'Choose Image Size in Single Post/Page', 'magzimum' ); ?></strong></p>
    <select name="theme_settings[single_image]" id="theme_settings_single_image">
      <option value=""><?php echo __( 'Default', 'magzimum' ); ?></option>
      <?php if ( ! empty( $image_size_options ) ): ?>
        <?php foreach ( $image_size_options as $key => $val ): ?>

          <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $theme_settings_single_image, $key ); ?> ><?php echo esc_html( $val ); ?></option>

        <?php endforeach ?>
      <?php endif ?>
    </select>
    <?php
  }

endif;



if ( ! function_exists( 'magzimum_save_theme_settings_meta' ) ) :

  /**
   * Save theme settings meta box value
   *
   * @since  Magzimum 1.0
   */
  function magzimum_save_theme_settings_meta( $post_id  ) {

    // Verify nonce
    if ( ! isset( $_POST['magzimum_theme_settings_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['magzimum_theme_settings_meta_box_nonce'], basename( __FILE__ ) ) )
          return;

    // Bail if auto save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

    // Check permission
    if ( 'page' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
    } else if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if( ! array_filter( $_POST['theme_settings'] ) ) {
      // no values
      delete_post_meta( $post_id, 'theme_settings' );
    }
    else{
      update_post_meta( $post_id, 'theme_settings', $_POST['theme_settings'] );
    }

  }

endif;

add_action( 'save_post', 'magzimum_save_theme_settings_meta' );
