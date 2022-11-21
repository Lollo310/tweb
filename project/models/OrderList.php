<?php

/**
 * @author Michele Lorenzo
 */

namespace App\Models;

require_once ("../core/DBConfig.php");

use App\Core\DBConfig;
use PDO;

class OrderList {
    
    private $orderList;

    function getOrderList() {
        return $this->orderList;
    }

    function selectFromDBByUser($userId) {
        $conn = DBConfig::DBConnect();
        $qUserId = $conn->quote($userId);
        $stmt = $conn->prepare("SELECT * FROM orders WHERE buyer = $qUserId");
        
        $stmt->execute();
        $this->orderList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>