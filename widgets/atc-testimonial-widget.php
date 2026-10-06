<?php

namespace ATCFE\Classes\Widgets;

use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use ATCPRO\Services\ATCWidgetPro; 
use ATCFE\Models\GoogleReviews;
use ATCFE\Models\GooglePlaces;

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
        require_once ATCFE_PLUGIN_DIR_PATH . 'app/Models/GooglePlaces.php';

        // get google reviews from database
        $GooglePlaces = new GooglePlaces();
        $places       = $GooglePlaces->getPlaces();
        $customReviewsCondition = [];
        $googleReviewsCondition = [];

        if (defined('ATCPRO')) {
            $customReviewsCondition = ['atc_custom_reviews_show_option' => 'yes'];
            $googleReviewsCondition = ['atc_google_reviews_show_option' => 'yes'];
        }

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
            // elementor reviews repeater start 
            $this->add_control(
                'atc_custom_reviews_heading',
                [
                    'type' => Controls_Manager::HEADING,
                    'label' => esc_html__( 'Custom Reviews', 'advanced-testimonial-carousel-for-elementor' ),
                    'condition' => $customReviewsCondition,
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
            $repeater->add_control(
                'atc_date',
                [
                    'label' => esc_html__(
                        'Date',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                    'type' => Controls_Manager::DATE_TIME,
                    'default' => '',
                    'label_block' => true,
            
                    'picker_options' => [
                        'maxDate' => 'today',
                    ],
            
                    'dynamic' => [
                        'active' => true,
                    ],
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
                            'image-link' => 'repeater-features-options.png'
                        ] ),
                    ]
                );
            }

          $this->add_control(
              'atc_list',
              [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'condition' => $customReviewsCondition,
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
                    [
                        'atc_content' => "<p>". esc_html__( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio' , 'advanced-testimonial-carousel-for-elementor' )."</p>",
                        'atc_name' => esc_html__( 'William Smith', 'advanced-testimonial-carousel-for-elementor' )                
                    ],
                    [
                        'atc_content' => "<p>". esc_html__( 'Lorem ipsum dolor sit amet, tpat dictum purus, at malesuada tellus convallis et. Aliquam erat volutpat. Vestibulum felis ex, ultrices posuere facilisis eget, malesuada quis elit. Nulla ac eleifend odio' , 'advanced-testimonial-carousel-for-elementor' )."</p>",
                        'atc_name' => esc_html__( 'Thomas Davis', 'advanced-testimonial-carousel-for-elementor' )                
                    ],
                ],
                'title_field' => '{{{ atc_name }}}'
              ]
          );
          // repeater end
            
            // google reviews options start
            $this->add_control(
                'atc_google_reviews_heading',
                [
                    'type' => Controls_Manager::HEADING,
                    'label' => esc_html__( 'Google Reviews', 'advanced-testimonial-carousel-for-elementor' ),
                    'separator' => 'before',
                    'condition' => $googleReviewsCondition,
                ]
            );
           
            $place_options = [
                '' => esc_html__(
                    'Choose Place',
                    'advanced-testimonial-carousel-for-elementor'
                ),
            ];
            
            foreach ( $places as $place ) {
                $place_options[ $place->place_id ] = $place->name;
            }
            
            $this->add_control(
                'atc_google_reviews_place_id',
                [
                    'label'   => esc_html__(
                        'Select Place',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => $place_options,
                    'default' => '',
                    'condition' => $googleReviewsCondition,
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
                            'image-link' => 'quotation-icon-options.png'
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
                            'image-link' => 'additional-options.png'
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
            $this->add_responsive_control(
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
                            'image-link' => 'testimonial-background-style.png'
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
                            'image-link' => 'slider-background-style.png'
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
            $this->add_responsive_control(
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
            $this->add_responsive_control(
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
            $this->add_responsive_control(
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
                            'image-link' => 'image-style.png'
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
            $this->add_responsive_control(
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
                        '{{WRAPPER}} .atc-testimonial-container .content' => 'text-align: {{VALUE}}',
                    ]
                ]
            );
            $this->add_control(
                'atc_widget_content_color',
                [
                    'label' => esc_html__( 'Text Color', 'advanced-testimonial-carousel-for-elementor' ),
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
                    'label' => esc_html__( 'Typography', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .content',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'content_shadow',
                    'label' => esc_html__( 'Text Shadow', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .content',
                ]
            );
            $this->add_responsive_control(
                'atc_content_margin',
                [
                    'label' => esc_html__( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'atc_content_padding',
                [
                    'label' => esc_html__( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
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
				'label' => esc_html__( 'Author Name', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_author_name_display' => 'yes'] : []
			]
        );
            $this->add_responsive_control(
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
                'atc_author_name_margin',
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
                'atc_author_name_padding',
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
            $this->add_responsive_control(
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

        // Date styles
        $this->start_controls_section(
			'atc_widget_date_style_section',
			[
				'label' => esc_html__( 'Date', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_date_display' => 'yes'] : []
			]
        );
            $this->add_responsive_control(
                'atc_date_text_align',
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
                        '{{WRAPPER}} .atc-testimonial-container .description .date' => 'text-align: {{VALUE}}',
                    ]
                ]
            );
            $this->add_control(
                'atc_widget_date_color',
                [
                    'label' => esc_html__( 'Text Color', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .description .date' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'date_typography',
                    'label' => esc_html__( 'Typography', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .date',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'date_shadow',
                    'label' => esc_html__( 'Text Shadow', 'advanced-testimonial-carousel-for-elementor' ),
                    'selector' => '{{WRAPPER}} .atc-testimonial-container .description .date',
                ]
            );
            $this->add_responsive_control(
                'atc_date_margin',
                [
                    'label' => esc_html__( 'Margin', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .description .date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'atc_date_padding',
                [
                    'label' => esc_html__( 'Padding', 'advanced-testimonial-carousel-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .atc-testimonial-container .description .date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'image-link' => 'rating-style.png'
                        ] ),
                    ]
                );
            }
        $this->end_controls_section();

        $this->start_controls_section(
			'atc_google_review_heading_total_style_section',
			[
				'label' => esc_html__( 'Google Heading Ratings', 'advanced-testimonial-carousel-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => defined('ATCPRO') ? ['atc_google_review_heading_total_rating' => 'yes'] : []
			]
        );
            if (defined('ATCPRO')) {
                (new ATCWidgetPro)->googleHeadingTotalRatingStyle($this);
            } else {
                $this->add_control(
                    'atc_important_notice_heading_total_rating_style',
                    [
                        'type' => Controls_Manager::RAW_HTML,
                        'raw' => $this->getProNotice( [
                            'title' => $proNotice['title'],
                            'message' => $proNotice['message'],
                            'link' => $proNotice['link'],
                            'image-link' => 'google-total-rating-style.png'
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
                            'image-link' => 'quotation-icon-style.png'
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
            $this->add_responsive_control(
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
                            'image-link' => 'arrows-style.png'
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

        $this->add_responsive_control(
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
        $this->add_responsive_control(
			'ase_dots_position',
			[
				'label' => esc_html__( 'Dots Position', 'advanced-testimonial-carousel-for-elementor' ),
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
				<img class="atc-nerd-box-icon" src="<?php echo esc_url( ATCFE_PLUGIN_URL . 'assets/images/' .$proNotice['image-link'] ); ?>" />
			</div>
			<div class="atc-nerd-box-title">
				<?php Utils::print_unescaped_internal_string( $proNotice['title'] ); ?>
			</div>
			<div class="atc-nerd-box-message">
				<?php Utils::print_unescaped_internal_string( $proNotice['message'] ); ?> <br/><br/>
			</div><br/>
			<a href="<?php echo esc_url( ( $proNotice['link'] ) ); ?>" class="atc-nerd-box-link atc-button atc-button-default atc-button-go-pro" target="_blank">
				<?php echo esc_html__( 'Upgrade Now', 'advanced-testimonial-carousel-for-elementor' ); ?>
			</a>
		</div>
	<?php
		return ob_get_clean();
	}

   
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $customReviewsDisplay = "yes";
        $googleReviewsDisplay = 'yes';

        if (defined( 'ATCPRO' )) {
            $customReviewsDisplay = $settings['atc_custom_reviews_show_option'];
            $googleReviewsDisplay = $settings['atc_google_reviews_show_option'];
        }

        if ( $customReviewsDisplay === 'yes' || $googleReviewsDisplay === 'yes') {
            $this->html( $settings );
            return;
        }

        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            echo '<div class="atc-empty-testimonial">';
            echo esc_html__(
                'Please enable Custom Reviews or Google Reviews.',
                'advanced-testimonial-carousel-for-elementor'
            );
            echo '</div>';
        }
    }


    public function html( $settings )
    {
        $dots                     = 'yes';
        $arrows                   = 'yes';
        $imageDisplay             = 'yes';
        $authorNameDisplay        = 'yes';
        $companyNameDisplay       = 'yes';
        $dateDisplay              = 'yes';
        $googlePlacesTotalReviews = '';
        $headingTotalRating       = '';
        $assetsImagesURL          = ATCFE_PLUGIN_URL.'assets/images/';
        $googleLogoDisplay        = '';
        $customReviewsDisplay     = 'yes';
        $googleReviewsDisplay     = 'yes';

        $template = defined( 'ATCPRO' ) ? ( $settings['atc_layout'] ?? 'template-1' ) : 'template-1';

        /*
        * Slider attributes.
        */
        $this->add_render_attribute(
            'atc_options',
            [
                'id'              => 'atc-testimonial-carousel-' . intval( $this->get_id() ),
                'class'           => [
                    'swiper-container',
                    'atc-testimonial-container',
                    'atc-testimonial-slider-' . sanitize_html_class( $template ),
                ],
                'data-pagination'  => '.swiper-pagination',
                'data-button-next' => '.swiper-button-next',
                'data-button-prev' => '.swiper-button-prev',
            ]
        );

        /*
        * Pro settings.
        */
        if ( defined( 'ATCPRO' ) ) {
            $template           = $settings['atc_layout'] ?? 'template-1';
            $loop               = ( ( $settings['atc_testimonial_loop'] ?? '' ) === 'yes') ? 'true' : 'false';
            $autoPlay           = ( ( $settings['atc_testimonial_autoplay'] ?? '' ) === 'yes' ) ? 'true' : 'false';
            $arrows             = $settings['atc_testimonial_nav'] ?? 'yes';
            $dots               = $settings['atc_testimonial_dots'] ?? 'yes';
            $autoHeight         = (( $settings['atc_slider_auto_height'] ?? '' ) === 'yes') ? 'true' : 'false';
            $sliderPerView      = empty($settings['atc_slider_per_view']) ? '1': $settings['atc_slider_per_view'];
            $sliderPerGroup     = $settings['atc_slider_per_group'] ?? 1;
            $sliderSpaceBetween = $settings['atc_slider_space_between'] ?? 30;
            $imageDisplay       = $settings['atc_image_display'] ?? 'yes';
            $authorNameDisplay  = $settings['atc_author_name_display'] ?? 'yes';
            $companyNameDisplay = $settings['atc_company_name_display'] ?? 'yes';
            $dateDisplay        = $settings['atc_date_display'] ?? 'yes';
            $ratingDisplay      = $settings['atc_rating_display'] ?? 'yes';
            $quotationDisplay   = $settings['atc_quotation_display'] ?? 'yes';
            $sliderSpeed        = $settings['atc_testimonial_slide_speed'] ?? 300;
            $reviewsLimit       = $settings['atc_reviews_limit'] ?? '';
            $headingTotalRating = $settings['atc_google_review_heading_total_rating'] ?? '';
            $googleLogoDisplay  = $settings['atc_google_logo_display'] ?? '';
            $customReviewsDisplay = $settings['atc_custom_reviews_show_option'];
            $googleReviewsDisplay = $settings['atc_google_reviews_show_option'];


            // dafault if template-7
            if ( ($template == 'template-7' || $template == 'template-8') && empty($settings['atc_slider_per_view']) ) {
                $sliderPerView  = '3';
                $sliderSpaceBetween = 25;
            }
           
            $this->add_render_attribute(
                'atc_options',
                [
                    'data-loop'                 => esc_attr( $loop ),
                    'data-autoplay'             => esc_attr( $autoPlay ),
                    'data-auto-height'          => esc_attr( $autoHeight ),
                    'data-slider-per-view'      => esc_attr( $sliderPerView ),
                    'data-slider-per-group'     => esc_attr( $sliderPerGroup ),
                    'data-slider-space-between' => esc_attr( $sliderSpaceBetween ),
                    'data-slider-speed'         => esc_attr( $sliderSpeed ),
                ]
            );
        }

        /*
        * Custom Reviews.
        */
        $reviews = [];

        /*
        * Custom Elementor reviews.
        */
        if ( $customReviewsDisplay  === 'yes' ) {
            $reviews = $settings['atc_list'] ?? [];

            if ( ! is_array( $reviews ) ) {
                $reviews = [];
            }
        }

        /*
        * Google Reviews.
        */
        if ( $googleReviewsDisplay === 'yes' ) {
            require_once ATCFE_PLUGIN_DIR_PATH . 'app/Models/GoogleReviews.php';
            require_once ATCFE_PLUGIN_DIR_PATH . 'app/Models/GooglePlaces.php';
        
            $googleReviews = new GoogleReviews();
            $GooglePlaces  = new GooglePlaces();
            $place        = [];
        
            $place_id = sanitize_text_field( $settings['atc_google_reviews_place_id'] ?? '' );
        
            $googleReviewsData = [];
        
            if ( ! empty( $place_id ) ) {

                $params = [
                    'place_id' =>  $place_id,
                    'rating'   =>  sanitize_text_field( $settings['atc_google_reviews_min_rating'] ?? '' ),
                    'sort'     =>  sanitize_text_field( $settings['atc_google_reviews_sort'] ?? '' ),
                    'date_sort'=> sanitize_text_field( $settings['atc_google_reviews_date_sort'] ?? ''),
                ];
        
                $googleReviewsData = $googleReviews->getGoogleReviews( $params );
        
                if ( ! is_array( $googleReviewsData ) ) {
                    $googleReviewsData = [];
                }    

                $place = $GooglePlaces->getPlaceId($place_id);
            }
        
            $googleReviewsData = array_map(
                function ( $review ) {
                    $review = (array) $review;
                    return [
                        'atc_content' => wp_kses_post( $review['review_text'] ?? '' ),
                        'atc_name' => sanitize_text_field( $review['author_name'] ?? '' ),
                        '_id' => sanitize_text_field(  $review['review_id'] ?? '' ),
                        'atc_title' => '',
                        'atc_date'  => sanitize_text_field(  $review['review_time'] ?? '' ),
                        'atc_image' => [
                            'url' => esc_url_raw(
                                $review['author_photo'] ?? ''
                            ),
                            'id'   => '',
                            'size' => '',
                        ],
                        'atc_pro_rating_scale' => 5,
                        'atc_pro_rating' => (float) ( $review['rating'] ?? 0 ),
                        'atc_pro_star_style' => 'star_fontawesome',
                        'atc_pro_unmarked_star_style' => 'solid',
                    ];
                },
                $googleReviewsData
            );

            /*
                * Google Reviews Position.
            */
            $googleReviewsPosition = sanitize_key( $settings['atc_google_reviews_position'] ?? 'after' );

            if ( 'before' === $googleReviewsPosition ) {
                $reviews = array_merge( $googleReviewsData, $reviews );
            } else {
                $reviews = array_merge( $reviews, $googleReviewsData );
            }
        }

        /*
        * Remove completely empty reviews.
        *
        * This is useful if Elementor repeater contains
        * empty/default items.
        */
        $reviews = array_filter( $reviews, function ( $item ) {
                return ! empty( $item['atc_content'] ) || ! empty( $item['atc_name'] );
            }
        );

        /*
        * Limit Google Reviews.
        */
        if ( ! empty( $reviewsLimit ) ) {
            $reviewsLimit = absint( $reviewsLimit );

            if ( $reviewsLimit > 0 ) {
                $reviews = array_slice( $reviews, 0, $reviewsLimit );
            }
        }

        /*
        * Re-index array.
        */
        $reviews = array_values( $reviews );

        /*
        * Empty reviews message.
        */
        if ( empty( $reviews ) ) {
            echo '<div class="atc-empty-testimonial">';
            echo esc_html__(
                'No reviews found. Please add a custom review or select a Google Place with reviews.',
                'advanced-testimonial-carousel-for-elementor'
            );
            echo '</div>';
            return;
        }

        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor escapes render attributes via get_render_attribute_string().
        $render_attributes = $this->get_render_attribute_string( 'atc_options' );

        ?>
      
        <div <?php echo $render_attributes; ?>>
            <?php if ( $headingTotalRating === 'yes' && !empty( $place_id ) ): ?>
                <div class="atc-google-reviews-ratings">
                    <h2 class="title">Google Reviews ⭐ 
                        <?php 
                            echo esc_html($place->rating); 
                        ?>
                    </h2>
                </div>
            <?php endif; ?>
            
            <div class="swiper-wrapper">
                <?php foreach ( $reviews as $item ) : ?>
                    <?php
                    /*
                    * Safe values.
                    */
                    $content = $item['atc_content'] ?? '';
                    $name    = $item['atc_name'] ?? '';
                    $title   = $item['atc_title'] ?? '';
                    $date    = $item['atc_date'] ?? '';

                    $image_url = '';

                    if ( isset( $item['atc_image'] ) && is_array( $item['atc_image'] ) ) {
                        $image_url = $item['atc_image']['url'] ?? '';
                    }

                    $image_align = sanitize_html_class( $settings['atc_image_text_align'] ?? '' );
                    ?>

                    <?php if ( 'template-6' === $template || 'template-7' === $template || 'template-8' === $template ) : ?>
                        <div class="swiper-slide atc-slider">
                            <div class="description">
                                <div class="content">

                                    <?php

                                    if ( defined( 'ATCPRO' ) && 'yes' === $quotationDisplay && ! empty( $content ) ) {
                                        ( new ATCWidgetPro() )->quotationIconRender( $this );
                                    }

                                    // Content limit
                                    $content_limit = 30; // Number of words

                                    // Create short content
                                    $short_content = wp_trim_words(
                                        wp_strip_all_tags( $content ),
                                        $content_limit,
                                        '...'
                                    );

                                    ?>

                                    <div class="atc-content-short">
                                        <?php echo esc_html( $short_content ); ?>
                                    </div>

                                    <div class="atc-content-full" style="display: none;">
                                        <?php echo wp_kses_post( $content ); ?>
                                    </div>

                                    <?php if ( str_word_count( wp_strip_all_tags( $content ) ) > $content_limit ) : ?>
                                        <button type="button" class="atc-read-more-btn">
                                            <?php esc_html_e( '[Read More...]', 'advanced-testimonial-carousel-for-elementor' ); ?>
                                        </button>

                                        <button type="button" class="atc-less-btn" style="display:none;">
                                            <?php esc_html_e( '[Less..]', 'advanced-testimonial-carousel-for-elementor' ); ?>
                                        </button>
                                    <?php endif; ?>
                                

                                    <?php

                                    if ( defined( 'ATCPRO' ) && 'yes' === $quotationDisplay && ! empty( $content ) ) {
                                        ( new ATCWidgetPro() )->quotationRightIconRender( $this );
                                    }

                                    ?>
                                </div>
                                <div class="bio-information">
                                    <?php if ( 'yes' === $imageDisplay ) : ?>
                                        <div class="author-img atc-image-align-<?php echo esc_attr( $image_align ); ?>">
                                            <img
                                                src="<?php echo esc_url( $image_url ); ?>"
                                                alt="<?php echo esc_attr( $name ); ?>"
                                            />
                                        </div>
                                    <?php endif; ?>
                                    <div class="info">
                                        <?php if ( 'yes' === $authorNameDisplay ) : ?>
                                            <h4 class="author-name">
                                                <?php echo esc_html( $name ); ?>
                                            </h4>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $date ) && 'yes' === $dateDisplay ) : ?>
                                            <?php
                                                $timestamp = strtotime( $date );
                                                if ( $timestamp && $timestamp <= time() ) :
                                                    $date_text = human_time_diff( $timestamp, time() ) . ' ago';
                                            ?>
                                                <span class="date">
                                                    <?php echo esc_html( $date_text ); ?>
                                                </span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ( 'yes' === $companyNameDisplay ) : ?>
                                            <p class="company">
                                                <?php echo esc_html( $title ); ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php
                                            if ( defined( 'ATCPRO' ) && 'yes' === $ratingDisplay ) {
                                                ( new ATCWidgetPro() )->ratingRender( $item, $this );
                                            }
                                        ?>
                                    </div>
                                    <?php if ( $googleLogoDisplay === 'yes' && !empty( $place_id ) ): ?>
                                        <div class="atc-google-image">
                                            <img
                                                    src="<?php echo esc_url( $assetsImagesURL . 'google-icon.png' ); ?>"
                                                    alt="Google"
                                                >
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="swiper-slide atc-slider">
                            <?php if ( 'yes' === $imageDisplay ) : ?>
                                <div class="author-img atc-image-align-<?php echo esc_attr( $image_align ); ?>">
                                    <img
                                        src="<?php echo esc_url( $image_url ); ?>"
                                        alt="<?php echo esc_attr( $name ); ?>"
                                    />
                                </div>
                            <?php endif; ?>
                                <div class="description">
                                    <div class="content">

                                        <?php

                                        if ( defined( 'ATCPRO' ) && 'yes' === $quotationDisplay && ! empty( $content ) ) {
                                            ( new ATCWidgetPro() )->quotationIconRender( $this );
                                        }

                                        // Content limit
                                        $content_limit = 30; // Number of words

                                        // Create short content
                                        $short_content = wp_trim_words(
                                            wp_strip_all_tags( $content ),
                                            $content_limit,
                                            '...'
                                        );

                                        ?>

                                        <div class="atc-content-short">
                                            <?php echo esc_html( $short_content ); ?>
                                        </div>

                                        <div class="atc-content-full" style="display: none;">
                                            <?php echo wp_kses_post( $content ); ?>
                                        </div>

                                        <?php if ( str_word_count( wp_strip_all_tags( $content ) ) > $content_limit ) : ?>
                                            <button type="button" class="atc-read-more-btn">
                                                <?php esc_html_e( '[Read More...]', 'advanced-testimonial-carousel-for-elementor' ); ?>
                                            </button>

                                            <button type="button" class="atc-less-btn" style="display:none;">
                                                <?php esc_html_e( '[Less..]', 'advanced-testimonial-carousel-for-elementor' ); ?>
                                            </button>
                                        <?php endif; ?>


                                        <?php

                                        if ( defined( 'ATCPRO' ) && 'yes' === $quotationDisplay && ! empty( $content ) ) {
                                            ( new ATCWidgetPro() )->quotationRightIconRender( $this );
                                        }

                                        ?>

                                    </div>

                                    <?php if ( 'yes' === $authorNameDisplay ) : ?>
                                        <h4 class="author-name">
                                            <?php 
                                                echo esc_html( $name ); 
                                            ?>
                                        </h4>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $date ) && 'yes' === $dateDisplay ) : ?>
                                        <?php
                                            $timestamp = strtotime( $date );
                                            if ( $timestamp && $timestamp <= time() ) :
                                                $date_text = human_time_diff( $timestamp, time() ) . ' ago';
                                        ?>
                                            <span class="date">
                                                <?php echo esc_html( $date_text ); ?>
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if ( 'yes' === $companyNameDisplay && !empty($title) ) : ?>
                                        <p class="company">
                                            <?php echo esc_html( $title ); ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php
                                    if ( defined( 'ATCPRO' ) && 'yes' === $ratingDisplay ) {
                                        ( new ATCWidgetPro() )->ratingRender( $item, $this );
                                    }
                                    ?>
                                </div>
                            <?php if ( $googleLogoDisplay === 'yes' && !empty( $place_id ) ): ?>
                                <div class="atc-google-image">
                                <img
                                        src="<?php echo esc_url( $assetsImagesURL . 'google-icon.png' ); ?>"
                                        alt="Google"
                                    >
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <?php if ( 'yes' === $arrows ) : ?>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            <?php endif; ?>

            <?php if ( 'yes' === $dots ) : ?>
                <div class="swiper-pagination"></div>
            <?php endif; ?>
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