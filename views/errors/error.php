<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Streamhive</title>
    <link rel="shortcut icon" href="../public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="public/assets/css/style.css">
    <script src="public/assets/js/sidebar.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/../partials/navbar.php"; ?>

    <main class="auth-container">
        <div class="auth-form">
            <h1>Something went wrong</h1>

            <p><?php echo htmlspecialchars($message ?? "Unknown error") ?></p>

            <a href="javascript:history.back()">Go back</a>
        </div>
    </main>

    <?php require __DIR__ . "/../partials/footer.php"; ?>
</body>
</html>