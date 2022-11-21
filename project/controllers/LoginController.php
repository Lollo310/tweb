<?php

/**
 * Controller PHP per login.php.
 * @author Michele Lorenzo
 */

require_once ("../core/Util.php");
require_once ("../models/User.php");

use App\Core\Util;
use App\Models\User;

Util::sessionStart();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  header("Content-type: application/json");

  if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST["password"]);

    $user = new User();
    if ($user->selectFromDB($email, $password, $_POST["userType"])) {
      Util::sessionClean();
      $_SESSION["id"] = $user->getId();
      $_SESSION["firstName"] = $user->getFirstName();
      $_SESSION["isSeller"] = $user->getIsSeller();

      if ($_POST["rememberMe"])
        setcookie("userId", $user->getId(), array("samesite" => "Lax"));

      Util::redirect("views/home-page.php");
    } else
      Util::printJson(array("error" => "Invalid email, password or user type."));
  }
}
