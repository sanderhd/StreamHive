<?php

$config = require __DIR__ . "/../config/Config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libary | Streamhive</title>
    <link rel="shortcut icon" href="public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="public/assets/css/style.css">
    <script src="public/assets/js/sidebar.js" defer></script>
</head>
<body>
    <?php require __DIR__ . "/partials/navbar.php"; ?>

    <main class="library">
        <div class="category-filters">
            <a href="<?= $config["base_path"] ?>/library<?= !empty($search) ? '?search=' . urlencode($search) : '' ?>"
            class="filter-btn <?= empty($_GET['category']) ? 'active' : '' ?>">
                All
            </a>
            <?php foreach ($categories as $cat): ?>
                <?php
                $params = [];
                if (!empty($search))          $params["search"]   = $search;
                if ($cat["id"] != ($_GET["category"] ?? null)) $params["category"] = $cat["id"];
                $url = $config["base_path"] . "/library" . (!empty($params) ? '?' . http_build_query($params) : '');
                $isActive = ($_GET["category"] ?? null) == $cat["id"];
                ?>
                <a href="<?= $url ?>" class="filter-btn <?= $isActive ? 'active' : '' ?>">
                    <?= htmlspecialchars($cat["name"]) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($search)): ?>
            <h2>Results for "<?= htmlspecialchars($search) ?>"</h2>
        <?php endif; ?>

        <div class="library-grid">
            <?php if (empty($videos)): ?>
                <p>No videos found.</p>
            <?php endif; ?>

            <?php foreach ($videos as $video): ?>
                <a href="<?= $config["base_path"] ?>/video/<?= $video["id"] ?>" class="library-card">
                    <img
                        src="public/uploads/thumbnails/<?= $video["thumbnail"] ?>"
                        alt="<?= htmlspecialchars($video["title"]) ?>"
                    >
                    <div class="content">
                        <h3><?= htmlspecialchars($video["title"]) ?></h3>
                        <p><?= htmlspecialchars($video["description"]) ?></p>
                        <?php if (!empty($video["category_name"])): ?>
                            <span class="category-tag"><?= htmlspecialchars($video["category_name"]) ?></span>
                        <?php endif; ?>
                        <div class="library-information">
                            <div class="views">
                                <?= $video["views"] ?> views &nbsp;·&nbsp;
                                <?= date("d-m-Y", strtotime($video["created_at"])) ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>

    <?php require __DIR__ . "/partials/footer.php"; ?>
</body>
</html>