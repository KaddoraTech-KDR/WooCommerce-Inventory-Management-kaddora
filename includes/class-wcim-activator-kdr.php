<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCIM_Activator_KDR {

	/**
	 * Run plugin activation tasks.
	 *
	 * @return void
	 */
	public static function activate() {
		self::create_stock_logs_table();
		self::add_default_settings();
		self::set_plugin_version();
	}

	/**
	 * Create stock logs table.
	 *
	 * @return void
	 */
	private static function create_stock_logs_table() {
		global $wpdb;

		$table_name      = $wpdb->prefix . 'wcim_stock_logs_kdr';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name} (
			id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
			product_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
			variation_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
			old_stock DECIMAL(10,2) NOT NULL DEFAULT 0.00,
			new_stock DECIMAL(10,2) NOT NULL DEFAULT 0.00,
			stock_change DECIMAL(10,2) NOT NULL DEFAULT 0.00,
			action_type VARCHAR(50) NOT NULL DEFAULT 'manual',
			note TEXT NULL,
			user_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
			created_at DATETIME NOT NULL,
			PRIMARY KEY (id),
			KEY product_id (product_id),
			KEY variation_id (variation_id),
			KEY action_type (action_type)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Add default plugin settings.
	 *
	 * @return void
	 */
	private static function add_default_settings() {
		$default_settings = array(
			'low_stock_threshold' => 5,
			'enable_alerts'       => 'yes',
			'alert_email'         => get_option( 'admin_email' ),
		);

		if ( false === get_option( 'wcim_kdr_settings' ) ) {
			add_option( 'wcim_kdr_settings', $default_settings );
			return;
		}

		$existing_settings = get_option( 'wcim_kdr_settings', array() );
		$merged_settings   = wp_parse_args( $existing_settings, $default_settings );

		update_option( 'wcim_kdr_settings', $merged_settings );
	}

	/**
	 * Save plugin version.
	 *
	 * @return void
	 */
	private static function set_plugin_version() {
		update_option( 'wcim_kdr_version', WCIM_KDR_VERSION );
	}
}