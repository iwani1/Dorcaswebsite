<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "luxrio_opt";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }


    $alowhtml = array(
        'p' => array(
            'class' => array()
        ),
        'span' => array()
    );


    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Luxrio Options', 'luxrio' ),
        'page_title'           => esc_html__( 'Luxrio Options', 'luxrio' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );


    Redux::set_args( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'luxrio' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'luxrio' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'luxrio' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'luxrio' )
        )
    );
    Redux::set_help_tab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'luxrio' );
    Redux::set_help_sidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */


    // -> START General Fields

    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'General', 'luxrio' ),
        'id'               => 'luxrio_general_option',
        'customizer_width' => '450px',
        'icon'             => 'el el-cog',
        'fields'           => array(
            array(
                'id'       => 'luxrio_scroll_animation',
                'type'     => 'switch',
                'title'    => esc_html__( 'Scroll Animation', 'luxrio' ),
                'subtitle' => esc_html__( 'Switch Enabled to Enable Animation.', 'luxrio' ),
                'default'  => true,
                'on'       => esc_html__('Enabled','luxrio'),
                'off'      => esc_html__('Disabled','luxrio'),
            ),
        )
    ));
   

    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Brand Color', 'luxrio' ),
        'id'               => 'luxrio_brand_color',
        'customizer_width' => '450px',
        'icon'             => 'el el-cog',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'luxrio_primary',
                'type'     => 'color',
                'title'    => esc_html__( 'Primary Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Primary Theme Color', 'luxrio' ),
                'default'  => '#ff3e01',
            ),

            array(
                'id'       => 'luxrio_secondary',
                'type'     => 'color',
                'title'    => esc_html__( 'Secondary Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Secondary Theme Color', 'luxrio' ),
                'default'  => '#eef2fb',
            ),
            array(
                'id'       => 'luxrio_heading_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Heading Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Heading Color', 'luxrio' ),
                'default'  => '#021210',
            ),
            array(
                'id'       => 'luxrio_body_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Body Text Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Body Text Color', 'luxrio' ),
                'default'  => '#4a4949',
            ),
            array(
                'id'       => 'luxrio_body_bg',
                'type'     => 'color',
                'title'    => esc_html__( 'White Background', 'luxrio' ),
                'subtitle' => esc_html__( 'Set White Bg Color', 'luxrio' ),
                'default'  => '#ffffff',
            ),
            array(
                'id'       => 'light_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Light Color', 'luxrio' ),
                'default'  => '#eee7d5',
            ),
            array(
                'id'       => 'black_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Black Color', 'luxrio' ),
                'default'  => '#000000',
            ),
            array(
                'id'       => 'white_color',
                'type'     => 'color',
                'title'    => esc_html__( 'White Color', 'luxrio' ),
                'default'  => '#ffffff',
            ),
            array(
                'id'       => 'luxrio_smoke',
                'type'     => 'color',
                'title'    => esc_html__( 'Smoke Color', 'luxrio' ),
                'default'  => ' #d1d0d0',
            ),
            array(
                'id'       => 'yellow_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Yellow Color', 'luxrio' ),
                'default'  =>  '#fec624',
            ),
            array(
                'id'       => 'success_color',
                'type'     => 'color',
                'title'    => esc_html__( 'success Color', 'luxrio' ),
                'default'  => '#28a745',
            ),
            array(
                'id'       => 'error_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Error Color', 'luxrio' ),
                'default'  => '#dc3545',
            ),
            array(
                'id'       => 'border_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Border Color', 'luxrio' ),
                'default'  => '#e0e0e0',
            ),

        )

    ) );


    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Typography', 'luxrio' ),
        'id'               => 'luxrio_typography',
        'customizer_width' => '450px',
        'icon'             => 'el el-cog',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'          => 'title_typography',
                'type'        => 'typography', 
                'title'       => __( 'Title Typography', 'luxrio' ),
                'google'      => true, 
                'font-backup' => true,
                'output'      => array('
                    h1, h2, h3, h4, h5, h6,.h1, .h2, .h3, .h4, .h5, .h6
                '),
                'units'       =>'px',
                'subtitle'    => __('Typography option with each property can be called individually.', 'luxrio'),
            ),
            array(
                'id'          => 'body_typography',
                'type'        => 'typography', 
                'title'       => __( 'Body Typography', 'luxrio' ),
                'google'      => true, 
                'font-backup' => true,
                'output'      => array('
                    body,
                    label,
                    p,
                    span
                '),
                'units'       =>'px',
                'subtitle'    => __('Typography option with each property can be called individually.', 'luxrio'),
            ),
        )

    ) );

    // Start Back to Top
    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Back To Top', 'luxrio' ),
        'id'               => 'luxrio_backtotop',
        'subsection'       => false,
        'fields'           => array(
            array(
                'id'       => 'luxrio_display_bcktotop',
                'type'     => 'switch',
                'title'    => esc_html__( 'Back To Top Button', 'luxrio' ),
                'subtitle' => esc_html__( 'Switch On to Display back to top button.', 'luxrio' ),
                'default'  => true,
                'on'       => esc_html__( 'Enabled', 'luxrio' ),
                'off'      => esc_html__( 'Disabled', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_bcktotop_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Back To Top Button Background Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Back to top button Background Color.', 'luxrio' ),
                'required' => array('luxrio_display_bcktotop','equals','1'),
                'output'   => array( 'background-color' =>'.scrollToTop' ),
            ),
            array(
                'id'       => 'luxrio_bcktotop_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Back To Top Icon Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Back to top Icon Color.', 'luxrio' ),
                'required' => array('luxrio_display_bcktotop','equals','1'),
                'output'   => array( '.scrollToTop i' ),
            ),
            array(
                'id'       => 'luxrio_bcktotop_border_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Back To Top Button Border Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Back to top button border Color.', 'luxrio' ),
                'required' => array('luxrio_display_bcktotop','equals','1'),
                'output'   => array( 'border-color' =>'.border-before-theme:before' ),
            )
        )
    ) );

    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Preloader', 'luxrio' ),
        'id'               => 'luxrio_preloader',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'luxrio_display_preloader',
                'type'     => 'switch',
                'title'    => esc_html__( 'Preloader', 'luxrio' ),
                'subtitle' => esc_html__( 'Switch Enabled to Display Preloader.', 'luxrio' ),
                'default'  => true,
                'on'       => esc_html__('Enabled','luxrio'),
                'off'      => esc_html__('Disabled','luxrio'),
            ),
            array(
                'id'       => 'luxrio_preloader_img',
                'type'     => 'media',
                'title'    => esc_html__( 'Preloader Image', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Preloader Image.', 'luxrio' ),
                'required' => array( "luxrio_display_preloader","equals",true )
            ),
            array(
                'id'       => 'luxrio_preloader_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Preloader Color One', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Preloader Color One', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_preloader_color_two',
                'type'     => 'color',
                'title'    => esc_html__( 'Preloader Color Two', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Preloader Color Two', 'luxrio' ),
            ),
        )
    ));

    

    /* End General Fields */

    /* Admin Lebel Fields */
    Redux::set_section( $opt_name, array(
        'title'             => esc_html__( 'Admin Label', 'luxrio' ),
        'id'                => 'luxrio_admin_label',
        'customizer_width'  => '450px',
        'subsection'        => true,
        'fields'            => array(
            array(
                'title'     => esc_html__( 'Admin Login Logo', 'luxrio' ),
                'subtitle'  => esc_html__( 'It belongs to the back-end of your website to log-in to admin panel.', 'luxrio' ),
                'id'        => 'luxrio_admin_login_logo',
                'type'      => 'media',
            ),
            array(
                'title'     => esc_html__( 'Custom CSS For admin', 'luxrio' ),
                'subtitle'  => esc_html__( 'Any CSS your write here will run in admin.', 'luxrio' ),
                'id'        => 'luxrio_theme_admin_custom_css',
                'type'      => 'ace_editor',
                'mode'      => 'css',
                'theme'     => 'chrome',
                'full_width'=> true,
            ),
        ),
    ) );

    Redux::set_section( $opt_name, array(
        'icon'             => 'el  el-foursquare',
        'title'            => esc_html__( 'Logo', 'luxrio' ),
        'id'               => 'logo_settings',
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'logo',
                'type'     => 'media',
                'title'    => esc_html__( 'Logo', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose the site Dark logo', 'luxrio' ),
                'default'  => array(
                    'url' => LUXRIO_DIR_URI . 'assets/img/logo.svg',
                ),
            ),
            array(
                'id'       => 'white_logo',
                'type'     => 'media',
                'title'    => esc_html__( 'White Logo', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose the site White logo', 'luxrio' ),
                'default'  => array(
                    'url' => LUXRIO_DIR_URI . 'assets/img/logo-white.svg',
                ),
            ),
    
        ),
    ) );

    // -> START Basic Fields
    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Header', 'luxrio' ),
        'id'               => 'luxrio_header',
        'customizer_width' => '400px',
        'icon'             => 'el el-credit-card',
        'fields'           => array(
            array(
                'id'       => 'luxrio_header_options',
                'type'     => 'button_set',
                'default'  => '1',
                'options'  => array(
                    "1"   => esc_html__('Prebuilt','luxrio'),
                    "2"      => esc_html__('Header Builder','luxrio'),
                ),
                'title'    => esc_html__( 'Header Options', 'luxrio' ),
                'subtitle' => esc_html__( 'Select header options.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_header_select_options',
                'type'     => 'select',
                'data'     => 'posts',
                'args'     => array(
                    'post_type'     => 'luxrio_header'
                ),
                'title'    => esc_html__( 'Header', 'luxrio' ),
                'subtitle' => esc_html__( 'Select header.', 'luxrio' ),
                'required' => array( 'luxrio_header_options', 'equals', '2' )
            ),

        ),
    ) );

    // -> START Header Menu
    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Header Menu', 'luxrio' ),
        'id'               => 'luxrio_header_menu_option',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'luxrio_header_menu_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Menu Color', 'luxrio' ),
                'output'   => array( 'color'    =>  '.menu-style1 > ul > li > a' ),
            ),
            array(
                'id'       => 'luxrio_header_menu_hover_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Menu Hover Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Menu Hover Color', 'luxrio' ),
                'output'   => array( 'color'    =>  '.menu-style1 > ul > li > a:hover' ),
            ),
            array(
                'id'       => 'luxrio_header_submenu_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Submenu Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Submenu Color', 'luxrio' ),
                'output'   => array( 'color'    =>  '.main-menu ul li ul.sub-menu li a' ),
            ),
            array(
                'id'       => 'luxrio_header_submenu_hover_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Submenu Hover Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Submenu Hover Color', 'luxrio' ),
                'output'   => array( 'color'    =>  '.main-menu ul li ul.sub-menu li a:hover' ),
            ),
            array(
                'id'       => 'luxrio_header_submenu_icon_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Submenu Icon Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Submenu Icon Color', 'luxrio' ),
                'output'   => array( 'color'    =>  '.main-menu ul li ul.sub-menu li a:after' ),
            ),
            array(
                'id'       => 'luxrio_header_submenu_border_top_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Submenu Border Top Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Submenu Border Top Color', 'luxrio' ),
                'output'   => array( 'border-top-color'    =>  '.main-menu ul.sub-menu' ),
            ),
            array(
                'id'       => 'luxrio_header_searchbar_switcher',
                'type'     => 'switch',
                'default'  => '0',
                'on'       => esc_html__( 'Show', 'luxrio' ),
                'off'      => esc_html__( 'Hide', 'luxrio' ),
                'title'    => esc_html__( 'Header Searchbar?', 'luxrio' ),
                'subtitle' => esc_html__( 'Control Header Searchbar By Show Or Hide System.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_searchbar_placeholder_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Placeholder Text', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Placeholder Text', 'luxrio' ),
                'default'  => esc_html__( 'Search Your Product', 'luxrio' ),
                'required' => array( "luxrio_header_searchbar_switcher", "equals", "1" )
            )
        )
    ) );
    // -> End Header Menu

     // -> START Mobile Menu
    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Cart Offcanvas', 'luxrio' ),
        'id'               => 'luxrio_cart_offcanvas_menu',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'luxrio_offcanvas_panel_bg',
                'type'     => 'background',
                'title'    => esc_html__( 'Offcanvas Panel Background', 'luxrio' ),
                'output'   => array('.sidemenu-wrapper .sidemenu-content'),
                'subtitle' => esc_html__( 'Set Offcanvas Panel Background Color', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_offcanvas_title_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Offcanvas Title Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Offcanvas Title color.', 'luxrio' ),
                'output'   => array( '.sidemenu-content h3.widget_title' )
            ),
            array(
                'id'       => 'luxrio_offcanvas_product_title_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Product Title Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Product Title color.', 'luxrio' ),
                'output'   => array( '.widget_shopping_cart .cart_list li.mini_cart_item a' )
            ),
        )
    ) );
    // -> End Mobile Menu

    // -> START Blog Page
    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Blog', 'luxrio' ),
        'id'         => 'luxrio_blog_page',
        'icon'  => 'el el-blogger',
        'fields'     => array(

            array(
                'id'       => 'luxrio_blog_sidebar',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Layout', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose blog layout from here. If you use this option then you will able to change three type of blog layout ( Default Left Sidebar Layour ). ', 'luxrio' ),
                'options'  => array(
                    '1' => array(
                        'alt' => esc_attr__('1 Column','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/no-sideber.png')
                    ),
                    '2' => array(
                        'alt' => esc_attr__('2 Column Left','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/left-sideber.png')
                    ),
                    '3' => array(
                        'alt' => esc_attr__('2 Column Right','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/right-sideber.png' )
                    ),

                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'luxrio_blog_grid',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Post Column', 'luxrio' ),
                'subtitle' => esc_html__( 'Select your blog post column from here. If you use this option then you will able to select three type of blog post layout ( Default Two Column ).', 'luxrio' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '1' => array(
                        'alt' => esc_attr__('1 Column','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/1column.png')
                    ),
                    '2' => array(
                        'alt' => esc_attr__('2 Column Left','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/2column.png')
                    ),
                    '3' => array(
                        'alt' => esc_attr__('2 Column Right','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/3column.png' )
                    ),

                ),
                'default'  => '1'
            ),

            array(
                'id'      => 'luxrio_blog_style',
                'type'     => 'select',
                'options'  => array(
                    'blog_style_one' => esc_html__('Blog Style One','luxrio'),
                    'blog_style_two' => esc_html__('Blog Style Two','luxrio'),
                ),
                'default'  => 'blog_style_one',
                'title'   => esc_html__('Blog Style', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_blog_page_title_switcher',
                'type'     => 'switch',
                'default'  => 1,
                'on'       => esc_html__('Show','luxrio'),
                'off'      => esc_html__('Hide','luxrio'),
                'title'    => esc_html__('Blog Page Title', 'luxrio'),
                'subtitle' => esc_html__('Control blog page title show / hide. If you use this option then you will able to show / hide your blog page title ( Default Setting Show ).', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_blog_page_title_setting',
                'type'     => 'button_set',
                'title'    => esc_html__('Blog Page Title Setting', 'luxrio'),
                'subtitle' => esc_html__('Control blog page title setting. If you use this option then you can able to show default or custom blog page title ( Default Blog ).', 'luxrio'),
                'options'  => array(
                    "predefine"   => esc_html__('Default','luxrio'),
                    "custom"      => esc_html__('Custom','luxrio'),
                ),
                'default'  => 'predefine',
                'required' => array("luxrio_blog_page_title_switcher","equals","1")
            ),
            array(
                'id'       => 'luxrio_blog_page_custom_title',
                'type'     => 'text',
                'title'    => esc_html__('Blog Custom Title', 'luxrio'),
                'subtitle' => esc_html__('Set blog page custom title form here. If you use this option then you will able to set your won title text.', 'luxrio'),
                'required' => array('luxrio_blog_page_title_setting','equals','custom')
            ),
            array(
                'id'            => 'luxrio_blog_postExcerpt',
                'type'          => 'slider',
                'title'         => esc_html__('Blog Posts Excerpt', 'luxrio'),
                'subtitle'      => esc_html__('Control the number of characters you want to show in the blog page for each post.. If you use this option then you can able to control your blog post characters from here ( Default show 10 ).', 'luxrio'),
                "default"       => 46,
                "min"           => 0,
                "step"          => 1,
                "max"           => 100,
                'resolution'    => 1,
                'display_value' => 'text',
            ),
            array(
                'id'       => 'luxrio_blog_readmore_setting',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Read More Text Setting', 'luxrio' ),
                'subtitle' => esc_html__( 'Control read more text from here.', 'luxrio' ),
                'options'  => array(
                    "default"   => esc_html__('Default','luxrio'),
                    "custom"    => esc_html__('Custom','luxrio'),
                ),
                'default'  => 'default',
            ),
            array(
                'id'       => 'luxrio_blog_custom_readmore',
                'type'     => 'text',
                'title'    => esc_html__('Read More Text', 'luxrio'),
                'subtitle' => esc_html__('Set read moer text here. If you use this option then you will able to set your won text.', 'luxrio'),
                'required' => array('luxrio_blog_readmore_setting','equals','custom')
            ),

            array(
                'title'     => esc_html__( 'Separator Image', 'luxrio' ),
                'subtitle'  => esc_html__( 'Blog Separator Image', 'luxrio' ),
                'id'        => 'luxrio_blog_separaotr_img',
                'type'      => 'media',
            ),

            array(
                'id'       => 'luxrio_blog_title_color',
                'output'   => array( '.vs-blog .blog-title a'),
                'type'     => 'color',
                'title'    => esc_html__( 'Blog Title Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Blog Title Color.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_blog_title_hover_color',
                'output'   => array( '.vs-blog .blog-title a:hover'),
                'type'     => 'color',
                'title'    => esc_html__( 'Blog Title Hover Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Blog Title Hover Color.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_blog_contant_color',
                'output'   => array( '.blog-content p'),
                'type'     => 'color',
                'title'    => esc_html__( 'Blog Excerpt / Content Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Blog Excerpt / Content Color.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_blog_read_more_button_color',
                'output'   => array( '.blog-content .link-btn'),
                'type'     => 'color',
                'title'    => esc_html__( 'Read More Button Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Read More Button Color.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_blog_read_more_button_hover_color',
                'output'   => array( '.blog-content .link-btn:hover'),
                'type'     => 'color',
                'title'    => esc_html__( 'Read More Button Hover Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Read More Button Hover Color.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_blog_pagination_color',
                'output'   => array( '.pagination li a,.pagination a i'),
                'type'     => 'color',
                'title'    => esc_html__('Blog Pagination Color', 'luxrio'),
                'subtitle' => esc_html__('Set Blog Pagination Color.', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_blog_pagination_active_color',
                'output'   => array( '.pagination li span.current'),
                'type'     => 'color',
                'title'    => esc_html__('Blog Pagination Active Color', 'luxrio'),
                'subtitle' => esc_html__('Set Blog Pagination Active Color.', 'luxrio'),
                'required'  => array('luxrio_blog_pagination', '=', '1')
            ),
            array(
                'id'       => 'luxrio_blog_pagination_hover_color',
                'output'   => array( '.pagination li a:hover,.pagination a i:hover'),
                'type'     => 'color',
                'title'    => esc_html__('Blog Pagination Hover Color', 'luxrio'),
                'subtitle' => esc_html__('Set Blog Pagination Hover Color.', 'luxrio'),
            ),
        ),
    ) );

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Single Blog Page', 'luxrio' ),
        'id'         => 'luxrio_post_detail_styles',
        'subsection' => true,
        'fields'     => array(

            array(
                'id'       => 'luxrio_blog_single_sidebar',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Layout', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose blog single page layout from here. If you use this option then you will able to change three type of blog single page layout ( Default Left Sidebar Layour ). ', 'luxrio' ),
                'options'  => array(
                    '1' => array(
                        'alt' => esc_attr__('1 Column','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/no-sideber.png')
                    ),
                    '2' => array(
                        'alt' => esc_attr__('2 Column Left','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/left-sideber.png')
                    ),
                    '3' => array(
                        'alt' => esc_attr__('2 Column Right','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/right-sideber.png' )
                    ),

                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'luxrio_post_details_title_position',
                'type'     => 'button_set',
                'default'  => 'header',
                'options'  => array(
                    'header'        => esc_html__('On Header','luxrio'),
                    'below'         => esc_html__('Below Thumbnail','luxrio'),
                ),
                'title'    => esc_html__('Blog Post Title Position', 'luxrio'),
                'subtitle' => esc_html__('Control blog post title position from here.', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_post_details_custom_title',
                'type'     => 'text',
                'title'    => esc_html__('Blog Details Custom Title', 'luxrio'),
                'subtitle' => esc_html__('This title will show in Breadcrumb title.', 'luxrio'),
                'required' => array('luxrio_post_details_title_position','equals','below')
            ),
            array(
                'id'       => 'luxrio_display_post_tags',
                'type'     => 'switch',
                'title'    => esc_html__( 'Tags', 'luxrio' ),
                'subtitle' => esc_html__( 'Switch On to Display Tags.', 'luxrio' ),
                'default'  => true,
                'on'        => esc_html__('Enabled','luxrio'),
                'off'       => esc_html__('Disabled','luxrio'),
            ),
            array(
                'id'       => 'luxrio_post_details_share_options',
                'type'     => 'switch',
                'title'    => esc_html__('Share Options', 'luxrio'),
                'subtitle' => esc_html__('Control post share options from here. If you use this option then you will able to show or hide post share options.', 'luxrio'),
                'on'        => esc_html__('Show','luxrio'),
                'off'       => esc_html__('Hide','luxrio'),
                'default'   => '0',
            ),
            array(
                'id'       => 'luxrio_post_details_author_desc_trigger',
                'type'     => 'switch',
                'title'    => esc_html__('Biography Info', 'luxrio'),
                'subtitle' => esc_html__('Control biography info from here. If you use this option then you will able to show or hide biography info ( Default setting Show ).', 'luxrio'),
                'on'        => esc_html__('Show','luxrio'),
                'off'       => esc_html__('Hide','luxrio'),
                'default'   => '0',
            ),
            array(
                'id'       => 'luxrio_post_details_post_navigation',
                'type'     => 'switch',
                'title'    => esc_html__('Post Navigation', 'luxrio'),
                'subtitle' => esc_html__('Control post navigation from here. If you use this option then you will able to show or hide post navigation ( Default setting Show ).', 'luxrio'),
                'on'        => esc_html__('Show','luxrio'),
                'off'       => esc_html__('Hide','luxrio'),
                'default'   => false,
            ),
            array(
                'id'       => 'luxrio_post_details_related_post',
                'type'     => 'switch',
                'title'    => esc_html__('Related Post', 'luxrio'),
                'subtitle' => esc_html__('Control related post from here. If you use this option then you will able to show or hide related post ( Default setting Show ).', 'luxrio'),
                'on'        => esc_html__('Show','luxrio'),
                'off'       => esc_html__('Hide','luxrio'),
                'default'   => false,
            ),
        )
    ));

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Meta Data', 'luxrio' ),
        'id'         => 'luxrio_common_meta_data',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'luxrio_blog_meta_icon_color',
                'output'   => array( '.blog-meta span i'),
                'type'     => 'color',
                'title'    => esc_html__('Blog Meta Icon Color', 'luxrio'),
                'subtitle' => esc_html__('Set Blog Meta Icon Color.', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_blog_meta_text_color',
                'output'   => array( '.blog-meta a,.blog-meta span'),
                'type'     => 'color',
                'title'    => esc_html__( 'Blog Meta Text Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Blog Meta Text Color.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_blog_meta_text_hover_color',
                'output'   => array( '.blog-meta a:hover'),
                'type'     => 'color',
                'title'    => esc_html__( 'Blog Meta Hover Text Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Blog Meta Hover Text Color.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_display_post_date',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Date', 'luxrio' ),
                'subtitle' => esc_html__( 'Switch On to Display Post Date.', 'luxrio' ),
                'default'  => true,
                'on'        => esc_html__('Enabled','luxrio'),
                'off'       => esc_html__('Disabled','luxrio'),
            ),
            array(
                'id'       => 'luxrio_display_post_author',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Auhtor', 'luxrio' ),
                'subtitle' => esc_html__( 'Switch On to Display Post Author.', 'luxrio' ),
                'default'  => false,
                'on'        => esc_html__( 'Enabled', 'luxrio'),
                'off'       => esc_html__( 'Disabled', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_display_post_comment',
                'type'     => 'switch',
                'title'    => esc_html__( 'Comment Count', 'luxrio' ),
                'subtitle' => esc_html__( 'Switch On to Display Comment Count.', 'luxrio' ),
                'default'  => true,
                'on'        => esc_html__('Enabled','luxrio'),
                'off'       => esc_html__('Disabled','luxrio'),
            ),
            array(
                'id'       => 'luxrio_display_post_category',
                'type'     => 'switch',
                'title'    => esc_html__( 'Category', 'luxrio' ),
                'subtitle' => esc_html__( 'Switch On to Display Category.', 'luxrio' ),
                'default'  => true,
                'on'        => esc_html__('Enabled','luxrio'),
                'off'       => esc_html__('Disabled','luxrio'),
            ),
        )
    ));

    /* Sidebar Start */
    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Sidebar Options', 'luxrio' ),
        'id'         => 'luxrio_sidebar_options',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'      => 'luxrio_sidebar_bg_color',
                'type'    => 'color',
                'title'   => esc_html__('Widgets Background Color', 'luxrio'),
                'output'  => array('background-color'   => '.blog-sidebar')
            ),
            array(
                'id'      => 'luxrio_sidebar_padding_margin_box_shadow_trigger',
                'type'    => 'switch',
                'title'   => esc_html__('Widgets Custom Box Shadow/Padding/Margin/border', 'luxrio'),
                'on'      => esc_html__('Show','luxrio'),
                'off'     => esc_html__('Hide','luxrio'),
                'default' => false
            ),
            array(
                'id'      => 'box-shadow',
                'type'    => 'box_shadow',
                'title'   => esc_html__('Box Shadow', 'luxrio'),
                'units'   => array( 'px', 'em', 'rem' ),
                'output'  => ( '.blog-sidebar .widget' ),
                'opacity' => true,
                'rgba'    => true,
                'required'=> array( 'luxrio_sidebar_padding_margin_box_shadow_trigger', 'equals' , '1' )
            ),
            array(
                'id'      => 'luxrio_sidebar_widget_margin',
                'type'    => 'spacing',
                'title'   => esc_html__('Widget Margin', 'luxrio'),
                'units'   => array('em', 'px'),
                'output'  => ( '.blog-sidebar .widget' ),
                'mode'    => 'margin',
                'required'=> array( 'luxrio_sidebar_padding_margin_box_shadow_trigger', 'equals' , '1' )
            ),
            array(
                'id'      => 'luxrio_sidebar_widget_padding',
                'type'    => 'spacing',
                'title'   => esc_html__('Widget Padding', 'luxrio'),
                'units'   => array('em', 'px'),
                'output'  => ( '.blog-sidebar .widget' ),
                'mode'    => 'padding',
                'required'=> array( 'luxrio_sidebar_padding_margin_box_shadow_trigger', 'equals' , '1' )
            ),
            array(
                'id'      => 'luxrio_sidebar_widget_border',
                'type'    => 'border',
                'title'   => esc_html__('Widget Border', 'luxrio'),
                'units'   => array('em', 'px'),
                'output'  => ( '.blog-sidebar .widget' ),
                'all'     => false,
                'required'=> array( 'luxrio_sidebar_padding_margin_box_shadow_trigger', 'equals' , '1' )
            ),
            array(
                'id'      => 'luxrio_sidebar_widget_title_heading_tag',
                'type'     => 'select',
                'options'  => array(
                    'h1'        => esc_html__('H1','luxrio'),
                    'h2'        => esc_html__('H2','luxrio'),
                    'h3'        => esc_html__('H3','luxrio'),
                    'h4'        => esc_html__('H4','luxrio'),
                    'h5'        => esc_html__('H5','luxrio'),
                    'h6'        => esc_html__('H6','luxrio'),
                ),
                'default'  => 'h3',
                'title'   => esc_html__('Widget Title Tag', 'luxrio'),
            ),
            array(
                'id'      => 'luxrio_sidebar_widget_title_margin',
                'type'    => 'spacing',
                'title'   => esc_html__('Widget Title Margin', 'luxrio'),
                'mode'    => 'margin',
                'output'  => array('.blog-sidebar .widget .widget_title'),
                'units'   => array('em', 'px'),
            ),
            array(
                'id'      => 'luxrio_sidebar_widget_title_padding',
                'type'    => 'spacing',
                'title'   => esc_html__('Widget Title Padding', 'luxrio'),
                'mode'    => 'padding',
                'output'  => array('.blog-sidebar .widget .widget_title'),
                'units'   => array('em', 'px'),
            ),
            array(
                'id'       => 'luxrio_sidebar_widget_title_color',
                'output'   =>  array('.blog-sidebar .widget .widget_title h1,.blog-sidebar .widget .widget_title h2,.blog-sidebar .widget .widget_title h3,.blog-sidebar .widget .widget_title h4,.blog-sidebar .widget .widget_title h5,.blog-sidebar .widget .widget_title h6'),
                'type'     => 'color',
                'title'    => esc_html__('Widget Title Color', 'luxrio'),
                'subtitle' => esc_html__('Set Widget Title Color.', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_sidebar_widget_text_color',
                'output'   => array('.blog-sidebar .widget'),
                'type'     => 'color',
                'title'    => esc_html__('Widget Text Color', 'luxrio'),
                'subtitle' => esc_html__('Set Widget Text Color.', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_sidebar_widget_anchor_color',
                'type'     => 'color',
                'output'   => array('.blog-sidebar .widget a'),
                'title'    => esc_html__('Widget Anchor Color', 'luxrio'),
                'subtitle' => esc_html__('Set Widget Anchor Color.', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_sidebar_widget_anchor_hover_color',
                'type'     => 'color',
                'output'   => array('.blog-sidebar .widget a:hover'),
                'title'    => esc_html__('Widget Hover Color', 'luxrio'),
                'subtitle' => esc_html__('Set Widget Anchor Hover Color.', 'luxrio'),
            )
        )
    ));
    /* Sidebar End */

    /* End blog Page */

    // -> START Page Option
    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Page', 'luxrio' ),
        'id'         => 'luxrio_page_page',
        'icon'  => 'el el-file',
        'fields'     => array(
            array(
                'id'       => 'luxrio_page_sidebar',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Select layout', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose your page layout. If you use this option then you will able to choose three type of page layout ( Default no sidebar ). ', 'luxrio' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '1' => array(
                        'alt' => esc_attr__('1 Column','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/no-sideber.png')
                    ),
                    '2' => array(
                        'alt' => esc_attr__('2 Column Left','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/left-sideber.png')
                    ),
                    '3' => array(
                        'alt' => esc_attr__('2 Column Right','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/right-sideber.png' )
                    ),

                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'luxrio_page_layoutopt',
                'type'     => 'button_set',
                'title'    => esc_html__('Sidebar Settings', 'luxrio'),
                'subtitle' => esc_html__('Set page sidebar. If you use this option then you will able to set three type of sidebar ( Default no sidebar ).', 'luxrio'),
                //Must provide key => value pairs for options
                'options' => array(
                    '1' => esc_html__( 'Page Sidebar', 'luxrio' ),
                    '2' => esc_html__( 'Blog Sidebar', 'luxrio' )
                 ),
                'default' => '1',
                'required'  => array('luxrio_page_sidebar','!=','1')
            ),
            array(
                'id'       => 'luxrio_page_title_switcher',
                'type'     => 'switch',
                'title'    => esc_html__('Title', 'luxrio'),
                'subtitle' => esc_html__('Switch enabled to display page title. Fot this option you will able to show / hide page title.  Default setting Enabled', 'luxrio'),
                'default'  => '1',
                'on'        => esc_html__('Enabled','luxrio'),
                'off'       => esc_html__('Disabled','luxrio'),
            ),
            array(
                'id'       => 'luxrio_page_title_tag',
                'type'     => 'select',
                'options'  => array(
                    'h1'        => esc_html__('H1','luxrio'),
                    'h2'        => esc_html__('H2','luxrio'),
                    'h3'        => esc_html__('H3','luxrio'),
                    'h4'        => esc_html__('H4','luxrio'),
                    'h5'        => esc_html__('H5','luxrio'),
                    'h6'        => esc_html__('H6','luxrio'),
                ),
                'default'  => 'h1',
                'title'    => esc_html__( 'Title Tag', 'luxrio' ),
                'subtitle' => esc_html__( 'Select page title tag. If you use this option then you can able to change title tag H1 - H6 ( Default tag H1 )', 'luxrio' ),
                'required' => array("luxrio_page_title_switcher","equals","1")
            ),
            array( 
                'id'       => 'luxrio_allHeader_title_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Title Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Title Color', 'luxrio' ),
                'output'   => array( 'color' => '.breadcumb-title' ),
            ),
            array(
                'id'       => 'luxrio_allHeader_bg',
                'type'     => 'background',
                'title'    => esc_html__( 'Background', 'luxrio' ),
                'output'   => array('.breadcumb-wrapper'),
                'subtitle' => esc_html__( 'Setting page header background. If you use this option then you will able to set Background Color, Background Image, Background Repeat, Background Size, Background Attachment, Background Position.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_enable_breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__( 'Breadcrumb Hide/Show', 'luxrio' ),
                'subtitle' => esc_html__( 'Hide / Show breadcrumb from all pages and posts ( Default settings hide ).', 'luxrio' ),
                'default'  => '1',
                'on'       => 'Show',
                'off'      => 'Hide',
            ),
            array(
                'id'       => 'luxrio_allHeader_breadcrumbtextcolor',
                'type'     => 'color',
                'title'    => esc_html__( 'Breadcrumb Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose page header breadcrumb text color here.If you user this option then you will able to set page breadcrumb color.', 'luxrio' ),
                'required' => array("luxrio_page_title_switcher","equals","1"),
                'output'   => array( 'color' => '.breadcumb-layout1 .breadcumb-content ul li a' ),
            ),
            array(
                'id'       => 'luxrio_allHeader_breadcrumbtextactivecolor',
                'type'     => 'color',
                'title'    => esc_html__( 'Breadcrumb Active Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose page header breadcrumb text active color here.If you user this option then you will able to set page breadcrumb active color.', 'luxrio' ),
                'required' => array( "luxrio_page_title_switcher", "equals", "1" ),
                'output'   => array( 'color' => '.breadcumb-layout1 .breadcumb-content ul li.active' ),
            ),
            array(
                'id'       => 'luxrio_allHeader_dividercolor',
                'type'     => 'color',
                'output'   => array( 'color'=>'.breadcumb-layout1 .breadcumb-content ul li:after' ),
                'title'    => esc_html__( 'Breadcrumb Divider Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose breadcrumb divider color.', 'luxrio' ),
            ),
        ),
    ) );
    /* End Page option */

    // -> START 404 Page

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( '404 Page', 'luxrio' ),
        'id'         => 'luxrio_404_page',
        'icon'       => 'el el-ban-circle',
        'fields'     => array(

            array(
                'id'       => 'luxrio_fof_error_number',
                'type'     => 'text',
                'title'    => esc_html__( 'Page Error Number', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Page Error Number', 'luxrio' ),
                'default'  => esc_html__( '404', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_fof_title',
                'type'     => 'text',
                'title'    => esc_html__( 'Page Title', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Page Title', 'luxrio' ),
                'default'  => esc_html__( 'Oops! That page can\'t be found.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_fof_subtitle',
                'type'     => 'text',
                'title'    => esc_html__( 'Page Subtitle', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Page Subtitle ', 'luxrio' ),
                'default'  => esc_html__( 'Lorem ipsum dolor sit amet, conse elit, sedid that eiusmod aboret dolore magna aliqua conseel usndi.', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_fof_btn_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Button Text', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Button Text ', 'luxrio' ),
                'default'  => esc_html__( 'Return To Home', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_fof_text_color',
                'type'     => 'color',
                'output'   => array( '.error-content .sec-title' ),
                'title'    => esc_html__( 'Title Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Pick a title color', 'luxrio' ),
                'validate' => 'color'
            ),
            array(
                'id'       => 'luxrio_fof_subtitle_color',
                'type'     => 'color',
                'output'   => array( '.error-content .sec-title2' ),
                'title'    => esc_html__( 'Subtitle Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Pick a subtitle color', 'luxrio' ),
                'validate' => 'color'
            ),
            array(
                'id'       => 'luxrio_fof_btn_color',
                'type'     => 'color',
                'output'   => array( '.vs-btn' ),
                'title'    => esc_html__('Button Color', 'luxrio'),
                'subtitle' => esc_html__('Pick Button Color', 'luxrio'),
                'validate' => 'color'
            ),
            array(
                'id'       => 'luxrio_fof_btn_color_hover',
                'type'     => 'color',
                'output'   => array( '.vs-btn:hover' ),
                'title'    => esc_html__( 'Button Color', 'luxrio'),
                'subtitle' => esc_html__( 'Pick Button Color', 'luxrio'),
                'validate' => 'color'
            ),
            array(
                'id'       => 'luxrio_fof_btn_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Button Background Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Pick Button Background Color', 'luxrio' ),
                'output'   => array( 'background-color' => '.vs-btn' ),
                'validate' => 'color'
            ),
            array(
                'id'       => 'luxrio_fof_btn_hover_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Button Hover Background Color', 'luxrio' ),
                'subtitle' => esc_html__( 'Pick Button Hover Background Color', 'luxrio' ),
                'output'   => array( 'background-color' => '.vs-btn:after' ),
                'validate' => 'color'
            ),
        ),
    ) );

    /* End 404 Page */
    // -> START Woo Page Option

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Woocommerce Page', 'luxrio' ),
        'id'         => 'luxrio_woo_page_page',
        'icon'  => 'el el-shopping-cart',
        'fields'     => array(
             array(
                'title'     => esc_html__( 'Shop Page Background', 'luxrio' ),
                'subtitle'  => esc_html__( 'Add Your Shop Page Background Image', 'luxrio' ),
                'id'        => 'luxrio_shop_bg',
                'type'      => 'media',
            ),
             array(
                'title'     => esc_html__( 'Breadcrumb Image', 'luxrio' ),
                'subtitle'  => esc_html__( 'Add Your Shop Page Breadcrumb Image', 'luxrio' ),
                'id'        => 'luxrio_shop_breadcrumb_bg',
                'type'      => 'media',
            ),

            array(
                'id'       => 'luxrio_woo_shoppage_sidebar',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Set Shop Page Sidebar.', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose shop page sidebar', 'luxrio' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '1' => array(
                        'alt' => esc_attr__('1 Column','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/no-sideber.png')
                    ),
                    '2' => array(
                        'alt' => esc_attr__('2 Column Left','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/left-sideber.png')
                    ),
                    '3' => array(
                        'alt' => esc_attr__('2 Column Right','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/right-sideber.png' )
                    ),

                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'luxrio_woo_product_col',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Product Column', 'luxrio' ),
                'subtitle' => esc_html__( 'Set your woocommerce product column.', 'luxrio' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '2' => array(
                        'alt' => esc_attr__('2 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/2col.png')
                    ),
                    '3' => array(
                        'alt' => esc_attr__('3 Columns','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/3col.png' )
                    ),
                    '4' => array(
                        'alt' => esc_attr__('4 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/4col.png')
                    ),
                    '5' => array(
                        'alt' => esc_attr__('5 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/5col.png')
                    ),
                    '6' => array(
                        'alt' => esc_attr__('6 Columns','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/6col.png' )
                    ),
                    '5' => array(
                        'alt' => esc_attr__('5 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/5col.png')
                    ),
                    '6' => array(
                        'alt' => esc_attr__('6 Columns','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/6col.png' )
                    ),),
                'default'  => '4'
            ),
			array(
                'id'       => 'luxrio_woo_product_perpage',
                'type'     => 'text',
                'title'    => esc_html__( 'Product Per Page', 'luxrio' ),
				'default' => '10'
            ),
            array(
                'id'       => 'luxrio_woo_singlepage_sidebar',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Product Single Page sidebar', 'luxrio' ),
                'subtitle' => esc_html__( 'Choose product single page sidebar.', 'luxrio' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '1' => array(
                        'alt' => esc_attr__('1 Column','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/no-sideber.png')
                    ),
                    '2' => array(
                        'alt' => esc_attr__('2 Column Left','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/left-sideber.png')
                    ),
                    '3' => array(
                        'alt' => esc_attr__('2 Column Right','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/right-sideber.png' )
                    ),

                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'luxrio_product_details_title_position',
                'type'     => 'button_set',
                'default'  => 'header',
                'options'  => array(
                    'header'        => esc_html__('On Header','luxrio'),
                    'below'         => esc_html__('Below Thumbnail','luxrio'),
                ),
                'title'    => esc_html__('Product Details Title Position', 'luxrio'),
                'subtitle' => esc_html__('Control product details title position from here.', 'luxrio'),
            ),
            array(
                'id'       => 'luxrio_product_details_custom_title',
                'type'     => 'text',
                'title'    => esc_html__( 'Product Details Title', 'luxrio' ),
                'default'  => esc_html__( 'Shop Details', 'luxrio' ),
                'required' => array('luxrio_product_details_title_position','equals','below'),
            ),
            array(
                'id'       => 'luxrio_woo_stock_quantity_show_hide',
                'type'     => 'switch',
                'title'    => esc_html__( 'Stock Quantity Show Hide', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Stock Quantity Show Hide?', 'luxrio' ),
                'default'  => '1',
                'on'       => esc_html__('Show','luxrio'),
                'off'      => esc_html__('Hide','luxrio')
            ),
            array(
                'id'       => 'luxrio_woo_relproduct_display',
                'type'     => 'switch',
                'title'    => esc_html__( 'Related product Hide/Show', 'luxrio' ),
                'subtitle' => esc_html__( 'Hide / Show related product in single page (Default Settings Show)', 'luxrio' ),
                'default'  => '1',
                'on'       => esc_html__('Show','luxrio'),
                'off'      => esc_html__('Hide','luxrio')
            ),
            array(
                'id'       => 'luxrio_woo_related_subtitle',
                'type'     => 'text',
                'title'    => esc_html__( 'Subtitle Text', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Related Product Subtitle Text', 'luxrio' ),
                'default'  => esc_html__( 'highly recommend','luxrio' ),
                'required' => array('luxrio_woo_relproduct_display','equals',true)
            ),
            array(
                'id'       => 'luxrio_woo_related_title',
                'type'     => 'text',
                'title'    => esc_html__( 'Title Text', 'luxrio' ),
                'subtitle' => esc_html__( 'Set Related Product Title Text', 'luxrio' ),
                'default'  => esc_html__( 'top related products','luxrio' ),
                'required' => array('luxrio_woo_relproduct_display','equals',true)
            ),
            array(
                'title'     => esc_html__( 'Title Shape', 'luxrio' ),
                'subtitle'  => esc_html__( 'Add Title Shape Image', 'luxrio' ),
                'id'        => 'luxrio_related_title_shape_image',
                'type'      => 'media',
                'required' => array('luxrio_woo_relproduct_display','equals',true)
            ),
			array(
                'id'       => 'luxrio_woo_relproduct_num',
                'type'     => 'text',
                'title'    => esc_html__( 'Related products number', 'luxrio' ),
                'subtitle' => esc_html__( 'Set how many related products you want to show in single product page.', 'luxrio' ),
                'default'  => 4,
                'required' => array('luxrio_woo_relproduct_display','equals',true)
            ),

            array(
                'id'       => 'luxrio_woo_related_product_col',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Related Product Column', 'luxrio' ),
                'subtitle' => esc_html__( 'Set your woocommerce related product column.', 'luxrio' ),
                'required' => array('luxrio_woo_relproduct_display','equals',true),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '2' => array(
                        'alt' => esc_attr__('2 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/2col.png')
                    ),
                    '3' => array(
                        'alt' => esc_attr__('3 Columns','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/3col.png' )
                    ),
                    '4' => array(
                        'alt' => esc_attr__('4 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/4col.png')
                    ),
                    '6' => array(
                        'alt' => esc_attr__('6 Columns','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/6col.png' )
                    ),

                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'luxrio_woo_upsellproduct_display',
                'type'     => 'switch',
                'title'    => esc_html__( 'Upsell product Hide/Show', 'luxrio' ),
                'subtitle' => esc_html__( 'Hide / Show upsell product in single page (Default Settings Show)', 'luxrio' ),
                'default'  => '1',
                'on'       => esc_html__('Show','luxrio'),
                'off'      => esc_html__('Hide','luxrio'),
            ),
            array(
                'id'       => 'luxrio_woo_upsellproduct_num',
                'type'     => 'text',
                'title'    => esc_html__( 'Upsells products number', 'luxrio' ),
                'subtitle' => esc_html__( 'Set how many upsells products you want to show in single product page.', 'luxrio' ),
                'default'  => 3,
                'required' => array('luxrio_woo_upsellproduct_display','equals',true),
            ),

            array(
                'id'       => 'luxrio_woo_upsell_product_col',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Upsells Product Column', 'luxrio' ),
                'subtitle' => esc_html__( 'Set your woocommerce upsell product column.', 'luxrio' ),
                'required' => array('luxrio_woo_upsellproduct_display','equals',true),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '6' => array(
                        'alt' => esc_attr__('2 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/2col.png')
                    ),
                    '4' => array(
                        'alt' => esc_attr__('3 Columns','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/3col.png' )
                    ),
                    '3' => array(
                        'alt' => esc_attr__('4 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/4col.png')
                    ),
                    '2' => array(
                        'alt' => esc_attr__('6 Columns','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/6col.png' )
                    ),

                ),
                'default'  => '4'
            ),
            array(
                'id'       => 'luxrio_woo_crosssellproduct_display',
                'type'     => 'switch',
                'title'    => esc_html__( 'Cross sell product Hide/Show', 'luxrio' ),
                'subtitle' => esc_html__( 'Hide / Show cross sell product in single page (Default Settings Show)', 'luxrio' ),
                'default'  => '1',
                'on'       => esc_html__( 'Show', 'luxrio' ),
                'off'      => esc_html__( 'Hide', 'luxrio' ),
            ),
            array(
                'id'       => 'luxrio_woo_crosssellproduct_num',
                'type'     => 'text',
                'title'    => esc_html__( 'Cross sell products number', 'luxrio' ),
                'subtitle' => esc_html__( 'Set how many cross sell products you want to show in single product page.', 'luxrio' ),
                'default'  => 3,
                'required' => array('luxrio_woo_crosssellproduct_display','equals',true),
            ),

            array(
                'id'       => 'luxrio_woo_crosssell_product_col',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Cross sell Product Column', 'luxrio' ),
                'subtitle' => esc_html__( 'Set your woocommerce cross sell product column.', 'luxrio' ),
                'required' => array( 'luxrio_woo_crosssellproduct_display', 'equals', true ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '6' => array(
                        'alt' => esc_attr__('2 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri() .'/assets/img/2col.png')
                    ),
                    '4' => array(
                        'alt' => esc_attr__('3 Columns','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/3col.png' )
                    ),
                    '3' => array(
                        'alt' => esc_attr__('4 Columns','luxrio'),
                        'img' => esc_url( get_template_directory_uri(). '/assets/img/4col.png')
                    ),
                    '2' => array(
                        'alt' => esc_attr__('6 Columns','luxrio'),
                        'img' => esc_url(  get_template_directory_uri() .'/assets/img/6col.png' )
                    ),

                ),
                'default'  => '4'
            ),
        ),
    ) );

    /* End Woo Page option */

    // -> START Social Media

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Social', 'luxrio' ),
        'id'         => 'luxrio_social_media',
        'icon'      => 'el el-globe',
        'desc'      => esc_html__( 'Social', 'luxrio' ),
        'fields'     => array(
            array(
                'id'          => 'luxrio_social_links',
                'type'        => 'slides',
                'title'       => esc_html__('Social Profile Links', 'luxrio'),
                'subtitle'    => esc_html__('Add social icon and url.', 'luxrio'),
                'show'        => array(
                    'title'          => true,
                    'description'    => true,
                    'progress'       => false,
                    'facts-number'   => false,
                    'facts-title1'   => false,
                    'facts-title2'   => false,
                    'facts-number-2' => false,
                    'facts-title3'   => false,
                    'facts-number-3' => false,
                    'url'            => true,
                    'project-button' => false,
                    'image_upload'   => false,
                ),
                'placeholder'   => array(
                    'icon'          => esc_html__( 'Icon (example: fab fa-facebook) ','luxrio'),
                    'title'         => esc_html__( 'Social Icon Class', 'luxrio' ),
                    'description'   => esc_html__( 'Social Icon Title', 'luxrio' ),
                ),
            ),
        ),
    ) );

    // -> START Footer Gallery Widget
    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Gallery Widget', 'luxrio' ),
        'id'         => 'luxrio_gallery_media',
        'icon'      => 'el el-camera',
        'desc'      => esc_html__( 'Gallery Image', 'luxrio' ),
        'fields'     => array(
            array(
                'id'          => 'luxrio_gallery_image_widget',
                'type'        => 'slides',
                'title'       => esc_html__('Gallery Images', 'luxrio'),
                'show'        => array(
                    'title'          => false,
                    'description'    => false,
                    'progress'       => false,
                    'facts-number'   => false,
                    'facts-title1'   => false,  
                    'facts-title2'   => false,
                    'facts-number-2' => false,
                    'facts-title3'   => false,
                    'facts-number-3' => false,
                    'url'            => false,
                    'project-button' => false,
                    'image_upload'   => true,
                ),
            ),
        ),
    ) );


    // -> START Footer Media
    Redux::set_section( $opt_name , array(
       'title'            => esc_html__( 'Footer', 'luxrio' ),
       'id'               => 'luxrio_footer',
       'desc'             => esc_html__( 'luxrio Footer', 'luxrio' ),
       'customizer_width' => '400px',
       'icon'              => 'el el-photo',
   ) );

   Redux::set_section( $opt_name, array(
       'title'      => esc_html__( 'Pre-built Footer / Footer Builder', 'luxrio' ),
       'id'         => 'luxrio_footer_section',
       'subsection' => true,
       'fields'     => array(
            array(
               'id'       => 'luxrio_footer_builder_trigger',
               'type'     => 'button_set',
               'default'  => 'prebuilt',
               'options'  => array(
                   'footer_builder'        => esc_html__('Footer Builder','luxrio'),
                   'prebuilt'              => esc_html__('Pre-built Footer','luxrio'),
               ),
               'title'    => esc_html__( 'Footer Builder', 'luxrio' ),
            ),
            array(
               'id'       => 'luxrio_footer_builder_select',
               'type'     => 'select',
               'required' => array( 'luxrio_footer_builder_trigger','equals','footer_builder'),
               'data'     => 'posts',
               'args'     => array(
                   'post_type'     => 'luxrio_footer'
               ),
               'on'       => esc_html__( 'Enabled', 'luxrio' ),
               'off'      => esc_html__( 'Disable', 'luxrio' ),
               'title'    => esc_html__( 'Select Footer', 'luxrio' ),
               'subtitle' => esc_html__( 'First make your footer from footer custom types then select it from here.', 'luxrio' ),
            ),
           array(
               'id'       => 'luxrio_disable_footer_bottom',
               'type'     => 'switch',
               'title'    => esc_html__( 'Footer Bottom?', 'luxrio' ),
               'default'  => 1,
               'on'       => esc_html__('Enabled','luxrio'),
               'off'      => esc_html__('Disable','luxrio'),
               'required' => array('luxrio_footer_builder_trigger','equals','prebuilt'),
            ),
            array(
               'id'       => 'luxrio_footer_bottom_background',
               'type'     => 'color',
               'title'    => esc_html__( 'Footer Bottom Background Color', 'luxrio' ),
               'required' => array( 'luxrio_disable_footer_bottom','=','1' ),
               'output'   => array( 'background-color'   =>   '.footer-copyright' ),
            ),
            array(
               'id'       => 'luxrio_copyright_text',
               'type'     => 'text',
               'title'    => esc_html__( 'Copyright Text', 'luxrio' ),
               'subtitle' => esc_html__( 'Add Copyright Text', 'luxrio' ),
               'default'  => sprintf( 'Copyright <i class="far fa-copyright"></i> %s <a  href="%s">%s</a> All Rights Reserved by <a  href="%s">%s</a>',date('Y'),esc_url('#'),__( 'Luxrio.','luxrio' ),esc_url('#'),__( 'Vecuro', 'luxrio' ) ),
               'required' => array( 'luxrio_disable_footer_bottom','equals','1' ),
            ),
            array(
               'id'       => 'luxrio_footer_copyright_color',
               'type'     => 'color',
               'title'    => esc_html__( 'Footer Copyright Text Color', 'luxrio' ),
               'subtitle' => esc_html__( 'Set footer copyright text color', 'luxrio' ),
               'required' => array( 'luxrio_disable_footer_bottom','equals','1'),
               'output'   => array( '.footer-copyright p' ),
            ),
            array(
               'id'       => 'luxrio_footer_copyright_acolor',
               'type'     => 'color',
               'title'    => esc_html__( 'Footer Copyright Ancor Color', 'luxrio' ),
               'subtitle' => esc_html__( 'Set footer copyright ancor color', 'luxrio' ),
               'required' => array( 'luxrio_disable_footer_bottom','equals','1'),
               'output'   => array( '.footer-copyright p a' ),
            ),
            array(
               'id'       => 'luxrio_footer_copyright_a_hover_color',
               'type'     => 'color',
               'title'    => esc_html__( 'Footer Copyright Ancor Hover Color', 'luxrio' ),
               'subtitle' => esc_html__( 'Set footer copyright ancor Hover color', 'luxrio' ),
               'required' => array( 'luxrio_disable_footer_bottom','equals','1'),
               'output'   => array( '.footer-copyright p a:hover' ),
            ),

       ),
   ) );


    /* End Footer Media */

    // -> START Custom Css
    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Custom Css', 'luxrio' ),
        'id'         => 'luxrio_custom_css_section',
        'icon'  => 'el el-css',
        'fields'     => array(
            array(
                'id'       => 'luxrio_css_editor',
                'type'     => 'ace_editor',
                'title'    => esc_html__('CSS Code', 'luxrio'),
                'subtitle' => esc_html__('Paste your CSS code here.', 'luxrio'),
                'mode'     => 'css',
                'theme'    => 'monokai',
            )
        ),
    ) );

    /* End custom css */



    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'luxrio' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::set_section( $opt_name, $section );
    }
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'luxrio' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'luxrio' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }