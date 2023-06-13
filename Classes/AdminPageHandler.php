<?php

namespace ATC\Classes;

class AdminPageHandler {

    public function register_settings_fields($settings)
	{
		$settings->add_tab(
			'atc-settings', [
				'label' => esc_html__( 'ATC Settings', 'elementor' ),
				'sections' => [
					'atc-plugins-section' => [
						'label' => esc_html__( '', 'elementor' ),
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


    public function getAddons()
    {
        $data = [
			'advanced-testimonial' => [
                'title'          => __('Advanced Testimonial Carousel For Elementor', 'fluent-crm'),
                'logo'           => 'testimonial-logo.png',
                'is_installed'   => defined('ATC_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wordpress.org/plugins/fluent-connect/',
                'settings_url'   => admin_url('admin.php?page=fluent-support#/'),
                'action_text'    => __('Install Advanced Testimonial', 'fluent-crm'),
				'route'			 => 'install-atc',
                'description'    => __('WordPress Helpdesk and Customer Support Ticket Plugin. Provide awesome support and manage customer queries right from your WordPress dashboard.', 'fluent-crm')
            ],

            'advanced-image-comparison'  => [
                'title'          => __('Advanced Image Comparison for Elementor', 'fluent-crm'),
                'logo'           => 'image-comparison-logo.png',
                'is_installed'   => defined('AIC_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wordpress.org/plugins/fluentform/',
                'settings_url'   => admin_url('admin.php?page=fluent_forms'),
                'action_text'    => __('Install Image Comparison', 'fluent-crm'),
				'route'			 => 'install-aic', 
                'description'    => __('Collect leads and build any type of forms, accept payments, connect with your CRM with the Fastest Contact Form Builder Plugin for WordPress', 'fluent-crm')
            ],
		
			'advanced-slider'    => [
                'title'          => __('Advanced Slider for Elementor', 'fluent-crm'),
                'logo'           => 'slider-logo.png',
                'is_installed'   => defined('ASE_PLUGIN_VERSION'),
                'upgrade_to_pro_link' => 'https://wordpress.org/plugins/fluent-smtp/',
                'settings_url'   => admin_url('options-general.php?page=fluent-mail#/'),
                'action_text'    => __('Install Advanced Slider', 'fluent-crm'),
				'route'			 => 'install-ase',
                'description'    => __('The Ultimate SMTP and SES Plugin for WordPress. Connect with any SMTP, SendGrid, Mailgun, SES, Sendinblue, PepiPost, Google, Microsoft and more.', 'fluent-crm')
            ]
		];

        return $data;
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
                    <li class="tab"> <a href="#tab-atc-settings" id="atc-addons-tab">Recommended Plugins</a> </li>
                    <li class="tab"> <a href="#tab-atc-settings" id="atc-license-tab">License Settings</a> </li>
                </ul>
            </div>
        <?php endif; ?>
		
		<div class="atc-addons-wrapper">
			<div class="atc-addons-heading">
				<h1 style="display: initial"> Elementor Recommended Plugins </h1>
				<p>	Extend FluentCRM functionalities and supercharge your email marketing and automation
			</div>

			<div class="atc-addons-wrap">
				<?php foreach ($data as $key => $value):?>
					<div class="atc-addons-templates">
						<div class="addons-box">
							<div class="image">
								<img src="<?php echo esc_url( ATC_PLUGIN_URL . 'assets/images/'. $value['logo']); ?>" alt="">
							</div>
							<h2> <?php echo $value['title']; ?> </h2>
							<p><?php echo $value['description']; ?></p>
							<div class="btn-box">
								<?php
									if (!$value['is_installed']):
								?>	<a class="btn installAddon" value="<?php echo $value['route']; ?>">
										<?php echo $value['action_text']; ?>
									</a>
								<?php else: ?>
									<a href="<?php echo $value['settings_url']; ?>" class="btn atcViewInstall" id="atcViewInstallddd">
										View Settings
									</a>
								<?php endif; ?>
								<a href="<?php echo $value['upgrade_to_pro_link']; ?>" class="btn" target="_blank">Upgrade to Pro</a>
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
				<p>The atc Pro Addon license activated.</p>
			</div>

			<div class="notice notice-error" id="atc-notice-error" style="display: none">
				<p>Something is wrong!</p>
			</div>

			<div class="atc_license_box" style="display:none">
				<div id="atc_activated_license" style="display: none">
					<h3 class="title">Please Provide a license key of Exact links Pro Addon</h3> 
					<div class="atc-input atc-input-group atc-input-group--append">
						<input type="text" id="atc_license_settings_field" placeholder="License Key" class="atc_input__inner">
						<div class="atc-input-group__append">
							<a href="#" id="atc_verify_btn" class="atc-button atc-button--success">
								&#128274; Verify License
							</a>
						</div>
					</div> 
					<hr style="margin: 20px 0px 30px;"> 
					<p>Don't have a license key? <a href="https://wpatcsbooster.org/" target="_blank" style="cursor:pointer">Purchase one here</a></p>
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
}