<?php

/**
 * Controller PHP per home-page.php.
 * @author Michele Lorenzo
 */

require_once ("../models/ProductList.php");
require_once ("../core/Util.php");
require_once ("../models/Product.php");

use App\Models\ProductList;
use App\Core\Util;
use App\Models\Product;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['comand'])) {
  switch ($_POST["comand"]) {
    case 'get products':
      $productList = new ProductList();

      try {
        $productList->selectFromDB(true);
        Util::printJson($productList->getProductList());
      } catch (PDOException $e) {
        Util::printJson(array("error" => "500: Server Error: " . $e->getMessage()));
      }

      break;
    case 'add cart':
      if (!empty($_POST['id'])) {
        $product = new Product();
        $cartData = array();
        $id = $_POST['id'];

        if (!empty($_COOKIE["cart"]))
          $cartData = json_decode($_COOKIE['cart']);

        if (!in_array($id, $cartData)) {
          $cartData[] = $id;
          setcookie("cart", json_encode($cartData), array("expires" => time() + 60 * 60 * 24, "samesite" => "Lax"));
        }
      }

      break;
    case 'filter':
      $productList = new ProductList();
      $priceMin = (empty($_POST['priceMin'])) ? 0 : $_POST['priceMin'];
      $priceMax = (empty($_POST['priceMax'])) ? PHP_INT_MAX : $_POST['priceMax'];

      try {
        $productList->selectFromDBByFilter($_POST['brand'], 
          $_POST['condition'], 
          $_POST['name'], 
          $priceMin, 
          $priceMax, 
          true
        );

        Util::printJson($productList->getProductList());
      } catch (PDOException $e) {
        Util::printJson(array("error" => "500: Server Error: " . $e->getMessage()));
      }

      break;
    default:
      Util::printJson(array("error" => "500: Server Error: Unexpected error."));

    break;
  }
}
