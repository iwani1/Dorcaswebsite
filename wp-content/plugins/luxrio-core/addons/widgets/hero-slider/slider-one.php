<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\HEADING;
use \Elementor\Repeater;
/**
 * 
 * Image Widget .
 *
 */
class Luxrio_Hero_One extends Widget_Base {

	public function get_name() { 
		return 'luxrioheroone';
	}

	public function get_title() {
		return __( 'Hero Home One', 'luxrio' );
	}


	public function get_icon() {
		return 'eicon-code';
    }


	public function get_categories() {
		return [ 'luxrio' ];
	}


	protected function register_controls() {
		//Top Content
		$this->start_controls_section(
			'slider_content',
			[
				'label' 	=> __( 'Slider Content', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$repeater = new Repeater();

		
		$repeater->add_control(
			'image_one',
			[
				'label'     => __( 'Image One', 'luxrio' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'image_two',
			[
				'label'     => __( 'Image Two', 'luxrio' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'image_three',
			[
				'label'     => __( 'Image Three', 'luxrio' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'image_four',
			[
				'label'     => __( 'Image Four', 'luxrio' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'title_one',
            [
				'label'         => __( 'Title One', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'Necklace' , 'luxrio' ),
				'label_block'   => true,
			]
		);
		$repeater->add_control(
			'title_two',
            [
				'label'         => __( 'Title Two', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'jeweellery' , 'luxrio' ),
				'label_block'   => true,
			]
		);

        $repeater->add_control(
			'hero_text',
            [
				'label'         => __( 'Discription', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'inspires' , 'luxrio' ),
				'label_block'   => true,
			]
		);

       
        $repeater->add_control(
			'button_text',
            [
				'label'         => __( 'Button Text', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'Appointment' , 'luxrio' ),
				'label_block'   => true,
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' 		=> __( 'Button Url', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXT,
				'placeholder' 	=> __( 'https://your-link.com', 'luxrio' ),
				'label_block'   => true,
			]
		);
		$this->add_control(
			'heroone_slides',
			[
				'label' 		=> __( 'Sliders', 'luxrio' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'bg_image' 	  		=> Utils::get_placeholder_image_src(),
						'title_one'       	=> __( 'Necklace', 'luxrio' ),
						'title_two'       	=> __( 'jeweellery', 'luxrio' ),
						'hero_text'   		=> __( 'HOLY JEWELRY and diamonds', 'luxrio' ),
						'button_text' 		=> __( 'Shop Now', 'luxrio' ),
						'link'        		=> __( '#', 'luxrio')
					],
					[
						'bg_image' 	  		=> Utils::get_placeholder_image_src(),
						'title_one'       	=> __( 'Wedding', 'luxrio' ),
						'title_two'       	=> __( 'jeweellery', 'luxrio' ),
						'hero_text'   		=> __( 'HOLY JEWELRY and diamonds', 'luxrio' ),
						'button_text' 		=> __( 'Shop Now', 'luxrio' ),
						'link'        		=> __( '#', 'luxrio' )
					],
				],
				'title_field' 	=> '{{title_one}}',
			]
		);
		$this->add_control(
			'bg_image',
			[
				'label'     => __( 'Background Image', 'luxrio' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'bg_image_shape_one',
			[
				'label'     => __( 'Background Shape One', 'luxrio' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'bg_image_shape_two',
			[
				'label'     => __( 'Background Shape Two', 'luxrio' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
        $this->end_controls_section();


		//Button  Style
		$this->start_controls_section( 
			'slider_settings',
			[
				'label' 	=> __( 'Slider Settings', 'luxrio' ),
                'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );
		$this->add_control(
			'slider_autoplay',
			[
				'label' 		=> __( 'Autoplay', 'luxrio' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'luxrio' ),
				'label_off' 	=> __( 'No', 'luxrio' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);
		$this->end_controls_section();
		
		// title
		$this->start_controls_section(
			'title_style',
			[
				'label' 	=> __( 'Content Style', 'luxrio' ),
                'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_control(
			'title_one_color',
			[
				'label' 	=> __( 'Title One Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-main .hero-title .highlight' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_one_typo',
				'label' 	=> __( 'Title One Typhography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .hero-main .hero-title .highlight',
			]
		);

		$this->add_control(
			'title_two_color',
			[
				'label' 	=> __( 'Title Two Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-main .hero-title .htext2' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_two_typo',
				'label' 	=> __( 'Title Two Typhography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .hero-main .hero-title .htext2',
			]
		);

		

		// Dis title
		$this->add_control(
			'dis_title',
			[
				'label' => esc_html__( 'Discription', 'luxrio' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dis_color',
			[
				'label' 	=> __( 'Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-text' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'sdis_typo',
				'label' 	=> __( 'Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .hero-text',
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
					'{{WRAPPER}} .vs-btn:hover .vs-btn__bar::before, {{WRAPPER}} .vs-btn:hover .vs-btn__bar::after' => 'background-color: {{VALUE}}',
                ],
			]
        );

		$this->add_control(
			'button_bg_hover_color_two',
			[
				'label' 		=> __( 'Background Hover Color Two', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn::after, {{WRAPPER}} .vs-btn::before' => 'background-color: {{VALUE}}',
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

		$this->add_render_attribute( 'wrapper', 'class', 'hero-carousel' );
		$this->add_render_attribute( 'wrapper', 'data-bg-src', $settings['bg_image']['url'] );

		if( $settings['slider_autoplay'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'true' );
		} else {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'false' );
		}
		
		?>

		<div class="z-index-common hero-layout1">
		
			<?php
				if( ! empty( $settings['bg_image_shape_one']['url'] ) ){
					echo luxrio_img_tag( array(
						'url'	=> esc_url( $settings['bg_image_shape_one']['url'] ),
						'class'	=> 'ele1'
					) );
				}
				if( ! empty( $settings['bg_image_shape_two']['url'] ) ){
					echo luxrio_img_tag( array(
						'url'	=> esc_url( $settings['bg_image_shape_two']['url'] ),
						'class'	=> 'ele2'
					) );
				}
			?>

			<div class="container custom-container">
				<div class="vs-hero">
					<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
					<?php foreach( $settings['heroone_slides'] as $slides  ): ?>
						<div>
							<div class="hero-main">
								<?php 
									if( ! empty( $slides['image_one']['url'] ) ){
										echo luxrio_img_tag( array(
											'url'	=> esc_url( $slides['image_one']['url'] ),
											'class'	=> 'hero-img1'
										) );
									}
									if( ! empty( $slides['image_two']['url'] ) ){
										echo luxrio_img_tag( array(
											'url'	=> esc_url( $slides['image_two']['url'] ),
											'class'	=> 'hero-img2'
										) );
									}
									if( ! empty( $slides['image_three']['url'] ) ){
										echo luxrio_img_tag( array(
											'url'	=> esc_url( $slides['image_three']['url'] ),
											'class'	=> 'hero-img3'
										) );
									}
									if( ! empty( $slides['image_four']['url'] ) ){
										echo luxrio_img_tag( array(
											'url'	=> esc_url( $slides['image_four']['url'] ),
											'class'	=> 'hero-img4'
										) );
									}
								?>

								<div class="container">
									<div class="row justify-content-lg-start justify-content-center">
										<div class="col-xl-8 col-lg-7 col-auto">
											<div class="hero-content text-center text-lg-start">
												<h1 class="hero-title">
													<span>
														<?php if(  !empty( $slides['title_one'] ) ): ?>
															<span class="highlight htext1"><?php echo esc_html( $slides['title_one'] ); ?></span>
														<?php endif; ?>
														<?php if(  !empty( $slides['title_two'] ) ): ?>
															<span class="htext2"><?php echo esc_html( $slides['title_two'] ); ?></span>
														<?php endif; ?>
													</span>
												</h1>
												
												<?php if( !empty( $slides['hero_text'] ) ): ?>
													<span class="hero-subtitle">
														<span class="htext3">
															<?php echo wp_kses_post( $slides['hero_text'] );?>
														</span>
													</span>
												<?php endif; ?>
												<?php if( !empty( $slides[ 'button_text' ]  ) ): ?>
													<div class="d-flex overflow-hidden hbtn1 justify-content-lg-start justify-content-center">
														<a href="<?php echo esc_html( $slides[ 'link' ] ); ?>" class="vs-btn">
															<?php echo esc_html( $slides[ 'button_text' ] ) ?>
														</a>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>

					<div class="carousel-arrow">
						<button class="vs-btn" data-slick-prev=".hero-carousel">
							<svg width="20" height="14" viewBox="0 0 20 14" fill="none">
								<path d="M7.57 0.930054L1.5 7.00005L7.57 13.0701" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M18.4999 7H1.66992" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</button>
						<button class="vs-btn" data-slick-next=".hero-carousel">
							<svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12.4299 0.930054L18.4999 7.00005L12.4299 13.0701" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M1.5 7H18.33" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</button>
					</div>
				</div>
			</div>
		</div>
		<?php 
	}
}
$widgets_manager->register( new \Luxrio_Hero_One() );