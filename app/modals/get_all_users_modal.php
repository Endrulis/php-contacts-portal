<div>
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
        </div>