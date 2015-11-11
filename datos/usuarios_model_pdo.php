<?php

require_once('db_abstract_model_pdo.php');

class Usuario extends DBAbstractModel {

    public $nombre;
    public $apellido;
    public $email;
    private $clave;
    public $id;

    function __construct() {
        $this->db_name = 'AMBUser';
    }

    public function get_all() {
            $this->query = " SELECT id, nombre, apellido, email, clave FROM usuarios  ";
            $this->get_all_results_from_query();
            return $this->rows;
    }
    
    public function get($user_email = '') {
        if ($user_email != ''):
            
            $this->query = " SELECT id, nombre, apellido, email, clave FROM usuarios WHERE email = '$user_email' ";
            $this->get_results_from_query();
            $this->id= $this->rows->id;
            $this->nombre= $this->rows->nombre;
            $this->apellido= $this->rows->apellido;
            $this->email= $this->rows->email;
            $this->clave= $this->rows->clave;
            
        endif;
        return $this;
    }

    public function save() {
       $this->query = "INSERT INTO usuarios (id,nombre, apellido, email, clave) VALUES ('$this->id','$this->nombre', '$this->apellido', '$this->email', '$this->clave')";
       return $this->execute_single_query();;
    }

    public function edit($user_email_old) {
        $this->query = "UPDATE usuarios SET nombre='$this->nombre', apellido='$this->apellido',clave='$this->clave', email = '$this->email' WHERE email ='$user_email_old' ";
        $this->execute_single_query();
    }

    public function delete() {
        $this->query = "DELETE FROM usuarios WHERE email = '$this->email' ";
        $this->execute_single_query();
    }

    function __destruct() {
        unset($this);
    }

}

