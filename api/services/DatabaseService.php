<?php

namespace Service;

use \PDO;

class DatabaseService {

    private static $connection = null;

    private static function initConnection() {
        $dbhost = "localhost";
        $dbuser = "yourusername";
        $dbpass = "yourpassword";
        $dbname = "testing";
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$connection = $dbh;
    }

    public static function getConnection() {
        if (self::$connection == null) {
            self::initConnection();
        }
        return self::$connection;
    }

    public function executeQuery($sql) {
        try {
            $db = self::getConnection();
            $stmt = $db->query($sql);
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            return $results;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

}
