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
        $this->db = Database::get_connection();
    }

    public function fetch_paginated_data($params)
    {
        $columns = [
            'name',
            'surname',
            'email',
            'phone',
            'client_no',
            'date',
        ];
    
        $start = $params['start'] ?? 0;
        $length = $params['length'] ?? 10;
    
        $order_column_index = $params['order'][0]['column'] ?? 0;
        $order_column = $columns[$order_column_index] ?? 'id';
        $order_dir = isset($params['order'][0]['dir']) && $params['order'][0]['dir'] === 'desc' ? 'DESC' : 'ASC';
    
        $search_value = $params['search']['value'] ?? '';
    
        $query = "SELECT * FROM users";
        $query_params = [];
    
        if (!empty($search_value)) {
            $query .= " WHERE name LIKE :search OR surname LIKE :search OR email LIKE :search";
            $query_params['search'] = '%' . $search_value . '%';
        }
    
        $query .= " ORDER BY $order_column $order_dir LIMIT :start, :length";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
        $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);
    
        foreach ($query_params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
    
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $total_query = "SELECT COUNT(*) FROM users";
        $total_records = $this->db->query($total_query)->fetchColumn();
    
        $filtered_query = "SELECT COUNT(*) FROM users";
        if (!empty($search_value)) {
            $filtered_query .= " WHERE name LIKE :search OR surname LIKE :search OR email LIKE :search";
        }
        $filtered_smt = $this->db->prepare($filtered_query);
        if (!empty($search_value)) {
            $filtered_smt->bindValue(':search', '%' . $search_value . '%', PDO::PARAM_STR);
        }
        $filtered_smt->execute();
        $filtered_records = $filtered_smt->fetchColumn();
    
        return [
            'draw' => $params['draw'] ?? 1,
            'recordsTotal' => (int)$total_records,
            'recordsFiltered' => (int)$filtered_records,
            'data' => $data,
        ];
    }   

    public function store_user($data)
    {
        try {
            $query = "INSERT INTO users (name, surname, email, phone, choose, client_no, agreement1, agreement2, user_info) 
                      VALUES (:name, :surname, :email, :phone, :choose, :client_no, :agreement1, :agreement2, :userinfo)";
            $exec = $this->db->prepare($query);
            $exec->execute($data);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function fetch_surname_counter($surname)
    {
        try {
            $stmt = $this->db->prepare("SELECT id FROM `users` WHERE surname = :surname");
            $stmt->execute(['surname' => $surname]);

            return $stmt->rowCount();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function fetch_email_domain_counter($domain)
    {
        try {
            $stmt = $this->db->prepare("SELECT id FROM `users` WHERE email LIKE :domain");
            $stmt->execute(['domain' => '%@' . $domain]);

            return $stmt->rowCount();
        } catch (PDOException $e) {
            return 0;
        }
    }
}
