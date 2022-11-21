<?php

/**
 * @author Michele Lorenzo
 */

namespace App\Models;

require_once ("../core/DBConfig.php");

use App\Core\DBConfig;
use PDO;

class ProductList {

  private $productList;

  function getProductList() {
    return $this->productList;
  }

  function selectFromDB(bool $excludeOrdered = false) {
    $conn = DBConfig::DBConnect();
    $exclude = ($excludeOrdered) ? " WHERE products.order IS NULL" : "";

    $stmt = $conn->prepare(
      "SELECT  products.id, brand, 
        products.name, 
        model, 
        year_of_production, 
        img, 
        size, 
        users.first_name,
        users.last_name, 
        products.condition, 
        price 
        FROM products JOIN users ON products.seller = users.id"
        . $exclude
    );

    $stmt->execute();
    $this->productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function selectFromDBById($ids) {
    $conn = DBConfig::DBConnect();
    $idsJoint = join(',', array_fill(0, count($ids), '?'));

    $query = "SELECT  products.id, brand, 
      products.name, 
      model, 
      year_of_production, 
      img, 
      size, 
      users.first_name,
      users.last_name, 
      products.condition, 
      price 
      FROM products JOIN users ON products.seller = users.id
      WHERE products.id IN ($idsJoint)";

    $stmt = $conn->prepare($query);
    $stmt->execute($ids);
    $this->productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function selectFromDBByOrder($orderId) {
    $conn = DBConfig::DBConnect();
    $qOrderId = $conn->quote($orderId);

    $query = "SELECT * FROM products WHERE products.order = $qOrderId";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $this->productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function selectFromDBByUser($userId, bool $excludeOrdered = false) {
    $conn = DBConfig::DBConnect();
    $exclude = ($excludeOrdered) ? " AND products.order IS NULL" : "";
    $qUserId = $conn->quote($userId);

    $query = "SELECT * FROM products WHERE products.seller = $qUserId" . $exclude;

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $this->productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function selectFromDBByFilter($brand, $condition, $name, $priceMin, $priceMax, $excludeOrdered = false) {
    $conn = DBConfig::DBConnect();
    $filters = array();
    $where = " WHERE price BETWEEN " . $priceMin . " AND " . $priceMax;

    if (!empty($brand)) $filters[] = " brand = " . $conn->quote($brand);
    if (!empty($condition)) $filters[] = " products.condition = " . $conn->quote($condition);
    if (!empty($name)) $filters[] = " name LIKE " . $conn->quote("%" . htmlspecialchars($name) . "%");
    if (!empty($excludeOrdered)) $filters[] = " products.order IS NULL";

    foreach ($filters as $filter) {
      $where .= (" AND" . $filter);
    }

    $stmt = $conn->prepare(
      "SELECT  products.id, brand, 
        products.name, 
        model, 
        year_of_production, 
        img, 
        size, 
        users.first_name,
        users.last_name, 
        products.condition, 
        price 
        FROM products JOIN users ON products.seller = users.id"
        . $where
    );

    $stmt->execute();
    $this->productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
