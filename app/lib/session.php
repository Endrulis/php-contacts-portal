<?php
// session.php

class Session {
    public function __construct() {
        $this->init();
    }

    private function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['initialized'])) {
            session_regenerate_id(true);
            $_SESSION['initialized'] = true;
        }
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

    public function checkSession() {
        if (!$this->isLoggedIn()) {
            $this->logout();
            header("Location: login.php");
            exit();
        }
    }

    public function checkLogin() {
        if ($this->isLoggedIn()) {
            header("Location: index.php");
            exit();
        }
    }

    public function handleLogout() {
        if (isset($_GET['logout'])) {
            $this->logout();
            header("Location: login.php");
            exit;
        }
    }
}
?>
