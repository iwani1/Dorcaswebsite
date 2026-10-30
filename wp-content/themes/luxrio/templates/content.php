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

if( class_exists( 'ReduxFramework' )){
    $luxrio_blog_style = luxrio_opt('luxrio_blog_style');

    if('blog_style_one' == $luxrio_blog_style ){
        get_template_part( 'templates/blog-style-one' );
    }elseif('blog_style_two' == $luxrio_blog_style ){
        get_template_part( 'templates/blog-style-two' );
    }
}else{
    get_template_part( 'templates/blog-style-one' );
}