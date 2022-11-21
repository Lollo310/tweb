<?php

/**
 * Utility.
 * @author Michele Lorenzo
 */

namespace App\Core;

class Util {

    private const ROOT = "http://localhost/TWeb/GitLab2/tweb/project/";

    /**
     * Stampa data in formato json.
     * @param data dati da stampare.
     */
    static function printJson($data) {
        echo json_encode($data);
    }

    /**
     * Stampa la nuova pagina da caricare.
     * @param location Path della nuova pagina.
     */
    static function redirect($location) {
        self::printJson(array("location" => self::ROOT . $location));
    }

    /**
     * Avvia una nuova sessione.
     */
    static function sessionClean() {
        if (isset($_SESSION)) {
            session_unset();
            session_destroy();
            session_start();
        }
    }

    /**
     * Avvia la sessione.
     */
    static function sessionStart() {
        if(!isset($_SESSION)) session_start();
    }

    /**
     * Controlla se l'utente è loggato.
     * @return true se l'utente è loggato.
     */
    static function checkLogin() {
        return isset($_SESSION["id"]);
    }
}

?>