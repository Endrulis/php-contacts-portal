<?php
//user.php

class User {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function register($firstname, $lastname, $username, $email, $password) {
        $created_at = date('Y-m-d H:i:s');

        $checkUsernameSQL = "SELECT COUNT(*) FROM users WHERE username = ?";
        $stmtCheck = $this->db->query($checkUsernameSQL, [$username]);
        $usernameExists = $stmtCheck->fetchColumn();

        if ($usernameExists > 0) {
            return ['status' => 'error', 'message' => 'Username already exists. Please choose another one.'];
        } else {
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (firstname, lastname, username, email, password, created_at) VALUES (?,?,?,?,?,?)";
            $result = $this->db->query($sql, [$firstname, $lastname, $username, $email, $hashedPassword, $created_at]);
            
            return $result ? ['status' => 'success', 'message' => 'Successfully registered.'] :
                             ['status' => 'error', 'message' => 'There were errors while saving the data.'];
        }
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = $this->db->query($sql, [$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
    
        return false;
    }

    public function changePassword($username, $new_password) {

        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = :password WHERE username = :username";
        $stmt = $this->db->query($sql, [
            ':password' => $hashedPassword,
            ':username' => $username
        ]);
        return $stmt->rowCount() > 0;
    }

    public function getAllUsers() {
        $sql = "SELECT firstname, lastname, username, email, password FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>