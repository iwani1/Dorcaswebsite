<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;
/**
 *
 * Tab Builder Widget .
 *
 */
class Luxrio_Tab_Builder extends Widget_Base {

	public function get_name() {
		return 'luxriotabbuilder';
	}

	public function get_title() {
		return __( 'Tab Builder', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	protected function register_controls() {

		$this->start_controls_section(
			'tab_builder_title_section',
			[
				'label' 	=> __( 'Tab Builder', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_builder_number',
			[
				'label' 	=> __( 'Tab Builder Number', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( '01.', 'luxrio' )
			]
        );

        $repeater->add_control(
			'tab_builder_title',
			[
				'label' 	=> __( 'Tab Builder Title', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Digital Marketing', 'luxrio' )
			]
        );

        $repeater->add_control(
			'tab_builder_title_subtitle',
			[
				'label' 	=> __( 'Tab Builder SubTitle', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( '259 Jobs Done', 'luxrio' )
			]
        );

		$repeater->add_control(
			'luxrio_tab_builder_title_option',
			[
				'label'     => __( 'Select Data', 'luxrio' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => $this->luxrio_tab_builder_title_choose_option(),
				'default'	=> ''
			]
		);

		$this->add_control(
			'tab_builder_title_repeater',
			[
				'label' 		=> __( 'Tab', 'luxrio' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'tab_builder_title'       => __( 'North West Redwater Refinery', 'luxrio' ),
						'tab_builder_subtitle'    => __( '259 Jobs Done', 'luxrio' ),
					],
					[
						'tab_builder_title'       => __( 'Road Construction', 'luxrio' ),
						'tab_builder_subtitle'    => __( '403 Jobs Done', 'luxrio' ),
					],
					[
						'tab_builder_title'       => __( 'Atmosphere Affordable Housing', 'luxrio' ),
						'tab_builder_subtitle'    => __( '105 Jobs Done', 'luxrio' ),
					],
					[
						'tab_builder_title'       => __( 'The Boulevard at West River', 'luxrio' ),
						'tab_builder_subtitle'    => __( '1259 Jobs Done', 'luxrio' ),
					],
				],
				'title_field' 	=> '{{{ tab_builder_title }}}',
			]
		);

        $this->end_controls_section();

		// title
		$this->start_controls_section(
			'general',
			[
				'label' 	=> __( 'General Style', 'luxrio' ),
                'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'tab_active_bg_color',
			[
				'label' 	=> __( 'Tab Active Background Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .project-tabbtn--style.active .project-tabbtn__number,{{WRAPPER}} .project-tabbtn--style:hover .project-tabbtn__number' => 'background-color: {{VALUE}}',
                ],
			]
        );
        $this->add_control(
			'tab_active_text_color',
			[
				'label' 	=> __( 'Tab Active Text background Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-pills .nav-link.active,{{WRAPPER}}  .nav-pills .nav-link:hover' => 'background-color: {{VALUE}}',
                ],
			]
        );
        $this->add_control(
			'title_text_color',
			[
				'label' 	=> __( 'Title Text Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .project-tabbtn--style .project-tabbtn__name' => 'color: {{VALUE}}',
                ],
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'title_typography',
				'label' 		=> __( 'Typography', 'luxrio' ),
                'selector' 		=> '{{WRAPPER}} .project-tabbtn--style .project-tabbtn__name',
			]
		);
		
        $this->end_controls_section();

    }

	public function luxrio_tab_builder_title_choose_option(){

		$luxrio_post_query = new WP_Query( array(
			'post_type'				=> 'luxrio_tab_build',
			'posts_per_page'	    => -1,
		) );

		$luxrio_tab_builder_title = array();
		$luxrio_tab_builder_title[''] = __( 'Select a Title','Luxrio');

		while( $luxrio_post_query->have_posts() ) {
			$luxrio_post_query->the_post();
			$luxrio_tab_builder_title[ get_the_ID() ] =  get_the_title();
		}
		wp_reset_postdata();

		return $luxrio_tab_builder_title;

	}

	protected function render() {

        $settings = $this->get_settings_for_display();
		
		echo '<div class="project--layout2 overflow-hidden">';
			echo '<div class="container">';
				echo '<div class="row gx-0 align-items-center">';
					echo '<div class="col-xl-8 project__col">';
						echo '<div class="nav flex-column nav-pills" id="nav-tabservice" role="tablist" aria-orientation="vertical">';
							$x = 0;
							foreach( $settings['tab_builder_title_repeater'] as $single_menu ){
								if( $x == 0 ){
									$active = 'active';
									$area   = 'true';
								}else{
									$active = '';
									$area   = 'false';
								}
								echo '<button class="nav-link project-tabbtn--style '.esc_attr( $active ).'" id="nav-digitalmarketing-tab'.$x.'" data-bs-toggle="tab" data-bs-target="#nav-digitalmarketing'.$x.'" type="button" role="tab" aria-controls="nav-digitalmarketing'.$x.'" aria-selected="'.esc_attr( $area ).'">';
									if( $single_menu['tab_builder_number'] ){
										echo '<span class="project-tabbtn__number">';
											echo esc_html( $single_menu['tab_builder_number'] );
										echo '</span>';
									}
									echo '<span class="project-tabbtn__content">';
										if( $single_menu['tab_builder_title'] ){
											echo '<span class="project-tabbtn__name">'.esc_html( $single_menu['tab_builder_title'] ).'</span>';
										}
										if( ! empty( $single_menu['tab_builder_title_subtitle'] ) ){
											echo '<span class="project-tabbtn__location">'.wp_kses_post( $single_menu['tab_builder_title_subtitle'] ).'</span>';
										}
									echo '</span>';
								echo '</button>';
							$x++;
							}
						echo '</div>';
					echo '</div>';
					echo '<div class="col-xl-4 project__col">';
						echo '<div class="tab-content" id="nav-tabserviceContent">';
							$x = 0;
							foreach( $settings['tab_builder_title_repeater'] as $single_menu ){
								if( $x == 0 ){
									$active = 'active';
								}else{
									$active = '';
								}
								$elementor = \Elementor\Plugin::instance();
								if( ! empty( $single_menu['luxrio_tab_builder_title_option'] ) ){
									echo '<div class="tab-pane fade show '.esc_attr( $active ).'" id="nav-digitalmarketing'.$x.'" role="tabpanel" aria-labelledby="nav-digitalmarketing-tab'.$x.'">';
										echo $elementor->frontend->get_builder_content_for_display( $single_menu['luxrio_tab_builder_title_option'] );
									echo '</div>';
								}
							$x++;
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}

}


$widgets_manager->register( new \Luxrio_Tab_Builder() );