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
class Luxrio_Footer_Menu_List extends Widget_Base {

	public function get_name() {
		return 'luxriolisttext';
	}

	public function get_title() {
		return __( 'Menu List', 'luxrio' );
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
				'label' 	=> __( 'Menu List', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'menu_style',
			[
				'label' 	=> __( 'Menu Style', 'luxrio' ),
                'type' 		=> Controls_Manager::SELECT,
                'options'   => [
                    '1'   		=> __( 'Style One', 'luxrio' ),
                    '2'   		=> __( 'Style Two', 'luxrio' ),
                ],
                'default'  	=> '1'
			]
        );

        $repeater = new Repeater();

		$repeater->add_control(
			'list_text',
			[
				'label' 	=> __( 'Name', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXT,
                'default'  	=> __( 'Home', 'luxrio' )
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
				'label' 		=> __( 'Footer Menus', 'luxrio' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'list_text'    => __( 'Home', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),

                    ],
					[
						'list_text'    => __( 'About', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),

                    ],
					[
						'list_text'    => __( 'Service', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),

                    ],
					[
						'list_text'    => __( 'Contact', 'luxrio' ),
						'text_link'    => __( '#', 'luxrio' ),

                    ],

                ],
                'title_field' 	=> '{{{ list_text }}}',
			]
		);

        $this->end_controls_section();

	}
	protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
			<?php
				$style_two_class='';
				if($settings['menu_style'] == 2){
				$style_two_class = '2';
				};
			?>
            <div class="footer-menu<?php echo esc_attr($style_two_class);?>">
				<?php foreach( $settings[ 'list_texts' ] as $lists ):
					?>
					<a href="<?php echo esc_url( $lists['text_link']['url'] ); ?>">
						<?php echo esc_html( $lists[ 'list_text' ] ); ?>
					</a>
				<?php endforeach; ?>
            </div>
        <?php 
	}
}
$widgets_manager->register( new \Luxrio_Footer_Menu_List() );