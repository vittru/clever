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
