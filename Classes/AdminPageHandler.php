<?php

namespace ATC\Classes;

use Elementor\Settings;

class AdminPageHandler {

	public function initialLoad()
	{
		if ( is_admin() ) {
			$page_id = Settings::PAGE_ID;
			add_action( "elementor/admin/after_create_settings/{$page_id}", function( Settings $settings ) {
				$this->register_settings_fields($settings);
			}, 11 );
		}
	}

    public function register_settings_fields($settings)
	{
		$settings->add_tab(
			'atc-settings', [
				'label' => esc_html__( 'ATC Settings', 'advanced-testimonial-carousel-for-elementor' ),
				'sections' => [
					'atc-plugins-section' => [
						'callback' => function() {
							$this->renderPage();
						},
						'fields' => []
					],
					'atc-license-section' => [
						'callback' => function() {
							$this->licenseRender();
						},
						'fields' => []
					]
				]
			]
		);
	}

    public function renderPage()
    {
		$data = $this->getAddons(); 
	?>
		<div class="notice notice-success" id="atc-notice-success" style="display: none">
			<p>The Advanced Testimonial Pro license activated.</p>
		</div>

		<div class="notice notice-error" id="atc-notice-error" style="display: none">
			<p>Something is wrong!</p>
		</div>

        <?php if (defined('ATCPRO_PLUGIN_VERSION')) :?>
            <div class="atc-settings-tabs">
                <ul class="menu-tabs">
                    <li class="tab"> <a href="#tab-atc-settings" id="atc-addons-tab">Recommended Addons</a> </li>
                    <li class="tab"> <a href="#tab-atc-settings" id="atc-license-tab">License Settings</a> </li>
                </ul>
            </div>
        <?php endif; ?>
		
		<div class="atc-addons-wrapper">
			<div class="atc-addons-heading">
				<h1 style="display: initial"> Elementor Recommended Addons </h1>
				<p>	These are the Elementor addons that will help your business. </p>  
			</div>

			<div class="atc-addons-wrap">
				<?php foreach ($data as $key => $value):?>
					<div class="atc-addons-templates">
						<div class="addons-box">
							<div class="image">
								<img src="<?php echo esc_url( ATC_PLUGIN_URL . 'assets/images/'. $value['logo']); ?>" alt="">
							</div>
							<h2> <?php echo esc_html($value['title']); ?> </h2>
							<p><?php echo esc_html($value['description']); ?></p>
							<div class="btn-box">
								<?php
									if (!$value['is_installed']):
								?>	<a class="btn atc-install-addon" value="<?php echo esc_attr($value['route']); ?>">
										<?php echo esc_html($value['action_text']); ?>
									</a>
								<?php else: ?>
									<a href="<?php echo esc_attr($value['settings_url']); ?>" class="viewInstall" target="_blank">
										View Settings
									</a>
								<?php endif; ?>
								<a href="<?php echo esc_attr($value['upgrade_to_pro_link']); ?>" class="upgrade-to-pro" target="_blank">Upgrade to Pro</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php
    }
   
    /**
     * Add page to admin menu callback
     */
	public function licenseRender() {
		?>
			<div class="notice notice-success" id="atc-notice-success" style="display: none">
				<p>The Advanced Testimonial Carousel Pro Addon license activated.</p>
			</div>

			<div class="notice notice-error" id="atc-notice-error" style="display: none">
				<p>Something is wrong!</p>
			</div>

			<div class="atc_license_box" style="display:none">
				<div id="atc_activated_license" style="display: none">
					<h3 class="title">Please Provide a license key of Advanced Testimonial Carousel Pro Addon</h3> 
					<div class="atc-input atc-input-group atc-input-group--append">
						<input type="text" id="atc_license_settings_field" placeholder="License Key" class="atc_input__inner">
						<div class="atc-input-group__append">
							<a href="#" id="atc_verify_btn" class="atc-button atc-button--success">
								&#128274; Verify License
							</a>
						</div>
					</div> 
					<hr style="margin: 20px 0px 30px;"> 
					<p>Don't have a license key? <a href="https://wpcreativeidea.com/" target="_blank" style="cursor:pointer">Purchase one here</a></p>
				</div>
				<div id="atc_deactivated_license" style="display: none">
					<div class="text-align-center">
						<span style="font-size: 50px;" class="el-icon el-icon-circle-check"></span>
					</div>
					<h2>You license key is valid and activated</h2>
					<hr style="margin: 20px 0px;" />
					<p>Want to deactivate this license? <a id="atc_deactive_license" href="#">Click here</a></p>
				</div>
				<div id="atcbooster-loading" style="display: none">
					<h2> Loading..... </h2>
				</div>
			</div>
		<?php
	}

	public function getAddons()
    {
        $data = [
			'advanced-testimonial' => [
                'title'          => __('Advanced Testimonial Carousel For Elementor', 'advanced-testimonial-carousel-for-elementor'),
                'logo'           => 'testimonial-logo.png',
                'is_installed'   => defined('ATC_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wpcreativeidea.com/testimonial',
                'settings_url'   => admin_url('admin.php?page=elementor-settings#tab-atc-settings'),
                'action_text'    => __('Install Testimonial', 'advanced-testimonial-carousel-for-elementor'),
				'route'			 => 'install-atc',
                'description'    => __('Advanced Testimonial Carousel for Elementor. You can add image, name, describes, title, added Unlimited slider.
				You can customize image, name, describes, title. Additional options etc.', 'advanced-testimonial-carousel-for-elementor')
            ],

            'advanced-image-comparison'  => [
                'title'          => __('Advanced Image Comparison for Elementor', 'advanced-testimonial-carousel-for-elementor'),
                'logo'           => 'image-comparison-logo.png',
                'is_installed'   => defined('AIC_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wpcreativeidea.com/image-comparison',
                'settings_url'   => admin_url('admin.php?page=elementor-settings#tab-aic-settings'),
                'action_text'    => __('Install Comparison', 'advanced-testimonial-carousel-for-elementor'),
				'route'			 => 'install-aic', 
                'description'    => __('Advanced Image Comparison is a fully Responsive.
				You can comparison your image. Comparison before image and after image. You can also image filtering.
				Customize image container, image radius, image border. Label customizing text color, background color border radius etc.
				You can set image overlay. Divider width, color. Handle color, background color, border radius etc.
				Additional options image visibility set, layout, move slider on click, move slider on hover, image overlay.', 'advanced-testimonial-carousel-for-elementor')
            ],
		
			'advanced-slider'    => [
                'title'          => __('Advanced Slider for Elementor', 'advanced-testimonial-carousel-for-elementor'),
                'logo'           => 'slider-logo.png',
                'is_installed'   => defined('ASE_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wpcreativeidea.com/slider',
                'settings_url'   => admin_url('admin.php?page=elementor-settings#tab-ase-settings'),
                'action_text'    => __('Install Slider', 'advanced-testimonial-carousel-for-elementor'),
				'route'			 => 'install-ase',
                'description'    => __('Advanced Slider for Elementor. You can add background image, title, content and button, added Unlimited slider. You can customize background, title, describes and button. Additional options etc.Additional options, Styling title, content, button, background Overlay etc pro features.', 'advanced-testimonial-carousel-for-elementor')
            ]
		];

        return $data;
    }
}