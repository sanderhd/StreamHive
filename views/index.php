<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../app/models/UserModel.php";
require_once __DIR__ . "/../app/models/VideoModel.php";

$config = require __DIR__ . "/../config/Config.php";

$db = new Database($config);
$userModel = new UserModel($db);
$videoModel = new VideoModel($db);

$videos = $videoModel->getAllVideos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamhive</title>
    <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="public/assets/css/style.css">
    <script src="public/assets/js/sidebar.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/partials/navbar.php"; ?>

    <main class="videos">
        <div class="video-grid">
            <?php foreach ($videos as $video) { ?>
                <a href="<?php echo $config["base_path"]; ?>/video/<?php echo $video["id"] ?>" class="video-link">
                    <div class="video-card">
                        <img 
                            src="public/uploads/thumbnails/<?php echo $video["thumbnail"]?>"
                            alt="<?= $video["title"] ?>"
                        >
                        <h3 class=""><?php echo $video["title"] ?></h3>
                        <p class="video-description"><?php echo $video["description"] ?></p>
                        
                        <div class="video-information">
                            <div class="views">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z"/></svg> <?php echo $video["views"] ?>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M291.5-411.5Q280-423 280-440t11.5-28.5Q303-480 320-480t28.5 11.5Q360-457 360-440t-11.5 28.5Q337-400 320-400t-28.5-11.5Zm160 0Q440-423 440-440t11.5-28.5Q463-480 480-480t28.5 11.5Q520-457 520-440t-11.5 28.5Q497-400 480-400t-28.5-11.5Zm160 0Q600-423 600-440t11.5-28.5Q623-480 640-480t28.5 11.5Q680-457 680-440t-11.5 28.5Q657-400 640-400t-28.5-11.5ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg> <?php echo date("d-m-Y", strtotime($video["created_at"])); ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </main>

    <?php require __DIR__ . "/partials/footer.php"; ?>
</body>
</html>