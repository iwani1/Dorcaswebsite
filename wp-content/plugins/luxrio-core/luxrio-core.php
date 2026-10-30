<?php
/**
 * Plugin Name: Luxrio Core
 * Description: This is a helper plugin of luxrio theme
 * Version:     1.0.1
 * Author:      Vecurosoft
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
 * Text Domain: luxrio
 */
 // Blocking direct access
if( ! defined( 'ABSPATH' ) ) {
    exit();
}

// Define Constant
define( 'LUXRIO_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'LUXRIO_PLUGIN_INC_PATH', plugin_dir_path( __FILE__ ) . 'inc/' );
define( 'LUXRIO_PLUGIN_CMB2EXT_PATH', plugin_dir_path( __FILE__ ) . 'cmb2-ext/' );
define( 'LUXRIO_PLUGIN_WIDGET_PATH', plugin_dir_path( __FILE__ ) . 'inc/widgets/' );
define( 'LUXRIO_PLUGIN_MODULES_PATH', plugin_dir_path( __FILE__ ) . 'inc/modules/' );
define( 'LUXRIO_PLUGDIRURI', plugin_dir_url( __FILE__ ) );
define( 'LUXRIO_ADDONS', plugin_dir_path( __FILE__ ) .'addons/' );
define( 'LUXRIO_CORE_PLUGIN_TEMP', plugin_dir_path( __FILE__ ) .'luxrio-template/' );

// load textdomain
add_action( 'init', 'luxrio_load_textdomain' );
function luxrio_load_textdomain(){
    load_plugin_textdomain( 'luxrio', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

//include file.
require_once LUXRIO_PLUGIN_INC_PATH .'luxriocore-functions.php';
require_once LUXRIO_PLUGIN_INC_PATH .'builder/builder.php';
 
require_once LUXRIO_PLUGIN_CMB2EXT_PATH . 'cmb2ext-init.php';

//Widget
require_once LUXRIO_PLUGIN_WIDGET_PATH . 'recent-post-widget.php';
require_once LUXRIO_PLUGIN_WIDGET_PATH . 'gallery-widget.php';


//
require_once LUXRIO_PLUGIN_MODULES_PATH . 'css-transform.php';
require_once LUXRIO_PLUGIN_MODULES_PATH . 'custom-css.php';

//addons
require_once LUXRIO_ADDONS . 'addons.php';