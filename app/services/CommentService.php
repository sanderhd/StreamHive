<?php

class CommentService {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getComments($videoId) {
        return $this->model->getByVideoId($videoId);
    }

    public function addComment($videoId, $userId, $text) {
        $text = trim($text);

        if ($text === "") {
            return false;
        }

        if (strlen($text) > 1000) {
            return false;
        }

        return $this->model->create($videoId, $userId, $text);
    }

    public function deleteComment($commentId, $userId) {
        return $this->model->delete($commentId, $userId);
    }
}