$(document.body).on('hidden.bs.modal', function () {
    $('#quick-view-modal').removeData('bs.modal');
});

var nameAsc = true;
var priceAsc = true;

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

$(document).on("click", "#showAvailable", function() {
    $("div.tab-pane.active li.good").show();
    if ($(this).is(":checked")) {
        $("div.tab-pane.active li.good").has('.aa-sold-out').hide();
    };
    $("div.tab-pane.active #showSale").attr('checked',false);
});

$(document).on("click", "#showSale", function() {
    $("div.tab-pane.active li.good").show();
    if ($(this).is(":checked")) {
        $("div.tab-pane.active li.good").not(":has('.aa-sale')").hide();
    };
    $("div.tab-pane.active #showAvailable").attr('checked',false);
});

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
    $(this).css("background-color","#1DA93C");
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
    $(this).parent().find(".aa-add-card-btn").css("background-color","#E46713")
})

$('.panel-heading a').on('click',function(e){
    if($(this).parents('.panel').children('.panel-collapse').hasClass('in')){
        e.stopPropagation();
    }
     e.preventDefault();
});

$('#order-form').submit(function(e) {
    var submit = true;
     $('input.order-form').each(function(){
        if($(this).is(":hidden")){
           $(this).remove();
        } else if (!$(this).val().trim()){
                submit = false;
        }    
     });
    $('textarea.order-form').each(function(){
        if($(this).is(":hidden")){
           $(this).remove();
        } else if (!$(this).val().trim()){
            submit = false;
        }    
     });
     if (!$('#branch').is(':hidden') && !$('#branch').val())
         submit = false;
     if (!submit) {
         e.preventDefault();
         $('#order-error').show();
     }    
});

$(document).on('click', '.aa-search-box .dropdown-lg', function (e) {
  e.stopPropagation();
});

$(document).on('click', '.aa-search-box #search-text', function (e) {
  e.stopPropagation();
});