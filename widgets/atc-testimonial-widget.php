<?php

class ATCTestimonialWidget extends \Elementor\Widget_Base
{
    public function get_name() 
    {
        return "atc-testimonial-carousel";
    }

    public function get_title() 
    {
        return __( 'ATC Testimonial Carousel', 'atc' );
        
    }

    public function get_icon() 
    {
        return "far fa-comment-alt";
    }

    public function get_categories()
    {
       return ['basic'];
    }
    

    protected function _register_controls()
    {
        
        $this->start_controls_section(
			'atc_widget_content_section',
			[
				'label' => __( 'Testimonial Carousel', 'atc' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );


        // repeater start
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'atc_content', [
                'label' => __( 'Content', 'atc' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc blandit non nisl a maximus. Sed aliquam lectus ipsum, id imperdiet purus euismod et. Maecenas volutpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio' , 'atc' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'atc_image', [
                'label' => __( 'Choose Image', 'atc' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
            ]
        );

        $repeater->add_control(
            'atc_name', [
                'label' => __( 'Name', 'atc' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'John Doe' , 'atc' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'atc_title', [
                'label' => __( 'Title', 'atc' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'CEO' , 'atc' ),
                'label_block' => true,
            ]
        );

  
          $this->add_control(
              'atc_list',
              [
                  'label' => __( 'Repeater List', 'atc' ),
                  'type' => \Elementor\Controls_Manager::REPEATER,
                  'fields' => $repeater->get_controls(),
                  'default' => [
                      [
                          'atc_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc blandit non nisl a maximus. Sed aliquam lectus ipsum, id imperdiet purus euismod et. Maecenas volutpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio', 'atc' ),
                          'atc_name' => __( 'John Doe', 'atc' )
                      ],
                      [
                          'atc_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc blandit non nisl a maximus. Sed aliquam lectus ipsum, id imperdiet purus euismod et. Maecenas volutpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio', 'atc' ),
                          'atc_name' => __( 'Michael Jackson', 'atc' )                
                      ],
                      [
                        'atc_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc blandit non nisl a maximus. Sed aliquam lectus ipsum, id imperdiet purus euismod et. Maecenas volutpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio', 'atc' ),
                        'atc_name' => __( 'Jackson', 'atc' )                
                      ],
                  ],
                  'title_field' => '{{{ atc_name }}}',
              ]
          );
          // repeater end

            $this->add_control(
                'atc_hr1',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
		    );

            $this->add_control(
                'atc_layout',
                [
                    'label' => __( 'Layout', 'atc' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'default'  => __( 'Default', 'atc' ),
                        'top' => __( 'Top', 'atc' ),
                        'bottom' => __( 'Bottom', 'atc' )
                    ],
                ]
            );

            $this->add_control(
                'atc_testimonial_autoplay',
                [
                    'label' => __( 'Autoplay', 'atc' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'atc' ),
                    'label_off' => __( 'Hide', 'atc' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'atc_testimonial_slide_speed',
                [
                    'label' => __( 'Slide Speed', 'atc' ),
                    'type' =>  \Elementor\Controls_Manager::SELECT,
                    'options' => [
                         '1000' => __( '1 Second', 'atc' ),
                         '2000' => __( '2 Seconds', 'atc' ),
                         '3000' => __( '3 Seconds', 'atc' ),
                         '4000' => __( '4 Seconds', 'atc' ),
                         '5000' => __( '5 Seconds', 'atc' ),
                         '6000' => __( '6 Seconds', 'atc' ),
                         '7000' => __( '7 Seconds', 'atc' ),
                         '8000' => __( '8 Seconds', 'atc' ),
                         '9000' => __( '9 Seconds', 'atc' ),
                         '10000' => __( '10 Seconds', 'atc' ),
                         '11000' => __( '11 Seconds', 'atc' ),
                         '12000' => __( '12 Seconds', 'atc' ),
                         '13000' => __( '13 Seconds', 'atc' ),
                         '14000' => __( '14 Seconds', 'atc' ),
                         '15000' => __( '15 Seconds', 'atc' ),
                    ],
                    'default' => '3000',
                ]
            );

            $this->add_control(
                'atc_testimonial_loop',
                [
                    'label' => __( 'Enable loop', 'atc' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'atc' ),
                    'label_off' => __( 'Hide', 'atc' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'atc_testimonial_nav',
                [
                    'label' => __( 'Enable Nav', 'atc' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'atc' ),
                    'label_off' => __( 'Hide', 'atc' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'atc_testimonial_dots',
                [
                    'label' => __( 'Enable Dots', 'atc' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'atc' ),
                    'label_off' => __( 'Hide', 'atc' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );
        $this->end_controls_section();
        
        $this->start_controls_section(
			'atc_widget_background_style_section',
			[
				'label' => __( 'Additional', 'atc' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        $this->add_control(
			'atc_widget_background_color',
			[
				'label' => __( 'Background Color', 'atc' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial' => 'background-color: {{VALUE}}',
				],
			]
        );
        $this->add_control(
            'atc_testimonial_height',
            [
                'label' => __( 'height', 'atc' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 600,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .atc-testimonial' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
			'atc_testimonial_margin',
			[
				'label' => __( 'Margin', 'atc' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .atc-slider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->add_responsive_control(
			'atc_testimonial_padding',
			[
				'label' => __( 'Padding', 'atc' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .atc-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_image_style_section',
			[
				'label' => __( 'Image', 'atc' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
            'atc_image_width',
            [
                'label' => __( 'width', 'atc' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .atc-testimonial .author-img img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'atc_image_height',
            [
                'label' => __( 'Height', 'atc' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .atc-testimonial .author-img img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'atc_image_border_radius',
			[
				'label' => __( 'Border Radius', 'atc' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .author-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
			'atc_widget_content_style_section',
			[
				'label' => __( 'Content', 'atc' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );
        $this->add_control(
			'atc_content_text_align',
			[
				'label' => __( 'Alignment', 'atc' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'atc' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'atc' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'atc' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'toggle' => true,
                'selectors' => [
					'{{WRAPPER}} .atc-testimonial .content' => 'text-align: {{VALUE}}',
				]
			]
		);
        $this->add_control(
			'atc_widget_content_color',
			[
				'label' => __( 'Text Color', 'atc' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .content' => 'color: {{VALUE}}',
				]
			]
        );

        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .atc-testimonial .content',
			]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'content_shadow',
				'label' => __( 'Text Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .atc-testimonial .content',
			]
        );

        $this->add_responsive_control(
			'atc_image_content_margin',
			[
				'label' => __( 'Margin', 'atc' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'atc_image_content_padding',
			[
				'label' => __( 'Padding', 'atc' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_author_name_style_section',
			[
				'label' => __( 'Author Name', 'atc' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'atc_author_name_text_align',
			[
				'label' => __( 'Alignment', 'atc' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'atc' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'atc' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'atc' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'toggle' => true,
                'selectors' => [
					'{{WRAPPER}} .atc-testimonial .description .author-name' => 'text-align: {{VALUE}}',
				]
			]
        );
        
        $this->add_control(
			'atc_widget_author_name_color',
			[
				'label' => __( 'Text Color', 'atc' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .description .author-name' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'author_name_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .atc-testimonial .description .author-name',
			]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'author_name_shadow',
				'label' => __( 'Text Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .atc-testimonial .description .author-name',
			]
        );

        $this->add_responsive_control(
			'atc_image_author_name_margin',
			[
				'label' => __( 'Margin', 'atc' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .description .author-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'atc_image_author_name_padding',
			[
				'label' => __( 'Padding', 'atc' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .description .author-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_company_style_section',
			[
				'label' => __( 'Company Name', 'atc' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'atc_company_text_align',
			[
				'label' => __( 'Alignment', 'atc' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'atc' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'atc' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'atc' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'toggle' => true,
                'selectors' => [
					'{{WRAPPER}} .atc-testimonial .description .company' => 'text-align: {{VALUE}}',
				]
			]
        );

        $this->add_control(
			'atc_widget_company_color',
			[
				'label' => __( 'Text Color', 'atc' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .description .company' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'author_company_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .atc-testimonial .description .company',
			]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'author_company_shadow',
				'label' => __( 'Text Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .atc-testimonial .description .company',
			]
        );

        $this->add_responsive_control(
			'atc_image_company_margin',
			[
				'label' => __( 'Margin', 'atc' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .description .company' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'atc_image_company_padding',
			[
				'label' => __( 'Padding', 'atc' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .description .company' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'atc_dots_style_section',
			[
				'label' => __( 'Dots Icon', 'atc' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'atc_dots_color',
			[
				'label' => __( 'Icon Color', 'atc' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial .swiper-pagination-bullet' => 'background: {{VALUE}}',
				],
			]
        );

        $this->add_control(
            'atc_dots_size',
            [
                'label' => __( 'Icon Size', 'atc' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px',''],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .atc-testimonial .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if ( $settings['atc_list'] ) {
            echo $this->html($settings);
        }
    }


    public function html($settings)
    {   
      
        $loop = ( $settings['atc_testimonial_loop'] ===  'yes' ) ? 'true' : 'false';
        $autoplay = ( $settings['atc_testimonial_autoplay'] ===  'yes' ) ? 'true' : 'false';
        
	    $this->add_render_attribute( 
			'atc_options', 
			[
                'data-loop' => $loop,
                'data-autoplay' => $autoplay,
                'data-slider-speed' => $settings['atc_testimonial_slide_speed']
            ]
        );
        
        ?>
        <div <?php echo $this->get_render_attribute_string( 'atc_options' ); ?> class="swiper-container atc-testimonial atc-testimonial-slider-<?php echo $settings['atc_layout']; ?>">
            <div class="swiper-wrapper">
                <?php foreach (  $settings['atc_list'] as $item ) {
                    echo '<div class="swiper-slide atc-slider" style="text-align:left">
                            <div class="author-img">
                                <img src="'.$item['atc_image']['url'].'"/>
                            </div>
                            <div class="description"> 
                                <p class="content">'. $item['atc_content'] .'</p>
                                <h4 class="author-name">'. $item['atc_name'] .'</h4>
                                <p class="company">'. $item['atc_title'] .'</p>
                            </div>
                        </div>';
                    }
                ?>
            </div>
            <?php 
                if ( 'yes' === $settings['atc_testimonial_nav'] ) {
                    echo '<div class="swiper-button-next"></div> <div class="swiper-button-prev"></div>';
                }
                if ( 'yes' === $settings['atc_testimonial_dots'] ) {
                    echo '<div class="swiper-pagination"></div>';
                }
            ?>
        </div>
        <?php
    }

    protected function _content_template()
    {
        ?>
        <# 
            let loop = ( settings.atc_testimonial_loop === 'yes' ) ? 'true' : 'false';
            let autoplay = ( settings.atc_testimonial_autoplay === 'yes' ) ? 'true' : 'false';
            
           
            view.addRenderAttribute( 
                'atc_options', 
                {
                    'data-loop': loop,
                    'data-autoplay': autoplay,
                    'data-slider-speed': settings.atc_testimonial_slide_speed
                }
            );
        #>

        <div {{{ view.getRenderAttributeString( 'atc_options' ) }}} class="swiper-container atc-testimonial atc-testimonial-slider-{{ settings.atc_layout }}">
            <div class="swiper-wrapper">
                <# _.each( settings.atc_list, function( item, index ) { #>
                    <div class="swiper-slide atc-slider" style="text-align:left">
                            <div class="author-img">
                                <img src="{{ item.atc_image.url }}"/>
                            </div>
                            <div class="description"> 
                                <p class="content">{{{ item.atc_content }}}</p>
                                <h4 class="author-name">{{{ item.atc_name }}}</h4>
                                <p class="company">{{{ item.atc_title }}}</p>
                            </div>
                        </div>
                <# } ); #>
            </div>
              <#  if ( 'yes' === settings.atc_testimonial_nav ) { #>
                <div class="swiper-button-next"></div> <div class="swiper-button-prev"></div>
              <# } #>

              <# if ( 'yes' === settings.atc_testimonial_dots ) { #>
                   <div class="swiper-pagination"></div>
              <# } #>
        </div>
        <?php
    }
} 