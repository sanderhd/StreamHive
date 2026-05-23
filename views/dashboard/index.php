<?php
require_once __DIR__ . "/../../core/Database.php";
require_once __DIR__ . "/../../app/models/UserModel.php";
require_once __DIR__ . "/../../app/models/VideoModel.php";
require_once __DIR__ . "/../../app/controllers/LogoutController.php";

$config = require __DIR__ . "/../../config/Config.php";

$db = new Database($config);
$userModel = new UserModel($db);
$videoModel = new VideoModel($db);

$userId = $_SESSION["user_id"];

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit;
}

$videos = $videoModel->getVideoByUserId($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Streamhive</title>
    <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="public/assets/css/style.css">
    <script src="public/assets/js/sidebar.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/../partials/navbar.php"; ?>

    <main class="dashboard">
        <div class="dashboard-title">
            <h2>Hey <?php echo $_SESSION["username"]; ?>!</h2>

            <div class="title-right">
                <a href="dashboard/video/upload" class="logout">
                    Upload
                </a>

                <a href="logout" class="logout">
                    Logout
                </a>
            </div>
        </div>

        <div class="video-grid">
            <?php foreach ($videos as $video) { ?>
                <div class="video-card">
                    <a href="<?php echo $config["base_path"]; ?>/video/<?php echo $video["id"]; ?>" class="video-link">
                        <img
                            src="public/uploads/thumbnails/<?php echo $video["thumbnail"] ?>"
                            alt="<?= htmlspecialchars($video["title"]) ?>"
                        >

                        <h3><?php echo htmlspecialchars($video["title"]) ?></h3>
                    </a>

                    <p class="video-description">
                        <?php echo htmlspecialchars($video["description"]) ?>
                    </p>

                    <div class="video-information">
                        <div class="views">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                <path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z"/>
                            </svg>

                            <?php echo (int)$video["views"] ?>

                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                            </svg>

                            <a href="dashboard/video/edit/<?php echo $video["id"] ?>">
                                Edit
                            </a>

                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                            </svg>

                            <a href="dashboard/video/delete/<?php echo $video["id"] ?>">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <?php require __DIR__ . "/../partials/footer.php"; ?>
</body>
</html>