<?php
/**
 * @Packge     : Luxrio
 * @Version    : 1.0
 * @Author     : Vecurosoft
 * @Author URI : https://www.vecurosoft.com/
 *
 */

// Block direct access
if ( ! defined('ABSPATH') ) {
    exit;
}
    // Header
    get_header();

    /**
    *
    * Hook for Blog Start Wrapper
    *
    * Hook luxrio_blog_start_wrap
    *
    * @Hooked luxrio_blog_start_wrap_cb 10
    *
    */
    do_action( 'luxrio_blog_start_wrap' );

    /**
    *
    * Hook for Blog Column Start Wrapper
    *
    * Hook luxrio_blog_col_start_wrap
    *
    * @Hooked luxrio_blog_col_start_wrap_cb 10
    *
    */
    do_action( 'luxrio_blog_col_start_wrap' );

    echo '<div class="row search-active filter-active">';
        if( have_posts() ) {
            while( have_posts() ) {
                the_post();
                if ( is_active_sidebar( 'luxrio-blog-sidebar' ) ) {
                    $column_class = 'col-md-6';
                }else{
                    $column_class = 'col-md-4';
                }
                echo '<div class="'.esc_attr( $column_class ).' filter-item">';
                    echo '<div class="vs-search">';
                        if( has_post_thumbnail() ){
                            echo '<div class="search-grid-img image-scale-hover">';
                                echo '<a href="'.esc_url( get_the_permalink() ).'">';
                                    the_post_thumbnail( );
                                echo '</a>';
                            echo '</div>';
                        }
                        echo '<div class="search-grid-content">';

                            if( get_the_title() ){
                                echo '<!-- Post Title -->';
                                echo '<h4 class="search-grid-title fw-semibold"><a href="'.esc_url( get_permalink() ).'">'.esc_html( get_the_title( ) ).'</a></h4>';
                                echo '<!-- End Post Title -->';
                            }

                            echo '<div class="search-grid-meta">';
                                echo '<span><a href="'.esc_url( luxrio_blog_date_permalink() ).'"><i class="far fa-calendar-alt"></i>';
                                    echo '<time datetime="'.esc_attr( get_the_date( DATE_W3C ) ).'">'.esc_html( get_the_date() ).'</time>';
                                echo '</a></span>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
            wp_reset_postdata();
        } else{
            get_template_part('templates/content','none');
        }
    echo '</div>';

    /**
    *
    * Hook for Blog Pagination
    *
    * Hook luxrio_blog_pagination
    *
    * @Hooked luxrio_blog_pagination_cb 10
    *
    */
    do_action( 'luxrio_blog_pagination' );

    /**
    *
    * Hook for Blog Column End Wrapper
    *
    * Hook luxrio_blog_col_end_wrap
    *
    * @Hooked luxrio_blog_col_end_wrap_cb 10
    *
    */
    do_action( 'luxrio_blog_col_end_wrap' );

    /**
    *
    * Hook for Blog Sidebar
    *
    * Hook luxrio_blog_sidebar
    *
    * @Hooked luxrio_blog_sidebar_cb 10
    *
    */
    do_action( 'luxrio_blog_sidebar' );

    /**
    *
    * Hook for Blog End Wrapper
    *
    * Hook luxrio_blog_end_wrap
    *
    * @Hooked luxrio_blog_end_wrap_cb 10
    *
    */
    do_action( 'luxrio_blog_end_wrap' );

    //footer
    get_footer();