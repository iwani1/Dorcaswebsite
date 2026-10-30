<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Section Title Widget .
 *
 */
class Luxrio_Section_Title_Widget extends Widget_Base {

	public function get_name() {
		return 'luxriosectiontitle';
	}

	public function get_title() {
		return __( 'Section Title', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title_section',
			[
				'label'		 	=> __( 'Section Title', 'luxrio' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
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
			'section_title_tag',
			[
				'label' 	=> __( 'Title Tag', 'luxrio' ),
				'type' 		=> Controls_Manager::SELECT,
				'options' 	=> [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default' => 'h2',
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
			'section_subtitle_tag',
			[
				'label' 	=> __( 'Subitle Tag', 'luxrio' ),
				'type' 		=> Controls_Manager::SELECT,
				'options' 	=> [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'P',
					'span'  => 'span',
				],
				'default' 	=> 'span',
				'condition'	=> ['section_subtitle!' => '']
			]
		);

		$this->add_control(
			'section_description',
			[
				'label' 	=> __( 'Section Description', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Section Description', 'luxrio' )
			]
        );
		$this->add_control(
			'show_sahpe',
			[
				'label'        => __( 'Show Shape', 'luxrio' ),
				'type'         =>   Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'luxrio' ),
				'label_off'    => __( 'Hide', 'luxrio' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'shape_icon',
			[
				'label' 		=> __( 'Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [ 'active' 		=> true ],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
				'condition'	=> [ 'show_sahpe' => 'yes' ]
			]
		);
        $this->add_responsive_control(
			'section_title_align',
			[
				'label' 		=> __( 'Alignment', 'luxrio' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'left' 	=> [
						'title' 		=> __( 'Left', 'luxrio' ),
						'icon' 			=> 'eicon-text-align-left',
					],
					'center' 	=> [
						'title' 		=> __( 'Center', 'luxrio' ),
						'icon' 			=> 'eicon-text-align-center',
					],
					'right' 	=> [
						'title' 		=> __( 'Right', 'luxrio' ),
						'icon' 			=> 'eicon-text-align-right',
					],
				],
				'default' 	=> 'left',
				'toggle' 	=> true,
				'selectors' 	=> [
					'{{WRAPPER}} .title-area' => 'text-align: {{VALUE}};',
                ]
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
					'{{WRAPPER}} .title-selector' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'section_title!'    => ''
                ]
			]
        );

        $this->add_control(
			'section_diff_title_color',
			[
				'label' 	=> __( 'Section Title Different Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title-selector span' => 'color: {{VALUE}}',
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
                'selector' 	=> '{{WRAPPER}} .title-selector',
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
					'{{WRAPPER}} .title-selector' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .title-selector' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' 	=> '{{WRAPPER}} .title-selector',
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
		$this->add_control(
			'section_description_color',
			[
				'label' 	=> __( 'Section Description Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title-area .sec-text' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'section_description!'    => ''
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'section_description_typography',
				'label' 	=> __( 'Section Description Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .title-area .sec-text',
                'condition' => [
                    'section_description!'    => ''
                ],
			]
        );

        $this->add_responsive_control(
			'section_description_margin',
			[
				'label' 		=> __( 'Section Description Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .title-area .sec-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' 	=> [
                    'section_description!'    => ''
                ],
			]
        );
        $this->end_controls_section();

	}

	protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'wrapper', 'class', 'title-area' );

        echo '<!-- Section Title -->';
		echo '<div '.$this->get_render_attribute_string( 'wrapper' ).' >';
			
			
			if( !empty( $settings['section_subtitle'] ) ) {
				echo '<'.esc_attr($settings['section_subtitle_tag']).' class="sec-subtitle">';
				
				echo wp_kses_post( $settings['section_subtitle'] ).'</'.esc_attr($settings['section_subtitle_tag']).'>';
			}
			if( !empty( $settings['section_title'] ) ) {
            	echo '<'.esc_attr($settings['section_title_tag']).' class="sec-title title-selector">';
					echo wp_kses_post( $settings['section_title'] );
				echo '</'.esc_attr($settings['section_title_tag']).'>'; 
			}
			if( ! empty( $settings['section_description'] ) ){
				echo luxrio_paragraph_tag( array(
					'text'	=> wp_kses_post( $settings['section_description'] ),
					'class'	=> 'sec-text'
				) );
			}
			if( 'yes' == $settings[ 'show_sahpe' ] ){
				echo luxrio_img_tag( array(
					'url'	=> esc_url( $settings[ 'shape_icon' ][ 'url' ] ),
					'alt'   => 'phone icon',
				) ); 
			};
        echo '</div>';
        echo '<!-- End Section Title -->';
	}
}
$widgets_manager->register( new \Luxrio_Section_Title_Widget() );