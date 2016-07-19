function modifyBasket() {
    var canBeBought = false;
    $('.quantity').each(function() {
        if ($(this).val() > 0) {
            canBeBought = true;
        };
    });
    $('.aa-add-to-cart-btn').attr('disabled', !canBeBought);
}

$(document).ready(modifyBasket());


