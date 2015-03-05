<?php
namespace Service;
require 'services/DatabaseService.php';

class CategoryService {
    private $dbService = null;
    public function __construct() {
        $this->dbService = new \Service\DatabaseService();
    }

    public function getCategory($name) {
        $sql = "select * FROM category where name = '$name'";
        $results = $this->dbService->executeQuery($sql);
        return $results;
    }
}
