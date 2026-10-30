<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Project Widget .
 *
 */
class Luxrio_Product_Banner extends Widget_Base {

	public function get_name() {
		return 'luxrioproductbanner';
	}

	public function get_title() {
		return __( 'Product Banner', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code'; 
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'product_banner',
			[
				'label' 	=> __( 'Banner', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'banner_image',
			[
				'label' 		=> __( 'Banner Image', 'luxrio' ),
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
			'show_star',
			[
				'label'        => __( 'Show Star', 'luxrio' ),
				'type'         =>   Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'luxrio' ),
				'label_off'    => __( 'Hide', 'luxrio' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
        $this->add_control(
			'product_category_text',
			[
				'label' 		=> __( 'Product Category Text', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXT,
				'default'		=> __( 'Premium Model', 'luxrio' ),
				'label_block'   => true,
			]
		);
        $this->add_control(
			'product_price',
			[
				'label' 		=> __( 'Price', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXT,
				'default'		=> __( 'Only From $85', 'luxrio' ),
				'label_block'   => true,
			]
		);
        $this->add_control(
			'button_text',
			[
				'label' 	=> __( 'Button Text', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Shop Now', 'luxrio' )
			]
        );

        $this->add_control(
			'button_link',
			[
				'label' 		=> __( 'Link', 'luxrio' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'luxrio' ),
				'show_external' => true,
				'default' 		=> [
					'url' 			=> '#',
					'is_external' 	=> false,
					'nofollow' 		=> false,
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'info_style',
			[
				'label' 	=> __( 'Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
		);



        $this->add_control(
			'banner_bg_image',
			[
				'label' 		=> __( 'Banner Background Image', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_responsive_control(
			'box_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .banner-style' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

		$this->add_control(
			'star_color',
			[
				'label' 		=> __( 'Star Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .star-rating:before ' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'category_text_color',
			[
				'label' 		=> __( 'Category Text Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .banner-style .banner-title a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'category_text_hover_color',
			[
				'label' 		=> __( 'Text hover Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .banner-style .banner-title a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'price_text_color',
			[
				'label' 		=> __( 'Price Text Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .banner-style .product-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'button_style_section',
			[
				'label' 	=> __( 'Button Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'button_color',
			[
				'label' 		=> __( 'Button Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'color: {{VALUE}}',
                ],
			]
        );

        $this->add_control(
			'button_color_hover',
			[
				'label' 		=> __( 'Hover Color ', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn:hover' => 'color: {{VALUE}}',
                ],
			]
        );

        $this->add_control(
			'button_bg_color',
			[
				'label' 		=> __( 'Background Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'background-color: {{VALUE}}',
                ],
			]
        );
        $this->add_control(
			'button_bg_color_hover',
			[
				'label' 		=> __( 'Background Hover Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn::before, {{WRAPPER}} .vs-btn::after' => 'background-color: {{VALUE}}',
                ],
			]
        );


        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'border',
				'label' 	=> __( 'Border', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .vs-btn',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'button_typography',
				'label' 	=> __( 'Button Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .vs-btn',
			]
        );

        $this->add_responsive_control(
			'button_margin',
			[
				'label' 		=> __( 'Button Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
        );

        $this->add_responsive_control(
			'button_padding',
			[
				'label' 		=> __( 'Button Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
		);
        $this->add_responsive_control(
			'button_border_radius',
			[
				'label' 		=> __( 'Button Border Radius', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .vs-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'box_shadow',
				'label' 	=> __( 'Box Shadow', 'luxrio' ),
				'selector' 	=> '{{WRAPPER}} .vs-btn',
			]
		);
        $this->end_controls_section();


    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'wrapper', 'class', 'vs-btn' );

        if( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_render_attribute( 'wrapper', 'href', esc_url( $settings['button_link']['url'] ) );
        }

        if( ! empty( $settings['button_link']['nofollow'] ) ) {
            $this->add_render_attribute( 'wrapper', 'rel', 'nofollow' );
        }

        if( ! empty( $settings['button_link']['is_external'] ) ) {
            $this->add_render_attribute( 'wrapper', 'target', '_blank' );
        }

        echo '<div class="banner-style" data-bg-src="'.esc_url( $settings['banner_bg_image']['url'] ).'">';
            if( ! empty( $settings['banner_image']['url'] ) ){
                echo '<div class="banner-img">';
                    echo luxrio_img_tag( array(
                        'url'   => esc_url( $settings['banner_image']['url'] ),
                    ) );
                echo '</div>';
            }
            echo '<div class="banner-content">';
                if( $settings['show_star'] == 'yes' ){
                    echo '<div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">';
                        echo '<span></span>';
                    echo '</div>';
                }
                if( ! empty( $settings['product_category_text'] ) ){
                    echo '<h3 class="banner-title"><a href="'.esc_url( $settings['button_link']['url'] ).'">'.esc_html( $settings['product_category_text'] ).'</a></h3>';
                }
                if( ! empty( $settings['product_price'] ) ){
                    echo '<span class="product-price">'.wp_kses_post( $settings['product_price'] ).'</span>';
                }
                if( ! empty( $settings['button_text'] ) ) {
                    echo '<a '.$this->get_render_attribute_string('wrapper').'>';
                        echo esc_html( $settings['button_text'] );
                    echo '</a>';
                }
            echo '</div>';
        echo '</div>';

	}

}
$widgets_manager->register( new \Luxrio_Product_Banner() );