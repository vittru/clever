$(document).ready(function () {
    $('#order-confirm').hide();
    $('#payment-redirect').show();
    var params = {
        TerminalKey: "1479903966423DEMO",
        Amount: $('#pay_sum').text(),
        OrderId: $('#pay_order').text(),
        DATA: "Email=" + $('#pay_email').text() + "|Phone=" + $('#pay_phone').text() + "|Name=" + $('#pay_name').text(),
        Frame: true
    };
    doPay(params);
    $('#payment-redirect').hide();
    $('#order-cofirm').show();
});