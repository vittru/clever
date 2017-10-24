function modifyBasket() {
    var canBeBought = false;
    $('.quantity:visible').each(function() {
        if ($(this).val() > 0) {
            canBeBought = true;
        };
    });
    $('.aa-add-to-cart-btn').attr('disabled', !canBeBought);
}

//$(document).ready(modifyBasket());

$('.aa-add-to-cart-btn').click(function e(){
    $(this).text('Добавлено');
    yaCounter44412517.reachGoal('INCART');

    var pId = $('#pId').text();
    var sizes = [];
    $('.quantity:visible').each(function() {
        if ($(this).val() > 0) {
            var obj = {};
            obj['goodId'] = pId;
            obj['sizeId'] = $(this).prop("id").substring(3);
            obj['count'] = $(this).val();
            obj['price'] = $(this).attr("data-price");
            obj['sale'] = $(this).attr("data-sale")
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

$(document).on("mouseleave", ".aa-add-to-cart-btn", function() {
    $(this).parent().find(".aa-add-to-cart-btn").html('<span class="fa fa-shopping-cart"></span>В корзину');
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  var target = $(e.target).attr("href"); // activated tab
  modifyBasket();
});

$("#emailMeBtn").click(function(){
    $('#emailMe').modal('show');
});

$("input[name=emailMeRAddr]").on('change', function () {
    if (this.value === 'phone') {
        $('#emailMePhone').removeAttr('disabled');
    } else {
        $('#emailMePhone').attr({'disabled': 'disabled'});
    }    
});

$('#emailMeSubmit').click(function() {
    var address;
    if ($('#emailMeAddr').length) 
        address = $('#emailMeAddr').val().trim();
    else {
        if ($('input[name=emailMeRAddr]:checked').val() === 'email') {
            address = $("label[for=emailMeREmail]").text().trim();
        } else
            if ($('#emailMePhone').length)
                address = $('#emailMePhone').val().trim();
            else
                address = $("label[for=emailMeRPhone]").text().trim();
    }
    if (address) {
        $.ajax({
            type: "GET",
            url: "/showgood/emailMe",
            data: {
                address: address,
                good: $('#pId').text()
            },
            success: function() {
                location.reload();
            }    
        });
    } else {
        if ($('#emailMeAddr').length) 
            $('#emailMeAddr').addClass('error');
        if ($('#emailMePhone').length && !$('#emailMePhone').attr('disabled'))
            $('#emailMePhone').addClass('error');
    }    
});