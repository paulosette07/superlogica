<?php

/**
 * Class Client
 */

namespace Application\Controller;

use \Library\Connection;
use \Library\System;

class DmlController {

    private $conn;

    function __construct() {
        Connection::init();
        $this->conn = Connection::getConnection();
    }
    
    public function createTable($query) {
        try {
            $this->conn->exec($query);
            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function insertValues($table, $keys, $values) {
        $sqlKeys = implode(',',$keys);
        $totalKeys = count($keys);
        $sqlValues = "";
        $i = 0;
        foreach($values as $vObj) {
            $sqlValues .= ($i < count($values) && $i != 0) ? ',' : '';
            $sqlValues .= "(";
            for($j=0; $j < $totalKeys; $j++) {
                $sqlValues .= "'$vObj[$j]'";
                $sqlValues .= ($j+1 == $totalKeys) ? '' : ',';
            }
            $sqlValues .= ")";
            $i++;
        }
        
        $sql = "INSERT INTO ".$table." (".$sqlKeys.") values ".$sqlValues.";";
        try {
            $this->conn->exec($sql);
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function list() {
        $query = "SELECT USUARIO.NOME, INFO.ANO_NASCIMENTO FROM USUARIO INNER JOIN INFO ON (USUARIO.CPF = INFO.CPF)";
        $data = $this->conn->prepare($query);
        $data->execute();
        
        try {
            return $data;
        } catch(PDOException $e) {
            return false;
        }
    }
}
