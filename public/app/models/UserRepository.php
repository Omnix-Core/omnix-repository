<?php

require_once __DIR__ . '/../libs/Database.php';
require_once __DIR__ . '/User.php';

class UserRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getPDO();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new User($row) : null;
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new User($row) : null;
    }

    public function create($username, $email, $password)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)"
        );
        
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password
        ]);
    }
}