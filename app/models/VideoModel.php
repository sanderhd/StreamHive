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

    public function getVideos($search = "", $categoryId = null) {
        $params = [];
        $sql = "SELECT videos.*, GROUP_CONCAT(categories.name SEPARATOR ', ') AS category_names
                FROM videos
                LEFT JOIN video_category ON videos.id = video_category.video_id
                LEFT JOIN categories ON video_category.category_id = categories.id
                WHERE 1=1";

        if (!empty($search)) {
            $sql .= " AND (videos.title LIKE :search OR videos.description LIKE :search)";
            $params["search"] = "%" . $search . "%";
        }

        if (!empty($categoryId)) {
            $sql .= " AND video_category.category_id = :category_id";
            $params["category_id"] = $categoryId;
        }

        $sql .= " GROUP BY videos.id ORDER BY videos.created_at DESC";

        return $this->db->queryDatabase($sql, $params)->fetchAll();
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

    // categories

    public function getCategories() {
        return $this->db->queryDatabase(
            "SELECT * FROM categories"
        )->fetchAll();
    }

    public function addCategory($name) {
        return $this->db->queryDatabase(
            "INSERT INTO categories (name) VALUES (:name)",
            [
                "name" => $name
            ]
        );
    }

    public function deleteCategory($id) {
        return $this->db->queryDatabase(
            "DELETE FROM categories WHERE id = :id",
            [
                "id" => $id
            ]
        );
    }
}