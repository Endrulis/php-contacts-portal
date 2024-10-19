<?php
// session.php

class Session {
    public function __construct() {
        session_start();
    }

    public function isLoggedIn() {
        return isset($_SESSION['userlogin']);
    }

    public function login($user) {
        $_SESSION['userlogin'] = $user;
    }

    public function logout() {
        session_destroy();
        unset($_SESSION);
    }

    public function getUser() {
        return $_SESSION['userlogin'] ?? null;
    }
}
?>
