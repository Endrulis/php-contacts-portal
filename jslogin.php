<?php
require_once('lib/config.php');

$session = new Session();
$db = new Database();
$userModel = new User($db);
$log = new Log($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input data
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
