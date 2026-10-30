<?php

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme ecohost for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */



/**
 * Include the TGM_Plugin_Activation class.
 */
require_once LUXRIO_DIR_PATH_INC . 'luxrio-framework/plugins-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'luxrio_register_required_plugins' );
function luxrio_register_required_plugins() {

    /*
    * Array of plugin arrays. Required keys are name and slug.
    * If the source is NOT from the .org repo, then source is also required.
    */

    $plugins = array(

        array(
            'name'                  => esc_html__( 'Luxrio Core', 'luxrio' ),
            'slug'                  => 'luxrio-core',
            'version'               => '1.0',
            'source'                => LUXRIO_DIR_PATH_INC . 'luxrio-framework/plugins/luxrio-core.zip',
            'required'              => true,
        ),
        
        array(
            'name'                  => esc_html__( 'TI WooCommerce Wishlist', 'luxrio' ),
            'slug'                  => 'ti-woocommerce-wishlist',
            'required'              => true,
        ),

        array(
            'name'                  => esc_html__( 'One Click Demo Importer', 'luxrio' ),
            'slug'                  => 'one-click-demo-import',
            'required'              => true,
        ),

        array(
            'name'                  => esc_html__( 'Variation Swatches for WooCommerce', 'luxrio' ),
            'slug'                  => 'woo-variation-swatches',
            'required'              => true,
        ),

        array(
            'name'      => esc_html__( 'Elementor', 'luxrio' ),
            'slug'      => 'elementor',
            'version'   => '',
            'required'  => true,
        ),
   
        array(
            'name'      => esc_html__( 'Redux Framework', 'luxrio' ),
            'slug'      => 'redux-framework',
            'version'   => '',
            'required'  => true,
        ),

        array(
            'name'      => esc_html__( 'CMB2', 'luxrio' ),
            'slug'      => 'cmb2',
            'required'  => true,
        ),

        array(
            'name'      => esc_html__( 'Contact Form 7', 'luxrio' ),
            'slug'      => 'contact-form-7',
            'version'   => '',
            'required'  => true,
        ),
        
        array(
            'name'      => esc_html__( 'WooCommerce', 'luxrio' ),
            'slug'      => 'woocommerce',
            'version'   => '',
            'required'  => true,
        ),

        array(
            'name'      => esc_html__( 'WPC Smart Quick View for WooCommerce', 'luxrio' ),
            'slug'      => 'woo-smart-quick-view',
            'version'   => '',
            'required'  => true,
        ),
        array(
            'name'      => esc_html__( 'Side Cart WooCommerce', 'luxrio' ),
            'slug'      => 'side-cart-woocommerce',
            'version'   => '',
            'required'  => true,
        ),
        array(
            'name'      => esc_html__( 'Max Mega Menu', 'luxrio' ),
            'slug'      => 'megamenu',
            'version'   => '',
            'required'  => true,
        ),

    );

    $config = array(
        'id'           => 'luxrio',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    );

    tgmpa( $plugins, $config );
}