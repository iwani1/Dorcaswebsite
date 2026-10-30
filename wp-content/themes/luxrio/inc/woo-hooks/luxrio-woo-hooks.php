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

// Woocommerce Product Per Page
add_filter( 'loop_shop_per_page', 'luxrio_new_loop_shop_per_page', 20 );
function luxrio_new_loop_shop_per_page( $product_count ) {
  $product_count = luxrio_opt( 'luxrio_woo_product_perpage' );
  return $product_count;
}

 // removing woocommerce default styles hook
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// removing woocommerce page title hook
add_filter('woocommerce_show_page_title','__return_false');

// wooocommerce product loop start filter
add_filter('woocommerce_product_loop_start','luxrio_woocommerce_product_loop_start');
function luxrio_woocommerce_product_loop_start( ) {
    echo '<div class="row">';
}

// wooocommerce product loop start filter
add_filter('woocommerce_product_loop_end','luxrio_woocommerce_product_loop_end');
function luxrio_woocommerce_product_loop_end( ) {
    echo '</div>';
}

// woocommerce format sale price
add_filter('woocommerce_format_sale_price','luxrio_woocommerce_format_sale_price',10,3);
function luxrio_woocommerce_format_sale_price( $price, $regular_price, $sale_price ) {
    $price = ' <ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
    return $price;
}

// woocommerce gravatar size
add_filter('woocommerce_review_gravatar_size','luxrio_woocommerce_review_gravatar_size');
function luxrio_woocommerce_review_gravatar_size() {
    return 65;
}


// product description heading remove
add_filter('woocommerce_product_description_heading','__return_false');

// product additional information remove
add_filter('woocommerce_product_additional_information_heading','__return_false');

// single product review title remove
add_filter('woocommerce_reviews_title','__return_false');

// woocommerce related product number
add_filter('woocommerce_output_related_products_args','luxrio_woocommerce_output_related_products_args',10,1);
function luxrio_woocommerce_output_related_products_args( $args ) {
    if( class_exists('ReduxFramework') ) {
        $args['posts_per_page'] = luxrio_opt('luxrio_woo_relproduct_num');
    } else {
        $args['posts_per_page'] = '3';
    }

    return $args;
}

// woocommerce upsell product number
add_filter('woocommerce_upsell_display_args','luxrio_woocommerce_upsell_display_args',10,1);
function luxrio_woocommerce_upsell_display_args( $args ) {
    if( class_exists('ReduxFramework') ) {
        $args['posts_per_page'] = luxrio_opt('luxrio_woo_upsellproduct_num');
    } else {
        $args['posts_per_page'] = '3';
    }
    return $args;
}

// woocommerce cross sell product number
add_filter('woocommerce_cross_sells_total','woocommerce_cross_sells_total',10,1);
function woocommerce_cross_sells_total( $limit ) {
    if( class_exists('ReduxFramework') ) {
        $limit = luxrio_opt('luxrio_woo_crosssellproduct_num');
    } else {
        $limit = '3';
    }

    return $limit;
}

// removing archive product hooks
remove_action('woocommerce_before_main_content','woocommerce_output_content_wrapper',10);
remove_action('woocommerce_after_main_content','woocommerce_output_content_wrapper_end',10);
remove_action('woocommerce_after_shop_loop','woocommerce_pagination',10);
remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);
remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);
remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);

// removing content product hooks
remove_action('woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10);
remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10);
remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',10);
remove_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10);
remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10);
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);

// removing single product hooks
remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating',10);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing',50);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);

// removing review hook
remove_action('woocommerce_review_before_comment_meta','woocommerce_review_display_rating',10);
remove_action('woocommerce_review_meta','woocommerce_review_display_meta',10,1);


// Remove Related Product Hook
remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_related_products',20 );

// Add Related Product
add_action( 'luxrio_woocommerce_output_related_products', 'woocommerce_output_related_products', 20 );

// Shop column start wrapper hook
add_action( 'woocommerce_before_main_content', 'luxrio_shop_col_start_cb', 10 );

// Shop column end wrapper hook
add_action('woocommerce_after_main_content','luxrio_shop_col_end_cb',10);

// Category Section Start
add_action( 'luxrio_shop_categorysection_start', 'luxrio_shop_categorysection_start_cb', 10 );

// shop main content hook
add_action('luxrio_shop_main_content','luxrio_shop_main_content_cb',10);

// shop main content end hook
add_action('luxrio_shop_main_content_end','luxrio_shop_main_content_end_cb',10);

// luxrio woocommerce pagination hook
add_action('woocommerce_after_shop_loop','luxrio_woocommerce_pagination',10);

// luxrio woocommerce filter wrapper hook
add_action('woocommerce_before_shop_loop','luxrio_woocommerce_filter_wrapper',20);

// luxrio woocommerce product content wrapper
add_action('luxrio_woocommerce_product_content', 'luxrio_woocommerce_tab_content_wrapper_start', 10 );
add_action('luxrio_woocommerce_product_content', 'luxrio_grid_tab_content_cb', 10 );
add_action('luxrio_woocommerce_product_content', 'luxrio_list_tab_content_cb', 20 );
add_action('luxrio_woocommerce_product_content', 'luxrio_woocommerce_tab_content_wrapper_end', 30 );

// luxrio woocommerce get sidebar
add_action('woocommerce_sidebar','luxrio_woocommerce_get_sidebar',10);

/*
*   Content Product Hook
*/

// luxrio shop loop product thumbnail hook
add_action( 'woocommerce_before_shop_loop_item', 'luxrio_loop_product_thumbnail', 10 );

// luxrio shop loop hozrizontal product thumbnail hook
add_action( 'woocommerce_before_shop_horizontal_loop_item', 'luxrio_loop_product_thumbnail', 10 );

// luxrio shop loop product summary hook
add_action( 'woocommerce_after_shop_loop_item', 'luxrio_loop_product_summary', 10 );

// luxrio shop loop horizontal product summary hook
add_action('woocommerce_after_shop_horizonal_loop_item', 'luxrio_horizontal_loop_product_summary' );

// luxrio shop loop horizontal product summary hook
add_action('luxrio_woocommerce_shop_three_loop_product_summary','luxrio_woocommerce_shop_three_loop_product_summary_cb',10);

/*
*   Single Product Hook
*/

// single product price and rating
add_action('woocommerce_single_product_summary', 'luxrio_woocommerce_single_product_price_rating', 10 );

// single product title
add_action('woocommerce_single_product_summary', 'luxrio_woocommerce_single_product_title', 10 );


// single product excerpt
add_action('woocommerce_single_product_summary', 'luxrio_woocommerce_single_product_excerpt', 40 );

// single product availability
add_action( 'woocommerce_single_product_summary', 'luxrio_woocommerce_single_product_availability', 50 );

// single product add to cart button
add_action('woocommerce_single_product_summary','luxrio_woocommerce_single_add_to_cart_button',60);

// single product meta hook
add_action('woocommerce_single_product_summary','luxrio_woocommerce_single_meta',80);

// single product sidebar
add_action('luxrio_woocommerce_single_product_sidebar','luxrio_woocommerce_single_product_sidebar_cb');

// single product price and rating
add_action('luxrio_quickview_single_product_summary','luxrio_woocommerce_single_product_price_rating',20);

// single product title
add_action('luxrio_quickview_single_product_summary','luxrio_woocommerce_quickview_single_product_title',30);

// single product excerpt
add_action('luxrio_quickview_single_product_summary','luxrio_woocommerce_single_product_excerpt',40);

// single product add to cart button
add_action('luxrio_quickview_single_product_summary','luxrio_woocommerce_single_add_to_cart_button',60);


/*
*   Single product Review Hook
*/

// single product reviewer name
add_action('woocommerce_review_before_comment_meta','luxrio_woocommerce_reviewer_meta',10,1);

/*
*   cart hook
*/
// cross sell products
add_action('woocommerce_after_cart','luxrio_woocommerce_cross_sell_display',10);


// product compare button remove
add_filter( 'woosc_button_position_archive', '__return_false' );
add_filter( 'woosc_button_position_single', '__return_false' );

add_filter( 'woosc_button_html', 'luxrio_woosc_button_html', 10, 2 );
function luxrio_woosc_button_html( $output , $prodid ) {
    return $output = '<a href="#" class="icon-btn  woosc-btn woosc-btn-' . esc_attr( $prodid ) . ' ' . get_option( '_woosc_button_class' ) . '" data-id="' . esc_attr( $prodid ) . '"><i class="fas fa-layer-group"></i></a>';
}

// Compare Button Text Added
add_filter( 'woosc_button_text_added', 'luxrio_woo_compare_btn_text_added', 10, 2 );
function luxrio_woo_compare_btn_text_added( ){
    return $output = '<i class="fas fa-layer-group"></i>';
}

add_filter( 'woosc_button_text', 'luxrio_compare_btn_text', 10, 2 );
function luxrio_compare_btn_text(){
    return $output = '<i class="fas fa-layer-group"></i>';
}

// Quick View
add_filter( 'woosq_button_position', function() {
    return '0';
} );

add_filter( 'woosq_button_html', 'luxrio_woosq_button_html', 10, 2 );
function luxrio_woosq_button_html( $output , $prodid ) {
    return $output = '<a href="#" class="product-action__btn woosq-btn woosq-btn-' . esc_attr( $prodid ) . ' ' . get_option( 'woosq_button_class' ) . '" data-id="' . esc_attr( $prodid ) . '" data-effect="mfp-3d-unfold"><i class="far fa-eye"></i></a>';
}