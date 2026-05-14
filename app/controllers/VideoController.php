<?php

class VideoController {
    private $videoService;

    public function __construct($db) {
        $this->videoService = new VideoService($db);
    }

    public function uploadVideo() {
        $userId = $_SESSION["user_id"];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $thumbnail = $_FILES['thumbnail'];
        $video = $_FILES['video'];

        $this->videoService->uploadVideo(
            $userId,
            $title,
            $description,
            $thumbnail,
            $video
        );

        header("Location: ../../dashboard");
        exit;
    }

    public function deleteVideo($id) {
        $userId = $_SESSION["user_id"];
        $this->videoService->deleteVideo($id, $userId);

        header("Location: ../../");
        exit;
    } 
}