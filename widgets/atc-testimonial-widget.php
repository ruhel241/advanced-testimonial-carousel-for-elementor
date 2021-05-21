<?php

namespace ATC\Classes\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Text_Shadow;


class ATCTestimonialWidget extends Widget_Base
{
    public function get_name() 
    {
        return "atc-testimonial-carousel";
    }

    public function get_title() 
    {
        return __( 'Advanced Testimonial Carousel', 'atc' );
        
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
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );


        // repeater start
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'atc_content', [
                'label' => __( 'Content', 'atc' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio' , 'atc' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'atc_image', [
                'label' => __( 'Choose Image', 'atc' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
            ]
        );

        $repeater->add_control(
            'atc_name', [
                'label' => __( 'Name', 'atc' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'John Doe' , 'atc' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'atc_title', [
                'label' => __( 'Title', 'atc' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'CEO' , 'atc' ),
                'label_block' => true,
            ]
        );

  
          $this->add_control(
              'atc_list',
              [
                  'label' => __( 'Repeater List', 'atc' ),
                  'type' => Controls_Manager::REPEATER,
                  'fields' => $repeater->get_controls(),
                  'default' => [
                      [
                          'atc_content' => __( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio', 'atc' ),
                          'atc_name' => __( 'John Doe', 'atc' )
                      ],
                      [
                          'atc_content' => __( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio', 'atc' ),
                          'atc_name' => __( 'Michael Jackson', 'atc' )                
                      ],
                      [
                        'atc_content' => __( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio', 'atc' ),
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
                    'type' => Controls_Manager::DIVIDER,
                ]
		    );

            $this->add_control(
                'atc_layout',
                [
                    'label' => __( 'Layout', 'atc' ),
                    'type' => Controls_Manager::SELECT,
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
                    'type' => Controls_Manager::SWITCHER,
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
                    'type' =>  Controls_Manager::SELECT,
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
                    'type' => Controls_Manager::SWITCHER,
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
                    'type' => Controls_Manager::SWITCHER,
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
                    'type' => Controls_Manager::SWITCHER,
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
				'label' => __( 'Additional Options', 'atc' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
        $this->add_control(
			'atc_widget_background_color',
			[
				'label' => __( 'Background Color', 'atc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container' => 'background-color: {{VALUE}}',
				],
			]
        );
        $this->add_control(
            'atc_testimonial_height',
            [
                'label' => __( 'height', 'atc' ),
                'type' => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .atc-testimonial-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
			'atc_testimonial_margin',
			[
				'label' => __( 'Margin', 'atc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .atc-slider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->add_responsive_control(
			'atc_testimonial_padding',
			[
				'label' => __( 'Padding', 'atc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .atc-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_image_style_section',
			[
				'label' => __( 'Image', 'atc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
            'atc_image_width',
            [
                'label' => __( 'width', 'atc' ),
                'type' => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .atc-testimonial-container .author-img img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'atc_image_height',
            [
                'label' => __( 'Height', 'atc' ),
                'type' => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .atc-testimonial-container .author-img img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'atc_image_border_radius',
			[
				'label' => __( 'Border Radius', 'atc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .author-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
			'atc_widget_content_style_section',
			[
				'label' => __( 'Content', 'atc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        $this->add_control(
			'atc_content_text_align',
			[
				'label' => __( 'Alignment', 'atc' ),
				'type' => Controls_Manager::CHOOSE,
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
					'{{WRAPPER}} .atc-testimonial-container .content' => 'text-align: {{VALUE}}',
				]
			]
		);
        $this->add_control(
			'atc_widget_content_color',
			[
				'label' => __( 'Text Color', 'atc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .content' => 'color: {{VALUE}}',
				]
			]
        );

        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'atc' ),
				'selector' => '{{WRAPPER}} .atc-testimonial-container .content',
			]
        );

        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'content_shadow',
				'label' => __( 'Text Shadow', 'atc' ),
				'selector' => '{{WRAPPER}} .atc-testimonial-container .content',
			]
        );

        $this->add_responsive_control(
			'atc_image_content_margin',
			[
				'label' => __( 'Margin', 'atc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'atc_image_content_padding',
			[
				'label' => __( 'Padding', 'atc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_author_name_style_section',
			[
				'label' => __( 'Author Name', 'atc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'atc_author_name_text_align',
			[
				'label' => __( 'Alignment', 'atc' ),
				'type' => Controls_Manager::CHOOSE,
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
					'{{WRAPPER}} .atc-testimonial-container .description .author-name' => 'text-align: {{VALUE}}',
				]
			]
        );
        
        $this->add_control(
			'atc_widget_author_name_color',
			[
				'label' => __( 'Text Color', 'atc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .description .author-name' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_name_typography',
				'label' => __( 'Typography', 'atc' ),
				'selector' => '{{WRAPPER}} .atc-testimonial-container .description .author-name',
			]
        );

        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'author_name_shadow',
				'label' => __( 'Text Shadow', 'atc' ),
				'selector' => '{{WRAPPER}} .atc-testimonial-container .description .author-name',
			]
        );

        $this->add_responsive_control(
			'atc_image_author_name_margin',
			[
				'label' => __( 'Margin', 'atc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .description .author-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'atc_image_author_name_padding',
			[
				'label' => __( 'Padding', 'atc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .description .author-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_company_style_section',
			[
				'label' => __( 'Company Name', 'atc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'atc_company_text_align',
			[
				'label' => __( 'Alignment', 'atc' ),
				'type' => Controls_Manager::CHOOSE,
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
					'{{WRAPPER}} .atc-testimonial-container .description .company' => 'text-align: {{VALUE}}',
				]
			]
        );

        $this->add_control(
			'atc_widget_company_color',
			[
				'label' => __( 'Text Color', 'atc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .description .company' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_company_typography',
				'label' => __( 'Typography', 'atc' ),
				'selector' => '{{WRAPPER}} .atc-testimonial-container .description .company',
			]
        );

        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'author_company_shadow',
				'label' => __( 'Text Shadow', 'atc' ),
				'selector' => '{{WRAPPER}} .atc-testimonial-container .description .company',
			]
        );

        $this->add_responsive_control(
			'atc_image_company_margin',
			[
				'label' => __( 'Margin', 'atc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .description .company' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'atc_image_company_padding',
			[
				'label' => __( 'Padding', 'atc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .description .company' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'atc_nav_section',
			[
				'label' => __( 'Nav Icon', 'atc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'atc_nav_color',
			[
				'label' => __( 'Icon Color', 'atc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .swiper-button-prev:before, {{WRAPPER}} .atc-testimonial-container .swiper-button-next:before' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_control(
			'atc_nav_size',
			[
				'label' => __( 'Icon Size', 'atc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
                    '{{WRAPPER}} .atc-testimonial-container .swiper-button-prev:before, {{WRAPPER}} .atc-testimonial-container .swiper-button-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
			]
		);

        $this->add_control(
			'atc_nav_position',
			[
				'label' => __( 'Icon Position', 'atc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
                        'max' => 100,
                        'step' => 1,
					],
				],
				'selectors' => [
                    '{{WRAPPER}} .atc-testimonial-container .swiper-button-prev:before, {{WRAPPER}} .atc-testimonial-container .swiper-button-next:before' => 'top: {{SIZE}}{{UNIT}};',
                ]
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'atc_dots_section',
			[
				'label' => __( 'Dots Icon', 'atc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'atc_dots_color',
			[
				'label' => __( 'Icon Color', 'atc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .swiper-pagination-bullet-active' => 'background: {{VALUE}}',
				],
			]
        );

        $this->add_control(
            'atc_dots_size',
            [
                'label' => __( 'Icon Size', 'atc' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .atc-testimonial-container .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'atc_dots_position',
			[
				'label' => __( 'Icon Position', 'atc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
                        'max' => 100,
                        'step' => 1,
					],
				],
				'selectors' => [
                    '{{WRAPPER}} .atc-testimonial-container .swiper-pagination-bullets' => 'bottom: {{SIZE}}{{UNIT}};',
                ]
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
                'id'    => 'atc-testimonial-carousel-' . esc_attr( $this->get_id() ),
                'class' => ['swiper-container atc-testimonial-container atc-testimonial-slider-'.$settings["atc_layout"]],
                'data-loop' => $loop,
                'data-autoplay' => $autoplay,
                'data-slider-speed' => $settings['atc_testimonial_slide_speed'],
                'data-pagination' => '.swiper-pagination',
                'data-button-next' => '.swiper-button-next',
                'data-button-prev' => '.swiper-button-prev',
            ]
        );
        
        ?>
        <div <?php echo $this->get_render_attribute_string( 'atc_options' ); ?>>
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

} 