
<?php
//jsregister.php

require_once('app/lib/config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
       
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $response = $userModel->register($firstname, $lastname, $username, $email, $password);

    echo json_encode($response);
}else{
    echo json_encode(['status' => 'error', 'message' => 'No data received.']);
}


?>