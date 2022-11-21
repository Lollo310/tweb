<?php
/**
 * Questo file contiene il codice che viene richiamato quando si 
 * effettua una rierca.
 * @author Michele Lorenzo
 * Corso: B
 */

header("Content-type: application/json");
include("common.php");

if (!isset($_SESSION["username"])) {
    json_encode(array("flash"=>"Please, login before using this website"));
    die;
}

$firstname = $_GET["firstname"];
$lastname = $_GET["lastname"];
$all = $_GET["all"];

try {
    testArguments($firstname, $lastname, $all);
    $conn = DBConnect();

    if ($all)
        $result = searchAll($conn, $firstname, $lastname);
    else
        $result = searchKevin($conn, $firstname, $lastname);
    
    printJson($firstname, $lastname, $result);
} catch (Exception $e) {
    $errMsg = array("errMsg" => $e->getMessage());
    echo json_encode($errMsg);
} finally {
    $conn = null;
}    
?>