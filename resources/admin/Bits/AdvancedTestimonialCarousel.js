import Vue from './elements';
import Router from 'vue-router';

import {
    applyFilters,
    addFilter,
    addAction,
    doAction,
    removeAllActions
} from '@wordpress/hooks';

Vue.use(Router);

export default class AdvancedTestimonialCarousel {
    constructor() {
        // this.Router = new Router({
        //     mode: 'history',
        //     routes: [] // Define your routes here
        // });
        this.Router = Router;
        this.doAction = doAction;
        this.addFilter = addFilter;
        this.addAction = addAction;
        this.applyFilters = applyFilters;
        this.removeAllActions = removeAllActions;
        this.appVars = window.atcAdminVars;
        this.Vue = this.extendVueConstructor();
    }

    extendVueConstructor() {
        const self = this;

        Vue.mixin({
            data() {
                return {
                    appVars: self.appVars
                }
            },
            methods: {
                addFilter,
                applyFilters,
                doAction,
                addAction,
                removeAllActions,
                // dateFormats: self.dateFormat,
                ucFirst: self.ucFirst,
                ucWords: self.ucWords,
                slugify: self.slugify,
                $handleSuccess: self.handleSuccess,
                $handleError: self.handleError,

                // nsHumanDiffTime: self.humanDiffTime,
                getPrefixLinkUrl(link) {
                    var prefixLink = this.appVars.site_url;
                    if (link.subdomain_name) {
                        return prefixLink.replace('://', '://' + link.subdomain_name + '.')
                    }
                    return prefixLink;
                },
                getCopySlugUrl(link) {
                    return this.getPrefixLinkUrl(link) + '/' + link.slug;
                },
                getDisplayShortCode(display, slug) {
                    if (display === 'box') {
                        return `[atcfe box-slug="${slug}"]`;
                    }
                    if (display === 'choice') {
                        return `[atcfe choice-slug="${slug}"]`;
                    }
                },
                getCopyUrlLink(link) {
                    return link;
                },

                getCopyText(val) {
                    return val;
                },

                $t(string) {
                    return window.atcAdminVars.i18n[string] || string;
                },
            }
        });

        // Vue.filter('dateFormats', self.dateFormat);
        Vue.filter('ucFirst', self.ucFirst);
        Vue.filter('ucWords', self.ucWords);
        // Vue.filter('nsHumanDiffTime', self.humanDiffTime);

        Vue.use(this.Router);

        return Vue;
    }

    registerBlock(blockLocation, blockName, block) {
        this.addFilter(blockLocation, this.appVars.slug, function (components) {
            components[blockName] = block;
            return components;
        });
    }

    registerTopMenu(title, route) {
        if (!title || !route.name || !route.path || !route.component) {
            return;
        }

        this.addFilter('atcfe_top_menus', this.appVars.slug, function (menus) {
            menus = menus.filter(m => m.route !== route.name);
            menus.push({
                route: route.name,
                title: title
            });
            return menus;
        });

        this.addFilter('atcfe_global_routes', this.appVars.slug, function (routes) {
            routes = routes.filter(r => r.name !== route.name);
            routes.push(route);
            return routes;
        });
    }

    request(method, route, data = {}) {
        const url = `${window.atcAdminVars.rest.url}/${route}`;

        const headers = { 'X-WP-Nonce': window.atcAdminVars.rest.nonce };

        if (['PUT', 'PATCH', 'DELETE'].indexOf(method.toUpperCase()) !== -1) {
            headers['X-HTTP-Method-Override'] = method;
            method = 'POST';
        }

        data.query_timestamp = Date.now();

        return new Promise((resolve, reject) => {
            window.jQuery.ajax({
                url: url,
                type: method,
                data: data,
                headers: headers
            })
                .then(response => resolve(response))
                .fail(errors => reject(errors.responseJSON));
        });
    }

  
    $get(options) {
        return window.jQuery.get(window.atcAdminVars.ajaxurl, options);
    }

    $post(options) {
        return window.jQuery.post(window.atcAdminVars.ajaxurl, options);
    }

    $put(options) {
        return window.jQuery.ajax({
            url: window.atcAdminVars.ajaxurl,
            type: 'PUT',
            data: options,
        });
    }

    $del(options) {
        return window.jQuery.post(window.atcAdminVars.ajaxurl, options);
    }

    ucFirst(text) {
        return text[0].toUpperCase() + text.slice(1).toLowerCase();
    }

    ucWords(text) {
        return (text + '').replace(/^(.)|\s+(.)/g, function ($1) {
            return $1.toUpperCase();
        });
    }

    slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(/[^\w\-]+/g, '') // Remove all non-word chars
            .replace(/\-\-+/g, '-') // Replace multiple - with single -
            .replace(/^-+/, '') // Trim - from start of text
            .replace(/-+$/, ''); // Trim - from end of text
    }

    convertToText(obj) {
        const string = [];
        if (typeof (obj) === 'object' && (obj.join === undefined)) {
            for (const prop in obj) {
                string.push(this.convertToText(obj[prop]));
            }
        } else if (typeof (obj) === 'object' && !(obj.join === undefined)) {
            for (const prop in obj) {
                string.push(this.convertToText(obj[prop]));
            }
        } else if (typeof (obj) === 'function') {

        } else if (typeof (obj) === 'string') {
            string.push(obj);
        }

        return string.join('<br />');
    }

    handleSuccess(message) {
        this.$notify({
            type: 'success',
            title: 'Success',
            message: message,
            offset: 32,
            dangerouslyUseHTMLString: true
        });
    }

    handleError(response) {
        if (response?.responseJSON?.data) {
            response = response.responseJSON.data;
        }
    
        let errorMessage = '';
    
        if (typeof response === 'string') {
            errorMessage = response;
        } else if (response?.message) {
            errorMessage = response.message;
        }
        
        if (!errorMessage) {
            errorMessage = 'Something went wrong!';
        }
    
        this.$notify({
            type: 'error',
            title: 'Error',
            message: errorMessage,
            offset: 32,
            dangerouslyUseHTMLString: true,
            position: 'top-right'
        });
    }  
}
