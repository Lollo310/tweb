<?php

/**
 * @author Michele Lorenzo
 */

namespace App\Models;

require_once ("../core/DBConfig.php");

use App\Core\DBConfig;
use PDO;

class Product{

  private $id;

  private $brand;

  private $name;

  private $model;

  private $yearOfProduction;

  private $img;

  private $size;

  private $seller;

  private $condition;

  private $price;

  function __construct(
    $brand = null,
    $name = null,
    $model = null,
    $yearOfProduction = null,
    $img = null,
    $size = null,
    $seller = null,
    $condition = null,
    $price = null
  ) {
    $this->id = 0;
    $this->brand = $brand;
    $this->name = $name;
    $this->model = $model;
    $this->yearOfProduction = $yearOfProduction;
    $this->img = $img;
    $this->size = $size;
    $this->seller = $seller;
    $this->condition = $condition;
    $this->price = $price;
  }

  function sanitize() {
    $this->name = htmlspecialchars($this->name);
    $this->model = htmlspecialchars($this->model);
    $this->yearOfProduction = htmlspecialchars($this->yearOfProduction);
    $this->size = htmlspecialchars($this->size);
    $this->price = htmlspecialchars($this->price);
  }

  function checkdata() {
    return !empty($this->name)
      && !empty($this->model)
      && !empty($this->yearOfProduction)
      && !empty($this->size)
      && !empty($this->price);
  }

  function insertIntoDB() {
    $conn = DBConfig::DBConnect();

    $qBrand = $conn->quote($this->brand);
    $qName = $conn->quote($this->name);
    $qModel = $conn->quote($this->model);
    $qYearOfProduction = $conn->quote($this->yearOfProduction);
    $qImg = $conn->quote($this->img);
    $qSize = $conn->quote($this->size);
    $qSeller = $conn->quote($this->seller);
    $qCondition = $conn->quote($this->condition);
    $qPrice = $conn->quote($this->price);

    $sql = "INSERT INTO products (
            brand, 
            products.name, 
            model, 
            year_of_production, 
            img, 
            size, 
            seller, 
            products.condition, 
            price
            ) VALUES (
                $qBrand,
                $qName,
                $qModel, 
                $qYearOfProduction, 
                $qImg,
                $qSize,
                $qSeller, 
                $qCondition, 
                $qPrice
            )";

    $conn->exec($sql);
    $conn = null;
  }

  function selectFromDB($id) {
    $conn = DBConfig::DBConnect();
    $qId = $conn->quote($id);

    $stmt = $conn->prepare(
      "SELECT * 
            FROM products 
            WHERE id = $qId"
    );

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount()) {
      $this->setAll($result);
      return true;
    } else
      return false;
  }

  function setAll($data) {
    $this->id = $data["id"];
    $this->brand = $data["brand"];
    $this->name = $data["name"];
    $this->model = $data["model"];
    $this->yearOfProduction = $data["year_of_production"];
    $this->img = $data["img"];
    $this->size = $data["size"];
    $this->seller = $data["seller"];
    $this->condition = $data["condition"];
    $this->price = $data["price"];
  }

  # STATIC METHODS FOR PERSISTANCE
  static function updateProductOrderId($id, $order_id) {
    $conn = DBConfig::DBConnect();
    $stmt = $conn->prepare("UPDATE products SET products.order = ? WHERE id = ?");

    $stmt->execute(array($order_id, $id));
    $conn = null;
  }

  static function deleteProduct($id) {
    $conn = DBConfig::DBConnect();
    $qId = $conn->quote($id);
    $conn->exec("DELETE FROM products WHERE id = $qId");
  }
}
