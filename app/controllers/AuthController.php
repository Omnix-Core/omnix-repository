<?php

require_once __DIR__ . '/../models/UserRepository.php';

class AuthController
{
    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function login($email, $password)
    {
        $user = $this->userRepo->verifyLogin($email, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }

    public function logout()
    {
        session_destroy();
    }
}
