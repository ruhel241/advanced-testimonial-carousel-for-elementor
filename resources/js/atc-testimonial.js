import Swiper from 'swiper/bundle';
// import styles bundle
import 'swiper/css/bundle';

(function($) {

    const ATCTestimonialCarousel = function( $scope, $ ) {
      if( 'undefined' == typeof $scope ) {
          return;
      }
      
      const atcTestimonialCarousel  = $('.atc-testimonial-container');
      const isPro = !!window.atcSwiperVar.has_pro;

      atcTestimonialCarousel.each(function() {
        const sectionId = '#' + $(this).attr('id');
       
        new Swiper(sectionId, {
          autoplay: isPro ? $(sectionId).data('autoplay') : true,
          loop: isPro ? $(sectionId).data('loop') : true,
          speed: isPro ? $(sectionId).data('slider-speed') : 6000,
          autoHeight: isPro ? $(sectionId).data('auto-height') : true,
          slidesPerView: isPro ? $(sectionId).data('slider-per-view') : 1, /// koita view korbe oita dekhabe 
          slidesPerGroup: isPro ? $(sectionId).data('slider-per-group') : 1, //koita kore slide hobe group kore dekhabe
          spaceBetween: isPro ? $(sectionId).data('slider-space-between') : 30,
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
  