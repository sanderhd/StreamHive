<?php
require_once __DIR__ . "/../../core/Database.php";
require_once __DIR__ . "/../../app/services/AuthService.php";
require_once __DIR__ . "/../../app/controllers/AuthController.php";
require_once __DIR__ . "/../../core/Helper.php";

$config = require "config/Config.php";

$db = new Database($config);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Streamhive</title>
    <link rel="shortcut icon" href="../public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="public/assets/css/style.css">
    <script src="public/assets/js/sidebar.js" defer></script>
    <script src="public/assets/js/passwordField.js" defer></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>
<body>
    <?php require __DIR__ . "/../partials/navbar.php"; ?>

    <main class="auth-container">
        <div class="auth-form">
            <h1>Welcome back</h1>
            <h2>Welcome back! Please enter your details</h2>

            <form action="login" method="POST">

                <div class="field">
                    <label>Email or username</label>
                    <input id="name" type="text" name="name">
                </div>

                <div class="field">
                    <label>Password</label>

                    <div class="password-field">
                       <input id="password" type="password" name="password">

                        <button type="button" class="toggle-password">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M607.5-372.5Q660-425 660-500t-52.5-127.5Q555-680 480-680t-127.5 52.5Q300-575 300-500t52.5 127.5Q405-320 480-320t127.5-52.5Zm-204-51Q372-455 372-500t31.5-76.5Q435-608 480-608t76.5 31.5Q588-545 588-500t-31.5 76.5Q525-392 480-392t-76.5-31.5ZM214-281.5Q94-363 40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200q-146 0-266-81.5ZM480-500Zm207.5 160.5Q782-399 832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280q113 0 207.5-59.5Z"/></svg>
                        </button> 
                    </div>
                </div>

                <div class="cf-turnstile" data-sitekey="0x4AAAAAADdkxWYflecmfyNU" data-theme="dark"></div>

                <button>Login</button> <a href="<?php echo $config["base_path"] ?>/auth/google" class="google-btn">Login with google</a>
            </form>
            <span class="bottom-text">
                Don't have an account?
                <a href="register">Sign up for free &rarr;</a>
            </span>
        </div>
    </main>

    <?php require __DIR__ . "/../partials/footer.php"; ?>
</body>
</html>