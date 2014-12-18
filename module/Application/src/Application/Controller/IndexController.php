<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdapter;
use Zend\Db\Sql\Select;

/**
 * Controlador que gerencia os chamados
 * 
 * @category Application
 * @package Controller
 * @author  Antonio Fernandes Neto <foxmsj@gmail.com>
 */
class IndexController extends ActionController {

    /**
     * Mostra os chamados cadastrados
     * @return void
     */
    public function indexAction() {
        $tecnico = $this->getTable('Application\Model\Chamado');
        //$sql = $tecnico->getSql();
        //$select = $sql->select();
        //$paginatorAdapter = new PaginatorDbSelectAdapter($select, $sql);
        //$paginator = new Paginator($paginatorAdapter);
        //$paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        return new ViewModel(array(
            'chamados' => $tecnico->fetchAll()->toArray()
        ));
    }
    
    public function recebidoAction() {
        $tecnico = $this->getTable('Application\Model\Chamado');

        return new ViewModel(array(
            'chamados' => $tecnico->fetchAll(null, array('status' => 'RECEBIDO'))->toArray()
        ));
    }
    
    public function alocadoAction() {
        $tecnico = $this->getTable('Application\Model\Chamado');

        return new ViewModel(array(
            'chamados' => $tecnico->fetchAll(null, array('status' => 'ALOCADO'))->toArray()
        ));
    }
    
    public function suspensoAction() {
        $tecnico = $this->getTable('Application\Model\Chamado');

        return new ViewModel(array(
            'chamados' => $tecnico->fetchAll(null, array('status' => 'SUSPENSO'))->toArray()
        ));
    }
    
    public function fechadoAction() {
        $tecnico = $this->getTable('Application\Model\Chamado');

        return new ViewModel(array(
            'chamados' => $tecnico->fetchAll(null, array('status' => 'FECHADO'))->toArray()
        ));
    }

}
