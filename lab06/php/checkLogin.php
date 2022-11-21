<?php
/**
 * Questo file contiene il codice che viene richiamato quando si 
 * effettua il login o per controllare che l'utente abbia fatto il login qunado 
 * accede alla pagina index.php.
 * @author Michele Lorenzo
 * Corso: B
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-type: application/json");
    include("common.php");

    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        #applica dei filtri per evitare attacchi XSS
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

        try {
            $conn = DBConnect();

            if (checkPassword($username, $password, $conn)) {
                if (isset($_SESSION)) {
                    session_destroy();
                    session_start();
                }

                $_SESSION["username"] = $username;
                $json = array("username" => $username);            
            } else 
                throw new InvalidArgumentException("Invalid username or passwrd");
            
        } catch (Exception $e) {
            $json = array("flash" => $e->getMessage());
            echo json_encode($json);
        } finally {
            $conn = null;
        }
    } else {
        if (isset($_SESSION["username"])) //l'utente ha effettuato il login
            echo json_encode(array("username" => $_SESSION["username"]));
        else {
            $_SESSION["flash"] = "Please, login before using this website";
            echo json_encode(array("flash" => "Please, login before using this website"));
        }
    }
} 

?>