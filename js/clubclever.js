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