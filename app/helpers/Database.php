<?php
namespace App\Helpers;
use PDO;
use PDOException;

class Database {
    private $db;

    public function __construct() {
        // Get config values
        $config = require_once __DIR__.'/../../config/db.php';

        try {
            $this->db = new PDO(
                "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}",
                $config['username'],
                $config['password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->db;
    }
}
