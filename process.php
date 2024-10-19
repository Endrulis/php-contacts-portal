
<?php
//process.php


require_once('lib/config.php');

$db = new Database();
$user = new User($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
       
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $response = $user->register($firstname, $lastname, $username, $email, $password);

    echo json_encode($response);
}else{
    echo json_encode(['status' => 'error', 'message' => 'No data received.']);
}


?>