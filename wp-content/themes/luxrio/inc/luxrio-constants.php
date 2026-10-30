<?php
/**
 * @Packge     : Luxrio
 * @Version    : 1.0
 * @Author     : Vecurosoft
 * @Author URI : https://www.vecurosoft.com/
 *
 */

// Block direct access
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 *
 * Define constant
 *
 */

// Base URI
if ( ! defined( 'LUXRIO_DIR_URI' ) ) {
    define('LUXRIO_DIR_URI', get_parent_theme_file_uri().'/' );
}

// Assist URI
if ( ! defined( 'LUXRIO_DIR_ASSIST_URI' ) ) {
    define( 'LUXRIO_DIR_ASSIST_URI', get_theme_file_uri('/assets/') );
}


// Css File URI
if ( ! defined( 'LUXRIO_DIR_CSS_URI' ) ) {
    define( 'LUXRIO_DIR_CSS_URI', get_theme_file_uri('/assets/css/') );
}

// Skin Css File
if ( ! defined( 'LUXRIO_DIR_SKIN_CSS_URI' ) ) {
    define( 'LUXRIO_DIR_SKIN_CSS_URI', get_theme_file_uri('/assets/css/skins/') );
}


// Js File URI
if (!defined('LUXRIO_DIR_JS_URI')) {
    define('LUXRIO_DIR_JS_URI', get_theme_file_uri('/assets/js/'));
}


// External PLugin File URI
if (!defined('LUXRIO_DIR_PLUGIN_URI')) {
    define('LUXRIO_DIR_PLUGIN_URI', get_theme_file_uri( '/assets/plugins/'));
}

// Base Directory
if (!defined('LUXRIO_DIR_PATH')) {
    define('LUXRIO_DIR_PATH', get_parent_theme_file_path() . '/');
}

//Inc Folder Directory
if (!defined('LUXRIO_DIR_PATH_INC')) {
    define('LUXRIO_DIR_PATH_INC', LUXRIO_DIR_PATH . 'inc/');
}

//LUXRIO framework Folder Directory
if (!defined('LUXRIO_DIR_PATH_FRAM')) {
    define('LUXRIO_DIR_PATH_FRAM', LUXRIO_DIR_PATH_INC . 'luxrio-framework/');
}

//Classes Folder Directory
if (!defined('LUXRIO_DIR_PATH_CLASSES')) {
    define('LUXRIO_DIR_PATH_CLASSES', LUXRIO_DIR_PATH_INC . 'classes/');
}

//Hooks Folder Directory
if (!defined('LUXRIO_DIR_PATH_HOOKS')) {
    define('LUXRIO_DIR_PATH_HOOKS', LUXRIO_DIR_PATH_INC . 'hooks/');
}

//Demo Data Folder Directory Path
if( !defined( 'LUXRIO_DEMO_DIR_PATH' ) ){
    define( 'LUXRIO_DEMO_DIR_PATH', LUXRIO_DIR_PATH_INC.'demo-data/' );
}
    
//Demo Data Folder Directory URI
if( !defined( 'LUXRIO_DEMO_DIR_URI' ) ){
    define( 'LUXRIO_DEMO_DIR_URI', LUXRIO_DIR_URI.'inc/demo-data/' );
}