/**
 * Codice JavaScript per la pagina login.php.
 * @author Michele Lorenzo
 * Corso: B
 */

$(function() {
    $("#logout").remove();
    $("#searchall").remove();
    $("#searchkevin").remove();
    $("#flash").hide();
    
    $.post(
        "php/checkFlash.php",
        checkFlash,
        "json"
    );

    $("#loginSubmit").click(login);
});

/**
 * Se i campi non sono vuoti effettua una richiesta AJAX al server con 
 * il metodo POST per effettuare il login.
 */
function login() {
    if ($("#username").val() == "" || $("#password").val() == "") {
        let data = {flash: "Username and password can't be empty"};
        checkFlash(data);
    } else { 
        $.post(
            "php/checkLogin.php",
            {
                username: $("#username").val(),
                password: $("#password").val()
            },
            checkFlash,
            "json"
        ).fail(checkFlash);
    }
}

/**
 * Se l'opreazione di login fallisce stampa il messaggio 
 * di errore altrimenti effettua un reindirizzamento alla pagina index.php-
 * @param {Array} data Contine il messaggio di errore se il login fallisce.
 */
function checkFlash(data) {
    if (data.flash) {
        $("#flash").html(data.flash);
        $("#flash").show();
    } else {
        $(document.location).attr("href", "index.php");
    }   
}