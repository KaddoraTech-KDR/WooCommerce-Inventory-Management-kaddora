<?php

$inventory_class = new WCIM_Inventory_KDR();

$search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

// $products = $inventory_class->get_products_with_stock($search);
$products = $inventory_class->get_inventory_data($search);

?>

<div class="wrap inventory">

  <div class="inventory-content">
    <h1>Inventory</h1>

    <!-- search -->
    <form method="get" class="inventory-search-form">
      <input type="hidden" name="page" value="wcim-kdr-inventory">
      <input type="text" name="search" placeholder="Search product..." value="<?php echo esc_attr($_GET['search'] ?? ''); ?>">
      <button class="button button-primary" type="submit">Search</button>
    </form>
  </div>

  <!-- table -->
  <table class="widefat fixed striped">

    <thead>
      <tr class="table-header">
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
            <td><?php echo esc_html($product['id']); ?></td>
            <td>
              <a href="<?php echo esc_url(get_permalink($product['id'])); ?>" class="product-link">
                <?php echo esc_html($product['name']); ?>
              </a>
            </td>
            <td><?php echo esc_html($product['sku']); ?></td>
            <td>
              <input type="number" min="0" class="wcim-stock-input" data-product="<?php echo esc_attr($product['id']); ?>" value="<?php echo esc_attr($product['stock']); ?>">
            </td>
            <td><?php echo esc_html($product['status']); ?></td>
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