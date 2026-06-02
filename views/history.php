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

    <main class="library history">
        <h2>History <span>watched videos</span></h2>

        <?php if(empty($videos)): ?>
            <p>You havent watched any videos yet</p>
        <?php else: ?>
            <div class="library-grid">
                <?php foreach($videos as $video): ?>
                        <a class="library-card" href="<?php echo $config["base_path"]; ?>/video/<?php echo $video["id"]; ?>">
                            <img 
                                src="public/uploads/thumbnails/<?php echo $video["thumbnail"] ?>"
                                alt="<?php echo $video["title"] ?>"
                            >

                            <div class="content">
                                <h3><?php echo $video["title"] ?></h3>

                                <p><?php echo $video["description"] ?></p>

                                <div class="library-information">
                                    <span class="views">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z"/></svg> <?php echo $video["views"] ?>
                                    </span>

                                    <span class="watched-at">
                                        Watched: <?php echo date("d M Y H:i", strtotime($video["watched_at"])) ?>
                                    </span>
                                </div>
                            </div>
                        </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <?php require __DIR__ . "/partials/footer.php"; ?>
</body>
</html>