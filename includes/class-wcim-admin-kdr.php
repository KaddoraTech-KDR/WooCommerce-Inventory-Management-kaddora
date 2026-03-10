<?php
if (! defined('ABSPATH')) {
	exit;
}

class WCIM_Admin_KDR
{

	/**
	 * Admin menu slug.
	 *
	 * @var string
	 */
	private $menu_slug = 'wcim-kdr-dashboard';

	/**
	 * Register plugin admin menu.
	 *
	 * @return void
	 */
	public function register_menu()
	{
		add_menu_page(
			__('Inventory Management', 'woocommerce-inventory-management-kdr'),
			__('Inventory kdr', 'woocommerce-inventory-management-kdr'),
			'manage_woocommerce',
			$this->menu_slug,
			array($this, 'render_dashboard_page'),
			'dashicons-products',
			30
		);

		add_submenu_page(
			$this->menu_slug,
			__('Dashboard', 'woocommerce-inventory-management-kdr'),
			__('Dashboard', 'woocommerce-inventory-management-kdr'),
			'manage_woocommerce',
			$this->menu_slug,
			array($this, 'render_dashboard_page')
		);

		add_submenu_page(
			$this->menu_slug,
			__('All Inventory', 'woocommerce-inventory-management-kdr'),
			__('All Inventory', 'woocommerce-inventory-management-kdr'),
			'manage_woocommerce',
			'wcim-kdr-inventory',
			array($this, 'render_inventory_page')
		);

		add_submenu_page(
			$this->menu_slug,
			__('Settings', 'woocommerce-inventory-management-kdr'),
			__('Settings', 'woocommerce-inventory-management-kdr'),
			'manage_woocommerce',
			'wcim-kdr-settings',
			array($this, 'render_settings_page')
		);
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @param string $hook Current admin page hook.
	 * @return void
	 */
	public function enqueue_assets($hook)
	{
		$allowed_hooks = array(
			'toplevel_page_' . $this->menu_slug,
			'inventory-kdr_page_wcim-kdr-inventory',
			'inventory-kdr_page_wcim-kdr-settings',
		);

		if (! in_array($hook, $allowed_hooks, true)) {
			return;
		}

		wp_enqueue_style(
			'wcim-kdr-admin',
			WCIM_KDR_URL . 'assets/css/admin.css',
			array(),
			WCIM_KDR_VERSION
		);

		wp_enqueue_script(
			'wcim-kdr-admin',
			WCIM_KDR_URL . 'assets/js/admin.js',
			array('jquery'),
			WCIM_KDR_VERSION,
			true
		);

		wp_localize_script(
			'wcim-kdr-admin',
			'wcim_kdr_admin',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce'    => wp_create_nonce('wcim_kdr_admin_nonce'),
			)
		);
	}

	/**
	 * Render dashboard page.
	 *
	 * @return void
	 */
	public function render_dashboard_page()
	{
		if (! current_user_can('manage_woocommerce')) {
			wp_die(esc_html__('You do not have permission to access this page.', 'woocommerce-inventory-management-kdr'));
		}

		$template = WCIM_KDR_PATH . 'templates/dashboard.php';

		echo '<div class="wrap wcim-kdr-wrap">';

		if (file_exists($template)) {
			include $template;
		} else {
			echo '<h1>' . esc_html__('Inventory Dashboard', 'woocommerce-inventory-management-kdr') . '</h1>';
			echo '<p>' . esc_html__('Dashboard template file not found.', 'woocommerce-inventory-management-kdr') . '</p>';
		}

		echo '</div>';
	}

	/**
	 * Render inventory page.
	 *
	 * @return void
	 */
	public function render_inventory_page()
	{
		if (! current_user_can('manage_woocommerce')) {
			wp_die(esc_html__('You do not have permission to access this page.', 'woocommerce-inventory-management-kdr'));
		}

		$template = WCIM_KDR_PATH . 'templates/inventory-page.php';

		echo '<div class="wrap wcim-kdr-wrap">';

		if (file_exists($template)) {
			include $template;
		} else {
			echo '<h1>' . esc_html__('All Inventory', 'woocommerce-inventory-management-kdr') . '</h1>';
			echo '<p>' . esc_html__('Inventory template file not found.', 'woocommerce-inventory-management-kdr') . '</p>';
		}

		echo '</div>';
	}

	/**
	 * Render settings page.
	 *
	 * @return void
	 */
	public function render_settings_page()
	{
		if (! current_user_can('manage_woocommerce')) {
			wp_die(esc_html__('You do not have permission to access this page.', 'woocommerce-inventory-management-kdr'));
		}

		$template = WCIM_KDR_PATH . 'templates/settings-page.php';

		echo '<div class="wrap wcim-kdr-wrap">';

		if (file_exists($template)) {
			include $template;
		} else {
			echo '<h1>' . esc_html__('Settings', 'woocommerce-inventory-management-kdr') . '</h1>';
			echo '<p>' . esc_html__('Settings template file not found.', 'woocommerce-inventory-management-kdr') . '</p>';
		}

		echo '</div>';
	}
}
