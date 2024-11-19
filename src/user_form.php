<?php

namespace Src;

require __DIR__ . '/database.php';

use Src\Database;
use PDOException;

class UserForm
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    private function sanitize_data($data)
    {
        return [
            'name'      => htmlspecialchars(trim($data['name'])),
            'surname'   => htmlspecialchars(trim($data['surname'])),
            'email'     => htmlspecialchars(trim($data['email'])),
            'phone'     => htmlspecialchars(trim($data['phone'])),
            'choose'    => htmlspecialchars(trim($data['choose'])),
            'client_no' => htmlspecialchars(trim($data['client_no'])),
            'agreement' => isset($data['agreement1']) ? 1 : 0,
            'userinfo'  => htmlspecialchars(trim($data['userinfo'] ?? '')),
        ];
    }

    public function save_form($post)
    {
        $validation = $this->is_form_valid($post);
        if (!$validation['valid']) {
            return $this->json_response(422, $validation['data'], 'Validation error!');
        }

        $data = $this->sanitize_data($post);

        $data = $this->map_data($data);

        if($data = $this->save_form_to_db($data)) {
            return $this->json_response(200, $data, 'Data saved!');
        } else {
            return $this->json_response(200, $data, 'Error!');
        }
    }

    private function save_form_to_db($data)
    {
        try {
            $query = "INSERT INTO zadanie (name, surname, email, phone, choose, client_no, agreement1, agreement2, user_info) 
                      VALUES (:name, :surname, :email, :phone, :choose, :client_no, :agreement1, :agreement2, :userinfo)";
            $exec = $this->db->prepare($query);
            $exec->execute($data);
            $lastInsertId = $this->db->lastInsertId();
            $query = "SELECT * FROM zadanie WHERE id = :id";
            $exec = $this->db->prepare($query);
            $exec->bindParam(':id', $lastInsertId, PDO::PARAM_INT);
            $exec->execute();
    
            return $exec->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    private function map_data($data)
    {
        return [
            'name'      => $data['name'],
            'surname'   => $data['surname'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'choose'    => $data['choose'],
            'client_no' => $data['client_no'],
            'agreement1'=> $data['agreement'],
            'agreement2'=> $data['agreement'],
            'userinfo'  => $data['userinfo'],
        ];
    }

    public function counter($surname)
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT id_form FROM `zadanie` WHERE surname = :surname");
            $stmt->execute(['surname' => $surname]);

            return $stmt->rowCount();
        } catch (PDOException $e) {
            return 0;
        }
    }

    private function is_form_valid($data)
    {
        $errors = [];
        $requiredFields = ['name', 'surname', 'email', 'client_no', 'choose', 'agreement1', 'agreement2'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[] = "Pole {$field} jest wymagane.";
            }
        }
        if (!empty($data['client_no']) && !preg_match('/^\d{3}[0-9]{3}-[A-Z]{5}$/', $data['client_no'])) {
            $errors[] = "Numer klienta musi mieć format 000DDD-WWWWW, gdzie D to cyfry, a W to wielkie litery.";
        }
        if (!empty($data['choose']) && $data['choose'] === '1') {
            if (empty($data['account'])) {
                $errors[] = "Pole Numer konta jest wymagane przy wyborze 1.";
            } elseif (!preg_match('/^\d{26}$/', $data['account'])) {
                $errors[] = "Numer konta musi być polskim numerem (26 cyfr).";
            }
        }
        if (!empty($data['phone']) && !preg_match('/^\d{9}$/', $data['phone'])) {
            $errors[] = "Numer telefonu musi składać się z 9 cyfr.";
        }
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Adres e-mail jest nieprawidłowy.";
        }
        if (empty($data['agreement1']) || $data['agreement1'] !== 'on') {
            $errors[] = "Musisz zaakceptować Oświadczenie 1.";
        }
        if (empty($data['agreement2']) || $data['agreement2'] !== 'on') {
            $errors[] = "Musisz zaakceptować Oświadczenie 2.";
        }
    
        return empty($errors) ? ['valid' => true, 'data' => []] : ['valid' => false, 'data' => $errors];
    }

    private function json_response($code = 200, $data = [], $message = null)
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');

        return json_encode([
            'status' => $code < 300,
            'data' => $data,
            'message' => $message
        ]);
    }
}

function get_surname_counter($surname)
{
    $frm = new UserForm;
    return (int) $frm->counter($surname);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    $frm = new UserForm();
    $result = $frm->save_form($_POST);

    header('Content-Type: application/json; charset=utf-8');
    echo $result;
    exit;
}
