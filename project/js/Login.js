/**
 * Codice JavaScript per login.php.
 * @author Michele Lorenzo 
 */

const ROOT = "http://localhost/TWeb/GitLab2/tweb/project/";

$(function () {
    // controlli per il form
    $("form[name='login']").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: "required"
        },
        errorClass: "text-danger"
    });

    $("div.alert").hide();
    $("form[name='login']").on("submit",function(event){event.preventDefault()});
    $("#submit").click(login);
    $("#signUp").click(() => redirect({location: ROOT + "views/sign-up.php"}));
})

/**
 * Query Ajax per il login.
 */
function login() {
    if ($("form[name='login']").valid()) {
        $.post(
            ROOT + "controllers/LoginController.php",
            {
                email: $("#email").val(),
                password: $("#password").val(),
                userType: $("#userType").val(),
                rememberMe: $("#rememberMe").is(":checked") ? "1" : "0"
            },
            redirect,
            "json"
        ).fail((jqXHR, textStatus, errorThrown) => {
            $(".cleanable").remove();
            $("div.alert").append("<span class='cleanable'> " + errorThrown + ": " + textStatus + "</span>");
            $("div.alert").show();
        });
    }
}

/**
 * Carica la nuova pagina.
 * @param {any} data risposta Ajax.
 */
function redirect(data) {
    if (data.location)     
        $(window.location).attr("href", data.location);
    else {
        $(".cleanable").remove();
        $("div.alert").append("<span class='cleanable'> " + data.error + "</span>"); 
        $("div.alert").show();
    }
}
