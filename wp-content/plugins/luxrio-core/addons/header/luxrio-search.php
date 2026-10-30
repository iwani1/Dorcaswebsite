<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;
/**
 *
 * Header Widget .
 *
 */
class Luxrio_Search extends Widget_Base {

	public function get_name() {
		return 'luxriosearch';
	}

	public function get_title() {
		return __( 'Search Form', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio_header_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'header_search',
			[
				'label' 	=> __( 'Header Search And Login', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'header_search_version',
			[
				'label' 		=> __( 'Header Search Version', 'luxrio' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '1',
				'options' 		=> [
					'1'  			=> __( 'Version One', 'luxrio' ),
					'2' 			=> __( 'Version Two', 'luxrio' ),
				],
			]
		);

		$this->add_control(
			'placeholder_text',
			[
				'label' 		=> __( 'What are you looking for', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXT,
				'default'		=> __( 'Search Here...', 'luxrio' ),
				'label_block'   => true,
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'search_style',
			[
				'label' 	=> __( 'Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'search_color',
			[
				'label' 		=> __( 'Search Icon Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wc-link2 svg path' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .header-search button i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'placeholder_color',
			[
				'label' 		=> __( 'Search Placeholder Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .header-search input' => 'color: {{VALUE}}',
					'{{WRAPPER}} .header-search input::placeholder' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'border_bottom_color',
			[
				'label' 		=> __( 'Border Bottom Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .header-search::after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'border_bottom_color_hover',
			[
				'label' 		=> __( 'Border Bottom Hover Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .header-search:hover::after,{{WRAPPER}} .header-search:focus::after' => 'background-color: {{VALUE}}',
				],
			]
		);
		

		$this->end_controls_section();


    }

	protected function render() {

        $settings = $this->get_settings_for_display();

		if( $settings['header_search_version'] == '1' ){
			echo '<button class="wc-link2 searchBoxTggler"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.084 18.3333C14.6403 18.3333 18.334 14.6397 18.334 10.0833C18.334 5.52698 14.6403 1.83333 10.084 1.83333C5.52764 1.83333 1.83398 5.52698 1.83398 10.0833C1.83398 14.6397 5.52764 18.3333 10.084 18.3333Z" stroke="#EBEBEB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M17.3517 18.9657C17.8376 20.4323 18.9467 20.579 19.7992 19.2957C20.5784 18.1223 20.0651 17.1598 18.6534 17.1598C17.6084 17.1507 17.0217 17.9665 17.3517 18.9657Z" stroke="#EBEBEB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg></button>';
		}elseif($settings['header_search_version'] == '2'){
			echo '<form action="'.esc_url( home_url('/') ).'" class="header-search">';
              	echo '<input name="s" type="text" placeholder="'.esc_attr( $settings['placeholder_text'] ).'">';
              	echo '<button type="submit" aria-label="search-button"><i class="fas fa-search"></i></button>';
            echo '</form>';
		}

	}

}
$widgets_manager->register( new \Luxrio_Search() );
