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
class Luxrio_Offcanvas extends Widget_Base {

	public function get_name() {
		return 'luxriooffcanvas';
	}

	public function get_title() {
		return __( 'Offcanvas', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio_header_elements' ];
	}

	protected function register_controls() {

		

		$this->start_controls_section(
			'offcanvas_section',
			[
				'label' 	=> __( 'Offcanvas', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'luxrio_Offcanvas_builder',
			[
				'label'     => __( 'Select Offcanvas', 'luxrio' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->luxrio_offcanvas_one(),
				'default'	=> ''
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label' 		=> __( 'Icon Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .sideMenuToggler svg path' => 'fill: {{VALUE}}',
                ],
			]
        );

		$this->add_control(
			'icon_bg_hover_color',
			[
				'label' 		=> __( 'Icon Hover Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .sideMenuToggler:hover svg path' => 'fill: {{VALUE}}',
                ],
			]
        );

		$this->add_control(
			'offcanvas_bg_color',
			[
				'label' 		=> __( 'Offcanvas Background Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .sidemenu-wrapper .sidemenu-content' => 'background-color: {{VALUE}}',
                ],
			]
        );

        $this->end_controls_section();

    }


	public function luxrio_offcanvas_one(){

		$luxrio_post_query = new WP_Query( array(
			'post_type'				=> 'luxrio_off_build',
			'posts_per_page'	    => -1,
		) );

		$luxrio_tab_builder_title_title = array();
		$luxrio_tab_builder_title_title[''] = __( 'Select a Title','luxrio');

		while( $luxrio_post_query->have_posts() ) {
			$luxrio_post_query->the_post();
			$luxrio_tab_builder_title_title[ get_the_ID() ] =  get_the_title();
		}
		wp_reset_postdata();
		return $luxrio_tab_builder_title_title;
	}

	protected function render() {

        $settings = $this->get_settings_for_display();

		echo '<button class="sideMenuToggler d-none d-md-block">
			<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M0 10V0H10.5L15 5L20 0H29.5V10L25.5 15L29.5 19.5V30H20L15 25.5L10.5 30H0V19.5L5 15L0 10Z" fill="#EEE7D5"></path>
			</svg>
		</button>';

		echo '<div class="sidemenu-wrapper d-none d-md-block">';
			echo '<div class="sidemenu-content">';
				echo '<button class="closeButton sideMenuCls"><i class="fas fa-times"></i></button>';
					$elementor = \Elementor\Plugin::instance();
					echo $elementor->frontend->get_builder_content_for_display($settings['luxrio_Offcanvas_builder']);
			echo '</div>';
		echo '</div>';
		
	}
}
$widgets_manager->register( new \Luxrio_Offcanvas() );
?>
