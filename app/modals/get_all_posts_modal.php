<div>
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
</div>