<?php

require_once 'autoload.php';

$action = (isset($_GET['action'])) ? $_GET['action'] : 'actionError';

Library\System::checkAction($action, 'client-list');

if ($action == 'save') {
    $post = $_POST;
    $id = false;
    if(isset($post['id'])) {
        if($post['id'] != '') {
            $id = $post['id'];
        }
    }
    $data['name'] = $post['name'];
    $data['userName'] = $post['userName'];
    $data['zipCode'] = \Library\System::removeMask($post['zipCode']);
    $data['email'] = $post['email'];
    $data['password'] = $post['password'];
    
    if(\Library\System::validatePassword($post['password'])) {
        $clientController = new Application\Controller\ClientController();
        $clientController->save($data, $id);
    } else {
        \Library\System::redirect('error', 'ERROR - Senha inválida', 'client-form', $id);
    }
}

if ($action == 'delete') {
    $key = (isset($_GET['key'])) ? Library\System::_var($_GET['key']) : false;
    $clientController = new Application\Controller\ClientController();
    $clientController->delete($key);
}