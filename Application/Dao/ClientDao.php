<?php

namespace Application\Dao;

class ClientDao extends \Library\AbstractModel {

    private $id;
    private $name;
    private $userName;
    private $zipCode;
    private $email;
    private $password;
    private $insert_dt;
    private $update_dt;

    public function __construct() {
        $model = "Application\Dao\ClientDao";
        $table = "client";
        parent::__construct($model, $table);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getZipCode($show = false) {
        $zipCode = $this->zipCode;
        if ($show) {
            $zipCode = $this->mask($zipCode, "#####-###");
        }
        return $zipCode;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
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

    public function setUserName($userName) {
        $this->userName = parent::prepare($userName);
        return $this;
    }

    public function setZipCode($zipCode) {
        $this->zipCode = parent::prepare($zipCode);
        return $this;
    }

    public function setEmail($email) {
        $this->email = parent::prepare($email);
        return $this;
    }

    public function setPassword($password) {
        $this->password = parent::prepare($password);
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
        $this->setUserName($data->username);
        $this->setZipCode($data->zipcode);
        $this->setEmail($data->email);
        $this->setPassword($data->password);
        $this->setInsert_dt($data->insert_dt);
        $this->setUpdate_dt($data->update_dt);
    }

}
