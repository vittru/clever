function modifyBasket() {
    var canBeBought = false;
    $('.quantity:visible').each(function() {
        if ($(this).val() > 0) {
            canBeBought = true;
        };
    });
    $('.aa-add-to-cart-btn').attr('disabled', !canBeBought);
    $('.aa-quick-order-btn').attr('disabled', !canBeBought);
}

//$(document).ready(modifyBasket());

$('.aa-add-to-cart-btn').click(function e(){
    $(this).text('Добавлено');
    if (window.location.hostname !== "localhost") {
        yaCounter44412517.reachGoal('INCART');
    }    
        
    var pId = $('#pId').text();
    var sizes = [];
    $('.quantity:visible').each(function() {
        if ($(this).val() > 0) {
            var obj = {};
            obj['goodId'] = pId;
            obj['sizeId'] = $(this).prop("id").substring(3);
            obj['count'] = $(this).val();
            obj['price'] = $(this).attr("data-price");
            obj['sale'] = $(this).attr("data-sale");
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

$(document).ready(function e() {
    var url = document.location.toString(); // select current url shown in browser.
    if (url.match('#')) {
        $('.nav-tabs a[href=#' + url.split('#')[1] + ']').tab('show'); // activate current tab after reload page.
    }
});   
    // Change hash for page-reload
$('.nav-tabs a').on('shown', function (e) { // this function call when we change tab.
    window.location.hash = e.target.hash; // to change hash location in url.
    alert(window.location.hash);
});

$('.aa-quick-order-btn').click(function e(){
    $('#quickOrderOrder').show();
    $('#quickOrderComplete').hide();

    var pId = $('#pId').text();
    var i = 1;
    var sum = 0;
    $('.quantity:visible').each(function() {
        if ($(this).val() > 0) {
            $('#quickOrderGoodId').val(pId);
            $('#quickOrderSizeId'+i).val($(this).prop("id").substring(3));
            $('#quickOrderSizeSale'+i).val($(this).attr("data-sale"));
            $('#quickOrderSize'+i).html($(this).attr("data-size"));
            $('#quickOrderQuantity'+i).html($(this).val());
            $('#quickOrderQuantity'+i).parent().show();
            $('#quickOrderPrice'+i).html($(this).attr("data-price"));
            sum=+sum + +$(this).attr("data-price")*+$(this).val();
            i++;
        };
    });
    for (j=i;j<=3;j++){
        $('#quickOrderQuantity'+j).parent().hide();
    }
    $('#quickOrderTotalPrice').html(sum);
});

$('#quickOrderSubmit').click(function e(){
    var sizes = [];
    var obj = {};
    obj['goodId'] = $('#quickOrderGoodId').val();
    obj['sizeId'] = $('#quickOrderSizeId1').val();
    obj['count'] = $('#quickOrderQuantity1').html();
    obj['price'] = $('#quickOrderPrice1').html();
    obj['sale'] = $('#quickOrderSizeSale1').val();
    sizes.push(obj);
    if ($('#quickOrderSizeId2').val()) {
        var obj = {};
        obj['goodId'] = $('#quickOrderGoodId').val();
        obj['sizeId'] = $('#quickOrderSizeId2').val();
        obj['count'] = $('#quickOrderQuantity2').html();
        obj['price'] = $('#quickOrderPrice2').html();
        obj['sale'] = $('#quickOrderSizeSale2').val();
        sizes.push(obj);
    }
    if ($('#quickOrderSizeId3').val()) {
        var obj = {};
        obj['goodId'] = $('#quickOrderGoodId').val();
        obj['sizeId'] = $('#quickOrderSizeId3').val();
        obj['count'] = $('#quickOrderQuantity3').html();
        obj['price'] = $('#quickOrderPrice3').html();
        obj['sale'] = $('#quickOrderSizeSale3').val();
        sizes.push(obj);
    }
    $.ajax({
        type: "POST",
        url: "/buy/quick",
        data: {data : JSON.stringify(sizes),
        email: $('#quickOrderEmail').val(),
        phone: $('#quickOrderPhone').val()},
        success: function(a) {
            if (!isNaN(a)) {
                $("#quickOrderId").html(a);
                $('#quickOrderOrder').hide();
                $('#quickOrderComplete').show();
            }else {
                $("#quickOrderError").show();
                $("#quickOrderError").html(a);
            }
        }    
    });
});

$(document).on("mouseleave", ".aa-add-to-cart-btn", function() {
    $(this).parent().find(".aa-add-to-cart-btn").html('<span class="fa fa-shopping-cart"></span>В корзину');
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  var target = $(e.target).attr("href"); // activated tab
  modifyBasket();
  if (target === "#bb") {
      $('.aa-add-to-cart-btn').show();
      $('.aa-quick-order-btn').show();
      $('#emailMeBtn').hide();
  } else {
      if (!$('.quantity:visible').length) {
        $('.aa-add-to-cart-btn').hide();
        $('.aa-quick-order-btn').hide();
        $('#emailMeBtn').show();
      }
  }
});

$('#addReview').click(function a() {
    $('#reviewGoodId').val($('#pId').text());
});
