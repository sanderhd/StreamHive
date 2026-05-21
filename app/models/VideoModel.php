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

    public function uploadVideo($title, $description, $userid, $filename) {
        return $this->db->queryDatabase(
        
        );
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
}