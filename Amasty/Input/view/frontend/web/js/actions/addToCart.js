require(['jquery', 'Magento_Customer/js/customer-data'], function ($, customerData) {

    $(document).ready(function () {
        var xhr = null;
        $('#input-sku').on('keypress', function () {

            if (xhr) {
                xhr.abort();
            }

            xhr = $.ajax({

                url: 'customrouter/action/autocomplete',
                data: $('#wholesale-form').serialize(),
                beforeSend: function () {
                    $('#skus').empty();
                },
                success: function (response) {

                    for (var sku in response) {
                        $('#skus').append($('<option>').attr('value', sku).text(response[sku]));
                    }

                    xhr = null;
                }
            });
        });

        $('#input-sku').on('blur', function () {
            $('#skus').empty();
        })

        $('#submitAdding').on('click', function (e) {

            $.ajax({
                url: 'checkout/cart/add',
                type: 'POST',
                data: $('#wholesale-form').serialize(),
                beforeSend: function (data) {
                    console.log('before send sku');
                    console.log(data);

                },
                success: function () {
                    console.log("addeda");
                    var sections = ['cart'];
                    customerData.reload(sections, true);
                }
            });
        });
    });
});
