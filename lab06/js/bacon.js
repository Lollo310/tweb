/**
 * Codice JavaScript per la pagina index.php.
 * @author Michele Lorenzo
 * Corso: B
 */

$(function () {
    $("#errMsg").hide();
    $("#results").hide();

    $.post(
        "php/checkLogin.php",
        checkLog,
        "json"
    ).fail(printErr);

    $("#searchall input[name='submit']").click(searchAll);
    $("#searchkevin input[name='submit']").click(searchKevin);
    $("#submitLogout").click(logout);
});

/**
 * Effettua una richiesta AJAX al server per farsi restituire tutti film 
 * dove l'attore inserito dall'utente ha un ruolo.
 */
function searchAll() {
    $.get(
        "php/getMovieList.php",
        {
            firstname: $("#searchall input[name='firstname']").val(),
            lastname: $("#searchall input[name='lastname']").val(),
            all: "true"
        },
        printFilms,
        "json"
    ).fail(printErr);
};

/**
 * Effettua una richiesta AJAX al server per farsi restituire tutti film 
 * dove Kevin Bacon e l'attore inserito dall'utente hanno un ruolo.
 */
function searchKevin() {
    $.get(
        "php/getMovieList.php",
        {
            firstname: $("#searchkevin input[name='firstname']").val(),
            lastname: $("#searchkevin input[name='lastname']").val(),
            all: "false"
        },
        printFilms,
        "json"
    ).fail(printErr);
};

/**
 * Stamapa l'errore.
 * @param {jqXHR} jqXHR Oggetto jQuery XMLHttpRequest.
 * @param {String} textStatus Messaggio dell'errore.
 * @param {String} errorThrown Tipo di errore.
 */
function printErr(jqXHR, textStatus, errorThrown) {
    $(".kevin").hide();
    $("#results").hide();
    $("#errMsg").html(errorThrown + ": " + textStatus);
    $("#errMsg").show();
}

/**
 * Stampa i film oppure, in caso di errore, il messaggio d'errore.
 * @param {Array} data Film o messaggio d'errore.
 */
function printFilms(data) {
    $(".removable").remove();
    $(".kevin").hide();
    $("#errMsg").hide();

    if (data.errMsg){
       printErr(null, data.errMsg, "Error");
    } else {
        $("#firstN").html(data.firstname);
        $("#lastN").html(data.lastname);
        data.movies.forEach(createARowTable);
        $("#results").slideDown();
    }
}

/**
 * Crea e inizializza una riga nella tabella dei film.
 * @param {Array} movie Film{Nome, Anno}.
 * @param {Number} index Posizione all'interno dell'array dei film.
 */
function createARowTable(movie, index) {
    var tr = $("<tr class='removable'></tr>");
    
    tr.append("<td>" + (index + 1) + "</td>");
    tr.append("<td>" + movie.name + "</td>");
    tr.append("<td>" + movie.year + "</td>");
    $("#list").append(tr);
}

/**
 * Controlla se l'utente ha effettuato il login.
 * @param {Array} data Username o messaggio di errore.
 */
function checkLog(data) {
    if (data.flash)
        $(window.location).attr("href", "login.php");
    else
        $("#username").html(data.username);    
}

/**
 * Effettua una richiesta AJAX al server con il metodo GET 
 * per effettuare il logout dell'utente.
 */
function logout() {
    $.get(
        "php/logout.php",
        function() {
            $(window.location).attr("href", "login.php");
        }
    ).fail(printErr);
}