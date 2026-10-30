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

    if( !empty( luxrio_pagination() ) ) :
?>
<!-- Post Pagination -->
<div class="vs-pagination">

        <?php 
        
    
        
        add_filter('next_posts_link_attributes', 'posts_link_attributes');
        add_filter('previous_posts_link_attributes', 'posts_link_attributes');
        function posts_link_attributes(){
            return 'class="pagi-btn"';
        };


        ?>

        <?php
             $prev 	= '<i class="fa-solid fa-angles-left"></i>';
             $next 	= '<i class="fa-solid fa-angles-right"></i>';
            // previous
            if( get_previous_posts_link() ){
                previous_posts_link( $prev );
            }
        ?>
         <ul>
            <?php 
                echo luxrio_pagination();
            ?>
         </ul>
        <?php 
        // next
        if( get_next_posts_link() ){
            next_posts_link( $next );
        }
    ?>
</div>
<!-- End of Post Pagination -->
<?php 
    endif;