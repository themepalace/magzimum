( function( $ ) {

  $(document).ready(function($){

    // Implement go to top
    if ( $('#btn-scrollup').length > 0 ) {

      $(window).scroll(function(){
          if ($(this).scrollTop() > 100) {
              $('#btn-scrollup').fadeIn();
          } else {
              $('#btn-scrollup').fadeOut();
          }
      });

      $('#btn-scrollup').click(function(){
          $("html, body").animate({ scrollTop: 0 }, 600);
          return false;
      });

    }

  });

} )( jQuery );
