<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/user_repository.php';

use Src\UserRepository;
use Src\Database;

$database = new Database();
$db = $database->connect();
$userRepo = new UserRepository($db);
$params = $_GET;
$data = $userRepo->fetch_paginated_data($params);

try {
    $data = $userRepo->fetch_paginated_data($params);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
} catch (\Exception $e) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
