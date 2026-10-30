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
class Luxrio_Hero_Three extends Widget_Base {

	public function get_name() {
		return 'luxrioherothree';
	}

	public function get_title() {
		return __( 'Hero Home Three', 'luxrio' );
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

		$repeater->add_control(
			'slide_image',
			[
				'label'     => __( 'Slide Image', 'luxrio' ),
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
				'default'       => __( 'Time' , 'luxrio' ),
				'label_block'   => true,
			]
		);
		$repeater->add_control(
			'title_two',
            [
				'label'         => __( 'Title Two', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'Travel' , 'luxrio' ),
				'label_block'   => true,
			]
		);

        $repeater->add_control(
			'price_text',
            [
				'label'         => __( 'Price Text', 'luxrio' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => __( 'starting at $150.00','luxrio' ),
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
						'bg_image' 	  => Utils::get_placeholder_image_src(),
						'title_one'   => __( 'Time', 'luxrio' ),
						'title_one'   => __( 'Travel','luxrio' ),
					],
				],
				'title_field' 	=> '{{title_one}}',
			]
		);
		$this->add_control(
			'shape_image',
			[
				'label'     => __( 'Shape Image', 'luxrio' ),
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
					'{{WRAPPER}} .hero-main .hero-main .hero-title .highlight .highlight' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_one_typo',
				'label' 	=> __( 'Title One Typo', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .hero-main .hero-main .hero-title .highlight .highlight',
			]
		);

		$this->add_control(
			'title_two_color',
			[
				'label' 	=> __( 'Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hero-main .hero-title .highlight' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_two_typo',
				'label' 	=> __( 'Title Typo', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .hero-main .hero-title .highlight',
			]
		);


		$this->add_responsive_control(
			'section_tile_padding',
			[
				'label' 		=> __( 'Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .hero-main .hero-title .highlight' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
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
					'{{WRAPPER}} .hero-pricing' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'sdis_typo',
				'label' 	=> __( 'Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .hero-pricing',
			]
		);
		$this->end_controls_section();

	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'hero-carousel3' );

		if( $settings['slider_autoplay'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'true' );
		} else {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'false' );
		}
		
		?>

	<section class="hero-layout3">
		<?php
			if( $settings['shape_image']['url'] ){
				echo luxrio_img_tag( array(
					'url'	=> esc_url( $settings['shape_image']['url'] ),
					'class'	=> 'hero-ele1'
				) );
			}
		?>

		<div class="hero-carousel-arrow">
			<button class="hero-carousel-prev" data-slick-prev=".hero-carousel3">
			<svg width="20" height="14" xmlns="http://www.w3.org/2000/svg">
				<path d="M7.57 0.93L1.5 7l6.07 6.07" stroke="#F2F2F2" stroke-width="1.5" stroke-linecap="round" />
				<path d="M18.5 7H1.67" stroke="#F2F2F2" stroke-width="1.5" stroke-linecap="round" />
			</svg>
			</button>
			<div class="slick-status">
			<span class="slick-status__active">01</span> / <span>02</span>
			</div>
			<button class="hero-carousel-next" data-slick-next=".hero-carousel3">
			<svg width="20" height="14" xmlns="http://www.w3.org/2000/svg">
				<path d="M12.43 0.93L18.5 7l-6.07 6.07" stroke="#F2F2F2" stroke-width="1.5" stroke-linecap="round" />
				<path d="M1.5 7H18.33" stroke="#F2F2F2" stroke-width="1.5" stroke-linecap="round" />
			</svg>
			</button>
		</div>
		<div class="vs-hero">
		<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
		<?php foreach( $settings['heroone_slides'] as $slides  ): ?>
			<div>
				<div class="hero-main style4" data-bg-src="<?php echo esc_url( $slides['bg_image']['url'] ); ?>">
					<?php if( ! empty( $slides['price_text'] ) ): ?>
						<div class="hero-pricing">
							<?php echo wp_kses_post( $slides['price_text'] );?>
						</div>
					<?php endif;?>
					<?php if( ! empty( $slides['slide_image']['url'] ) ): ?>
						<div class="hero-img3 style2">
							<?php 
								echo luxrio_img_tag( array(
									'url'	=> esc_url( $slides['slide_image']['url'] ),
									'class'	=> 'hero-img3-img'
								) );
							?>
						</div>
					<?php endif;?>
					<h1 class="hero-title">
						<span>
						<?php if( ! empty( $slides['title_one'] ) ): ?>
							<span class="htext2 highlight"><?php echo esc_html( $slides['title_one'] );?></span>
						<?php endif;?>
						<?php if( ! empty( $slides['title_two'] ) ): ?>
							<span class="htext1"><?php echo esc_html( $slides['title_two'] );?></span>
						<?php endif;?>
						</span>
					</h1>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		</div>
		</section>
		<?php 
	}
}
$widgets_manager->register( new \Luxrio_Hero_Three() );