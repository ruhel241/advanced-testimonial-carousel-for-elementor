import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

(function ($) {
    const ATCTestimonialCarousel = function ($scope, $) {
        if ('undefined' == typeof $scope) {
            return;
        }

        const atcTestimonialCarousel = $('.atc-testimonial-container');
        const isPro = !!window.atcSwiperVar.has_pro;

        atcTestimonialCarousel.each(function () {
            const $slider = $(this);
            const sectionId = '#' + $slider.attr('id');
            const sliderPerView = parseInt( $slider.data('slider-per-view'), 10) || 1;

            const swiper = new Swiper(sectionId, {
                autoplay: isPro ? $slider.data('autoplay') : true,
                loop: isPro ? $slider.data('loop') : true,
                speed: isPro ? $slider.data('slider-speed') : 8000,
                autoHeight: isPro ? $slider.data('auto-height') : true,
                // Default / Desktop
                slidesPerView: isPro ? sliderPerView : 1,
                slidesPerGroup: isPro ? $slider.data('slider-per-group') : 1,
                breakpoints: {
                    // Mobile
                    0: {
                        slidesPerView: 1,
                    },
                    // Tablet
                    768: {
                        slidesPerView: isPro ? Math.min(sliderPerView, 2) : 1,
                    },
                    // Desktop
                    1024: {
                        slidesPerView: isPro ? sliderPerView : 1,
                    },
                },

                spaceBetween: isPro ? $slider.data('slider-space-between') : 30,
                pagination: {
                    el: $slider.data('pagination'),
                    clickable: true
                },
                navigation: {
                    nextEl: $slider.data('button-next'),
                    prevEl: $slider.data('button-prev')
                }
            });
            // Store Swiper instance
            $slider.data('swiper', swiper);
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/atc-testimonial-carousel.default',
            ATCTestimonialCarousel
        );
    });

    // Read More button
    $(document).on('click', '.atc-read-more-btn', function () {
        const $button  = $(this);
        const $content = $button.closest('.content');
        const $slider  = $button.closest('.atc-testimonial-container');
        $content.find('.atc-content-short').hide();
        $content.find('.atc-content-full').show();
        $button.hide();
        $content.find('.atc-less-btn').show();
        // Update Swiper height
        const swiper = $slider.data('swiper');
        if (swiper) {
            swiper.updateAutoHeight(2000);
        }
    });

    // Less button
    $(document).on('click', '.atc-less-btn', function () {
        const $button  = $(this);
        const $content = $button.closest('.content');
        const $slider  = $button.closest('.atc-testimonial-container');
        $content.find('.atc-content-short').show();
        $content.find('.atc-content-full').hide();
        $button.hide();
        $content.find('.atc-read-more-btn').show();
        // Update Swiper height
        const swiper = $slider.data('swiper');
        if (swiper) {
            swiper.updateAutoHeight(3000);
        }
    });
})(jQuery);