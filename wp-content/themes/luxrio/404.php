<?php
/**
 * @Packge     : Luxrio
 * @Version    : 1.0
 * @Author     : Vecurosoft
 * @Author URI : https://themeforest.net/user/vecuro_themes
 *
 */

    // Block direct access
    if( !defined( 'ABSPATH' ) ){
        exit();
    }

    if( class_exists( 'ReduxFramework' ) ) {
        $luxrio404title         = luxrio_opt( 'luxrio_fof_error_number' );
        $luxrio404subtitle      = luxrio_opt( 'luxrio_fof_title' );
        $luxrio404desc          = luxrio_opt( 'luxrio_fof_subtitle' );
        $luxrio404btntext       = luxrio_opt( 'luxrio_fof_btn_text' );
    } else {
        $luxrio404title         = __( '404', 'luxrio' );
        $luxrio404subtitle      = __( 'Oops! That page can\'t be found.', 'luxrio' );
        $luxrio404btntext       = __( 'Go Back To Home', 'luxrio' );
        $luxrio404desc          = __( 'Lorem ipsum dolor sit amet, conse elit, sedid that eiusmod aboret dolore magna aliqua conseel usndi', 'luxrio');
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
        'sup'       => array(),
        'sub'       => array(),
        'li'        => array(),
    );

    // get header
    get_header();

    echo '<div class="z-index-common space-bottom">';
        echo '<div class="container">';
            echo '<div class="row">';
                echo '<div class="col-lg-8 mx-auto">';
                    echo '<div class="error-content">';
                        if( ! empty( $luxrio404title ) ){
                            echo '<h2>'.esc_html( $luxrio404title ).'</h2>';
                        }
                        if( ! empty( $luxrio404subtitle ) ){
                            echo '<h3>'.wp_kses( $luxrio404subtitle, $allowhtml ).'</h3>';
                        }
                        if( ! empty( $luxrio404desc ) ){
                            echo '<p>'.wp_kses( $luxrio404desc, $allowhtml ).'</p>';
                        }
                        if( ! empty( $luxrio404btntext ) ){
                            echo '<a href="'.esc_url( home_url( '/' ) ).'" class="vs-btn">';
                                echo esc_html( $luxrio404btntext );
                                echo '<i class="fas fa-arrow-right-long"></i>';
                            echo '</a>';
                        }
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    //footer
    get_footer();