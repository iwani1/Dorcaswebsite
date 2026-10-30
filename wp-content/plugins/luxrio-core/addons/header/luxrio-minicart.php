<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * Header Widget .
 *
 */
class Luxrio_Mini_Cart extends Widget_Base {

	public function get_name() {
		return 'luxriominicarts';
	}

	public function get_title() {
		return __( 'Minicart', 'luxrio' );
	}

	public function get_icon() {
		return 'eicon-code';
    }

	public function get_categories() {
		return [ 'luxrio_header_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'luxrio_minicart',
			[
				'label' 	=> __( 'Minicart', 'luxrio' ),
				'tab' 		=> Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'cart_text',
			[
				'label' 		=> __( 'Cart Text', 'luxrio' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> esc_html__( 'Bag', 'luxrio' ),
			]
		);

		
        $this->end_controls_section();


    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        ?>
		<?php 
			if( class_exists( 'woocommerce' ) ){
				global $woocommerce;
				if( ! empty( WC()->cart->get_cart_contents_count() ) ){
					$count = WC()->cart->get_cart_contents_count();
				} else {
					$count = "0";
				}
			}
		?>

		<?php if( class_exists( 'woocommerce' ) ): ?>
			<a class="wc-link xoo-wsc-cart-trigger sideCartToggler" href="#">
				<?php echo esc_html( $settings['cart_text'] );?> 
				<span class="cart-count"><?php echo $count; ?></span> 
				<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5.33315 6.33334V3.12501C5.33315 1.75001 6.24982 0.833344 7.62482 0.833344H10.3748C11.7498 0.833344 12.6665 1.75001 12.6665 3.12501V6.33334M16.709 14.6108H5.33315M5.70002 4.95834H12.3C15.4167 4.95834 15.7284 6.41584 15.9392 8.19418L16.7642 15.0692C17.03 17.3242 16.3334 19.1667 13.125 19.1667H4.88419C1.66669 19.1667 0.970022 17.3242 1.24502 15.0692L2.07003 8.19418C2.2717 6.41584 2.58336 4.95834 5.70002 4.95834Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
			</a>
		<?php endif; ?>
        <?php 
	}

}
$widgets_manager->register( new \Luxrio_Mini_Cart() );