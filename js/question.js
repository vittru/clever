$("#question-form").submit(function(e) {
    e.preventDefault();
    var email = $("#question-email").val(),
        name = $("#question-name").val(),
        question = $("#question-text").val();
    $.ajax({
        type: "POST",
        url: "/question",
        data: "userEmail=" + email + "&userName=" + name + "&question=" + question,
        dataType: "html",
        dataFilter: function(a) {
            return $(a).filter("#error").html();
        },
        success: function(a) {
            if (a == null) {
                $(".aa-question").html("<h2>Спасибо за ваш вопрос, мы ответим Вам на указанную почту</h2>");
            }else {
                $("#question-error").show();
                $("#question-error").html(a);
            }
        }
    }) ;   
});

$("#question-email").focus(function(){
    $('#question-error').hide();
});

$("#question-name").focus(function(){
    $('#question-error').hide();
});

$("#question-text").focus(function(){
    $('#question-error').hide();
});

