<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit();
}
/**
 * @Packge     : Luxrio
 * @Version    : 1.0
 * @Author     : Vecurosoft
 * @Author URI : https://www.vecurosoft.com/
 *
 */

// enqueue css
function luxrio_common_custom_css(){
	// Register an inline-only stylesheet (no HTTP request) that the dynamic CSS below attaches to.
	wp_register_style( 'luxrio-color-schemes', false, array(), null );
	wp_enqueue_style( 'luxrio-color-schemes' );

    $CustomCssOpt = luxrio_opt( 'luxrio_css_editor' );

    if ( ! $CustomCssOpt ) {
        $CustomCssOpt = '';
    }

    $customcss = "";

    if( get_header_image() ){
        $luxrio_header_bg =  get_header_image();
    }

	if( class_exists('woocommerce') ){
		if( is_shop() ){
			$luxrio_header_bg = luxrio_opt( 'luxrio_shop_breadcrumb_bg','url');
		}

		if( is_singular( 'product' ) ){
			$luxrio_header_bg = luxrio_opt( 'luxrio_shop_breadcrumb_bg','url');
		}
		
		if( is_product_category() ){
			$luxrio_header_bg = luxrio_opt( 'luxrio_shop_breadcrumb_bg','url');
		}
	}
	if( luxrio_meta( 'page_breadcrumb_settings' ) == 'page' && is_page() ){
		if( ! empty( luxrio_meta( 'breadcumb_image' ) ) ){
			$luxrio_header_bg = luxrio_meta( 'breadcumb_image' );
		}
	}

    if( !empty( $luxrio_header_bg ) ){
        $customcss .= ".breadcumb-wrapper{
            background-image:url('{$luxrio_header_bg}')!important;
        }";
    }



	// theme color
	$luxrio_primary 	    = luxrio_opt('luxrio_primary');
	$luxrio_secondary      = luxrio_opt('luxrio_secondary');
	$luxrio_heading_color  = luxrio_opt('luxrio_heading_color');	
	$luxrio_body_color     = luxrio_opt('luxrio_body_color');
	$luxrio_body_bg        = luxrio_opt('luxrio_body_bg');
	$light_color            = luxrio_opt('light_color');
	$black_color            = luxrio_opt('black_color');
	$white_color            = luxrio_opt('white_color');
	$luxrio_smoke          = luxrio_opt('luxrio_smoke');
	$yellow_color           = luxrio_opt('yellow_color');
	$success_color          = luxrio_opt('success_color');
	$error_color            = luxrio_opt('error_color');
	$border_color           = luxrio_opt('border_color');

	
	if( !empty( $luxrio_primary ) ) {
		$customcss .= ":root {
		  --theme-color: {$luxrio_primary};
		}";
	}

	if( !empty( $luxrio_secondary ) ) {
		$customcss .= ":root {
			--theme-color2: {$luxrio_secondary};
		}";
	}


	if( !empty( $luxrio_heading_color ) ) {
		$customcss .= ":root {
			--title-color: {$luxrio_heading_color};
		}";
	}

	if( !empty( $luxrio_body_color ) ) {
		$customcss .= ":root {
			--body-color: {$luxrio_body_color};
		}";
	}

	if( !empty( $luxrio_body_bg ) ) {
		$customcss .= ":root {
			--body-bg: {$luxrio_body_bg};
		}";
	}

	if( !empty( $light_color ) ) {
		$customcss .= ":root {
			--light-color: {$light_color};
		}";
	}

	if( !empty( $luxrio_smoke ) ) {
		$customcss .= ":root {
			--smoke-color: {$luxrio_smoke};
		}";
	}

	if( !empty( $black_color ) ) {
		$customcss .= ":root {
			--black-color: {$black_color};
		}";
	}

	if( !empty( $white_color  ) ) {
		$customcss .= ":root {
			--white-color: {$white_color };
		}";
	}

	if( !empty( $success_color ) ) {
		$customcss .= ":root {
			--success-color: {$success_color};
		}";
	}

	if( !empty( $error_color ) ) {
		$customcss .= ":root {
			--error-color: {$error_color};
		}";
	}

	if( !empty( $border_color ) ) {
		$customcss .= ":root {
			--border-color: {$border_color};
		}";
	}

	if( !empty( $CustomCssOpt ) ){
		$customcss .= $CustomCssOpt;
	}

    wp_add_inline_style( 'luxrio-color-schemes', $customcss );
}
add_action( 'wp_enqueue_scripts', 'luxrio_common_custom_css', 100 );