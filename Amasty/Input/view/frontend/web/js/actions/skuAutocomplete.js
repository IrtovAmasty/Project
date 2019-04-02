require([
    'jquery'
], function ($) {
    $(function () {
        const inputField = $('#input-sku');
        let ajaxQuery = null;
        inputField.on('keypress', function () {
            if (inputField.val().length > 3) {
                if (ajaxQuery) {
                    ajaxQuery.abort();
                }
                ajaxQuery = $.ajax({
                    url: "/Input/Actions/Autocomplete",
                    data: {'searchPattern': inputField.val()},
                    success: function (data) {
                        try {
                            JSON.parse(data);
                            fillAutoComplete(data);
                        } catch (e) {
                            console.log("Something went wrong");
                        }
                    }
                });
            }
        });
    });

    function fillAutoComplete(data) {
        data.forEach(function () {
        });
    }
});