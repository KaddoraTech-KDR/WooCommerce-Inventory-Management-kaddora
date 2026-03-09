<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCIM_Loader_KDR {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->load_dependencies();
	}

	/**
	 * Load required plugin files.
	 *
	 * @return void
	 */
	private function load_dependencies() {
		$admin_file = WCIM_KDR_PATH . 'includes/class-wcim-admin-kdr.php';

		if ( file_exists( $admin_file ) ) {
			require_once $admin_file;
		}
	}

	/**
	 * Run plugin.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Register plugin admin menu.
	 *
	 * @return void
	 */
	public function register_admin_menu() {
		if ( class_exists( 'WCIM_Admin_KDR' ) ) {
			$admin = new WCIM_Admin_KDR();
			$admin->register_menu();
		}
	}

	/**
	 * Enqueue admin CSS and JS.
	 *
	 * @param string $hook Current admin page hook.
	 * @return void
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( class_exists( 'WCIM_Admin_KDR' ) ) {
			$admin = new WCIM_Admin_KDR();
			$admin->enqueue_assets( $hook );
		}
	}
}