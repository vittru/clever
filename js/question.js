$("#question-form").submit(function(e) {
    e.preventDefault();
    var email = $("#question-email").val(),
        name = $("#question-name").val(),
        question = $("#question-text").val();
    $.ajax({
        type: "POST",
        url: "question",
        data: "userEmail=" + email + "&userName=" + name + "&question=" + question,
        dataType: "html",
        dataFilter: function(a) {
            return $(a).filter("#error").html();
        },
        success: function(a) {
            if (a == null) {
                window.location.reload();
            }else {
                $("#question-error").css("display", "inline-block");
                $("#question-error").html(a);
            }
        }
    }) ;   
});

$("#question-email").focus(function(){
    $('#question-error').css("display", "none");
});

$("#question-name").focus(function(){
    $('#question-error').css("display", "none");
});

$("#question-text").focus(function(){
    $('#question-error').css("display", "none");
});

