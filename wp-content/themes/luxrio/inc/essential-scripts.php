<?php
/**
 * @Packge     : Luxrio
 * @Version    : 1.0
 * @Author     : Vecurosoft
 * @Author URI : https://www.vecurosoft.com/
 *
 */

// Block direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue scripts and styles.
 */
function luxrio_essential_scripts() {

	wp_enqueue_style( 'luxrio-style', get_stylesheet_uri() ,array(), wp_get_theme()->get( 'Version' ) );

    // google font
    wp_enqueue_style( 'luxrio-fonts', luxrio_google_fonts() ,array(), wp_get_theme()->get( 'Version' ) );

    // Font Awesome Five
    wp_enqueue_style( 'fontawesome', get_theme_file_uri( '/assets/css/fontawesome.min.css' ) ,array(), '6.6.0' );

    // Slick css
    wp_enqueue_style( 'slick', get_theme_file_uri( '/assets/css/slick.min.css' ) ,array(), '4.0.13' );

    // Bootstrap Min
    wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/css/bootstrap.min.css' ) ,array(), '4.3.1' );

    // Magnific Popup
    wp_enqueue_style( 'magnific-popup', get_theme_file_uri( '/assets/css/magnific-popup.min.css' ), array(), '1.0' );

    // luxrio app style
    wp_enqueue_style( 'luxrio-main-style', get_theme_file_uri('/assets/css/style.css') ,array(), wp_get_theme()->get( 'Version' ) );

    // Load Js

    // Bootstrap
    wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array( 'jquery' ), '4.3.1', true );

    // Slick
    wp_enqueue_script( 'slick', get_theme_file_uri( '/assets/js/slick.min.js' ), array('jquery'), '1.0.0', true );
    
    // Slick animation
    wp_enqueue_script( 'slick-animation', get_theme_file_uri( '/assets/js/slick-animation.min.js' ), array('jquery'), '1.0.0', true );

    // magnific popup
    wp_enqueue_script( 'magnific-popup', get_theme_file_uri( '/assets/js/jquery.magnific-popup.min.js' ), array('jquery'), '1.0.0', true );

    // Isotope
    wp_enqueue_script( 'isototpe-pkgd', get_theme_file_uri( '/assets/js/isotope.pkgd.min.js' ), array( 'jquery' ), '1.0.0', true );

    // Isotope Imagesloaded
    wp_enqueue_script( 'imagesloaded' );

    // wow script
    wp_enqueue_script( 'luxrio-wow', get_theme_file_uri( '/assets/js/wow.min.js' ), array('jquery'), wp_get_theme()->get( 'Version' ), true );
    
    // gsap script
    wp_enqueue_script( 'gsap', get_theme_file_uri( '/assets/js/gsap.min.js' ), array('jquery'), wp_get_theme()->get( 'Version' ), true );
    
    // gsap scroll-to-plugin script
    wp_enqueue_script( 'gsap-scroll-to-plugin', get_theme_file_uri( '/assets/js/gsap-scroll-to-plugin.js' ), array('jquery'), '3.11.4', true );

    // lenis script
    wp_enqueue_script( 'lenis', get_theme_file_uri( '/assets/js/lenis.min.js' ), array('jquery'), '1.1.17', true );
    
    // Scroll Trigger script
    wp_enqueue_script( 'scrolltrigger', get_theme_file_uri( '/assets/js/ScrollTrigger.min.js' ), array('jquery'), '3.12.5', true );
    
    // main script
    wp_enqueue_script( 'luxrio-main-script', get_theme_file_uri( '/assets/js/main.js' ), array('jquery'), wp_get_theme()->get( 'Version' ), true );

    // comment reply
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    

}
add_action( 'wp_enqueue_scripts', 'luxrio_essential_scripts',99 );


function luxrio_block_editor_assets( ) {
    // Add custom fonts.
	wp_enqueue_style( 'luxrio-editor-fonts', luxrio_google_fonts(), array(), null );
}

add_action( 'enqueue_block_editor_assets', 'luxrio_block_editor_assets' );
 
function luxrio_google_fonts() {
    $font_families = array(
        'Cormorant:300,400,500,600,700',
        'Italiana:100,200,300,400,500,600,700,800,900', 
        'Poppins:100,200,300,400,500,600,700,800,900',
    );

    $familyArgs = array(
        'family' => urlencode( implode( '|', $font_families ) ),
        'subset' => urlencode( 'latin,latin-ext' ),
    );

    $fontUrl = add_query_arg( $familyArgs, '//fonts.googleapis.com/css' );

    return esc_url_raw( $fontUrl );
}