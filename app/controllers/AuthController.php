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
            die("CAPTCHA missing");
        }

        $verify = verifyTurnstile($token, $this->config['TURNSTILE_SECRET']);

        if (!$verify || !isset($verify["success"]) || !$verify["success"]) {
            die("CAPTCHA failed");
        }
    }

    public function register() {
        $this->verifyTurnstile();

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $repeatPassword = $_POST['repeat-password'] ?? '';

        if (!$username || !$email || !$password) {
            die("Missing fields");
        }

        if ($password !== $repeatPassword) {
            die("Passwords do not match");
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
            die("Missing login fields");
        }

        $success = $this->authService->loginUser($name, $password);

        if (!$success) {
            die("Invalid email/username or password");
        }

        header("Location: dashboard");
        exit;
    }
}