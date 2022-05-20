<?php

namespace Library;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Connection
 *
 * @author Paulo Sette
 */
class Connection {

    private static $pdo;
    private static $dsn;
    private static $user;
    private static $pass;
    private static $initialized = false;

    public static function init($host = false, $dbname = false, $dsn = false) {
        if (self::$initialized)
            return;

        $ini = System::getConfigIni();
        if ($host == false)
            $host = $ini['database']['host'];
        if ($dbname == false)
            $dbname = $ini['database']['dbname'];
        if ($dsn == false)
            $dsn = $ini['database']['dsn'];

        if($dsn == 'sqlite') {
            self::$dsn = $dsn . ':' .__DIR__.$dbname;
        } else {
            self::$dsn = $dsn . ':host=' . $host . ';dbname=' . $dbname;
            self::$user = $ini['database']['user'];
            self::$pass = $ini['database']['pass'];
        }

        try {
            self::$pdo = new \PDO(self::$dsn, self::$user, self::$pass);
        } catch (\PDOException $exc) {
            echo "Erro: " . $exc->getMessage();
        }
        self::$initialized = true;
    }

    public static function getConnection() {
        return self::$pdo;
    }
    
    public static function closeConnection() {
        self::$pdo = null;
    }
}
