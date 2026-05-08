<?php

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createUser($email, $passwordHash) {
        return $this->db->queryDatabase(
            "INSERT INTO users (email, password) VALUES (:email, :password)",
            [
                "email" => $email,
                "password" => $passwordHash
            ]
        );
    }

    public function getUserById($id) {
        return $this->db->queryDatabase(
            "SELECT * FROM users WHERE id = :id",
            ["id" => $id]
        )->fetch();
    }
}