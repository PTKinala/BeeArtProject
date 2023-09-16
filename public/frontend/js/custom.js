/* location.reload(); */

$(document).ready(function () {
    loadcart();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    function loadcart() {
        $.ajax({
            method: "GET",
            url: "/load-cart-data",
            successs: function (response) {
                $(".cart-count").html("");
                $(".cart-count").html(response.count);
            },
        });
    }

    $(".addToCartBtn").click(function (e) {
        e.preventDefault();

        var product_id = $(this)
            .closest(".product_data")
            .find(".prod_id")
            .val();
        var product_qty = $(this)
            .closest(".product_data")
            .find(".qty-input")
            .val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "POST",
            url: "/add-to-cart",
            data: {
                product_id: product_id,
                product_qty: product_qty,
            },
            success: function (response) {
                if (response.status == "success") {
                    swal({
                        text: response.message,
                        icon: "success",
                        confirmButton: true,
                        confirmButtonText: "OK",
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    swal({
                        text: response.message,
                        icon: "error",
                        confirmButton: true,
                        confirmButtonText: "OK",
                    });
                }
                loadcart();
                /*   swal({
                    text: response.status,
                    icon: "error",
                    confirmButton: true,
                    confirmButtonText: "OK",
                }).then((result) => {
                    location.reload();
                });
                loadcart(); */
            },
        });
    });

    $(".increment-btn").click(function (e) {
        e.preventDefault();

        var inc_value = $(this)
            .closest(".product_data")
            .find(".qty-input")
            .val();
        var value = parseInt(inc_value, 10);
        value = isNaN(value) ? 0 : value;
        if (value < 10) {
            value++;
            $(this).closest(".product_data").find(".qty-input").val(value);
        }
    });

    $(".decrement-btn").click(function (e) {
        e.preventDefault();

        var dec_value = $(this)
            .closest(".product_data")
            .find(".qty-input")
            .val();
        var value = parseInt(dec_value, 10);
        value = isNaN(value) ? 0 : value;
        if (value > 1) {
            value--;
            $(this).closest(".product_data").find(".qty-input").val(value);
        }
    });

    $(".delete-cart-item").click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest(".product_data").find(".prod_id").val();
        $.ajax({
            method: "POST",
            url: "delete-cart-item",
            data: {
                prod_id: prod_id,
            },
            success: function (response) {
                window.location.reload();
                swal("", response.status, "success");
            },
        });
    });

    $(".changeQuantity").click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest(".product_data").find(".prod_id").val();
        var qty = $(this).closest(".product_data").find(".qty-input").val();
        data = {
            prod_id: prod_id,
            prod_qty: qty,
        };

        $.ajax({
            method: "POST",
            url: "update-cart",
            data: data,
            success: function (response) {
                window.location.reload();
            },
        });
    });

    $("#qty-id").on("change", function (e) {
        /*   e.preventDefault(); */

        var ordersText = $("#orders-id").text();
        var qtyValue = $("#qty-id").val();

        var data = {
            ordersText: ordersText,
            qtyValue: qtyValue,
        };

        $.ajax({
            method: "POST",
            url: "/price-orders",
            data: data,
            success: function (response) {
                var formattedPrice = new Number(response.price).toLocaleString(
                    undefined,
                    { minimumFractionDigits: 2, maximumFractionDigits: 2 }
                );

                $("#result-text").text((formattedPrice += " บาท"));
                $("#input-price-id").val(response.price);

                // ทำงานกับข้อมูลที่ได้จากการร้องขอ AJAX ที่ response
            },
        });
    });
});
