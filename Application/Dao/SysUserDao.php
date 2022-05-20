<?php

namespace Application\Dao;

class SysUserDao extends \Library\AbstractModel {

    private $id;
    private $name;
    private $email;
    private $password;
    private $status;
    private $insert_dt;
    private $update_dt;

    public function __construct() {
        $model = "Application\Dao\SysUserDao";
        $table = "sys_user";
        parent::__construct($model, $table);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return md5($this->password);
    }

    public function getStatus() {
        return $this->status;
    }

    public function getInsert_dt() {
        return $this->insert_dt;
    }

    public function getUpdate_dt() {
        return $this->update_dt;
    }

    public function setId($id) {
        $this->id = parent::prepare($id);
        return $this;
    }

    public function setName($name) {
        $this->name = parent::prepare($name);
        return $this;
    }

    public function setEmail($email) {
        $this->email = parent::prepare($email);
        return $this;
    }

    public function setPassword($password) {
        $this->password = md5($password);
        return $this;
    }

    public function setStatus($status) {
        $this->status = parent::prepare($status);
        return $this;
    }

    public function setInsert_dt($insert_dt) {
        $this->insert_dt = $insert_dt;
        return $this;
    }

    public function setUpdate_dt($update_dt) {
        $this->update_dt = $update_dt;
        return $this;
    }

    public function setListData($data) {
        $this->setId($data->id);
        $this->setName($data->name);
        $this->setEmail($data->email);
        $this->setPassword($data->password);
        $this->setstatus($data->status);
        $this->setInsert_dt($data->insert_dt);
        $this->setUpdate_dt($data->update_dt);
    }

    public function validateUser($email, $password) {
        if (empty($email) || empty($password)) {
            return array("success" => false, "message" => "ERROR: Email ou Senha inválido");
        }
        $query = "SELECT * FROM sys_user WHERE email = '$email'";
        $data = $this->conn->prepare($query);
        $data->execute();
        $user = $data->fetchObject();
        if (!isset($user->id)) {
            return array("success" => false, "message" => "ERROR: Usuário não encontrato");
        } else {
            if ($user->password === md5($password)) {
                return array("success" => true, "user" => $user);
            }
            return array("success" => false, "message" => "ERROR: Email ou Senha Invádio");
        }
    }

}
