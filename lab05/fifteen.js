/**
 * Codice javascript per il gioco fifteen puzzle.
 * Viene utilizzata la libreria JQuery per la realizzazione di questo codice.
 * @see https://api.jquery.com/
 * @author Michele Lorenzo
 * Corso: B
 */

//Costanti
const NUMBER_ROWS_COLUMNS = 4;  /* Numero di righe e colonne del puzzle */
const TILE_SIDE = 100;          /* Lato in pixel di una casella */
const TIMER = 150;              /* Timer in sec */

//Variabili globali
var blankTileRow = 3;           /* Riga all'interno del puzzle della casella vuota */
var blankTileColumn = 3;        /* Colonna all'interno del puzzle della casella vuota */
var timerId;                    /* ID del timer */

$(function () {
    init();
});

/**
 * Inizzializza il gioco ed il puzzle.
 */
function init() {
    var tiles = $("#puzzlearea div");

    for (let i = 0; i < tiles.length; i++) {
        let r = Math.floor(i / NUMBER_ROWS_COLUMNS);
        let c = i % NUMBER_ROWS_COLUMNS;

        $(tiles[i]).attr("id", "tile_" + r + "_" + c);
        $(tiles[i]).css({
            "top": r * TILE_SIDE + "px",
            "left": c * TILE_SIDE + "px",
            "background-position": -c * TILE_SIDE + "px " + -r * TILE_SIDE + "px"
        });

        $(tiles[i]).click(moveTile);
    }

    updateMovable();
    $("#timer span").html(TIMER);
    createStartPanel("Start a new game");
}

/**
 * Muove una singola casella ed aggiorna la casella vuota.
 */
 function moveTile() {
    if ($(this).hasClass("movable")) {
        var tileId = $(this).attr("id");

        $(this).animate({
            "top": blankTileRow * TILE_SIDE + "px",
            "left": blankTileColumn * TILE_SIDE + "px"
        }, "fast");

        $(this).attr("id", "tile_" + blankTileRow + "_" + blankTileColumn);
        blankTileRow = parseInt(tileId.substr(5, 1));
        blankTileColumn = parseInt(tileId.substr(7, 1));
        win();
        updateMovable();
    }
}

/**
 * Aggiorna le caselle movibili (la cui casella adiacente è vuota).
 */
 function updateMovable() {
    $("#puzzlearea div").each(
        function () {
            if ($(this).is(getElement(blankTileRow, blankTileColumn - 1))
                || $(this).is(getElement(blankTileRow - 1, blankTileColumn))
                || $(this).is(getElement(blankTileRow, blankTileColumn + 1))
                || $(this).is(getElement(blankTileRow + 1, blankTileColumn))) {
                if (!$(this).hasClass("movable"))
                    $(this).addClass("movable");
            } else if ($(this).hasClass("movable"))
                $(this).removeClass("movable");
        }
    )
}

/**
 * Crea la finestra di inizio/fine partita.
 * @param {String} msg Messaggio di inzio/fine partita.
 */
 function createStartPanel(msg) {
    $("body").append("<div id='bg-start-panel'></div>");
    $("body").append("<div id='start-panel' class='panel'><p id='win'> " + msg + " </p></div>");
    $("#start-panel").append("<p id='controls'><button id='shufflebutton'>New Game</button></p>");
    $("#shufflebutton").click(shuffle);
}

/**
 * Visualizza la finestra di inizio/fine partita.
 * @param {String} msg Messaggio di inzio/fine partita.
 */
function showStartPanel(msg) {
    $("#bg-start-panel").fadeIn("slow");
    $("#win").html(msg);
    $("#start-panel").fadeIn("slow");
}

/**
 * Controlla se il giocatore ha vinto, ovvero se tutte le 
 * caselle sono nella posizione coretta.
 */
 function win() {
    var tiles = $("#puzzlearea div");
    var win = true;

    for (let i = 0; win && i < tiles.length; i++) {
        let r = Math.floor(i / NUMBER_ROWS_COLUMNS);
        let c = i % NUMBER_ROWS_COLUMNS;
        let id = "tile_" + r + "_" + c;

        if ($(tiles[i]).attr("id") != id)
            win = false;
    }

    if (win && getTimer() != TIMER) {
        clearInterval(timerId);
        increase("#score span", 1);
        showStartPanel("You have won");
    }
}

/**
 * Restituisce un elemento HTML della riga e colonna specificata.
 * @param {Number} r Numero di riga.
 * @param {Number} c Numero di colonna.
 * @returns Elemento HTML.
 */
 function getElement(r, c) {
    return $("#tile_" + r + "_" + c);
}

/**
 * Mischia il puzzle effettuando TIMER movimenti di caselle scelte 
 * casualmente tra quelle movibili.
 */
 function shuffle() {
    $("#timer span").html(TIMER);

    for (let i = 0; i < TIMER; i++) {
        let movableTiles = $(".movable");
        let index = parseInt(Math.random() * movableTiles.length);

        $(movableTiles[index]).each(moveTile);
    }

    setTimeout(function() {
        $("#start-panel").fadeOut("slow");
        $("#bg-start-panel").fadeOut("slow");
        timerId = setInterval(timer, 1000);
    }, TIMER / 50 * 1000);
}

/**
 * Ritorna il valore del timer.
 * @returns Secondi rimanenti al timer.
 */
 function getTimer() {
    return parseInt($("#timer span").html());
}

/**
 * Incrementa un numero in un elemento HTML.
 * @param {String} id Id dell'elemento HTML.
 * @param {Number} val Valore che si vuole aggiungere.
 * @returns Valore incrementato.
 */
function increase(id, val) {
    var n = parseInt($(id).html()) + val;

    $(id).html(n);

    return n;
}

/**
 * Timer handler.
 */
function timer() {
    var timer = increase("#timer span", -1);

    if (timer < 10 && !$("timer").hasClass("end-timer")) 
        $("#timer").addClass("end-timer");

    if (timer == 0) {
        clearInterval(timerId);
        showStartPanel("Game Over");
        $("#timer").removeClass("end-timer");
    }
}