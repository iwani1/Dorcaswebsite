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

    //header
    get_header();

    /**
    * 
    * Hook for Blog Details Wrapper
    *
    * Hook luxrio_blog_details_wrapper_start
    *
    * @Hooked luxrio_blog_details_wrapper_start_cb 10
    *  
    */
    do_action( 'luxrio_blog_details_wrapper_start' );
    
    /**
    * 
    * Hook for Blog Details Column Start
    *
    * Hook luxrio_blog_details_col_start
    *
    * @Hooked luxrio_blog_details_col_start_cb 10
    *  
    */
    do_action( 'luxrio_blog_details_col_start' );

    while( have_posts( ) ) :
        the_post();
        
        get_template_part( 'templates/content-single');
        
    endwhile;
    /**
    * 
    * Hook for Blog Details Column End
    *
    * Hook luxrio_blog_details_col_end
    *
    * @Hooked luxrio_blog_details_col_end_cb 10
    *  
    */
    do_action( 'luxrio_blog_details_col_end' );

    /**
    * 
    * Hook for Blog Details Sidebar
    *
    * Hook luxrio_blog_details_sidebar
    *
    * @Hooked luxrio_blog_details_sidebar_cb 10
    *  
    */
    do_action( 'luxrio_blog_details_sidebar' );
    /**
    * 
    * Hook for Blog Details Wrapper End
    *
    * Hook luxrio_blog_details_wrapper_end
    *
    * @Hooked luxrio_blog_details_wrapper_end_cb 10
    *  
    */
    do_action( 'luxrio_blog_details_wrapper_end' );

    //footer
    get_footer();