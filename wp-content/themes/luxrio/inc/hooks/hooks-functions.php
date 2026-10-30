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

   


    // preloader hook function
    if( ! function_exists( 'luxrio_preloader_wrap_cb' ) ) {
        function luxrio_preloader_wrap_cb() {
            $preloader_display              =  luxrio_opt('luxrio_display_preloader');

            if( class_exists('ReduxFramework') ){
                if( $preloader_display ){
                    echo '<div class="preloader">';
                        echo '<button class="vs-btn preloaderCls">'.esc_html__( 'Cancel Preloader', 'luxrio' ).'</button>';
                        echo '<div class="preloader-inner">';
                            if( ! empty( luxrio_opt( 'luxrio_preloader_img','url' ) ) ){
                                echo luxrio_img_tag( array(
                                    'url'   => esc_url( luxrio_opt( 'luxrio_preloader_img','url' ) ),
                                ) );
                            }
                            echo '<span class="loader"></span>';
                        echo '</div>';
                    echo '</div>'; 
                }
            }else{
                echo '<div class="preloader">';
                    echo '<button class="vs-btn preloaderCls">'.esc_html__( 'Cancel Preloader', 'luxrio' ).'</button>';
                    echo '<div class="preloader-inner">';
                        echo '<span class="loader"></span>';
                    echo '</div>';
                echo '</div>';
            }
        }
    }


    // Header Hook function
    if( !function_exists('luxrio_header_cb') ) {
        function luxrio_header_cb( ) {
            get_template_part('templates/header');
            get_template_part('templates/header-menu-bottom');
        }
    }

    // back top top hook function
    if( ! function_exists( 'luxrio_back_to_top_cb' ) ) {
        function luxrio_back_to_top_cb( ) {
            $backtotop_trigger = luxrio_opt('luxrio_display_bcktotop');
            $custom_bcktotop   = luxrio_opt('luxrio_custom_bcktotop');
            $custom_bcktotop_icon   = luxrio_opt('luxrio_custom_bcktotop_icon');
            if( class_exists( 'ReduxFramework' ) ) {
                if( $backtotop_trigger ) {
                    if( $custom_bcktotop ) {
                        echo '<!-- Back to Top Button -->';
                        echo '<a href="#" class="scrollToTop scroll-btn">';
                            echo '<i class="fa '.esc_attr( $custom_bcktotop_icon ).'"></i>';
                        echo '</a>';
                        echo '<!-- End of Back to Top Button -->';
                    } else {
                        echo '<!-- Back to Top Button -->';
                        echo '<a href="#" class="scrollToTop scroll-btn">';
                            echo '<i class="fas fa-arrow-up"></i>';
                        echo '</a>';
                        echo '<!-- End of Back to Top Button -->';
                    }
                }
            }

        }
    }

    // Blog Start Wrapper Function
    if( !function_exists('luxrio_blog_start_wrap_cb') ) {
        function luxrio_blog_start_wrap_cb() {
            echo '<section class="vs-blog-wrapper space-top space-extra-bottom arrow-wrap">';
                echo '<div class="container">';
                    echo '<div class="row gx-50">';
        }
    }

    // Blog End Wrapper Function
    if( !function_exists('luxrio_blog_end_wrap_cb') ) {
        function luxrio_blog_end_wrap_cb() {
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        }
    }

    // Blog Column Start Wrapper Function
    if( !function_exists('luxrio_blog_col_start_wrap_cb') ) {
        function luxrio_blog_col_start_wrap_cb() {
            if( class_exists('ReduxFramework') ) {
                $luxrio_blog_sidebar = luxrio_opt('luxrio_blog_sidebar');
                if( $luxrio_blog_sidebar == '2' && is_active_sidebar('luxrio-blog-sidebar') ) {
                    echo '<div class="col-lg-9 order-lg-last">';
                } elseif( $luxrio_blog_sidebar == '3' && is_active_sidebar('luxrio-blog-sidebar') ) {
                    echo '<div class="col-lg-9">';
                } else {
                    echo '<div class="col-lg-12">';
                }

            } else {
                if( is_active_sidebar('luxrio-blog-sidebar') ) {
                    echo '<div class="col-lg-9">';
                } else {
                    echo '<div class="col-lg-12">';
                }
            }
        }
    }
    // Blog Column End Wrapper Function
    if( !function_exists('luxrio_blog_col_end_wrap_cb') ) {
        function luxrio_blog_col_end_wrap_cb() {
            echo '</div>';
        }
    }

    // Blog Sidebar
    if( !function_exists('luxrio_blog_sidebar_cb') ) {
        function luxrio_blog_sidebar_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_blog_sidebar = luxrio_opt('luxrio_blog_sidebar');
            } else {
                $luxrio_blog_sidebar = 2;
            }
            if( $luxrio_blog_sidebar != 1 && is_active_sidebar('luxrio-blog-sidebar') ) {
                // Sidebar
                get_sidebar();
            }
        }
    }


    if( !function_exists('luxrio_blog_details_sidebar_cb') ) {
        function luxrio_blog_details_sidebar_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_blog_single_sidebar = luxrio_opt('luxrio_blog_single_sidebar');
            } else {
                $luxrio_blog_single_sidebar = 4;
            }
            if( $luxrio_blog_single_sidebar != 1 ) {
                // Sidebar
                get_sidebar();
            }

        }
    }

    // Blog Pagination Function
    if( !function_exists('luxrio_blog_pagination_cb') ) {
        function luxrio_blog_pagination_cb( ) {
            get_template_part('templates/pagination');
        }
    }

    // Blog Content Function
    if( !function_exists('luxrio_blog_content_cb') ) {
        function luxrio_blog_content_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_blog_grid = luxrio_opt('luxrio_blog_grid');
            } else {
                $luxrio_blog_grid = '1';
            }

            if( $luxrio_blog_grid == '1' ) {
                $luxrio_blog_grid_class = 'col-lg-12';
            } elseif( $luxrio_blog_grid == '2' ) {
                $luxrio_blog_grid_class = 'col-sm-6';
            } else {
                $luxrio_blog_grid_class = 'col-lg-4 col-sm-6';
            }

            echo '<div class="row">';
                if( have_posts() ) {
                    while( have_posts() ) {
                        the_post();
                        echo '<div class="'.esc_attr($luxrio_blog_grid_class).'">';
                            get_template_part('templates/content',get_post_format());
                        echo '</div>';
                    }
                    wp_reset_postdata();
                } else{
                    get_template_part('templates/content','none');
                }
            echo '</div>';
        }
    }

    // footer content Function
    if( !function_exists('luxrio_footer_content_cb') ) {
        function luxrio_footer_content_cb( ) {

            if( class_exists('ReduxFramework') && did_action( 'elementor/loaded' )  ){
                if( is_page() || is_page_template('template-builder.php') ) {
                    $post_id = get_the_ID();

                    // Get the page settings manager
                    $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

                    // Get the settings model for current post
                    $page_settings_model = $page_settings_manager->get_model( $post_id );

                    // Retrieve the Footer Style
                    $footer_settings = $page_settings_model->get_settings( 'luxrio_footer_style' );

                    // Footer Local
                    $footer_local = $page_settings_model->get_settings( 'luxrio_footer_builder_option' );

                    // Footer Enable Disable
                    $footer_enable_disable = $page_settings_model->get_settings( 'luxrio_footer_choice' );

                    if( $footer_enable_disable == 'yes' ){
                        if( $footer_settings == 'footer_builder' ) {
                            // local options
                            $luxrio_local_footer = get_post( $footer_local );
                            echo '<footer>';
                            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $luxrio_local_footer->ID );
                            echo '</footer>';
                        } else {
                            // global options
                            $luxrio_footer_builder_trigger = luxrio_opt('luxrio_footer_builder_trigger');
                            if( $luxrio_footer_builder_trigger == 'footer_builder' ) {
                                echo '<footer>';
                                $luxrio_global_footer_select = get_post( luxrio_opt( 'luxrio_footer_builder_select' ) );
                                $footer_post = get_post( $luxrio_global_footer_select );
                                echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $footer_post->ID );
                                echo '</footer>';
                            } else {
                                // wordpress widgets
                                luxrio_footer_global_option();
                            }
                        }
                    }
                } else {
                    // global options
                    $luxrio_footer_builder_trigger = luxrio_opt('luxrio_footer_builder_trigger');
                    if( $luxrio_footer_builder_trigger == 'footer_builder' ) {
                        echo '<footer>';
                        $luxrio_global_footer_select = get_post( luxrio_opt( 'luxrio_footer_builder_select' ) );
                        $footer_post = get_post( $luxrio_global_footer_select );
                        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $footer_post->ID );
                        echo '</footer>';
                    } else {
                        // wordpress widgets
                        luxrio_footer_global_option();
                    }
                }
            } else {
                echo '<div class="footer-copyright text-center bg-black py-3 link-inherit z-index-common">';
                    echo '<div class="container">';
                        echo '<p class="mb-0 text-white">'.sprintf( 'Copyright <i class="far fa-copyright"></i> %s <a href="%s">%s</a> All Rights Reserved by <a href="%s">%s</a>',date('Y'),esc_url('#'),__( 'Luxrio.','luxrio' ),esc_url('#'),__( 'Vecuro', 'luxrio' ) ).'</p>';
                    echo '</div>';
                echo '</div>';
            }

        }
    }


    // blog details wrapper start hook function
    if( !function_exists('luxrio_blog_details_wrapper_start_cb') ) {
        function luxrio_blog_details_wrapper_start_cb( ) {
            echo '<section class="vs-blog-wrapper blog-details space-top space-extra-bottom">';
                echo '<div class="container">';
                    echo '<div class="row gx-50">';
        }
    }

    // blog details column wrapper start hook function
    if( !function_exists('luxrio_blog_details_col_start_cb') ) {
        function luxrio_blog_details_col_start_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_blog_single_sidebar = luxrio_opt('luxrio_blog_single_sidebar');
                if( $luxrio_blog_single_sidebar == '2' && is_active_sidebar('luxrio-blog-sidebar') ) {
                    echo '<div class="col-lg-9 order-last">';
                } elseif( $luxrio_blog_single_sidebar == '3' && is_active_sidebar('luxrio-blog-sidebar') ) {
                    echo '<div class="col-lg-9">';
                } else {
                    echo '<div class="col-lg-12">';
                }

            } else {
                if( is_active_sidebar('luxrio-blog-sidebar') ) {
                    echo '<div class="col-lg-9">';
                } else {
                    echo '<div class="col-lg-12">';
                }
            }
        }
    }

    // blog details post meta hook function
    if( !function_exists('luxrio_blog_post_meta_cb') ) {
        function luxrio_blog_post_meta_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_display_post_date      =  luxrio_opt('luxrio_display_post_date');
                $luxrio_display_post_author    =  luxrio_opt('luxrio_display_post_author');
                $luxrio_display_post_comment   =  luxrio_opt('luxrio_display_post_comment');

            } else {
                $luxrio_display_post_date      = '1';
                $luxrio_display_post_author    = '1';
                $luxrio_display_post_comment   = '1';
            }

            echo '<!-- Blog Meta -->';
            echo '<div class="blog-meta">';
                if( $luxrio_display_post_author ) {
                    echo luxrio_anchor_tag( array(
                        "text" => wp_kses_post( 'By ' . ucwords( get_the_author() ) . '' ),
                        "url"  => esc_url( get_author_posts_url( get_the_author_meta('ID') ) ),
                    ) );
                }  
                
                if( $luxrio_display_post_comment ){
                    if( get_comments_number() == 1 ){
                        $comment_text = __( ' Comment', 'luxrio' );
                    }else{
                        $comment_text = __( ' Comments', 'luxrio' );
                    }
                    echo '<a href="'.esc_url( get_comments_link( get_the_ID() ) ).'">' . '' . esc_html( get_comments_number() ).''.$comment_text.'</a>';
                }
                if( $luxrio_display_post_date ){
                    echo '<span class="blog-date"><a class="text-inherit" href="'.esc_url( luxrio_blog_date_permalink() ).'">';
                        echo '<time datetime="'.esc_attr( get_the_date( DATE_W3C ) ).'">'.esc_html( get_the_date() ).'</time>';
                    echo '</a></span>';
                }

            echo '</div>';

        }
    }

    // blog details share options hook function
    if( !function_exists('luxrio_blog_details_share_options_cb') ) {
        function luxrio_blog_details_share_options_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_post_details_share_options = luxrio_opt('luxrio_post_details_share_options');
            } else {
                $luxrio_post_details_share_options = false;
            }
            if( function_exists( 'luxrio_social_sharing_buttons' ) && $luxrio_post_details_share_options ) {
                echo '<div class="blog-social">';
                    echo luxrio_social_sharing_buttons();
                echo '</div>';
            }
        }
    }

    // blog details post navigation hook function
    if( !function_exists('luxrio_blog_details_post_navigation_cb') ) {
        function luxrio_blog_details_post_navigation_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_post_details_post_navigation = luxrio_opt('luxrio_post_details_post_navigation');
            } else {
                $luxrio_post_details_post_navigation = true;
            }

            $prevpost = get_previous_post();
            $nextpost = get_next_post();

            if( $luxrio_post_details_post_navigation && ! empty( $prevpost ) || !empty( $nextpost ) ) {
                echo '<!-- Post Navigation -->';
                echo '<div class="post-pagination">';
                    echo '<div class="row justify-content-between align-items-center gy-4">';
                        echo '<div class="col-6">';
                        if( ! empty( $prevpost ) ) {
                            echo '<!-- Nav Previous -->';
                            
                            echo '<div class="post-pagi-box prev">';
                                echo '<a class="post-pagi-control" href="'.esc_url( get_permalink( $prevpost->ID ) ).'">';
                                    echo  '<i class="fas fa-long-arrow-left"></i>';
                                    echo esc_html__( 'Previous Post', 'luxrio' );
                                echo '</a>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '<!-- End Nav Previous -->';
                        
                        echo '<div class="col-6">';
                        if( !empty( $nextpost ) ) {
                                echo '<div class="post-pagi-box next">';
                                    echo '<a class="post-pagi-control" href="'.esc_url( get_permalink( $nextpost->ID ) ).'">';
                                        echo esc_html__( 'Next Post', 'luxrio' );
                                        echo  '<i class="fas fa-long-arrow-right"></i>';
                                    echo '</a>';
                                echo '</div>';
                            }
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '<!-- End Post Navigation -->';
            }
        }
    }
    // blog details author bio hook function
    if( !function_exists('luxrio_blog_details_author_bio_cb') ) {
        function luxrio_blog_details_author_bio_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $postauthorbox =  luxrio_opt( 'luxrio_post_details_author_desc_trigger' );
            } else {
                $postauthorbox = '1';
            }
            if( !empty( get_the_author_meta('description')  ) && $postauthorbox == '1' ) {
                echo '<!-- Post Author -->';
                echo '<div class="post-admin">';
                    echo '<!-- Author Thumb -->';
                    echo '<div class="post-img">';
                        echo luxrio_img_tag( array(
                            "url"   => esc_url( get_avatar_url( get_the_author_meta('ID'), array(
                            "size"  => 189
                            ) ) ),
                        ) );
                    echo '</div>';
                    echo '<!-- End of Author Thumb -->';
                    echo '<div class="post-content">';
                        echo '<div class="post-header">';
                            echo luxrio_heading_tag( array(
                                "tag"   => "h4",
                                "text"  => luxrio_anchor_tag( array(
                                    "text"  => esc_html( ucwords( get_the_author() ) ),
                                    "url"   => esc_url( get_author_posts_url( get_the_author_meta('ID') ) ),
                                    'class' => 'text-inherit',
                                ) ),
                            ) );
                        echo '</div>';
                        
                        if( ! empty( get_the_author_meta('description') ) ) {
                            echo '<p class="post-text">';
                                echo esc_html( get_the_author_meta('description') );
                            echo '</p>';
                        };
                        if( function_exists( 'luxrio_social_icon' ) ){
                            luxrio_social_icon();
                        }
                    echo '</div>';
                echo '</div>';
                echo '<!-- End of Post Author -->';
            }

        }
    }

    // Blog Details Comments hook function
    if( !function_exists('luxrio_blog_details_comments_cb') ) {
        function luxrio_blog_details_comments_cb( ) {
            if ( ! comments_open() ) {
                echo '<div class="blog-comment-area">';
                    echo luxrio_heading_tag( array(
                        "tag"   => "h3",
                        "text"  => esc_html__( 'Comments are closed', 'luxrio' ),
                        "class" => "inner-title"
                    ) );
                echo '</div>';
            }

            // comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
        }
    }

    // Blog Details Related Post hook function
    if( !function_exists('luxrio_blog_details_related_post_cb') ) {
        function luxrio_blog_details_related_post_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_excerpt_length = '4';
                $luxrio_post_details_related_post = luxrio_opt('luxrio_post_details_related_post');
            } else {
                $luxrio_excerpt_length = '4';
                $luxrio_post_details_related_post = false;
            }
            $relatedpost = new WP_Query( array(
                "post_type"         => "post",
                "posts_per_page"    => "3",
                "category__in"      => wp_get_post_categories(get_the_ID()),
                "post__not_in"      =>  array( get_the_ID() )
            ) );
            if( $relatedpost->have_posts() && $luxrio_post_details_related_post ) {
                echo '<!-- Related Post -->';
                echo '<div class="related-post-wrapper pt-40">';
                    echo '<h2 class="inner-title1 h1">'.esc_html__( 'Relatetd', 'luxrio' ).' <span class="text-theme">'.esc_html__( 'Post', 'luxrio' ).'</span></h2>';
                    echo '<div class="row text-center">';
                        while( $relatedpost->have_posts() ) {
                            $relatedpost->the_post();
                            echo '<div class="col-lg-4">';
                                echo '<!-- Single Post -->';
                                echo '<div class="vs-blog blog-grid">';
                                    if( has_post_thumbnail(  ) ){
                                        the_post_thumbnail( 'luxrio-related-post-size', [ 'class'  => 'w-100' ] );
                                    }
                                    echo '<div class="blog-content">';
                                        if( get_the_title() ){
                                            echo '<!-- Post Title -->';
                                            echo '<h4 class="blog-title fw-semibold"><a href="'.esc_url( get_permalink() ).'">'.esc_html( wp_trim_words( get_the_title(), '3', '' ) ).'</a></h4>';
                                            echo '<!-- End Post Title -->';
                                        }
                                        echo '<span><a href="'.esc_url( luxrio_blog_date_permalink() ).'">';
                                            echo '<time datetime="'.esc_attr( get_the_date( DATE_W3C ) ).'">'.esc_html( get_the_date() ).'</time>';
                                        echo '</a></span>';
                                        echo '<span>';
                                            echo luxrio_getPostViews( get_the_ID() );
                                            echo esc_html__( ' Views', 'luxrio' );
                                        echo '</span>';
                                    echo '</div>';
                                echo '</div>';
                                echo '<!-- End Single Post -->';
                            echo '</div>';
                        }
                        wp_reset_postdata();
                    echo '</div>';
                echo '</div>';
                echo '<!-- End Related Post -->';
            }
        }
    }

    // Blog Details Column end hook function
    if( !function_exists('luxrio_blog_details_col_end_cb') ) {
        function luxrio_blog_details_col_end_cb( ) {
            echo '</div>';
        }
    }

    // Blog Details Wrapper end hook function
    if( !function_exists('luxrio_blog_details_wrapper_end_cb') ) {
        function luxrio_blog_details_wrapper_end_cb( ) {
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        }
    }

    // page start wrapper hook function
    if( !function_exists('luxrio_page_start_wrap_cb') ) {
        function luxrio_page_start_wrap_cb( ) {
            if( is_page( 'cart' ) ){
                $section_class = "vs-cart-wrapper space-top space-extra-bottom";
            }elseif( is_page( 'checkout' ) ){
                $section_class = "vs-checkout-wrapper space-top space-extra-bottom";
            }else{
                $section_class = "space-top space-extra-bottom";
            }
            echo '<section class="'.esc_attr( $section_class ).'">';
                echo '<div class="container">';
                    echo '<div class="row">';
        }
    }

    // page wrapper end hook function
    if( !function_exists('luxrio_page_end_wrap_cb') ) {
        function luxrio_page_end_wrap_cb( ) {
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        }
    }

    // page column wrapper start hook function
    if( !function_exists('luxrio_page_col_start_wrap_cb') ) {
        function luxrio_page_col_start_wrap_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_page_sidebar = luxrio_opt('luxrio_page_sidebar');
            }else {
                $luxrio_page_sidebar = '1';
            }
            if( $luxrio_page_sidebar == '2' && is_active_sidebar('luxrio-page-sidebar') ) {
                echo '<div class="col-lg-8 order-last">';
            } elseif( $luxrio_page_sidebar == '3' && is_active_sidebar('luxrio-page-sidebar') ) {
                echo '<div class="col-lg-8">';
            } else {
                echo '<div class="col-lg-12">';
            }

        }
    }

    // page column wrapper end hook function
    if( !function_exists('luxrio_page_col_end_wrap_cb') ) {
        function luxrio_page_col_end_wrap_cb( ) {
            echo '</div>';
        }
    }

    // page sidebar hook function
    if( !function_exists('luxrio_page_sidebar_cb') ) {
        function luxrio_page_sidebar_cb( ) {
            if( class_exists('ReduxFramework') ) {
                $luxrio_page_sidebar = luxrio_opt('luxrio_page_sidebar');
            }else {
                $luxrio_page_sidebar = '1';
            }

            if( class_exists('ReduxFramework') ) {
                $luxrio_page_layoutopt = luxrio_opt('luxrio_page_layoutopt');
            }else {
                $luxrio_page_layoutopt = '3';
            }

            if( $luxrio_page_layoutopt == '1' && $luxrio_page_sidebar != 1 ) {
                get_sidebar('page');
            } elseif( $luxrio_page_layoutopt == '2' && $luxrio_page_sidebar != 1 ) {
                get_sidebar();
            }
        }
    }

    // page content hook function
    if( !function_exists('luxrio_page_content_cb') ) {
        function luxrio_page_content_cb( ) {
            if(  class_exists('woocommerce') && ( is_woocommerce() || is_cart() || is_checkout() || is_page('wishlist') || is_account_page() )  ) {
                echo '<div class="woocommerce--content">';
            } else {
                echo '<div class="page--content clearfix">';
            }

                the_content();

                // Link Pages
                luxrio_link_pages();

            echo '</div>';
            // comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }

        }
    }
    if( !function_exists('luxrio_blog_post_thumb_cb') ) {
        function luxrio_blog_post_thumb_cb( ) {

            if( class_exists('ReduxFramework') ) {
                $luxrio_display_post_date      =  luxrio_opt('luxrio_display_post_date');
                $luxrio_display_post_author    =  luxrio_opt('luxrio_display_post_author');

            } else {
                $luxrio_display_post_date      = '1';
                $luxrio_display_post_author      = '1';
            }
            
            if( get_post_format() ) {
                $format = get_post_format();
            }else{
                $format = 'standard';
            }

            $luxrio_post_slider_thumbnail = luxrio_meta( 'post_format_slider' );

            if( !empty( $luxrio_post_slider_thumbnail ) ){
                echo '<div class="blog-img vs-carousel" data-arrows="true" data-slide-show="1" data-fade="true">';
                    foreach( $luxrio_post_slider_thumbnail as $single_image ){
                        if( ! is_single() ){
                            echo '<a href="'.esc_url( get_permalink() ).'" class="post-thumbnail">';
                        }
                        echo luxrio_img_tag( array(
                            'url'   => esc_url( $single_image )
                        ) );
                        if( ! is_single() ){
                            echo '</a>';
                        }
                    }
                    
                echo '</div>';
            }elseif( has_post_thumbnail() && $format == 'standard' ) {
                echo '<!-- Post Thumbnail -->';
                echo '<div class="blog-img">';
                    if( ! is_single() ){
                        echo '<a href="'.esc_url( get_permalink() ).'" class="post-thumbnail">';
                    }
                    the_post_thumbnail();
                    if( ! is_single() ){
                        echo '</a>';
                    }
                echo '</div>';
                echo '<!-- End Post Thumbnail -->';
            }elseif( $format == 'video' ){
                if( has_post_thumbnail() && !empty ( luxrio_meta( 'post_format_video' ) ) ){
                    echo '<div class="blog-video blog-img">';
                        if( ! is_single() ){
                            echo '<a href="'.esc_url( get_permalink() ).'" class="post-thumbnail">';
                        }
                            the_post_thumbnail();
                        if( ! is_single() ){
                            echo '</a>';
                        }
                        echo '<a href="'.esc_url( luxrio_meta( 'post_format_video' ) ).'" class="play-btn popup-video">';
                          echo '<i><svg xmlns="http://www.w3.org/2000/svg" width="18.875" height="36.156" viewBox="0 0 18.875 36.156">
                          <g id="Triangle_1" data-name="Triangle 1" transform="translate(-753.451 -2955.813)" fill="rgba(0,0,0,0)" stroke-linejoin="round">
                            <path d="M 755.951171875 2986.11279296875 L 755.951171875 2961.6689453125 L 768.7118530273438 2973.890869140625 L 755.951171875 2986.11279296875 Z" stroke="none"></path>
                            <path d="M 758.451171875 2967.525146484375 L 758.451171875 2980.256591796875 L 765.0975952148438 2973.890869140625 L 758.451171875 2967.525146484375 M 753.451171875 2955.812744140625 L 772.326171875 2973.890869140625 L 753.451171875 2991.968994140625 L 753.451171875 2955.812744140625 Z" stroke="none" fill="currentColor"></path>
                          </g>
                        </svg></i>';
                        echo '</a>';
                    echo '</div>';
                }elseif( ! has_post_thumbnail() && ! is_single() ){
                    echo '<div class="blog-video">';
                        if( ! is_single() ){
                            echo '<a href="'.esc_url( get_permalink() ).'" class="post-thumbnail">';
                        }
                            echo luxrio_embedded_media( array( 'video', 'iframe' ) );
                        if( ! is_single() ){
                            echo '</a>';   
                        }
                    echo '</div>';
                }
            }elseif( $format == 'audio' ){
                $luxrio_audio = luxrio_meta( 'post_format_audio' );
                if( !empty( $luxrio_audio ) ){
                    echo '<div class="blog-audio blog-image">';
                            echo wp_oembed_get( $luxrio_audio );
                           
                    echo '</div>';
                }elseif( !is_single() ){
                    echo '<div class="blog-audio blog-image">';
                            echo luxrio_embedded_media( array( 'audio', 'iframe' ) );
                           
                    echo '</div>';
                }
            }

        }
    }

    if( !function_exists( 'luxrio_blog_post_content_cb' ) ) {
        function luxrio_blog_post_content_cb( ) {
            $allowhtml = array(
                'p'         => array(
                    'class'     => array()
                ),
                'span'      => array(),
                'a'         => array(
                    'href'      => array(),
                    'title'     => array()
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'b'         => array(),
                'sup'       => array(),
                'sub'       => array(),
            );
            echo '<!-- blog-content -->';

            echo '<div class="blog-content ">';

                // Blog Post Meta
                do_action( 'luxrio_blog_post_meta' );

                if( ! is_single() ){
                    echo '<!-- Post Title -->';
                    echo '<h2 class="blog-title"><a href="'.esc_url( get_permalink() ).'">'.wp_kses( get_the_title(), $allowhtml ).'</a></h2>';
                    echo '<!-- End Post Title -->';
                }

                // Excerpt And Read More Button
                do_action( 'luxrio_blog_postexcerpt_read_content' );

            echo '</div>';
            echo '<!-- End Post Content -->';
        }
    }

    if( ! function_exists( 'luxrio_blog_postexcerpt_read_content_cb') ) {
        function luxrio_blog_postexcerpt_read_content_cb( ) {
            if( class_exists( 'ReduxFramework' ) ) {
                $luxrio_excerpt_length = luxrio_opt('luxrio_blog_postExcerpt');
            } else {
                $luxrio_excerpt_length = '24';
            }
            $allowhtml = array(
                'p'         => array(
                    'class'     => array()
                ),
                'span'      => array(),
                'a'         => array(
                    'href'      => array(),
                    'title'     => array()
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'b'         => array(),
            );

            if( class_exists( 'ReduxFramework' ) ) {
                $luxrio_blog_admin = luxrio_opt( 'luxrio_blog_post_author' );
                $luxrio_blog_separator_img = luxrio_opt( 'luxrio_blog_separaotr_img','url' );
                $luxrio_blog_readmore_setting_val = luxrio_opt('luxrio_blog_readmore_setting');
                if( $luxrio_blog_readmore_setting_val == 'custom' ) {
                    $luxrio_blog_readmore_setting = luxrio_opt('luxrio_blog_custom_readmore');
                } else {
                    $luxrio_blog_readmore_setting = __( 'Read More', 'luxrio' );
                }
            } else {
                $luxrio_blog_readmore_setting = __( 'Read More', 'luxrio' );
                $luxrio_blog_admin = true;
                $luxrio_blog_separator_img = get_template_directory_uri().'/assets/img/dot-shape.svg';
            }

            echo '<!-- Post Summary -->';
                echo luxrio_paragraph_tag( array(
                    "text"  => wp_kses( wp_trim_words( get_the_excerpt(), $luxrio_excerpt_length, '' ), $allowhtml ),
                    "class" => 'blog-text',
                ) );
            echo '<!-- End Post Summary -->';

            if( $luxrio_blog_admin || !empty( $luxrio_blog_readmore_setting ) ){
                if( !empty( $luxrio_blog_readmore_setting ) ){
                    echo '<div class="blog-footer">';
                        echo '<!-- Button -->';
                            echo '<a href="'.esc_url( get_permalink() ).'" class="blog-link">'.esc_html( $luxrio_blog_readmore_setting );
                            echo ' <svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14.707 6.04883L10.957 9.79883C10.6055 10.1797 9.99023 10.1797 9.63867 9.79883C9.25781 9.44727 9.25781 8.83203 9.63867 8.48047L11.7773 6.3125H0.9375C0.410156 6.3125 0 5.90234 0 5.375C0 4.81836 0.410156 4.4375 0.9375 4.4375H11.7773L9.63867 2.29883C9.25781 1.94727 9.25781 1.33203 9.63867 0.980469C9.99023 0.599609 10.6055 0.599609 10.957 0.980469L14.707 4.73047C15.0879 5.08203 15.0879 5.69727 14.707 6.04883Z" fill="#FF3E01" />
                        </svg></a>';
                        echo '<!-- End Button -->';
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
            }

            if( ! empty( $luxrio_blog_separator_img ) ){
                echo luxrio_img_tag( array(
                    'url'   => esc_url( $luxrio_blog_separator_img ),
                    'class' => 'blog-element'
                ) );
            }
        }
    }