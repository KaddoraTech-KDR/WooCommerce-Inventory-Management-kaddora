<?php
if (!defined("ABSPATH")) exit;

class WCIM_Logs_KDR
{
  // get_recent_logs
  public static function get_recent_logs($limit = 10)
  {
    global $wpdb;
    $table = $wpdb->prefix . "wcim_stock_logs_kdr";

    $logs = $wpdb->get_results(
      $wpdb->prepare("SELECT * FROM $table ORDER BY created_at DESC LIMIT %d", $limit)
    );

    return $logs;
  }

  // get_recent_updates_count
  public static function get_recent_updates_count()
  {
    global $wpdb;
    $table = $wpdb->prefix . 'wcim_stock_logs_kdr';

    $count = $wpdb->get_var(
      "SELECT COUNT(*) FROM $table"
    );

    return intval($count);
  }

  // insert
  public static function insert_log($product_id, $old_stock, $new_stock, $action = "manual")
  {
    global $wpdb;

    $table = $wpdb->prefix . "wcim_stock_logs_kdr";

    $stock_change = $new_stock - $old_stock;

    $wpdb->insert(
      $table,
      array(
        'product_id' => $product_id,
        'variation_id' => 0,
        'old_stock' => $old_stock,
        'new_stock' => $new_stock,
        'stock_change' => $stock_change,
        'action_type' => $action,
        'user_id' => get_current_user_id(),
        'created_at'   => current_time('mysql'),
      ),
      array('%d', '%d', '%f', "%f", "%f", "%s", "%d", "%s")
    );
  }
}
