<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="screen-reader-text" for="s"><?php echo _x( 'Search for:', 'label', 'magzimum'  ); ?></label>
    <?php
      $placeholder_text = '';
      $search_placeholder = magzimum_get_option( 'search_placeholder' );
      if ( ! empty( $search_placeholder ) ) {
        $placeholder_text = ' placeholder="' . esc_attr( $search_placeholder ) . '" ';
      }
     ?>
    <input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" <?php echo $placeholder_text; ?> class="search-field"/>
    <input type="submit" id="searchsubmit" value="&#xf002;" class="search-submit"/>
</form>
