<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div <?php wc_product_class( array('product-style1'), $product ); ?>>
    <?php
        if( has_post_thumbnail() ){
            echo '<div class="product-img">';
                the_post_thumbnail( 'product-image-two', array( 'class' => 'img' ) );
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
            echo '</div>';
        }
    ?>
   
    <?php
    echo '<h3 class="product-title">';
        echo '<a href="'.esc_url( get_the_permalink() ).'">'.esc_html( get_the_title() ).'</a>';
    echo '</h3>';
    
    $rprice = $product->get_price_html();

    echo '<span class="product-price">';
        $rprice = $product->get_price_html();
        echo '<span class="product-price__number">'.$rprice.'</span>';

        echo '<div class="product-cart">'; 
            // Cart Button
            woocommerce_template_loop_add_to_cart_text_style();
        echo '</div>';

    echo '</span>';
    echo '<div class="product-rate">';
        echo woocommerce_template_loop_rating();
    echo '</div>';
echo '</div>';