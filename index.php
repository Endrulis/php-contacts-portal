<?php
//index.php

require_once('app/lib/config.php');

$session->checkSession();
$session->handleLogout();

$user = $session->getUser();
$username = $user['username'];

if (isset($_POST['create_post'])) {
    $data = [
        'user_id' => $user['id'],
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'location' => $_POST['location'] ?? null
    ];
    $message = $postModel->createPost($data);
}

if (isset($_POST['delete_post'])) {
    $postId = $_POST['post_id'];
    $userId = $user['id'];

    if ($postModel->deletePost($postId, $userId)) {
        $message = "<div class='alert alert-success'>Post deleted successfully.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error deleting post.</div>";
    }
}

$posts = $postModel->getAllPosts();

if (isset($_POST['change_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        if ($userModel->changePassword($username, $new_password)) {
            echo "<script>alert('Password changed successfully!');</script>";
        } else {
            echo "<script>alert('Failed to change password!');</script>";
        }
    }
}

$users = $userModel->getAllUsers();
$logs = $log->getLogs();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Portal</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>

<body>

    <a href="index.php?logout=true" class="btn btn-danger" style="margin: 20px 0px 0 20px;">Logout</a>

    <div class="container">

        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#passwordModal">Change Password</button>

        <?php include('app/modals/change_password_modal.php'); ?>

        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#createPostModal">Create Post</button>

        <?php include('app/modals/create_post_modal.php'); ?>

        <?php if (isset($message)) echo $message; ?>

        <?php include('app/modals/get_all_posts_modal.php'); ?>

        <?php include('app/modals/get_all_users_modal.php'); ?>

        <?php include('app/modals/get_login_logs_modal.php'); ?>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>

</html>