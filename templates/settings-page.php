<?php

$options = get_option('wcim_kdr_settings');

$threshold = $options['low_stock_threshold'] ?? 5;
$alerts = $options['enable_alerts'] ?? 'yes';
$email = $options['alert_email'] ?? get_option('admin_email');

?>

<div class="wrap">

  <h1>Inventory Settings</h1>

  <form method="post" action="options.php" class="wcim-settings-form">

    <?php settings_fields('wcim_kdr_settings_group'); ?>

    <table class="form-table">

      <tr>
        <th>Low Stock Threshold</th>
        <td>
          <input type="number"
            name="wcim_kdr_settings[low_stock_threshold]"
            value="<?php echo esc_attr($threshold); ?>">
        </td>
      </tr>

      <tr>
        <th>Enable Alerts</th>
        <td>
          <select name="wcim_kdr_settings[enable_alerts]">
            <option value="yes" <?php selected($alerts, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($alerts, 'no'); ?>>No</option>
          </select>
        </td>
      </tr>

      <tr>
        <th>Alert Email</th>
        <td>
          <input type="email"
            name="wcim_kdr_settings[alert_email]"
            value="<?php echo esc_attr($email); ?>">
        </td>
      </tr>

    </table>

    <?php submit_button(); ?>

  </form>

</div>