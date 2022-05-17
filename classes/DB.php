<?php 

class DB {

    public static $mysqli = false;

    public static function getConnection() {
        if(self::$mysqli) {
            return self::$mysqli;
        }
        try {
            self::$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            return self::$mysqli;
        } catch(Exception $e) {
            error_log($e->getMessage());
            exit('Error connecting to database'); 
        }
    }
}