<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$luxrio_woo_relproduct_display = luxrio_opt('luxrio_woo_relproduct_display');

if ( $related_products && $luxrio_woo_relproduct_display) : ?>
    <div class="space-extra-top">
	<div class="container">
        <div class="row"> 
            <div class="col-lg-auto mx-auto">
                <div class="title-area text-center">
                <?php if( ! empty( luxrio_opt('luxrio_woo_related_subtitle') ) ):?>
                    <span class="sec-subtitle"><?php echo esc_html( luxrio_opt('luxrio_woo_related_subtitle') );?></span>
                <?php endif;?>
                <?php if( ! empty( luxrio_opt('luxrio_woo_related_title') ) ):?>
                <h2 class="sec-title text-white text-uppercase"><?php echo esc_html( luxrio_opt('luxrio_woo_related_title') );?></h2>
                <?php endif;?>
                <?php 
                    if( ! empty( luxrio_opt('luxrio_related_title_shape_image','url') ) ){
                        echo luxrio_img_tag( array(
                            'url'   => esc_url( luxrio_opt('luxrio_related_title_shape_image','url') )
                        ) );
                    }
                ?>
                </div>
            </div>
        </div>

        <?php
            if( class_exists('ReduxFramework') ) {
                $luxrio_woo_related_product_col = luxrio_opt('luxrio_woo_related_product_col');
            } else{
                $luxrio_woo_related_product_col = '3';
            }
        ?>
		<div class="row related-product vs-carousel" data-slide-show="<?php echo esc_attr( $luxrio_woo_related_product_col );?>" data-lg-slide-show="3" data-md-slide-show="2" >
        

			<?php foreach ( $related_products as $related_product ) : ?>
                <div class="col-md-6 col-lg-3">
                    <?php
                        $post_object = get_post( $related_product->get_id() );

                        setup_postdata( $GLOBALS['post'] =& $post_object );

                        wc_get_template_part( 'content', 'product-four' );
                    ?>
                </div>

			<?php endforeach; ?>

		</div>

	</div>
	</div>

<?php endif;

wp_reset_postdata();