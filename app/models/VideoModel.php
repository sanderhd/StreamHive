<?php

class VideoModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getVideoById($id) {
        return $this->db->queryDatabase(
            "SELECT * FROM videos WHERE id = :id",
            ["id" => $id]
        )->fetch();
    }

    public function getAllVideos() {
        return $this->db->queryDatabase(
            "SELECT * FROM videos"
        )->fetchAll();
    }

    public function getTrendingVideos() {
        return $this->db->queryDatabase(
            "SELECT * FROM videos ORDER BY views DESC"
        )->fetchAll();
    }

    public function searchVideo($query) {
        return $this->db->queryDatabase(
            "SELECT * FROM videos WHERE title =:query",
            ["query" => $query]
        )->fetch();
    }

    public function getVideoByUserId($userid) {
        return $this->db->queryDatabase(
            "SELECT * FROM videos WHERE user_id =:userid",
            ["userid" => $userid]
        )->fetchAll();
    }

    public function getVideos($search) {
        if (!empty($search)) {
            return $this->db->queryDatabase(
                "SELECT * FROM videos
                WHERE title LIKE :search
                OR description LIKE :search
                ORDER BY created_at DESC",
                [
                    "search" => "%" . $search . "%"
                ]
            );
        }

        return $this->db->queryDatabase(
            "SELECT * FROM videos ORDER BY created_at DESC"
        );
    }

    public function getRecommendedVideos($videoId) {
        return $this->db->queryDatabase(
            "SELECT * FROM videos
            WHERE id != :exclude_id
            ORDER BY views DESC",
            [
                "exclude_id" => $videoId,
            ]
        )->fetchAll();
    }
}