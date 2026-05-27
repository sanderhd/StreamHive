<?php

class LikeService {
    private $likeModel;

    public function __construct($likeModel) {
        $this->likeModel = $likeModel;
    }

    public function likeVideo($userId, $videoId) {
        return $this->likeModel->likeVideo($userId, $videoId);
    }

    public function getVideoLikeCount($videoId) {
        return $this->likeModel->getVideoLikeCount($videoId);
    }

    public function hasLikedVideo($userId, $videoId) {
        return $this->likeModel->getLikedVideo($videoId, $userId);
    }
}