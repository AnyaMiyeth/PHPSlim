<?php

abstract class DBAbstractModel {

    private static $db_host = 'localhost';
    private static $db_user = 'root';
    private static $db_pass = '';
    protected $db_name = 'AMBUser';
    protected $query;
    protected $rows = array();
    protected $conn;

# métodos abstractos para ABM de clases que hereden

    abstract protected function get_all();
    
    abstract protected function get();

    abstract protected function save();

    abstract protected function edit($pk);

    abstract protected function delete();
# los siguientes métodos pueden definirse con exactitud
# y no son abstractos
# Conectar a la base de datos

    private function open_connection() {
        $this->conn  = new PDO('mysql:host=' . self::$db_host . ';dbname=' . $this->db_name . ';charset=utf8', self::$db_user, self::$db_pass);
    }

# Desconectar la base de datos

    private function close_connection() {
        $this->conn= null;
    }

# Ejecutar un query simple del tipo INSERT, DELETE, UPDATE

    protected function execute_single_query() {
        /*
        try {
            
        } catch (Exception $e) {
            die("Oh noes! There's an error in the query!");
        }*/
             $this->open_connection();
             $cmd = $this->conn->prepare($this->query);
             $result=$cmd->execute();
             $this->close_connection();
        
        return $result;
    }

    protected function lastInsertId(){
        return $this->conn->lastInsertId();
    }

# Traer resultados de una consulta en un Array

    protected function get_results_from_query() {
        $this->open_connection();
        $consulta = $this->conn->prepare($this->query);
        $consulta->execute();
        $this->rows = $consulta->fetchObject();
        
        $this->close_connection(); 
        return $this->rows;
    }
    
    protected function get_all_results_from_query() {
        $this->open_connection();
        $consulta = $this->conn->prepare($this->query);
        $consulta->execute();
        $this->rows = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->close_connection(); 
        return $this->rows;
    }
    
    

}
