<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Product Widget .
 *
 */
class Luxrio_Product_Slider extends Widget_Base {

	public function get_name() {
		return 'luxrioproductslider';
	}

	public function get_title() {
		return __( 'Product Slider', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'product_slider_section',
			[
				'label' 	=> __( 'Product Slider', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'product_style',
			[
				'label' 	=> __( 'Product Style', 'luxrio' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> '1',
				'options'   => [
					'1'  		=> __( 'Style One', 'luxrio' ),
					'2' 		=> __( 'Style Two', 'luxrio' ),
					'3' 		=> __( 'Style Three', 'luxrio' ),
					'4' 		=> __( 'Style Four', 'luxrio' ),
				],
			]
		);

        $this->add_control(
			'product_count',
			[
				'label' 		=> __( 'Product Count', 'luxrio' ),
				'type' 			=> Controls_Manager::NUMBER,
				'min' 			=> 1,
				'max' 			=> 50,
				'step' 			=> 1,
				'default' 		=> 6,
			]
		);

        $this->add_control(
			'product_cats',
			[
				'label' 		=> __( 'Product Categories', 'luxrio' ),
                'type' 			=> Controls_Manager::SELECT2,
                'multiple' 		=> true,
                'label_block'   => true,
                'options' 		=> $this->product_cats_get(),
			]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_control_section',
			[
				'label' 		=> __( 'Slider Control', 'luxrio' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'desktop_items',
			[
				'label' 		=> __( 'Desktop Items', 'luxrio' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ '%' ],
				'range' 		=> [
					'%' 	=> [
						'min' 	=> 0,
						'step' 	=> 1,
						'max' 	=> 10,
					],
				],
				'default' 	=> [
					'unit' 		=> '%',
					'size' 		=> 3,
				],
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
			'slider_arrows',
			[
				'label' 		=> __( 'Arrows', 'luxrio' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'luxrio' ),
				'label_off' 	=> __( 'No', 'luxrio' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'general',
			[
				'label' 	=> __( 'General', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'star_color',
			[
				'label' 	=> __( 'Star Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .star-rating:before,{{WRAPPER}} .star-rating span:before' => 'color: {{VALUE}}',
                ],
			]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'product_title_style_section',
			[
				'label' 	=> __( 'Product Title Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'product_title_color',
			[
				'label' 	=> __( 'Product Title Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-style1 .product-title a,{{WRAPPER}} .product-style2 .product-title a' => 'color: {{VALUE}}',
                ],
			]
        );

        $this->add_control(
			'product_title_hover_color',
			[
				'label' 	=> __( 'Product Title Hover Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-style1 .product-title a:hover,{{WRAPPER}} .product-style2 .product-title a:hover' => 'color: {{VALUE}}',
                ],
			]
        );


        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'product_title_typography',
				'label' 	=> __( 'Product Title Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .product-style1 .product-title,{{WRAPPER}} .product-style2 .product-title',
			]
        );

        $this->add_responsive_control(
			'product_title_margin',
			[
				'label' 		=> __( 'Product Title Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-style1 .product-title,{{WRAPPER}} .product-style2 .product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

        $this->add_responsive_control(
			'product_title_padding',
			[
				'label' 		=> __( 'Product Title Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-style1 .product-title,{{WRAPPER}} .vs-product-box1 .product-content .product-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'product_price_style_section',
			[
				'label' 	=> __( 'Product Price Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'product_price_color',
			[
				'label' 		=> __( 'Product Price Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .product-style1 .product-price,{{WRAPPER}} .product-style2 .product-title' => 'color: {{VALUE}}',
                ]
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'product_price_typography',
				'label' 	=> __( 'Product Price Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .product-style1 .product-price,{{WRAPPER}} .product-style2 .product-title',
			]
        );

        $this->add_responsive_control(
			'product_price_margin',
			[
				'label' 		=> __( 'Product Price Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-style1 .product-price,{{WRAPPER}} .product-style2 .product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

        $this->add_responsive_control(
			'product_price_padding',
			[
				'label' 		=> __( 'Product Price Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-style1 .product-price,{{WRAPPER}} .product-style2 .product-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

		$this->end_controls_section();

    }

    protected function product_cats_get() {
        $terms = get_terms( array( 'taxonomy' => 'product_cat' ) );
        $term_array = array();
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $term_array[$term->slug] = $term->name;
            }
        }

        return $term_array;
    }

	protected function render() {

        $settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'row product-slider');

		$this->add_render_attribute( 'wrapper', 'data-slide-to-show', $settings['desktop_items']['size']);

		if( $settings['slider_arrows'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper','data-slick-arrows','true' );
		} else {
			$this->add_render_attribute( 'wrapper','data-slick-arrows','false' );
		}

		if( $settings['slider_autoplay'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'true' );
		} else {
			$this->add_render_attribute( 'wrapper', 'data-slick-autoplay', 'false' );
		}

        $args = array(
            "post_type" 		=> "product",
            "posts_per_page"    => esc_attr( $settings['product_count'] )
		);

		$args['order'] 		= 'ASC';
		$args['orderby'] 	= 'title';

        if( ! empty( $settings['product_cats'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $settings['product_cats'],
                ),
            );
        }

        $prods = new WP_Query( $args );

		echo '<section class="product-slider-wrapper">';
			echo '<div class="container">';
		        echo '<div '.$this->get_render_attribute_string( 'wrapper' ).'>';
		            while( $prods->have_posts() ) {
		                $prods->the_post();
						echo '<div class="col-xl-4 col-sm-6">';
							if( $settings['product_style'] == '1' ){
								wc_get_template( 'content-product.php' );
							}elseif( $settings['product_style'] == '2' ){
			                	wc_get_template( 'content-product-two.php' );
							}elseif( $settings['product_style'] == '3' ){
								wc_get_template( 'content-product-three.php' );
							}else{
								wc_get_template( 'content-product-four.php' );
							}
						echo '</div>';
		            }
		            wp_reset_postdata();
		        echo '</div>';
	        echo '</div>';
	    echo '</section>';
	}
}

$widgets_manager->register(new \Luxrio_Product_Slider());