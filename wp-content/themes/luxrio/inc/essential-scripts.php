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
/**
 * Cache-busting version string for a local theme asset.
 *
 * Uses the file's modification time so that a replaced vendor file always
 * busts browser/proxy caches, instead of hardcoded version numbers that
 * drift away from the build actually shipped in the package.
 *
 * @param string $relative_path Path relative to the theme root, e.g. '/assets/js/slick.min.js'.
 * @return string
 */
function luxrio_asset_version( $relative_path ) {
    $path = get_theme_file_path( $relative_path );

    return file_exists( $path ) ? (string) filemtime( $path ) : wp_get_theme()->get( 'Version' );
}

function luxrio_essential_scripts() {

	wp_enqueue_style( 'luxrio-style', get_stylesheet_uri(), array(), luxrio_asset_version( '/style.css' ) );

    // google font
    wp_enqueue_style( 'luxrio-fonts', luxrio_google_fonts() ,array(), wp_get_theme()->get( 'Version' ) );

    // Font Awesome Free 6
    wp_enqueue_style( 'fontawesome', get_theme_file_uri( '/assets/css/fontawesome.min.css' ), array(), luxrio_asset_version( '/assets/css/fontawesome.min.css' ) );

    // Slick css
    wp_enqueue_style( 'slick', get_theme_file_uri( '/assets/css/slick.min.css' ), array(), luxrio_asset_version( '/assets/css/slick.min.css' ) );

    // Bootstrap Min
    wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/css/bootstrap.min.css' ), array(), luxrio_asset_version( '/assets/css/bootstrap.min.css' ) );

    // Magnific Popup
    wp_enqueue_style( 'magnific-popup', get_theme_file_uri( '/assets/css/magnific-popup.min.css' ), array(), luxrio_asset_version( '/assets/css/magnific-popup.min.css' ) );

    // luxrio app style
    wp_enqueue_style( 'luxrio-main-style', get_theme_file_uri( '/assets/css/style.min.css' ), array(), luxrio_asset_version( '/assets/css/style.min.css' ) );

    // Load Js

    // Bootstrap
    wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/bootstrap.min.js' ), true );

    // Slick
    wp_enqueue_script( 'slick', get_theme_file_uri( '/assets/js/slick.min.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/slick.min.js' ), true );
    
    // Slick animation
    wp_enqueue_script( 'slick-animation', get_theme_file_uri( '/assets/js/slick-animation.min.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/slick-animation.min.js' ), true );

    // magnific popup
    wp_enqueue_script( 'magnific-popup', get_theme_file_uri( '/assets/js/jquery.magnific-popup.min.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/jquery.magnific-popup.min.js' ), true );

    // Isotope
    wp_enqueue_script( 'isototpe-pkgd', get_theme_file_uri( '/assets/js/isotope.pkgd.min.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/isotope.pkgd.min.js' ), true );

    // Isotope Imagesloaded
    wp_enqueue_script( 'imagesloaded' );

    // wow script
    wp_enqueue_script( 'luxrio-wow', get_theme_file_uri( '/assets/js/wow.min.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/wow.min.js' ), true );
    
    // gsap script
    wp_enqueue_script( 'gsap', get_theme_file_uri( '/assets/js/gsap.min.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/gsap.min.js' ), true );
    
    // gsap scroll-to-plugin script
    wp_enqueue_script( 'gsap-scroll-to-plugin', get_theme_file_uri( '/assets/js/gsap-scroll-to-plugin.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/gsap-scroll-to-plugin.js' ), true );

    // lenis script
    wp_enqueue_script( 'lenis', get_theme_file_uri( '/assets/js/lenis.min.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/lenis.min.js' ), true );
    
    // Scroll Trigger script
    wp_enqueue_script( 'scrolltrigger', get_theme_file_uri( '/assets/js/ScrollTrigger.min.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/ScrollTrigger.min.js' ), true );
    
    // main script
    wp_enqueue_script( 'luxrio-main-script', get_theme_file_uri( '/assets/js/main.js' ), array( 'jquery' ), luxrio_asset_version( '/assets/js/main.js' ), true );

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