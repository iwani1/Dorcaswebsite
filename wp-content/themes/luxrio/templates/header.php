<?php
/**
 * @Packge     : Luxrio
 * @Version    : 1.0
 * @Author     : Vecurosoft
 * @Author URI : https://www.vecurosoft.com/
 *
 */

    // Block direct access
    if( ! defined( 'ABSPATH' ) ){
        exit();
    }

    if( class_exists( 'ReduxFramework' ) && defined('ELEMENTOR_VERSION') ) {
        if( is_page() || is_page_template('template-builder.php') ) {
            $luxrio_post_id = get_the_ID();

            // Get the page settings manager
            $luxrio_page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

            // Get the settings model for current post
            $luxrio_page_settings_model = $luxrio_page_settings_manager->get_model( $luxrio_post_id );

            // Retrieve the color we added before
            $luxrio_header_style = $luxrio_page_settings_model->get_settings( 'luxrio_header_style' );
            $luxrio_header_builder_option = $luxrio_page_settings_model->get_settings( 'luxrio_header_builder_option' );

            if( $luxrio_header_style == 'header_builder'  ) {

                if( !empty( $luxrio_header_builder_option ) ) {
                    $luxrioheader = get_post( $luxrio_header_builder_option );
                    echo '<header class="header">';
                        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $luxrioheader->ID );
                    echo '</header>';
                    luxrio_global_header();
                }
            } else {
                // global options
                $luxrio_header_builder_trigger = luxrio_opt('luxrio_header_options');
                if( $luxrio_header_builder_trigger == '2' ) {
                    echo '<header>';
                    $luxrio_global_header_select = get_post( luxrio_opt( 'luxrio_header_select_options' ) );
                    $header_post = get_post( $luxrio_global_header_select );
                    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header_post->ID );
                    echo '</header>';
                    luxrio_global_header();
                } else {
                    // wordpress Header
                    luxrio_global_header_option();
                }
            }
        } else {
            $luxrio_header_options = luxrio_opt('luxrio_header_options');
            if( $luxrio_header_options == '1' ) {
                luxrio_global_header_option();
            } else {
                $luxrio_header_select_options = luxrio_opt('luxrio_header_select_options');
                $luxrioheader = get_post( $luxrio_header_select_options );
                echo '<header class="header">';
                    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $luxrioheader->ID );
                echo '</header>';
                luxrio_global_header();
            }
        }
    } else {
        luxrio_global_header_option();
    }