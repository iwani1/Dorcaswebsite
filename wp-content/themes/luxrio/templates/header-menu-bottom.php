<?php
/**
 * @Packge     : Luxrio
 * @Version    : 1.0
 * @Author     : Vecurosoft
 * @Author URI : https://www.vecurosoft.com/
 *
 */

    // Block direct access
    if( !defined( 'ABSPATH' ) ){
        exit();
    }

    if( defined( 'CMB2_LOADED' )  ){
        if( !empty( luxrio_meta('page_breadcrumb_area') ) ) {
            $luxrio_page_breadcrumb_area  = luxrio_meta('page_breadcrumb_area');
        } else {
            $luxrio_page_breadcrumb_area = '1';
        }
    }else{
        $luxrio_page_breadcrumb_area = '1';
    }

    $allowhtml = array(
        'p'         => array(
            'class'     => array()
        ),
        'span'      => array(
            'class'     => array(),
        ),
        'a'         => array(
            'href'      => array(),
            'title'     => array()
        ),
        'br'        => array(),
        'em'        => array(),
        'strong'    => array(),
        'b'         => array(),
        'sub'       => array(),
        'sup'       => array(),
    );

    if( class_exists( 'ReduxFramework' ) ){
        $luxrio_scroll_animation = luxrio_opt( 'luxrio_scroll_animation' );
    }else{
        $luxrio_scroll_animation = '';
    }

    if(  is_page() || is_page_template( 'template-builder.php' )  ) {
        if( $luxrio_scroll_animation ){
                echo '<main class="main">';
            }
        if( $luxrio_page_breadcrumb_area == '1' ) {
            echo '<!-- Page title -->';
            echo '<div class="breadcumb-wrapper background-image">';
                echo '<div class="container z-index-common">';
                    echo '<div class="breadcumb-content">';
                        if( defined('CMB2_LOADED') || class_exists('ReduxFramework') ) {
                            if( luxrio_meta('page_breadcrumb_settings') == 'page' ) {
                                $luxrio_page_title_switcher = luxrio_meta('page_title');
                            } elseif( luxrio_opt('luxrio_page_title_switcher') == true ) {
                                $luxrio_page_title_switcher = luxrio_opt('luxrio_page_title_switcher');
                            }else{
                                $luxrio_page_title_switcher = '1';
                            }
                        } else {
                            $luxrio_page_title_switcher = '1';
                        }

                        if( $luxrio_page_title_switcher == '1' ){
                            if( class_exists( 'ReduxFramework' ) ){
                                $luxrio_page_title_tag    = luxrio_opt('luxrio_page_title_tag');
                            }else{
                                $luxrio_page_title_tag    = 'h1';
                            }

                            if( defined( 'CMB2_LOADED' )  ){
                                if( !empty( luxrio_meta('page_title_settings') ) ) {
                                    $luxrio_custom_title = luxrio_meta('page_title_settings');
                                } else {
                                    $luxrio_custom_title = 'default';
                                }
                            }else{
                                $luxrio_custom_title = 'default';
                            }

                            if( $luxrio_custom_title == 'default' ) {
                                echo luxrio_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $luxrio_page_title_tag ),
                                        "text"  => esc_html( get_the_title( ) ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            } else {
                                echo luxrio_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $luxrio_page_title_tag ),
                                        "text"  => esc_html( luxrio_meta('custom_page_title') ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            }

                        }

                        if( defined('CMB2_LOADED') || class_exists('ReduxFramework') ) {

                            if( luxrio_meta('page_breadcrumb_settings') == 'page' ) {
                                $luxrio_breadcrumb_switcher = luxrio_meta('page_breadcrumb_trigger');
                            } else {
                                $luxrio_breadcrumb_switcher = luxrio_opt('luxrio_enable_breadcrumb');
                            }

                        } else {
                            $luxrio_breadcrumb_switcher = 'on';
                        }

                        if( $luxrio_breadcrumb_switcher == 'on' && (  is_page() || is_page_template( 'template-builder.php' ) )) {
                            echo '<div class="breadcumb-menu-wrap">';
                                luxrio_breadcrumbs(
                                    array(
                                        'breadcrumbs_classes' => 'nav',
                                    )
                                );
                            echo '</div>';
                        }

                        echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<!-- End of Page title -->';
        }
    } else {

      if( $luxrio_scroll_animation ){
                echo '<main class="main">';
            }

        echo '<!-- Page title -->';
        echo '<div class="breadcumb-wrapper background-image">';
            echo '<div class="container z-index-common">';
                echo '<div class="breadcumb-content">';
                    if( class_exists( 'ReduxFramework' )  ){
                        $luxrio_page_title_switcher  = luxrio_opt('luxrio_page_title_switcher');
                    }else{
                        $luxrio_page_title_switcher = '1';
                    }

                    if( $luxrio_page_title_switcher ){
                        if( class_exists( 'ReduxFramework' ) ){
                            $luxrio_page_title_tag    = luxrio_opt('luxrio_page_title_tag');
                        }else{
                            $luxrio_page_title_tag    = 'h1';
                        }
                        if( class_exists('woocommerce') && is_shop() ) {
                            echo luxrio_heading_tag(
                                array(
                                    "tag"   => esc_attr( $luxrio_page_title_tag ),
                                    "text"  => wp_kses( woocommerce_page_title( false ), $allowhtml ),
                                    'class' => 'breadcumb-title'
                                )
                            );
                        }elseif ( is_archive() ){
                            echo luxrio_heading_tag(
                                array(
                                    "tag"   => esc_attr( $luxrio_page_title_tag ),
                                    "text"  => wp_kses( get_the_archive_title(), $allowhtml ),
                                    'class' => 'breadcumb-title'
                                )
                            );
                        }elseif ( is_home() ){
                            $luxrio_blog_page_title_setting = luxrio_opt('luxrio_blog_page_title_setting');
                            $luxrio_blog_page_title_switcher = luxrio_opt('luxrio_blog_page_title_switcher');
                            $luxrio_blog_page_custom_title = luxrio_opt('luxrio_blog_page_custom_title');
                            if( class_exists('ReduxFramework') ){
                                if( $luxrio_blog_page_title_switcher ){
                                    echo luxrio_heading_tag(
                                        array(
                                            "tag"   => esc_attr( $luxrio_page_title_tag ),
                                            "text"  => !empty( $luxrio_blog_page_custom_title ) && $luxrio_blog_page_title_setting == 'custom' ? esc_html( $luxrio_blog_page_custom_title) : esc_html__( 'Blog', 'luxrio' ),
                                            'class' => 'breadcumb-title'
                                        )
                                    );
                                }
                            }else{
                                echo luxrio_heading_tag(
                                    array(
                                        "tag"   => "h1",
                                        "text"  => esc_html__( 'Blog', 'luxrio' ),
                                        'class' => 'breadcumb-title',
                                    )
                                );
                            }
                        }elseif( is_search() ){
                            echo luxrio_heading_tag(
                                array(
                                    "tag"   => esc_attr( $luxrio_page_title_tag ),
                                    "text"  => esc_html__( 'Search Result', 'luxrio' ),
                                    'class' => 'breadcumb-title'
                                )
                            );
                        }elseif( is_404() ){
                            echo luxrio_heading_tag(
                                array(
                                    "tag"   => esc_attr( $luxrio_page_title_tag ),
                                    "text"  => esc_html__( '404 PAGE', 'luxrio' ),
                                    'class' => 'breadcumb-title'
                                )
                            );
                        }elseif( is_singular( 'luxrio_project' ) ){
                            echo luxrio_heading_tag(
                                array(
                                    "tag"   => "h1",
                                    "text"  => esc_html__( 'Project Details', 'luxrio' ),
                                    'class' => 'breadcumb-title',
                                )
                            );
                        }elseif( is_singular( 'product' ) ){
                            $posttitle_position  = luxrio_opt('luxrio_product_details_title_position');
                            $postTitlePos = false;
                            if( class_exists( 'ReduxFramework' ) ){
                                if( $posttitle_position && $posttitle_position != 'header' ){
                                    $postTitlePos = true;
                                }
                            }else{
                                $postTitlePos = false;
                            }
                            
                            if( $postTitlePos != true ){
                                echo luxrio_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $luxrio_page_title_tag ),
                                        "text"  => wp_kses( get_the_title( ), $allowhtml ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            } else {
                                if( class_exists( 'ReduxFramework' ) ){
                                    $luxrio_post_details_custom_title  = luxrio_opt('luxrio_product_details_custom_title');
                                }else{
                                    $luxrio_post_details_custom_title = __( 'Shop Details','luxrio' );
                                }

                                if( !empty( $luxrio_post_details_custom_title ) ) {
                                    echo luxrio_heading_tag(
                                        array(
                                            "tag"   => esc_attr( $luxrio_page_title_tag ),
                                            "text"  => wp_kses( $luxrio_post_details_custom_title, $allowhtml ),
                                            'class' => 'breadcumb-title'
                                        )
                                    );
                                }
                            }
                        }else{
                            $posttitle_position  = luxrio_opt('luxrio_post_details_title_position');
                            $postTitlePos = false;
                            if( is_single() ){
                                if( class_exists( 'ReduxFramework' ) ){
                                    if( $posttitle_position && $posttitle_position != 'header' ){
                                        $postTitlePos = true;
                                    }
                                }else{
                                    $postTitlePos = false;
                                }
                            }
                            if( is_singular( 'product' ) ){
                                $posttitle_position  = luxrio_opt('luxrio_product_details_title_position');
                                $postTitlePos = false;
                                if( class_exists( 'ReduxFramework' ) ){
                                    if( $posttitle_position && $posttitle_position != 'header' ){
                                        $postTitlePos = true;
                                    }
                                }else{
                                    $postTitlePos = false;
                                }
                            }

                            if( $postTitlePos != true ){
                                echo luxrio_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $luxrio_page_title_tag ),
                                        "text"  => wp_kses( get_the_title( ), $allowhtml ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            } else {
                                if( class_exists( 'ReduxFramework' ) ){
                                    $luxrio_post_details_custom_title  = luxrio_opt('luxrio_post_details_custom_title');
                                }else{
                                    $luxrio_post_details_custom_title = __( 'Blog Details','luxrio' );
                                }

                                if( !empty( $luxrio_post_details_custom_title ) ) {
                                    echo luxrio_heading_tag(
                                        array(
                                            "tag"   => esc_attr( $luxrio_page_title_tag ),
                                            "text"  => wp_kses( $luxrio_post_details_custom_title, $allowhtml ),
                                            'class' => 'breadcumb-title'
                                        )
                                    );
                                }
                            }
                        }
                    }
                    if( class_exists('ReduxFramework') ) {
                        $luxrio_breadcrumb_switcher = luxrio_opt( 'luxrio_enable_breadcrumb' );
                    } else {
                        $luxrio_breadcrumb_switcher = '1';
                    }
                    if( $luxrio_breadcrumb_switcher == '1' ) {
                        echo '<div class="breadcumb-menu-wrap">';
                            luxrio_breadcrumbs(
                                array(
                                    'breadcrumbs_classes' => 'nav',
                                )
                            );
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<!-- End of Page title -->';
    }