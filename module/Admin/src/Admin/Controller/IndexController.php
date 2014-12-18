<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Chamado;
use Application\Form\Chamado as ChamadoForm;

/**
 * Controlador que gerencia os chamados
 * 
 * @category Admin
 * @package Controller
 * @author  Elton Minetto <eminetto@coderockr.com>
 */
class IndexController extends ActionController
{
    /**
     * Cria ou edita um chamado
     * @return void
     */
    public function saveAction()
    {
        $form = new ChamadoForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $chamado = new Chamado;
            $form->setInputFilter($chamado->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                $chamado->setData($data);
                
                $saved = $this->getTable('Application\Model\Chamado')->save($chamado);
                return $this->redirect()->toUrl('/');
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {    
            $chamado = $this->getTable('Application\Model\Chamado')->get($id);
            $form->bind($chamado);
            $form->get('submit')->setAttribute('value', 'Edit');
        }
        return new ViewModel(
            array('form' => $form)
        );
    }
     
    /**
     * Exclui um chamado
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id == 0) {
            throw new \Exception("Código obrigatório");
        }
        
        $this->getTable('Application\Model\Chamado')->delete($id);
        return $this->redirect()->toUrl('/');
    }

}