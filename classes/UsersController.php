<?php 

class UsersController {
    
    public function loginPage() {
        $error = false;
        $message = false;
        if(isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        include('views/login.php');
    }

    public function doLogin() {
        $um = new User();
        $found = $um->find($_POST['username'],$_POST['password']);
        if($found) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['user'] = $found;
            header('Location: /');
        } else {
            $_SESSION['error'] = 'Username/Password combination is incorrect.';
            header('Location: /login');
        }
    }

    public function logout() {
        $_SESSION['loggedIn'] = false;
        $_SESSION['user'] = false;
        $_SESSION['message'] = 'You have successfully logged out.';
        header('Location: /login');
    }
}