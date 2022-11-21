<?php

/**
 * Controller PHP per new-product.php.
 * @author Michele Lorenzo
 */

require_once ("../core/Util.php");
require_once ("../models/Product.php");

use App\Core\Util;
use App\Models\Product;

Util::sessionStart();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST["comand"])) {
    switch ($_POST['comand']) {
      case 'check is seller':
        if ($_SESSION['isSeller'] == 0) 
          Util::redirect("views/home-page.php");
        else
          Util::printJson(array('response' => '200: OK'));

        break;
      case 'add product':
        try {
          if (!isset($_POST["img"]))
            throw new InvalidArgumentException(" Please upload an image.");

          $array_splitted = explode("\\", $_POST["img"]);
          $filename = end($array_splitted);

          if (!file_exists("../images/products/" . $filename))
            throw new InvalidArgumentException(" Please upload an image first.");

          $product = new Product(
            $_POST["brand"],
            $_POST["name"],
            $_POST["model"],
            $_POST["yearOfProduction"],
            "images/products/" . $filename,
            $_POST["size"],
            $_SESSION["id"],
            $_POST["condition"],
            $_POST["price"]
          );

          # per evitare attacchi lato server
          $product->sanitize();

          if (!$product->checkData()) // controllo i dati lato server
            throw new InvalidArgumentException(" Field/fields is/are empty.");

          $product->insertIntoDB();
          Util::printJson(array("success" => " Product added successfully."));
        } catch (InvalidArgumentException $e) {
          Util::printJson(array("error" => $e->getMessage()));
        } catch (PDOException $e) {
          Util::printJson(array("error" => "500: Server Error: " . $e->getMessage()));
        }

        break;
      default:
        Util::printJson(array("error" => "500: Server Error: Unexpected error."));

        break;
    }
  } else { // caricamento immagine
    if (isset($_FILES['file']['name'])) {
      $filename = $_FILES['file']['name'];
      $location = "../images/products/" . $filename;

      if (move_uploaded_file($_FILES['file']['tmp_name'], $location))
        Util::printJson(array("success" => " File upload successful."));
      else
        Util::printJson(array("error" => " File upload failed."));
    } else // non è stata caricata nessuna immagine
      Util::printJson(array("error" => " Please select an images."));
  }
}
