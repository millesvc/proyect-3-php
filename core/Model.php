<?php
/**
 * Clase base Model.
 * Compatible con PHP 7.3.
 */

require_once BASE_PATH . '/config/database.php';

abstract class Model {
    protected $db;

    public function __construct() {
        $this->db = getDB();
    }
}
