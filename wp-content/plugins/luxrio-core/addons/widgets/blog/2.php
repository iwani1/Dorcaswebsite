<?php
    echo '<div class="vs-blog blog-style3">';
        echo '<div class="blog-img">';
            if ( has_post_thumbnail() ) {
                echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                    the_post_thumbnail( 'home-slider-blog-image-two', ['class' => 'blog-img__img'] );
                echo '</a>';
            }
        echo '</div>';
        echo '<div class="blog-content">';
            echo '<div class="blog-plus">';
                echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                    echo '<i class="fas fa-plus"></i>';
                echo '</a>';
            echo '</div>';
            echo '<div class="blog-meta">';
                echo '<a class="blog-date" href="' . esc_url( luxrio_blog_date_permalink() ) . '">';
                    echo '<time datetime="' . esc_attr( get_the_date(DATE_W3C) ) . '">' . esc_html( get_the_date() ) . '</time>';
                echo '</a>';

                echo '<a class="blog-meta__cn" href="'.esc_url( get_comments_link( get_the_ID() ) ).'"><i class="far fa-comment-dots"></i>' . esc_html( get_comments_number() ).'</a>';

            echo '</div>';
            echo '<h2 class="blog-title">
                    <a href="' . esc_url( get_permalink() ) . '">' . esc_html( wp_trim_words( get_the_title(), $settings['title_count'], '') ) . '</a>
                </h2>';
            if ( ! empty( $settings['excerpt_count'] ) ) {
                echo '<p class="blog-text">' . wp_kses_post( wp_trim_words( get_the_content(), $settings['excerpt_count'], '') ) . '</p>';
            }
        echo '</div>';
    echo '</div>';