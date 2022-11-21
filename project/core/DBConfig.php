<?php

/**
 * Configurazione del DBMS.
 * @author Michele Lorenzo.
 */

namespace App\Core;

use PDOException;
use PDO;

class DBConfig {

    private const SERVER_NAME = "localhost";

    private const DB_NAME = "rebuy";

    private const USER_NAME = "root";

    /**
     * Prova a connettersi al DBMS.
     * @return PDO se l'operazione termina con successo.
     * @throws PDOException altrimenti.
     */
    static function DBConnect() {
        $conn = new PDO("mysql:host=" . self::SERVER_NAME . ";dbname=" . self::DB_NAME, self::USER_NAME);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}

?>