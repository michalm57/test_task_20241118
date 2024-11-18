<?php

class Form
{
    public function save_form($post){

        $data=$this->sanitize_data($post);
        $form_data=[
            'name'      =>$data['name'],
            'surname'   =>$data['surname'],
            'email'     =>$data['email'],
            'phone'     =>$data['phone'],
            'choose'    =>$data['choose'],
            'client_no' =>$data['client_no'],
            'agreement1'=>$data['agreement'],
            'agreement2'=>$data['agreement'],
            'userinfo'  =>$data['user_info'],
        ]

        $this=>save_form_to_db($form_data);

    }

    private function save_form_to_db($data){
        try {
            $db = new PDO("mysql:host=$db_host;dbname=",$db_username,$db_password);

            $exec = $db->prepare($query);
            $exec->execute($data);
            
            return true;
        } catch(PDOException $e) {
            return false;
        }
        $db=null;
    }

    public function counter($data){
        $db->prepare("select id_form from `zadanie` where surname = :surname");
        $db->execute(array('surname'=>$data));
        return $db->rowCount();
    }
}

function get_surname_counter($filter_data){
    $frm=new Form;
    return (int)$frm->counter($filter_data);
}

if (isset($_POST) && count($_POST)>0){
    $frm=new Form;
    return $frm->save_form();
}