<?php

/**
 * Controller PHP per added-product-list.php.
 * @author Michele Lorenzo
 */

require_once ("../core/Util.php");
require_once ("../models/Product.php");
require_once ("../models/ProductList.php");

use App\Core\Util;
use App\Models\Product;
use App\Models\ProductList;

Util::sessionStart();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['comand'])) {
  switch ($_POST['comand']) {
    case 'get products':
      if ($_SESSION['isSeller'] == 1) {
        $productList = new ProductList();
  
        try {
          $productList->selectFromDBByUser($_SESSION['id'], true);
          Util::printJson($productList->getProductList());
        } catch (PDOException $e) {
          Util::printJson(array("error" => "500: Server Error: " . $e->getMessage()));
        }
      } else {
        Util::redirect("views/home-page.php");
      }

      break;
    case 'delete product':
      if (!empty($_POST['id'])) 
        try {
          Product::deleteProduct($_POST['id']);
          Util::printJson(array("response" => "200: OK"));
        } catch (PDOException $e) {
          Util::printJson(array("error" => "500: Server Error: " . $e->getMessage()));
        }

      break;
    default: 
      Util::printJson(array("error" => "500: Server Error: Unexpected error."));

      break;
  }
}

?>