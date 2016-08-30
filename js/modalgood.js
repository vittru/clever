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

$('.aa-add-to-cart-btn').click(function e(){
    var pId = $('#pId').text();
    var sizes = [];
    $('.quantity').each(function() {
        if ($(this).val() > 0) {
            var obj = {};
            obj['goodId'] = pId;
            obj['sizeId'] = $(this).prop("id").substring(3);
            obj['count'] = $(this).val();
            sizes.push(obj);
        };
    });
    $.ajax({
        type: "POST",
        url: "/cart/add",
        data: {data : JSON.stringify(sizes)},
        success: function() {
            $("#cartbox").load(location.href + " #cartbox>*","");
        }    
    });
});		
