<?php
if (! defined('ABSPATH')) {
	exit;
}

class WCIM_Loader_KDR
{

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->load_dependencies();
	}

	/**
	 * Load required plugin files.
	 *
	 * @return void
	 */
	private function load_dependencies()
	{
		$admin_file = WCIM_KDR_PATH . 'includes/class-wcim-admin-kdr.php';
		$inventory_file = WCIM_KDR_PATH . "includes/class-wcim-inventory-kdr.php";
		$ajax_file = WCIM_KDR_PATH . "includes/class-wcim-ajax-kdr.php";
		$logs_file = WCIM_KDR_PATH . "includes/class-wcim-logs-kdr.php";
		$setting_file = WCIM_KDR_PATH . "includes/class-wcim-settings-kdr.php";

		// settings
		if (file_exists($setting_file)) {
			require_once $setting_file;
		}

		// logs
		if (file_exists($logs_file)) {
			require_once $logs_file;
		}

		// ajax
		if (file_exists($ajax_file)) {
			require_once $ajax_file;
		}

		// inventory
		if (file_exists($inventory_file)) {
			require_once $inventory_file;
		}

		// admin
		if (file_exists($admin_file)) {
			require_once $admin_file;
		}
	}

	/**
	 * Run plugin.
	 *
	 * @return void
	 */
	public function run()
	{
		// admin
		add_action('admin_menu', array($this, 'register_admin_menu'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

		// ajax
		add_action("wp_ajax_wcim_kdr_update_stock", array($this, "register_update_stock"));

		// settings
		add_action("admin_init", array($this, "register_settings_page"));
	}

	// register_settings_page
	public function register_settings_page()
	{
		if (class_exists("WCIM_Settings_KDR")) {
			$setting = new WCIM_Settings_KDR();
			$setting->register_settings();
		}
	}

	// register_update_stock
	public function register_update_stock()
	{
		if (class_exists("WCIM_Ajax_KDR")) {
			$ajax = new WCIM_Ajax_KDR();
			$ajax->update_stock();
		}
	}

	/**
	 * Register plugin admin menu.
	 *
	 * @return void
	 */
	public function register_admin_menu()
	{
		if (class_exists('WCIM_Admin_KDR')) {
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
	public function enqueue_admin_assets($hook)
	{
		if (class_exists('WCIM_Admin_KDR')) {
			$admin = new WCIM_Admin_KDR();
			$admin->enqueue_assets($hook);
		}
	}
}
