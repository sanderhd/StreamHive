<?php

class LikeModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function likeVideo($userId, $videoId) {
        $existing = $this->db->queryDatabase(
            "SELECT id FROM likes WHERE user_id = :user_id AND video_id = :video_id",
            [
                "user_id" => $userId,
                "video_id" => $videoId,
            ]
        )->fetch();

        if ($existing) {
            $this->db->queryDatabase(
                "DELETE FROM likes WHERE user_id = :user_id AND video_id = :video_id",
                [
                    "user_id" => $userId, 
                    "video_id" => $videoId
                ]
            );
            return false;
        }

        $this->db->queryDatabase(
            "INSERT INTO likes (user_id, video_id, comment_id, created_at) 
             VALUES (:user_id, :video_id, NULL, NOW())",
            [
                "user_id" => $userId, 
                "video_id" => $videoId
            ]
        );
        return true;
    }

    public function getVideoLikes($videoId) {
        return $this->db->queryDatabase(
            "SELECT COUNT(*) as count FROM likes WHERE video_id = :video_id", 
            [
                "video_id" => $videoId,
            ]
        )->fetch()["count"];
    }

    public function getLikedVideo($videoId, $userId) {
        return $this->db->queryDatabase(
            "SELECT id FROM likes WHERE video_id = :video_id AND user_id = :user_id",
            [
                "video_id" => $videoId,
                "user_id" => $userId,
            ]
        )->fetch();
    }
}