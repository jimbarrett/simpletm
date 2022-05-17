<?php 

class User extends Model {

    public function find($username,$password) {
        $stmt = $this->mysqli->prepare("SELECT id, username FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param('ss',$username,md5($password));
        $stmt->execute();
        $arr = $stmt->get_result()->fetch_assoc();

        return $arr;
    }

}