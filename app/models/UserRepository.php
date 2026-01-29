<?php

require_once __DIR__ . '/../libs/Model.php';
require_once __DIR__ . '/User.php';

class UserRepository extends Model
{
    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = :email"
        );
        $stmt->execute([':email' => $email]);

        return $stmt->fetchObject('User');
    }

    public function create(string $username, string $email, string $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password, role, created_at)
             VALUES (:username, :email, :password, 'user', NOW())"
        );

        return $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => $hash
        ]);
    }

    public function verifyLogin(string $email, string $password)
    {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }
}
