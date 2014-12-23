<?php
namespace Application\Form;

use Zend\Form\Form;

class Chamado extends Form
{
    public function __construct()
    {
        parent::__construct('chamado');
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/admin/index/save');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(
            'name' => 'numeroos',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Número OS',
            ),
        ));
        $this->add(array(
            'name' => 'chamadocobra',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Chamado Cobra',
            ),
        ));
        $this->add(array(
            'name' => 'dependencia',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Dependência',
            ),
        ));
        $this->add(array(
            'name' => 'dtachamado',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Data Chamado',
            ),
        ));
        $this->add(array(
            'name' => 'dtalimite',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Data Limite',
            ),
        ));
        $this->add(array(
            'name' => 'status',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Status',
            ),
        ));
        $this->add(array(
            'name' => 'tecnicoalocado',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Técnico Alocado',
            ),
        ));
        $this->add(array(
            'name' => 'agencia',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Agência',
            ),
        ));
        $this->add(array(
            'name' => 'nrocontrato',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Nº Contrato',
            ),
        ));
        $this->add(array(
            'name' => 'grupo',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Grupo',
            ),
        ));
        $this->add(array(
            'name' => 'controlador',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Controlador',
            ),
        ));
        $this->add(array(
            'name' => 'observacao',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Observação',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Enviar',
                'id' => 'submitbutton',
            ),
        ));
    }
}