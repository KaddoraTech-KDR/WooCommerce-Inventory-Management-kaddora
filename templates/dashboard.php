<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = array(
	'total_products' => 0,
	'low_stock'      => 0,
	'out_of_stock'   => 0,
	'recent_updates' => 0,
);
?>

<div class="wcim-kdr-dashboard">
	<div class="wcim-kdr-header">
		<h1><?php esc_html_e( 'Inventory Dashboard', 'woocommerce-inventory-management-kdr' ); ?></h1>
		<p><?php esc_html_e( 'Manage product stock, monitor low inventory, and track recent updates.', 'woocommerce-inventory-management-kdr' ); ?></p>
	</div>

	<div class="wcim-kdr-cards">
		<div class="wcim-kdr-card">
			<h2><?php esc_html_e( 'Total Products', 'woocommerce-inventory-management-kdr' ); ?></h2>
			<p class="wcim-kdr-card-number"><?php echo esc_html( $stats['total_products'] ); ?></p>
		</div>

		<div class="wcim-kdr-card">
			<h2><?php esc_html_e( 'Low Stock', 'woocommerce-inventory-management-kdr' ); ?></h2>
			<p class="wcim-kdr-card-number"><?php echo esc_html( $stats['low_stock'] ); ?></p>
		</div>

		<div class="wcim-kdr-card">
			<h2><?php esc_html_e( 'Out of Stock', 'woocommerce-inventory-management-kdr' ); ?></h2>
			<p class="wcim-kdr-card-number"><?php echo esc_html( $stats['out_of_stock'] ); ?></p>
		</div>

		<div class="wcim-kdr-card">
			<h2><?php esc_html_e( 'Recent Updates', 'woocommerce-inventory-management-kdr' ); ?></h2>
			<p class="wcim-kdr-card-number"><?php echo esc_html( $stats['recent_updates'] ); ?></p>
		</div>
	</div>

	<div class="wcim-kdr-dashboard-sections">
		<div class="wcim-kdr-panel">
			<h2><?php esc_html_e( 'Low Stock Alerts', 'woocommerce-inventory-management-kdr' ); ?></h2>
			<p><?php esc_html_e( 'Low stock products will appear here in future steps.', 'woocommerce-inventory-management-kdr' ); ?></p>
		</div>

		<div class="wcim-kdr-panel">
			<h2><?php esc_html_e( 'Recent Stock Activity', 'woocommerce-inventory-management-kdr' ); ?></h2>
			<p><?php esc_html_e( 'Recent inventory changes will appear here after log integration.', 'woocommerce-inventory-management-kdr' ); ?></p>
		</div>
	</div>
</div>