<?php
//jslogin.php

require_once('app/lib/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Username and password are required.']);
        exit;
    }

    $user = $userModel->login($username, $password);

    if ($user) {
        $session->login($user);

        $log->logAction($username, true);
        echo json_encode(['status' => 'success', 'message' => 'Login successful.']);
    } else {
        $log->logAction($username, false);
        echo json_encode(['status' => 'error', 'message' => 'Username or password is incorrect.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
