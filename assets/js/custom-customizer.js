( function( $ ) {

  // Breadcrumb option manager
  function magzimum_breadcrumb_option_manager(){

    var breadcrumb_type = $('#customize-control-theme_options-breadcrumb_type select').val();

    switch(breadcrumb_type) {
      case 'disabled':
      case 'advanced':
          $('#customize-control-theme_options-breadcrumb_separator').hide();
          break;
      case 'simple':
          $('#customize-control-theme_options-breadcrumb_separator').show();
          break;
      default:
          break;
    }

  } // end function

  $(document).ready(function($){

    // Breadcrumb
    $('#customize-control-theme_options-breadcrumb_type select')
      .on('change', function(e){
        magzimum_breadcrumb_option_manager();
    });
    magzimum_breadcrumb_option_manager();


  });


} )( jQuery );

(function($) {
  //Message if WordPress version is less tham 4.0
    if ( parseInt(magzimum_misc_links.WP_version ) < 4) {
        $('.preview-notice').prepend('<span style="font-weight:bold;">' + magzimum_misc_links.old_version_message + '</span>');
        jQuery('#customize-info .btn-upgrade, .misc_links').click(function(event) {
            event.stopPropagation();
        });
    }

    //Add Upgrade Button
    $('.preview-notice').prepend('<span id="magzimum_upgrade"><a target="_blank" class="button btn-upgrade" href="' + magzimum_misc_links.upgrade_link + '">' + magzimum_misc_links.upgrade_text + '</a></span>');
    jQuery('#customize-info .btn-upgrade, .misc_links').click(function(event) {
        event.stopPropagation();
    });
})(jQuery);
