$(document).ready(function () {

    function validateEmail(email) {
        var res = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return res.test(email);
    }

    $(".contact-form #submit").click(function () {
        var email = $("#email");
        var subject = $("#subject");
        var message = $("#message");

        var dataString = $(".contact-form form").serializeArray();
        $("#email-error,#subject-error,#message-error").empty();
        if (email.val() == '' || !validateEmail(email.val()) || subject.val() == '' || message.val() == '') {
            if (email.val() == '' || !validateEmail(email.val())) {
                email.addClass('input-error');
                $("#email-error").html('Ce champ est obligatoire ou n\'est pas valide');
            }
            if (subject.val() == '') {
                subject.addClass('input-error');
                $("#subject-error").html('Ce champ est obligatoire');
            }
            if (message.val() == '') {
                message.addClass('input-error');
                $("#message-error").html('Ce champ est obligatoire');
            }
            swal({
                title: "Erreur !",
                text: "Champs vides ou invalides",
                icon: "error",
            });
        } else {
            console.log(dataString);
            $.ajax({
                type: "POST",
                url: "/contact-us.php",
                data: dataString,
                success: function () {
                    swal({
                        title: "Message envoyé !",
                        text: "Votre message a été envoyé",
                        icon: "success",
                    });
                    $("#email,#subject,#message").val('');
                    $("#email-error,#subject-error,#message-error").empty();
                }
            });
        }
        return false;
    });
});