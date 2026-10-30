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
/**
 *
 * Product Category Widget .
 *
 */
class Luxrio_Product_Category extends Widget_Base{

	public function get_name() {
		return 'luxrioproductcategory';
	}

	public function get_title() {
		return __( 'Product Category', 'luxrio' );
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
				'label' 	=> __( 'Product Category', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'left_side_big_image',
			[
				'label' 		=> __( 'Left Big Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'left_small_image',
			[
				'label' 		=> __( 'Left Small Shape Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'image_caption', [
				'label' 		=> __( 'Image Caption', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'Earring' , 'luxrio' ),
				'label_block' 	=> true,
			]
        );

		$this->add_control(
			'section_title',
			[
				'label' 	=> __( 'Section Title', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Section Title', 'luxrio' )
			]
        );

		$this->add_control(
			'section_subtitle',
			[
				'label' 	=> __( 'Section Subtitle', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Section Subtitle', 'luxrio' )
			]
        );

		$this->add_control(
			'shape_icon',
			[
				'label' 		=> __( 'Title Shape Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [ 'active' 		=> true ],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
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

		$this->add_control(
			'shape_one',
			[
				'label' 		=> __( 'Shape Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'general_style',
			[
				'label' 	=> __( 'General Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'         	=> 'category_background',
                'label'     	=> __( 'Background', 'luxrio' ),
				'selector' 		=> '{{WRAPPER}} .cate-layout1'
			]
		);

		$this->add_control(
			'category_box_bg_color',
			[
				'label' 	=> __( 'Category Box Bg Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cate-style1' => 'background-color: {{VALUE}}',
                ],
			]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style_section',
			[
				'label' => __( 'Section Title Style', 'luxrio' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_wrapper_margin',
			[
				'label' 		=> __( 'Section Wrapper Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .title-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

        $this->add_responsive_control(
			'section_wrapper_padding',
			[
				'label' 		=> __( 'Section Wrapper Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .title-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' 	=> 'after'
			]
		);

        $this->add_control(
			'section_title_color',
			[
				'label' 	=> __( 'Section Title Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sec-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'section_title!'    => ''
                ]
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'section_title_typography',
				'label' 	=> __( 'Section Title Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .sec-title',
                'condition' => [
                    'section_title!'    => ''
                ]
			]
		);

        $this->add_responsive_control(
			'section_title_margin',
			[
				'label' 		=> __( 'Section Title Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .sec-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'section_title!'    => ''
                ]
			]
        );

        $this->add_responsive_control(
			'section_title_padding',
			[
				'label' 		=> __( 'Section Title Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .sec-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' 	=> [
                    'section_title!'    => ''
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'border',
				'label' 	=> __( 'Border', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .sec-title',
				'condition' => [
                    'section_title!'    => ''
                ],
                'separator' => 'after'
			]
		);
		


		$this->add_control(
			'section_subtitle_color',
			[
				'label' 		=> __( 'Section Subtitle Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .sec-subtitle' => 'color: {{VALUE}}',
                ],
                'condition' 	=> [
                    'section_subtitle!'    => ''
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'section_subtitle_typography',
				'label' 	=> __( 'Section Subtitle Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .sec-subtitle',
                'condition' => [
                    'section_subtitle!'    => ''
                ],
			]
        );

        $this->add_responsive_control(
			'section_subtitle_margin',
			[
				'label' 		=> __( 'Section Subtitle Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .sec-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'section_subtitle!'    => ''
                ],
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

		$this->add_render_attribute( 'wrapper', 'class', 'row category-slider ' );
        $this->add_render_attribute( 'wrapper', 'data-slide-to-show', $settings['slide_to_show']['size'] );

		if( $settings['slider_autoplay'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'true' );
		} else {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'false' );
		}

		?>

    <section class="cate-layout1 space space-extra-bottom z-index-common">
		<?php 
			if( ! empty( $settings['shape_one']['url'] ) ){
				echo luxrio_img_tag( array(
					'url'	=> esc_url( $settings['shape_one']['url'] ),
					'class'	=> 'ele2'
				) );
			}
		?>

        
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-9 col-lg-8">
                    <div class="ps-xl-5">
                    <div class="title-area">
						<?php
							if( !empty( $settings['section_subtitle'] ) ) {
                        		echo '<span class="sec-subtitle">'.esc_html( $settings['section_subtitle'] ).'</span>';
							}
							if( !empty( $settings['section_title'] ) ) {
                        		echo '<h2 class="sec-title">'.esc_html( $settings['section_title'] ).'</h2>';
							}
							
							if( ! empty( $settings['shape_icon']['url'] ) ){
								echo luxrio_img_tag( array(
									'url'	=> esc_url( $settings['shape_icon']['url'] ),
								) );
							}
						?>
                    </div>
                    <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                        <?php foreach( $settings[ 'slides' ] as $slide ): ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="cate-style1">
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
                    </div>
                </div>
            </div>
        </div>
		<div class="img-box1">
			<?php 
				if( ! empty( $settings['left_side_big_image']['url'] ) ){
					echo luxrio_img_tag( array(
						'url'	=> esc_url( $settings['left_side_big_image']['url'] ),
						'class'	=> 'img1 it-scroll-element'
					) );
				}
			?>
            <div class="img-body it-scroll-element" data-it-scroll-speed="1.2" data-it-scroll-y="100">
			<?php 
				if( ! empty( $settings['left_small_image']['url'] ) ){
					echo luxrio_img_tag( array(
						'url'	=> esc_url( $settings['left_small_image']['url'] ),
						'class'	=> 'ele1'
					) );
				}
			?>
			<?php
				if( ! empty( $settings['image_caption'] ) ){
            		echo '<span class="img-caption">'.esc_html( $settings['image_caption'] ).'</span>';
				}
			?>
            </div>
        </div>
    </section>

		<?php 
	}
}
$widgets_manager->register( new \Luxrio_Product_Category() );
