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
class Luxrio_Home_Four extends Widget_Base {

	public function get_name() { 
		return 'luxrioherofour';
	}

	public function get_title() {
		return __( 'Hero Home Four', 'luxrio' );
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
			'slider_image',
			[
				'label'     => __( 'Slider Image', 'luxrio' ),
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
			'subtitle',
            [
				'label'         => __( 'Subttile', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'extra 20% off' , 'luxrio' ),
				'label_block'   => true,
			]
		);
		$repeater->add_control(
			'title',
            [
				'label'         => __( 'Title', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'stylish wrist watch' , 'luxrio' ),
				'label_block'   => true,
			]
		);

        $repeater->add_control(
			'hero_text',
            [
				'label'         => __( 'Discription', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'Starting At' , 'luxrio' ),
				'label_block'   => true,
			]
		);

		$repeater->add_control(
			'button_text',
            [
				'label'         => __( 'Button Text', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'Shop Now' , 'luxrio' ),
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
						'subtitle'       	=> __( 'extra 20% off', 'luxrio' ),
						'title'       	    => __( 'stylish wrist watch ', 'luxrio' ),
						'hero_text'   		=> __( 'starting at <span>$150.00</span>', 'luxrio' ),
					],
					[
						'bg_image' 	  		=> Utils::get_placeholder_image_src(),
						'subtitle'       	=> __( 'extra 20% off', 'luxrio' ),
						'title'       	    => __( 'stylish wrist watch', 'luxrio' ),
						'hero_text'   		=> __( 'starting at <span>$150.00</span>', 'luxrio' ),
					],
				],
				'title_field' 	=> '{{title}}',
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
			'slider_dots',
			[
				'label' 		=> __( 'Dots', 'luxrio' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'luxrio' ),
				'label_off' 	=> __( 'No', 'luxrio' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
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
			'subtitle_style',
			[
				'label' 	=> __( 'Content Style', 'luxrio' ),
                'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_control(
			'sub_title_color',
			[
				'label' 	=> __( 'Subtitle Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-content--style4 .hero-content__offer--text' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'sub_title_typo',
				'label' 	=> __( 'Subtitle Typhography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .hero-content--style4 .hero-content__offer--text',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' 	=> __( 'Title Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-content--style4 .hero-content__title' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typo',
				'label' 	=> __( 'Title Typhography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .hero-content--style4 .hero-content__title',
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
					'{{WRAPPER}} .hero-content--style4 .hero-content__price' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'sdis_typo',
				'label' 	=> __( 'Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .hero-content--style4 .hero-content__price',
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

		$this->add_render_attribute( 'wrapper', 'class', 'hero-vs-carousel4' );

		if( $settings['slider_autoplay'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'true' );
		} else {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'false' );
		}

		if( $settings['slider_dots'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'data-slick-dots', 'true' );
		} else {
			$this->add_render_attribute( 'wrapper', 'data-slick-dots', 'false' );
		}
		

		?>
		<section class="hero-layout4">
            <div class="container">
                <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                    <?php foreach( $settings['heroone_slides'] as $slides  ): ?>
                        <div class="slick-slide">
                            <div class="row justify-content-between align-items-center gy-5 flex-column-reverse flex-lg-row">
                                <div class="col-xl-6 col-lg-7">
                                    <div class="hero-content hero-content--style4 text-center text-lg-start">
                                        <?php if( ! empty( $slides['subtitle'] ) ): ?>
                                            <span class="hero-content__offer--text"><?php echo esc_html( $slides['subtitle'] );?></span>
                                        <?php endif; ?>
                                        <?php if( ! empty( $slides['title'] ) ): ?>
                                        <h1 class="hero-content__title"><?php echo esc_html( $slides['title'] );?></h1>
                                        <?php endif; ?>
                                        <?php if( ! empty( $slides['hero_text'] ) ): ?>
                                            <div class="hero-content__price">
                                                <?php echo wp_kses_post( $slides['hero_text'] );?>
                                            </div>
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
                                <?php 
                                    if( ! empty( $slides['slider_image']['url'] ) ){
                                        echo '<div class="col-xl-auto col-lg-5">';
                                            echo '<div class="hero-img hero-img--container4 text-center text-lg-start">';
                                                echo luxrio_img_tag( array(
                                                    'url' => esc_url( $slides['slider_image']['url'] ),
                                                ) );
                                            echo '</div>';
                                        echo '</div>';
                                    }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
			</div>
        </section>
		<?php 
	}
}
$widgets_manager->register( new \Luxrio_Home_Four() );
