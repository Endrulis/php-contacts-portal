<?php
//index.php

require_once('lib/config.php');

$db = new Database();
$userModel = new User($db);
$postModel = new Post($db);
$log = new Log($db);
$session = new Session();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    $session->logout();
    header("Location: login.php");
}

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
    $userId = $user['id']; // Get the logged-in user's ID

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

<p>Welcome to index.php</p>

<a href="index.php?logout=true">Logout</a>

<div class="container">

<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#passwordModal">Change Password</button>

    <!-- Modalas slaptažodžio keitimui -->
    <div id="passwordModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <!-- Slaptažodžio keitimo forma -->
                    <form action="index.php" method="POST">
                        <div class="form-group">
                            <label for="new_password">New Password:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="change_password">Change Password</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#createPostModal">Create Post</button>

    <!-- Modal for creating a post -->
    <div id="createPostModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Post</h4>
                </div>
                <div class="modal-body">
                    <!-- Post creation form -->
                    <form action="index.php" method="POST">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea class="form-control" id="content" name="content" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="location">Location:</label>
                            <input type="text" class="form-control" id="location" name="location">
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_post">Create Post</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Display messages -->
    <?php if (isset($message)) echo $message; ?>

    <h1>All Posts</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Title</th>
                <th>Content</th>
                <th>Location</th>
                <th>Timestamp</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($posts) {
                foreach ($posts as $post) {
                    echo "<tr>
                            <td>{$post['username']}</td>
                            <td>{$post['title']}</td>
                            <td>{$post['content']}</td>
                            <td>{$post['location']}</td>
                            <td>{$post['timestamp']}</td>
                            <td>
                                <form action='index.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='post_id' value='{$post['id']}'>
                                    <input type='hidden' name='user_id' value='{$post['user_id']}'>
                                    <button type='submit' class='btn btn-danger' name='delete_post'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No posts found</td></tr>";
            }
            ?>
        </tbody>
    </table>


    <h1>All Users</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>

            </tr>
        </thead>
        <tbody>
            <?php
            if ($users) {
                foreach ($users as $user) {
                    echo "<tr>
                            <td>{$user['firstname']}</td>
                            <td>{$user['lastname']}</td>
                            <td>{$user['username']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['password']}</td>
                            </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Login Logs</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Timestamp</th>
                <th>Success</th>
                <th>IP Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($logs) {
                foreach ($logs as $log) {
                    $status = $log['success'] ? 'Success' : 'Failed';
                    echo "<tr>
                            <td>{$log['username']}</td>
                            <td>{$log['timestamp']}</td>
                            <td>{$status}</td>
                            <td>{$log['ip_address']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No login logs found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>

