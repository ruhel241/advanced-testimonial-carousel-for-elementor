<?php

namespace ATC\Classes;

class SetupController
{

    public function handleAjaxCalls()
    {
        $route = sanitize_text_field( $_REQUEST['route'] );
        $nonce = sanitize_text_field( $_REQUEST['nonce'] );

        if ( !(isset($nonce) && wp_verify_nonce($nonce, 'atc_nonce')) ) {
            return;
        }

        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        
        /**
         *  Advaced Testimonial Carousel
        */
        if ($route == 'install-atc') {
            $this->handleAdvancedTestimonialInstall();
        }

        /**
         *  Advaced Image Comparison
        */
        if ( $route == 'install-aic' ) {
            $this->handleImageComparisonInstall();
        }

        /**
         *  Advaced Slider
        */
        if ($route == 'install-ase') {
            $this->handleAdvancedSliderInstall();
        }
    }

    /**
     * Advanced Testimonial Carousel For Elementor 
    */

    public function handleAdvancedTestimonialInstall()
    {
        $this->installAdvancedTestimonial();

        wp_send_json_success([
            'is_installed' => defined('ATC_PLUGIN_VERSION'),
            'message'      => __('Advanced Testimonial Carousel for Elementor plugin has been installed and activated successfully', 'advanced-testimonial-carousel-for-elementor')
        ]);
    }

    private function installAdvancedTestimonial()
    {
        $plugin_id = 'advanced-testimonial-carousel-for-elementor';
        $plugin = [
            'name'      => __('Advanced Testimonial Carousel for Elementor', 'advanced-testimonial-carousel-for-elementor'), 
			'repo-slug' => 'advanced-testimonial-carousel-for-elementor',
			'file'      => 'advanced-testimonial-carousel-for-elementor.php',
        ];
        $this->backgroundInstaller($plugin, $plugin_id);
    }

    /**
     * Advanced Image Comparison
    */

    public function handleImageComparisonInstall()
    {
        $this->installImageComparison();

        wp_send_json_success([
            'is_installed' => defined('AIC_PLUGIN_VERSION'),
            'message'      => __('Advanced Image Comparison for Elementor has been installed and activated', 'advanced-testimonial-carousel-for-elementor')
        ]);
    }

    private function installImageComparison()
    {
        $plugin_id = 'advanced-image-comparison-for-elementor';
        $plugin = [
            'name'      => __('Advanced Image Comparison for Elementor', 'advanced-testimonial-carousel-for-elementor'),
            'repo-slug' => 'advanced-image-comparison-for-elementor',
            'file'      => 'advanced-image-comparison-for-elementor.php',
        ];
        $this->backgroundInstaller($plugin, $plugin_id);
    }

    /**
     * Advanced Slider For Elementor 
    */

    public function handleAdvancedSliderInstall()
    {
        $this->installAdvancedSlider();

        wp_send_json_success([
            'is_installed' => defined('ASE_PLUGIN_VERSION'),
            'message'      => __('Advanced Slider for Elementor plugin has been installed and activated successfully', 'advanced-testimonial-carousel-for-elementor')
        ]);
    }

    private function installAdvancedSlider()
    {
        $plugin_id = 'advanced-slider-for-elementor';
        $plugin = [
            'name'      => __('Advanced Slider for Elementor', 'advanced-testimonial-carousel-for-elementor'),
			'repo-slug' => 'advanced-slider-for-elementor',
			'file'      => 'advanced-slider-for-elementor.php',
        ];
        $this->backgroundInstaller($plugin, $plugin_id);
    }

    private function backgroundInstaller($plugin_to_install, $plugin_id)
    {
        if (!empty($plugin_to_install['repo-slug'])) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            require_once ABSPATH . 'wp-admin/includes/plugin.php';

            WP_Filesystem();

            $skin = new \Automatic_Upgrader_Skin();
            $upgrader = new \WP_Upgrader($skin);
            $installed_plugins = array_reduce(array_keys(\get_plugins()), array($this, 'associate_plugin_file'), array());
            $plugin_slug = $plugin_to_install['repo-slug'];
            $plugin_file = isset($plugin_to_install['file']) ? $plugin_to_install['file'] : $plugin_slug . '.php';
            $installed = false;
            $activate = false;

            // See if the plugin is installed already.
            if (isset($installed_plugins[$plugin_file])) {
                $installed = true;
                $activate = !is_plugin_active($installed_plugins[$plugin_file]);
            }

            // Install this thing!
            if (!$installed) {
                // Suppress feedback.
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
                }

                // Discard feedback.
                ob_end_clean();
            }

            wp_clean_plugins_cache();

            // Activate this thing.
            if ($activate) {
                try {
                    $result = activate_plugin($installed ? $installed_plugins[$plugin_file] : $plugin_slug . '/' . $plugin_file);

                    if (is_wp_error($result)) {
                        throw new \Exception($result->get_error_message());
                    }
                } catch (\Exception $e) {
                }
            }
        }
    }

    private function associate_plugin_file($plugins, $key)
    {
        $path = explode('/', $key);
        $filename = end($path);
        $plugins[$filename] = $key;
        return $plugins;
    }

}


