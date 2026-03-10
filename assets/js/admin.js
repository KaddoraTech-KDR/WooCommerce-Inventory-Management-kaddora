jQuery(document).ready(function ($) {

  $(document).on('change', '.wcim-stock-input', function () {

    var product_id = $(this).data('product');
    var stock = $(this).val();

    console.log("AJAX TRIGGERED", product_id, stock);

    $.post(wcim_kdr_admin.ajax_url, {

      action: "wcim_kdr_update_stock",
      nonce: wcim_kdr_admin.nonce,
      product_id: product_id,
      stock: stock

    }, function (response) {

      console.log(response);

      if (response.success) {
        alert("Stock updated");
      }

    });

  });

});