<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Product Category Widget .
 *
 */
class Luxrio_Product_Category_Slider extends Widget_Base{

	public function get_name() {
		return 'luxrioproductcategoryslider';
	}

	public function get_title() {
		return __( 'Product Category Slider', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section',
			[
				'label' 	=> __( 'Product Category Slider', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
		);

		
		$repeater = new Repeater();

		$repeater->add_control(
			'category_image',
			[
				'label' 		=> __( 'Category Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'category_name', [
				'label' 		=> __( 'Category Name', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'Wedding Ring' , 'luxrio' ),
				'label_block' 	=> true,
			]
        );

		$repeater->add_control(
			'category_url', [
				'label' 		=> __( 'Category Url', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( '#' , 'luxrio' ),
				'label_block' 	=> true,
			]
        );

		$repeater->add_control(
			'category_stock', [
				'label' 		=> __( 'Category Stock Amount', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( '20 Product' , 'luxrio' ),
				'label_block' 	=> true,
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
						'category_name' 		=> __( 'wedding ring', 'luxrio' ),
						'category_image' 		=> Utils::get_placeholder_image_src(),
					],
					[
						'category_name' 		=> __( 'Diamond Pendant', 'luxrio' ),
						'category_image' 		=> Utils::get_placeholder_image_src(),
					],
					[
						'category_name' 		=> __( 'Woman Earring', 'luxrio' ),
						'category_image' 		=> Utils::get_placeholder_image_src(),
					],
				],
				'title_field' 	=> '{{{ category_name }}}',
			]
		);

		$this->end_controls_section();
		
        $this->start_controls_section(
			'category_name_style_section',
			[
				'label' 	=> __( 'Category Name', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'category_name_color',
			[
				'label' 		=> __( 'Category Name Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .cate-style1 .cate-title a' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_control(
			'category_name_hover_color',
			[
				'label' 		=> __( 'Category Name Hover Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .cate-style1 .cate-title a:hover' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'category_name_typography',
				'label' 	=> __( 'Category Name Typography', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .cate-style1 .cate-title',
			]
        );

        $this->add_responsive_control(
			'category_name_margin',
			[
				'label' 		=> __( 'Category Name Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .cate-style1 .cate-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );
        $this->end_controls_section();

        $this->start_controls_section(
			'category_stock_style_section',
			[
				'label' 	=> __( 'Category Stock', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'category_stock_color',
			[
				'label' 	=> __( 'Category Stock Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cate-style1 .cate-stock' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'category_stock_typography',
				'label' 	=> __( 'Feedback Typography', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .cate-style1 .cate-stock',
			]
        );

        $this->add_responsive_control(
			'category_stock_margin',
			[
				'label' 		=> __( 'Feedback Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .cate-style1 .cate-stock' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );
        $this->end_controls_section();


		// slider contrl
		$this->start_controls_section(
			'slider_control_section',
			[
				'label' 		=> __( 'Slider Control', 'wellnez' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'slider_autoplay',
			[
				'label' 		=> __( 'Autoplay?', 'luxrio' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'luxrio' ),
				'label_off' 	=> __( 'No', 'luxrio' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'no',
			]
		);

		$this->add_control(
			'slide_to_show',
			[
				'label' 		=> __( 'Slide To Show', 'wellnez' ),
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
					'size' 		=> 2,
				],
			]
		);
        $this->end_controls_section();

	}
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'row category-slider2 ' );
        $this->add_render_attribute( 'wrapper', 'data-slide-to-show', $settings['slide_to_show']['size'] );

		if( $settings['slider_autoplay'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'true' );
		} else {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'false' );
		}

		?>

        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php foreach( $settings[ 'slides' ] as $slide ): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="cate-style1 style2">
                        <?php
                            if( ! empty( $slide['category_image']['url'] ) ){
                                echo '<div class="cate-img">';
                                    echo luxrio_img_tag( array(
                                        'url'	=> esc_url( $slide['category_image']['url'] ),
                                    ) );
                                echo '</div>';
                            }
                            if( ! empty( $slide['category_name'] ) ){
                                echo '<h3 class="cate-title">';
                                    echo '<a href="'.esc_url( $slide['category_url'] ).'">'.esc_html( $slide['category_name'] ).'</a>';
                                echo '</h3>';
                            }
                            if( ! empty( $slide['category_stock'] ) ){
                                echo '<span class="cate-stock">'.esc_html( $slide['category_stock'] ).'</span>';
                            }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

		<?php 
	}
}
$widgets_manager->register( new \Luxrio_Product_Category_Slider() );