<?php

/**
 * Controller PHP per sign-up.php.
 * @author Michele Lorenzo
 */

require_once ("../models/User.php");
require_once ("../core/Util.php");

use App\Models\User;
use App\Core\Util;

Util::sessionStart();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = new User($_POST["firstName"]
            , $_POST["lastName"]
            , $_POST["birthday"]
            , $_POST["gender"]
            , $_POST["email"]
            , $_POST["phoneNumber"]
            , (bool) $_POST["userType"]
            , password_hash($_POST["password"], PASSWORD_DEFAULT)
        );
        
        # per evitare attacchi lato server
        $user->sanitize();
        
        try {
            if (!$user->checkData()) // controllo i dati lato server
                throw new InvalidArgumentException(); 

            $user->insertIntoDB();
            Util::redirect("views/login.php");
        } catch (PDOException $e) {
            Util::printJson(array("error"=>"User already exists."));
        } catch (InvalidArgumentException $e) {
            Util::printJson(array("error"=>"Invalid argument."));
        }
}

?>