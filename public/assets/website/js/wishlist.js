'use strict'


// Toggle
$(document).on('click', '#wishlistToggle', function (e) {
    e.preventDefault();
    $('#miniWishlist').toggle();
});

$(document).on('click', function (e) {
    if (!$(e.target).closest('.wishlist_wrapper').length) {
        $('#miniWishlist').hide();
    }
});

// Add To Wishlist Button
$(document).on('click', '.product_fav', function (e) {
    e.preventDefault();

    let productId = $(this).data('product-id');
    $(this).addClass('active');

    // productId ? console.log('Clicked') : null;
    $.ajax({
        url: '/wishlist/add',
        method: 'POST',
        data: {
            product_id: productId,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (res) {

            if (res.success) {
                Swal.mixin({
                    toast: true,
                    position: "top-right",
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                }).fire({
                    icon: "success",
                    title: res.message ?? "Item Added To Wishlist Successfully",
                });
                console.log(res);
            }

            // تحديث wishlist
            renderMiniWishlist(res.wishlist);
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
});


// Wishlist render
function renderMiniWishlist(wishlist) {
    let html = '';
    let count = wishlist.length;
    let total = 0;

    wishlist.forEach(item => {
        total += Number(item.product.final_price);
        html += `
			<div class="mini_wishlist_item" data-product-id="${item.product.id}">
				<img src="${item.product.image}" width="50" height="42">

              	<div class="item_name"> ${item.product.name} </div>
              	<div class="item_name"> ${item.product.final_price} </div>
				<div class="cart_col remove">
                    <button class="wishlist_remove_btn" data-source="mini">×</button>
                </div>
            </div>
        `;
    });

    // console.log(html, total);
    if (wishlist.length === 0) {
        html = `<div class="empty_wishlist">Your wishlist is empty</div>`;
    };


    $('#wishlist-items').html(html);
    $('#wishlist-count').text(count);
    $('#wishlist-footer-count').text(count);
    $('#wishlist-footer-total').text(total + ' EGP');
};


// Show All Products In Wishlist
$(document).ready(function () {
    $.ajax({
        url: '/wishlist',
        method: 'GET',
        success: function (res) {
            renderMiniWishlist(res.wishlist);
        }
    });
});



// Delete Button
$(document).on('click', '.wishlist_remove_btn', function () {
    let item = $(this).closest('[data-product-id]');
    let productId = item.data('product-id');
    $(this).removeClass('active');

    $.ajax({
        url: '/wishlist/remove',
        method: 'POST',
        data: {
            product_id: productId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            if (res.success) {
                renderMiniWishlist(res.wishlist);
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        },
    })
});