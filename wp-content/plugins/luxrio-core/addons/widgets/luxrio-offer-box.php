<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\HEADING;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Image Widget .
 *
 */
class Luxrio_OfferBox extends Widget_Base {

	public function get_name() {
		return 'luxrioofferbox';
	}
 
	public function get_title() {
		return __( 'Offer Box', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'image_section',
			[
				'label' 	=> __( 'Content', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'media_image',
			[
				'label' 		=> __( 'Image / Svg Icon', 'luxrio' ),
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
			'subtitle', [
				'label' 		=> __( 'Subtitle', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'save up to 40% off' , 'luxrio' ),
				'label_block' 	=> true,
			]
        );

        $this->add_control(
			'title', [
				'label' 		=> __( 'Title', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'Personalized Learning' , 'luxrio' ),
				'label_block' 	=> true,
				
			]
        );

 
        $this->add_control(
			'button_text',
			[
				'label' 	=> __( 'Button Text', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Contact Us', 'luxrio' )
			]
        );

        $this->add_control(
			'button_link',
			[
				'label' 		=> __( 'Link', 'luxrio' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'luxrio' ),
				'show_external' => true,
				'default' 		=> [
					'url' 			=> '#',
					'is_external' 	=> false,
					'nofollow' 		=> false,
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'title_style_option',
			[
				'label' 	=> __( 'Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
		);

		//Title
		$this->add_control(
			'title_color',
			[
				'label' 		=> __( 'Title Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .offer-style .offer-title' => 'color: {{VALUE}} !important',
                ]
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'title_typography',
				'label'         => __( 'Title Typography', 'luxrio' ),
                'selector'      => '{{WRAPPER}} .offer-style .offer-title',
			]
		);
		$this->add_control(
			'subtitles',
			[
				'label' => esc_html__( 'Subtitle', 'luxrio' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'label' 		=> __( 'Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .offer-style .offer-subtitle' => 'color: {{VALUE}} !important',
                ]
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'subtitle_typography',
				'label'         => __( 'Typography', 'luxrio' ),
                'selector'      => '{{WRAPPER}}  .offer-style .offer-subtitle',
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

        $this->add_render_attribute( 'wrapper', 'class', 'vs-btn' );

        if( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_render_attribute( 'wrapper', 'href', esc_url( $settings['button_link']['url'] ) );
        }

        if( ! empty( $settings['button_link']['nofollow'] ) ) {
            $this->add_render_attribute( 'wrapper', 'rel', 'nofollow' );
        }

        if( ! empty( $settings['button_link']['is_external'] ) ) {
            $this->add_render_attribute( 'wrapper', 'target', '_blank' );
        }

        echo '<div class="offer-style">';
            if( ! empty( $settings['media_image']['url'] ) ){
                echo '<div class="offer-img">';
                    echo luxrio_img_tag( array(
                        'url'   => esc_url( $settings['media_image']['url'] ), 
                    ) );
                echo '</div>';
            }
            echo '<div class="offer-body">';
                if( ! empty( $settings['subtitle'] ) ){
                    echo '<span class="offer-subtitle">'.esc_html( $settings['subtitle'] ).'</span>';
                }
                if( ! empty( $settings['title'] ) ){
                    echo '<h3 class="offer-title">'.esc_html( $settings['title'] ).'</h3>';
                }
                if( ! empty( $settings['button_text'] ) ) {
                    echo '<a '.$this->get_render_attribute_string('wrapper').'>';
                        echo esc_html( $settings['button_text'] );
                    echo '</a>';
                }
            echo '</div>';
        echo '</div>';

	}
}
$widgets_manager->register( new \Luxrio_OfferBox() );