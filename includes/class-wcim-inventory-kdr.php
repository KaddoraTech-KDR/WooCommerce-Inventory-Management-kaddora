<?php
if (!defined("ABSPATH")) exit;

class WCIM_Inventory_KDR
{
  // get_total_products
  public function get_total_products()
  {
    $args = [
      'status' => 'publish',
      'limit'  => -1,
      'return' => 'ids'
    ];

    $products = wc_get_products($args);

    return count($products);
  }

  // get_products_with_stock
  public function get_products_with_stock($search = '')
  {
    $args = [
      'status' => 'publish',
      'limit'  => -1
    ];

    if (!empty($search)) {
      $args['search'] = '*' . $search . '*';
    }

    return wc_get_products($args);
  }

  // get_inventory_data
  public function get_inventory_data($search = '')
  {
    $products = $this->get_products_with_stock($search);

    $inventory = [];

    foreach ($products as $product) {

      $inventory[] = [
        'id' => $product->get_id(),
        'name' => $product->get_name(),
        'sku' => $product->get_sku(),
        'stock' => $product->get_stock_quantity(),
        'status' => $product->get_stock_status(),
      ];
    }

    return $inventory;
  }

  // get_low_stock_products
  public function get_low_stock_products()
  {
    $options = get_option('wcim_kdr_settings');

    $threshold = $options['low_stock_threshold'] ?? 5;

    $products = $this->get_products_with_stock();

    $low_products = [];

    foreach ($products as $product) {

      $stock = $product->get_stock_quantity();

      if ($stock !== null && $stock <= $threshold && $stock > 0) {
        $low_products[] = $product;
      }
    }

    return $low_products;
  }

  // get_low_stock_count
  public function get_low_stock_count()
  {
    return count($this->get_low_stock_products());
  }

  // get_out_of_stock_count
  public function get_out_of_stock_count()
  {
    $products = $this->get_products_with_stock();

    $count = 0;

    foreach ($products as $product) {

      if ($product->get_stock_status() === 'outofstock') {
        $count++;
      }
    }

    return $count;
  }
}
