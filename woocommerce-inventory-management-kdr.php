<?php
/**
 * Plugin Name: WooCommerce Inventory Management kaddora
 * Description: A modern and scalable inventory management plugin for WooCommerce.
 * Version: 1.0.0
 * Author: Kaddora Tech
 * Text Domain: woocommerce-inventory-management-kdr
 * Domain Path: /languages
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * WC requires at least: 8.0
 * WC tested up to: 9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Prevent running twice.
if ( defined( 'WCIM_KDR_FILE' ) ) {
	return;
}

/**
 * Plugin constants.
 */
define( 'WCIM_KDR_FILE', __FILE__ );
define( 'WCIM_KDR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WCIM_KDR_URL', plugin_dir_url( __FILE__ ) );
define( 'WCIM_KDR_VERSION', '1.0.0' );
define( 'WCIM_KDR_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Check whether WooCommerce is active.
 *
 * @return bool
 */
function wcim_kdr_is_woocommerce_active() {
	return class_exists( 'WooCommerce' );
}

/**
 * Show admin notice if WooCommerce is missing.
 *
 * @return void
 */
function wcim_kdr_missing_woocommerce_notice() {
	?>
	<div class="notice notice-error">
		<p>
			<?php esc_html_e( 'WooCommerce Inventory Management kdr requires WooCommerce to be installed and active.', 'woocommerce-inventory-management-kdr' ); ?>
		</p>
	</div>
	<?php
}

/**
 * Load plugin textdomain.
 *
 * @return void
 */
function wcim_kdr_load_textdomain() {
	load_plugin_textdomain(
		'woocommerce-inventory-management-kdr',
		false,
		dirname( WCIM_KDR_BASENAME ) . '/languages'
	);
}
add_action( 'plugins_loaded', 'wcim_kdr_load_textdomain' );

/**
 * Include required files.
 *
 * @return void
 */
function wcim_kdr_include_files() {
	require_once WCIM_KDR_PATH . 'includes/class-wcim-activator-kdr.php';
	require_once WCIM_KDR_PATH . 'includes/class-wcim-loader-kdr.php';
}
wcim_kdr_include_files();

/**
 * Activation hook.
 *
 * @return void
 */
function wcim_kdr_activate_plugin() {
	if ( ! wcim_kdr_is_woocommerce_active() ) {
		deactivate_plugins( WCIM_KDR_BASENAME );

		wp_die(
			esc_html__( 'WooCommerce Inventory Management kdr requires WooCommerce to be active before activation.', 'woocommerce-inventory-management-kdr' ),
			esc_html__( 'Plugin activation error', 'woocommerce-inventory-management-kdr' ),
			array(
				'back_link' => true,
			)
		);
	}

	if ( class_exists( 'WCIM_Activator_KDR' ) ) {
		WCIM_Activator_KDR::activate();
	}
}
register_activation_hook( __FILE__, 'wcim_kdr_activate_plugin' );

/**
 * Start plugin.
 *
 * @return void
 */
function wcim_kdr_run_plugin() {
	if ( ! wcim_kdr_is_woocommerce_active() ) {
		add_action( 'admin_notices', 'wcim_kdr_missing_woocommerce_notice' );
		return;
	}

	if ( class_exists( 'WCIM_Loader_KDR' ) ) {
		$plugin = new WCIM_Loader_KDR();
		$plugin->run();
	}
}
add_action( 'plugins_loaded', 'wcim_kdr_run_plugin', 20 );