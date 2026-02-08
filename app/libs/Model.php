<?php
require_once '../app/libs/Database.php';

class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getPDO();
    }
}
?>