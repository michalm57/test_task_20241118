<?php

namespace Src\Forms;

require_once __DIR__ . '/../database/Database.php';

use Src\Database\Database; 

class Form
{
    protected $db;

    public function __construct()
    {
        $dataBase = new Database();
        $this->db = $dataBase->connect();
    }

    public function save_form($post)
    {

        $data = $this->sanitize_data($post);

        $form_data = [
            'name'      => $data['name'],
            'surname'   => $data['surname'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'choose'    => $data['choose'],
            'client_no' => $data['client_no'],
            'agreement1' => $data['agreement'],
            'agreement2' => $data['agreement'],
            'userinfo'  => $data['userinfo'],
        ];

        return $this->save_form_to_db($form_data);
    }

    public function counter($data)
    {
        $this->db->prepare("select id_form from `zadanie` where surname = :surname");
        $this->db->execute(array('surname' => $data));
        return $this->db->rowCount();
    }

    
    private function save_form_to_db($data)
    {
        try {
            $query = "INSERT INTO zadanie (name, surname, email, phone, choose, client_no, agreement1, agreement2, user_info) 
                      VALUES (:name, :surname, :email, :phone, :choose, :client_no, :agreement1, :agreement2, :userinfo)";
            $exec = $this->db->prepare($query);
            $exec->execute($data);

            return true;
        } catch (PDOException $e) {
            return false;
        }
        $db = null;
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
}

function get_surname_counter($filter_data)
{
    $frm = new Form();
    return (int)$frm->counter($filter_data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frm = new Form();
    $result = $frm->save_form($_POST);
    
    if ($result) {
        header('Location: /index.php?status=success');
        exit;
    } else {
        header('Location: /index.php?status=error');
        exit;
    }
}