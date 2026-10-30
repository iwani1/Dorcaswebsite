<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Testimonial Slider Two Widget .
 *
 */
class Luxrio_Testimonial_Slider_Two extends Widget_Base{

	public function get_name() {
		return 'luxriotestimonialsliderstwo';
	}

	public function get_title() {
		return __( 'Testimonial Slider Two', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'testimonial_slider_section',
			[
				'label' 	=> __( 'Testimonial Slider Two', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
		);

		
		$this->add_control(
			'left_side_big_image',
			[
				'label' 		=> __( 'Left Big Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$this->add_control(
			'section_title',
			[
				'label' 	=> __( 'Section Title', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Section Title', 'luxrio' )
			]
        );

		$this->add_control(
			'section_subtitle',
			[
				'label' 	=> __( 'Section Subtitle', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Section Subtitle', 'luxrio' )
			]
        );

		$this->add_control(
			'shape_icon',
			[
				'label' 		=> __( 'Title Shape Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [ 'active' 		=> true ],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'client_image',
			[
				'label' 		=> __( 'Client Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'client_name', [
				'label' 		=> __( 'Client Name', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'Rodja Heartmann' , 'luxrio' ),
				'label_block' 	=> true,
			]
        );
		$repeater->add_control(
			'client_designation', [
				'label' 		=> __( 'Client Designation', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'Google Ceo' , 'luxrio' ),
				'label_block' 	=> true,
			]
        );

        $repeater->add_control(
			'client_feedback', [
				'label' 		=> __( 'Client Feedback', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'Contrary to popular belief, Lorem Ipsum is not simply random text over 2000 years old. Richard McClintock' , 'luxrio' ),
				'label_block' 	=> true,
			]
		);
		$repeater->add_control(
			'show_star',
			[
				'label'        => __( 'Show Star', 'luxrio' ),
				'type'         =>   Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'luxrio' ),
				'label_off'    => __( 'Hide', 'luxrio' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'slides',
			[
				'label' 		=> __( 'Slides', 'luxrio' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'client_name' 		=> __( 'alaxander lee', 'luxrio' ),
						'client_feedback' 	=> __( '“Lorem ipsum dolor sit amet, conse elit, sedid do eiusmod tempor incidit laboret dolore magna aliqua. Quis ipsum usndi laboris ipsum dolor sitamet conseelit, sedid mollit“', 'luxrio' ),
						'client_image' 		=> Utils::get_placeholder_image_src(),
					],
					[
						'client_name' 		=> __( 'Vivi Marian', 'luxrio' ),
						'client_feedback' 	=> __( 'Didco ipsum dolor sit amet, conse elit, sedid do eiusmod tempor incidit laboret dolore magna aliqua. Quis ipsum usndi laboris ipsum dolor sitamet conseelit, sedid mturing“', 'luxrio' ),
						'client_image' 		=> Utils::get_placeholder_image_src(),
					],
				],
				'title_field' 	=> '{{{ client_name }}}',
			]
		);


		$this->end_controls_section();
		
		$this->start_controls_section(
			'general_style',
			[
				'label' 	=> __( 'General Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'star_color',
			[
				'label' 	=> __( 'Star Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testi-style.style2 .testi-rate i' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_title_style_section',
			[
				'label' => __( 'Section Title Style', 'luxrio' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_wrapper_margin',
			[
				'label' 		=> __( 'Section Wrapper Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .title-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

        $this->add_responsive_control(
			'section_wrapper_padding',
			[
				'label' 		=> __( 'Section Wrapper Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .title-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' 	=> 'after'
			]
		);

        $this->add_control(
			'section_title_color',
			[
				'label' 	=> __( 'Section Title Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sec-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'section_title!'    => ''
                ]
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'section_title_typography',
				'label' 	=> __( 'Section Title Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .sec-title',
                'condition' => [
                    'section_title!'    => ''
                ]
			]
		);

        $this->add_responsive_control(
			'section_title_margin',
			[
				'label' 		=> __( 'Section Title Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .sec-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'section_title!'    => ''
                ]
			]
        );

        $this->add_responsive_control(
			'section_title_padding',
			[
				'label' 		=> __( 'Section Title Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .sec-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' 	=> [
                    'section_title!'    => ''
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'border',
				'label' 	=> __( 'Border', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .sec-title',
				'condition' => [
                    'section_title!'    => ''
                ],
                'separator' => 'after'
			]
		);
		


		$this->add_control(
			'section_subtitle_color',
			[
				'label' 		=> __( 'Section Subtitle Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .sec-subtitle' => 'color: {{VALUE}}',
                ],
                'condition' 	=> [
                    'section_subtitle!'    => ''
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'section_subtitle_typography',
				'label' 	=> __( 'Section Subtitle Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .sec-subtitle',
                'condition' => [
                    'section_subtitle!'    => ''
                ],
			]
        );

        $this->add_responsive_control(
			'section_subtitle_margin',
			[
				'label' 		=> __( 'Section Subtitle Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .sec-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'section_subtitle!'    => ''
                ],
			]
        );
		
        $this->end_controls_section();

        $this->start_controls_section(
			'testimonial_slider_client_name_style_section',
			[
				'label' 	=> __( 'Client Name', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'testimonial_slider_client_name_color',
			[
				'label' 		=> __( 'Client Name Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .testi-style .testi-user' => 'color: {{VALUE}}!important',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'testimonial_slider_client_name_typography',
				'label' 	=> __( 'Client Name Typography', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .testi-style .testi-user',
			]
        );

        $this->add_responsive_control(
			'testimonial_slider_client_name_margin',
			[
				'label' 		=> __( 'Client Name Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .testi-style .testi-user' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );
        $this->end_controls_section();

        $this->start_controls_section(
			'testimonial_slider_client_feedback_style_section',
			[
				'label' 	=> __( 'Client Feedback', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'testimonial_slider_client_feedback_color',
			[
				'label' 	=> __( 'Client Feedback Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testi-style .testi-text' => 'color: {{VALUE}} !important',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'testimonial_slider_client_feedback_typography',
				'label' 	=> __( 'Feedback Typography', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .testi-style .testi-text',
			]
        );

        $this->add_responsive_control(
			'testimonial_slider_client_feedback_margin',
			[
				'label' 		=> __( 'Feedback Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .testi-style .testi-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );
        $this->end_controls_section();

		$this->start_controls_section(
			'testimonial_slider_client_designation_style_section',
			[
				'label' 	=> __( 'Client Designation', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'testimonial_slider_client_designation_color',
			[
				'label' 	=> __( 'Client Designation Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testi-style .designation' => 'color: {{VALUE}} !important',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'testimonial_slider_client_designation_typography',
				'label' 	=> __( 'Designation Typography', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .testi-style .designation',
			]
        );

        $this->add_responsive_control(
			'testimonial_slider_client_designation_margin',
			[
				'label' 		=> __( 'Designation Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .testi-style .designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );
        $this->end_controls_section();



	}
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'testi-carousel2' );

		?>

		<section class="testi-layout2 z-index-common">
			<div class="vs-carousel-arrow">
				<button data-slick-prev=".testi-carousel2">
				<svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M0.875999 4.586L5.462 0L6.876 1.414L2.614 5.677L24 5.707V7.707L2.554 7.677L6.877 12L5.463 13.414L0.875999 8.828C0.315294 8.26451 0.000526428 7.50193 0.000526428 6.707C0.000526428 5.91207 0.315294 5.14949 0.875999 4.586Z" fill="#EEDCB3" fill-opacity="0.5" />
				</svg>
				</button>
				<button data-slick-next=".testi-carousel2">
					<svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M23.124 4.586L18.538 0L17.124 1.414L21.386 5.677L0 5.707V7.707L21.446 7.677L17.123 12L18.537 13.414L23.124 8.828C23.6847 8.26451 23.9995 7.50193 23.9995 6.707C23.9995 5.91207 23.6847 5.14949 23.124 4.586Z" fill="white" />
					</svg>
				</button>
			</div>
			<div class="container">
				<div class="row align-items-center">
				<div class="col-lg-5">
					<?php 
						if( ! empty( $settings['left_side_big_image']['url'] ) ){
							echo '<div class="testi-left">';
								echo luxrio_img_tag( array(
									'url'	=> esc_url( $settings['left_side_big_image']['url'] ),
								) );
							echo '</div>';
						}
					?>
				</div>
				<div class="col-lg-7">
					<div class="title-area">
					<?php
						if( !empty( $settings['section_subtitle'] ) ) {
							echo '<span class="sec-subtitle">'.esc_html( $settings['section_subtitle'] ).'</span>';
						}
						if( !empty( $settings['section_title'] ) ) {
							echo '<h2 class="sec-title">'.esc_html( $settings['section_title'] ).'</h2>';
						}
						
						if( ! empty( $settings['shape_icon']['url'] ) ){
							echo luxrio_img_tag( array(
								'url'	=> esc_url( $settings['shape_icon']['url'] ),
							) );
						}
					?>
					</div>
					<div class="testi-inner">
					<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
						<?php foreach( $settings[ 'slides' ] as $slide ): ?>
							<div class="testi-style style2">
								<?php if( $slide['show_star'] == 'yes' ):?>
									<div class="testi-rate">
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
									</div>
								<?php endif;?>
								<?php if( !empty( $slide[ 'client_feedback' ] ) ): ?>
									<p class="testi-text">
										<?php echo esc_html( $slide[ 'client_feedback' ] ); ?>
									</p>
								<?php endif; ?>
								<div class="testi-auth">
									<?php if( $slide['client_image']['url'] ): ?>
										<div class="testi-thumb">
											<?php
												echo luxrio_img_tag( array(
													'url'	=> esc_url( $slide['client_image']['url'] ),
													'class'   => 'img',
												) );
											?>
										</div>
									<?php endif; ?>

									<div class="testi-auth-info">
										<?php if( !empty( $slide[ 'client_name' ] ) ): ?>
											<span class="testi-user">
												<?php echo esc_html($slide[ 'client_name' ]) ?>
											</span>
										<?php endif; ?>
										<?php if( ! empty( $slide[ 'client_designation' ] ) ): ?>
											<span class="designation"><?php echo esc_html( $slide[ 'client_designation' ] );?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					</div>
				</div>
				</div>
			</div>
		</section>


		<?php 
	}
}
$widgets_manager->register( new \Luxrio_Testimonial_Slider_Two() );
