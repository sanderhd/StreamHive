<?php

class AuthService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registerUser($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $this->db->queryDatabase(
            "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)",
            [
                "username" => $username,
                "email" => $email,
                "password" => $hashedPassword
            ] 
        );
    }

    function loginUser($name, $password) {
        $user = $this->db->queryDatabase(
            "SELECT * FROM users WHERE email = :name OR username =:name",
            [
                "name" => $name
            ]
        )->fetch();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION["username"] = $user["username"];
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        return true;
    }
}