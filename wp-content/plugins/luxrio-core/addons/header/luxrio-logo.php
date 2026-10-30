<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * New Header Widget .
 *
 */
class Luxrio_Site_Logo extends Widget_Base {

	public function get_name() {
		return 'luxriologo';
	}

	public function get_title() {
		return __( 'Luxrio Site Logo', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio_header_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
            'section_layout',
            [
                'label' => __('Layout', 'luxrio'),
            ]
        );

        $this->add_control(
			'logo_type',
			[
				'label' => __( 'Logo Type', 'luxrio' ),
				'type'  => Controls_Manager::SELECT,
				'default' => 'dark',
				'options' => [
					'dark'   => __( 'Dark', 'luxrio' ),
					'white'  => __( 'White', 'luxrio' ),
					'custom' => __( 'Custom', 'luxrio' ),
				],
			]
        );
        
        $this->add_control(
            'image',
            [
                'label' => __('Choose logo', 'luxrio'),
                'type'  => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'logo_type' => 'custom',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'logo_size', 
                'include' => [],
                'default' => 'large',
                'condition' => [
                    'logo_type' => 'custom',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_align',
            [
                'label' => __('Align', 'luxrio'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'luxrio'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('top', 'luxrio'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'luxrio'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .header-logo' => 'text-align: {{SIZE}};',
                ],
                'toggle' => true,
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => __('Image width', 'luxrio'),
                'type'  => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .header-logo' => 'max-width: {{SIZE}}{{UNIT}};',
                ]

            ]
        );
		$this->add_responsive_control(
            'logo_margin',
            [
                'label' => __('Margin', 'luxrio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .header-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->end_controls_section();
    }
	
	protected function render() {

		$settings = $this->get_settings();
		?>
			<div class="header-logo">
				<a href="<?php echo home_url(); ?>">
					<?php
					if ( 'custom' == $settings['logo_type'] && $settings['image']['url']) {
						echo Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
					} else {
						echo $this->luxrio_get_site_logo( $settings['logo_type'] );
					}
					?>
				</a>
			</div>
		<?php
	}

	/**
     * 
     *  luxrio get logo  
     * 
     */
    public function luxrio_get_site_logo( $logo_type = 'dark'  )
    {
        $logo = '';
        $luxrio = get_option('luxrio_opt');
        $logo_url = '';
        if ( 'dark' ==  $logo_type && isset( $luxrio['logo']['url'] ) ) {
            $logo_url = esc_url($luxrio['logo']['url']);
            $logo = '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('title')) . '" class="dark-logo">';

        } else if ( 'white' ==  $logo_type && isset($luxrio['white_logo']['url'])) {
            $logo_url = esc_url($luxrio['white_logo']['url']);
            $logo = '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('title')) . '" class="white-logo">';
        } else {
            if ( has_custom_logo() ) {
                $core_logo_id = get_theme_mod('custom_logo');
                $logo_url = wp_get_attachment_image_src($core_logo_id, 'full');
                $logo = '<img src="' . esc_url($logo_url[0]) . '" alt="' . esc_attr(get_bloginfo('title')) . '">';
            } else {

                $logo = '<h2 class="navbar-brand__regular">' . get_bloginfo('name') . '</h2>';

            }
        }
        return $logo;
    }
}
$widgets_manager->register( new \Luxrio_Site_Logo() );