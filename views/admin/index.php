<?php
require_once __DIR__ . "/../../core/Database.php";
require_once __DIR__ . "/../../app/models/UserModel.php";
require_once __DIR__ . "/../../app/models/VideoModel.php";
require_once __DIR__ . "/../../core/Helper.php";

$config = require __DIR__ . "/../../config/Config.php";

$db = new Database($config);
$userModel = new UserModel($db);
$videoModel = new VideoModel($db);

$categories = $videoModel->getCategories();

if ($_SESSION["role"] !== "admin") {
    header("Location: dashboard");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | StreamHive</title>
    <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="public/assets/css/style.css">
    <script src="public/assets/js/sidebar.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/../partials/navbar.php"; ?>

    <main>
        <div class="categories">
            <h2>Categories</h2>

        
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($categories as $category) { ?>
                    <tr>
                        <td><?php echo $category["id"] ?></td>
                        <td><?php echo $category["name"] ?></td>
                        <td>
                            <a href="<?php echo $config["base_path"] ?>/admin/categories/delete/<?php echo $category["id"] ?>"
                            class="delete-btn"
                            onclick="return confirm('Are you sure?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <div class="add">
                <form method="post" action="<?php echo $config["base_path"]?>/admin/categories">
                    <input id="category" name="category" required>
                    <button type="submit">Add</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>