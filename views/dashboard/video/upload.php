<?php
require_once __DIR__ . "/../../../core/Database.php";
require_once __DIR__ . "/../../../app/models/UserModel.php";
require_once __DIR__ . "/../../../app/models/VideoModel.php";
require_once __DIR__ . "/../../../app/controllers/LogoutController.php";

$config = require __DIR__ . "/../../../config/Config.php";

$db = new Database($config);
$userModel = new UserModel($db);
$videoModel = new VideoModel($db);

$userId = $_SESSION["user_id"];
$categories = $videoModel->getCategories();

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload | Streamhive</title>
    <link rel="shortcut icon" href="../../public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <script src="../../public/assets/js/sidebar.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/../../partials/navbar.php"; ?>

    <main class="dashboard">
        <div class="dashboard-title">
            <h2>Upload Video</h2>

            <div class="title-right">
                <a href="javascript:history.back()" class="logout">Back</a>
            </div>
        </div>

        <div class="form-container">
            <form action="<?php echo $config["base_path"]?>/dashboard/video/upload" method="POST" enctype="multipart/form-data" class="video-form">
                <h1>Upload Video</h1>
                
                <div class="field">
                    <label>Title</label>
                    <input id="title" type="text" name="title" required>
                </div>

                <div class="field">
                    <label>Description</label>
                    <textarea id="description" name="description"></textarea>
                </div>

                <div class="field">
                    <label>Category</label>
                    <select name="category_id" id="category_id" required>
                        <option value="" disabled selected>Choose a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category["id"] ?>">
                                <?= htmlspecialchars($category["name"]) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="field">
                    <label>Thumbnail</label>
                    <div id="thumbnail-preview" class="file-preview">
                        No file selected
                    </div>

                    <label for="thumbnail-upload" class="file-upload">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M240-280h480L570-480 450-320l-90-120-120 160Zm-80 160q-33 0-56.5-23.5T80-200v-480q0-33 23.5-56.5T160-760h126l74-80h240l74 80h126q33 0 56.5 23.5T880-680v480q0 33-23.5 56.5T800-120H160Zm0-80h640v-480H638l-73-80H395l-73 80H160v480Zm320-240Z"/></svg>
                        Upload Thumbnail
                    </label>
                    <input id="thumbnail-upload" type="file" accept=".png" name="thumbnail" required/>
                </div>

                <div class="field">
                    <label>Video</label>
                    <div id="video-preview" class="file-preview">
                        No file selected
                    </div>

                    <label for="video-upload" class="file-upload">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-320v-326L336-542l-56-58 200-200 200 200-56 58-104-104v326h-80ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z"/></svg>
                        Upload Video
                    </label>
                    <input id="video-upload" type="file" accept=".mp4" name="video" required/>
                </div>

                <div id="progress-container" style="display:none" class="progress-wrapper">
                    <div class="progress-track">
                        <div id="progress-bar" class="progress-bar"></div>
                    </div>
                    <span id="progress-label">0%</span>
                </div>

                <button>Upload</button>
            </form>
        </div>
    </main>

    <?php require __DIR__ . "/../../partials/footer.php"; ?>
    <script src="../../public/assets/js/uploadField.js"></script>
</body>
</html>