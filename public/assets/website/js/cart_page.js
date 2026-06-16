// Delete Product
$(document).on('click', '.remove_btn', function () {

    let item = $(this).closest('.cart_row');
    let productId = item.data('product-id');

    updateCart(productId, 0);
    window.location.reload();
});