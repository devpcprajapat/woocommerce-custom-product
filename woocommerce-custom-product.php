<?php
/**
 * @link              https://www.cmsminds.com/
 * @since             1.0.1
 * @package           WooCommerce_Custom_Product
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Custom Product
 * Plugin URI:        https://github.com/devpcprajapat/woocommerce-custom-product.git
 * Description:       Add custom image upload functionality to WooCommerce products.
 * Version:           1.0.1
 * Author:            cmsMinds
 * Author URI:        https://www.cmsminds.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wooCommerce_custom_product
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Hook to check WooCommerce activation
function custom_plugins_loaded_callback() {
	$active_plugins = get_option( 'active_plugins' );
	$is_wc_active   = in_array( 'woocommerce/woocommerce.php', $active_plugins, true );

	if ( current_user_can( 'activate_plugins' ) && false === $is_wc_active ) {
		add_action( 'admin_notices', 'custom_admin_notices_callback' );
	}else{
        include 'enqueue.php';
        include 'upload_btn.php';
        include 'validation.php';
        include 'store.php';
        include 'display.php';
        include 'email-template.php';
    }
}

add_action( 'plugins_loaded', 'custom_plugins_loaded_callback' );



function custom_admin_notices_callback() {
	$this_plugin_data = get_plugin_data( __FILE__ );
	$this_plugin      = $this_plugin_data['Name'];
	$wc_plugin        = 'WooCommerce';
	?>
	<div class="error">
		<p>
			<?php
			/* translators: 1: %s: strong tag open, 2: %s: strong tag close, 3: %s: this plugin, 4: %s: woocommerce plugin, 5: anchor tag for woocommerce plugin, 6: anchor tag close */
			echo wp_kses_post( sprintf( __( '%1$s%3$s%2$s is requires %1$s%4$s%2$s to be installed and active. Click %5$shere%6$s to install or activate it.', 'easy-reservations' ), '<strong>', '</strong>', esc_html( $this_plugin ), esc_html( $wc_plugin ), '<a target="_blank" href="' . admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) . '">', '</a>' ) );
			?>
		</p>
	</div>
	<?php
}