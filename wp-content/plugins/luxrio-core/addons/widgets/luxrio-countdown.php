<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
/**
 *
 * Countdown Box Widget .
 *
 */

class Luxrio_Countdown_Box extends Widget_Base {

	public function get_name() {
		return 'luxriocountdown';
	}

	public function get_title() {
		return __( 'Countdown', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code luxrio';
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

    public function get_keywords() {
		return [ 'counter'];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'luxrio_counter',
			[
				'label' 	=> __( 'Countdown', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'left_bg_image',
			[
				'label' 		=> __( 'Left Background Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'right_bg_image',
			[
				'label' 		=> __( 'Right Background Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'subtitle',
			[
				'label' 	=> __( 'Subtitle', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXT,
                'default'  	=> __( 'your need it', 'luxrio' ),
                'label_block' 	=> true,
			]
        );

        $this->add_control(
			'title',
			[
				'label' 	=> __( 'Title', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXT,
                'default'  	=> __( 'deal of the week', 'luxrio' ),
                'label_block' 	=> true,
			]
        );
        
		$this->add_control(
			'section_description',
			[
				'label' 	=> __( 'Description', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXT,
                'default'  	=> __( 'INew deal every week! Hurry Up!', 'luxrio' ),
                'label_block' 	=> true,
			]
        );
        $this->add_control(
			'countdown_date',
			[
				'label' 	=> __( 'Countdown Date ( Format Like 01/12/2024 )', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXT,
				'default'   => __( '01/12/2025', 'luxrio' ),
                'label_block' 	=> true,
			]
        );

        $this->add_control(
			'box_btn_text',
			[
				'label' 	=> __( 'Button Text', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXT,
				'default'   => __( 'Shop Now', 'luxrio' ),
                'label_block' 	=> true,
			]
        );
        
        $this->add_control(
			'btn_url',
			[
				'label' 	=> __( 'Button Url', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXT,
				'default'   => __( '#', 'luxrio' ),
                'label_block' 	=> true,
			]
        );
        $this->end_controls_section();


        // Section Title
        $this->start_controls_section(
			'section_style',
			[
				'label'		 	=> __( 'Content Style', 'luxrio' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
            's_title_color',
            [
                'label'     => __('Title Color', 'luxrio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .deal-content .sec-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 's_title_typography',
				'label' 		=> __( 'Typography', 'luxrio' ),
				'selector' 		=> '{{WRAPPER}} .deal-content .sec-title',
			]
		);

        $this->add_responsive_control(
			'section_tile_margin',
			[
				'label' 		=> __( 'Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .deal-content .sec-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

        $this->add_responsive_control(
			'section_tile_padding',
			[
				'label' 		=> __( 'Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .deal-content .sec-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );
        $this->add_control(
            'sub_title_color',
            [
                'label'     => __('Sub Title Color', 'luxrio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sec-subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'sub_title_typography',
				'label' 		=> __( 'Sub Title Typography', 'luxrio' ),
				'selector' 		=> '{{WRAPPER}} .sec-subtitle',
			]
		);

        $this->add_control(
            'dis_title_color',
            [
                'label'     => __('Discription Color', 'luxrio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .deal-content .sec-text2' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'dis_title_typography',
				'label' 		=> __( 'Discription Typography', 'luxrio' ),
				'selector' 		=> '{{WRAPPER}} .deal-content .sec-text2',
			]
		);


        $this->end_controls_section();

        $this->start_controls_section(
			'c_section_style',
			[
				'label'		 	=> __( 'Countdown Style', 'luxrio' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label'     => __( 'Box Bg Color', 'luxrio' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .offer-counter .count-number' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'countdown_color',
            [
                'label'     => __(' Countdown Color', 'luxrio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .offer-counter .count-number' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'countdown_typography',
				'label' 		=> __( 'Typography', 'luxrio' ),
				'selector' 		=> '{{WRAPPER}} .offer-counter .count-number',
			]
		);

        $this->add_control(
            'countname_color',
            [
                'label'     => __( 'Count Name Color', 'luxrio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .offer-counter .count-name' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'countname_typography',
				'label' 		=> __( 'Count Name Typography', 'luxrio' ),
				'selector' 		=> '{{WRAPPER}} .offer-counter .count-name',
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
			'button_style_section',
			[
				'label' 	=> __( 'Button Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'button_color',
			[
				'label' 		=> __( 'Button Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'color: {{VALUE}}',
                ],
			]
        );

        $this->add_control(
			'button_color_hover',
			[
				'label' 		=> __( 'Hover Color ', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn:hover' => 'color: {{VALUE}}',
                ],
			]
        );
		$this->add_control(
			'button_icon_color',
			[
				'label' 		=> __( 'Button Icon Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn.style3 > i' => 'color: {{VALUE}}',
                ],
			]
        );
        $this->add_control(
			'button_bg_color',
			[
				'label' 		=> __( 'Background Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'background-color: {{VALUE}}',
                ],
			]
        );
        $this->add_control(
			'button_bg_color_hover',
			[
				'label' 		=> __( 'Background Hover Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn::before, {{WRAPPER}} .vs-btn::after' => 'background-color: {{VALUE}}',
                ],
			]
        );


        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'border',
				'label' 	=> __( 'Border', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .vs-btn',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'button_typography',
				'label' 	=> __( 'Button Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .vs-btn',
			]
        );

        $this->add_responsive_control(
			'button_margin',
			[
				'label' 		=> __( 'Button Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

        $this->add_responsive_control(
			'button_padding',
			[
				'label' 		=> __( 'Button Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
		);
        $this->add_responsive_control(
			'button_border_radius',
			[
				'label' 		=> __( 'Button Border Radius', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'box_shadow',
				'label' 	=> __( 'Box Shadow', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .vs-btn',
			]
		);
        $this->end_controls_section();

    }

	protected function render() {
       
        $settings = $this->get_settings_for_display();

        echo '<section class="space z-index-common bg-position" data-bg-src="'.esc_url( $settings['left_bg_image']['url'] ).'">';
            echo '<div class="overlay"></div>';
            if( ! empty($settings['right_bg_image']['url'])){
                echo '<div class="img-box6">';
                    echo luxrio_img_tag( array(
                        'url'   => esc_url( $settings['right_bg_image']['url'] ),
                        'class' =>'img1'
                    ) );
                echo '</div>';
            }
            echo '<div class="container">';
                echo '<div class="row">';
                echo '<div class="col-xxl-6 offset-xxl-3 col-xl-6 col-lg-auto deal-content wow animate__fadeInUp text-center text-lg-start" data-wow-delay="0.2s">';
                    if( !empty( $settings[ 'subtitle' ] ) ){
                        echo '<span class="sec-subtitle">'.esc_html( $settings['subtitle'] ).'</span>';
                    }
                    if( !empty( $settings[ 'title' ] ) ){
                        echo '<h2 class="sec-title">'.esc_html( $settings['title'] ).'</h2>';
                    }
                    if( !empty( $settings[ 'section_description' ] ) ){
                        echo '<p class="sec-text2">'.esc_html( $settings['section_description'] ).'</p>';
                    }
                    if( ! empty( $settings['countdown_date'] ) ){
                        echo '<div class="counter-style">';
                            echo '<ul class="offer-counter justify-content-center justify-content-lg-start" data-offer-date="'.esc_attr( $settings['countdown_date'] ).'">';
                                echo '<li>';
                                echo '<div class="day count-number">00</div><span class="count-name">'.esc_html__( 'Days','luxrio' ).'</span>';
                                echo '</li>';
                                echo '<li>';
                                echo '<div class="hour count-number">00</div><span class="count-name">'.esc_html__( 'Hours','luxrio' ).'</span>';
                                echo '</li>';
                                echo '<li>';
                                echo '<div class="minute count-number">00</div><span class="count-name">'.esc_html__( 'Minutes','luxrio' ).'</span>';
                                echo '</li>';
                                echo '<li>';
                                echo '<div class="seconds count-number">00</div><span class="count-name">'.esc_html__( 'Seconds','luxrio' ).'</span>';
                                echo '</li>';
                            echo '</ul>';
                        echo '</div>';
                    }
                    if( !empty( $settings[ 'box_btn_text' ] ) ){
                        echo '<a href="'.esc_url( $settings[ 'btn_url' ] ).'" class="vs-btn style5">'.esc_html( $settings['box_btn_text'] ).'</a>';
                    }
                echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</section>';
	}
}
$widgets_manager->register( new \Luxrio_Countdown_Box() );