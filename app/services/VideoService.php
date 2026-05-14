<?php

class VideoService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function uploadVideo($userId, $title, $description, $thumbnail, $video) {
        $videoName = time() . "_" . basename($video["name"]);
        $thumbnailName = time() . "_" . basename($video['name']);

        $videoPath = __DIR__ . "/../../public/uploads/videos" . $videoName;
        $thumbnailPath = __DIR__ . "/../../public/uploads/thumbnails" . $thumbnailName;

        move_uploaded_file($video["tmp_name"], $videoPath);
        move_uploaded_file($video["tmp_name"], $thumbnailPath);

        $sql = "
            INSERT INTO videos
            (user_id, title, description, filename, thumbnail)
            VALUES
            (:user_id, :title, :description, :filename, :thumbnail)
        ";

        $this->db->queryDatabase($sql, [
            "user_id" => $userId,
            "title" => $title,
            "description" => $description,
            "filename" => $videoName,
            "thumbnail" => $thumbnailName
        ]);
    }

    public function deleteVideo($videoId, $userId) {
        $this->db->queryDatabase(
            "DELETE FROM videos WHERE id = :id AND user_id = :user_id", [
                "id" => $videoId,
                "user_id" => $userId
            ]
        );
    }
}