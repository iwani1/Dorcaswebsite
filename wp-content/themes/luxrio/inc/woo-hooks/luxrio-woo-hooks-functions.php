<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit();
}
/**
 * @Packge     : Luxrio
 * @Version    : 1.0
 * @Author     : Luxrio
 * @Author URI : https://www.vecuro.com/
 *
 */

if( ! function_exists( 'luxrio_shop_categorysection_start_cb' ) ){
    function luxrio_shop_categorysection_start_cb(){
        // global $post;
        $terms = get_terms( array(
            'taxonomy'      => 'product_cat',
            'hide_empty'    => false,
        ) );
        if( $terms && class_exists( 'ReduxFramework' ) && luxrio_opt( 'luxrio_category_show_hide' ) ){
            echo '<section class="space-top arrow-wrap">';
                echo '<div class="container">';
                    echo '<div class="row category justify-content-between align-items-center vs-carousel arrow-margin" data-arrows="true" data-slide-show="6" data-ml-slide-show="6" data-lg-slide-show="5" data-md-slide-show="4" data-sm-slide-show="3" data-xs-slide-show="2">';
                        foreach ( $terms as $term ){
                            $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                            $catImg = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                            echo '<div class="col-xl-2">';
                                echo '<div class="cat_rounded">';
                                    if( ! empty( $catImg ) ){
                                        echo '<div class="cat-img">';
                                            echo '<a href="'.esc_url( get_term_link( $term ) ).'">';
                                                echo luxrio_img_tag( array(
                                                    'url'   => esc_url( $catImg[0] )
                                                ) );
                                            echo '</a>';
                                        echo '</div>';
                                    }
                                    echo '<h3 class="cat-name"><a class="text-inherit" href="'.esc_url( get_term_link( $term ) ).'">'.esc_html( $term->name ).'</a></h3>';
                                echo '</div>';
                            echo '</div>';
                        }
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        }
    }
}

// luxrio shop main content hook functions
if( !function_exists('luxrio_shop_main_content_cb') ) {
    function luxrio_shop_main_content_cb( ) {

       

        if( is_shop() || is_product_category() || is_product_tag() ) {
            if( !empty( luxrio_opt("luxrio_shop_bg") ) ){
                $luxrio_shop_bg_image = luxrio_opt("luxrio_shop_bg");
                $url = $luxrio_shop_bg_image['url'];
            }else{
                $url = '';
            }
            
            echo '<section class="vs-product-wrapper space-top space-extra-bottom background-image" style="background-image: url('. $url .')">';
                 echo '<div class="outer-wrap3">';
            if( class_exists('ReduxFramework') ) {
                $luxrio_woo_product_col = luxrio_opt('luxrio_woo_product_col');
                if( $luxrio_woo_product_col == '2' ) {
                    echo '<div class="container">';
                } elseif( $luxrio_woo_product_col == '3' ) {
                    echo '<div class="container">';
                } elseif( $luxrio_woo_product_col == '4' ) {
                    echo '<div class="container">';
                } elseif( $luxrio_woo_product_col == '5' ) {
                    echo '<div class="luxrio-container">';
                } elseif( $luxrio_woo_product_col == '6' ) {
                    echo '<div class="luxrio-container">';
                }
            } else {
                echo '<div class="container">';
            }
        } else {
            echo '<section class="vs-product-wrapper space-extra-bottom product-details space-top">';
                echo '<div class="container">';
        }
            echo '<div class="row">';
    }
}

// luxrio shop main content hook function
if( !function_exists('luxrio_shop_main_content_end_cb') ) {
    function luxrio_shop_main_content_end_cb( ) {
                echo '</div>';
             echo '</div>';
        echo '</div>';
    echo '</section>';
    }
}

// shop column start hook function
if( !function_exists('luxrio_shop_col_start_cb') ) {
    function luxrio_shop_col_start_cb( ) {
        if( class_exists('ReduxFramework') ) {
            if( class_exists('woocommerce') && ( is_shop() || is_product_category() ) ) {
                $luxrio_woo_shoppage_sidebar = luxrio_opt('luxrio_woo_shoppage_sidebar');
                if( $luxrio_woo_shoppage_sidebar == '2' && is_active_sidebar('luxrio-woo-sidebar') ) {
                    echo '<div class="col-lg-8 col-xl-9 order-last">';
                } elseif( $luxrio_woo_shoppage_sidebar == '3' && is_active_sidebar('luxrio-woo-sidebar') ) {
                    echo '<div class="col-lg-8 col-xl-9">';
                } else {
                    echo '<div class="col-lg-12">';
                }
            } else {
                echo '<div class="col-lg-12">';
            }
        } else {
            if( class_exists('woocommerce') && ( is_shop() || is_product_category() ) ) {
                if( is_active_sidebar('luxrio-woo-sidebar') ) {
                    echo '<div class="col-lg-8 col-xl-9">';
                } else {
                    echo '<div class="col-lg-12">';
                }
            } else {
                echo '<div class="col-lg-12">';
            }
        }

    }
}

// shop column end hook function
if( !function_exists('luxrio_shop_col_end_cb') ) {
    function luxrio_shop_col_end_cb( ) {
        echo '</div>';
    }
}

// luxrio woocommerce pagination hook function
if( ! function_exists('luxrio_woocommerce_pagination') ) {
    function luxrio_woocommerce_pagination( ) {
        if( ! empty( luxrio_pagination() ) ) {
            echo '<div class="row">';
                echo '<div class="col-12">';
                    echo '<div class="vs-pagination">';
                        add_filter('next_posts_link_attributes', 'woo_posts_link_attributes');
                        add_filter('previous_posts_link_attributes', 'woo_posts_link_attributes');
                        function woo_posts_link_attributes(){
                            return 'class="pagi-btn"';
                        };
                        $prev 	= '<i class="fa-solid fa-angles-left"></i>';
                        $next 	= '<i class="fa-solid fa-angles-right"></i>';
                        // previous
                        if( get_previous_posts_link() ){
                            previous_posts_link( $prev );
                        }
                        echo '<ul>';
                            echo luxrio_pagination();
                        echo '</ul>';
                        // next
                        if( get_next_posts_link() ){
                            next_posts_link( $next );
                        }
                        
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
}

// woocommerce filter wrapper hook function
if( ! function_exists('luxrio_woocommerce_filter_wrapper') ) {
    function luxrio_woocommerce_filter_wrapper( ) {
        echo '<div class="vs-sort-bar">';
            echo '<div class="row gx-4 gy-0 align-items-center">';
                echo '<div class="col-md-auto flex-grow-1">';
                    woocommerce_result_count();
                echo '</div>';
                echo '<div class="col-md-auto">';
                    echo '<div class="col-sm-auto">';
                        echo woocommerce_catalog_ordering();
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}

// woocommerce tab content wrapper start hook function
if( ! function_exists('luxrio_woocommerce_tab_content_wrapper_start') ) {
    function luxrio_woocommerce_tab_content_wrapper_start( ) {
        echo '<!-- Tab Content -->';
        echo '<div class="tab-content" id="nav-tabContent">';
    }
}

// woocommerce tab content wrapper start hook function
if( ! function_exists('luxrio_woocommerce_tab_content_wrapper_end') ) {
    function luxrio_woocommerce_tab_content_wrapper_end( ) {
        echo '</div>';
        echo '<!-- End Tab Content -->';
    }
}
// luxrio grid tab content hook function
if( !function_exists('luxrio_grid_tab_content_cb') ) {
    function luxrio_grid_tab_content_cb( ) {
        echo '<!-- Grid -->';
            echo '<div class="tab-pane fade show active" id="tab-grid" role="tabpanel" aria-labelledby="tab-shop-grid">';
                woocommerce_product_loop_start();
                if( class_exists('ReduxFramework') ) {
                    $luxrio_woo_product_col = luxrio_opt('luxrio_woo_product_col');
                    if( $luxrio_woo_product_col == '2' ) {
                        $luxrio_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-6';
                    } elseif( $luxrio_woo_product_col == '3' ) {
                        $luxrio_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-4';
                    } elseif( $luxrio_woo_product_col == '4' ) {
                        $luxrio_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-3';
                    }elseif( $luxrio_woo_product_col == '5' ) {
                        $luxrio_woo_product_col_val = 'col-xl col-lg-6 col-sm-6';
                    } elseif( $luxrio_woo_product_col == '6' ) {
                        $luxrio_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-2';
                    }
                } else {
                    $luxrio_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-3';
                }

                if ( wc_get_loop_prop( 'total' ) ) {
                    while ( have_posts() ) {
                        the_post();

                        echo '<div class="'.esc_attr( $luxrio_woo_product_col_val ).'">';
                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action( 'woocommerce_shop_loop' );

                            wc_get_template_part( 'content', 'product' );

                        echo '</div>';
                    }
                    wp_reset_postdata();
                }

                woocommerce_product_loop_end();
            echo '</div>';
        echo '<!-- End Grid -->';
    }
}

// luxrio list tab content hook function
if( !function_exists('luxrio_list_tab_content_cb') ) {
    function luxrio_list_tab_content_cb( ) {
        echo '<!-- List -->';
        echo '<div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-shop-list">';
            woocommerce_product_loop_start();

            if ( wc_get_loop_prop( 'total' ) ) {
                while ( have_posts() ) {
                    the_post();
                    echo '<div class="col-sm-6 col-lg-6 col-xl-4">';
                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action( 'woocommerce_shop_loop' );

                        wc_get_template_part( 'content-horizontal', 'product' );
                    echo '</div>';
                }
                wp_reset_postdata();
            }

            woocommerce_product_loop_end();
        echo '</div>';
        echo '<!-- End List -->';
    }
}

// luxrio woocommerce get sidebar hook function
if( ! function_exists('luxrio_woocommerce_get_sidebar') ) {
    function luxrio_woocommerce_get_sidebar( ) {
        if( class_exists('ReduxFramework') ) { 
            $luxrio_woo_shoppage_sidebar = luxrio_opt('luxrio_woo_shoppage_sidebar');
        } else {
            if( is_active_sidebar('luxrio-woo-sidebar') ) {
                $luxrio_woo_shoppage_sidebar = '2';
            } else {
                $luxrio_woo_shoppage_sidebar = '1';
            }
        }

        if( is_shop() ) {
            if( $luxrio_woo_shoppage_sidebar != '1' ) {
                get_sidebar('shop');
            }
        }
    }
}

// luxrio loop product thumbnail hook function
if( !function_exists('luxrio_loop_product_thumbnail') ) {
    function luxrio_loop_product_thumbnail( ) {
        global $product;

        if( $product->is_on_sale() && $product->get_type() == 'simple' ) {
            echo '<div class="onsale product-tag">'.esc_html__( 'Sale', 'luxrio' ).'</div>';
        }
        if( $product->is_featured() ) {
            echo '<div class="featured woocommerce-badge product-tag">'.esc_html__( 'Hot', 'luxrio' ).'</div>';
        }
        if( ! $product->is_in_stock() ) {
            echo '<div class="outofstock woocommerce-badge product-tag">'.esc_html__( 'Stock Out', 'luxrio' ).'</div>';
        }
        // Product bottom
        echo '<div class="product-action">';
            // Wishlist Button
            if( class_exists( 'TInvWL_Admin_TInvWL' ) ){
                echo do_shortcode( '[ti_wishlists_addtowishlist]' );
            }
            // Quick View Button
            if( class_exists( 'WPCleverWoosq' ) ){
                echo do_shortcode('[woosq]');
            }
        echo '</div>';
        echo '<div class="product-img">';
            if( has_post_thumbnail() ){
                echo '<a href="'.esc_url( get_permalink() ).'">';
                    the_post_thumbnail( 'product-image' );
                echo '</a>';
            }
        echo '</div>';
    }
}

// shop loop product summary
if( ! function_exists('luxrio_loop_product_summary') ) {
    function luxrio_loop_product_summary( ) {
        global $product;
        echo '<div class="product-content">'; 
            // Product Title
            echo '<h3 class="product-title">
            <a href="'.esc_url( get_permalink() ).'">'.esc_html( get_the_title() ).'</a>
            </h3>';
            // Product Price
            echo '<div class="product-price">';
                echo woocommerce_template_loop_price();
                // Cart Button
                woocommerce_template_loop_add_to_cart_text_style();
            echo '</div>';

            echo woocommerce_template_loop_rating();
        echo '</div>';
    }
}

// shop loop horizontal product summary
if( ! function_exists( 'luxrio_horizontal_loop_product_summary' ) ) {
    function luxrio_horizontal_loop_product_summary() {
        global $product;
        echo '<div class="product-content">';
            echo '<div>';
                // Product Title
                echo '<h4 class="product-title h5"><a href="'.esc_url( get_permalink() ).'">'.esc_html( get_the_title() ).'</a></h4>';
                // Product Price
                echo woocommerce_template_loop_price();
                // Product Rating
                woocommerce_template_loop_rating();

            echo '</div>';
        echo '</div>';
    }
}

// single product price rating hook function
if( !function_exists('luxrio_woocommerce_single_product_price_rating') ) {
    function luxrio_woocommerce_single_product_price_rating() {
        global $product;
        // Product Rating
        echo '<div class="product-rating">';
            $average_rating = $product->get_average_rating();
            $review_count   = $product->get_review_count();
            if( $review_count == '0' ){
                esc_html_e( 'There are no reviews yet', 'luxrio' );
            }else{
                woocommerce_template_loop_rating();
                
                echo '<span class="product-rating__total">'.esc_html( $review_count );
                if( $review_count > 1 ) {
                    esc_html_e(' Reviews','luxrio');
                } else {
                    esc_html_e(' Review','luxrio');
                };
               echo '</span> ';
            }
        echo '</div>';
        
       
       
    }
}

// single product title hook function
if( !function_exists('luxrio_woocommerce_single_product_title') ) {
    function luxrio_woocommerce_single_product_title( ) {
       
        global $product;

        if( class_exists( 'ReduxFramework' ) ) {
            $producttitle_position = luxrio_opt('luxrio_product_details_title_position');
        } else {
            $producttitle_position = 'header';
        }
        if( $producttitle_position != 'header' ) {
            echo '<!-- Product Title -->';
            echo '<h2 class="product-title">'.esc_html( get_the_title() ).'</h2>';
            echo '<!-- End Product Title -->';
        }

        echo '<div class="product-price">';
            echo '<!-- Product Prices -->';
            woocommerce_template_single_price();
            echo '<!-- End Product Price -->';

            $availability = $product->get_availability();

            if( class_exists( 'ReduxFramework' ) ){
                $luxrio_stock_quantity = luxrio_opt( 'luxrio_woo_stock_quantity_show_hide' );
            }else{
                $luxrio_stock_quantity = 1;
            }

            if( $luxrio_stock_quantity ){
                if( $availability['class'] != 'out-of-stock' ) {
                    if( $product->get_stock_quantity() ){
                        echo '<span class="stock in-stock">'.esc_html( $product->get_stock_quantity() ).'</span>';
                    }else{
                        echo '<span class="stock in-stock">'.esc_html__( 'In Stock', 'luxrio' ).'</span>';
                    }
                } else {
                    echo '<span class="stock out-of-stock">'.esc_html__( 'Out Of Stock', 'luxrio' ).'</span>';
                }
            }
        echo '</div>';

    }
}

// single product title hook function
if( !function_exists('luxrio_woocommerce_quickview_single_product_title') ) {
    function luxrio_woocommerce_quickview_single_product_title( ) {
        echo '<!-- Product Title -->';
        echo '<h2 class="product-title">'.esc_html( get_the_title() ).'</h2>';
        echo '<!-- End Product Title -->';
    }
}

// single product excerpt hook function
if( !function_exists('luxrio_woocommerce_single_product_excerpt') ) {
    function luxrio_woocommerce_single_product_excerpt( ) {
        echo '<!-- Product Description -->';
        woocommerce_template_single_excerpt();
        echo '<!-- End Product Description -->';
    }
}

// single product availability hook function
if( !function_exists('luxrio_woocommerce_single_product_availability') ) {
    function luxrio_woocommerce_single_product_availability( ) {
        global $product;
        
    }
}

// single product add to cart fuunction
if( !function_exists('luxrio_woocommerce_single_add_to_cart_button') ) {
    function luxrio_woocommerce_single_add_to_cart_button( ) {
        woocommerce_template_single_add_to_cart();
    }
}

// single product ,eta hook function
if( !function_exists('luxrio_woocommerce_single_meta') ) {
    function luxrio_woocommerce_single_meta( ) {
        global $product;
        echo '<div class="product_meta">';
            if( ! empty( $product->get_sku() ) ){
                echo '<span class="sku_wrapper">'.esc_html__( 'SKU:', 'luxrio' ).'<span class="sku">'.$product->get_sku().'</span></span>';
            }
            echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'luxrio' ) . ' ', '</span>' );
            // Add the "Tags" section here
            $product_tags = get_the_terms( $product->get_id(), 'product_tag' );
            if ( $product_tags && ! is_wp_error( $product_tags ) ) {
                echo '<span>' . esc_html__( 'Tags:', 'luxrio' ) . ' ';
                $tag_links = array();
                foreach ( $product_tags as $tag ) {
                    $tag_links[] = '<a href="' . get_term_link( $tag ) . '" rel="tag">' . esc_html( $tag->name ) . '</a>';
                }
                echo implode( ', ', $tag_links );
                echo '</span>';
            }
            if( function_exists( 'luxrio_social_sharing_buttons_woocommerce' ) ) {
                echo luxrio_social_sharing_buttons_woocommerce();
            }
        echo '</div>';

        
        
    }
}

// single produt sidebar hook function
if( !function_exists('luxrio_woocommerce_single_product_sidebar_cb') ) {
    function luxrio_woocommerce_single_product_sidebar_cb(){
        if( class_exists('ReduxFramework') ) {
            $luxrio_woo_singlepage_sidebar = luxrio_opt('luxrio_woo_singlepage_sidebar');
            if( ( $luxrio_woo_singlepage_sidebar == '2' || $luxrio_woo_singlepage_sidebar == '3' ) && is_active_sidebar('luxrio-woo-sidebar') ) {
                get_sidebar('shop');
            }
        } else {
            if( is_active_sidebar('luxrio-woo-sidebar') ) {
                get_sidebar('shop');
            }
        }
    }
}

// reviewer meta hook function
if( !function_exists('luxrio_woocommerce_reviewer_meta') ) {
    function luxrio_woocommerce_reviewer_meta( $comment ){
        $verified = wc_review_is_from_verified_owner( $comment->comment_ID );
        if ( '0' === $comment->comment_approved ) { ?>
            <em class="woocommerce-review__awaiting-approval">
                <?php esc_html_e( 'Your review is awaiting approval', 'luxrio' ); ?>
            </em>

        <?php } else { ?>
                <h4 class="name h4"><?php echo ucwords( get_comment_author() ); ?> </h4>
                
                <span class="commented-on "><time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"> <?php printf( esc_html__('%1$s at %2$s', 'luxrio'), get_comment_date(wc_date_format()),  get_comment_time() ); ?> </time></span>
           
                <?php
                if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
                    echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'luxrio' ) . ')</em> ';
                }

                ?>
        <?php
        }

        woocommerce_review_display_rating();
    }
}

// luxrio woocommerce cross sell display hook function
if( !function_exists('luxrio_woocommerce_cross_sell_display') ) {
    function luxrio_woocommerce_cross_sell_display( ){
        woocommerce_cross_sell_display();
    }
}

// add to cart button
function woocommerce_template_loop_add_to_cart( $args = array() ) {
    global $product;

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode(
					' ',
					array_filter(
						array(
							'icon-btn',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = wp_parse_args( $args, $defaults );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
            }
        }

        echo sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'cart-button' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            '<i class="fas fa-shopping-cart"></i>'
        );
}

// add to cart button Text
function woocommerce_template_loop_add_to_cart_text_style( $args = array() ) {
    global $product;

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode(
					' ',
					array_filter(
						array(
							'product-cart',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = wp_parse_args( $args, $defaults );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
            }
        }
        
        if ( $product->is_type( 'simple' ) ){
            $luxrio_cart_text = esc_html__( 'Add to cart','luxrio' );
        }
    
        if ($product->is_type( 'variable' ) ){
            $luxrio_cart_text = esc_html__( 'Select Option','luxrio' );
        }
        
        if ($product->is_type( 'grouped' ) ){
            $luxrio_cart_text = esc_html__( 'View options','luxrio' );
        }
        
        if ($product->is_type( 'external' ) ){
            $luxrio_cart_text = esc_html__( 'Read More','luxrio' );
        }

        echo sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'cart-button' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            $luxrio_cart_text,
            
        );
}