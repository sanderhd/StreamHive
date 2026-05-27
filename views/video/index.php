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
                    <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm146.5-204.5Q340-521 340-580t40.5-99.5Q421-720 480-720t99.5 40.5Q620-639 620-580t-40.5 99.5Q539-440 480-440t-99.5-40.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm100-95.5q47-15.5 86-44.5-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160q53 0 100-15.5ZM523-537q17-17 17-43t-17-43q-17-17-43-17t-43 17q-17 17-17 43t17 43q17 17 43 17t43-17Zm-43-43Zm0 360Z"/></svg> <?php echo $userModel->getUsernameById($video["user_id"])["username"]; ?></span>
                    <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z"/></svg> <?php echo $video["views"] ?></span>
                    <span>
                        <?php 
                            $now = time();
                            $your_date = strtotime($video["created_at"]);
                            $datediff = $now - $your_date;
                            echo round($datediff / (60 * 60 * 24));
                        ?>
                        days ago
                    </span>

                    <form method="POST" action="<?php echo $config["base_path"];?>/video/<?php echo $video['id']; ?>/like">
                        <button type="submit" class="like-btn  <?php echo $videoLiked ? 'liked' : ''; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                            </svg>
                            <?php echo $videoLikes; ?>
                        </button>
                    </form>
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
            <?php foreach ($recommendedVideos as $recommended): ?>
                <a href="<?php echo $config["base_path"]; ?>/video/<?php echo $recommended['id']; ?>" class="recommended-card">
                    <img 
                        src="../public/uploads/thumbnails/<?php echo $recommended['thumbnail']; ?>" 
                        alt="<?php echo $recommended['title']; ?>"
                    >
                    <div class="info">
                        <h4><?php echo $recommended['title']; ?></h4>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                <path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z"/>
                            </svg>
                            <?php echo $recommended['views']; ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </aside>
    </main>
</body>
</html>