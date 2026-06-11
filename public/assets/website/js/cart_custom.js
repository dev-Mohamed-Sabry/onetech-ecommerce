// Start Mini Cart Functions

// Cart Toggle 
$(document).on('click', '#cartToggle', function (e) {
	e.preventDefault();
	$('#miniCart').toggle();
});

// إغلاق عند الضغط خارجها
$(document).on('click', function (e) {
	if (!$(e.target).closest('.cart, #miniCart').length) {
		$('#miniCart').hide();
	}
});



// Show All Products In Cart
$(document).ready(function () {
	$.ajax({
		url: '/cart',
		method: 'GET',
		success: function (res) {
			renderCart(res.cart, res.total);
		}
	});
});

// Add To Cart Button
$(document).on('click', '.add-to-cart', function (e) {
	e.preventDefault();

	let productId = $(this).data('product-id');

	// productId ? console.log('Clicked') : null;
	$.ajax({
		url: '/cart/add',
		method: 'POST',
		data: {
			product_id: productId,
			quantity: 1
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
					title: res.message ?? "Item Added To Cart Successfully ",
				});
			}
			let html = '';

			if (res.cart.length === 0) {
				html = `<div class="empty_cart">Your cart is empty</div>`;
			} else {

				res.cart.forEach(item => {
					html += `
                            <div class="mini_cart_item" data-product-id="${item.product.id}">
                                <div class="item_name"> ${item.product.name}
								</div>

                                <div class="qty_controls">
								<button class="qty-plus">+</button>
								
								<span class="qty">${item.quantity}</span>
								
								<button class="qty-minus">-</button>
                                </div>

                                <div class="item_price">
                                    ${item.product.final_price} EGP
                                </div>
                            </div>
                            `;
				});
			}

			$('#mini-cart-items').html(html);
			$('#mini-cart-total').text(res.total + ' EGP');
		},
		error: function (xhr) {
			console.log(xhr.responseText);
		}
	});
});


// Update Cart

$(document).on('click', '.qty-plus', function () {

	let item = $(this).closest('[data-product-id]');
	let productId = item.data('product-id');
	let qty = parseInt(item.find('.qty').text());

	updateCart(productId, qty + 1);
});


$(document).on('click', '.qty-minus', function () {

	let item = $(this).closest('[data-product-id]');
	let productId = item.data('product-id');
	let qty = parseInt(item.find('.qty').text());

	updateCart(productId, qty - 1);
});


function updateCart(productId, quantity) {

	$.ajax({
		url: '/cart/update',
		method: 'POST',
		data: {
			product_id: productId,
			quantity: quantity
		},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		},
		success: function (res) {
			renderCart(res.cart, res.total);
		}
	});
}



// Render Cart

function renderCart(cart, total) {

	let html = '';
	let count = 0;

	cart.forEach(item => {
		count += item.quantity;

		html += `
            <div class="mini_cart_item" data-product-id="${item.product.id}">
				 <img src="${item.product.image}" width="50"> 
              	<div class="item_name"> ${item.product.name}</div>
                <div class="qty_controls">
				<button class="qty-plus">+</button>
				<span class="qty">${item.quantity}</span>
				<button class="qty-minus">-</button>
                </div>

                <div class='item_price'>${item.product.final_price * item.quantity} EGP</div>
            </div>
        `;
	});

	if (cart.length === 0) {
		html = `<div class="empty_cart">Your cart is empty</div>`;
	}

	$('#mini-cart-items').html(html);
	$('#mini-cart-total').text(total + ' EGP');
	$('#cart-total').text(total + ' EGP');
	$('#cart-count').text(count);
}

// End Mini Cart Functions