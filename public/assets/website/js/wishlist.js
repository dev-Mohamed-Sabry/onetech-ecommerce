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