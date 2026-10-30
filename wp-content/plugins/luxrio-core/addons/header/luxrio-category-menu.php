<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Gallery Image Widget .
 *
 */
class Luxrio_Category_Menu extends Widget_Base {

	public function get_name() {
		return 'luxriocategorymenu';
	}

	public function get_title() {
		return __( 'Category Menu', 'luxrio' );
	}


	public function get_icon() {
		return 'eicon-code';
    }


	public function get_categories() {
		return [ 'luxrio' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'list_section',
			[
				'label' 	=> __( 'Category Menu', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

        $repeater = new Repeater();

		$repeater->add_control(
			'list_text',
			[
				'label' 	=> __( 'Category Name', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXT,
                'default'  	=> __( 'Home', 'luxrio' )
			]
        );
        $repeater->add_control(
            'image',
            [
                'label' => __('Choose Category Image', 'luxrio'),
                'type'  => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );
        $repeater->add_control(
            'text_link',
            [
                'label' 		=> __( 'Link', 'luxrio' ),
                'type' 			=> Controls_Manager::URL,
                'placeholder' 	=> __( 'https://your-link.com', 'luxrio' ),
                'show_external' => true,
                'default' 		=> [
                    'url' 			=> '#',
                    'is_external' 	=> true,
                    'nofollow' 		=> true,
                ],
            ]
        );
		$this->add_control(
			'list_texts',
			[
				'label' 		=> __( 'Category Name', 'luxrio' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'list_text'    => __( 'Fashion', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),
                    ],
					[
						'list_text'    => __( 'Watch', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),
                    ],
					[
						'list_text'    => __( 'Earrings', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),
                    ],
					[
						'list_text'    => __( 'Necklace', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),
                    ],
					[
						'list_text'    => __( 'Rings', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),
                    ],
					[
						'list_text'    => __( 'Classic', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),
                    ],

                ],
                'title_field' 	=> '{{{ list_text }}}',
			]
		);

        $this->end_controls_section();

        // Add Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'luxrio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        // Menu Item Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'menu_typography',
                'label'    => __('Menu Typography', 'luxrio'),
                'selector' => '{{WRAPPER}} .menu-item a',
            ]
        );
        
        // Menu Item Color
        $this->add_control(
            'menu_color',
            [
                'label'     => __('Menu Color', 'luxrio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item a' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        // Menu Item Hover Color
        $this->add_control(
            'menu_hover_color',
            [
                'label'     => __('Menu Hover Color', 'luxrio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        // Menu Icon Color
        $this->add_control(
            'menu_icon_color',
            [
                'label'     => __('Menu Icon Color', 'luxrio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-icon path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        // Menu Icon hover Color
        $this->add_control(
            'menu_icon_hover_color',
            [
                'label'     => __('Menu Icon Hover Color', 'luxrio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-toggle:hover .menu-icon path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_section();

	}
	protected function render() {
        $settings = $this->get_settings_for_display();

        echo '<div class="menu-wrapper">';
            echo '<div class="menu-category">';
                echo '<button class="menu-toggle">';
                    echo '<svg class="menu-icon" width="31" height="23" viewBox="0 0 31 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="line1" d="M7 1.5C7 0.671573 7.67157 0 8.5 0H29.5C30.3284 0 31 0.671573 31 1.5C31 2.32843 30.3284 3 29.5 3H8.5C7.67157 3 7 2.32843 7 1.5Z" fill="white"></path>
                    <path class="line2" d="M0 11.5C0 10.6716 0.671573 10 1.5 10H29.5C30.3284 10 31 10.6716 31 11.5C31 12.3284 30.3284 13 29.5 13H1.5C0.671573 13 0 12.3284 0 11.5Z" fill="white"></path>
                    <path class="line3" d="M7 21.5C7 20.6716 7.67157 20 8.5 20H29.5C30.3284 20 31 20.6716 31 21.5C31 22.3284 30.3284 23 29.5 23H8.5C7.67157 23 7 22.3284 7 21.5Z" fill="white"></path>
                    </svg>';
                echo '</button>';
                echo '<ul class="menu-list">';
                    foreach( $settings[ 'list_texts' ] as $lists ){
                        echo '<li class="menu-item">';
                            echo '<a href="'.esc_url( $lists['text_link']['url'] ).'">';
                                if( ! empty( $lists['image']['url'] ) ){
                                    echo '<span class="icon">';
                                        echo luxrio_img_tag( array(
                                            'url'   => esc_url( $lists['image']['url'] )
                                        ) );
                                    echo '</span>';
                                }
                                echo esc_html( $lists[ 'list_text' ] );
                            echo '</a>';
                        echo '</li>';
                    }
                echo '</ul>';
            echo '</div>';
        echo '</div>';
	}
}
$widgets_manager->register( new \Luxrio_Category_Menu() );