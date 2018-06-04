jQuery.expr[':'].icontains = function(a, i, m) {
    return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
};

$(document.body).on('hidden.bs.modal', function () {
    $('#single-product').removeData('bs.modal');
});

var nameAsc = true;
var priceAsc = true;

function filter() {
    $("ul.aa-product-catg li.good").show();
    if ($("div.tab-pane.active #showAvailable").is(":checked")) {
        $("div.tab-pane.active li.good").has('.aa-sold-out').hide();
    };
    if ($("div.tab-pane.active #showSale").is(":checked")) {
        $("div.tab-pane.active li.good").not(":has('.aa-sale')").hide();
    };
    var word = $("#showWord").val().trim();
    if (word) {
        $("div.tab-pane.active li.good").not(":icontains('" + word + "')").hide();
    };     
}    

$("#nameSortButton").on("click", function () {
    var alphabeticallyOrderedDivs = $("ul.aa-product-catg li.good").sort(function (a, b) {
        return (nameAsc == ($(a).find(".aa-product-title").text() > $(b).find(".aa-product-title").text())) ? 1 : -1;
    });
    nameAsc = nameAsc ? false : true;
    $("div.aa-sort-form").find(".sortAsc").hide();
    $("div.aa-sort-form").find(".sortDesc").hide();
    
    if (nameAsc) {
        $(this).find(".sortAsc").show();
    } else {
        $(this).find(".sortDesc").show();
    }    
    $("ul.aa-product-catg").html(alphabeticallyOrderedDivs);
});

$("#priceSortButton").on("click", function () {
    var numericallyOrderedDivs = $("ul.aa-product-catg li.good").sort(function (a, b) {
        return (priceAsc == (parseInt($(a).find(".aa-product-price").attr('value')) > parseInt($(b).find(".aa-product-price").attr('value')))) ? 1 : -1;
    });
    priceAsc = priceAsc ? false : true;
    $("div.aa-sort-form").find(".sortAsc").hide();
    $("div.aa-sort-form").find(".sortDesc").hide();
    
    if (priceAsc) {
        $(this).find(".sortAsc").show();
    } else {
        $(this).find(".sortDesc").show();
    }    
    $("ul.aa-product-catg").html(numericallyOrderedDivs);
});

//$(document).on("click", "#showAvailable", filter);

//$(document).on("click", "#showSale", filter);

$("#showWord").on("change keyup paste input", filter_goods);

$(document).on("click", ".aa-remove-product", function() {
    var id = $(this).attr('id'),
        sid = $(this).attr('value');

    $.ajax({    
        type: "GET",   
        url: "/cart/remove",   
        data: "id=" + id + "&sid=" + sid,
        dataType: "html",
        success: function (){
            $(".cart-view-table").load(location.href + " .cart-view-table>*","");
            $("#cartbox").load(location.href + " #cartbox>*","");
        }
    });
});

$(document).on("change", ".aa-cart-quantity", function() {
    var tr = $(this).parent().parent();
    var id = $(tr).find('.aa-remove-product').attr('id'),
        sid = $(tr).find('.aa-remove-product').attr('value'),
        count = $(this).val();
    $.ajax({
        type: "GET",
        url: "/cart/update",
        data: "id=" + id + "&sid=" + sid + "&c=" + count,
        dataType: "html",
        success: function(){
            $(".cart-view-table").load(location.href + " .cart-view-table>*","");
            $("#cartbox").load(location.href + " #cartbox>*","");
        }    
    });    
});    

$(document).on("click", ".aa-add-card-btn", function () {
    $(this).text('Добавлено');
    var host = window.location.hostname;
    if(host != "localhost") {
        yaCounter44412517.reachGoal('INCART');
    }    
        
    var obj = {};
    obj['goodId'] = $(this).attr("id");
    obj['sizeId'] = $(this).attr("value");
    obj['count'] = 1;
    obj['price'] = $(this).attr("data-price");
    obj['sale'] = $(this).attr("data-sale");
    var sizes=[obj];

    $.ajax({
        type: "POST",
        url: "/cart/add",
        data: {data : JSON.stringify(sizes)},
        success: function() {
            $("#cartbox").load(location.href + " #cartbox>*","");
        }    
    });
});

$(document).on("mouseleave", "li.good", function() {
    $(this).parent().find(".aa-add-card-btn").html('<span class="fa fa-shopping-cart"></span>В корзину');
});

$('.panel-heading a').on('click',function(e){
    if($(this).parents('.panel').children('.panel-collapse').hasClass('in')){
        e.stopPropagation();
    }
    e.preventDefault();
})

$('#order-form').submit(function(e) {
    var submit = true;
    if ($("#discount").is(":hidden")) {
        $("#promo").val('');
        $("#bonus").val('');
    }
    if (!$("#promo-error").is(":hidden") || $("#promo").is(":hidden")){
        $("#promo").val('');
    }
    if (!$("#bonus-error").is(":hidden") || $("#bonus").is(":hidden")){
        $("#bonus").val('');
    }
    $('input.required').each(function(){
        if(!$(this).is(":hidden") && !$(this).val().trim())
            submit = false;
     });
    $('textarea.required').each(function(){
        if(!$(this).is(":hidden") && !$(this).val().trim())
            submit = false;
     });
     if (!$('#branch').is(':hidden') && !$('#branch').val())
         submit = false;
     if (!submit) {
         e.preventDefault();
         $('#order-error').show();
     } else {
        //We're disabling all hidden fields to avoid sending them to backend
        $('input.order-form:hidden').attr("disabled", true);
        $('textarea.order-form:hidden').attr("disabled", true);
        $('#branch:hidden').attr("disabled", true);
     };    
});

$(document).on('click', '.aa-search-box .dropdown-lg', function (e) {
    e.stopPropagation();
});

$(document).on('click', '.aa-search-box #search-text', function (e) {
    e.stopPropagation();
});

function applyDiscount(a, error) {
    JSON.parse(a, function(k, v) {
        var code = true;
        if (k === 'error') {
            if (v) {
                error.text(v);
                error.show();
                code = false;
            } else {
                error.hide();
            }    
        }
        if (!code) {
            $('#discount').hide();
        } else {
            if (k === 'discount') {
                if (v) {
                    $('#discount').find('#sum').text(v + ' руб.');    
                    $('#discount').show();
                } else {
                    $('#discount').hide();
                }
            }    
            if (k === 'percent' && v) {
                $('#discount').find('#sum').text(v + ' %');    
                $('#discount').show();                            
            }
        }
        if (k === 'total') {
            $('#total').text(v + ' руб.');
            if (v < $('#freeDelivery').text()) {
                $('#amount-left').text($('#freeDelivery').text()-v);
                $('#delivery-info').show();
            } else {
                $('#delivery-info').hide();
            }
        }
    });

};

function checkPromo(promo) {
    $.ajax({    
        type: "GET",   
        url: "/buy/checkpromo",   
        data: "promo=" + promo,
        dataType: "html",
        success: function (a){
            applyDiscount(a, $('#promo-error'));
        }
    });
    if (!promo) {
        $('#discount').hide();
        $('#promo-error').hide();
    }    
}

$(document).on('change', '#promo', function() {
    checkPromo($(this).val().trim());
});

$('#promo').on('keyup', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    checkPromo($(this).val().trim());
    return false;
  }
});

$('#order-form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});

$('#change-order-status').on('click', function() {
    var orderId = $("[name='id']").val();
    var statusId = $('#status').val();
    $.ajax({    
        type: "GET",   
        url: "/account/updateorder",   
        data: "order=" + orderId + "&status="+statusId,
        dataType: "html"
    }); 
    location.reload();
});

$('#search-text').on('focus', function() {
    $('#search-dropdown').addClass('open'); 
});

$(document).on('click', function(e) {
    if (!$(e.target).closest('#search-dropdown').length) {
        $('#search-dropdown').removeClass('open'); 
    }    
});

$('#panel-bonus').on('click',function(){
    if(!$(this).parents('.panel').children('.panel-collapse').hasClass('in')){
        $('#promo').val('');
        checkPromo($('#promo').val().trim());
    }
});

$('#use-bonus').on('click', function() {
    $.ajax({
        type: "GET",   
        url: "/buy/checkbonus",   
        data: "bonus=" + $('#bonus').val(),
        dataType: "html",
        success: function (a){
            applyDiscount(a, $('#bonus-error'));
        }
    });
    $(this).blur();
});

$(".SlectBox").on("change", filter_goods);

function filter_goods() {
    $("#empty-catg").hide();
    $("ul.aa-product-catg li.good").show();
    $(".SlectBox").each(function() {
        var criteria = new Array();
        $(this).find("option:selected").each(function() {
            criteria.push($(this)[0].id);
        });
        if (criteria.length > 0) {
            $("ul.aa-product-catg li.good").each(function() {
                var shown = false;
                var i = 0;
                while (!shown && i < criteria.length) {
                    if ($(this).has('div.' + criteria[i]).length)
                        shown = true;
                    else
                        i++;
                };
                if (!shown)
                    $(this).hide();
            });
        };
    });
    var word = $("#showWord").val().trim();
    if (word) {
        $("ul.aa-product-catg li.good").not(":icontains('" + word + "')").hide();
    };
    if($("ul.aa-product-catg").children(':visible').length == 0) {
        $("#empty-catg").show();
    }
};    

$("input[name=payment]").on('change', function () {
    if (this.value == 'card') {
        $('#make_order').val('Заказать и оплатить');
    } else {
        $('#make_order').val('Заказать');
    }    
});


$(document).ready(function () {
    $('.SlectBox').SumoSelect({captionFormat: '{0} выбрано', captionFormatAllSelected:'Все {0} выбраны'});
    $('#city').editableSelect();
});

$("#subscribe-form").submit(function(e) { 
    e.preventDefault(); 
    var email=$("#subscribe-email").val();
    $.ajax({
        type: "POST",
        url: "subscribe",
        data: "userEmail=" + email,
        dataType: "html",
        dataFilter: function(a) {
            return $(a).filter("#error").html();
        },
        success: function(a) {
            if (a == null) {
                window.location.reload();
            }else {
                $("#subscribe-error").show();
                $("#subscribe-error").html(a);
            }
        }
    });
});

$("#subscribe-email").focus(function(){
    $('#subscribe-error').hide();
});


$('#sendTestEmail').click(function() {
    var mysave =  $('#description').summernote('code');
    $('#text').val(mysave);
    $.post('/mailout/testEmail',
    {
        header: $('#header').val(),
        text: $('#text').val(),
        email: $('#testEmail').val()
    },
    function(data, status){
        alert(data);
    });
});

$(document).on("click", ".aa-emailme-btn", function () {
    $('#emailMe').modal('show');
    $('#emailGoodId').val($(this).offsetParent().find('.aa-product-img').attr('href').substring(13,20));
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
    if ($('#pId').length) {
        goodEmail = $('#pId').text();
    } else {
        goodEmail = $('#emailGoodId').val();
    }
    if (address) {
        $.ajax({
            type: "GET",
            url: "/showgood/emailMe",
            data: {
                address: address,
                good: goodEmail 
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

$('[data-toggle=popover]').popover({
  trigger:"click"
});

$('[data-toggle=popover]').on('click', function (e) {
   $('[data-toggle=popover]').not(this).popover('hide');
});

$('.aa-quick-order-btn').on('click', function() {
    $('#quickOrderCount').val(1);
    $('#quickOrderError').hide();
    if ($('.image-good').length) {
        $('#quickOrderImage').attr('src',$('.image-good').attr('src'));
        $('#quickOrderGood').html($('.modal-title').html());
    } else {
        $('#quickOrderImage').attr('src',$(this).offsetParent().find('img').attr('src'));
        $('#quickOrderGood').html($(this).offsetParent().find('div.aa-product-title a').html());
        $('#quickOrderQuantity').html('1');
        $('#quickOrderPrice').html($(this).offsetParent().find('.aa-product-price').html());
    }    
});
