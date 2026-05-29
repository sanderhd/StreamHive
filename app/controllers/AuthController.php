<?php

class AuthController {
    private $authService;

    public function __construct($db) {
        $this->authService = new AuthService($db);
    }

    public function register() {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeat-password'];

        if ($password !== $repeatPassword) {
            die("Passwords doe not match");
        };

        $this->authService->registerUser($username, $email, $password);

        header("Location: dashboard");
        exit;
    }

    public function login() {
        $name = $_POST['name'];
        $password = $_POST['password'];

        $success = $this->authService->loginUser($name, $password);

        if (!$success) {
            die("Invalied password or email");
        }
        
        header("Location: dashboard");
        exit;
    }
}