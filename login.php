<?php

require_once 'autoload.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $security = Library\Security::getInstance();
    $security->login($email, $password);
    if ($security->hasIdentity()) {
        header("Location: client-list.php");
    } else {
        header("Location: index.php?loginError=2");
    }
} else {
    header("Location: index.php?loginError=2");
}