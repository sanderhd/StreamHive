<?php

$config = require __DIR__ . "/../config/Config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 | Streamhive</title>
    <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="public/assets/css/style.css">
    <script src="public/assets/js/sidebar.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/partials/navbar.php"; ?>

    <main>
        <div class="error-page">
            <h1>404</h1>
            <h2>Oops! Something is wrong...</h2>
            <p>We couldn't find the page you were looking for</p>

            <div class="buttons">
                <a href="<?php echo $config["base_path"] ?>">Go home</a>
            </div>
        </div>
    </main>

    <?php require __DIR__ . "/partials/footer.php"; ?>
</body>
</html>