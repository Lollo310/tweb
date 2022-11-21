<?php
/**
 * Questo file contiene il codice che effettua il logout dell'utente.
 * @author Michele Lorenzo
 * Corso: B
 */

include("common.php");

if (isset($_SESSION)) {
    session_unset();
    session_destroy();
}

session_start();
$_SESSION["flash"] = "Logout successful";
?>