<?php

namespace Src;

require_once __DIR__ . '/database.php';

use Src\Database;
use PDO;

class UserRepository
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function fetchPaginatedData($params)
    {
        $columns = [
            'name',
            'surname',
            'email',
            'phone',
            'choose',
            'client_no',
            'agreement1',
            'userinfo',
        ];
    
        $start = $params['start'] ?? 0;
        $length = $params['length'] ?? 10;
    
        $orderColumnIndex = $params['order'][0]['column'] ?? 0;
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';
        $orderDir = isset($params['order'][0]['dir']) && $params['order'][0]['dir'] === 'desc' ? 'DESC' : 'ASC';
    
        $searchValue = $params['search']['value'] ?? '';
    
        $query = "SELECT * FROM zadanie";
        $queryParams = [];
    
        if (!empty($searchValue)) {
            $query .= " WHERE name LIKE :search OR surname LIKE :search OR email LIKE :search";
            $queryParams['search'] = '%' . $searchValue . '%';
        }
    
        $query .= " ORDER BY $orderColumn $orderDir LIMIT :start, :length";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
        $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);
    
        foreach ($queryParams as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
    
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $totalQuery = "SELECT COUNT(*) FROM zadanie";
        $totalRecords = $this->db->query($totalQuery)->fetchColumn();
    
        $filteredQuery = "SELECT COUNT(*) FROM zadanie";
        if (!empty($searchValue)) {
            $filteredQuery .= " WHERE name LIKE :search OR surname LIKE :search OR email LIKE :search";
        }
        $filteredStmt = $this->db->prepare($filteredQuery);
        if (!empty($searchValue)) {
            $filteredStmt->bindValue(':search', '%' . $searchValue . '%', PDO::PARAM_STR);
        }
        $filteredStmt->execute();
        $filteredRecords = $filteredStmt->fetchColumn();
    
        return [
            'draw' => $params['draw'] ?? 1,
            'recordsTotal' => (int)$totalRecords,
            'recordsFiltered' => (int)$filteredRecords,
            'data' => $data,
        ];
    }    
}
