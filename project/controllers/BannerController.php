<?php

/**
 * Controller PHP per banner.html.
 * @author Michele Lorenzo
 */

require_once ("../core/Util.php");
require_once ("../models/User.php");

use App\Core\Util;
use App\Models\User;

Util::sessionStart();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  switch ($_POST["comand"]) {
    case 'check login':
      if (Util::checkLogin())
        Util::printJson(array("firstName" => $_SESSION["firstName"], "isSeller" => $_SESSION["isSeller"]));
      else 
                if (isset($_COOKIE["userId"])) {
        $user = new User();

        try {
          $user->selectFromDBWithId($_COOKIE["userId"]);
          Util::sessionClean();

          $_SESSION["id"] = $user->getId();
          $_SESSION["firstName"] = $user->getFirstName();
          $_SESSION["isSeller"] = $user->getIsSeller();

          Util::printJson(array("firstName" => $user->getFirstName(), "isSeller" => $user->getIsSeller()));
        } catch (PDOException $e) {
          Util::printJson(array("error" => "500: Server Error:" . $e->getMessage()));
        }
      }

      break;

    case 'logout':
      Util::sessionClean();

      if (isset($_COOKIE["userId"]))
        setcookie("userId", 0, time() - 1);

      Util::redirect("views/home-page.php");
      break;
    default:
      Util::printJson(array("error" => "500: Server Error: Unexpected error."));

      break;
  }
}
