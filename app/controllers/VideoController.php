<?php
$config = require __DIR__ . "/../../config/Config.php";

class VideoController {
    private $videoService;
    private $config;

    public function __construct($db) {
        $this->config = require __DIR__ . "/../../config/Config.php";
        $this->videoService = new VideoService($db);
    }

    public function uploadVideo() {
        session_start();

        if (!isset($_SESSION["user_id"])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION["user_id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $thumbnail = $_FILES["thumbnail"];
        $video = $_FILES["video"];

        $this->videoService->uploadVideo(
            $userId,
            $title,
            $description,
            $thumbnail,
            $video
        );

        header("Location: " . $this->config["base_path"] . "/dashboard");
        exit;
    }

    public function deleteVideo($id) {
        $userId = $_SESSION["user_id"];
        $this->videoService->deleteVideo($id, $userId);

        header("Location: " . $this->config["base_path"] . "/dashboard");
        exit;
    } 

    public function updateVideo($id) {
        session_start();

        if (!isset($_SESSION["user_id"])) {
            header("Location: " . $this->config["base_path"] . "/login");
        }

        $userId = $_SESSION["user_id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $thumbnail = $_FILES["thumbnail"] ?? null;

        $this->videoService->updateVideo(
            $id,
            $userId,
            $title,
            $description,
            $thumbnail
        );

        header("Location: " . $this->config["base_path"] . "/dashboard");
        exit;
    }
}