$(document).ready(function () {
    var params = {
        TerminalKey: "1479903966423",
        Amount: $('#pay_sum').text(),
        OrderId: $('#pay_order').text(),
        DATA: "Email=" + $('#pay_email').text() + "|Phone=" + $('#pay_phone').text() + "|Name=" + $('#pay_name').text(),
        Frame: true
    };
    doPay(params);
});

