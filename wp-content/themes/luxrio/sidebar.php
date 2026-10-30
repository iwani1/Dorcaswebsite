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
    exit;
}

if ( ! is_active_sidebar( 'luxrio-blog-sidebar' ) ) {
    return;
}
?>

<div class="col-lg-3">
    <div class="sidebar-area sticky-sidebar">
    <?php dynamic_sidebar( 'luxrio-blog-sidebar' ); ?>
    </div>
</div>