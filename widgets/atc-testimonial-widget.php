<?php

namespace ATC\Classes\Widgets;

use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;

use ATCPRO\Services\ATCWidgetPro;

class ATCTestimonialWidget extends Widget_Base
{
    public function get_name() 
    {
        return "atc-testimonial-carousel";
    }

    public function get_title() 
    {
        return __( 'Advanced Testimonial Carousel', 'advanced-testimonial-carousel-for-elementor' );
        
    }

    public function get_icon() 
    {
        return "eicon-testimonial-carousel";
    }

    public function get_categories()
    {
       return ['basic'];
    }
    

    protected function register_controls()
    {
        $proNotice = [
			'title' => esc_html__( 'These are pro features', 'advanced-testimonial-carousel-for-elementor' ),
			'message' => esc_html__( 'These are pro features, if you want to enable these features you need to upgrade to the pro version.', 'advanced-testimonial-carousel-for-elementor' ),
			'link' => "mailto: ruhel241@gmail.com"
		];

        $this->start_controls_section(
			'atc_widget_content_section',
			[
				'label' => __( 'Testimonial Carousel', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );


        // repeater start
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'atc_content', [
                'label' => __( 'Content', 'advanced-testimonial-carousel-for-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio' , 'advanced-testimonial-carousel-for-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'atc_image', [
                'label' => __( 'Choose Image', 'advanced-testimonial-carousel-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
            ]
        );

        $repeater->add_control(
            'atc_name', [
                'label' => __( 'Name', 'advanced-testimonial-carousel-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'John Doe' , 'advanced-testimonial-carousel-for-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'atc_title', [
                'label' => __( 'Title', 'advanced-testimonial-carousel-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'CEO' , 'advanced-testimonial-carousel-for-elementor' ),
                'label_block' => true,
            ]
        );

  
          $this->add_control(
              'atc_list',
              [
                  'label' => __( 'Repeater List', 'advanced-testimonial-carousel-for-elementor' ),
                  'type' => Controls_Manager::REPEATER,
                  'fields' => $repeater->get_controls(),
                  'default' => [
                      [
                          'atc_content' => __( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio', 'advanced-testimonial-carousel-for-elementor' ),
                          'atc_name' => __( 'John Doe', 'advanced-testimonial-carousel-for-elementor' )
                      ],
                      [
                          'atc_content' => __( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio', 'advanced-testimonial-carousel-for-elementor' ),
                          'atc_name' => __( 'Michael Jackson', 'advanced-testimonial-carousel-for-elementor' )                
                      ],
                      [
                        'atc_content' => __( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio', 'advanced-testimonial-carousel-for-elementor' ),
                        'atc_name' => __( 'Jackson', 'advanced-testimonial-carousel-for-elementor' )                
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

           
        $this->end_controls_section();
        
        $this->start_controls_section(
			'atc_widget_background_style_section',
			[
				'label' => __( 'Additional Options', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            $this->add_control(
                'atc_testimonial_autoplay',
                [
                    'label' => __( 'Autoplay', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'advanced-testimonial-carousel-for-elementor' ),
                    'label_off' => __( 'Hide', 'advanced-testimonial-carousel-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'atc_testimonial_loop',
                [
                    'label' => __( 'Enable loop', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'advanced-testimonial-carousel-for-elementor' ),
                    'label_off' => __( 'Hide', 'advanced-testimonial-carousel-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'atc_testimonial_nav',
                [
                    'label' => __( 'Enable Nav', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'advanced-testimonial-carousel-for-elementor' ),
                    'label_off' => __( 'Hide', 'advanced-testimonial-carousel-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'atc_testimonial_dots',
                [
                    'label' => __( 'Enable Dots', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'advanced-testimonial-carousel-for-elementor' ),
                    'label_off' => __( 'Hide', 'advanced-testimonial-carousel-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );
            
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->additionaloptionsMore($this);
            }

            $this->add_control(
                'atc_layout',
                [
                    'label' => __( 'Layout', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'default'  => __( 'Default', 'advanced-testimonial-carousel-for-elementor' ),
                        'top' => __( 'Top', 'advanced-testimonial-carousel-for-elementor' ),
                        'bottom' => __( 'Bottom', 'advanced-testimonial-carousel-for-elementor' )
                    ],
                ]
            );
            $this->add_control(
                'atc_testimonial_slide_speed',
                [
                    'label' => __( 'Slide Speed', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' =>  Controls_Manager::SELECT,
                    'options' => [
                        '1000' => __( '1 Second', 'advanced-testimonial-carousel-for-elementor' ),
                        '2000' => __( '2 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '3000' => __( '3 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '4000' => __( '4 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '5000' => __( '5 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '6000' => __( '6 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '7000' => __( '7 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '8000' => __( '8 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '9000' => __( '9 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '10000' => __( '10 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '11000' => __( '11 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '12000' => __( '12 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '13000' => __( '13 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '14000' => __( '14 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                        '15000' => __( '15 Seconds', 'advanced-testimonial-carousel-for-elementor' ),
                    ],
                    'default' => '3000',
                ]
            );
            if (!defined('ATCPRO')) {
                $this->add_control(
                    'atc_important_notice_additional_options',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->get_pro_notice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'additional-options.png'
                        ] ),
                    ]
                );
            } 
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_rating_style_section',
			[
				'label' => __( 'Rating Options', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->ratingOptionsPro($this);
            } else {
                $this->add_control(
                    'atc_important_notice_rating_options',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->get_pro_notice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'rating-options.jpg'
                        ] ),
                    ]
                );
            }
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_testimonial_carousel_style',
			[
				'label' => __( 'Testimonial Carousel', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
            $this->add_control(
                'atc_testimonial_height',
                [
                    'label' => __( 'Height', 'advanced-testimonial-carousel-for-elementor' ),
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
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->borderBoxStyling($this);
            } 
            $this->add_responsive_control(
                'atc_testimonial_margin',
                [
                    'label' => __( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before'
                ]
            );
            $this->add_responsive_control(
                'atc_testimonial_padding',
                [
                    'label' => __( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            if (!defined('ATCPRO')) {
                $this->add_control(
                    'atc_notice_border_box_style',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->get_pro_notice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'border-box-style.jpg'
                        ] ),
                    ]
                );
            }
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_background_style',
			[
				'label' => esc_html__( 'Background', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->backgroundGradientStyling($this);
            } else {
                $this->add_control(
                    'atc_important_notice_bg_gradien_style',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->get_pro_notice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'background-gradien-style.jpg'
                        ] ),
                    ]
                );
            }
		$this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_image_style_section',
			[
				'label' => __( 'Image', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_image_display' => 'yes'] : []
			]
        );
            $this->add_control(
                'atc_image_text_align',
                [
                    'label' => __( 'Alignment', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'toggle' => true,
                    // 'selectors' => [
                    //     '{{WRAPPER}} .atc-testimonial-container .author-img' => 'text-align: {{VALUE}}',
                    // ]
                ]
            );
            $this->add_control(
                'atc_image_width',
                [
                    'label' => __( 'width', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => __( 'Height', 'advanced-testimonial-carousel-for-elementor' ),
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
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->imageStylingOptions($this);
            }
            $this->add_responsive_control(
                'atc_image_border_radius',
                [
                    'label' => __( 'Border Radius', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .author-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'after'
                ]
            );
            $this->add_responsive_control(
                'atc_image_margin',
                [
                    'label' => __( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .author-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'atc_image_padding',
                [
                    'label' => __( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .author-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            if (!defined('ATCPRO')) {
                $this->add_control(
                    'atc_important_notice_image_style',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->get_pro_notice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'image-style.jpg'
                        ] ),
                    ]
                );
            }
        $this->end_controls_section();


        $this->start_controls_section(
			'atc_widget_content_style_section',
			[
				'label' => __( 'Content', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
            $this->add_control(
                'atc_content_text_align',
                [
                    'label' => __( 'Alignment', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
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
                    'label' => __( 'Text Color', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => __( 'Typography', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .content',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'content_shadow',
                    'label' => __( 'Text Shadow', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .content',
                ]
            );
            $this->add_responsive_control(
                'atc_image_content_margin',
                [
                    'label' => __( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => __( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
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
				'label' => __( 'Author Name', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_author_name_display' => 'yes'] : []
			]
        );
            $this->add_control(
                'atc_author_name_text_align',
                [
                    'label' => __( 'Alignment', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
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
                    'label' => __( 'Text Color', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => __( 'Typography', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .author-name',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'author_name_shadow',
                    'label' => __( 'Text Shadow', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .author-name',
                ]
            );
            $this->add_responsive_control(
                'atc_image_author_name_margin',
                [
                    'label' => __( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => __( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
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
				'label' => __( 'Company Name', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_company_name_display' => 'yes'] : []
            ]
        );
            $this->add_control(
                'atc_company_text_align',
                [
                    'label' => __( 'Alignment', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
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
                    'label' => __( 'Text Color', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => __( 'Typography', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .company',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'author_company_shadow',
                    'label' => __( 'Text Shadow', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .company',
                ]
            );
            $this->add_responsive_control(
                'atc_image_company_margin',
                [
                    'label' => __( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => __( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .description .company' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_rating_style',
			[
				'label' => esc_html__( 'Ratings', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_rating_display' => 'yes'] : []
            ]
		);
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->starStylingOptions($this);
            } else {
                $this->add_control(
                    'atc_important_notice_rating_style',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->get_pro_notice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'rating-style.jpg'
                        ] ),
                    ]
                );
            }
        $this->end_controls_section();
        
        $this->start_controls_section(
			'atc_nav_section',
			[
				'label' => __( 'Arrows Icon', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
            $this->add_control(
                'atc_nav_color',
                [
                    'label' => __( 'Arrows Color', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .swiper-button-prev::after, {{WRAPPER}} .atc-testimonial-container .swiper-button-next::after' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'atc_nav_size',
                [
                    'label' => __( 'Arrows Size', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em'],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .swiper-button-prev::after, {{WRAPPER}} .atc-testimonial-container .swiper-button-next::after' => 'font-size: {{SIZE}}{{UNIT}};',
                    ]
                ]
            );
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->arrowsStyling($this);
            } else {
                $this->add_control(
                    'atc_notice_arrows_style',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->get_pro_notice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'arrows-style.jpg'
                        ] ),
                    ]
                );
            }
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_dots_section',
			[
				'label' => __( 'Dots Icon', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'atc_dots_color',
			[
				'label' => __( 'Dots Color', 'advanced-testimonial-carousel-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .swiper-pagination-bullet-active' => 'background: {{VALUE}}',
				],
			]
        );

        $this->add_control(
            'atc_dots_size',
            [
                'label' => __( 'Dots Size', 'advanced-testimonial-carousel-for-elementor' ),
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
			'ase_dots_position',
			[
				'label' => esc_html__( 'Dots Position', 'advanced-slider-for-elementor-pro' ),
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

    public function get_pro_notice( $proNotice ) {
		ob_start();
	?>
		<div class="atc-nerd-box">
			<div class="image-box">
				<img class="atc-nerd-box-icon" src="<?php echo esc_url( ATC_PLUGIN_URL . 'assets/images/' .$proNotice['image-link'] ); ?>" />
			</div>
			<div class="atc-nerd-box-title">
				<?php Utils::print_unescaped_internal_string( $proNotice['title'] ); ?>
			</div>
			<div class="atc-nerd-box-message">
				<?php Utils::print_unescaped_internal_string( $proNotice['message'] ); ?> <br/><br/>
				<p style="font-size:10px">[Note: Pro version Comming Soon please contact to email]</p>
			</div><br/>
			<a href="<?php echo esc_url( ( $proNotice['link'] ) ); ?>" class="atc-nerd-box-link atc-button atc-button-default atc-button-go-pro" target="_blank">
				<?php echo esc_html__( 'Upgrade Now', 'advanced-slider-for-elementor' ); ?>
			</a>
		</div>
	<?php
		return ob_get_clean();
	}

    protected function get_rating() {
		$settings = $this->get_settings_for_display();
		$rating_scale = (int) $settings['atc_pro_rating_scale'];
		$rating = (float) $settings['atc_pro_rating'] > $rating_scale ? $rating_scale : $settings['atc_pro_rating'];

		return [ $rating, $rating_scale ];
	}

    protected function render_stars( $icon ) {
		$rating_data = $this->get_rating();
		$rating = (float) $rating_data[0];
		$floored_rating = floor( $rating );
		$stars_html = '';

		for ( $stars = 1.0; $stars <= $rating_data[1]; $stars++ ) {
			if ( $stars <= $floored_rating ) {
				$stars_html .= '<i class="elementor-star-full">' . $icon . '</i>';
			} elseif ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
				$stars_html .= '<i class="elementor-star-' . ( $rating - $floored_rating ) * 10 . '">' . $icon . '</i>';
			} else {
				$stars_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
			}
		}

		return $stars_html;
	}


    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if ( $settings['atc_list'] ) {
            echo $this->html($settings);
            wp_enqueue_style( 'atc-elementor-frontend', ATC_PLUGIN_URL. 'assets/css/atc-frontend.min.css');
        }
    }


    public function html($settings)
    {   
        $imageDisplay = true;
        $authorNameDisplay = true;
        $companyNameDisplay = true;
        $ratingDisplay = true;
        $stars_element = '';
        $loop = ( $settings['atc_testimonial_loop'] ===  'yes' ) ? 'true' : 'false';
        $autoplay = ( $settings['atc_testimonial_autoplay'] ===  'yes' ) ? 'true' : 'false';
        
	    $this->add_render_attribute( 
			'atc_options', 
			[   
                'id'    => 'atc-testimonial-carousel-' . intval( $this->get_id() ),
                'class' => ['swiper-container atc-testimonial-container atc-testimonial-slider-'.$settings["atc_layout"]],
                'data-loop' => $loop,
                'data-autoplay' => $autoplay,
                'data-slider-speed' => $settings['atc_testimonial_slide_speed'],
                'data-pagination' => '.swiper-pagination',
                'data-button-next' => '.swiper-button-next',
                'data-button-prev' => '.swiper-button-prev',
            ]
        );

        if (defined('ATCPRO')) {
            $imageDisplay       = $settings['atc_image_display'];
            $authorNameDisplay  = $settings['atc_author_name_display'];
            $companyNameDisplay = $settings['atc_company_name_display'];
            $ratingDisplay      = $settings['atc_rating_display'];

            $rating_data = $this->get_rating();
            $textual_rating = $rating_data[0] . '/' . $rating_data[1];
            $icon = '&#xE934;';

            if ( 'star_fontawesome' === $settings['atc_pro_star_style'] ) {
                if ( 'outline' === $settings['atc_pro_unmarked_star_style'] ) {
                    $icon = '&#xE933;';
                }
            } elseif ( 'star_unicode' === $settings['atc_pro_star_style'] ) {
                $icon = '&#9733;';

                if ( 'outline' === $settings['atc_pro_unmarked_star_style'] ) {
                    $icon = '&#9734;';
                }
            }

            $this->add_render_attribute( 'atc_icon_wrapper', [
                'class' => 'elementor-star-rating',
                'title' => $textual_rating,
                'itemtype' => 'http://schema.org/Rating',
                'itemscope' => '',
                'itemprop' => 'reviewRating',
            ] );

            $schema_rating = '<span itemprop="ratingValue" class="elementor-screen-only">' . $textual_rating . '</span>';
            $stars_element = '<div ' . $this->get_render_attribute_string( 'atc_icon_wrapper' ) . '>' . $this->render_stars( $icon ) . ' ' . $schema_rating . '</div>';
        }
    ?>
        <div <?php echo $this->get_render_attribute_string( 'atc_options' ); ?>>
            <div class="swiper-wrapper">
                <?php foreach (  $settings['atc_list'] as $item ) : ?>
                    <div class="swiper-slide atc-slider">
                        <?php if ($imageDisplay): ?>
                            <div class="author-img atc-image-align-'<?php echo $settings['atc_image_text_align']; ?>">
                                <img src="<?php echo esc_url($item['atc_image']['url']); ?>" alt="<?php echo esc_html($item['atc_name']); ?>"/>
                            </div>
                        <?php endif; ?>
                        <div class="description"> 
                            <p class="content">
                                <?php echo esc_html($item['atc_content']); ?>
                            </p>
                            
                            <?php if ($authorNameDisplay): ?> 
                                <h4 class="author-name">
                                    <?php echo esc_html($item['atc_name']); ?>
                                </h4>
                            <?php endif; ?>

                            <?php if ($companyNameDisplay): ?> 
                                <p class="company">
                                    <?php echo esc_html($item['atc_title']); ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($ratingDisplay): ?> 
                                <?php echo $stars_element; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php 
                if ( 'yes' === $settings['atc_testimonial_nav'] ) {
                    echo wp_kses_post('<div class="swiper-button-next"></div> <div class="swiper-button-prev"></div>');
                }
                if ( 'yes' === $settings['atc_testimonial_dots'] ) {
                    echo wp_kses_post('<div class="swiper-pagination"></div>');
                }
            ?>
        </div>
        <?php
    }

   


    /**
	 * Render element output in the editor.
	 *
	 * Used to generate the live preview, using a Backbone JavaScript template.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {}

} 