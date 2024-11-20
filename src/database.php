<?php

namespace Src;

class Database
{
    private static ?self $instance = null;
    private static ?\PDO $connection = null;

    private function __construct()
    {
        $config = require __DIR__ . '/../config/db_connection.php';

        try {
            self::$connection = new \PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_username'],
                $config['db_password']
            );
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function get_instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function get_connection(): \PDO
    {
        if (self::$connection === null) {
            self::get_instance();
        }

        return self::$connection;
    }
}
