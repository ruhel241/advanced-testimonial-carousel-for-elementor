<?php

namespace ATC\Http\Controllers;

class SetupController
{
    public function register() {
        add_action('wp_ajax_atc_settings_admin_ajax', array($this, 'ajaxRoutes'));
    }

    public function ajaxRoutes()
    {
         // 🔐 Nonce check (CSRF protection).
         if ( ! check_ajax_referer( 'atc_nonce', 'nonce', false ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Invalid nonce',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                403
            );
        }
    
        // Permission check.
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Unauthorized access',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                403
            );
        }
    
        $request = wp_unslash( $_REQUEST );
    
        $route = sanitize_key( $request['route'] ?? '' );
    
        $maps = array(
            'install_atc'    => 'handleAdvancedTestimonialInstall',
            'install_aic'    => 'handleImageComparisonInstall',
            'install_ase'    => 'handleAdvancedSliderInstall',
            'install_aptfe'  => 'handleAdvancedPricingInstall',
            'get_addons'     => 'getAddons'
        );
    
        if ( ! isset( $maps[ $route ] ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Invalid route',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                400
            );
        }
    
        do_action( 'aptfe_doing_ajax_setup_' . $route );
    
        // Request data sanitization handled in methods.
        $this->{$maps[ $route ]}( $request );
    
        do_action(
            'aptfe_admin_ajax_handler_setup_catch',
            $route
        );
    }

    /**
     * Advanced Testimonial Carousel For Elementor 
    */

    private function handleAdvancedTestimonialInstall()
    {
        $slug = 'advanced-testimonial-carousel-for-elementor';

        $plugin = [
            'name'      => __('Advanced Testimonial Carousel for Elementor', 'advanced-testimonial-carousel-for-elementor'),
            'repo-slug' => $slug,
            'file'      => 'advanced-testimonial-carousel-for-elementor.php',
        ];

        $result = $this->backgroundInstaller($plugin, $slug);

        if ($result) {
            wp_send_json_success([
                'is_installed' => defined('ATC_PLUGIN_VERSION'),
                'message'      => __('Advanced Testimonial Carousel for Elementor plugin has been installed and activated successfully.', 'advanced-testimonial-carousel-for-elementor')
            ]);
        }

        wp_send_json_error([
            'is_installed' => false,
            'message'      => __('Plugin installation or activation failed.', 'advanced-testimonial-carousel-for-elementor')
        ]);
    }

    /**
     * Advanced Image Comparison
    */

    private function handleImageComparisonInstall()
    {
        $slug = 'advanced-image-comparison-for-elementor';
        $plugin = [
            'name'      => __('Advanced Image Comparison for Elementor', 'advanced-testimonial-carousel-for-elementor'),
            'repo-slug' => 'advanced-image-comparison-for-elementor',
            'file'      => 'advanced-image-comparison-for-elementor.php',
        ];

        $result = $this->backgroundInstaller($plugin, $slug);

        if ($result) {
            wp_send_json_success([
                'is_installed' => defined('AIC_PLUGIN_VERSION'),
                'message'      => __('Advanced Image Comparison for Elementor plugin has been installed and activated successfully.', 'advanced-testimonial-carousel-for-elementor')
            ]);
        }

        wp_send_json_error([
            'is_installed' => false,
            'message'      => __('Plugin installation or activation failed.', 'advanced-testimonial-carousel-for-elementor')
        ]);
    }

    /**
     * Advanced Slider For Elementor 
    */

    private function handleAdvancedSliderInstall()
    {
        $slug = 'advanced-slider-for-elementor';
        $plugin = [
            'name'      => __('Advanced Slider for Elementor', 'advanced-testimonial-carousel-for-elementor'),
			'repo-slug' => 'advanced-slider-for-elementor',
			'file'      => 'advanced-slider-for-elementor.php',
        ];

        $result = $this->backgroundInstaller($plugin, $slug);

        if ($result) {
            wp_send_json_success([
                'is_installed' => defined('ASE_PLUGIN_VERSION'),
                'message'      => __('Advanced Slider for Elementor plugin has been installed and activated successfully', 'advanced-testimonial-carousel-for-elementor')
            ]);
        }

        wp_send_json_error([
            'is_installed' => false,
            'message'      => __('Plugin installation or activation failed.', 'advanced-testimonial-carousel-for-elementor')
        ]);
    }

    /**
     * Advanced Pricing Table For Elementor 
    */

    private function handleAdvancedPricingInstall()
    {
        $slug = 'advanced-pricing-table-for-elementor';
        $plugin = [
            'name'      => __('Advanced Pricing Table for Elementor', 'advanced-testimonial-carousel-for-elementor'),
			'repo-slug' => 'advanced-pricing-table-for-elementor',
			'file'      => 'advanced-pricing-table-for-elementor.php',
        ];

        $result = $this->backgroundInstaller($plugin, $slug);

        if ($result) {
            wp_send_json_success([
                'is_installed' => defined('APTFE_PLUGIN_VERSION'),
                'message'      => __('Advanced Pricing Table for Elementor plugin has been installed and activated successfully', 'advanced-testimonial-carousel-for-elementor')
            ]);
        }

        wp_send_json_error([
            'is_installed' => false,
            'message'      => __('Plugin installation or activation failed.', 'advanced-testimonial-carousel-for-elementor')
        ]);
    }


    private function backgroundInstaller($plugin_to_install, $slug)
    {
        if (empty($plugin_to_install['repo-slug'])) {
            return false;
        }
    
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    
        WP_Filesystem();
    
        $skin     = new \Automatic_Upgrader_Skin();
        $upgrader = new \WP_Upgrader($skin);
    
        $installed_plugins = array_reduce(
            array_keys(get_plugins()),
            array($this, 'associate_plugin_file'),
            array()
        );
    
        $plugin_slug = $plugin_to_install['repo-slug'];
    
        $plugin_file = isset($plugin_to_install['file'])
            ? $plugin_to_install['file']
            : $plugin_slug . '.php';
    
        $installed = false;
        $activate  = false;
    
        // Check if plugin already installed.
        if (isset($installed_plugins[$plugin_file])) {
            $installed = true;
            $activate  = !is_plugin_active($installed_plugins[$plugin_file]);
        }
    
        // Install plugin if not installed.
        if (!$installed) {
    
            ob_start();
    
            try {
    
                $plugin_information = plugins_api(
                    'plugin_information',
                    array(
                        'slug'   => $plugin_slug,
                        'fields' => array(
                            'short_description' => false,
                            'sections'          => false,
                            'requires'          => false,
                            'rating'            => false,
                            'ratings'           => false,
                            'downloaded'        => false,
                            'last_updated'      => false,
                            'added'             => false,
                            'tags'              => false,
                            'homepage'          => false,
                            'donate_link'       => false,
                            'author_profile'    => false,
                            'author'            => false,
                        ),
                    )
                );
    
                if (is_wp_error($plugin_information)) {
                    throw new \Exception($plugin_information->get_error_message());
                }
    
                $package = $plugin_information->download_link;
    
                $download = $upgrader->download_package($package);
    
                if (is_wp_error($download)) {
                    throw new \Exception($download->get_error_message());
                }
    
                $working_dir = $upgrader->unpack_package($download, true);
    
                if (is_wp_error($working_dir)) {
                    throw new \Exception($working_dir->get_error_message());
                }
    
                $result = $upgrader->install_package(
                    array(
                        'source'                      => $working_dir,
                        'destination'                 => WP_PLUGIN_DIR,
                        'clear_destination'           => false,
                        'abort_if_destination_exists' => false,
                        'clear_working'               => true,
                        'hook_extra'                  => array(
                            'type'   => 'plugin',
                            'action' => 'install',
                        ),
                    )
                );
    
                if (is_wp_error($result)) {
                    throw new \Exception($result->get_error_message());
                }
    
                $activate = true;
    
            } catch (\Exception $e) {
    
                error_log($e->getMessage());
    
                ob_end_clean();
    
                return false;
            }
    
            ob_end_clean();
        }
    
        wp_clean_plugins_cache();
    
        // Activate plugin.
        if ($activate) {
            try {
    
                $plugin_path = $installed
                    ? $installed_plugins[$plugin_file]
                    : $plugin_slug . '/' . $plugin_file;
    
                $result = activate_plugin($plugin_path);
    
                if (is_wp_error($result)) {
                    throw new \Exception($result->get_error_message());
                }
    
            } catch (\Exception $e) {

                error_log($e->getMessage());
    
                return false;
            }
        }
    
        return true;
    }

    private function associate_plugin_file($plugins, $key)
    {
        $path               = explode('/', $key);
        $filename           = end($path);
        $plugins[$filename] = $key;
        return $plugins;
    }

    public function getAddons()
    {
        $imageUrl = ATC_PLUGIN_URL.'assets/images/';

        $data = [
            'advanced-testimonial' => [
                'title'          => __('Advanced Testimonial Carousel For Elementor', 'advanced-testimonial-carousel-for-elementor'),
                'logo'           => $imageUrl . 'testimonial-logo.png',
                'is_installed'   => defined('ATC_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wpcreativeidea.com/testimonial',
                'settings_url'   => admin_url('admin.php?page=elementor-settings#tab-atcfe-settings'),
                'action_text'    => __('Install Testimonial', 'advanced-testimonial-carousel-for-elementor'),
				'route'			 => 'install_atc',
                'description'    => __('Advanced Testimonial Carousel for Elementor. You can add image, name, describes, title, added Unlimited slider.
				You can customize image, name, describes, title. Additional options etc.', 'advanced-testimonial-carousel-for-elementor')
            ],
			'advanced-pricing-table' => [
                'title'          => __('Advanced Pricing Table For Elementor', 'advanced-testimonial-carousel-for-elementor'),
                'logo'           => $imageUrl .'pricing-table-logo.png',
                'is_installed'   => defined('APTFE_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wpcreativeidea.com/pricing',
                'settings_url'   => admin_url('admin.php?page=elementor-settings#tab-aptfe-settings'),
                'action_text'    => __('Install Pricing', 'advanced-testimonial-carousel-for-elementor'),
				'route'			 => 'install_aptfe',
                'description'    => __('Advanced Pricing Table for Elementor lets you create responsive and customizable pricing tables easily with Elementor.', 'advanced-testimonial-carousel-for-elementor')
            ],
			'advanced-image-comparison'  => [
                'title'          => __('Advanced Image Comparison for Elementor', 'advanced-testimonial-carousel-for-elementor'),
                'logo'           => $imageUrl . 'image-comparison-logo.png',
                'is_installed'   => defined('AIC_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wpcreativeidea.com/image-comparison',
                'settings_url'   => admin_url('admin.php?page=elementor-settings#tab-aic-settings'),
                'action_text'    => __('Install Comparison', 'advanced-testimonial-carousel-for-elementor'),
				'route'			 => 'install_aic', 
                'description'    => __('Advanced Image Comparison is a fully Responsive.
				You can comparison your image. Comparison before image and after image. You can also image filtering.
				Customize image container, image radius, image border. Label customizing text color, background color border radius etc.
				You can set image overlay. Divider width, color. Handle color, background color, border radius etc.
				Additional options image visibility set, layout, move slider on click, move slider on hover, image overlay.', 'advanced-testimonial-carousel-for-elementor')
            ],
		
			'advanced-slider'    => [
                'title'          => __('Advanced Slider for Elementor', 'advanced-testimonial-carousel-for-elementor'),
                'logo'           => $imageUrl . 'slider-logo.png',
                'is_installed'   => defined('ASE_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wpcreativeidea.com/slider',
                'settings_url'   => admin_url('admin.php?page=elementor-settings#tab-ase-settings'),
                'action_text'    => __('Install Slider', 'advanced-testimonial-carousel-for-elementor'),
				'route'			 => 'install_ase',
                'description'    => __('Advanced Slider for Elementor. You can add background image, title, content and button, added Unlimited slider. You can customize background, title, describes and button. Additional options etc.Additional options, Styling title, content, button, background Overlay etc pro features.', 'advanced-testimonial-carousel-for-elementor')
            ]
		];

        wp_send_json_success([
            'get_addons' => $data,
            'message'    => __('Get Recommended Addons', 'advanced-testimonial-carousel-for-elementor')
        ]);
    }
}