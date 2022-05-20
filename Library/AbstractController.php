<?php

abstract class AbstractController {

    /**
     * @var Object Wimard_Auth::getInstance();
     */
    protected $_auth;

    /**
     * @var Object Usuario();
     */
    protected $_usuario;

    /**
     * @var String Prefixo
     */
    protected $listUrl;

    /**
     * @var String Entidade
     */
    protected $entity;

    /**
     * @var String Dao
     */
    protected $dao;

    /**
     * @var String Form
     */
    protected $form;

    /**
     * @var Bool del
     */
    protected $del = false;
    protected $insertMsg = 'O Registro foi inserido com sucesso';
    protected $insertError = 'Problemas ao tentar inserir o registro';
    protected $updateMsg = 'O Registro foi alterado com sucesso';
    protected $updateError = 'Problemas ao tentar alterar o registro';
    protected $deleteMsg = 'Registro excluido com sucesso';
    protected $deleteError = 'Problemas ao tentar excluir o registro';

    public function init() {
        
    }

    /**
     * 
     * @param type $st_view
     * @param type $v_params
     */
    public function indexAction($st_view = false, $v_params = null) {
        if (isset($v_params['msg'])) {
            $msg = $v_params['msg'];
            if ($msg == 'insertMsg') {
                $v_params['msg'] = $this->insertMsg;
            }
            if ($msg == 'insertError') {
                $v_params['msg'] = $this->insertError;
                $v_params['error'] = 1;
            }
            if ($msg == 'updateMsg') {
                $v_params['msg'] = $this->updateMsg;
            }
            if ($msg == 'updateError') {
                $v_params['msg'] = $this->updateError;
                $v_params['error'] = 1;
            }
            if ($msg == 'deleteMsg') {
                $v_params['msg'] = $this->deleteMsg;
            }
            if ($msg == 'deleteError') {
                $v_params['msg'] = $this->deleteError;
                $v_params['error'] = 1;
            }
        }
        $o_view = new View($st_view, $v_params);
        $o_view->showContents();
    }

    /**
     * 
     * @param type $st_view
     * @param type $v_params
     */
    public function formAction($st_view = false, $v_params = null) {
        $o_view = new View($st_view, $v_params);
        $o_view->showContents();
    }

    /**
     * 
     * @param type $result
     * @param type $id
     */
    public function saveAction($result = false, $id = null) {
        if (isset($id) && $id != '' && $id != null) {
            if ($result == true) {
                header("Location: " . System::getBaseUrl() . "/" . $this->listUrl . "?msg=updateMsg");
            } else {
                header("Location: " . System::getBaseUrl() . "/" . $this->listUrl . "?msg=updateError");
            }
        } else {
            if ($result == true) {
                header("Location: " . System::getBaseUrl() . "/" . $this->listUrl . "?msg=insertMsg");
            } else {
                header("Location: " . System::getBaseUrl() . "/" . $this->listUrl . "?msg=insertError");
            }
        }
    }

    /**
     * 
     * @param type $id
     */
    public function deleteAction($result = false, $id = null) {
        if (isset($id) && $id != '' && $id != null) {
            if ($result == true) {
                header("Location: " . System::getBaseUrl() . "/" . $this->listUrl . "?msg=deleteMsg");
            } else {
                header("Location: " . System::getBaseUrl() . "/" . $this->listUrl . "?msg=deleteError");
            }
        } else {
            header("Location: " . System::getBaseUrl() . "/" . $this->listUrl . "?msg=deleteError");
        }
    }

    public function showAction($options = null) {
        $params = Zend_Registry::get('get');
        $entity = new $this->entity;
        $data = $entity->fetchRow("id = " . $params->id);
        $this->view->obj = $data;
    }

}
