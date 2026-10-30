<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( $settings['blog_post_style'] == '1' ) {
    echo '<div class="vs-blog blog-style2">';
        if( has_post_thumbnail() ) {
            echo '<div class="blog-img">';
                echo '<a href="'.esc_url( get_the_permalink() ).'">';
                    the_post_thumbnail( 'blog-post-one', ['class' => 'img'] );
                echo '</a>';
            echo '</div>';
        }
        echo '<div class="blog-body">';
            echo '<div class="blog-metas">';
                //date
                echo '<a class="blog-meta" href="' . esc_url( luxrio_blog_date_permalink() ) . '">';
                    echo '<time datetime="' . esc_attr( get_the_date(DATE_W3C) ) . '">' . esc_html(get_the_date()) . '</time>';
                echo '</a>';

                echo '<a href="'.esc_url( get_author_posts_url( get_the_author_meta('ID') ) ).'" class="blog-meta">'.get_the_author().'</a>';

            echo '</div>';

            echo '<h3 class="blog-title">';
                echo '<a href="'.esc_url( get_the_permalink() ).'">'.esc_html( wp_trim_words( get_the_title(), $settings['title_count'], '') ).'</a>';
            echo '</h3>';

            echo '<span class="blog-divider2"></span>';
            echo '<span class="blog-divider"></span>';
            if ( ! empty( $settings['read_more_text'] ) ){
                echo '<a href="'.esc_url( get_the_permalink() ).'" class="blog-link">'.esc_html( $settings['read_more_text'] ).'</a>';
            }
        echo '</div>';
    echo '</div>';
}