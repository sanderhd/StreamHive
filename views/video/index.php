<?php
require_once __DIR__ . "/../../core/Database.php";
require_once __DIR__ . "/../../app/models/UserModel.php";
require_once __DIR__ . "/../../app/models/VideoModel.php";

$config = require __DIR__ . "/../../config/Config.php";

$db = new Database($config);
$userModel = new UserModel($db);
$videoModel = new VideoModel($db);

$videos = $videoModel->getVideoById($video["id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $video["title"] ?> | StreamHive</title>
    <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../public/assets/css/style.css">
    <script src="../public/assets/js/sidebar.js" defer></script>
    <script src="../public/assets/js/videoController.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/../partials/navbar.php"; ?>

    <main class="video-section">
        <div class="video-player">
            <div class="player-wrapper">
                <video id="video">
                    <source src="../public/uploads/videos/<?php echo $video["filename"] ?>" type="video/mp4">
                </video>

                <div class="controls">
                    <button id="play">▶</button>
                    <button id="pause">⏸</button>
                    <input id="seek" type="range" min="0" max="100" value="0">
                    <span id="time">0:00</span>
                </div>
            </div>

            <div class="video-details">
                <h2><?php echo $video["title"] ?></h2>

                <div class="video-info">
                    <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z"/></svg> <?php echo $video["views"] ?></span>
                    <span><?php echo $video["created_at"] ?></span>
                </div>

                <p><?php echo $video["description"] ?></p>
            </div>

            <div class="video-comments">
                <h3>Comments</h3>

                <?php if (isset($_SESSION["user_id"])): ?>
                    <form method="post" action="../video/<?php echo $video["id"]; ?>/comment" class="comment-form">
                        <input
                            type="text"
                            name="comment"
                            placeholder="Write a comment..."
                            required
                        >
                        <button type="submit">Post</button>
                    </form>
                <?php else: ?>
                    <p class="login-to-comment">Log in to comment</p>
                <?php endif ?>

                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div class="content">
                            <div class="author">
                                <?php echo htmlspecialchars($comment["username"]) ?>
                            </div>

                            <div class="text">
                                <?php echo htmlspecialchars($comment["content"]) ?>
                            </div>
                        </div>

                        <?php if (isset($_SESSION["user_id"])): ?>
                            <?php if ($comment["user_id"] === $_SESSION["user_id"]): ?>
                                <div class="actions">
                                    <form method="post" action="../video/<?php echo $video["id"]; ?>/delete-comment">
                                        <input type="hidden" name="comment_id" value="<?php echo $comment["id"]; ?>">

                                        <button type="submit" class="delete-video">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <aside class="videos-recommended">
            <div class="recommended-card">
                <img src="">
                <div class="info">
                    <h4>Video Title</h4>
                    <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z"/></svg>12k</span>
                </div>
            </div>
        </aside>
    </main>
</body>
</html>