<?php
//login.php

require_once('app/lib/config.php');

$session->checkLogin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>

    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center form_container">
                        <h1>Login</h1>
                        <form action="login.php" method="post">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" name="username" id="username" class="form-control input_user" required>
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control input_password" required>
                            </div>

                            <div class="d-flex justify-content-center mt-3 login_container" style="margin-top: 8px;">
                                <button type="submit" name="button" id="login" class="btn login_btn">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-5" style="margin-top: 8px;">
                        <div class="d-flex justify-content-center links">
                            Don't have an account? <a href="registration.php" class="ml-2">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#login').click(function(e) {
                e.preventDefault();

                var username = $('#username').val();
                var password = $('#password').val();

                if (username.trim() === '' || password.trim() === '') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Username and password are required.',
                        icon: 'error'
                    });
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: 'jslogin.php',
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(data) {
                        try {
                            var response = JSON.parse(data);
                            console.log(response);

                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Successful',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(function() {
                                    window.location.href = "index.php";
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        } catch (e) {
                            console.error("Invalid JSON response:", data);
                            Swal.fire({
                                title: 'Error',
                                text: 'Invalid request. Username or password is incorrect',
                                icon: 'error'
                            });
                        }
                    }
                })
            })
        })
    </script>

</body>

</html>