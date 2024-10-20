<?php

class Log {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function logAction($username, $success) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $timestamp = date('Y-m-d H:i:s');
        $sql = "INSERT INTO log (username, timestamp, success, ip_address) VALUES (?, ?, ?, ?)";
        $this->db->query($sql, [$username, $timestamp, $success, $ip_address]);
    }

    public function getLogs() {
        $sql = "SELECT username, timestamp, success, ip_address FROM log ORDER BY timestamp DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>
