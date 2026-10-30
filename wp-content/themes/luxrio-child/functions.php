<?php
/**
 *
 * @Packge      Luxrio
 * @Author      Vecuro
 * @Author URL  https//www.vecurosoft.com
 * @version     1.0
 *
 */

/**
 * Enqueue style of child theme
 */
function luxrio_child_enqueue_styles() {

    wp_enqueue_style( 'luxrio-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'luxrio-child-style', get_stylesheet_directory_uri() . '/style.css',array( 'luxrio-style' ),wp_get_theme()->get('Version'));
}
add_action( 'wp_enqueue_scripts', 'luxrio_child_enqueue_styles', 100000 );