<?php
if (!defined("ABSPATH")) exit;

class WCIM_Ajax_KDR
{
  // update_stock
  public function update_stock()
  {
    check_ajax_referer('wcim_kdr_admin_nonce', 'nonce');

    if (!current_user_can('manage_woocommerce')) {
      wp_send_json_error('Permission denied');
    }

    $product_id = intval($_POST['product_id']);

    // new stock
    $stock = intval($_POST['stock']);

    $product = wc_get_product($product_id);
    if (!$product) {
      wp_send_json_error('Product not found');
    }

    // old stock
    $old_stock = $product->get_stock_quantity();
    if ($old_stock === null) {
      $old_stock = 0;
    }

    if (class_exists('WCIM_Logs_KDR')) {
      WCIM_Logs_KDR::insert_log(
        $product_id,
        $old_stock,
        $stock,
        'manual'
      );
    }

    $product->set_stock_quantity($stock);
    $product->save();

    wp_send_json_success(array(
      'message' => 'Stock updated',
      'old_stock' => $old_stock,
      'new_stock' => $stock
    ));
  }
}
