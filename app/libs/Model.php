<?php
require_once '../app/libs/Database.php';

class Model {
    protected $db;

    public function __construct() {
        // Inicializamos la conexión UNA VEZ aquí
        // Cualquier clase que herede de Model tendrá acceso a $this->db
        $this->db = Database::getInstance()->getPDO();
    }
}
?>