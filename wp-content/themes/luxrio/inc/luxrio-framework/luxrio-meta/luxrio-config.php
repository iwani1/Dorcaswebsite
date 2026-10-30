<?php

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

 /**
 * Only return default value if we don't have a post ID (in the 'post' query variable)
 *
 * @param  bool  $default On/Off (true/false)
 * @return mixed          Returns true or '', the blank default
 */
function luxrio_set_checkbox_default_for_new_post( $default ) {
	return isset( $_GET['post'] ) ? '' : ( $default ? (string) $default : '' );
}

add_action( 'cmb2_admin_init', 'luxrio_register_metabox' );

/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */

function luxrio_register_metabox() {

	$prefix = '_luxrio_';

	$prefixpage = '_luxriopage_';

	$luxrio_post_meta = new_cmb2_box( array(
		'id'            => $prefixpage . 'blog_post_control',
		'title'         => esc_html__( 'Post Thumb Controller', 'luxrio' ),
		'object_types'  => array( 'post' ), // Post type
		'closed'        => true
	) );
	$luxrio_post_meta->add_field( array(
		'name' => esc_html__( 'Post Format Video', 'luxrio' ),
		'desc' => esc_html__( 'Use This Field When Post Format Video', 'luxrio' ),
		'id'   => $prefix . 'post_format_video',
        'type' => 'text_url',
    ) );
	$luxrio_post_meta->add_field( array(
		'name' => esc_html__( 'Post Format Audio', 'luxrio' ),
		'desc' => esc_html__( 'Use This Field When Post Format Audio', 'luxrio' ),
		'id'   => $prefix . 'post_format_audio',
        'type' => 'oembed',
    ) );
	$luxrio_post_meta->add_field( array(
		'name' => esc_html__( 'Post Thumbnail For Slider', 'luxrio' ),
		'desc' => esc_html__( 'Use This Field When You Want A Slider In Post Thumbnail', 'luxrio' ),
		'id'   => $prefix . 'post_format_slider',
        'type' => 'file_list',
    ) );

	$luxrio_page_meta = new_cmb2_box( array(
		'id'            => $prefixpage . 'page_meta_section',
		'title'         => esc_html__( 'Page Meta', 'luxrio' ),
		'object_types'  => array( 'page' ), // Post type
        'closed'        => true
    ) );

    $luxrio_page_meta->add_field( array(
		'name' => esc_html__( 'Page Breadcrumb Area', 'luxrio' ),
		'desc' => esc_html__( 'check to display page breadcrumb area.', 'luxrio' ),
		'id'   => $prefix . 'page_breadcrumb_area',
        'type' => 'select',
        'default' => '1',
        'options'   => array(
            '1'   => esc_html__('Show','luxrio'),
            '2'     => esc_html__('Hide','luxrio'),
        )
    ) );


    $luxrio_page_meta->add_field( array(
		'name' => esc_html__( 'Page Breadcrumb Settings', 'luxrio' ),
		'id'   => $prefix . 'page_breadcrumb_settings',
        'type' => 'select',
        'default'   => 'global',
        'options'   => array(
            'global'   => esc_html__( 'Global Settings', 'luxrio' ),
            'page'     => esc_html__( 'Page Settings', 'luxrio' ),
        )
	) );

	$luxrio_page_meta->add_field( array(
	    'name'    => esc_html__( 'Breadcumb Image', 'luxrio' ),
	    'desc'    => esc_html__( 'Upload an image or enter an URL.', 'luxrio' ),
	    'id'      => $prefix . 'breadcumb_image',
	    'type'    => 'file',
	    // Optional:
	    'options' => array(
	        'url' => false, // Hide the text input for the url
	    ),
	    'text'    => array(
	        'add_upload_file_text' => __( 'Add File', 'luxrio' ) // Change upload button text. Default: "Add or Upload File"
	    ),
	    'preview_size' => 'large', // Image size to use when previewing in the admin.
	) );

    $luxrio_page_meta->add_field( array(
		'name' => esc_html__( 'Page Title', 'luxrio' ),
		'desc' => esc_html__( 'check to display Page Title.', 'luxrio' ),
		'id'   => $prefix . 'page_title',
        'type' => 'select',
        'default' => '1',
        'options'   => array(
            '1'   	=> esc_html__( 'Show','luxrio'),
            '2'     => esc_html__( 'Hide','luxrio'),
        )
	) );

    $luxrio_page_meta->add_field( array(
		'name' => esc_html__( 'Page Title Settings', 'luxrio' ),
		'id'   => $prefix . 'page_title_settings',
        'type' => 'select',
        'options'   => array(
            'default'  => esc_html__('Default Title','luxrio'),
            'custom'  => esc_html__('Custom Title','luxrio'),
        ),
        'default'   => 'default'
    ) );

    $luxrio_page_meta->add_field( array(
		'name' => esc_html__( 'Custom Page Title', 'luxrio' ),
		'id'   => $prefix . 'custom_page_title',
        'type' => 'text'
    ) );

    $luxrio_page_meta->add_field( array(
		'name' => esc_html__( 'Breadcrumb', 'luxrio' ),
		'desc' => esc_html__( 'Select Show to display breadcrumb area', 'luxrio' ),
		'id'   => $prefix . 'page_breadcrumb_trigger',
        'type' => 'checkbox',
    ) );

    $luxrio_layout_meta = new_cmb2_box( array(
		'id'            => $prefixpage . 'page_layout_section',
		'title'         => esc_html__( 'Page Layout', 'luxrio' ),
        'context' 		=> 'side',
        'priority' 		=> 'high',
        'object_types'  => array( 'page' ), // Post type
        'closed'        => true
	) );

	$luxrio_layout_meta->add_field( array(
		'desc'       => esc_html__( 'Set page layout container,container fluid,fullwidth or both. It\'s work only in template builder page.', 'luxrio' ),
		'id'         => $prefix . 'custom_page_layout',
		'type'       => 'radio',
        'options' => array(
            '1' => esc_html__( 'Container', 'luxrio' ),
            '2' => esc_html__( 'Container Fluid', 'luxrio' ),
            '3' => esc_html__( 'Fullwidth', 'luxrio' ),
        ),
	) );
}

add_action( 'cmb2_admin_init', 'luxrio_register_taxonomy_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function luxrio_register_taxonomy_metabox() {

    $prefix = '_luxrio_';
	/**
	 * Metabox to add fields to categories and tags
	 */
	$luxrio_term_meta = new_cmb2_box( array(
		'id'               => $prefix.'term_edit',
		'title'            => esc_html__( 'Category Metabox', 'luxrio' ),
		'object_types'     => array( 'term' ),
		'taxonomies'       => array( 'category'),
	) );
	$luxrio_term_meta->add_field( array(
		'name'     => esc_html__( 'Extra Info', 'luxrio' ),
		'id'       => $prefix.'term_extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );
	$luxrio_term_meta->add_field( array(
		'name' => esc_html__( 'Category Image', 'luxrio' ),
		'desc' => esc_html__( 'Set Category Image', 'luxrio' ),
		'id'   => $prefix.'term_avatar',
        'type' => 'file',
        'text'    => array(
			'add_upload_file_text' => esc_html__('Add Image','luxrio') // Change upload button text. Default: "Add or Upload File"
		),
	) );
	

	

	/**
	 * Metabox to add fields to class widget
	 */
	
	 $luxrio_term_class = new_cmb2_box( array(
		'id'               => $prefix.'class',
		'title'            => esc_html__( 'class Metabox', 'luxrio' ),
		'object_types'     => array( 'luxrio_class' ),
	) );

	$luxrio_term_class->add_field( array(
		'name'     => esc_html__( 'Class Info', 'luxrio' ),
		'id'       => $prefix.'class_list',
		'type'     => 'wysiwyg',
		'default'  => esc_html__( '11 - 13 Years','luxrio' ),
	) );


	$luxrio_term_class->add_field( array(
		'name'     => esc_html__( 'Price', 'luxrio' ),
		'id'       => $prefix.'class_price',
		'type'     => 'text',
		'default'  => esc_html__( '$29','luxrio' ),
	) );
	
	$luxrio_term_class->add_field( array(
		'name'     => esc_html__( 'Duration', 'luxrio' ),
		'id'       => $prefix.'class_duration',
		'type'     => 'text',
		'default'  => esc_html__( '/ month','luxrio' ),
	) );


	/**
	 * Metabox to add fields to Teachers widget
	 */
	
	 $luxrio_term_teachers = new_cmb2_box( array(
		'id'               => $prefix.'teachers',
		'title'            => esc_html__( 'Teachers Metabox', 'luxrio' ),
		'object_types'     => array( 'luxrio_teacher' ),
	) );

	$luxrio_term_teachers->add_field( array(
		'name'     => esc_html__( 'Designation', 'luxrio' ),
		'id'       => $prefix.'teachers_designation',
		'type'     => 'text',
		'default'  => esc_html__( 'Principal and Manager','luxrio' ),
	) );

	$luxrio_term_teachers->add_field( array(
		'name'     => esc_html__( 'Phone Number', 'luxrio' ),
		'id'       => $prefix.'teachers_number',
		'type'     => 'text',
		'default'  => esc_html__( '+44 (0) 207 689 7888','luxrio' ),
	) );

	$profiles_group = $luxrio_term_teachers->add_field( array(
        'id'          => $prefix . 'profiles',
        'type'        => 'group',
        'description' => __( 'Add social profiles', 'luxrio' ),
        'options'     => array(
            'group_title'   => __( 'Profile {#}', 'luxrio' ),
            'add_button'    => __( 'Add Another Profile', 'luxrio' ),
            'remove_button' => __( 'Remove Profile', 'luxrio' ),
            'sortable'      => true,
        ),
    ) );

    // Add fields to the repeatable group
    $luxrio_term_teachers->add_group_field( $profiles_group, array(
        'name' => __( 'Social Network', 'luxrio' ),
        'id'   => 'network',
        'type' => 'text',
    ) );

    $luxrio_term_teachers->add_group_field( $profiles_group, array(
        'name' => __( 'Profile URL', 'luxrio' ),
        'id'   => 'url',
        'type' => 'text_url',
    ) );

}
