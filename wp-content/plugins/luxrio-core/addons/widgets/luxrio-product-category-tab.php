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
class Luxrio_Product_Category_Tab extends Widget_Base{

	public function get_name() {
		return 'luxrioproductcategorytab';
	}

	public function get_title() {
		return __( 'Product Category Tab', 'luxrio' );
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
				'label' 	=> __( 'Product Category Tab', 'luxrio' ),
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
			'category_name', [
				'label' 		=> __( 'Category Name', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'Man' , 'luxrio' ),
				'label_block' 	=> true,
			]
        );

        $repeater->add_control(
			'luxrio_tab_builder_title_option',
			[
				'label'     => __( 'Select Data', 'luxrio' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => $this->luxrio_tab_builder_title_choose_option(),
				'default'	=> ''
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
						'category_name' 		=> __( 'Man', 'luxrio' ),
					],
					[
						'category_name' 		=> __( 'Woman', 'luxrio' ),
					],
					[
						'category_name' 		=> __( 'Kids', 'luxrio' ),
					],
				],
				'title_field' 	=> '{{{ category_name }}}',
			]
		);

		$this->add_control(
			'shape_one',
			[
				'label' 		=> __( 'Shape One', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'shape_two',
			[
				'label' 		=> __( 'Shape Two', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'shape_three',
			[
				'label' 		=> __( 'Shape Three', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'shape_four',
			[
				'label' 		=> __( 'Shape Four', 'luxrio' ),
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
				'selector' 		=> '{{WRAPPER}} .cate-layout2'
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

    public function luxrio_tab_builder_title_choose_option(){

		$luxrio_post_query = new WP_Query( array(
			'post_type'				=> 'luxrio_tab_build',
			'posts_per_page'	    => -1,
		) );

		$luxrio_tab_builder_title = array();
		$luxrio_tab_builder_title[''] = __( 'Select a Title','Luxrio');

		while( $luxrio_post_query->have_posts() ) {
			$luxrio_post_query->the_post();
			$luxrio_tab_builder_title[ get_the_ID() ] =  get_the_title();
		}
		wp_reset_postdata();

		return $luxrio_tab_builder_title;

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

    <section class="cate-layout2 space space-extra-bottom z-index-common">
		<?php 
			if( ! empty( $settings['shape_one']['url'] ) ){
				echo luxrio_img_tag( array(
					'url'	=> esc_url( $settings['shape_one']['url'] ),
					'class'	=> 'ele1'
				) );
			}
			if( ! empty( $settings['shape_two']['url'] ) ){
				echo luxrio_img_tag( array(
					'url'	=> esc_url( $settings['shape_two']['url'] ),
					'class'	=> 'ele2'
				) );
			}
			if( ! empty( $settings['shape_three']['url'] ) ){
				echo luxrio_img_tag( array(
					'url'	=> esc_url( $settings['shape_three']['url'] ),
					'class'	=> 'ele3'
				) );
			}
			if( ! empty( $settings['shape_four']['url'] ) ){
				echo luxrio_img_tag( array(
					'url'	=> esc_url( $settings['shape_four']['url'] ),
					'class'	=> 'ele4'
				) );
			}
		?>

        
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-7">
                    <div class="cate-content">
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
                        <div class="cate-tab">
							<?php
								echo '<div class="nav nav-pills mb-30" id="nav-tabservice" role="tablist" aria-orientation="vertical">';
									$x = 0;
									foreach( $settings['slides'] as $single_menu ){
										if( $x == 0 ){
											$active = 'active';
											$area   = 'true';
										}else{
											$active = '';
											$area   = 'false';
										}
										echo '<button class="nav-link project-tabbtn--style '.esc_attr( $active ).'" id="nav-digitalmarketing-tab'.$x.'" data-bs-toggle="tab" data-bs-target="#nav-digitalmarketing'.$x.'" type="button" role="tab" aria-controls="nav-digitalmarketing'.$x.'" aria-selected="'.esc_attr( $area ).'">';
											echo '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M9.33489 14H4.66511V11.1417L2.41544 12.5417L0 8.66542L2.67637 7L0 5.33458L2.41544 1.45833L4.66511 2.85833V0H9.33489V2.85833L11.5846 1.45833L14 5.33633L11.3236 7L14 8.66542L11.5846 12.5417L9.33489 11.1417V14ZM5.83255 12.8333H8.16744V9.04167L11.2104 10.9357L12.3924 9.04167L9.11541 7L12.3924 4.95833L11.2104 3.06367L8.16744 4.95833V1.16667H5.83255V4.95833L2.78961 3.06367L1.60757 4.95833L4.88459 7L1.60757 9.04167L2.78961 10.9387L5.83255 9.04167V12.8333Z" fill="white" />
											</svg>';
											if( ! empty( $single_menu['category_name'] ) ){
												echo esc_html( $single_menu['category_name'] );
											}
										echo '</button>';
									$x++;
									}
								echo '</div>';
						
								echo '<div class="tab-content" id="nav-tabserviceContent">';
									$x = 0;
									foreach( $settings['slides'] as $single_menu ){
										if( $x == 0 ){
											$active = 'active';
										}else{
											$active = '';
										}
										$elementor = \Elementor\Plugin::instance();
										if( ! empty( $single_menu['luxrio_tab_builder_title_option'] ) ){
											echo '<div class="tab-pane fade show '.esc_attr( $active ).'" id="nav-digitalmarketing'.$x.'" role="tabpanel" aria-labelledby="nav-digitalmarketing-tab'.$x.'">';
												echo $elementor->frontend->get_builder_content_for_display( $single_menu['luxrio_tab_builder_title_option'] );
											echo '</div>';
										}
									$x++;
									}
								echo '</div>';
							?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="img-box1 style2">
            <?php 
				if( ! empty( $settings['left_side_big_image']['url'] ) ){
					echo luxrio_img_tag( array(
						'url'	=> esc_url( $settings['left_side_big_image']['url'] ),
						'class'	=> 'img1'
					) );
				}
			?>
        </div>
    </section>

		<?php 
	}
}
$widgets_manager->register( new \Luxrio_Product_Category_Tab() );
