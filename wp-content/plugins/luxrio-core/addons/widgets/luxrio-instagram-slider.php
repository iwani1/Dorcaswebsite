<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
/**
 *
 * Instagram Slider Widget .
 *
 */
class Luxrio_Instagram_Slider extends Widget_Base{

	public function get_name() {
		return 'luxrioinstagramslider';
	}

	public function get_title() {
		return __( 'Instagram Slider', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'testimonial_slider_section',
			[
				'label' 	=> __( 'Instagram Slider', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'instagram_style',
			[
				'label' 	=> __( 'Instagram Style', 'luxrio' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> '1',
				'options' 	=> [
					'1'  		=> __( 'Style One', 'luxrio' ),
					'2' 		=> __( 'Style Two', 'luxrio' ),
				],
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'instagram_image',
			[
				'label' 		=> __( 'Instagram Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $repeater->add_control(
			'instagram_url',
			[
				'label'         => __('URL', 'luxrio'),
				'type'          => Controls_Manager::TEXT,
				'label_block'   => true,
                'default'       => __( '#', 'luxrio' ),
			]
		);

		$this->add_control(
			'slides',
			[
				'label' 		=> __( 'Slides', 'luxrio' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'instagram_image' 		=> Utils::get_placeholder_image_src(),
					],
					[
						'instagram_image' 		=> Utils::get_placeholder_image_src(),
					],
					[
						'instagram_image' 		=> Utils::get_placeholder_image_src(),
					],
					[
						'instagram_image' 		=> Utils::get_placeholder_image_src(),
					],
					[
						'instagram_image' 		=> Utils::get_placeholder_image_src(),
					],
					[
						'instagram_image' 		=> Utils::get_placeholder_image_src(),
					],
					[
						'instagram_image' 		=> Utils::get_placeholder_image_src(),
					],
				],
			]
		);

        $this->add_control(
			'icon',
			[
				'label'     => __('Icon', 'luxrio'),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'     => 'fas fa-star',
					'library'   => 'solid',
				],
				'condition' => ['instagram_style' => '1']
			]
		);

        $this->add_control(
			'instagram_text',
			[
				'label'         => __('Text', 'luxrio'),
				'type'          => Controls_Manager::TEXT,
				'label_block'   => true,
                'default'       => __( 'Instagram', 'luxrio' ),
				'condition'     => ['instagram_style' => '2']
			]
		);

		$this->end_controls_section();

        

        $this->start_controls_section( 
			'slider_settings',
			[
				'label' 	=> __( 'Slider Settings', 'luxrio' ),
                'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );
		$this->add_control(
			'slider_autoplay',
			[
				'label' 		=> __( 'Autoplay', 'luxrio' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'luxrio' ),
				'label_off' 	=> __( 'No', 'luxrio' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);
		$this->add_control(
			'slider_arrow',
			[
				'label' 		=> __( 'Arrow', 'luxrio' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'luxrio' ),
				'label_off' 	=> __( 'No', 'luxrio' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);
        $this->add_control(
			'slide_to_show',
			[
				'label' 		=> __( 'Slide To Show', 'luxrio' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'range' 		=> [
					'px' 			=> [
						'min' 			=> 0,
						'max' 			=> 10,
						'step'			=> 1,
					],
				],
				'default' 	=> [
					'unit' 		=> 'px',
					'size' 		=> 3,
				],
			]
		);
		$this->end_controls_section();
		


	}
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'instagram-carousel' );

		if( $settings['slider_autoplay'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'true' );
		} else {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'false' );
		}

        $this->add_render_attribute( 'wrapper', 'data-slide-to-show', $settings['slide_to_show']['size'] );

		?>
        <div class="instagram-layout<?php echo esc_attr( $settings['instagram_style'] ); ?>">
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <?php foreach( $settings['slides'] as $slide ): ?>
                    <div>
                        <div class="insta-style">
                            <?php echo luxrio_img_tag( array(
                                'url'	=> esc_url( $slide['instagram_image']['url']  ),
                            ) );
                            ?>
                            <a href="<?php echo esc_url( $slide['instagram_url'] );?>" class="insta-icon">
                                <?php if( $settings['instagram_style'] == '1' ): ?>
                                <?php \Elementor\Icons_Manager::render_icon($settings["icon"], ['aria-hidden' => 'true']); ?>
                                
                                <?php elseif( $settings['instagram_style'] == '2' ):?>
                                    <?php echo esc_html( $settings['instagram_text'] );?>
                                <?php endif;?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
			
		<?php 
	}
}
$widgets_manager->register( new \Luxrio_Instagram_Slider() );