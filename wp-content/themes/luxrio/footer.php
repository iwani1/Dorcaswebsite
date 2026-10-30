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
    /**
    *
    * Hook for Footer Content
    *
    * Hook luxrio_footer_content
    *
    * @Hooked luxrio_footer_content_cb 10
    *
    */
    do_action( 'luxrio_footer_content' );
    
    if( class_exists( 'ReduxFramework' ) ){
        $luxrio_scroll_animation = luxrio_opt( 'luxrio_scroll_animation' );
    }else{
        $luxrio_scroll_animation = '';
    }

    if( $luxrio_scroll_animation ){
                echo '</main>';
            }

    if( !is_404(  ) ) {
        /**
        *
        * Hook for Back to Top Button
        *
        * Hook luxrio_back_to_top
        *
        * @Hooked luxrio_back_to_top_cb 10
        *
        */
        do_action( 'luxrio_back_to_top' );
    }

    wp_footer();
    ?>
</body>
</html>