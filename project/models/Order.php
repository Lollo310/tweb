<?php

/**
 * @author Michele Lorenzo
 */

namespace App\Models;

require_once ("../core/DBConfig.php");

use App\Core\DBConfig;

class Order {

  private $no;

  private $dateOfPurchase;

  private $buyer;

  private $address;

  function __construct($dateOfPurchase = null, $buyer = null, $address = null) {
    $this->no = 0;
    $this->dateOfPurchase = $dateOfPurchase;
    $this->buyer = $buyer;
    $this->address = $address;
  }

  function getNo() {
    return $this->no;
  }

  function sanitize() {
    $this->address = htmlspecialchars($this->address);
  }

  function checkdata() {
    return !empty($this->dateOfPurchase) && !empty($this->buyer) && !empty($this->address);
  }

  function insertIntoDB() {
    $conn = DBConfig::DBConnect();

    $qDateOfPurchase = $conn->quote($this->dateOfPurchase);
    $qBuyer = $conn->quote($this->buyer);
    $qAddress = $conn->quote($this->address);

    $sql = "INSERT INTO orders (date_of_purchase, buyer, orders.address) 
            VALUES ($qDateOfPurchase, $qBuyer, $qAddress)";

    $conn->exec($sql);
    $this->no = $conn->lastInsertId();
    $conn = null;
  }
}
