<?php
//post.php

class Post{
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function createPost($data) {
        $userId = $data['user_id'];
        $title = $data['title'];
        $content = $data['content'];
        $location = $data['location'] ?? null;
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        if (empty($title) || empty($content)) {
            return "<div class='alert alert-danger'>Title and Content cannot be empty.</div>";
        }

        $sql = "INSERT INTO posts (user_id, title, content, location, ip_address) VALUES (:user_id, :title, :content, :location, :ip_address)";
        $result = $this->db->query($sql, [
            ':user_id' => $userId,
            ':title' => $title,
            ':content' => $content,
            ':location' => $location,
            ':ip_address' => $ipAddress
        ]);

        return $result->rowCount() > 0 ? "<div class='alert alert-success'>Post created successfully.</div>" : 
                                            "<div class='alert alert-danger'>Error creating post.</div>";
    }

    public function getAllPosts() {
        $sql = "SELECT posts.*, users.username FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.timestamp DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletePost($postId, $userId) {
        $sql = "DELETE FROM posts WHERE id = :post_id AND user_id = :user_id";
        
        $result = $this->db->query($sql, [
            ':post_id' => $postId,
            ':user_id' => $userId
        ]);

        return $result->rowCount() > 0;
    }
}

?>