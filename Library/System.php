<?php

namespace Library;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of System
 *
 * @author Paulo Sette
 */
class System {

    public static function getConfigIni() {
        $ini = parse_ini_file('Application/Config/config.ini', true);
        return $ini;
    }

    public static function getSystemMode() {
        $ini = System::getConfigIni();
        return $ini['base']['mode'];
    }

    public static function _var($param) {
        return pg_escape_string($param);
    }

    public static function checkAction($action, $callback = 'index', $actions = array('save', 'delete')) {
        if ($action == 'actionError') {
            header("Location: $callback.php?actionError=1");
        }

        if (is_array($actions)) {
            if (!in_array($action, $actions)) {
                header("Location: $callback.php?actionError=1");
            }
        }
    }

    public static function redirect($type = false, $message = false, $callback = 'index', $key = false) {
        if (!$type) {
            header("Location: $callback.php");
        } else {
            $key = ($key) ? '&key='.$key : '';
            header("Location: ".$callback.".php?tpmsg=".$type."&msg=".$message.$key);
        }
    }

    public static function msg($message, $type = 'msg') {
        if (is_null($message)) {
            echo '<div class="boxError" id="popBox">ERROR!</div>';
        }
        echo '<div class="box_' . $type . '" id="popBox">' . $message . '</div>';
    }

    public static function removeEmptyFromArray($array) {
        if (!is_array($array)) {
            return false;
        }

        foreach ($array as $key => $link) {
            if ($link === '') {
                unset($array[$key]);
            }
        }
        return $array;
    }

    public static function key_implode(&$array, $glue) {
        $result = "";
        foreach ($array as $key => $value) {
            $result .= $key . "='" . $value . "'" . $glue;
        }
        return substr($result, 0, -1 * strlen($glue));
    }

    public static function validatePassword($password) {
        $re = '/(?!\s)(?=.*?[a-z]{1,})(?=.*?[A-Z]{1,})(?=.*?\d{1,}).*(?=.?[^a-zA-Z0-9]{1,})?.([^\s]){8,}/m';
        return preg_match($re, $password) ? true : false;
    }
    
    public static function removeMask($param) {
        $param = str_replace("-", "", $param);
        $param = str_replace("(", "", $param);
        $param = str_replace(")", "", $param);
        $param = str_replace("/", "", $param);
        $param = str_replace("\\", "", $param);
        $param = str_replace(" ", "", $param);
        $param = str_replace(".", "", $param);
        $param = str_replace(",", ".", $param);
        $param = str_replace("%", "", $param);
        return trim($param);
    }
}
