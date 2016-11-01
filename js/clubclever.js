jQuery.expr[':'].icontains = function(a, i, m) {
    return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
};

$(document.body).on('hidden.bs.modal', function () {
    $('#single-product').removeData('bs.modal');
});

var nameAsc = true;
var priceAsc = true;

function filter() {
    $("div.tab-pane.active li.good").show();
    if ($("div.tab-pane.active #showAvailable").is(":checked")) {
        $("div.tab-pane.active li.good").has('.aa-sold-out').hide();
    };
    if ($("div.tab-pane.active #showSale").is(":checked")) {
        $("div.tab-pane.active li.good").not(":has('.aa-sale')").hide();
    };
    var word = $("div.tab-pane.active #showWord").val().trim();
    if (word) {
        $("div.tab-pane.active li.good").not(":icontains('" + word + "')").hide();
    };     
}    

$(document).on("click","#nameSortButton", function () {
    var alphabeticallyOrderedDivs = $("div.tab-pane.active li.good").sort(function (a, b) {
        return (nameAsc == ($(a).find(".aa-product-title").text() > $(b).find(".aa-product-title").text())) ? 1 : -1;
    });
    nameAsc = nameAsc ? false : true;
    $("div.tab-pane.active").find(".sortAsc").hide();
    $("div.tab-pane.active").find(".sortDesc").hide();
    
    if (nameAsc) {
        $(this).find(".sortAsc").show();
    } else {
        $(this).find(".sortDesc").show();
    }    
    $("div.tab-pane.active ul.aa-product-catg").html(alphabeticallyOrderedDivs);
});

$(document).on("click",'#priceSortButton', function () {
    var numericallyOrderedDivs = $("div.tab-pane.active li.good").sort(function (a, b) {
        return (priceAsc == (parseInt($(a).find(".aa-product-price").attr('value')) > parseInt($(b).find(".aa-product-price").attr('value')))) ? 1 : -1;
    });
    priceAsc = priceAsc ? false : true;
    $("div.tab-pane.active").find(".sortAsc").hide();
    $("div.tab-pane.active").find(".sortDesc").hide();
    
    if (priceAsc) {
        $(this).find(".sortAsc").show();
    } else {
        $(this).find(".sortDesc").show();
    }    
    $("div.tab-pane.active ul.aa-product-catg").html(numericallyOrderedDivs);
});

$(document).on("click", "#showAvailable", filter);

$(document).on("click", "#showSale", filter);

$(document).on("change keyup paste input", "#showWord", filter);

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
    $(this).text('ДОБАВЛЕНО');
    //$(this).css("background-color","#1DA93C");
    var id = $(this).attr("id"),
        sid = $(this).attr("value");
        
    var obj = {};
    obj['goodId'] = id;
    obj['sizeId'] = sid;
    obj['count'] = 1;
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

$(document).on("mouseleave", ".aa-product-img", function() {
    $(this).parent().find(".aa-add-card-btn").html('<span class="fa fa-shopping-cart"></span>В корзину');
});

$('.panel-heading a').on('click',function(e){
    if($(this).parents('.panel').children('.panel-collapse').hasClass('in')){
        e.stopPropagation();
    }
    e.preventDefault();
});

$('#order-form').submit(function(e) {
    var submit = true;
    if (!$("#promo-error").is(":hidden") || $("#promo").is(":hidden")){
        $("#promo").val('');
    }
    if (!$("#bonus-error").is(":hidden") || $("#bonus").is(":hidden")){
        $("#bonus").val('');
    }
    $('input.order-form').each(function(){
        if(!$(this).is(":hidden") && !$(this).val().trim())
            submit = false;
     });
    $('textarea.order-form').each(function(){
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
            if (v < 1500) {
                $('#amount-left').text(1500-v);
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
