<?php 

require_once __DIR__ . "/../models/VideoModel.php";

class AdminController {
    private $videoModel;
    private $config;

    public function __construct($db, $config) {
        $this->videoModel = new VideoModel($db);
        $this->config = $config;
    }

    public function addCategory() {
        $name = trim($_POST["category"]);

        if (!empty($name)) {
            $this->videoModel->addCategory($name);
        }
        header("Location: " . $this->config["base_path"] . "/admin");
        exit;
    }

    public function deleteCategory($id) {
        $this->videoModel->deleteCategory($id);
        header("Location: " . $this->config["base_path"] . "/admin");
        exit;
    }
}