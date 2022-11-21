<?php
/**
 * Questo file contiene il codice che viene richiamato al caricamento 
 * della pagina login.php per restituire eventuali messaggi di errore.
 * @author Michele Lorenzo
 * Corso: B
 */

include("common.php");
header("Content-type: application/json");

if (isset($_SESSION["flash"])) {
    echo json_encode(array("flash" => $_SESSION["flash"]));
    unset($_SESSION["flash"]);
}
?>