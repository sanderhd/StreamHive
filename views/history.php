<?php

$config = require __DIR__ . "/../config/Config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History | Streamhive</title>
    <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="public/assets/css/style.css">
    <script src="public/assets/js/sidebar.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/partials/navbar.php"; ?>

    <main>
        <h2>History</h2>

        <?php if(empty($videos)): ?>
            <p>You havent watched any videos yet</p>
        <?php else: ?>
            <div class="videos">
                <?php foreach($videos as $video): ?>
                    <div class="video-card">
                        <a href="<?php echo $config["base_path"]; ?>/video/<?php echo $video["id"]; ?>">
                            <img 
                                src="/uploads/thumbnails/<?php echo $video["thumbnail"] ?>"
                                alt="<?php echo $video["title"] ?>"
                            >

                            <h3><?php echo $video["title"] ?></h3>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <?php require __DIR__ . "/partials/footer.php"; ?>
</body>
</html>