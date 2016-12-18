( function( $ ) {

  $(document).ready(function($){

    // Featured content carousel
    var $featured_carousel = $("#main-featured-content");
    var $flag_nav = ( 1 == $featured_carousel.data('show_arrow') ) ? true : false ;
    var $flag_autoplay = ( 1 == $featured_carousel.data('enable_autoplay') ) ? true : false ;
    var $transition_delay = ( $featured_carousel.data('transition_delay') ) ? $featured_carousel.data('transition_delay') : 2000 ;
    $featured_carousel.owlCarousel({
      nav: $flag_nav,
      loop: true,
      autoplay: $flag_autoplay,
      autoplayTimeout: $transition_delay,
      margin:30,
      navText:['',''],
      navRewind: true,
      responsiveClass: true,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:2
          },
          1023:{
              items:3
          }
      }
    });

    // Trigger mmenu
    $('#mob-menu').mmenu();
    $('#mob-menu-top').mmenu({
      offCanvas: {
                  dragOpen: true,
                  position  : "right",
                  direction:'left',
                  zposition : "next"
                }
    });

    // Search in Header
    if( $('#btn-search-icon').length > 0 ) {
      $('#btn-search-icon').click(function(e){
          e.preventDefault();
          $("#header-search-form").slideToggle();
      });

    }
    // Implement go to top
    if ( $('#btn-scrollup').length > 0 ) {

      $(window).scroll(function(){
          if ($(this).scrollTop() > 100) {
              $('#btn-scrollup').fadeIn('slow');
          } else {
              $('#btn-scrollup').fadeOut('slow');
          }
      });

      $('#btn-scrollup').click(function(){
          $("html, body").animate({ scrollTop: 0 }, 600);
          return false;
      });

    }

    // Breaking ticker
    var $breaking_ticker = $('#breaking-ticker');
    var breaking_delay_interval = $breaking_ticker.data('delay');

    $breaking_ticker.easyTicker({
      direction: 'up',
      easing: 'swing',
      speed: 'slow',
      interval: breaking_delay_interval,
      height: 'auto',
      visible: 1,
      mousePause: 1,
    });



  });

} )( jQuery );
