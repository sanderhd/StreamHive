<?php

class SearchService {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    public function searchVideo($params) {

        return $this->db->queryDatabase(
            "SELECT * FROM videos 
             WHERE title LIKE :params 
             OR description LIKE :params",
            [
                "params" => "%" . $params . "%",
            ]
        );
    }
}