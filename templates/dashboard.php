<?php
if (! defined('ABSPATH')) {
	exit;
}

$inventory = new WCIM_Inventory_KDR();

$total_products = $inventory->get_total_products();
$low_stock = $inventory->get_low_stock_count();
$out_of_stock = $inventory->get_out_of_stock_count();
$low_products = $inventory->get_low_stock_products();

$recent_updates = WCIM_Logs_KDR::get_recent_updates_count();
$recent_logs = WCIM_Logs_KDR::get_recent_logs(10);
?>

<div class="wcim-kdr-dashboard">

	<!-- header -->
	<div class="wcim-kdr-header">
		<h1><?php esc_html_e('Inventory Dashboard', 'woocommerce-inventory-management-kdr'); ?></h1>
		<p><?php esc_html_e('Manage product stock, monitor low inventory, and track recent updates.', 'woocommerce-inventory-management-kdr'); ?></p>
	</div>

	<!-- card -->
	<div class="wcim-kdr-cards container-box">
		<div class="wcim-kdr-card">
			<h2><?php esc_html_e('Total Products', 'woocommerce-inventory-management-kdr'); ?></h2>
			<p class="wcim-kdr-card-number"><?php echo esc_html($total_products); ?></p>
		</div>

		<div class="wcim-kdr-card">
			<h2><?php esc_html_e('Low Stock', 'woocommerce-inventory-management-kdr'); ?></h2>
			<p class="wcim-kdr-card-number"><?php echo esc_html($low_stock); ?></p>
		</div>

		<div class="wcim-kdr-card">
			<h2><?php esc_html_e('Out of Stock', 'woocommerce-inventory-management-kdr'); ?></h2>
			<p class="wcim-kdr-card-number"><?php echo esc_html($out_of_stock); ?></p>
		</div>

		<div class="wcim-kdr-card">
			<h2><?php esc_html_e('Recent Updates', 'woocommerce-inventory-management-kdr'); ?></h2>
			<p class="wcim-kdr-card-number"><?php echo esc_html($recent_updates); ?></p>
		</div>
	</div>

	<!-- sections -->
	<div class="wcim-kdr-dashboard-sections container-box">

		<!-- Low Stock Alerts -->
		<div class="wcim-kdr-panel">
			<h2>
				<?php esc_html_e('Low Stock Alerts', 'woocommerce-inventory-management-kdr'); ?>
			</h2>
			<?php if (!empty($low_products)) : ?>

				<table class="widefat striped">

					<thead>
						<tr class="table-header">
							<th>Product</th>
							<th>Stock</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($low_products as $product) : ?>
							<tr>
								<td>
									<a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" class="product-link">
										<?php echo esc_html($product->get_name()); ?>
									</a>
								</td>
								<td>
									<strong>
										<?php echo esc_html($product->get_stock_quantity()); ?>
									</strong>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>

				</table>
			<?php else : ?>
				<p>No low stock products.</p>
			<?php endif; ?>
		</div>

		<!-- Recent Stock Activity -->
		<div class="wcim-kdr-panel">
			<h2>
				<?php esc_html_e('Recent Stock Activity', 'woocommerce-inventory-management-kdr'); ?>
			</h2>

			<table class="widefat striped">

				<thead>
					<tr class="table-header">
						<th>Product</th>
						<th>Old</th>
						<th>New</th>
						<th>Change</th>
						<th>User</th>
						<th>Time</th>
					</tr>
				</thead>

				<tbody>
					<?php if (!empty($recent_logs)) : ?>
						<?php foreach ($recent_logs as $log) : ?>
							<?php
							$product = wc_get_product($log->product_id);
							$user = get_user_by('id', $log->user_id);
							?>
							<tr>
								<td>
									<a href="<?php echo esc_url(get_permalink($log->product_id)); ?>" class="product-link">
										<?php echo esc_html($product ? $product->get_name() : 'Unknown'); ?>
									</a>
								</td>
								<td><?php echo esc_html($log->old_stock); ?></td>
								<td>
									<strong>
										<?php echo esc_html($log->new_stock); ?>
									</strong>
								</td>
								<!-- change -->
								<td style="color: <?php echo $log->stock_change >= 0 ? 'green' : 'red'; ?>">
									<?php echo esc_html($log->stock_change); ?>
								</td>
								<td><?php echo esc_html($user ? $user->user_login : 'System'); ?></td>
								<td><?php echo esc_html($log->created_at); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="6">No stock activity yet.</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>

		</div>

	</div>
</div>