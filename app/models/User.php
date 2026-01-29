<?php

class User
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;
    public $created_at;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
