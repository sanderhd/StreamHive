<?php
require_once __DIR__ . "/../../core/Database.php";
require_once __DIR__ . "/../../app/models/UserModel.php";
require_once __DIR__ . "/../../app/models/VideoModel.php";

require_once __DIR__ . "/../../core/Helper.php";

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
    <link rel="shortcut icon" href="../public/images/favicon.ico" type="image/x-icon">

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

                <button id="center-play" class="center-play">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path d="M320-200v-560l440 280-440 280Z"/>
                    </svg>
                </button>

                <div class="controls">
                    <button id="toggle-play">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                            <path d="M320-200v-560l440 280-440 280Z"/>
                        </svg>
                    </button>
                    <input id="seek" type="range" min="0" max="100" value="0">
                    <span id="time">0:00</span>
                    <button id="volume-icon" class="volume-icon-btn">
                        <!-- wordt gevuld door JS -->
                    </button>
                    <input id="volume" type="range" min="0" max="1" step="0.01" value="1" class="volume-slider">
                </div>
            </div>

            <div class="video-details">
                <h2><?php echo htmlspecialchars($video["title"]) ?></h2>

                <div class="video-meta">
                    <div class="uploader">
                        <div class="avatar">
                            <?php echo strtoupper(substr($userModel->getUsernameById($video["user_id"])["username"], 0, 1)); ?>
                        </div>
                        <span class="username"><?php echo htmlspecialchars($userModel->getUsernameById($video["user_id"])["username"]); ?></span>
                    </div>

                    <div class="video-stats">
                        <span class="stat">
                            <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#aaa">
                                <path d="M320-200v-560l440 280-440 280Z"/>
                            </svg>
                            <?php echo $video["views"] ?>
                        </span>
                        <span class="stat"><?= timeAgo($video["created_at"]) ?></span>

                        <form method="POST" action="<?php echo $config["base_path"];?>/video/<?php echo $video['id']; ?>/like">
                            <button type="submit" class="like-btn <?php echo $videoLiked ? 'liked' : ''; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                                </svg>
                                <?php echo $videoLikes; ?>
                            </button>
                        </form>
                    </div>
                </div>

                <?php if (!empty($video["description"])): ?>
                    <p class="description"><?php echo htmlspecialchars($video["description"]) ?></p>
                <?php endif ?>
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