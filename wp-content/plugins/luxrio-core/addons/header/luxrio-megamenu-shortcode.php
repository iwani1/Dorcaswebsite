<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
/**
 * 
 * Menu Shortcode Widget .
 *
 */
class Luxrio_Menu_Shortcode extends Widget_Base {

	public function get_name() {
		return 'luxriomenushortocde';
	}

	public function get_title() {
		return __( 'Menu Shortcode', 'luxrio' );
	}


	public function get_icon() {
		return 'eicon-code';
    }
    

	public function get_categories() {
		return [ 'luxrio_header_elements' ];
	}

	
	protected function _register_controls() {

		$this->start_controls_section(
			'menu_shortocde_section',
			[
				'label' => __( 'Menu Shortcode', 'luxrio' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
        
        $this->add_control(
			'menu_shortocde',
			[
				'label' => __( 'Shortcode', 'luxrio' ),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder'  => __( '[shortcode here]', 'luxrio' )
			]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
			'menu_top_level_menu_item_style_section',
			[
				'label' => __( 'Top Level Menu Items', 'luxrio' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'top_level_menu_alignment',
			[
				'label' => __( 'Menu Alignment', 'luxrio' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'luxrio' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'luxrio' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'luxrio' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu' => 'text-align: {{VALUE}} !important;',
				],
				'toggle' => true,
			]
		);
        
        $this->add_control(
			'top_level_menu_color',
			[
				'label' => __( 'Menu Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li > a' => 'color: {{VALUE}} !important;',
                ]
			]
        );
        
        $this->add_control(
			'top_level_menu_hover_color',
			[
				'label' => __( 'Menu Hover Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li > a:hover' => 'color: {{VALUE}} !important;',
                ]
			]
        );
        
        $this->add_control(
			'top_level_menu_bg_color',
			[
				'label' => __( 'Menu Background Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li > a' => 'background-color: {{VALUE}} !important;',
                ]
			]
		);
		
		$this->add_control(
			'top_level_menu_hover_bg_color',
			[
				'label' => __( 'Menu Hover Background Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li > a:hover' => 'background-color: {{VALUE}} !important;',
                ]
			]
		);
		
		$this->add_control(
			'top_level_menu_current_item_color',
			[
				'label' => __( 'Menu Current Item Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-current-menu-item > a' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} ul.mega-menu > li.mega-current-menu-ancestor.mega-current-menu-parent > a' => 'color: {{VALUE}} !important;',
                ]
			]
        );
		
		$this->add_control(
			'top_level_menu_current_item_bg_color',
			[
				'label' => __( 'Menu Current Item Background Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-current-menu-item > a' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} ul.mega-menu > li.mega-current-menu-ancestor.mega-current-menu-parent > a' => 'background-color: {{VALUE}} !important;',
                ]
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'top_level_menu_typography',
				'label' => __( 'Menu Typography', 'luxrio' ),
                'selector' => '{{WRAPPER}} ul.mega-menu > li > a',
			]
		);

        $this->add_responsive_control(
			'top_level_menu_margin',
			[
				'label' => __( 'Menu Margin', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
        );
        
        $this->add_responsive_control(
			'top_level_menu_padding',
			[
				'label' => __( 'Menu Padding', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
		);

		$this->add_control(
			'top_level_menu_height',
			[
				'label' 		=> __( 'Height', 'luxrio' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 0,
						'step' 	=> 1,
						'max'	=> 500
					],
				],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li > a' => 'height: {{SIZE}}{{UNIT}} !important;line-height: {{SIZE}}{{UNIT}} !important;'
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'top_level_menu_border',
				'label' => __( 'Border', 'luxrio' ),
				'selector' => '{{WRAPPER}} ul.mega-menu > li > a',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'flyout_menu_item_style_section',
			[
				'label' => __( 'Flyout Menu', 'luxrio' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'flyout_submenu_bg_color',
			[
				'label' => __( 'Sub Menu Background', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul' => 'background-color: {{VALUE}} !important;',
                ]
			]
		);
		
		$this->add_control(
			'flyout_submenu_width',
			[
				'label' 		=> __( 'Sub Menu Width', 'luxrio' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 0,
						'step' 	=> 1,
						'max'	=> 500
					],
				],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul' => 'width: {{SIZE}}{{UNIT}} !important;',
                ]
			]
		);

		$this->add_responsive_control(
			'flyout_submenu_padding',
			[
				'label' => __( 'Sub Menu Padding', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'flyout_submenu_border',
				'label' => __( 'Sub Menu Border', 'luxrio' ),
				'selector' => '{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul',
			]
		);

		$this->add_responsive_control(
			'flyout_submenu_border_radius',
			[
				'label' => __( 'Sub Menu Border Radius', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				]
			]
		);

		$this->add_control(
			'flyout_menu_item_color',
			[
				'label' => __( 'Menu Item Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul li a' => 'color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'flyout_menu_item_bg_color',
			[
				'label' => __( 'Menu Item Background Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul li a' => 'background-color: {{VALUE}} !important;',
                ]
			]
		);

		$this->add_control(
			'flyout_menu_item_hover_color',
			[
				'label' => __( 'Menu Item Hover Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul li a:hover' => 'color: {{VALUE}} !important;',
                ]
			]
		);

		$this->add_control(
			'flyout_menu_item_hover_bg_color',
			[
				'label' => __( 'Menu Item Hover Background Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul li a:hover' => 'background-color: {{VALUE}} !important;',
                ]
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'flyout_menu_item_typography',
				'label' => __( 'Menu Item Typography', 'luxrio' ),
                'selector' => '{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul li a',
			]
		);

        $this->add_responsive_control(
			'flyout_menu_item_margin',
			[
				'label' => __( 'Menu Item Margin', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
        );
        
        $this->add_responsive_control(
			'flyout_menu_item_padding',
			[
				'label' => __( 'Menu Item Padding', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
		);

		$this->add_control(
			'flyout_menu_item_height',
			[
				'label' 		=> __( 'Menu Item Height', 'luxrio' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 0,
						'step' 	=> 1,
						'max'	=> 500
					],
				],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu li.mega-menu-flyout ul li a' => 'height: {{SIZE}}{{UNIT}} !important;',
                ]
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'mega_menu_style_section',
			[
				'label' => __( 'Mega Menu', 'luxrio' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
			'megamenu_panel_width',
			[
				'label' 		=> __( 'Megamenu Panel Width', 'luxrio' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 0,
						'step' 	=> 1,
						'max'	=> 2000
					],
				],
				'selectors' => [
					'{{WRAPPER}} #mega-menu-wrap-primary-menu #mega-menu-primary-menu li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-row' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                ]
			]
		);  
        $this->add_control(
			'megamenu_panel_bg_color',
			[
				'label' => __( 'Panel Background', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu' => 'background-color: {{VALUE}} !important;',
                ]
			]
		);

		$this->add_responsive_control(
			'megamenu_panel_padding',
			[
				'label' => __( 'Panel Padding', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
		);

		$this->add_responsive_control(
			'megamenu_column_padding',
			[
				'label' => __( 'Column Padding', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
		);

		$this->add_control(
			'megamenu_second_level_items',
			[
				'label' => __( 'Second Level Menu Items', 'luxrio' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'megamenu_second_level_item_color',
			[
				'label' => __( 'Item Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link' => 'color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'megamenu_second_level_item_hover_color',
			[
				'label' => __( 'Item Hover Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:hover' => 'color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'megamenu_second_level_item_bg_color',
			[
				'label' => __( 'Item Background Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link' => 'background-color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'megamenu_second_level_item_bg_hover_color',
			[
				'label' => __( 'Item Hover Background Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:hover' => 'background-color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'megamenu_second_level_item_typography',
				'label' => __( 'Item Typography', 'luxrio' ),
                'selector' => '{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link',
			]
		);

		$this->add_responsive_control(
			'megamenu_second_level_item_padding',
			[
				'label' => __( 'Item Padding', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
		);

        $this->add_responsive_control(
			'megamenu_second_level_item_margin',
			[
				'label' => __( 'Item Margin', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
		);
		
		$this->add_control(
			'megamenu_third_level_items',
			[
				'label' => __( 'Third Level Menu Items', 'luxrio' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'megamenu_third_level_item_color',
			[
				'label' => __( 'Item Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link' => 'color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'megamenu_third_level_item_hover_color',
			[
				'label' => __( 'Item Hover Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link:hover' => 'color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'megamenu_third_level_item_bg_color',
			[
				'label' => __( 'Item Background Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link' => 'background-color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_control(
			'megamenu_third_level_item_bg_hover_color',
			[
				'label' => __( 'Item Hover Background Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link:hover' => 'background-color: {{VALUE}} !important;',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'megamenu_third_level_item_typography',
				'label' => __( 'Item Typography', 'luxrio' ),
                'selector' => '{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link',
			]
		);

		$this->add_responsive_control(
			'megamenu_third_level_item_padding',
			[
				'label' => __( 'Item Padding', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
		);

        $this->add_responsive_control(
			'megamenu_third_level_item_margin',
			[
				'label' => __( 'Item Margin', 'luxrio' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ul.mega-menu > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
			]
        );


		$this->end_controls_section();

	}

	protected function render() {

        $settings = $this->get_settings_for_display();
        // if ( function_exists('max_mega_menu_is_enabled') ) {
			
            echo '<nav class="main-menu menu-style2">';
				wp_nav_menu( array(
					"theme_location"    => 'primary-menu',
					"container"         => '',
					"menu_class"        => ''
				) );
            echo '</nav>';
		// }
        
	}

}

$widgets_manager->register( new \Luxrio_Menu_Shortcode() );