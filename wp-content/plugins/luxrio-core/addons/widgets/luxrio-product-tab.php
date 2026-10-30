<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
/**
 *
 * Product Tab Widget .
 *
 */
class Luxrio_Product_Tabs extends Widget_Base {

	public function get_name() {
		return 'luxrioproducttab';
	}

	public function get_title() {
		return __( 'Product Tab', 'luxrio' );
	}


	public function get_icon() {
		return 'eicon-code';
    }


	public function get_categories() {
		return [ 'luxrio' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'product_tab_section',
			[
				'label'     => __( 'Product Tab', 'luxrio' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'product_count',
			[
				'label'     => __( 'Product Count', 'luxrio' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'default'   => 6,
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
			'column_count',
			[
				'label'     => __( 'Column', 'luxrio' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'6'            => __( '2 Columns', 'luxrio' ),
					'4'            => __( '3 Columns', 'luxrio' ),
					'3'            => __( '4 Columns', 'luxrio' ),
					'2'            => __( '6 Columns', 'luxrio' ),
					'12'           => __( 'Full Width', 'luxrio' ),
				],
				'default'   => '4',
			]
        );

        $this->add_control(
			'column_count_laptop',
			[
				'label'     => __( 'Column Laptop', 'luxrio' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'6'            => __( '2 Columns', 'luxrio' ),
					'4'            => __( '3 Columns', 'luxrio' ),
					'3'            => __( '4 Columns', 'luxrio' ),
					'2'            => __( '6 Columns', 'luxrio' ),
					'12'           => __( 'Full Width', 'luxrio' ),
				],
				'default'   => '4',
			]
        );

        $this->add_control(
			'column_count_tablet',
			[
				'label'     => __( 'Column Tablet', 'luxrio' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'6'            => __( '2 Columns', 'luxrio' ),
					'4'            => __( '3 Columns', 'luxrio' ),
					'3'            => __( '4 Columns', 'luxrio' ),
					'2'            => __( '6 Columns', 'luxrio' ),
					'12'           => __( 'Full Width', 'luxrio' ),
				],
				'default'   => '4',
			]
        );

        $this->add_control(
			'column_count_mobile',
			[
				'label'     => __( 'Column Mobile', 'luxrio' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'6'            => __( '2 Columns', 'luxrio' ),
					'4'            => __( '3 Columns', 'luxrio' ),
					'3'            => __( '4 Columns', 'luxrio' ),
					'2'            => __( '6 Columns', 'luxrio' ),
					'12'           => __( 'Full Width', 'luxrio' ),
				],
				'default'   => '4',
			]
        );


        $this->add_control(
			'product_filter_by',
			[
				'label'         => __( 'Product Filter By', 'luxrio' ),
				'type'          => Controls_Manager::SELECT,
				'options'       => [
					'1'            => __('Product Attributes','luxrio'),
					'2'            => __('Product Categories','luxrio'),
				],
				'default'       => '1',
			]
        );

        $this->add_control(
			'product_attributes',
			[
				'label'         => __( 'Product Attributes', 'luxrio' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'label_block'   => true,
				'options'       => [
					'recent-items'     => __('Recent','luxrio'),
					'top-rated'        => __('Top Rated','luxrio'),
					'featured'         => __('Featured','luxrio'),
					'on-sale'          => __('On Sale','luxrio'),
					'best-selling'     => __('Best Selling','luxrio'),
                ],
                'condition'     => ['product_filter_by' => '1']
			]
        );

        $this->add_control(
			'product_cats',
			[
				'label'         => __( 'Product Categories', 'luxrio' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'label_block'   => true,
                'options'       => $this->product_cats_get(),
                'condition'     => ['product_filter_by' => '2']
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

		$uniqid = uniqid();

        echo '<!-- Section Title -->';
        echo '<!-- Product Navtab -->';
        echo '<div class="product-navtab tab-style1">';

            echo '<div class="nav" id="nav-tab" role="tablist">';
                if( $settings['product_filter_by'] == '1' ) {
                    $tabdata = $settings['product_attributes'];
                    $tabcount = 1;
                    foreach( $tabdata as $singletabdata ) {
                        $tabnamearr = explode('-',$singletabdata);
                        $tabname = implode(' ',$tabnamearr);
                        if( $tabcount == '1' ) {
                            $activecls 	= 'active';
                            $area 		= 'true';
                        } else {
                            $activecls 	= '';
                            $area 		= 'false';
                        }
                        echo '<button class="nav-link '.esc_attr( $activecls ).'" id="'.esc_attr($singletabdata).'-tab" data-bs-toggle="tab" data-bs-target="#'.esc_attr($singletabdata).'" type="button" role="tab" aria-controls="'.esc_attr($singletabdata).'" aria-selected="'.esc_attr( $area ).'">'.esc_html( ucwords( $tabname ) ).'</button>';

                        $tabcount++;
                    }
                } else {
                    $tabdata = $settings['product_cats'];
                    $tabcount = 1;
                    echo '<button id="all-item" class="nav-link active" data-bs-toggle="tab" data-bs-target="#all-'.esc_attr($uniqid).'" type="button" role="tab" aria-controls="all-'.esc_attr($uniqid).'" aria-selected="true">'.esc_html__( 'All', 'luxrio' ).'</button>';
                    foreach( $tabdata as $singletabdata ) {
                        $tabnamearr = explode('-',$singletabdata);
                        $tabname = implode(' ',$tabnamearr);
                        echo '<button class="nav-link" id="'.esc_attr($singletabdata).'-tab" data-bs-toggle="tab" data-bs-target="#'.esc_attr($singletabdata).'" type="button" role="tab" aria-controls="'.esc_attr($singletabdata).'" aria-selected="false">'.esc_html( ucwords( $tabname ) ).'</button>';
                        $tabcount++;
                    }
                }
            echo '</div>';


            if( $settings['product_filter_by'] == '1' ) {
				echo '<div class="tab-content" id="nav-tabContent">';
	                $tabdata = $settings['product_attributes'];
					$tabcount = 1;
					foreach( $tabdata as $singletabdata ){
						if( $tabcount == '1' ) {
							$activecls 	= 'show active';
							$area 		= 'true';
						} else {
							$activecls 	= '';
							$area 		= 'false';
						}
						echo '<div class="tab-pane fade '.esc_attr( $activecls ).'" id="'.esc_attr( $singletabdata ).'" role="tabpanel" aria-labelledby="'.esc_attr( $singletabdata ).'-tab">';
							echo '<div class="row">';
			                    if( $singletabdata == 'top-rated' ) {
			                        $args = array(
			                            "posts_per_page"    => esc_attr( $settings['product_count'] ),
			                            "post_type"         => "product",
			                            'meta_key'          =>  '_wc_average_rating',
			                            'order'             => 'DESC',
			                            'orderby'           => 'meta_value_num'
			                        );
			                    } elseif( $singletabdata == 'featured' ) {
			                        $args = array(
			                            "posts_per_page"    => esc_attr( $settings['product_count'] ),
			                            "post_type"         => "product",
			                            'orderby'           => 'date',
			                            'order'             => 'DESC',
			                            'post__in'          => wc_get_featured_product_ids()
			                        );
			                    } elseif( $singletabdata == 'on-sale' ) {
			                        $args = array(
			                            "posts_per_page"    => esc_attr( $settings['product_count'] ),
			                            "post_type"         => "product",
			                            'orderby'           => 'title',
				                        'order'             => 'ASC',
			                            'post__in'          => wc_get_product_ids_on_sale()
			                        );
			                    } elseif( $singletabdata == 'best-selling' ) {
			                        $args = array(
			                            "posts_per_page"    => esc_attr( $settings['product_count'] ),
			                            "post_type"         => "product",
			                            'meta_key'          => 'total_sales',
			                            'order'             => 'DESC',
			                            'orderby'           => 'meta_value_num',
			                        );
			                    } elseif( $singletabdata == 'recent-items' ) {
			                        $args = array(
			                            "posts_per_page"    => esc_attr( $settings['product_count'] ),
			                            "post_type"         => "product",
			                            'orderby'           => 'date',
				                        'order'             => 'DESC',
			                        );
			                    }

		                        $productss = new WP_Query( $args );
		                        if( $productss->have_posts() ) {
		                            while( $productss->have_posts() ) {
		                                $productss->the_post();
		                                echo '<div class="col-xl-'.esc_attr( $settings['column_count'] ).' col-lg-'.esc_attr( $settings['column_count_laptop'] ).' col-md-'.esc_attr( $settings['column_count_tablet'] ).' col-'.esc_attr( $settings['column_count_mobile'] ).' filter-item '.esc_attr( $singletabdata ).'">';

		                                    if( $settings['product_style'] == '1' ){
		                                        wc_get_template( 'content-product.php' );
		                                    }elseif( $settings['product_style'] == '2' ){
		                                        wc_get_template( 'content-product-two.php' );
		                                    }elseif( $settings['product_style'] == '3' ){
		                                        wc_get_template( 'content-product-three.php' );
		                                    }elseif( $settings['product_style'] == '4' ){
		                                        wc_get_template( 'content-product-four.php' );
		                                    }
		                                echo '</div>';
		                            }
		                            wp_reset_postdata();
		                        }
							echo '</div>';
						echo '</div>';
						$tabcount++;
					}
				echo '</div>';
            } else {

                echo '<!-- Tab Content -->';
				echo '<div class="tab-content" id="nav-tabContent">';
					$tabdata = $settings['product_cats'];
					echo '<div class="tab-pane fade show active" id="all-'.esc_attr( $uniqid ).'" role="tabpanel" aria-labelledby="all-item">';
						echo '<div class="row">';
							$args = array(
								"posts_per_page"    => esc_attr( $settings['product_count'] ),
								"post_type"         => "product",
								'tax_query' => array(
									array(
										'taxonomy' => 'product_cat',
										'field'    => 'slug',
										'terms'    => $settings['product_cats'],
									),
								),
							);
							$productss = new WP_Query( $args );
							if( $productss->have_posts() ) {
								while( $productss->have_posts() ) {
									$productss->the_post();
									echo '<div class="col-xl-'.esc_attr( $settings['column_count'] ).' col-lg-'.esc_attr( $settings['column_count_laptop'] ).' col-md-'.esc_attr( $settings['column_count_tablet'] ).' col-'.esc_attr( $settings['column_count_mobile'] ).'">';
                                        if( $settings['product_style'] == '1' ){
                                            wc_get_template( 'content-product.php' );
                                        }elseif( $settings['product_style'] == '2' ){
                                            wc_get_template( 'content-product-two.php' );
                                        }elseif( $settings['product_style'] == '3' ){
                                            wc_get_template( 'content-product-three.php' );
                                        }elseif( $settings['product_style'] == '4' ){
                                            wc_get_template( 'content-product-four.php' );
                                        }
									echo '</div>';
								}
								wp_reset_postdata();
							}

						echo '</div>';
					echo '</div>';

                    foreach( $tabdata as $singletabdata ) {
						echo '<div class="tab-pane fade" id="'.esc_attr( $singletabdata ).'" role="tabpanel" aria-labelledby="'.esc_attr( $singletabdata ).'-tab">';
							echo '<div class="row">';
                                $args = array(
                                    "posts_per_page"    => esc_attr( $settings['product_count'] ),
                                    "post_type"         => "product",
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field'    => 'slug',
                                            'terms'    => esc_attr($singletabdata),
                                        ),
                                    ),
                                );
                                $productss = new WP_Query( $args );
                                if( $productss->have_posts() ) {
                                    while( $productss->have_posts() ) {
                                        $productss->the_post();
                                        echo '<div class="col-xl-'.esc_attr( $settings['column_count'] ).' col-lg-'.esc_attr( $settings['column_count_laptop'] ).' col-md-'.esc_attr( $settings['column_count_tablet'] ).' col-'.esc_attr( $settings['column_count_mobile'] ).' filter-item '.esc_attr( $singletabdata ).'">';
                                            if( $settings['product_style'] == '1' ){
                                                wc_get_template( 'content-product.php' );
                                            }elseif( $settings['product_style'] == '2' ){
                                                wc_get_template( 'content-product-two.php' );
                                            }elseif( $settings['product_style'] == '3' ){
                                                wc_get_template( 'content-product-three.php' );
                                            }elseif( $settings['product_style'] == '4' ){
                                                wc_get_template( 'content-product-four.php' );
                                            }elseif( $settings['product_style'] == '5' ){
                                                wc_get_template( 'content-product-five.php' );
                                            }elseif( $settings['product_style'] == '6' ){
                                                wc_get_template( 'content-product-six.php' );
                                            }elseif( $settings['product_style'] == '7' ){
                                                wc_get_template( 'content-product-seven.php' );
                                            }elseif( $settings['product_style'] == '8' ){
                                                wc_get_template( 'content-product-eight.php' );
                                            }elseif( $settings['product_style'] == '9' ){
                                                wc_get_template( 'content-product-nine.php' );
                                            }elseif( $settings['product_style'] == '10' ){
                                                wc_get_template( 'content-product-ten.php' );
                                            }elseif( $settings['product_style'] == '11' ){
                                                wc_get_template( 'content-product-eleven.php' );
                                            }elseif( $settings['product_style'] == '12' ){
                                                wc_get_template( 'content-product-twelve.php' );
                                            }elseif( $settings['product_style'] == '13' ){
                                                wc_get_template( 'content-product-thirteen.php' );
                                            }elseif( $settings['product_style'] == '14' ){
                                                wc_get_template( 'content-product-fourteen.php' );
                                            }elseif( $settings['product_style'] == '15' ){
                                                wc_get_template( 'content-product-fifteen.php' );
                                            }elseif( $settings['product_style'] == '16' ){
                                                wc_get_template( 'content-product-sixteen.php' );
                                            }elseif( $settings['product_style'] == '17' ){
                                                wc_get_template( 'content-product-seventeen.php' );
                                            }else{
                                                wc_get_template( 'content-horizontal-product.php' );
                                            }
                                        echo '</div>';
                                    }
                                    wp_reset_postdata();
                                }

                            echo '</div>';
                        echo '</div>';
                    }
                echo '</div>';
                echo '<!-- End Tab Content -->';
            }
        echo '</div>';
	}

}

$widgets_manager->register( new \Luxrio_Product_Tabs() );