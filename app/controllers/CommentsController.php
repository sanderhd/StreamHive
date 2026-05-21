<?php

$config = require __DIR__ . "/../../config/Config.php";

class CommentController {
    private $commentService;
    private $config;

    public function __construct($db) {
        $this->config = require __DIR__ . "/../../config/Config.php";

        $commentModel = new CommentModel($db);
        $this->commentService = new CommentService($commentModel);
    }

    public function add($videoId) {
        if (!isset($_SESSION["user_id"])) {
            header("Location: /login");
            exit;
        }

        $comment = $_POST["comment"];

        if (empty($comment)) {
            die("Comment cannot be empty");
        }

        $this->commentService->addComment(
            $videoId,
            $_SESSION["user_id"],
            $comment
        );

        header("Location: " . $this->config["base_path"] . "/video/" . $videoId);
        exit;
    }

    public function delete($videoId, $commentId) {
        if (!isset($_SESSION["user_id"])) {
            header("Location: login");
            exit;
        }

        $this->commentService->deleteComment(
            $commentId,
            $_SESSION["user_id"]
        );

        header("Location: " . $this->config["base_path"] . "/video/" . $videoId);
        exit;
    }
}