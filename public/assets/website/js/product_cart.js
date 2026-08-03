$(document).on('click', '#cart_button', function (e) {

    e.preventDefault();

    let product_id = $(this).data('product-id');
    let quantity = parseInt($("#quantity_input").val()) || 1;
    let availableStock = parseInt($("#quantity_input").attr('max'));

    if (quantity < 1) {
        quantity = 1;
    }

    if (quantity > availableStock) {
        Swal.fire({
            icon: 'warning',
            text: `Available stock is only ${availableStock}`
        });

        return;
    }

    $.ajax({
        url: '/cart/add',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            product_id: product_id,
            quantity: quantity,
        },

        success: function (response) {


            Swal.mixin({
                toast: true,
                position: "top-right",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
            }).fire({
                icon: "success",
                title: response.message ?? "Item Added To Cart Successfully",
            });

            setTimeout(() => {
                window.location.reload();
            }, 1000);
        },
        error: function (xhr) {

            Swal.fire({
                icon: 'warning',
                text: xhr.responseJSON.message
            });

        }
    });

});