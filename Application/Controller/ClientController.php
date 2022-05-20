<?php

/**
 * Class Client
 */

namespace Application\Controller;

use \Application\Dao\ClientDao;
use \Library\System;
use \Library\Paginator;

class ClientController {

    public function list($search) {
        $searchFields = ['name', 'userName', 'email', 'zipCode'];
        $clientDao = new ClientDao();
        $clientsTotal = $clientDao->list(true, $searchFields, $search);

        $pages = new Paginator();
        $pages->default_ipp = 10;
        $pages->items_total = $clientsTotal;
        $pages->mid_range = 9;
        $pages->paginate();

        $clients = $clientDao->list(false, $searchFields, $search, $pages->start, $pages->limit);
        $clients['pages'] = $pages;

        return $clients;
    }

    public function save($data, $id) {
        $clientDao = new ClientDao();
        $client = $clientDao->save($data, $id);
        if (!$client['success']) {
            System::redirect('error', 'ERROR - ' . $data['message'], 'client-list');
        }
        System::redirect('msg', 'Registro Salvo com Sucesso', 'client-list');
    }

    public function delete($key) {
        if (!$key) {
            System::redirect('error', 'ERROR - Está faltando o Código do Registro.', 'client-list');
        }
        $clientDao = new ClientDao();
        if ($clientDao->delete($key)) {
            System::redirect('danger', 'O Registro foi removido com Sucesso.', 'client-list');
        }
    }

}
