<?php

class VideoService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function uploadVideo($userId, $title, $description, $thumbnail, $video, $categoryId) {
        $videoPath = "public/uploads/videos/";
        $thumbPath = "public/uploads/thumbnails/";
        $videoName = uniqid() . "_" . basename($video["name"]);
        $thumbName = uniqid() . "_" . basename($thumbnail["name"]);

        move_uploaded_file($video["tmp_name"], $videoPath . $videoName);
        move_uploaded_file($thumbnail["tmp_name"], $thumbPath . $thumbName);

        $this->db->queryDatabase(
            "INSERT INTO videos (user_id, title, description, filename, thumbnail, views, created_at)
            VALUES (:user_id, :title, :description, :filename, :thumbnail, 0, NOW())",
            [
                "user_id"     => $userId,
                "title"       => $title,
                "description" => $description,
                "filename"    => $videoName,
                "thumbnail"   => $thumbName
            ]
        );

        $videoId = $this->db->lastInsertId();

        $this->db->queryDatabase(
            "INSERT INTO video_category (video_id, category_id) VALUES (:video_id, :category_id)",
            [
                "video_id"    => $videoId,
                "category_id" => $categoryId
            ]
        );
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

    public function registerView($videoId) {
        $this->db->queryDatabase(
            "UPDATE videos SET views = views + 1 WHERE id = :id",
            [
                "id" => $videoId,
            ]
        );
    }

    public function updateVideo($videoId, $userId, $title, $description, $thumbnail = null, $categoryId = null) {
        $video = $this->db->queryDatabase(
            "SELECT * FROM videos WHERE id = :id AND user_id = :user_id",
            ["id" => $videoId, "user_id" => $userId]
        )->fetch();

        if (!$video) return false;

        $params = [
            "id" => $videoId,
            "user_id" => $userId,
            "title" => $title,
            "description" => $description
        ];

        $sql = "UPDATE videos SET title = :title, description = :description";

        if ($thumbnail && $thumbnail["name"]) {
            $thumbPath = "public/uploads/thumbnails/";
            $thumbName = uniqid() . "_" . basename($thumbnail["name"]);
            move_uploaded_file($thumbnail["tmp_name"], $thumbPath . $thumbName);
            $sql .= ", thumbnail = :thumbnail";
            $params["thumbnail"] = $thumbName;
            @unlink($thumbPath . $video["thumbnail"]);
        }

        $sql .= " WHERE id = :id AND user_id = :user_id";
        $this->db->queryDatabase($sql, $params);

        if ($categoryId) {
            $this->db->queryDatabase(
                "DELETE FROM video_category WHERE video_id = :video_id",
                ["video_id" => $videoId]
            );
            $this->db->queryDatabase(
                "INSERT INTO video_category (video_id, category_id) VALUES (:video_id, :category_id)",
                ["video_id" => $videoId, "category_id" => $categoryId]
            );
        }

        return true;
    }
}