<?php
$config = require __DIR__ . "/../../config/Config.php";

class SearchController {
    private $config;
    private $searchService;

    public function __construct($db) {
        $this->config = require __DIR__ . "/../../config/Config.php"; 
        $this->searchService = new SearchService($db);
    }

    public function searchVideo() {
        $params = $_GET["search"];

        $this->searchService->searchVideo(
            $params
        );

        
    }
}