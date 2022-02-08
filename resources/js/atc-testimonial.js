import Swiper from 'swiper/bundle';
// import styles bundle
import 'swiper/css/bundle';

(function($) {

    const ATCTestimonialCarousel = function( $scope, $ ) {
      if( 'undefined' == typeof $scope ) {
          return;
      }
      
      const atcTestimonialCarousel  = $('.atc-testimonial-container');
     
      atcTestimonialCarousel.each(function() {
        const sectionId = '#' + $(this).attr('id');
       
        new Swiper(sectionId, {
          autoplay: $(sectionId).data('autoplay'),
          speed: $(sectionId).data('slider-speed'),
          autoHeight: true,
          spaceBetween: 30,
          loop: $(sectionId).data('loop'),
          pagination: {
            el: $(sectionId).data('pagination'),
            clickable: true
          },
          navigation: {
            nextEl: $(sectionId).data('button-next'),
            prevEl: $(sectionId).data('button-prev')
          }
        });
      });
    }
   
    $( window ).on( 'elementor/frontend/init', function () {
      elementorFrontend.hooks.addAction( 'frontend/element_ready/atc-testimonial-carousel.default', ATCTestimonialCarousel );
    });
  
  })( jQuery );
  