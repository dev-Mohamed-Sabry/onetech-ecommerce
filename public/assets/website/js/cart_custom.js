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
			// $.get('/cart', console.log)
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
					title: res.message ?? "Item Added To Cart Successfully",
				});
			}

			// console.log('ADD RESPONSE', res);
			renderCart(res.cart, res.total);
		},
		error: function (xhr) {
			console.log(xhr.responseText);
		}
	});
});


// Update Cart

// Increment
$(document).on('click', '.qty-plus', function () {

	let item = $(this).closest('.mini_cart_item, .cart_row');
	let productId = item.data('product-id');

	let qty = item.find('.qty').length
		? parseInt(item.find('.qty').text())
		: parseInt(item.find('input').val());

	updateCart(productId, qty + 1);
});

// Decrement
$(document).on('click', '.qty-minus', function () {

	let item = $(this).closest('.mini_cart_item, .cart_row');
	let productId = item.data('product-id');

	let qty = item.find('.qty').length
		? parseInt(item.find('.qty').text())
		: parseInt(item.find('input').val());

	// لو الكمية 1 → نحذف المنتج
	if (qty <= 1) {
		updateCart(productId, 0);
		return;
	}

	updateCart(productId, (qty - 1));
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
	// console.log('RENDER CART', cart);

	let html = '';
	let count = 0;

	cart.forEach(item => {
		count += item.quantity;
		// console.log(item.product);
		html += `
				<div class="mini_cart_item" data-product-id="${item.product.id}">
				<img src="${item.product.image}" width="50"> 
              	<div class="item_name"> ${item.product.name}</div>
                <div class="qty_controls">
					<button class="qty-plus">+</button>
					<span class="qty">${item.quantity}</span>
					<button class="qty-minus">-</button>
                </div>

                <div class='mini-cart-total' >${item.product.final_price * item.quantity} EGP</div>
            </div>
        `;
	});

	// console.log(html, total);
	if (cart.length === 0) {
		html = `<div class="empty_cart">Your cart is empty</div>`;
	}

	$('#mini-cart-items').html(html);
	$('#mini-cart-total').text(total + ' EGP');
	$('#cart-total').text(total + ' EGP');
	$('#cart-count').text(count);
}
// End Mini Cart Functions