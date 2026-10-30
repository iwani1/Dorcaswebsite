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

    luxrio_setPostViews( get_the_ID() );

    ?>
    <div <?php post_class(); ?> >
    <?php
        if( class_exists('ReduxFramework') ) {
            $luxrio_post_details_title_position = luxrio_opt('luxrio_post_details_title_position');
        } else {
            $luxrio_post_details_title_position = 'header';
        }

        $allowhtml = array(
            'p'         => array(
                'class'     => array()
            ),
            'span'      => array(),
            'a'         => array(
                'href'      => array(),
                'title'     => array(),
                'class'     => array(),
            ),
            'br'        => array(),
            'em'        => array(),
            'strong'    => array(),
            'b'         => array(),
        );

        // Blog Post Thumbnail
        do_action( 'luxrio_blog_post_thumb' );
        

        echo '<div class="blog-content">';

           
            // Blog Post Meta
            do_action( 'luxrio_blog_post_meta' );

            //title
            if( $luxrio_post_details_title_position != 'header' ) {
                echo '<h2 class="blog-title">'.wp_kses( get_the_title(), $allowhtml ).'</h2>';
            }

            // Blog COntent
            the_content();
            // Link Pages
            luxrio_link_pages();

        echo '</div>';



        $luxrio_post_tag = get_the_tags();

        if( class_exists('ReduxFramework') ) {
            $luxrio_post_details_share_options  = luxrio_opt('luxrio_post_details_share_options');
            $luxrio_blog_separator_img          = luxrio_opt( 'luxrio_blog_separaotr_img','url' );
        } else {
            $luxrio_post_details_share_options  = false;
            $luxrio_blog_separator_img          = get_template_directory_uri().'/assets/img/dot-shape.svg';
        }

        if( ! empty( $luxrio_post_tag ) || ( function_exists( 'luxrio_social_sharing_buttons' ) && $luxrio_post_details_share_options ) ){
            echo '<!-- Share Links Area -->';
            echo '<div class="blog-footer">';
                    
                    if( is_array( $luxrio_post_tag ) && ! empty( $luxrio_post_tag ) ){
                        echo '<div class="tagcloud">';
                            foreach( $luxrio_post_tag as $tags ){
                                echo '<a class="tag-cloud-link" href="'.esc_url( get_tag_link( $tags->term_id ) ).'">'.esc_html( $tags->name ).'</a>';
                            }
                        echo '</div>';
                    }
                    /**
                    *
                    * Hook for Blog Details Share Options
                    *
                    * Hook luxrio_blog_details_share_options
                    *
                    * @Hooked luxrio_blog_details_share_options_cb 10
                    *
                    */
                    do_action( 'luxrio_blog_details_share_options' );

            echo '</div>';
        }

        if( ! empty( $luxrio_blog_separator_img ) ){
            echo luxrio_img_tag( array(
                'url'   => esc_url( $luxrio_blog_separator_img ),
                'class' => 'blog-element'
            ) );
        }

    echo '</div>';
    /**
    *
    * Hook for Blog Details Author Bio
    *
    * Hook luxrio_blog_details_author_bio
    *
    * @Hooked luxrio_blog_details_author_bio_cb 10
    *
    */
    do_action( 'luxrio_blog_details_author_bio' );

    /**
    *
    * Hook for Blog Details Post Navigation Options
    *
    * Hook luxrio_blog_details_post_navigation
    *
    * @Hooked luxrio_blog_details_post_navigation_cb 10
    *
    */
    do_action( 'luxrio_blog_details_post_navigation' );



    /**
    *
    * Hook for Blog Details Related Post
    *
    * Hook luxrio_blog_details_related_post
    *
    * @Hooked luxrio_blog_details_related_post_cb 10
    *
    */
    do_action( 'luxrio_blog_details_related_post' );

    /**
    *
    * Hook for Blog Details Comments
    *
    * Hook luxrio_blog_details_comments
    *
    * @Hooked luxrio_blog_details_comments_cb 10
    *
    */
    do_action( 'luxrio_blog_details_comments' );