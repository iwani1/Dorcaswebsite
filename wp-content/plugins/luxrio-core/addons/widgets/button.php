<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
/**
 *
 * Button Widget .
 *
 */
class Luxrio_Button extends Widget_Base {

	public function get_name() {
		return 'luxriobutton';
	}

	public function get_title() {
		return __( 'Button', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'button_section',
			[
				'label' 	=> __( 'Button', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'button_style',
			[
				'label' 	=> __( 'Button Style', 'luxrio' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> '1',
				'options' 	=> [
					'1'  		=> __( 'Style One', 'luxrio' ),
					'2' 		=> __( 'Style Two', 'luxrio' ),
					'3' 		=> __( 'Style Three', 'luxrio' ),
					'4' 		=> __( 'Style Four', 'luxrio' ),
				],
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

		$this->add_control(
			'button_icon',
			[
				'label' 	=> __( 'Button Icon Class', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'fa-solid fa-headphones', 'luxrio' ),
				'condition'	=> [ 'button_style' => '3' ]
			]
        );

        $this->add_responsive_control(
			'button_align',
			[
				'label' 		=> __( 'Alignment', 'luxrio' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'left' 			=> [
						'title' 		=> __( 'Left', 'luxrio' ),
						'icon' 			=> 'eicon-text-align-left',
					],
					'center' 		=> [
						'title' 		=> __( 'Center', 'luxrio' ),
						'icon' 			=> 'eicon-text-align-center',
					],
						'right' 	=> [
						'title' 		=> __( 'Right', 'luxrio' ),
						'icon' 			=> 'eicon-text-align-right',
					],
				],
				'default' 		=> 'left',
				'toggle' 		=> true,
				'selectors' 	=> [
					'{{WRAPPER}} .btn-wrapper' => 'text-align: {{VALUE}}',
                ],
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
		

		if( $settings['button_style'] == '1' ){
			$this->add_render_attribute( 'wrapper', 'class', 'vs-btn' );
		}elseif( $settings['button_style'] == '2' ){
			$this->add_render_attribute( 'wrapper', 'class', 'vs-btn style2' );
		}elseif( $settings['button_style'] == '3' ){
			$this->add_render_attribute( 'wrapper', 'class', 'vs-btn style3' );
		}elseif( $settings['button_style'] == '4' ){
			$this->add_render_attribute( 'wrapper', 'class', 'vs-btn style6' );
		}

		
		
		
        if( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_render_attribute( 'wrapper', 'href', esc_url( $settings['button_link']['url'] ) );
        }

        if( ! empty( $settings['button_link']['nofollow'] ) ) {
            $this->add_render_attribute( 'wrapper', 'rel', 'nofollow' );
        }

        if( ! empty( $settings['button_link']['is_external'] ) ) {
            $this->add_render_attribute( 'wrapper', 'target', '_blank' );
        }

        echo '<!-- Button -->';
		echo '<div class="btn-wrapper">';
			echo '<a '.$this->get_render_attribute_string('wrapper').'>';
				if( ! empty( $settings['button_icon'] ) ){
					echo '<i class="'.$settings['button_icon'].'"></i>';
				}
				if( ! empty( $settings['button_text'] ) ) {
					echo esc_html( $settings['button_text'] );
				}
				if( $settings['button_style'] == '4' ){
					echo '<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M24.0132 11.9994L4.40018 0.407369C3.95755 0.144966 3.45333 0.00444828 2.93879 0.000103008C2.42424 -0.00424226 1.91772 0.12774 1.47073 0.38263C1.02373 0.63752 0.652195 1.00623 0.393902 1.45127C0.135609 1.89631 -0.000234709 2.40181 0.000182978 2.91637L0.000182184 21.0824C-0.000235548 21.5969 0.135608 22.1024 0.393901 22.5475C0.652194 22.9925 1.02373 23.3612 1.47072 23.6161C1.91772 23.871 2.42424 24.003 2.93879 23.9986C3.45333 23.9943 3.95755 23.8538 4.40018 23.5914L24.0132 11.9994ZM2.00018 8.99937L7.08118 11.9994L2.00018 14.9994L2.00018 8.99937ZM2.46118 21.8794C2.32016 21.8006 2.20293 21.6853 2.12182 21.5456C2.04071 21.4059 1.99869 21.2469 2.00018 21.0854L2.00018 17.3254L11.0132 11.9994L2.00018 6.67337L2.00018 2.91637C1.99996 2.75516 2.04242 2.59676 2.12325 2.45729C2.20408 2.31781 2.32041 2.20222 2.46039 2.12227C2.60038 2.04232 2.75904 2.00086 2.92025 2.00211C3.08145 2.00335 3.23945 2.04726 3.37818 2.12937L20.0812 11.9994L3.38118 21.8694C3.24264 21.9532 3.08406 21.9981 2.92214 21.9993C2.76023 22.0005 2.60098 21.9581 2.46118 21.8764L2.46118 21.8794Z" fill="#FF3E01"></path>
					</svg>';
				}
			echo '</a>';
		echo '</div>';
		echo '<!-- End Button -->';
	}

}
$widgets_manager->register( new \Luxrio_Button() );