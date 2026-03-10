<?php

$inventory_class = new WCIM_Inventory_KDR();

$search = $_GET['search'] ?? '';

$products = $inventory_class->get_products_with_stock($search);

?>

<div class="wrap">

  <h1>Inventory</h1>

  <!-- search -->
  <form method="get">
    <input type="hidden" name="page" value="wcim-kdr-inventory">
    <input type="text" name="search" placeholder="Search product..." value="<?php echo esc_attr($_GET['search'] ?? ''); ?>">
    <button class="button">Search</button>
  </form>

  <!-- table -->
  <table class="widefat fixed striped">

    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>SKU</th>
        <th>Stock</th>
        <th>Status</th>
      </tr>
    </thead>

    <tbody>
      <?php if (!empty($products)) : ?>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?php echo esc_html($product->get_id()); ?></td>
            <td><?php echo esc_html($product->get_name()); ?></td>
            <td><?php echo esc_html($product->get_sku()); ?></td>
            <td>
              <input type="number" min="0" class="wcim-stock-input" data-product="<?php echo esc_attr($product->get_id()); ?>" value="<?php echo esc_attr($product->get_stock_quantity()); ?>">
            </td>
            <td><?php echo esc_html($product->get_stock_status()); ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">No products found.</td>
        </tr>
      <?php endif; ?>
    </tbody>

  </table>

</div>