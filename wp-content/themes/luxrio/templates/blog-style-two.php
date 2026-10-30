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

echo '<!-- Single Post -->';
?>
<div <?php post_class(); ?> >
<?php
    // Blog Post Content
    do_action( 'luxrio_blog_post_thumb' );


    // Excerpt And Read More Button
    do_action( 'luxrio_blog_post_content' );

echo '</div>';
echo '<!-- End Single Post -->';