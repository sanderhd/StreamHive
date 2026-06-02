<?php

require_once __DIR__ . "/../../core/Helper.php";

class AuthController {
    private $authService;
    private $config;

    public function __construct($db, $config) {
        $this->authService = new AuthService($db);
        $this->config = $config;
    }

    private function verifyTurnstile() {
        $token = $_POST["cf-turnstile-response"] ?? '';

        if (!$token) {
            abort("CAPTCHA not completed", 400);
        }

        $verify = verifyTurnstile($token, $this->config['TURNSTILE_SECRET']);

        if (!$verify || !isset($verify["success"]) || !$verify["success"]) {
            abort("CAPTCHA verification failed. Please try again", 403);
        }
    }

    public function register() {
        $this->verifyTurnstile();

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $repeatPassword = $_POST['repeat-password'] ?? '';

        if (!$username || !$email || !$password) {
            abort("Please fill in all fields", 400);
        }

        if ($password !== $repeatPassword) {
            abort("Passwords do not match", 400);
        }

        $this->authService->registerUser($username, $email, $password);

        header("Location: dashboard");
        exit;
    }

    public function login() {
        $this->verifyTurnstile();

        $name = $_POST['name'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$name || !$password) {
            abort("Please fill in all fields", 400);
        }

        $success = $this->authService->loginUser($name, $password);

        if (!$success) {
            abort("Invalid email/username or password", 401);
        }

        header("Location: dashboard");
        exit;
    }
}