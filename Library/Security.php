<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Library;

/**
 * Description of Security
 *
 * @author paulo
 */
class Security {

    protected static $_instance;

    /**
     * @var Object
     */
    public $auth = null;

    /**
     * @var Object
     */
    public $valid = false;

    /**
     * @var Object
     */
    public $user;

    private function __construct() {
        // Caso exista uma identidade
        if ($this->hasIdentity()) {
            $this->valid = true;
            // Pega a identidade do usuario
            $this->user = $_SESSION['user'];
        } else {
            $this->valid = false;
        }
    }

    /**
     * Metodo getInstance();
     * Pega a instancia da classe
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function hasIdentity() {
        if (!isset($_SESSION['logged'])) {
            return false;
        }
        return true;
    }

    public function validateLogin() {
        if($this->valid == false) {
            header("Location: index.php?loginError=1");
        }
    }

    public function login($email, $password) {
        $email = \Library\System::_var($email);
        $password = \Library\System::_var($password);

        $sysUserDao = new \Application\Dao\SysUserDao();
        $validate = $sysUserDao->validateUser($email, $password);
        if ($validate['success'] == false) {
            return $validate;
        }
        $user = $validate['user'];
        $user->password = null;
        var_dump($user);

        $_SESSION['logged'] = true;
        $_SESSION['user'] = $user;
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }

    /**
     * Matodo getUser();
     * Pega o Username do usuario atual
     */
    public function getUser() {
        return $this->user;
    }

}
