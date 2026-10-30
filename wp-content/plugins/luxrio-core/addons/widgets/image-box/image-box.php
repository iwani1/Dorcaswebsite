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
class Luxrio_Image_Box extends Widget_Base {

	public function get_name() {
		return 'luxrioimagebox';
	}
     
	public function get_title() {
		return __( 'Image Box', 'luxrio' );
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
				'label' 	=> __( 'Image Box', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'imagebox_layout',
			[
				'label' => __( 'Style', 'luxrio' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => __( 'Style 1', 'luxrio' ),
					'2' => __( 'Style 2', 'luxrio' ),
				],
			]
		);
		// img start
        $this->add_control(
			'image_one',
			[
				'label' 		=> __( 'Image One', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'image_two', 
			[
				'label' 		=> __( 'Image Two', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
			]
		);
        $this->add_control(
			'image_three', 
			[
				'label' 		=> __( 'Image Three', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
				'condition'		=> ['imagebox_layout' => '2']
			]
		);
        $this->add_control(
			'image_four', 
			[
				'label' 		=> __( 'Image Four', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
				'condition'		=> ['imagebox_layout' => '2']
			]
		);

		$this->add_control(
			'image_caption',
			[
				'label' 	=> __( 'Image Caption', 'luxrio' ),
				'type' 		=> Controls_Manager::TEXTAREA,
				'default'  	=> __( '15% Off', 'luxrio' ),
				'label_block' 	=> true,
				
				'condition'		=> ['imagebox_layout' => '1']
			]
		);

		$this->end_controls_section();

		// 
		$this->start_controls_section(
			'style_section',
			[
				'label' 	=> __( 'Content Box', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
				'condition'		=> [ 'imagebox_layout' => [ '1', '3' ] ],
			]
        );

		$this->add_control(
			'mdeia_color',
			[
				'label' 		=> __( 'Top Title', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-infobox--style .vs-infobox__title, {{WRAPPER}} .counter-box--style1 .counter-box__number' => 'color: {{VALUE}} !important',
                ]
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'mdeia_typography',
				'label'         => __( 'Title Typography', 'luxrio' ),
                'selector'      => '{{WRAPPER}} .vs-infobox--style .vs-infobox__title, {{WRAPPER}} .counter-box--style1 .counter-box__number',
			]
		);

		$this->add_control(
			'subtitles',
			[
				'label' => esc_html__( 'Title', 'luxrio' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'label' 		=> __( 'Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-infobox--style .vs-infobox__number, {{WRAPPER}} .counter-box--style1 .counter-box__title' => 'color: {{VALUE}} !important',
                ]
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'subtitle_typography',
				'label'         => __( 'Typography', 'luxrio' ),
                'selector'      => '{{WRAPPER}} .vs-infobox--style .vs-infobox__number, {{WRAPPER}} .counter-box--style1 .counter-box__title',
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

        $settings = $this->get_settings_for_display();
		$imagebox = $settings[ 'imagebox_layout' ];
		
		?>
        <?php 	
            if ($imagebox) {
                include(''.$imagebox.'.php');
            }
        ?>
	<?php
	}
}
$widgets_manager->register( new \Luxrio_Image_Box() );