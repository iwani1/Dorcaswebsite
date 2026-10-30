<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

    /**
     * Class For Builder
     */
    class LuxrioBuilder{

        function __construct(){
            // register admin menus
        	add_action( 'admin_menu', [$this, 'register_settings_menus'] );

            // Custom Footer Builder With Post Type
			add_action( 'init',[ $this,'post_type' ],0 );

 		    add_action( 'elementor/frontend/after_enqueue_scripts', [ $this,'widget_scripts'] );

			add_filter( 'single_template', [ $this, 'load_canvas_template' ] );

            add_action( 'elementor/element/wp-page/document_settings/after_section_end', [ $this,'luxrio_add_elementor_page_settings_controls' ],10,2 );

		}

		public function widget_scripts( ) {
			wp_enqueue_script( 'luxrio-core',LUXRIO_PLUGDIRURI.'assets/js/luxrio-core.js',array( 'jquery' ),'1.0',true );
		}


        public function luxrio_add_elementor_page_settings_controls( \Elementor\Core\DocumentTypes\Page $page ){

			$page->start_controls_section(
                'luxrio_header_option',
                [
                    'label'     => __( 'Header Option', 'luxrio' ),
                    'tab'       => \Elementor\Controls_Manager::TAB_SETTINGS,
                ]
            );


            $page->add_control(
                'luxrio_header_style',
                [
                    'label'     => __( 'Header Option', 'luxrio' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => [
    					'prebuilt'             => __( 'Pre Built', 'luxrio' ),
    					'header_builder'       => __( 'Header Builder', 'luxrio' ),
    				],
                    'default'   => 'prebuilt',
                ]
			);

            $page->add_control(
                'luxrio_header_builder_option',
                [
                    'label'     => __( 'Header Name', 'luxrio' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => $this->luxrio_header_choose_option(),
                    'condition' => [ 'luxrio_header_style' => 'header_builder'],
                    'default'	=> ''
                ]
            );

            $page->end_controls_section();

            $page->start_controls_section(
                'luxrio_footer_option',
                [
                    'label'     => __( 'Footer Option', 'luxrio' ),
                    'tab'       => \Elementor\Controls_Manager::TAB_SETTINGS,
                ]
            );
            $page->add_control(
    			'luxrio_footer_choice',
    			[
    				'label'         => __( 'Enable Footer?', 'luxrio' ),
    				'type'          => \Elementor\Controls_Manager::SWITCHER,
    				'label_on'      => __( 'Yes', 'luxrio' ),
    				'label_off'     => __( 'No', 'luxrio' ),
    				'return_value'  => 'yes',
    				'default'       => 'yes',
    			]
    		);
            $page->add_control(
                'luxrio_footer_style',
                [
                    'label'     => __( 'Footer Style', 'luxrio' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => [
    					'prebuilt'             => __( 'Pre Built', 'luxrio' ),
    					'footer_builder'       => __( 'Footer Builder', 'luxrio' ),
    				],
                    'default'   => 'prebuilt',
                    'condition' => [ 'luxrio_footer_choice' => 'yes' ],
                ]
            );
            $page->add_control(
                'luxrio_footer_builder_option',
                [
                    'label'     => __( 'Footer Name', 'luxrio' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => $this->luxrio_footer_choose_option(),
                    'condition' => [ 'luxrio_footer_style' => 'footer_builder','luxrio_footer_choice' => 'yes' ],
                    'default'	=> ''
                ]
            );

			$page->end_controls_section();

        }

		public function register_settings_menus(){
			add_menu_page(
				esc_html__( 'Luxrio Builder', 'luxrio' ),
            	esc_html__( 'Luxrio Builder', 'luxrio' ),
				'manage_options',
				'luxrio',
				[$this,'register_settings_contents__settings'],
				'dashicons-admin-site',
				2
			);

			add_submenu_page('luxrio', esc_html__('Footer Builder', 'luxrio'), esc_html__('Footer Builder', 'luxrio'), 'manage_options', 'edit.php?post_type=luxrio_footer');
			add_submenu_page('luxrio', esc_html__('Header Builder', 'luxrio'), esc_html__('Header Builder', 'luxrio'), 'manage_options', 'edit.php?post_type=luxrio_header');
			add_submenu_page('luxrio', esc_html__('Tab Builder', 'luxrio'), esc_html__('Tab Builder', 'luxrio'), 'manage_options', 'edit.php?post_type=luxrio_tab_build');
			add_submenu_page('luxrio', esc_html__('OFF Canvas Builder', 'luxrio'), esc_html__('OFF Canvas Builder', 'luxrio'), 'manage_options', 'edit.php?post_type=luxrio_off_build');
		}

		// Callback Function
		public function register_settings_contents__settings(){
            echo '<h2>';
			    echo esc_html__( 'Welcome To Header And Footer Builder Of This Theme','luxrio' );
            echo '</h2>';
		}

		public function post_type() {

			$labels = array(
				'name'               => __( 'Footer', 'luxrio' ),
				'singular_name'      => __( 'Footer', 'luxrio' ),
				'menu_name'          => __( 'Luxrio Footer Builder', 'luxrio' ),
				'name_admin_bar'     => __( 'Footer', 'luxrio' ),
				'add_new'            => __( 'Add New', 'luxrio' ),
				'add_new_item'       => __( 'Add New Footer', 'luxrio' ),
				'new_item'           => __( 'New Footer', 'luxrio' ),
				'edit_item'          => __( 'Edit Footer', 'luxrio' ),
				'view_item'          => __( 'View Footer', 'luxrio' ),
				'all_items'          => __( 'All Footer', 'luxrio' ),
				'search_items'       => __( 'Search Footer', 'luxrio' ),
				'parent_item_colon'  => __( 'Parent Footer:', 'luxrio' ),
				'not_found'          => __( 'No Footer found.', 'luxrio' ),
				'not_found_in_trash' => __( 'No Footer found in Trash.', 'luxrio' ),
			);

			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'rewrite'             => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'elementor' ),
			);

			register_post_type( 'luxrio_footer', $args );

			$labels = array(
				'name'               => __( 'Header', 'luxrio' ),
				'singular_name'      => __( 'Header', 'luxrio' ),
				'menu_name'          => __( 'Luxrio Header Builder', 'luxrio' ),
				'name_admin_bar'     => __( 'Header', 'luxrio' ),
				'add_new'            => __( 'Add New', 'luxrio' ),
				'add_new_item'       => __( 'Add New Header', 'luxrio' ),
				'new_item'           => __( 'New Header', 'luxrio' ),
				'edit_item'          => __( 'Edit Header', 'luxrio' ),
				'view_item'          => __( 'View Header', 'luxrio' ),
				'all_items'          => __( 'All Header', 'luxrio' ),
				'search_items'       => __( 'Search Header', 'luxrio' ),
				'parent_item_colon'  => __( 'Parent Header:', 'luxrio' ),
				'not_found'          => __( 'No Header found.', 'luxrio' ),
				'not_found_in_trash' => __( 'No Header found in Trash.', 'luxrio' ),
			);

			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'rewrite'             => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'elementor' ),
			);

			register_post_type( 'luxrio_header', $args );

            $labels = array(
				'name'               => __( 'Tab Builder', 'luxrio' ),
				'singular_name'      => __( 'Tab Builder', 'luxrio' ),
				'menu_name'          => __( 'Luxrio Tab Builder', 'luxrio' ),
				'name_admin_bar'     => __( 'Tab Builder', 'luxrio' ),
				'add_new'            => __( 'Add New', 'luxrio' ),
				'add_new_item'       => __( 'Add New Tab Builder', 'luxrio' ),
				'new_item'           => __( 'New Tab Builder', 'luxrio' ),
				'edit_item'          => __( 'Edit Tab Builder', 'luxrio' ),
				'view_item'          => __( 'View Tab Builder', 'luxrio' ),
				'all_items'          => __( 'All Tab Builder', 'luxrio' ),
				'search_items'       => __( 'Search Tab Builder', 'luxrio' ),
				'parent_item_colon'  => __( 'Parent Tab Builder:', 'luxrio' ),
				'not_found'          => __( 'No Tab Builder found.', 'luxrio' ),
				'not_found_in_trash' => __( 'No Tab Builder found in Trash.', 'luxrio' ),
			);

			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'rewrite'             => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'elementor' ),
			);
			register_post_type( 'luxrio_tab_build', $args );

			//Off Canvas builder
            $labels = array(
				'name'               => __( 'Off Canvas Builder', 'luxrio' ),
				'singular_name'      => __( 'Off Canvas Builder', 'luxrio' ),
				'menu_name'          => __( 'Luxrio Off Canvas Builder', 'luxrio' ),
				'name_admin_bar'     => __( 'Off Canvas Builder', 'luxrio' ),
				'add_new'            => __( 'Add New', 'luxrio' ),
				'add_new_item'       => __( 'Add New Off Canvas Builder', 'luxrio' ),
				'new_item'           => __( 'New Off Canvas Builder', 'luxrio' ),
				'edit_item'          => __( 'Edit Off Canvas Builder', 'luxrio' ),
				'view_item'          => __( 'View Off Canvas Builder', 'luxrio' ),
				'all_items'          => __( 'All Off Canvas Builder', 'luxrio' ),
				'search_items'       => __( 'Search Off Canvas Builder', 'luxrio' ),
				'parent_item_colon'  => __( 'Parent Off Canvas Builder:', 'luxrio' ),
				'not_found'          => __( 'No Off Canvas Builder found.', 'luxrio' ),
				'not_found_in_trash' => __( 'No Off Canvas Builder found in Trash.', 'luxrio' ),
			);

			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'rewrite'             => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'elementor' ),
			);
			register_post_type( 'luxrio_off_build', $args );

		}

		function load_canvas_template( $single_template ) {

			global $post;

			if ( 'luxrio_footer' == $post->post_type || 'luxrio_header' == $post->post_type || 'luxrio_tab_build' == $post->post_type || 'luxrio_off_build' == $post->post_type  ) {

				$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

				if ( file_exists( $elementor_2_0_canvas ) ) {
					return $elementor_2_0_canvas;
				} else {
					return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
				}
			}

			return $single_template;
		}

        public function luxrio_footer_choose_option(){

			$luxrio_post_query = new WP_Query( array(
				'post_type'			=> 'luxrio_footer',
				'posts_per_page'	    => -1,
			) );

			$luxrio_builder_post_title = array();
			$luxrio_builder_post_title[''] = __('Select a Footer','Luxrio');

			while( $luxrio_post_query->have_posts() ) {
				$luxrio_post_query->the_post();
				$luxrio_builder_post_title[ get_the_ID() ] =  get_the_title();
			}
			wp_reset_postdata();

			return $luxrio_builder_post_title;

		}

		public function luxrio_header_choose_option(){

			$luxrio_post_query = new WP_Query( array(
				'post_type'			=> 'luxrio_header',
				'posts_per_page'	    => -1,
			) );

			$luxrio_builder_post_title = array();
			$luxrio_builder_post_title[''] = __('Select a Header','Luxrio');

			while( $luxrio_post_query->have_posts() ) {
				$luxrio_post_query->the_post();
				$luxrio_builder_post_title[ get_the_ID() ] =  get_the_title();
			}
			wp_reset_postdata();

			return $luxrio_builder_post_title;

        }

    }

    $builder_execute = new LuxrioBuilder();