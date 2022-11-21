<?php

/**
 * Controller PHP per orders.php.
 * @author Michele Lorenzo
 */

require_once ("../core/Util.php");
require_once ("../models/OrderList.php");
require_once ("../models/ProductList.php");

use App\Core\Util;
use App\Models\OrderList;
use App\Models\ProductList;

Util::sessionStart();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['comand'])) {
  switch ($_POST['comand']) {
    case 'get orders':
      $orderList = new OrderList();

      try {
        $orderList->selectFromDBByUser($_SESSION['id']);
        Util::printJson($orderList->getOrderList());
      } catch (PDOException $e) {
        Util::printJson(array("error" => "500: Server Error: " . $e->getMessage()));
      }

      break;
    case 'get products':
      if (!empty($_POST['id'])) {
        $productList = new ProductList();

        try {
          $productList->selectFromDBByOrder($_POST['id']);
          Util::printJson($productList->getProductList());
        } catch (PDOException $e) {
          Util::printJson(array("error" => "500: Server Error: " . $e->getMessage()));
        }
      }

      break;
    default:
    Util::printJson(array("error" => "500: Server Error: Unexpected error."));
    
    break;
  }
}

?>