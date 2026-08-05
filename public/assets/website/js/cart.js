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
			renderMiniCart(res.cart, res.total);
		}
	});
});

// Add To Cart Button
$(document).on('click', '.add-to-cart, .add-to-cart-from-wishlist', function (e) {
	console.log('click');

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

			// تحديث الميني كارت
			renderMiniCart(res.cart, res.total);
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

	let qty = item.find('input').length
		? parseInt(item.find('input').val())
		: parseInt(item.find('.qty').text());
	// console.log(qty);

	updateCart(productId, qty + 1);
});

// Decrement
$(document).on('click', '.qty-minus', function () {

	let item = $(this).closest('.mini_cart_item, .cart_row');
	let productId = item.data('product-id');

	let qty = item.find('input').length
		? parseInt(item.find('input').val())
		: parseInt(item.find('.qty').text());

	// لو الكمية 1 → نحذف المنتج
	if (qty <= 1) {
		updateCart(productId, 0);
		return;
	}

	updateCart(productId, (qty - 1));

});


// function isCartPage() {
// 	return $('.cart_page').length > 0;
// }


// mini cart update
// function updateCart(productId, quantity) {

// 	$.ajax({
// 		url: '/cart/update',
// 		method: 'POST',
// 		data: {
// 			product_id: productId,
// 			quantity: quantity
// 		},
// 		headers: {
// 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
// 		},
// 		success: function (res) {

// 			renderMiniCart(res.cart, res.total);
// 			if (isCartPage()) {
// 				renderCartPage(res.cart, res.total);
// 			}
// 		}
// 	});
// }


function updateCart(productId, quantity) {

	$.ajax({
		url: '/cart/update',
		method: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			product_id: productId,
			quantity: quantity
		},

		success: function (response) {

			renderMiniCart(response.cart, response.total);
			renderCartPage(response.cart);


			$('#cart-total').text(response.total + ' EGP');
			$('#mini_cart_total').text(response.total + ' EGP');
		},

		error: function (xhr) {

			Swal.mixin({
				toast: true,
				position: "top",
				showConfirmButton: false,
				timer: 3500,
				timerProgressBar: true,
			}).fire({
				icon: "warning",
				text: xhr.responseJSON.message
			});

		}
	});
}

// Cart Page Update
function renderCartPage(cart, total) {

	let html = '';
	let grandTotal = 0;

	cart.forEach(item => {

		grandTotal += item.product.final_price * item.quantity;

		html += `

        <div class="cart_row" data-product-id="${item.product.id}">

            <div class="cart_col image">
                <a href="/product-details/${item.product.id}">
					<img src="${item.product.image ?? 'uploads/products/no_img.jpg'}" >
				</a>
            </div>

            <div style="font-size: 14px;
    					font-weight: 500;
    					color: #222;
    					display: -webkit-box;
    					-webkit-line-clamp: 2;
    					-webkit-box-orient: vertical;
    					overflow: hidden;">
                ${item.product.name}
            </div>

            <div class="cart_col price">
			<span style="font-size: 11px; color: #888;"> Price </span>
				<div style="font-weight: 600; color: #0e8ce4;">
                ${item.product.final_price} EGP
            	</div>
            </div>

            <div class="cart_col qty">
                <div class="qty_box">
                    <button class="qty-minus">-</button>
                    <input class="qty" value="${item.quantity}">
                    <button class="qty-plus">+</button>
                </div>
            </div>

            <div class="cart_col total">
			<span style="font-size: 11px; color: #888; ">Total</span>
				<div style="font-weight: 600; color: #0e8ce4;">
                ${item.product.final_price * item.quantity} EGP
				</div>
            </div>

            <div class="cart_col remove">
                <button class="remove_btn">×</button>
            </div>
        </div>
		`;

	});

	$('.cart_wrapper').html(html);
	$('.cart-total').text(grandTotal + ' EGP');
}



// Render Cart
function renderMiniCart(cart, total) {
	// console.log('RENDER CART', cart);

	let html = '';
	let count = 0;

	count = (cart.length);

	cart.forEach(item => {
		// console.log(count);

		// console.log(item.product);
		html += `
				<div class="mini_cart_item" data-product-id="${item.product.id}">
				<a href="/product-details/${item.product.id}">
					<img src="${item.product.image ?? 'uploads/products/no_img.jpg'}" width="50" height="42">
            	</a>
              	<div class="item_name"> ${item.product.name}</div>
                <div class="qty_controls">
				<button class="qty-minus">-</button>
				<span class="qty">${item.quantity}</span>
				<button class="qty-plus">+</button>
                </div>
                <div class='mini-cart-total ' >
				${item.product.final_price * item.quantity} EGP
				</div>
				<div class="cart_col remove">
                    <button class="remove_btn" data-source="mini">×</button>
                </div>
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



// Delete Product
$(document).on('click', '.remove_btn', function () {

	let item = $(this).closest('[data-product-id]');
	let productId = item.data('product-id');

	updateCart(productId, 0);
});
