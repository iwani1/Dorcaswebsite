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
 * Include File
 *
 */
  
// Constants
require_once get_parent_theme_file_path() . '/inc/luxrio-constants.php';

//theme setup
require_once LUXRIO_DIR_PATH_INC . 'theme-setup.php';

//essential scripts
require_once LUXRIO_DIR_PATH_INC . 'essential-scripts.php';

if( class_exists( 'WooCommerce' ) ){
    // Woo Hooks
    require_once LUXRIO_DIR_PATH_INC . 'woo-hooks/luxrio-woo-hooks.php';

    // Woo Hooks Functions
    require_once LUXRIO_DIR_PATH_INC . 'woo-hooks/luxrio-woo-hooks-functions.php';
}

// plugin activation
require_once LUXRIO_DIR_PATH_INC . 'luxrio-framework/plugins-activation/luxrio-active-plugins.php';

// meta options
require_once LUXRIO_DIR_PATH_INC . 'luxrio-framework/luxrio-meta/luxrio-config.php';

// page breadcrumbs
require_once LUXRIO_DIR_PATH_INC . 'luxrio-breadcrumbs.php';

// sidebar register
require_once LUXRIO_DIR_PATH_INC . 'luxrio-widgets-reg.php';

//luxrio elementor integration
require_once LUXRIO_DIR_PATH_INC . 'luxrio-elementor-integration.php';

//essential functions
require_once LUXRIO_DIR_PATH_INC . 'luxrio-functions.php';

// theme dynamic css
require_once LUXRIO_DIR_PATH_INC . 'luxrio-commoncss.php';

// helper function
require_once LUXRIO_DIR_PATH_INC . 'wp-html-helper.php';

// Demo Data
require_once LUXRIO_DEMO_DIR_PATH . 'demo-import.php';

// pagination
require_once LUXRIO_DIR_PATH_INC . 'wp_bootstrap_pagination.php';

// luxrio options
require_once LUXRIO_DIR_PATH_INC . 'luxrio-framework/luxrio-options/luxrio-options.php';

// hooks
require_once LUXRIO_DIR_PATH_HOOKS . 'hooks.php';

// hooks funtion
require_once LUXRIO_DIR_PATH_HOOKS . 'hooks-functions.php';