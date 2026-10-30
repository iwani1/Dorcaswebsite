<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Utils;
use \Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Faq Widget .
 *
 */
class Luxrio_Faq extends Widget_Base {

	public function get_name() {
		return 'luxriofaq';
	}

	public function get_title() {
		return __( 'Faq', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'faq_section',
			[
				'label'		 	=> __( 'Faq', 'luxrio' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
        );
		
        $repeater = new Repeater();

        $repeater->add_control(
			'faq_question',
			[
				'label' 	=> __( 'Faq Question', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Ethical testing rather than ethical interfaces?', 'luxrio' )
			]
        );

        $repeater->add_control(
			'faq_answer',
			[
				'label' 	=> __( 'Faq Answer', 'luxrio' ),
                'type' 		=> Controls_Manager::TEXTAREA,
                'default'  	=> __( 'Assertively conceptualize cooperative potentialities with process centric internal or "organic" sources. Authoritatively pontificate B2C metrics via one-to-one synergy.', 'luxrio' )
			]
        );

		$this->add_control(
			'faq_repeater',
			[
				'label' 		=> __( 'Faq', 'luxrio' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'faq_question'    => __( 'Ethical testing rather than ethical interfaces?', 'luxrio' ),
						'faq_answer'      => __( 'Assertively conceptualize cooperative potentialities with process centric internal or "organic" sources. Authoritatively pontificate B2C metrics via one-to-one synergy.', 'luxrio' ),
					],
					[
						'faq_question'    => __( 'Latin derived from Cicero\'s 1st-century BC text De', 'luxrio' ),
                        'faq_answer'      => __( 'Assertively conceptualize cooperative potentialities with process centric internal or "organic" sources. Authoritatively pontificate B2C metrics via one-to-one synergy.', 'luxrio' ),
					],
					[
						'faq_question'    => __( 'Creation timelines for the standard lorem passage', 'luxrio' ),
                        'faq_answer'      => __( 'Assertively conceptualize cooperative potentialities with process centric internal or "organic" sources. Authoritatively pontificate B2C metrics via one-to-one synergy.', 'luxrio' ),
					],
					[
						'faq_question'    => __( 'Lorem ipsum was purposefully designed to have', 'luxrio' ),
                        'faq_answer'      => __( 'Assertively conceptualize cooperative potentialities with process centric internal or "organic" sources. Authoritatively pontificate B2C metrics via one-to-one synergy.', 'luxrio' ),
					],
				],
				'title_field' 	=> '{{{ faq_question }}}',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'faq_style_section',
			[
				'label' => __( 'Faq Question Style', 'luxrio' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);


        $this->add_control(
			'accordion_box_color',
			[
				'label' 	=> __( 'Accordion Box Background', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion.accordion-style1 .accordion-item:first-of-type .accordion-button' => 'background-color: {{VALUE}}',
                ],
			]
        );

        $this->add_control(
			'faq_question_color',
			[
				'label' 	=> __( 'Faq Question Color', 'luxrio' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-style1 .accordion-button' => 'color: {{VALUE}}',
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'faq_question_typography',
				'label' 	=> __( 'Faq Question Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .accordion-style1 .accordion-button',
			]
		);

        $this->add_responsive_control(
			'faq_question_margin',
			[
				'label' 		=> __( 'Faq Question Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .accordion-style1 .accordion-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );

        $this->add_responsive_control(
			'faq_question_padding',
			[
				'label' 		=> __( 'Faq Question Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .accordion-style1 .accordion-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
		);

		$this->add_control(
			'faq_answer_color',
			[
				'label' 		=> __( 'Faq Answer Color', 'luxrio' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .accordion-body p' => 'color: {{VALUE}}',
                ],
				'separator'		=> 'before'
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'faq_answer_typography',
				'label' 	=> __( 'Faq Answer Typography', 'luxrio' ),
                'selector' 	=> '{{WRAPPER}} .accordion-body p',
			]
        );

        $this->add_responsive_control(
			'faq_answer_margin',
			[
				'label' 		=> __( 'Faq Answer Margin', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .accordion-body p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );

        $this->add_responsive_control(
			'faq_answer_padding',
			[
				'label' 		=> __( 'Faq Answer Padding', 'luxrio' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .accordion-body p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
        );

        $this->end_controls_section();

	}

	protected function render() {

        $settings = $this->get_settings_for_display();
		
		
        if ( ! empty( $settings['faq_repeater'] ) ) {
            // Generate a unique ID for this widget instance
            $widget_unique_id = 'faqWidget_' . uniqid();
        
            echo '<div class="accordion accordion-style1 ">';
                echo '<div class="accordion"  id="' . esc_attr($widget_unique_id) . '">';
            
                $x = 1;
                foreach ($settings['faq_repeater'] as $single_data) {
                    if ($x == '1') {
                        $ariaexpanded = 'true';
                        $class = 'show';
                        $collesed = '';
                        $active = 'active';
                    } else {
                        $ariaexpanded = 'false';
                        $class = '';
                        $collesed = 'collapsed';
                        $active = '';
                    }
                    echo '<div class="accordion-item ' . esc_attr($active) . '">';
                    if (!empty($single_data['faq_question'])) {
                        // Generate a unique ID for this FAQ item
                        $faq_unique_id = 'faq_' . uniqid();
            
                        echo '<h2 class="accordion-header" id="' . esc_attr($faq_unique_id) . '">';
                        echo '<button class="accordion-button ' . esc_attr($collesed) . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . esc_attr($faq_unique_id) . '_collapse" aria-expanded="' . esc_attr($ariaexpanded) . '" aria-controls="' . esc_attr($faq_unique_id) . '_collapse">';
                        echo esc_html($single_data['faq_question']);
                        echo '</button>';
                        echo '</h2>';
                    }
                    if (!empty($single_data['faq_answer'])) {
                        echo '<div id="' . esc_attr($faq_unique_id) . '_collapse" class="accordion-collapse collapse ' . esc_attr($class) . '" aria-labelledby="' . esc_attr($faq_unique_id) . '" data-bs-parent="#' . esc_attr($widget_unique_id) . '">';
                        echo '<div class="accordion-body">';
                        echo esc_html($single_data['faq_answer']);
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                    $x++;
                }
                echo '</div>';
            echo '</div>';
		}
        
	}
}
$widgets_manager->register_widget_type( new \Luxrio_Faq() );