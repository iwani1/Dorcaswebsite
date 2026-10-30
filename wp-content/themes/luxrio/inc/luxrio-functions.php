<?php

/**
 * @Packge     : Luxrio
 * @Version    : 1.0
 * @Author     : Vecurosoft
 * @Author URI : https://www.vecurosoft.com/
 *
 */


// Block direct access
if( ! defined( 'ABSPATH' ) ){
    exit;
}

 // theme option callback
function luxrio_opt( $id = null, $url = null ){
    global $luxrio_opt;

    if( $id && $url ){

        if( isset( $luxrio_opt[$id][$url] ) && $luxrio_opt[$id][$url] ){
            return $luxrio_opt[$id][$url];
        }
    }else{
        if( isset( $luxrio_opt[$id] )  && $luxrio_opt[$id] ){
            return $luxrio_opt[$id];
        }
    }
}


// theme logo
function luxrio_theme_logo() {
    // escaping allow html
    $allowhtml = array(
        'a'    => array(
            'href' => array()
        ),
        'span' => array(),
        'i'    => array(
            'class' => array()
        )
    );
    $siteUrl = home_url('/');
    if( has_custom_logo() ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $siteLogo = '';
        $siteLogo .= '<a class="logo" href="'.esc_url( $siteUrl ).'">';
        $siteLogo .= luxrio_img_tag( array(
            "class" => "img-fluid logo-img",
            "url"   => esc_url( wp_get_attachment_image_url( $custom_logo_id, 'full') )
        ) );
        $siteLogo .= '</a>';

        return $siteLogo;
    } elseif( !empty(  luxrio_opt('logo', 'url' ) )  ){

        $siteLogo = '<img class="img-fluid logo-img h" src="'.esc_url( luxrio_opt('logo', 'url' ) ).'" alt="'.esc_attr__( 'logo', 'luxrio' ).'" />';
        return '<a class="logo" href="'.esc_url( $siteUrl ).'">'.$siteLogo.'</a>';

    }else{
        return '<h2 class="mb-0"><a class="logo" href="'.esc_url( $siteUrl ).'">'.esc_html( get_bloginfo('name') ).'</a></h2>';
    }
}

// Luxrio Coming Soon Logo
function luxrio_coming_soon_logo() {
    // escaping allow html
    $allowhtml = array(
        'a'    => array(
            'href' => array()
        ),
        'span' => array(),
        'i'    => array(
            'class' => array()
        )
    );
    $siteUrl = home_url('/');
    // site logo
    if( luxrio_opt( 'luxrio_coming_logo', 'url' )  ){

        $siteLogo = '<img src="'.esc_url( luxrio_opt('luxrio_coming_logo', 'url' ) ).'" alt="'.esc_attr__( 'logo', 'luxrio' ).'" />';

        return '<a class="logo" href="'.esc_url( $siteUrl ).'">'.$siteLogo.'</a>';

    }elseif( luxrio_opt('luxrio_coming_site_title') ){
        return '<h2 class="mb-0"><a class="text-logo" href="'.esc_url( $siteUrl ).'">'.wp_kses( luxrio_opt('luxrio_coming_site_title'), $allowhtml ).'</a></h2>';
    }else{
        return '<h2 class="mb-0"><a class="text-logo" href="'.esc_url( $siteUrl ).'">'.esc_html( get_bloginfo('name') ).'</a></h2>';
    }
}

// custom meta id callback
function luxrio_meta( $id = '' ){
    $value = get_post_meta( get_the_ID(), '_luxrio_'.$id, true );
    return $value;
}


// Blog Date Permalink
function luxrio_blog_date_permalink() {
    $year  = get_the_time('Y');
    $month_link = get_the_time('m');
    $day   = get_the_time('d');
    $link = get_day_link( $year, $month_link, $day);
    return $link;
}

//audio format iframe match
function luxrio_iframe_match() {
    $audio_content = luxrio_embedded_media( array('audio', 'iframe') );
    $iframe_match = preg_match("/\iframe\b/i",$audio_content, $match);
    return $iframe_match;
}


//Post embedded media
function luxrio_embedded_media( $type = array() ){
    $content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
    $embed   = get_media_embedded_in_content( $content, $type );


    if( in_array( 'audio' , $type) ){
        if( count( $embed ) > 0 ){
            $output = str_replace( '?visual=true', '?visual=false', $embed[0] );
        }else{
           $output = '';
        }

    }else{
        if( count( $embed ) > 0 ){
            $output = $embed[0];
        }else{
           $output = '';
        }
    }
    return $output;
}


// WP post link pages
function luxrio_link_pages(){
    wp_link_pages( array(
        'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'luxrio' ) . '</span>',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
        'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'luxrio' ) . ' </span>%',
        'separator'   => '<span class="screen-reader-text">, </span>',
    ) );
}


// Data Background image attr
function luxrio_data_bg_attr( $imgUrl = '' ){
    return 'data-bg-img="'.esc_url( $imgUrl ).'"';
}

// image alt tag
function luxrio_image_alt( $url = '' ){
    if( $url != '' ){
        // attachment id by url
        $attachmentid = attachment_url_to_postid( esc_url( $url ) );
       // attachment alt tag
        $image_alt = get_post_meta( esc_html( $attachmentid ) , '_wp_attachment_image_alt', true );
        if( $image_alt ){
            return $image_alt ;
        }else{
            $filename = pathinfo( esc_url( $url ) );
            $alt = str_replace( '-', ' ', $filename['filename'] );
            return $alt;
        }
    }else{
       return;
    }
}


// Flat Content wysiwyg output with meta key and post id

function luxrio_get_textareahtml_output( $content ) {
    global $wp_embed;

    $content = $wp_embed->autoembed( $content );
    $content = $wp_embed->run_shortcode( $content );
    $content = wpautop( $content );
    $content = do_shortcode( $content );

    return $content;
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */

function luxrio_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'luxrio_pingback_header' );


// Excerpt More
function luxrio_excerpt_more( $more ) {
    return '...';
}

add_filter( 'excerpt_more', 'luxrio_excerpt_more' );


// luxrio comment template callback
function luxrio_comment_callback( $comment, $args, $depth ) {
        $add_below = 'comment';
    ?>
    <li <?php comment_class( array('vs-comment') ); ?>>
        <div id="comment-<?php comment_ID() ?>" class="vs-post-comment">
            <?php
                if( get_avatar( $comment, 110 )  ) :
            ?>
            <!-- Author Image -->
            <div class="comment-avater">
                <?php
                    if ( $args['avatar_size'] != 0 ) {
                        echo get_avatar( $comment, 110 );
                    }
                ?>
            </div>
            <!-- Author Image -->
            <?php
                endif;
            ?>
            <!-- Comment Content -->
            <div class="comment-content">
                <h4 class="name h5"><?php echo esc_html( ucwords( get_comment_author() ) ); ?><span class="commented-on"> 
                    <?php printf( esc_html__('%1$s', 'luxrio'), get_comment_date() ); ?> 
                </span></h4>
                
                <?php comment_text(); ?>

                <div class="edit_and_reply d-flex gap-4">
                    <?php
                        comment_reply_link(array_merge( $args, array( 'add_below' => $add_below, 'depth' => 1, 'max_depth' => 5, 'reply_text' => '<i class="fas fa-reply"></i>Reply' ) ) );
                    ?>
                    <span class="comment-edit-link"><?php edit_comment_link( '<i class="fa fa-pencil"></i>'.esc_html__( 'Edit', 'luxrio' ), '  ', '' ); ?></span>
                </div>

                <?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'luxrio' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Comment Content -->
<?php
}

//body class
add_filter( 'body_class', 'luxrio_body_class' );
function luxrio_body_class( $classes ) {
    if( class_exists('ReduxFramework') ) {
        $luxrio_blog_single_sidebar = luxrio_opt('luxrio_blog_single_sidebar');
        if( ($luxrio_blog_single_sidebar != '2' && $luxrio_blog_single_sidebar != '3' ) || ! is_active_sidebar('luxrio-blog-sidebar') ) {
            $classes[] = 'no-sidebar';
        }
        $classes[] = 'vs-body';
    } else {
        if( !is_active_sidebar('luxrio-blog-sidebar') ) {
            $classes[] = 'no-sidebar';
        }
        $classes[] = 'vs-body';
    }
    return $classes;
}


function luxrio_footer_global_option(){

    // Luxrio Footer Bottom Enable Disable
    if( class_exists( 'ReduxFramework' ) ){
        $luxrio_footer_bottom_active = luxrio_opt( 'luxrio_disable_footer_bottom' );
    }else{
        $luxrio_footer_bottom_active = '1';
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
    );

    if( $luxrio_footer_bottom_active == '1' ){
        echo '<!-- Footer -->';
        echo '<footer class="footer-wrapper footer-layout1">';

            if( $luxrio_footer_bottom_active == '1' ){
                $allowhtml = array(
                    'p'         => array(
                        'class'     => array()
                    ),
                    'span'      => array(),
                    'a'         => array(
                        'href'      => array(),
                        'title'     => array(),
                        'class'     => array(),
                    ),
                    'br'        => array(),
                    'em'        => array(),
                    'strong'    => array(),
                    'b'         => array(),
                );
                echo '<div class="copyright-wrap footer-copyright text-center bg-black py-3 link-inherit z-index-common">';
                    echo '<div class="container">';
                        echo '<div class="row align-items-center">';
                            if( ! empty( luxrio_opt( 'luxrio_copyright_text' ) ) ){
                                echo '<p class="mb-0 text-white">'.wp_kses( luxrio_opt( 'luxrio_copyright_text' ), $allowhtml ).'</p>';
                            }
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
        echo '</footer>';
        echo '<!-- End Footer -->';
    }
}

function luxrio_social_icon(){
    $luxrio_social_icon = luxrio_opt( 'luxrio_social_links' );
    if( ! empty( $luxrio_social_icon ) && isset( $luxrio_social_icon ) ){
        echo '<div class="blog-social">';
        foreach( $luxrio_social_icon as $social_icon ){
            if( ! empty( $social_icon['description'] ) ){
                echo '<a href="'.esc_url( $social_icon['url'] ).'">'.esc_html( $social_icon['description'] ).'</a>';
            }
        }
        echo '</div>';
    }
}


// global header
function luxrio_global_header_option() {
    luxrio_global_header();
    echo '<header class="vs-header header-layout2 header-default">';
        echo '<div class="sticky-active py-3 py-lg-0">';
            echo '<div class="container position-relative">';
                echo '<div class="row align-items-center justify-content-between">';
                    echo '<div class="col-auto align-self-center">';
                        echo '<div class="header-logo">';
                            echo luxrio_theme_logo();
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="col text-center">';
                        if( has_nav_menu( 'primary-menu' ) ){
                            echo '<nav class="main-menu menu-style2 d-none d-lg-block">';
                                wp_nav_menu( array(
                                    "theme_location"    => 'primary-menu',
                                    "container"         => '',
                                    "menu_class"        => ''
                                ) );
                            echo '</nav>';
                        }
                        
                    echo '</div>';

                    echo '<div class="col-auto">';
                        echo '<!-- Search Toggler -->';
                        echo '<div class="header-btns">';
                            echo '<button class="searchBoxTggler icon-btn justify-content-center"><i class="fas fa-search"></i></button>';
                        echo '</div>';
                    echo '</div>';
                    
                    echo '<div class="col-auto  d-inline-block d-lg-none">';
                        echo '<!-- Mobile Menu Toggler -->';
                        echo '<button class="vs-menu-toggle icon-btn"><i class="fas fa-bars"></i></button>';
                    echo '</div>';


                echo '</div>';
            echo '</div>';
        echo '</div>';
        if( ! empty( luxrio_opt( 'luxrio_notice_text' ) ) ){
            echo '<div class="header-notice d-none d-md-block">';
                echo '<div class="container">';
                    echo '<p class="mb-0 fs-xs text-title">'.esc_html( luxrio_opt( 'luxrio_notice_text' ) ).'</p>';
                echo '</div>';
            echo '</div>';
        }
    echo '</header>';

    echo '<div class="popup-search-box">';
            echo '<button class="searchClose"><i class="fas fa-times"></i></button>';
        echo '<form action="'.esc_url( home_url() ).'">';
            echo '<input name="s" type="text" placeholder="'.esc_attr__( 'What are you looking for', 'luxrio' ).'">';
            echo '<button type="submit" aria-label="search-button"><i class="fas fa-search"></i></button>';
        echo '</form>';
    echo '</div>';

}

// Luxrio Default Header
if( ! function_exists( 'luxrio_global_header' ) ){
    function luxrio_global_header(){
        // Mobile Menu
        echo '<div class="vs-menu-wrapper">';
            echo '<div class="vs-menu-area">';
                echo '<button class="vs-menu-toggle"><i class="fas fa-times"></i></button>';
                echo '<div class="mobile-logo">';
                    echo luxrio_theme_logo();
                echo '</div>';
                if( has_nav_menu( 'mobile-menu' ) ){
                    echo '<div class="vs-mobile-menu link-inherit">';
                        wp_nav_menu( array(
                            "theme_location"    => 'mobile-menu',
                            "container"         => '',
                            "menu_class"        => ''
                        ) );
                    echo '</div>';
                }
            echo '</div>';
        echo '</div>';

        echo '<div class="popup-search-box">';
            echo '<button class="searchClose"><i class="fas fa-times"></i></button>';
            echo '<form action="'.esc_url( home_url() ).'">';
                echo '<input name="s" type="text" placeholder="'.esc_attr__( 'What Are You Looking For', 'luxrio' ).'">';
                echo '<button type="submit" aria-label="search-button"><i class="fas fa-search"></i></button>';
            echo '</form>';
        echo '</div>';
    }
}

// luxrio woocommerce breadcrumb
function luxrio_woo_breadcrumb( $args ) {
    return array(
        'delimiter'   => '',
        'wrap_before' => '<ul class="breadcumb-menu">',
        'wrap_after'  => '</ul>',
        'before'      => '<li>',
        'after'       => '</li>',
        'home'        => _x( 'Home', 'breadcrumb', 'luxrio' ),
    );
}

add_filter( 'woocommerce_breadcrumb_defaults', 'luxrio_woo_breadcrumb' );



//Fire the wp_body_open action.
if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

//Remove Tag-Clouds inline style
add_filter( 'wp_generate_tag_cloud', 'luxrio_remove_tagcloud_inline_style',10,1 );
function luxrio_remove_tagcloud_inline_style( $input ){
   return preg_replace('/ style=("|\')(.*?)("|\')/','',$input );
}

// password protected form
add_filter('the_password_form','luxrio_password_form',10,1);
function luxrio_password_form( $output ) {
    $output = '<form action="' . esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post"><div class="theme-input-group">
        <input name="post_password" type="password" class="theme-input-style" placeholder="'.esc_attr__( 'Enter Password','luxrio' ).'">
        <button type="submit" class="submit-btn btn-fill">'.esc_html__( 'Enter','luxrio' ).'</button></div></form>';
    return $output;
}

function luxrio_setPostViews( $postID ) {
    $count_key  = 'post_views_count';
    $count      = get_post_meta( $postID, $count_key, true );
    if( $count == '' ){
        $count = 0;
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
    }else{
        $count++;
        update_post_meta( $postID, $count_key, $count );
    }
}

function luxrio_getPostViews( $postID ){
    $count_key  = 'post_views_count';
    $count      = get_post_meta( $postID, $count_key, true );
    if( $count == '' ){
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
        return __( '0', 'luxrio' );
    }
    return $count;
}


add_filter( 'wp_list_categories', 'luxrio_cat_count_span' );
function luxrio_cat_count_span( $links ) {
    $links = str_replace('</a> (', '</a> <span class="cat-item__number">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}

/* This code filters the Archive widget to include the post count inside the link */
add_filter( 'get_archives_link', 'luxrio_archive_count_span' );
function luxrio_archive_count_span( $links ) {
    $links = str_replace('</a>&nbsp;(', '</a> <span class="cat-item__number">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}

// Blog Category
if( ! function_exists( 'luxrio_blog_category' ) ){
    function luxrio_blog_category(){
        if( class_exists( 'ReduxFramework' ) ){
            $luxrio_display_post_category =  luxrio_opt('luxrio_display_post_category');
        }else{
            $luxrio_display_post_category = '1';
        }


        if( $luxrio_display_post_category ){
            $luxrio_post_categories = get_the_category();
            if( is_array( $luxrio_post_categories ) && ! empty( $luxrio_post_categories ) ){
                echo '<div class="blog-category ">';
                    echo ' <a href="'.esc_url( get_term_link( $luxrio_post_categories[0]->term_id ) ).'">'.esc_html( $luxrio_post_categories[0]->name ).'</a> ';
                echo '</div>';
            }
        }
    }
}

// Add Extra Class On Comment Reply Button
function luxrio_custom_comment_reply_link( $content ) {
    $extra_classes = 'replay-btn';
    return preg_replace( '/comment-reply-link/', 'comment-reply-link ' . $extra_classes, $content);
}

add_filter('comment_reply_link', 'luxrio_custom_comment_reply_link', 99);

// Add Extra Class On Edit Comment Link
function luxrio_custom_edit_comment_link( $content ) {
    $extra_classes = 'replay-btn';
    return preg_replace( '/comment-edit-link/', 'comment-edit-link ' . $extra_classes, $content);
}

add_filter('edit_comment_link', 'luxrio_custom_edit_comment_link', 99);


function luxrio_post_classes( $classes, $class, $post_id ) {
    if ( get_post_type() === 'post' ) {
        if( ! is_single() ){
            if( luxrio_opt( 'luxrio_blog_style' ) == '3' ){
                $classes[] = "vs-blog blog-style1 wow animate__fadeInUp wow-animated";
            }else{
                $classes[] = "vs-blog blog-style1 wow animate__fadeInUp wow-animated";
            }
        }else{
            $classes[] = "vs-blog blog-style1 blog-single";
        }
    }elseif( get_post_type() === 'product' ){
        // Return Class
    }elseif( get_post_type() === 'page' ){
        $classes[] = "page--item";
    }

    return $classes;
}
add_filter( 'post_class', 'luxrio_post_classes', 10, 3 );



function luxrio_megamenu_add_theme_luxrio_1737951828($themes) {
    $themes["luxrio_1737951828"] = array(
        'title' => 'Luxrio',
        'container_background_from' => 'rgba(0, 0, 0, 0)',
        'container_background_to' => 'rgba(255, 255, 255, 0)',
        'container_padding_left' => '24px',
        'container_padding_right' => '24px',
        'menu_item_align' => 'center',
        'menu_item_background_hover_from' => 'rgba(255, 255, 255, 0)',
        'menu_item_background_hover_to' => 'rgba(255, 255, 255, 0)',
        'menu_item_link_font_size' => '15px',
        'menu_item_link_height' => '82px',
        'menu_item_link_weight' => 'inherit',
        'menu_item_link_text_transform' => 'uppercase',
        'menu_item_link_color_hover' => 'rgb(255, 62, 1)',
        'menu_item_link_weight_hover' => 'inherit',
        'menu_item_link_padding_left' => '24px',
        'menu_item_link_padding_right' => '24px',
        'menu_item_highlight_current' => 'off',
        'panel_background_from' => 'rgb(255, 255, 255)',
        'panel_background_to' => 'rgb(255, 255, 255)',
        'panel_width' => '',
        'panel_inner_width' => '',
        'panel_border_color' => 'rgb(255, 62, 1)',
        'panel_border_bottom' => '3px',
        'panel_padding_left' => '20px',
        'panel_padding_right' => '20px',
        'panel_font_size' => '14px',
        'panel_font_color' => '#666',
        'panel_font_family' => 'inherit',
        'panel_second_level_font_color' => 'rgb(2, 18, 16)',
        'panel_second_level_font_color_hover' => 'rgb(2, 18, 16)',
        'panel_second_level_text_transform' => 'capitalize',
        'panel_second_level_font' => 'inherit',
        'panel_second_level_font_size' => '16px',
        'panel_second_level_font_weight' => 'bold',
        'panel_second_level_font_weight_hover' => 'bold',
        'panel_second_level_text_decoration' => 'none',
        'panel_second_level_text_decoration_hover' => 'none',
        'panel_second_level_padding_bottom' => '15px',
        'panel_second_level_margin_bottom' => '10px',
        'panel_second_level_border_color' => 'rgb(255, 62, 1)',
        'panel_second_level_border_color_hover' => 'rgb(255, 62, 1)',
        'panel_second_level_border_bottom' => '1px',
        'panel_third_level_font_color' => 'rgb(2, 18, 16)',
        'panel_third_level_font_color_hover' => 'rgb(255, 62, 1)',
        'panel_third_level_text_transform' => 'uppercase',
        'panel_third_level_font' => 'inherit',
        'panel_third_level_font_size' => '16px',
        'panel_third_level_font_weight' => 'inherit',
        'panel_third_level_font_weight_hover' => 'inherit',
        'panel_third_level_padding_top' => '4px',
        'panel_third_level_padding_bottom' => '4px',
        'flyout_width' => '190px',
        'flyout_menu_background_from' => 'rgb(255, 255, 255)',
        'flyout_menu_background_to' => 'rgb(255, 255, 255)',
        'flyout_border_color' => 'rgb(255, 62, 1)',
        'flyout_border_bottom' => '3px',
        'flyout_padding_top' => '18px',
        'flyout_padding_right' => '20px',
        'flyout_padding_bottom' => '18px',
        'flyout_padding_left' => '20px',
        'flyout_link_weight' => 'bold',
        'flyout_link_weight_hover' => 'bold',
        'flyout_background_from' => 'rgb(255, 255, 255)',
        'flyout_background_to' => 'rgb(255, 255, 255)',
        'flyout_background_hover_from' => 'rgba(221, 221, 221, 0)',
        'flyout_background_hover_to' => 'rgba(255, 255, 255, 0)',
        'flyout_link_size' => '16px',
        'flyout_link_color' => 'rgb(2, 18, 16)',
        'flyout_link_color_hover' => 'rgb(255, 62, 1)',
        'flyout_link_family' => 'inherit',
        'flyout_link_text_transform' => 'uppercase',
        'transitions' => 'on',
        'toggle_background_from' => '#222',
        'toggle_background_to' => '#222',
        'mobile_background_from' => '#222',
        'mobile_background_to' => '#222',
        'mobile_menu_item_link_font_size' => '14px',
        'mobile_menu_item_link_color' => '#ffffff',
        'mobile_menu_item_link_text_align' => 'left',
        'mobile_menu_item_link_color_hover' => '#ffffff',
        'mobile_menu_item_background_hover_from' => '#333',
        'mobile_menu_item_background_hover_to' => '#333',
        'custom_css' => '/** Push menu onto new line **/ 
#{$wrap} { 
    clear: both; 
}
#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link,#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link:hover,#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link:focus,#{$wrap} #{$menu} > li.mega-menu-item.mega-menu-megamenu ul.mega-sub-menu ul.mega-sub-menu {
    font-weight:700;
}',
    );
    return $themes;
}
add_filter("megamenu_themes", "luxrio_megamenu_add_theme_luxrio_1737951828");