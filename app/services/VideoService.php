<?php

class VideoService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function uploadVideo($userId, $title, $description, $thumbnail, $video) {
        $videoPath = "public/uploads/videos/";
        $thumbPath = "public/uploads/thumbnails/";

        $videoName = uniqid() . "_" . basename($video["name"]);
        $thumbName = uniqid() . "_" . basename($thumbnail["name"]);

        move_uploaded_file($video["tmp_name"], $videoPath . $videoName);
        move_uploaded_file($thumbnail["tmp_name"], $thumbPath . $thumbName);

        $sql = "
            INSERT INTO videos (user_id, title, description, filename, thumbnail, views, created_at)
            VALUES (:user_id, :title, :description, :filename, :thumbnail, 0, NOW())
        ";

        $this->db->queryDatabase($sql, [
            "user_id" => $userId,
            "title" => $title,
            "description" => $description,
            "filename" => $videoName,
            "thumbnail" => $thumbName
        ]);
    }

    public function deleteVideo($videoId, $userId) {
        $video = $this->db->queryDatabase(
            "SELECT * FROM videos WHERE id = :id AND user_id = :user_id",
            [
                "id" => $videoId,
                "user_id" => $userId
            ]
        )->fetch();

        if (!$video) {
            return;
        }

        @unlink("public/uploads/videos/" . $video["filename"]);
        @unlink("public/uploads/thumbnails/" . $video["thumbnail"]);

        $this->db->queryDatabase(
            "DELETE FROM videos WHERE id = :id AND user_id = :user_id",
            [
                "id" => $videoId,
                "user_id" => $userId
            ]
        );
    }
}