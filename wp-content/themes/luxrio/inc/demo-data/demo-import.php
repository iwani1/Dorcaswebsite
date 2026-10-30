<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( );
}
/**
 * @Packge    : luxrio
 * @version   : 1.0
 * @Author    : Vecurosoft
 * @Author URI: https://www.vecurosoft.com/
 */
 
// demo import file
function luxrio_import_files() {

	$demoImg = '<img src="'. LUXRIO_DEMO_DIR_URI  .'screen-image.png" alt="'.esc_attr__('Demo Preview Imgae','luxrio').'" />';
    return array(
        array(
            'import_file_name'             => esc_html__('Luxrio Demo','luxrio'),
            'local_import_file'            =>  LUXRIO_DEMO_DIR_PATH  . 'luxrio-demo.xml',
            'local_import_widget_file'     =>  LUXRIO_DEMO_DIR_PATH  . 'luxrio-widgets-demo.json',
            'local_import_redux'           => array(
                array(
                    'file_path'   =>  LUXRIO_DEMO_DIR_PATH . 'redux_options_demo.json',
                    'option_name' => 'luxrio_opt',
                ),
            ),
            'import_notice' => $demoImg,
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'luxrio_import_files' );

// Resolve a page ID by title without the deprecated get_page_by_title() (WP 6.2+).
function luxrio_get_page_id_by_title( $title ) {
    $query = new WP_Query(
        array(
            'post_type'              => 'page',
            'title'                  => $title,
            'post_status'            => 'publish',
            'posts_per_page'         => 1,
            'fields'                 => 'ids',
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'ignore_sticky_posts'    => true,
        )
    );

    return ! empty( $query->posts ) ? (int) $query->posts[0] : 0;
}

// demo import setup
function luxrio_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Primary Menu', 'nav_menu' );

    if ( $main_menu instanceof WP_Term ) {
        set_theme_mod(
            'nav_menu_locations',
            array(
                'primary-menu' => (int) $main_menu->term_id,
                'mobile-menu'  => (int) $main_menu->term_id,
            )
        );
    }

    // Assign front page and posts page (blog page).
    $front_page_id = luxrio_get_page_id_by_title( 'Home 01' );
    $blog_page_id  = luxrio_get_page_id_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );

    if ( $front_page_id ) {
        update_option( 'page_on_front', $front_page_id );
    }

    if ( $blog_page_id ) {
        update_option( 'page_for_posts', $blog_page_id );
    }

    luxrio_elementor_settings();

    // Clear the Elementor CSS cache if Elementor is active (it may not be).
    if ( class_exists( '\Elementor\Core\Files\Manager' ) ) {
        $elem_clear_cache = new \Elementor\Core\Files\Manager();

        if ( method_exists( $elem_clear_cache, 'clear_cache' ) ) {
            $elem_clear_cache->clear_cache();
        }
    }
}
add_action( 'pt-ocdi/after_import', 'luxrio_after_import_setup' );


//disable the branding notice after successful demo import
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

//change the location, title and other parameters of the plugin page
function luxrio_import_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'Luxrio Demo Import' , 'luxrio' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'luxrio' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'luxrio-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'luxrio_import_plugin_page_setup' );
 
// Enqueue scripts
function luxrio_demo_import_custom_scripts(){
	if ( isset( $_GET['page'] ) && 'luxrio-demo-import' === sanitize_key( wp_unslash( $_GET['page'] ) ) ) {
		// style
		wp_enqueue_style( 'luxrio-demo-import', LUXRIO_DEMO_DIR_URI.'css/luxrio.demo.import.css', array(), '1.0', false );
	}
}
add_action( 'admin_enqueue_scripts', 'luxrio_demo_import_custom_scripts' );

//Global Color Option
function luxrio_elementor_settings() {
    $kit_id = (int) get_option( 'elementor_active_kit' );

    // Bail out when Elementor is not installed (no kit exists) or the kit is gone.
    if ( ! $kit_id || ! get_post( $kit_id ) ) {
        return false;
    }

    $settings = json_decode( '[{"system_colors":[{"_id":"luxrio_opt_primary","title":"Primary","color":"#ff3e01"},{"_id":"luxrio_opt_secondary","title":"Secondary","color":"#eef2fb"},{"_id":"luxrio_opt_secondary_two","title":"Secondary","color":"#15161b"},{"_id":"luxrio_opt_headline","title":"Heading","color":"#021210"},{"_id":"luxrio_opt_body","title":"Body","color":"#4a4949"},{"_id":"luxrio_opt_body_bg","title":"Body Background","color":"#ffffff"},{"_id":"luxrio_opt_light_color","title":"Light Color","color":"#d1d0d0"},{"_id":"luxrio_opt_black_color","title":"Black Color","color":"#000000"},{"_id":"luxrio_opt_white_color","title":"White Color","color":"#ffffff"},{"_id":"luxrio_opt_yellow_color","title":"Yellow Color","color":"#fec624"},{"_id":"luxrio_opt_success_color","title":"Success Color","color":"#28a745"},{"_id":"luxrio_opt_error_color","title":"Error Color","color":"#dc3545"},{"_id":"luxrio_opt_border_color","title":"Border Color","color":"#e0e0e0"},{"_id":"luxrio_opt_luxrio_smoke","title":"Smoke Color","color":" #d1d0d0"}],"system_typography":[],"__globals__":[]}]', true );

    return update_post_meta( $kit_id, '_elementor_page_settings', $settings[0] );
}