<?php

namespace Library;

/**
 * Abstract Class for default database conection
 * 
 * @package PauloSette
 * @author Paulo Sette
 * @version 0.1
 *  
 * Diretory \Library
 * File - AbstractModel.php
 */
abstract class AbstractModel {

    /**
     * Default var to get connection
     * @var $conn
     */
    protected $conn;
    private $model;
    private $table;

    function __construct($model, $table) {
        Connection::init();
        $this->conn = Connection::getConnection();
        $this->model = $model;
        $this->table = $table;
    }

    public function prepare($param) {
        return pg_escape_string($param);
    }

    /**
     * Retorna um array contendo os contatos
     * @param string $st_nome
     * @return Array
     */
    public function list($onlyTotal = false, $searchFields, $searchValue = null, $start = false, $limit = false) {
        $query = 'SELECT * FROM ' . $this->table;
        if (!is_null($searchValue)) {
            if (is_array($searchFields)) {
                $query .= ' WHERE';
                $i = 1;
                $totalFields = count($searchFields);
                foreach ($searchFields as $sf) {
                    $query .= ' LOWER(' . $sf . ') LIKE \'%' . strtolower($searchValue) . '%\'';
                    if ($i < $totalFields) {
                        $query .= ' OR';
                        $i++;
                    }
                }
            }
        }
        $queryTotal = 'SELECT COUNT(*) as count FROM ' . $this->table;
        $query .= ' ORDER BY id ASC';
        if ($start !== false && $limit !== false) {
            $query .= ' LIMIT ' . intval($limit) . ' OFFSET ' . intval($start);
        }
        $models = array();
        try {
            $total = 0;
            $dataTotal = $this->conn->prepare($queryTotal);
            $dataTotal->execute();
            $total = $dataTotal->fetchObject()->count;
            if ($onlyTotal) {
                return $total;
            }

            $data = $this->conn->prepare($query);
            $data->execute();
            
            while ($r = $data->fetchObject()) {
                $model = new $this->model;
                $model->setListData($r);
                array_push($models, $model);
            }
            return array("success" => true, "data" => $models, "total" => $total);
        } catch (PDOException $e) {
            throw 'ERROR: ' . $e;
        }
        return false;
    }

    public function save($data, $id = false, $insert_dt = true, $update_dt = true) {
        if (!is_array($data)) {
            return array('success' => false, 'message' => '"$data" Não é um array');
        }

        $data = \Library\System::removeEmptyFromArray($data);
        if (!$id) {
            $columns = implode(", ", array_keys($data));
            $escaped_values = array_map('pg_escape_string', array_values($data));
            $values = "'" . implode("', '", $escaped_values) . "'";
            if ($insert_dt == true) {
                $columns .= ", insert_dt";
                $values .= ", '" . date('Y-m-d H:i:s') . "'";
            }
            $st_query = "INSERT INTO " . $this->table . " ($columns) VALUES ($values)";
        } else {
            $values = \Library\System::key_implode($data, ', ');
            if ($update_dt == true) {
                $values .= ", update_dt='" . date('Y-m-d H:i:s') . "'";
            }
            $st_query = "UPDATE " . $this->table . " SET " . $values . " WHERE id = $id";
        }
        try {
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $sql = $this->conn->prepare($st_query);
            if ($sql->execute()) {
                if (!$id) {
                    $id = $this->conn->lastInsertId();
                }
                return array("success" => true, "id" => $id);
            } else {
                return array("success" => false, "message" => 'Erro ao inserir');
            }
        } catch (PDOException $e) {
            throw $e;
        }
        return array("success" => false);
    }

    /**
     * Deleta os dados persistidos na tabela de
     * contato usando como referencia, o id da classe.
     */
    public function delete($id, $column = 'id') {
        if (!is_null($id)) {
            $st_query = "DELETE FROM " . $this->table . " WHERE $column = $id";
            if ($this->conn->exec($st_query) > 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retorna os dados de um contato referente
     * a um determinado Id
     * @param integer $id
     * @return Object
     */
    public function loadById($id) {
        if (!is_null($id)) {
            $query = "SELECT * FROM " . $this->table . " WHERE id = $id;";
            $data = $this->conn->prepare($query);
            $data->execute();
            $oRet = $data->fetchObject();
            if (!isset($oRet->id)) {
                return false;
            }
            $model = new $this->model;
            $model->setListData($oRet);
            return $model;
        }
        return false;
    }

    /**
     * Retorna os dados de um contato referente
     * a um determinado Id
     * @param integer $id
     * @return Object
     */
    public function fetchAll($id = false, $column = 'id') {
        $query = "SELECT * FROM " . $this->table;
        if($id) {
            $query = "SELECT * FROM " . $this->table . " WHERE $column = $id";
        }
        $data = $this->conn->prepare($query);
        $data->execute();
        $models = array();
        while ($r = $data->fetchObject()) {
            $model = new $this->model;
            $model->setListData($r);
            array_push($models, $model);
        }
        return $models;
    }

    /**
     * 
     * @param type $field
     * @param type $mask
     * @return type
     */
    public function mask($field, $mask = false) {
        if ($field == '' || $field == null) {
            $return = '';
        } else {
            $iField = -1;
            for ($i = 0; $i < strlen($mask); $i++) {
                if ($mask[$i] == '#') {
                    $mask[$i] = $field[++$iField];
                }
            }
//retorna o campo formatado
            $return = $mask;
        }

        return $return;
    }

}
