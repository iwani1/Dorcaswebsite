<div class="img-box2" data-bg-src="<?php echo esc_url( $settings['image_one']['url'] );?>">
    <div class="img-body">
        <?php
            if( ! empty( $settings['image_two']['url'] ) ){
                echo luxrio_img_tag( array(
                    'url'   => esc_url( $settings['image_two']['url'] ),
                    'class' => 'ele1'
                ) );
            }
            if( ! empty( $settings['image_caption'] ) ){
                echo '<span class="img-caption">'.esc_html( $settings['image_caption'] ).'</span>';
            }
        ?>
    
    </div>
</div>