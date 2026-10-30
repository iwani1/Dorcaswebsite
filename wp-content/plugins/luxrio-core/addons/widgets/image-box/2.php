<div class="img-box5">
<?php
    if( ! empty( $settings['image_one']['url'] ) ){
        echo '<div class="img1">';
            echo luxrio_img_tag( array(
                'url'   => esc_url( $settings['image_one']['url'] ),
            ) );
        echo '</div>';
    }
    if( ! empty( $settings['image_two']['url'] ) ){
        echo '<div class="img2">';
            echo luxrio_img_tag( array(
                'url'   => esc_url( $settings['image_two']['url'] ),
            ) );
        echo '</div>';
    }
    if( ! empty( $settings['image_three']['url'] ) ){
        echo '<div class="img3">';
            echo luxrio_img_tag( array(
                'url'   => esc_url( $settings['image_three']['url'] ),
            ) );
        echo '</div>';
    }
    if( ! empty( $settings['image_four']['url'] ) ){
        echo '<div class="img4">';
            echo luxrio_img_tag( array(
                'url'   => esc_url( $settings['image_four']['url'] ),
            ) );
        echo '</div>';
    }
?>

</div>