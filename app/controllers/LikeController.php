<?php

class LikeController {
    private $likeService;
    private $config;

    public function __construct($db) {
        $this->config = require __DIR__ . "/../../config/Config.php";
        $likeModel = new LikeModel($db);
        $this->likeService = new LikeService($likeModel);
    } 

    public function likeVideo($videoId) {
        if (!isset($_SESSION["user_id"])) {
            header("Location: " . $this->config["base_path"] . "/login");
            exit;
        }

        $this->likeService->likeVideo($_SESSION["user_id"], $videoId);

        header("Location: " . $this->config["base_path"] . "/video/" . $videoId);
        exit;
    }

    public function hasLikedVideo($videoId) {
        if (!isset($_SESSION["user_id"])) return false;
        return $this->likeService->hasLikedVideo($_SESSION["user_id"], $videoId);
    }
}