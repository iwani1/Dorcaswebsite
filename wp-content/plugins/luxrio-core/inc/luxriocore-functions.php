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
        exit();
    }

/**
 * Admin Custom Login Logo
 */
function luxrio_custom_login_logo() {
  $logo = ! empty( luxrio_opt( 'luxrio_admin_login_logo', 'url' ) ) ? luxrio_opt( 'luxrio_admin_login_logo', 'url' ) : '' ;
  if( isset( $logo ) && !empty( $logo ) )
      echo '<style type="text/css">body.login div#login h1 a { background-image:url('.esc_url( $logo ).'); }</style>';
}
add_action( 'login_enqueue_scripts', 'luxrio_custom_login_logo' );

/**
* Admin Custom css
*/
add_action( 'admin_enqueue_scripts', 'luxrio_admin_styles' );

function luxrio_admin_styles() {
  // $luxrio_admin_custom_css = ! empty( luxrio_opt( 'luxrio_theme_admin_custom_css' ) ) ? luxrio_opt( 'luxrio_theme_admin_custom_css' ) : '';
  if ( ! empty( $luxrio_admin_custom_css ) ) {
      $luxrio_admin_custom_css = str_replace(array("\r\n", "\r", "\n", "\t", '    '), '', $luxrio_admin_custom_css);
      echo '<style rel="stylesheet" id="luxrio-admin-custom-css" >';
              echo esc_html( $luxrio_admin_custom_css );
      echo '</style>';
  }
}

 // share button code
 function luxrio_social_sharing_buttons( ) {

  // Get page URL
  $URL = get_permalink();
  $Sitetitle = get_bloginfo('name');

  // Get page title
  $Title = str_replace( ' ', '%20', get_the_title());


  // Construct sharing URL without using any script

  $twitterURL = 'https://twitter.com/share?text='.esc_html( $Title ).'&url='.esc_url( $URL );
  $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.esc_url( $URL );
  $pinteresturl = 'http://pinterest.com/pin/create/link/?url='.esc_url( $URL ).'&media='.esc_url(get_the_post_thumbnail_url()).'&description='.wp_kses_post(get_the_title());
  $linkedin = 'https://www.linkedin.com/shareArticle?mini=true&url='.esc_url( $URL ).'&title='.esc_html( $Title );


  // Add sharing button at the end of page/page content
$content = '';

  $content .= '<a class="facebook" href="'.esc_url( $facebookURL ).'" target="_blank">'.esc_html__( 'FB','luxrio' ).'</a>';
  $content .= '<a class="twitter" href="'. esc_url( $twitterURL ) .'" target="_blank">'.esc_html__( 'X','luxrio' ).'</a>';
  $content .= '<a class="instagram" href="'.esc_url( $pinteresturl ).'" target="_blank">'.esc_html__( 'PIN','luxrio' ).'</a>';
  $content .= '<a class="linkedin" href="'.esc_url( $linkedin ).'" target="_blank">'.esc_html__( 'LI','luxrio' ).'</a>';
  return $content;
}
 // share button code
 function luxrio_social_sharing_buttons_woocommerce( ) {

    // Get page URL
    $URL = get_permalink();
    $Sitetitle = get_bloginfo('name');
  
    // Get page title
    $Title = str_replace( ' ', '%20', get_the_title());
  
  
    // Construct sharing URL without using any script
  
    $twitterURL = 'https://twitter.com/share?text='.esc_html( $Title ).'&url='.esc_url( $URL );
    $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.esc_url( $URL );
    $pinteresturl = 'http://pinterest.com/pin/create/link/?url='.esc_url( $URL ).'&media='.esc_url(get_the_post_thumbnail_url()).'&description='.wp_kses_post(get_the_title());
    $linkedin = 'https://www.linkedin.com/shareArticle?mini=true&url='.esc_url( $URL ).'&title='.esc_html( $Title );
  
  
    // Add sharing button at the end of page/page content
  $content = '';
    $content .= '<span>'.esc_html__( 'Share:' );
    $content .= '<a class="facebook" href="'.esc_url( $facebookURL ).'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
    $content .= '<a class="twitter" href="'. esc_url( $twitterURL ) .'" target="_blank"><i class="fab fa-instagram"></i></a>';
    $content .= '<a class="instagram" href="'.esc_url( $pinteresturl ).'" target="_blank"><i class="fab fa-twitter"></i></a>';
    $content .= '<a class="linkedin" href="'.esc_url( $linkedin ).'" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
    $content .= '</span>';
    return $content;
  }
//add SVG to allowed file uploads
function luxrio_mime_types( $mimes ) {
  $mimes['svg'] = 'image/svg+xml';
  $mimes['svgz'] = 'image/svgz+xml';
  $mimes['exe'] = 'program/exe';
  $mimes['dwg'] = 'image/vnd.dwg';
  return $mimes;
}
add_filter('upload_mimes', 'luxrio_mime_types');

function luxrio_wp_check_filetype_and_ext( $data, $file, $filename, $mimes ) {
    $wp_filetype = wp_check_filetype( $filename, $mimes );
    $ext         = $wp_filetype['ext'];
    $type        = $wp_filetype['type'];
    $proper_filename = $data['proper_filename'];

    return compact( 'ext', 'type', 'proper_filename' );
}
add_filter('wp_check_filetype_and_ext','luxrio_wp_check_filetype_and_ext',10,4);

if( ! function_exists('luxrio_get_user_role_name') ){
    function luxrio_get_user_role_name( $user_ID ){
        global $wp_roles;

        $user_data      = get_userdata( $user_ID );
        $user_role_slug = $user_data->roles[0];
        return translate_user_role( $wp_roles->roles[$user_role_slug]['name'] );
    }
}


add_filter('wpcf7_autop_or_not', '__return_false');

add_image_size( 'blog-sidebar-size-thumb',70,70,true );
add_image_size( 'product-image',303,353,true );
add_image_size( 'product-image-two',295,295,true );
add_image_size( 'product-image-three',265,245,true );
add_image_size( 'product-image-four',218,240,true );
add_image_size( 'blog-post-one',413,319,true );




/**
* Enqueue block editor JavaScript and CSS
*/
function luxrio_widget_editor_scripts() {

  // Make paths variables so we don't write em twice 
  // $blockPath = '../assets/js/blocks.js';

  
  // Enqueue the bundled block JS file
  wp_enqueue_script(
      'luxrio-blocks-js', LUXRIO_PLUGDIRURI . 'assets/js/blocks.js',
      [  'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n' ],
      '1.00',
      true
  );
}
// Hook scripts function into block editor hook
add_action( 'enqueue_block_editor_assets', 'luxrio_widget_editor_scripts' );


/**
 * Post orderby list
 */
function luxrio_get_post_orderby_options()
{
    $orderby = array(
        'ID' => 'Post ID',
        'author' => 'Post Author',
        'title' => 'Title',
        'date' => 'Date',
        'modified' => 'Last Modified Date',
        'parent' => 'Parent Id',
        'rand' => 'Random',
        'comment_count' => 'Comment Count',
        'menu_order' => 'Menu Order',
    );
    $orderby = apply_filters('luxrio_post_orderby', $orderby);
    return $orderby;
}

/**
 * Get Posts
 *
 * @since 1.0
 *
 * @return array
 */
if ( ! function_exists( 'luxrio_get_all_posts' ) ) {
    function luxrio_get_all_posts($posttype)
    {
        $args = array(
            'post_type' => $posttype,
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $post_list = array();
        if( $data = get_posts($args)){
            foreach($data as $key){
                $post_list[$key->ID] = $key->post_title;
            }
        }
        return  $post_list;
    }
}


/**
 * Responsive Column Order
 *
 */
function luxrio_add_responsive_column_order( $element, $args ) {
	$element->add_responsive_control(
		'responsive_column_order',
		[
			'label' => __( 'Responsive Column Order', 'luxrio' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'separator' => 'before',
			'selectors' => [
				'{{WRAPPER}}' => '-webkit-order: {{VALUE}}; -ms-flex-order: {{VALUE}}; order: {{VALUE}};',
			],
		]
	);
}
add_action( 'elementor/element/column/layout/before_section_end', 'luxrio_add_responsive_column_order', 10, 2 );



function add_svg_to_upload_mimes( $upload_mimes ) {
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';
    return $upload_mimes;
}
add_filter( 'upload_mimes', 'add_svg_to_upload_mimes', 10, 1 );
 