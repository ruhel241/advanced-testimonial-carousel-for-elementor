<?php

namespace ATC\Classes\Widgets;

use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
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
			'link' => esc_url("https://wpcreativeidea.com/testimonial")
		];

        $this->start_controls_section(
			'atc_widget_content_section',
			[
				'label' => esc_html__( 'Testimonial Carousel', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            // repeater start
            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'atc_image', [
                    'label' => esc_html__( 'Choose Image', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'dynamic' => [
                        'active' => true,
                    ]
                ]
            );

            $repeater->add_control(
                'atc_name', [
                    'label' => esc_html__( 'Name', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'John Doe' , 'advanced-testimonial-carousel-for-elementor' ),
                    'label_block' => true,
                    'dynamic' => [
                        'active' => true,
                    ]
                ]
            );

            $repeater->add_control(
                'atc_title', [
                    'label' => esc_html__( 'Designation', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'CEO' , 'advanced-testimonial-carousel-for-elementor' ),
                    'label_block' => true,
                    'dynamic' => [
                        'active' => true,
                    ]
                ]
            );

            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->WYSIWYGEditor($repeater);
            } else {
                $repeater->add_control(
                    'atc_content', [
                        'label' => esc_html__( 'Content', 'advanced-testimonial-carousel-for-elementor' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => "<p>". esc_html__( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio' , 'advanced-testimonial-carousel-for-elementor' )."</p>",
                        'label_block' => true,
                        'dynamic' => [
                            'active' => true
                        ]
                    ]
                );
            }   
           
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->ratingOptionsPro($repeater);
            } else {
                $repeater->add_control(
                    'atc_important_notice_rating_options',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->getProNotice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'repeater-features-options.jpg'
                        ] ),
                    ]
                );
            }

          $this->add_control(
              'atc_list',
              [
                  'label' => esc_html__( 'Repeater List', 'advanced-testimonial-carousel-for-elementor' ),
                  'type' => Controls_Manager::REPEATER,
                  'fields' => $repeater->get_controls(),
                  'default' => [
                      [
                          'atc_content' => "<p>". esc_html__( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio' , 'advanced-testimonial-carousel-for-elementor' )."</p>",
                          'atc_name' => esc_html__( 'John Doe', 'advanced-testimonial-carousel-for-elementor' )
                      ],
                      [
                          'atc_content' => "<p>". esc_html__( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio' , 'advanced-testimonial-carousel-for-elementor' )."</p>",
                          'atc_name' => esc_html__( 'Michael Jackson', 'advanced-testimonial-carousel-for-elementor' )                
                      ],
                      [
                        'atc_content' => "<p>". esc_html__( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio' , 'advanced-testimonial-carousel-for-elementor' )."</p>",
                        'atc_name' => esc_html__( 'Jackson', 'advanced-testimonial-carousel-for-elementor' )                
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
			'atc_quotation_icon_style_section',
			[
				'label' => esc_html__( 'Quotation Icon', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->quotationIconOptions($this);
            } else {
                $this->add_control(
                    'atc_notice_quotation_icon_options',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->getProNotice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'quotation-icon-options.jpg'
                        ] ),
                    ]
                );
            }
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_background_style_section',
			[
				'label' => esc_html__( 'Additional Options', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->additionaloptionsMore($this);
            } else {
                $this->add_control(
                    'atc_important_notice_additional_options',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->getProNotice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'additional-options.jpg'
                        ] ),
                    ]
                );
            } 
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_testimonial_carousel_style',
			[
				'label' => esc_html__( 'Testimonial Carousel', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
            $this->add_control(
                'atc_testimonial_height',
                [
                    'label' => esc_html__( 'Height', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'separator' => 'after',
					'condition' => defined('ATCPRO') ? ['atc_slider_auto_height' => ''] : [],
                ]
            );
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->testimonialBackgroundStyling($this);
            } 
            $this->add_responsive_control(
                'atc_testimonial_margin',
                [
                    'label' => esc_html__( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    // 'default' => [
                    //     'top' => 0,
                    //     'right' => 16,
                    //     'bottom' => 0,
                    //     'left' => 16,
                    //     'unit' => 'px'
                    // ],
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
                        'raw' => $this->getProNotice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'testimonial-background-style.jpg'
                        ] ),
                    ]
                );
            }
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_slider_bg_style',
			[
				'label' => esc_html__( 'Slider Background', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->sliderBackgroundStyling($this);
            } else {
                $this->add_control(
                    'atc_notice_slider_bg_style',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->getProNotice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'slider-background-style.jpg'
                        ] ),
                    ]
                );
            }
		$this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_image_style_section',
			[
				'label' => esc_html__( 'Image', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_image_display' => 'yes'] : []
			]
        );
            $this->add_control(
                'atc_image_text_align',
                [
                    'label' => esc_html__( 'Alignment', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'width', 'advanced-testimonial-carousel-for-elementor' ),
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
                    // 'default' => [
                    //     'unit' => 'px',
                    //     'size' => 150,
                    // ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .author-img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'atc_image_height',
                [
                    'label' => esc_html__( 'Height', 'advanced-testimonial-carousel-for-elementor' ),
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
                    // 'default' => [
                    //     'unit' => 'px',
                    //     'size' => 150,
                    // ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .author-img' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->imageStylingOptions($this);
            }
            $this->add_responsive_control(
                'atc_image_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    // 'default' => [
                    //     'unit' => '%',
                    //     'top' => 100,
                    //     'right' => 100,
                    //     'bottom' => 100,
                    //     'left' => 100,
                    // ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .author-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'after'
                ]
            );
            $this->add_responsive_control(
                'atc_image_margin',
                [
                    'label' => esc_html__( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
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
                        'raw' => $this->getProNotice( [
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
				'label' => esc_html__( 'Content', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
            $this->add_control(
                'atc_content_text_align',
                [
                    'label' => esc_html__( 'Alignment', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .content p' => 'text-align: {{VALUE}}',
                    ]
                ]
            );
            $this->add_control(
                'atc_widget_content_color',
                [
                    'label' => esc_html__( 'Text Color', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .content p' => 'color: {{VALUE}}',
                    ]
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Typography', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .content p',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'content_shadow',
                    'label' => esc_html__( 'Text Shadow', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .content p',
                ]
            );
            $this->add_responsive_control(
                'atc_image_content_margin',
                [
                    'label' => esc_html__( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'atc_image_content_padding',
                [
                    'label' => esc_html__( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_widget_author_name_style_section',
			[
				'label' => esc_html__( 'Author Name', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_author_name_display' => 'yes'] : []
			]
        );
            $this->add_control(
                'atc_author_name_text_align',
                [
                    'label' => esc_html__( 'Alignment', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'Text Color', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'Typography', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .author-name',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'author_name_shadow',
                    'label' => esc_html__( 'Text Shadow', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .author-name',
                ]
            );
            $this->add_responsive_control(
                'atc_image_author_name_margin',
                [
                    'label' => esc_html__( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
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
				'label' => esc_html__( 'Company Name', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_company_name_display' => 'yes'] : []
            ]
        );
            $this->add_control(
                'atc_company_text_align',
                [
                    'label' => esc_html__( 'Alignment', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'advanced-testimonial-carousel-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'Text Color', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'Typography', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .company',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'author_company_shadow',
                    'label' => esc_html__( 'Text Shadow', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .company',
                ]
            );
            $this->add_responsive_control(
                'atc_image_company_margin',
                [
                    'label' => esc_html__( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
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
                (new ATCWidgetPro)->ratingStylingOptions($this);
            } else {
                $this->add_control(
                    'atc_important_notice_rating_style',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->getProNotice( [
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
			'atc_quotation_section_style_icon',
			[
				'label' => esc_html__( 'Quotation Icon', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->quotationIconStyle($this);
            } else {
                $this->add_control(
                    'atc_notice_quotation_icon_style',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->getProNotice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'quotation-icon-style.jpg'
                        ] ),
                    ]
                );
            }

        $this->end_controls_section();
        
        $this->start_controls_section(
			'atc_nav_section',
			[
				'label' => esc_html__( 'Arrows Icon', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        if (!defined('ATCPRO')) {
            $this->add_control(
                'atc_nav_color',
                [
                    'label' => esc_html__( 'Arrows Color', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .swiper-button-prev::after, {{WRAPPER}} .atc-testimonial-container .swiper-button-next::after' => 'color: {{VALUE}}',
                    ],
                ]
            );
        }
            $this->add_control(
                'atc_nav_size',
                [
                    'label' => esc_html__( 'Arrows Size', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em'],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                    ],
                    // 'default' => [
					// 	'size' => 25,
					// ],
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
                        'raw' => $this->getProNotice( [
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
				'label' => esc_html__( 'Dots Icon', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'atc_dots_color',
			[
				'label' => esc_html__( 'Dots Color', 'advanced-testimonial-carousel-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .atc-testimonial-container .swiper-pagination-bullet-active' => 'background: {{VALUE}}',
				],
			]
        );

        $this->add_control(
            'atc_dots_size',
            [
                'label' => esc_html__( 'Dots Size', 'advanced-testimonial-carousel-for-elementor' ),
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

    public function getProNotice( $proNotice ) {
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
			</div><br/>
			<a href="<?php echo esc_url( ( $proNotice['link'] ) ); ?>" class="atc-nerd-box-link atc-button atc-button-default atc-button-go-pro" target="_blank">
				<?php echo esc_html__( 'Upgrade Now', 'advanced-slider-for-elementor' ); ?>
			</a>
		</div>
	<?php
		return ob_get_clean();
	}

   
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if ( $settings['atc_list'] ) {
            echo esc_html( $this->html($settings) );
        }
    }


    public function html($settings)
    {   
        $dots               = 'yes';
        $arrows             = 'yes';
        $imageDisplay       = 'yes';
        $authorNameDisplay  = 'yes';
        $companyNameDisplay = 'yes';
        $template           = defined('ATCPRO') ? $settings["atc_layout"] : 'template-1';

	    $this->add_render_attribute( 
			'atc_options', 
			[   
                'id'                => 'atc-testimonial-carousel-' . intval( $this->get_id() ),
                'class'             => ['swiper-container atc-testimonial-container atc-testimonial-slider-'.$template],
                'data-pagination'   => '.swiper-pagination',
                'data-button-next'  => '.swiper-button-next',
                'data-button-prev'  => '.swiper-button-prev',
            ]
        );

        if (defined('ATCPRO')) {
            $template           = $settings["atc_layout"];
            $loop               = ($settings['atc_testimonial_loop'] ===  'yes' ) ? 'true' : 'false';
			$autoPlay           = ($settings['atc_testimonial_autoplay'] ===  'yes' ) ? 'true' : 'false';
            $arrows             = $settings['atc_testimonial_nav'];
            $dots               = $settings['atc_testimonial_dots'];
            $autoHeight         = ($settings['atc_slider_auto_height'] ===  'yes' ) ? 'true' : 'false';
            $sliderPerView      = $settings['atc_slider_per_view'];
            $sliderPerGroup     = $settings['atc_slider_per_group'];
            $sliderSpaceBetween = $settings['atc_slider_space_between']['size'];
            $imageDisplay       = $settings['atc_image_display'];
            $authorNameDisplay  = $settings['atc_author_name_display'];
            $companyNameDisplay = $settings['atc_company_name_display'];
            $ratingDisplay      = $settings['atc_rating_display'];
            $quotationDisplay   = $settings['atc_quotation_display'];
            $sliderSpeed        = $settings['atc_testimonial_slide_speed'];

            $this->add_render_attribute( 
                'atc_options', 
                [   
                    'data-loop'                 => $loop,
                    'data-autoplay'             => $autoPlay,
                    'data-auto-height'          => $autoHeight,
                    'data-slider-per-view'      => $sliderPerView,
                    'data-slider-per-group'     => $sliderPerGroup,
                    'data-slider-space-between' => $sliderSpaceBetween,
                    'data-slider-speed'         => $sliderSpeed,
                ]
            );
        }
    ?>
       
        <div <?php echo wp_kses_post($this->get_render_attribute_string( 'atc_options' )); ?>>
            <div class="swiper-wrapper">
                <?php foreach (  $settings['atc_list'] as $item ) : ?>
                    <?php if ($template == 'template-6') : ?>
                        <div class="swiper-slide atc-slider">
                            <div class="description"> 
                                <div class="content">
                                    <?php 
                                        if (defined('ATCPRO') && ('yes' === $quotationDisplay) ) {
                                            (new ATCWidgetPro)->quotationIconRender($this);
                                        }
                                        echo wp_kses_post($item['atc_content']);
                                    ?>
                                </div>

                                <div class="bio-information">
                                    <?php if ('yes' === $imageDisplay): ?>
                                        <div class="author-img atc-image-align-<?php echo esc_attr($settings['atc_image_text_align']); ?>">
                                            <img src="<?php echo esc_url($item['atc_image']['url']); ?>" alt="<?php echo esc_attr($item['atc_name']); ?>"/>
                                        </div>
                                    <?php endif; ?>
                                
                                    <div class="info">
                                        <?php if ('yes' === $authorNameDisplay): ?> 
                                            <h4 class="author-name">
                                                <?php echo esc_html($item['atc_name']); ?>
                                            </h4>
                                        <?php endif; ?>

                                        <?php if ('yes' === $companyNameDisplay): ?> 
                                            <p class="company">
                                                <?php echo esc_html($item['atc_title']); ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php 
                                            if ( defined('ATCPRO') && ('yes' === $ratingDisplay) ):
                                                (new ATCWidgetPro)->ratingRender($item, $this); 
                                            endif; 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="swiper-slide atc-slider">
                            <?php if ('yes' === $imageDisplay): ?>
                                <div class="author-img atc-image-align-<?php echo esc_attr($settings['atc_image_text_align']); ?>">
                                    <img src="<?php echo esc_url($item['atc_image']['url']); ?>" alt="<?php echo esc_attr($item['atc_name']); ?>"/>
                                </div>
                            <?php endif; ?>
                            <div class="description"> 
                                <div class="content">
                                    <?php 
                                        if (defined('ATCPRO') && ('yes' === $quotationDisplay) ) {
                                            (new ATCWidgetPro)->quotationIconRender($this);
                                        }
                                        echo wp_kses_post($item['atc_content']);
                                    ?>
                                </div>
                                
                                <?php if ('yes' === $authorNameDisplay): ?> 
                                    <h4 class="author-name">
                                        <?php echo esc_html($item['atc_name']); ?>
                                    </h4>
                                <?php endif; ?>

                                <?php if ('yes' === $companyNameDisplay): ?> 
                                    <p class="company">
                                        <?php echo esc_html($item['atc_title']); ?>
                                    </p>
                                <?php endif; ?>

                                <?php 
                                    if ( defined('ATCPRO') && ('yes' === $ratingDisplay) ):
                                        (new ATCWidgetPro)->ratingRender($item, $this); 
                                    endif; 
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php 
                if ( 'yes' === $arrows ) {
                    echo wp_kses_post('<div class="swiper-button-next"></div> <div class="swiper-button-prev"></div>');
                }
                if ( 'yes' === $dots ) {
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