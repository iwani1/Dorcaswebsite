<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Control_Media;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Widget_Base;

class Luxrio_List_group extends Widget_Base {

	public function get_name() {
		return 'luxrio-list-groups';
	}

	public function get_title() {
		return esc_html__( 'List Group', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-editor-list-ol luxrio';
	}

	public function get_categories() {
		return [ 'luxrio' ];
	}

	public function get_keywords() {
		return [ 'luxrio', 'information', 'group', 'list', 'icon', 'socail' ];
	}

	protected function register_controls() {

		/*
		* Icon List Content
		*/
		$this->start_controls_section(
			'luxrio_section_list_content',
			[
				'label' => esc_html__( 'Content', 'luxrio' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
            'luxrio_list_icon_type',
            [
                'label' => __( 'Media Type', 'luxrio' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'icon',
				'options' => [
					'icon' => [
						'title' => __( 'Icon', 'luxrio' ),
						'icon' => 'eicon-star',
					],
					'number' => [
						'title' => __( 'Number', 'luxrio' ),
						'icon' => 'eicon-number-field',
					],
					'image' => [
						'title' => __( 'Image', 'luxrio' ),
						'icon' => 'eicon-image',
					],
				],
				'toggle' => false,
                'style_transfer' => true,
            ]
        );

		$repeater->add_control(
			'luxrio_list_icon',
			[
				'label'       => __( 'Icon', 'luxrio' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'separator'   =>'after',
				'default'     => [
					'value'   => 'far fa-check-circle',
					'library' => 'fa-regular'
				],
				'condition' =>[
					'luxrio_list_icon_type' => 'icon'
				]
			]
		);

		$repeater->add_control(
			'luxrio_list_icon_number',
			[
				'label'   => esc_html__( 'Number', 'luxrio' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '1', 'luxrio' ),
				'separator'   =>'after',
				'condition' =>[
					'luxrio_list_icon_type' => 'number'
				]
			]
		);

		$repeater->add_control(
			'luxrio_list_icon_number_image',
			[
				'label' => __( 'Choose Image', 'luxrio' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'separator'   =>'after',
				'dynamic' => [
					'active' => true,
				],
				'condition' =>[
					'luxrio_list_icon_type' => 'image'
				]
			]
		);

        $repeater->add_control(
			'luxrio_list_text',
			[
				'label'   => esc_html__( 'Text', 'luxrio' ),
				'type'    => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'List Text', 'luxrio' ),
				'dynamic' => [ 'active' => true ]
			]
		);

		$repeater->add_control(
			'luxrio_list_link',
			[
				'label' => __( 'List URL', 'luxrio' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'luxrio' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'luxrio_list_group',
			[
				'label' => __( 'List Items', 'elementor' ),
				'type' 		=> Controls_Manager::REPEATER,
				'fields' 	=> $repeater->get_controls(),
				'default' => [
					[
						'luxrio_list_text' => __( 'List Item #1', 'elementor' ),
						'luxrio_list_icon' => [
							'value' => 'fas fa-check',
							'library' => 'fa-solid',
						],
					],
					[
						'luxrio_list_text' => __( 'List Item #2', 'elementor' ),
						'luxrio_list_icon' => [
							'value' => 'fas fa-check',
							'library' => 'fa-solid',
						],
					],
					[
						'luxrio_list_text' => __( 'List Item #3', 'elementor' ),
						'luxrio_list_icon' => [
							'value' => 'fas fa-check',
							'library' => 'fa-solid',
						],
					],
				],
				'title_field' => '{{{ elementor.helpers.renderIcon( this, luxrio_list_icon, {}, "i", "panel" ) }}}{{{ luxrio_list_text }}}'
			]
		);

		$this->end_controls_section();

		/*
		* Icon List Content
		*/
		$this->start_controls_section(
			'luxrio_section_list_style',
			[
				'label' => esc_html__( 'Container', 'luxrio' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'luxrio_section_list_layout',
			[
				'label' => __( 'Layout', 'luxrio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'layout_1',
				'options' => [
					'layout_1' => __( 'Layout 1', 'luxrio' ),
					'layout_2' => __( 'Layout 2', 'luxrio' ),
					'layout_3' => __( 'Layout 3', 'luxrio' ),
				],
			]
		);

		$this->add_responsive_control(
			'luxrio_section_list_alignment',
			[
				'label'       => esc_html__( 'Alignment', 'luxrio' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'label_block' => false,
				'options'     => [
					'luxrio-list-group-left'   => [
						'title' => esc_html__( 'Left', 'luxrio' ),
						'icon'  => 'eicon-text-align-left'
					],
					'luxrio-list-group-center' => [
						'title' => esc_html__( 'Center', 'luxrio' ),
						'icon'  => 'eicon-text-align-center'
					],
					'luxrio-list-group-right'  => [
						'title' => esc_html__( 'Right', 'luxrio' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'selectors_dictionary' => [
					'luxrio-list-group-left' => 'justify-content: flex-start; text-align: left;',
					'luxrio-list-group-center' => 'justify-content: center; text-align: center;',
					'luxrio-list-group-right' => 'justify-content: flex-end; text-align: right;',
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper' => '{{VALUE}};',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item' => '{{VALUE}};',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item a' => '{{VALUE}};',
				],
				'default'     => 'luxrio-list-group-left',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'            => 'luxrio_section_list_group_background',
				'types'           => [ 'classic', 'gradient' ],
				'selector'        => '{{WRAPPER}} .luxrio-list-group',
			]
		);

		$this->add_responsive_control(
			'luxrio_section_list_group_padding',
			[
				'label'      => __( 'Padding', 'luxrio' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => true
                ],
				'selectors'  => [
					'{{WRAPPER}} .luxrio-list-group' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'luxrio_section_list_group_border',
				'selector'  => '{{WRAPPER}} .luxrio-list-group'
			]
		);

		$this->add_responsive_control(
			'luxrio_section_list_group_radius',
			[
				'label'        => __( 'Border Radius', 'luxrio' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px'
				],
				'selectors'    => [
					'{{WRAPPER}} .luxrio-list-group' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'luxrio_section_list_group_shadow',
				'selector' => '{{WRAPPER}} .luxrio-list-group'
			]
		);

		$this->end_controls_section();

		/*
		* Icon List Content
		*/
		$this->start_controls_section(
			'luxrio_section_list_item_style',
			[
				'label' => esc_html__( 'List Item', 'luxrio' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'luxrio_section_list_item_padding',
			[
				'label'        => __( 'Item Padding', 'luxrio' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'default'      => [
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'unit'     => 'px'
				],
				'selectors'    => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'luxrio_section_list_item_separator',
            [
				'label'        => __( 'Item Separator', 'luxrio' ),
				'type'         =>  Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'luxrio' ),
				'label_off'    => __( 'Hide', 'luxrio' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'luxrio_section_list_layout!' => 'layout_3'
				]
			]
        );

		$this->add_responsive_control(
			'luxrio_section_list_item_separator_height',
			[
				'label' => __( 'Separator Height', 'luxrio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_1 .luxrio-list-group-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_2 .luxrio-list-group-item:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'luxrio_section_list_item_separator' => 'yes',
					'luxrio_section_list_layout!' => 'layout_3'
				]
			]
		);

		$this->add_control(
			'luxrio_section_list_item_separator_color',
			[
				'label' => __( 'Separator Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e5e5e5',
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_1 .luxrio-list-group-item:not(:last-child):after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_2 .luxrio-list-group-item:not(:last-child):after' => 'background: {{VALUE}}',
				],
				'condition' => [
					'luxrio_section_list_item_separator' => 'yes',
					'luxrio_section_list_layout!' => 'layout_3'
				]
			]
		);

		$this->add_responsive_control(
			'luxrio_list_item_spacing',
			[
				'label' => __( 'Item Spacing', 'luxrio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_3 .luxrio-list-group-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'luxrio_section_list_layout' => 'layout_3'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'            => 'luxrio_list_item_background',
				'types'           => [ 'classic', 'gradient' ],
				'selector'        => '{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_3 .luxrio-list-group-item',
				'condition' => [
					'luxrio_section_list_layout' => 'layout_3'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'luxrio_list_item_border',
				'selector'  => '{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_3 .luxrio-list-group-item',
				'fields_options'  => [
                    'border' 	  => [
                        'default' => 'solid'
                    ],
                    'width'  	  => [
                        'default' 	 => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1'
                        ]
                    ],
                    'color' 	  => [
                        'default' => '#e5e5e5',
                    ]
                ],
				'condition' => [
					'luxrio_section_list_layout' => 'layout_3'
				]
			]
		);

		$this->add_responsive_control(
			'luxrio_list_item_radius',
			[
				'label'        => __( 'Border Radius', 'luxrio' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'default'      => [
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'unit'     => 'px'
				],
				'selectors'    => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_3 .luxrio-list-group-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'luxrio_section_list_layout' => 'layout_3'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'luxrio_list_item_shadow',
				'selector' => '{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_3 .luxrio-list-group-item',
				'condition' => [
					'luxrio_section_list_layout' => 'layout_3'
				]
			]
		);

		$this->end_controls_section();

		/*
		* Icon List Icon Style
		*/
		$this->start_controls_section(
			'luxrio_section_list_icon_style',
			[
				'label' => esc_html__( 'Icon', 'luxrio' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'luxrio_list_icon_position',
			[
				'label'       => esc_html__( 'Icon Position', 'luxrio' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'label_block' => false,
				'options'     => [
					'luxrio-icon-left'   => [
						'title' => esc_html__( 'Left', 'luxrio' ),
						'icon'  => 'eicon-h-align-left'
					],
					'luxrio-icon-center' => [
						'title' => esc_html__( 'Center', 'luxrio' ),
						'icon'  => 'eicon-v-align-top'
					],
					'luxrio-icon-right'  => [
						'title' => esc_html__( 'Right', 'luxrio' ),
						'icon'  => 'eicon-h-align-right'
					]
				],
				'default'     => 'luxrio-icon-left'
			]
		);

		$this->add_responsive_control(
			'luxrio_list_icon_alignment',
			[
				'label'       => esc_html__( 'Icon Vertical Alignment', 'luxrio' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'label_block' => false,
				'options'     => [
					'luxrio-icon-align-left'   => [
						'title' => esc_html__( 'Top', 'luxrio' ),
						'icon'  => 'eicon-v-align-top'
					],
					'luxrio-icon-align-center' => [
						'title' => esc_html__( 'Center', 'luxrio' ),
						'icon'  => 'eicon-v-align-middle'
					],
					'luxrio-icon-align-right'  => [
						'title' => esc_html__( 'Bottom', 'luxrio' ),
						'icon'  => 'eicon-v-align-bottom'
					]
				],
				'default'     => 'luxrio-icon-align-left',
				'selectors_dictionary' => [
					'luxrio-icon-align-left' => 'align-items: flex-start;',
					'luxrio-icon-align-center' => 'align-items: center;',
					'luxrio-icon-align-right' => 'align-items: flex-end;',
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item' => '{{VALUE}};',
				],
				'condition' => [
					'luxrio_list_icon_position!' => 'luxrio-icon-center'
				]
			]
		);

		$this->add_responsive_control(
			'luxrio_list_icon_top_alignment',
			[
				'label'       => esc_html__( 'Icon Alignment', 'luxrio' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'label_block' => false,
				'options'     => [
					'luxrio-icon-top-align-left'   => [
						'title' => esc_html__( 'Left', 'luxrio' ),
						'icon'  => 'eicon-v-align-top'
					],
					'luxrio-icon-top-align-center' => [
						'title' => esc_html__( 'Center', 'luxrio' ),
						'icon'  => 'eicon-v-align-middle'
					],
					'luxrio-icon-top-align-right'  => [
						'title' => esc_html__( 'Right', 'luxrio' ),
						'icon'  => 'eicon-v-align-bottom'
					]
				],
				'default'     => 'luxrio-icon-left',
				'selectors_dictionary' => [
					'luxrio-icon-top-align-left' => 'text-align: left; margin-right: auto;',
					'luxrio-icon-top-align-center' => 'text-align: center; margin-left: auto; margin-right: auto;',
					'luxrio-icon-top-align-right' => 'text-align: right; margin-left: auto;',
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon' => '{{VALUE}};',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon .luxrio-list-group-icon-image' => '{{VALUE}};',
				],
				'condition' => [
					'luxrio_list_icon_position' => 'luxrio-icon-center'
				]
			]
		);

		$this->add_responsive_control(
			'luxrio_section_list_item_icon_spacing',
			[
				'label' => __( 'Icon Right Spacing', 'luxrio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-text' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'luxrio_list_icon_position' => 'luxrio-icon-left'
				]
			]
		);

		$this->add_responsive_control(
			'luxrio_section_list_item_icon_margin_bottom',
			[
				'label' => __( 'Icon Bottom Spacing', 'luxrio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'luxrio_section_list_item_icon_left_spacing',
			[
				'label' => __( 'Icon Left Spacing', 'luxrio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'luxrio_list_icon_position' => 'luxrio-icon-right'
				]
			]
		);
		$this->add_responsive_control(
			'luxrio_section_list_item_icon_bottom_spacing',
			[
				'label' => __( 'Icon Bottom Spacing', 'luxrio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'luxrio_list_icon_position' => 'luxrio-icon-center'
				]
			]
		);

		$this->add_responsive_control(
			'luxrio_section_list_item_icon_size',
			[
				'label' => __( 'Icon Size', 'luxrio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon svg' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon .luxrio-list-group-icon-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'luxrio_section_list_item_icon_color',
			[
				'label' => __( 'Icon Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'luxrio_section_list_item_icon_color_hover',
			[
				'label' => __( 'Icon Color Hover', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon:hover i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon:hover svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'luxrio_section_list_item_icon_bg_color_hover',
			[
				'label' => __( 'Icon Background Hover', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon.yes:hover' => 'background-color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'luxrio_section_list_item_icon_border color_hover',
			[
				'label' => __( 'Icon Border Hover', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon.yes:hover' => 'border-color: {{VALUE}} !important',
				],
			]
		);


		$this->add_responsive_control(
			'luxrio_section_list_item_image_radius',
			[
				'label'        => __( 'Image Radius', 'luxrio' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px'
				],
				'selectors'    => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon .luxrio-list-group-icon-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'luxrio_list_item_icon_box_enable',
			[
				'label' => __( 'Enable Icon Box', 'luxrio' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'luxrio' ),
				'label_off' => __( 'Hide', 'luxrio' ),
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'luxrio_list_item_icon_box_width',
			[
				'label' => __( 'Icon Box Width', 'luxrio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon.yes' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_1 .luxrio-list-group-item .luxrio-list-group-text' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_2 .luxrio-list-group-item .luxrio-list-group-text' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper.layout_3 .luxrio-list-group-item .luxrio-list-group-text' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
				],
				'condition' => [
					'luxrio_list_item_icon_box_enable' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'luxrio_list_item_icon_box_height',
			[
				'label' => __( 'Icon Box Height', 'luxrio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon.yes' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'luxrio_list_item_icon_box_enable' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'            => 'luxrio_list_item_icon_box_background',
				'types'           => [ 'classic', 'gradient' ],
				'selector'        => '{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon.yes',
				'condition' => [
					'luxrio_list_item_icon_box_enable' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'            => 'luxrio_list_item_icon_box_background_hover',
				'types'           => [ 'classic', 'gradient' ],
				'selector'        => '{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon.yes:hover',
				'condition' => [
					'luxrio_list_item_icon_box_enable' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'luxrio_list_item_icon_box_border',
				'selector'  => '{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon.yes',
				'condition' => [
					'luxrio_list_item_icon_box_enable' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'luxrio_list_item_icon_box_radius',
			[
				'label'        => __( 'Border Radius', 'luxrio' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', '%', 'em' ],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px'
				],
				'selectors'    => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon.yes' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'luxrio_list_item_icon_box_enable' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'luxrio_list_item_icon_box_shadow',
				'selector' => '{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-icon.yes',
				'condition' => [
					'luxrio_list_item_icon_box_enable' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		/*
		* Icon List Text
		*/
		$this->start_controls_section(
			'luxrio_section_list_text_style',
			[
				'label' => esc_html__( 'Text', 'luxrio' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'luxrio_section_list_text_alignment',
			[
				'label'       => esc_html__( 'Text Alignment', 'luxrio' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'label_block' => false,
				'options'     => [
					'luxrio-text-align-left'   => [
						'title' => esc_html__( 'Left', 'luxrio' ),
						'icon'  => 'eicon-text-align-left'
					],
					'luxrio-text-align-center' => [
						'title' => esc_html__( 'Center', 'luxrio' ),
						'icon'  => 'eicon-text-align-left'
					],
					'luxrio-text-align-right'  => [
						'title' => esc_html__( 'Right', 'luxrio' ),
						'icon'  => 'eicon-text-align-left'
					]
				],
				'default'     => 'luxrio-text-align-left',
				'selectors_dictionary' => [
					'luxrio-text-align-left' => 'text-align: left;',
					'luxrio-text-align-center' => 'text-align: center;',
					'luxrio-text-align-right' => 'text-align: right;',
				],
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-text' => '{{VALUE}};',
				],
				'condition' => [
					'luxrio_list_icon_position' => 'luxrio-icon-center'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'luxrio_section_list_text_typography',
				'label' => __( 'Typography', 'luxrio' ),
				'selector' => '{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-text',
			]
		);

		$this->add_control(
			'luxrio_section_list_text_color',
			[
				'label' => __( 'Text Color', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'luxrio_section_list_text_hover_color',
			[
				'label' => __( 'Text Color Hover', 'luxrio' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .luxrio-list-group .luxrio-list-group-wrapper .luxrio-list-group-item .luxrio-list-group-text:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}
	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
		<div class="luxrio-list-group">
			<ul class="luxrio-list-group-wrapper <?php echo $settings['luxrio_section_list_layout']; ?>">
				<?php foreach( $settings['luxrio_list_group'] as $list ) : ?>
				<?php
					$target = $list['luxrio_list_link']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $list['luxrio_list_link']['nofollow'] ? ' rel="nofollow"' : '';
				?>
					<li class="luxrio-list-group-item <?php echo $settings['luxrio_list_icon_position']?>">
						<?php if ( !empty( $list['luxrio_list_link']['url'] ) ) { ?>
						<a href="<?php echo $list['luxrio_list_link']['url']; ?>" <?php echo $target; ?> <?php echo $nofollow; ?> >
						<?php } ?>
							<div class="luxrio-list-group-icon <?php echo $settings['luxrio_list_item_icon_box_enable']; ?>">
								<?php if ( $list['luxrio_list_icon_type'] === 'icon' && !empty($list['luxrio_list_icon']) ){ ?>
									<?php Icons_Manager::render_icon( $list['luxrio_list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								<?php } ?>
								<?php if ( $list['luxrio_list_icon_type'] === 'number' && !empty($list['luxrio_list_icon_type']) ){ ?>
									<div class="luxrio-list-group-icon-number">
										<?php echo $list['luxrio_list_icon_number']; ?>
									</div>
								<?php } ?>
								<?php if ( $list['luxrio_list_icon_type'] === 'image' && !empty($list['luxrio_list_icon_type']) ){ ?>
									<div class="luxrio-list-group-icon-image">
										<img src="<?php echo $list['luxrio_list_icon_number_image']['url'] ?>" alt="<?php echo $list['luxrio_list_text']; ?>">
									</div>
								<?php } ?>
							</div>
							<?php if ( !empty( $list['luxrio_list_text'] ) ) { ?>
								<span class="luxrio-list-group-text">
									<?php echo $list['luxrio_list_text']; ?>
								</span>
							<?php } ?>
						<?php if ( !empty( $list['luxrio_list_link']['url'] ) ) { ?>
						</a>
						<?php } ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
};
$widgets_manager->register( new \Luxrio_List_group() );