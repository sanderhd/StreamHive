<?php

class CommentModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getByVideoId($videoId) {
        return $this->db->queryDatabase(
            "SELECT c.*, u.username
             FROM comments c
             JOIN users u ON c.user_id = u.id
             WHERE c.video_id = :video_id
             ORDER BY c.created_at DESC",
            ["video_id" => $videoId]
        )->fetchAll();
    }

    public function create($videoId, $userId, $content) {
        return $this->db->queryDatabase(
            "INSERT INTO comments (video_id, user_id, content)
            VALUES (:video_id, :user_id, :content)",
            [
                "video_id" => $videoId,
                "user_id" => $userId,
                "content" => $content
            ]
        );
    }

    public function delete($commentId, $userId) {
        return $this->db->queryDatabase(
            "DELETE FROM comments
             WHERE id = :id AND user_id = :user_id",
            [
                "id" => $commentId,
                "user_id" => $userId
            ]
        );
    }
}