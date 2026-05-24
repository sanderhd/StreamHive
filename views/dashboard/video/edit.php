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
    <title>Edit | Streamhive</title>
    <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <script src="../../../public/assets/js/sidebar.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/../../partials/navbar.php"; ?>

    <main class="dashboard">
        <div class="dashboard-title">
            <h2>Edit Video | <?php echo $video["title"] ?></h2>

            <div class="title-right">
                <a href="javascript:history.back()" class="logout">Back</a>
            </div>
        </div>

        <div class="form-container">
            <form action="<?php echo $config["base_path"]; ?>/dashboard/video/edit/<?php echo $video["id"]; ?>" method="POST" enctype="multipart/form-data" class="video-form">
                <h1>Edit Video | <?php echo $video["title"]; ?></h1>
                
                <div class="field">
                    <label>Title</label>
                    <input id="title" type="text" name="title" value="<?php echo $video["title"] ?>">
                </div>

                <div class="field">
                    <label>Description</label>
                    <textarea id="description" name="description">
                        <?php echo $video["description"]; ?>
                    </textarea>
                </div>

                <div class="field">
                    <label>Thumbnail</label>
                    <div id="thumbnail-replace" class="file-preview">
                        No file selected
                    </div>
                    <label for="thumbnail-replace-upload" class="file-upload">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M240-280h480L570-480 450-320l-90-120-120 160Zm-80 160q-33 0-56.5-23.5T80-200v-480q0-33 23.5-56.5T160-760h126l74-80h240l74 80h126q33 0 56.5 23.5T880-680v480q0 33-23.5 56.5T800-120H160Zm0-80h640v-480H638l-73-80H395l-73 80H160v480Zm320-240Z"/></svg>
                        Replace Thumbnail
                    </label>
                    <input id="thumbnail-replace-upload" type="file" accept=".png" name="thumbnail" />
                </div>

                <button>Update</button>
            </form>
        </div>
    </main>

    <?php require __DIR__ . "/../../partials/footer.php"; ?>
    <script src="../../../public/assets/js/uploadField.js"></script>
</body>
</html>