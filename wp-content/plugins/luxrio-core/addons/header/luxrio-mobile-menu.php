<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;
/**
 *
 * Mobilemenu Widget .
 *
 */
class Luxrio_Mobilemenu extends Widget_Base {

	public function get_name() {
		return 'luxriomobilemenu';
	}

	public function get_title() {
		return __( 'Mobile Menu', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio_header_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'mobile_menu_section',
			[
				'label' 	=> __( 'Mobile Menu', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'button_style',
			[
				'label' 		=> __( 'Button Style', 'luxrio' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '1',
				'options' 		=> [
					'1'  			=> __( 'Version One', 'luxrio' ),
					'2' 			=> __( 'Version Two', 'luxrio' ),
				],
			]
		);

        $this->add_control(
			'logo',
			[
				'label'     => esc_html__( 'Mobile Logo', 'luxrio' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url'          => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'logo_link',
			[
				'label'         => __( 'Link', 'luxrio' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => __( '#', 'luxrio' ),
				'placeholder'   => __( 'Type Url Here', 'luxrio' ),
			]
		);

		$this->add_control(
			'menu_icon_color',
			[
				'label' 		=> __( 'Menu Icon Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-menu-toggle svg path' => 'fill: {{VALUE}}',
                ],
			]
        );

		$this->add_control(
			'mibile_menu_align',
			[
				'label' 	=> __( 'Menu Alignment', 'luxrio' ),
				'type' 		=> Controls_Manager::CHOOSE,
				'options' 	=> [
					'left' 		=> [
						'title' 	=> __( 'Left', 'luxrio' ),
						'icon' 		=> 'fa fa-align-left',
					],
					'center' 	=> [
						'title' 	=> __( 'Center', 'luxrio' ),
						'icon' 		=> 'fa fa-align-center',
					],
					'right' 	=> [
						'title' 	=> __( 'Right', 'luxrio' ),
						'icon' 		=> 'fa fa-align-right',
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .vs-menu-toggle-wraper' => 'text-align: {{VALUE}} !important;',
				],
				'toggle' 		=> true,
			]
		);

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

		if( has_nav_menu( 'mobile-menu' ) ){

			echo '<div class="vs-menu-toggle-wraper">';
            	echo '<button class="vs-menu-toggle">';
					if( $settings['button_style'] == '1' ){
						echo '<i class="fas fa-bars"></i>';
					}elseif( $settings['button_style'] == '2' ){
						echo '<svg width="31" height="23" viewBox="0 0 31 23" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M7 1.5C7 0.671573 7.67157 0 8.5 0H29.5C30.3284 0 31 0.671573 31 1.5C31 2.32843 30.3284 3 29.5 3H8.5C7.67157 3 7 2.32843 7 1.5Z" fill="white"></path>
							<path d="M0 11.5C0 10.6716 0.671573 10 1.5 10H29.5C30.3284 10 31 10.6716 31 11.5C31 12.3284 30.3284 13 29.5 13H1.5C0.671573 13 0 12.3284 0 11.5Z" fill="white"></path>
							<path d="M15 21.5C15 20.6716 15.6716 20 16.5 20H29.5C30.3284 20 31 20.6716 31 21.5C31 22.3284 30.3284 23 29.5 23H16.5C15.6716 23 15 22.3284 15 21.5Z" fill="white"></path>
							</svg>';
					}
				echo '</button>';
			echo '</div>';
		}
	}
}
$widgets_manager->register( new \Luxrio_Mobilemenu() );