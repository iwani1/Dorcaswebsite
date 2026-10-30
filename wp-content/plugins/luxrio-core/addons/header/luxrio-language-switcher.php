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
class Luxrio_Language_Switcher extends Widget_Base {

	public function get_name() {
		return 'luxriolanguageswitcher';
	}

	public function get_title() {
		return __( 'Gtranslate', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio_header_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'gtranslate',
			[
				'label' 	=> __( 'Gtranslate', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );
		$this->add_control(
			'style_select',
			[
				'label' 		=> __( 'Please Select Your Style From Gtranslate', 'luxrio' ),
				'type' 			=> Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'show_loginbar',
			[
				'label' => esc_html__( 'Login Bar', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor' ),
				'label_off' => esc_html__( 'No', 'elementor' ),
				'default' => 'no',
			]
		);

		$this->add_control(
			'login_link',
			[
				'label' 		=> __( 'Url', 'luxrio' ),
				'type' 			=> Controls_Manager::URL,
                'placeholder' 	=> __( 'https://your-link.com', 'luxrio' ),
                'show_external' => true,
				'default' 		=> [
					'url' 			=> '#',
					'is_external' 	=> true,
					'nofollow' 		=> true,
				],
				'condition' => [
					'show_loginbar' => 'yes',
				],
			]
        );

        $this->end_controls_section();


    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        echo '<div class="col-auto d-flex">';
			if( class_exists( 'Gtranslate' ) ){
				echo '<div class="header-dropdown">';
					echo '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false">English</a>';
					echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">';
						echo '<li>';
							echo do_shortcode('[gtranslate]');
						echo '</li>';
					echo '</ul>';
				echo '</div>';
			}
			if(  'yes' == $settings['show_loginbar'] ){	
				?>
					<a class="user-btn" href="<?php echo esc_url( $settings['login_link']['url'] ); ?>">
						<i class="far fa-user-circle"></i>
					</a>
				<?php 
			}
		echo '</div>';
		

	}

}
$widgets_manager->register( new \Luxrio_Language_Switcher() );