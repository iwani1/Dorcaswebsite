<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\Repeater;
/**
 *
 * Image Widget .
 *
 */
class Luxrio_View_Card extends Widget_Base {

	public function get_name() {
		return 'luxrioviewcard';
	}
     
	public function get_title() {
		return __( 'View Card', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';    
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

	protected function register_controls() {

		
		$this->start_controls_section(
			'image_section',
			[
				'label' 	=> __( 'View Card', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'viewcard_layout',
			[
				'label' => __( 'Style', 'luxrio' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => __( 'Style 1', 'luxrio' ),
					'2' => __( 'Style 2', 'luxrio' ),
					'3' => __( 'Style 3', 'luxrio' ),
				],
			]
		);
		// img start
        $this->add_control(
			'image_one',
			[
				'label' 		=> __( 'Image One', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'image_two', 
			[
				'label' 		=> __( 'Image Two', 'luxrio' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> [
					'active' 		=> true,
				],
				'default' 		=> [
					'url' 			=> Utils::get_placeholder_image_src(),
				],
                'condition'     => [
                    'viewcard_layout' => '1',
                ]
			]
		);

		$this->add_control(
			'image_caption',
			[
				'label' 	=> __( 'Image Caption', 'luxrio' ),
				'type' 		=> Controls_Manager::TEXTAREA,
				'default'  	=> __( 'Top Categories', 'luxrio' ),
				'label_block' 	=> true,
			]
		);
		$this->add_control(
			'button_text',
			[
				'label' 	=> __( 'Button Text', 'luxrio' ),
				'type' 		=> Controls_Manager::TEXTAREA,
				'default'  	=> __( 'Shop Now', 'luxrio' ),
				'label_block' 	=> true,
                'condition'     => [
                    'viewcard_layout' => '1',
                ]
			]
		);
		$this->add_control(
			'details_url',
			[
				'label' 	=> __( 'Details Url?', 'luxrio' ),
				'type' 		=> Controls_Manager::TEXTAREA,
				'default'  	=> __( '#', 'luxrio' ),
				'label_block' 	=> true,
			]
		);

		$this->end_controls_section();

		// 
		$this->start_controls_section(
			'style_section',
			[
				'label' 	=> __( 'Content Style', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'title_color',
			[
				'label' 		=> __( 'Title Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .view-style .view-content .view-title, {{WRAPPER}} .view-style .view-title2 a' => 'color: {{VALUE}}',
                ]
			]
        );
		$this->add_control(
			'title_hover_color',
			[
				'label' 		=> __( 'Title Hover Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .view-style .view-content .view-title, {{WRAPPER}} .view-style .view-title2 a:hover' => 'color: {{VALUE}}',
                ]
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'title_typography',
				'label'         => __( 'Title Typography', 'luxrio' ),
                'selector'      => '{{WRAPPER}} .view-style .view-content .view-title, {{WRAPPER}} .view-style .view-title2',
			]
		);

		
		$this->end_controls_section();
	}

	protected function render() {

        $settings = $this->get_settings_for_display();
		$viewcard = $settings[ 'viewcard_layout' ];
		
        if( $viewcard == '1' ){
            echo '<div class="view-style item1">';
                if( ! empty( $settings['image_one']['url'] ) ){
                    echo luxrio_img_tag( array(
                        'url'   => esc_url( $settings['image_one']['url'] ),
                    ) );
                }

                echo '<div class="view-content">';
                    if( ! empty( $settings['image_two']['url'] ) ){
                        echo luxrio_img_tag( array(
                            'url'   => esc_url( $settings['image_two']['url'] ),
                            'class' =>'shape1'
                        ) );
                    }
                    
                    if( ! empty( $settings['image_caption'] ) ){
                        echo '<h2 class="view-title">'.esc_html( $settings['image_caption'] ).'</h2>';
                    }
                    if( ! empty( $settings['button_text'] ) ){
                        echo '<a class="view-link" href="'.esc_url( $settings['details_url'] ).'">'.esc_html( $settings['button_text'] ).'<i class="fa-solid fa-angles-right"></i></a>';
                    }

                echo '</div>';
            echo '</div>';
        }elseif( $viewcard == '2' ){
            echo '<div class="view-style item2">';
                if( ! empty( $settings['image_one']['url'] ) ){
                    echo luxrio_img_tag( array(
                        'url'   => esc_url( $settings['image_one']['url'] ),
                    ) );
                }
                if( ! empty( $settings['image_caption'] ) ){
                    echo '<h2 class="view-title2"><a href="'.esc_url( $settings['details_url'] ).'">'.esc_html( $settings['image_caption'] ).'</a></h2>';
                }

            echo '</div>';
        }else{
            echo '<div class="view-style item4">';
                if( ! empty( $settings['image_one']['url'] ) ){
                    echo luxrio_img_tag( array(
                        'url'   => esc_url( $settings['image_one']['url'] ),
                    ) );
                }
                if( ! empty( $settings['image_caption'] ) ){
                    echo '<h2 class="view-title2">';
                        echo '<a href="'.esc_url( $settings['details_url'] ).'">';
                            echo esc_html( $settings['image_caption'] );
                            echo '<span>';
                                echo '<svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">';
                                    echo '<line y1="8.25" x2="19" y2="8.25" stroke="white" stroke-width="1.5" />';
                                    echo '<line x1="9.75" y1="3.27836e-08" x2="9.75" y2="17" stroke="white" stroke-width="1.5" />';
                                echo '</svg>';
                            echo '</span>';
                        echo '</a>';
                    echo '</h2>';
                }
            echo '</div>';
        }

	}
}
$widgets_manager->register( new \Luxrio_View_Card() );