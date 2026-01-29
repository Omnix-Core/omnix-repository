<?php

    class Config {
        private static $instance = null;
        private $params = [];

        private function __construct() {
            $this->params = require '../config/params.php';
        }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new Config();
            }
            return self::$instance;
        }

        public function get($key) {
            return $this->params[$key] ?? null;
        }
    }
?>