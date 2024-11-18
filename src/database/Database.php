<?php

namespace Src\Database;

class Database
{
    public function connect()
    {
        $config = require __DIR__ . '/../../config/db_connection.php';

        try {
            $db = new \PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_username'],
                $config['db_password']
            );
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
