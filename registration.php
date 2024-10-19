<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Registration</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div>
        <form action="registration.php" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <h1>Registration</h1>
                        <p>Fill up the form with correct values.</p>

                        <hr class="mb-3">

                        <label for="firstname"><b>First Name</b></label>
                        <input class="form-control" id="firstname" type="text" name="firstname" required>

                        <label for="lastname"><b>Last Name</b></label>
                        <input class="form-control" id="lastname" type="text" name="lastname" required>

                        <label for="username"><b>Username</b></label>
                        <input class="form-control" id="username" type="text" name="username" required>

                        <label for="email"><b>Email</b></label>
                        <input class="form-control" id="email" type="email" name="email" required>

                        <label for="password"><b>Password</b></label>
                        <div class="input-group">
                            <input class="form-control" id="password" type="password" name="password" required>
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button" id="generatePassword">Generate</button>
                            </span>
                        </div>

                        <hr class="mb-3">

                        <input class="btn btn-primary" type="submit" id="register" name="create" value="Sign Up">

                    </div>

                    <div class="col-sm-6">
                        <h2 id="generatedPasswordsHeader" style="display: none;">Generated Passwords</h2>
                        <div id="generatedPasswords" class="mt-3"></div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        function slaptazodzio_generatorius(simboliu_kiekis) {
            var pass = '';
            for (var i = 0; i < simboliu_kiekis; i++) {
                var raides = String.fromCharCode(Math.floor(Math.random() * (126 - 33) + 33));
                pass += raides;
            }
            return pass;
        }

        $(function() {

            $('#generatePassword').click(function () {
                var generatedPasswords = '';
                for (var i = 0; i < 5; i++) { // Generate 5 passwords
                    var password = slaptazodzio_generatorius(10);
                    generatedPasswords += `<div>${password} <button class="btn btn-link copyPassword" data-password="${password}">Copy</button></div>`;
                }
                $('#generatedPasswords').html(generatedPasswords);
                $('#generatedPasswordsHeader').show();
            });

            $(document).on('click', '.copyPassword', function () {
                var password = $(this).data('password');
                navigator.clipboard.writeText(password).then(function () {
                    Swal.fire({
                        title: 'Copied!',
                        text: 'Password has been copied to clipboard.',
                        icon: 'success'
                    });
                }, function () {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to copy password.',
                        icon: 'error'
                    });
                });
            });

            $('#register').click(function(e) {

                e.preventDefault();

                var valid = this.form.checkValidity();

                if (valid) {

                    var firstname = $('#firstname').val();
                    var lastname = $('#lastname').val();
                    var username = $('#username').val();
                    var email = $('#email').val();
                    var password = $('#password').val();

                    $.ajax({
                        type: 'POST',
                        url: 'process.php',
                        data: {
                            firstname: firstname,
                            lastname: lastname,
                            username: username,
                            email: email,
                            password: password
                        },
                        success: function(response) {
                            var data = JSON.parse(response); // Parse the JSON response

                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Registration successful. Redirecting...',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(function() {
                                    setTimeout(function() {
                                        window.location.href = "login.php";
                                    }, 100);
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: data.message,
                                    icon: 'error'
                                });
                            }
                        },
                        errors: function(data) {
                            Swal.fire({
                                title: 'Errors',
                                text: 'There were errors while saving the data.',
                                icon: 'error'
                            });
                        }
                    });

                } else {
                    Swal.fire({
                        title: 'Invalid form',
                        text: 'Please fill out the form correctly before submitting.',
                        icon: 'warning'
                    });
                }
            });
        });
    </script>

</body>

</html>