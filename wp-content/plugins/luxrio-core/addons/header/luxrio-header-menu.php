<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * HeaderMenu Widget .
 *
 */
class Luxrio_HeaderMenu extends Widget_Base {

	public function get_name() {
		return 'luxrioheadermenu';
	}

	public function get_title() {
		return __( 'Header Menu', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio_header_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'header_section',
			[
				'label' 	=> __( 'Header', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );
		$menus = $this->luxrio_menu_select();

		if( !empty( $menus ) ){
	        $this->add_control(
				'luxrio_menu_select',
				[
					'label'     	=> __( 'Select Menu', 'luxrio' ),
					'type'      	=> Controls_Manager::SELECT,
					'options'   	=> $menus,
					'description' 	=> sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'luxrio' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		}else {
			$this->add_control(
				'no_menu',
				[
					'type' 				=> Controls_Manager::RAW_HTML,
					'raw' 				=> '<strong>' . __( 'There are no menus in your site.', 'luxrio' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'luxrio' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' 		=> 'after',
					'content_classes' 	=> 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
        }
		$this->add_control(
			'more_options',
			[
				'label' 	=> esc_html__( 'Set Your Style From Style Tab', 'luxrio' ),
				'type' 		=> Controls_Manager::HEADING,
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'menu_top_level_menu_item_style_section',
			[
				'label' 	=> __( 'Top Level Menu Items', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'top_level_menu_alignment',
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
					'{{WRAPPER}} .menu-style1' => 'text-align: {{VALUE}} !important;',
				],
				'toggle' 		=> true,
			]
		);

        $this->add_control(
			'top_level_menu_color',
			[
				'label' 		=> __( 'Menu Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .menu-style1 > ul > li > a' => 'color: {{VALUE}} !important;',
                ]
			]
        );

        $this->add_control(
			'top_level_menu_hover_color',
			[
				'label' 			=> __( 'Menu Hover Color', 'luxrio' ),
				'type' 				=> Controls_Manager::COLOR,
				'selectors' 		=> [
					'{{WRAPPER}} .menu-style1 > ul > li > a:hover' => 'color: {{VALUE}} !important;',
                ]
			]
        );

        $this->add_control(
			'top_level_menu_bg_color',
			[
				'label' 			=> __( 'Menu Background Color', 'luxrio' ),
				'type' 				=> Controls_Manager::COLOR,
				'selectors' 		=> [
					'{{WRAPPER}} .menu-style1 > ul > li > a' => 'background-color: {{VALUE}} !important;',
                ]
			]
		);

		$this->add_control(
			'top_level_menu_hover_bg_color',
			[
				'label' 		=> __( 'Menu Hover Background Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .menu-style1 > ul > li > a:hover' => 'background-color: {{VALUE}} !important;',
                ]
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'top_level_menu_typography',
				'label' 		=> __( 'Menu Typography', 'luxrio' ),
                'selector' 		=> '{{WRAPPER}} .menu-style1 > ul > li > a',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'top_level_menu_typography_hover',
				'label' 		=> __( 'Menu Typography Hover', 'luxrio' ),
                'selector' 		=> '{{WRAPPER}} .menu-style1 > ul > li > a:hover',
			]
		);

        $this->add_responsive_control(
			'top_level_menu_margin',
			[
				'label' 		=> __( 'Menu Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .menu-style1 > ul > li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
        );

        $this->add_responsive_control(
			'top_level_menu_padding',
			[
				'label' 		=> __( 'Menu Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .menu-style1 > ul > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'top_level_menu_border',
				'label' 	=> __( 'Border', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .menu-style1 > ul > li > a',
			]
		);

		$this->end_controls_section();


    }

    protected function luxrio_menu_select(){
	    $luxrio_menu = wp_get_nav_menus();
	    $menu_array  = array();
		$menu_array[''] = __( 'Select A Menu','luxrio' );
	    foreach( $luxrio_menu as $menu ){
	        $menu_array[ $menu->slug ] = $menu->name;
	    }
	    return $menu_array;
	}

	protected function render() {

        $settings = $this->get_settings_for_display();
		if( !empty( $settings['luxrio_menu_select'] ) ){
            echo '<nav class="main-menu menu-style2">';
                wp_nav_menu( array(
                    'menu'              => $settings['luxrio_menu_select'],
                    'menu_class'        => "",
                    'container'         => "" 
                ) );
			echo '</nav>';
        }
	}
}
$widgets_manager->register( new \Luxrio_HeaderMenu() );