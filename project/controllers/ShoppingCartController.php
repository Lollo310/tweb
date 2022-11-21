<?php

/**
 * Controller PHP per shopping-cart.php.
 * @author Michele Lorenzo
 */

require_once ("../core/Util.php");
require_once ("../models/Order.php");
require_once ("../models/Product.php");
require_once ("../models/ProductList.php");

use App\Core\Util;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductList;

Util::sessionStart();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['comand'])) {
  switch ($_POST['comand']) {
    case 'redirect':
      if (!empty($_POST['address']) && !empty($_COOKIE['cart']) && count(json_decode($_COOKIE['cart'])) > 0) {
        $order = new Order(date('Y-m-d'), $_SESSION['id'], $_POST['address']);
        $ids = json_decode($_COOKIE['cart']);

        # per evitare attacchi lato server
        $order->sanitize();

        try {
          if (!$order->checkdata()) // controllo i dati lato server
            throw new InvalidArgumentException();
          
          $order->insertIntoDB();

          foreach ($ids as $id) 
            Product::updateProductOrderId($id, $order->getNo());

          setcookie('cart', '', time() - 3600);
          Util::redirect("views/confirmed-order.php");
        } catch (PDOException $e) {
          Util::printJson(array("error"=> "500: Server Error" . $e->getMessage()));
        } catch (InvalidArgumentException $e) {
          Util::printJson(array("error"=>"Invalid argument."));
        }
      }

      break;
    case 'get products':
      if (!empty($_COOKIE['cart']) && count(json_decode($_COOKIE['cart'])) > 0) {
        $productList = new ProductList();
        
        try {
          $productList->selectFromDBById(json_decode($_COOKIE['cart']));
          Util::printJson($productList->getProductList());
        } catch (PDOException $e) {
          Util::printJson(array("error"=> "500: Server Error" . $e->getMessage()));
        }
      } else
        Util::printJson(array('message' => 'empty'));

      break;
    case 'delete product':
      if (!empty($_POST['id']) && !empty($_COOKIE['cart'])) {
        $cartData = json_decode($_COOKIE['cart']);

        if (($key = array_search($_POST['id'], $cartData)) !== false) {
          unset($cartData[$key]);
          $cartData = array_values($cartData);
        } 

        setcookie('cart', json_encode($cartData),  array("expires" => time() + 60*60*24, "samesite" => "Lax"));
      }

      break;
    default:
      Util::printJson(array("error" => "500: Server Error: Unexpected error."));
    
      break;
  }
}

?>