import routes from './Bits/routes';
import Application from './Application.vue';

const vueRouter = new window.AdvancedTestimonialCarousel.Router({
    routes: window.AdvancedTestimonialCarousel.applyFilters(
        'atcfe_global_routes',
        routes
    )
});

window.AdvancedTestimonialCarousel.Vue.prototype.$get = window.AdvancedTestimonialCarousel.$get;

window.AdvancedTestimonialCarousel.Vue.prototype.$post =  window.AdvancedTestimonialCarousel.$post;

window.AdvancedTestimonialCarousel.Vue.prototype.$put =  window.AdvancedTestimonialCarousel.$put;

window.AdvancedTestimonialCarousel.Vue.prototype.$del = window.AdvancedTestimonialCarousel.$del;

window.AdvancedTestimonialCarousel.Vue.prototype.$bus = new window.AdvancedTestimonialCarousel.Vue();

new window.AdvancedTestimonialCarousel.Vue({
    el: '#atcfe_admin_wrap',
    // router: vueRouter,
    render: h => h(Application),
    mounted() {
    }
});