<?php 

class Model {

    public function __construct() {
        $this->mysqli = DB::getConnection();
    }
}