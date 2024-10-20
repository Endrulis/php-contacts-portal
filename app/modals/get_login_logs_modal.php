<div>
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