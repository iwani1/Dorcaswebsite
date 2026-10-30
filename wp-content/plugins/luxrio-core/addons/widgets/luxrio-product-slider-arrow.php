<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Image Widget .
 *
 */
class Luxrio_Prodcut_Slider_Arrow extends Widget_Base {

	public function get_name() {
		return 'luxrioprodcutsliderarrow';
	}
     
	public function get_title() {
		return __( 'Prodcut Slider Arrow', 'luxrio' );
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
				'label' 	=> __( 'Product Arrow', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );


		$this->end_controls_section();

	}

	protected function render() {

        $settings = $this->get_settings_for_display();
        ?>
            <div class="carousel-arrow2">
                <button data-slick-prev=".product-slider">
                <svg width="9" height="18" viewBox="0 0 9 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.08984 16.92L1.56984 10.4C0.799843 9.62996 0.799843 8.36996 1.56984 7.59996L8.08984 1.07996" stroke="#EEDCB3" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                </button>
                <button class="btn-right" data-slick-next=".product-slider">
                <svg width="9" height="18" viewBox="0 0 9 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.910156 16.92L7.43016 10.4C8.20016 9.62996 8.20016 8.36996 7.43016 7.59996L0.910156 1.07996" stroke="#EEDCB3" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                </button>
            </div>
        <?php
	}
}
$widgets_manager->register( new \Luxrio_Prodcut_Slider_Arrow() );