<?php

use Google\Client;
use Google\Service\Oauth2;

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

    public function redirectToGoogle() {
        $client = new Client();

        $client->setClientId($this->config['google']["client_id"]);
        $client->setClientSecret($this->config['google']["client_secret"]);
        $client->setRedirectUri(
            $this->config['google']['redirect_uris'][0]
        );

        $client->addScope("email");
        $client->addScope("profile");

        header("Location: " . $client->createAuthUrl());
        exit;
    }

    public function handleGoogleCallback() {
        $client = new Client();

        $client->setClientId($this->config['google']["client_id"]);
        $client->setClientSecret($this->config['google']["client_secret"]);
        $client->setRedirectUri($this->config['google']['redirect_uris'][0]);

        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (!isset($token['access_token'])) {
            abort("Google login failed", 401);
        }

        $client->setAccessToken($token);

        $oauth = new Oauth2($client);
        $googleUser = $oauth->userinfo->get();

        $email = $googleUser->email;
        $name = $googleUser->name;
        $googleId = $googleUser->id;

        $user = $this->authService->findByEmail($email);

        if (!$user) {
            $user = $this->authService->createGoogleUser($name, $email, $googleId);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        header("Location: " . $this->config["base_path"] . "/dashboard");
        exit;
    }
}