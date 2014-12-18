<?php

use Core\Test\ControllerTestCase;
use Admin\Controller\IndexController;
use Application\Model\Chamado;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\View\Renderer\PhpRenderer;


/**
 * @group Controller
 */
class IndexControllerTest extends ControllerTestCase
{
    /**
     * Namespace completa do Controller
     * @var string
     */
    protected $controllerFQDN = 'Admin\Controller\IndexController';

    /**
     * Nome da rota. Geralmente o nome do módulo
     * @var string
     */
    protected $controllerRoute = 'admin';

    /**
     * Testa o acesso a uma action que não existe
     */
    public function test404()
    {
        $this->routeMatch->setParam('action', 'action_nao_existente');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Testa a tela de inclusão de um novo registro
     * @return void
     */
    public function testSaveActionNewRequest()
    {
        // Dispara a ação
        $this->routeMatch->setParam('action', 'save');
        $result = $this->controller->dispatch($this->request, $this->response);
        // Verifica a resposta
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        
        // Testa se recebeu um ViewModel
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);

        //verifica se existe um form
        $variables = $result->getVariables();
        $this->assertInstanceOf('Zend\Form\Form', $variables['form']);
        $form = $variables['form'];
        //testa os itens do formulário
        $id = $form->get('id');
        $this->assertEquals('id', $id->getName());
        $this->assertEquals('hidden', $id->getAttribute('type'));
    }

    /**
     * Testa a alteração de um chamado
     */
    public function testSaveActionUpdateFormRequest()
    {
        $chamadoA = $this->addChamado();

        // Dispara a ação
        $this->routeMatch->setParam('action', 'save');
        $this->routeMatch->setParam('id', $chamadoA->id);
        $this->routeMatch->setParam('numero', $chamadoA->numero);
        $result = $this->controller->dispatch($this->request, $this->response);

        // Verifica a resposta
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        // Testa se recebeu um ViewModel
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);

        $variables = $result->getVariables();

        //verifica se existe um form
        $variables = $result->getVariables();
        $this->assertInstanceOf('Zend\Form\Form', $variables['form']);
        $form = $variables['form'];

        //testa os itens do formulário
        $id = $form->get('id');
        $numero = $form->get('numero');
        $this->assertEquals('id', $id->getName());
        $this->assertEquals($chamadoA->id, $id->getValue());
        $this->assertEquals($chamadoA->numero, $numero->getValue());
    }

    /**
     * Testa a inclusão de um novo chamado
     */
    public function testSaveActionChamadoRequest()
    {
        // Dispara a ação
        $this->routeMatch->setParam('action', 'save');
        
        $this->request->setMethod('post');
        $this->request->getPost()->set('numero', '20145715000007');
        $this->request->getPost()->set('chamado_cobra', 'CHM000005745316');
        $this->request->getPost()->set('dependencia', 'QSQ-CANDANGOLANDIA');
        $this->request->getPost()->set('dtachamado', date('Y-m-d H:i:s'));
        $this->request->getPost()->set('dtalimite', date('Y-m-d H:i:s'));
        $this->request->getPost()->set('status', 'ALOCADO');
        $this->request->getPost()->set('tecnico_alocado', 'ANTONIO');
        $this->request->getPost()->set('agencia', '1234');
        $this->request->getPost()->set('nrocontrato', '2011/96000264');
        $this->request->getPost()->set('grupo', 'TAA');
        $this->request->getPost()->set('observacao', 'Teste de Observação');
        
        $result = $this->controller->dispatch($this->request, $this->response);
        // Verifica a resposta
        $response = $this->controller->getResponse();
        //a página redireciona, então o status = 302
        $this->assertEquals(302, $response->getStatusCode());

        //verifica se salvou
        $chamados = $this->getTable('Application\Model\Chamado')->fetchAll()->toArray();
        $this->assertEquals(1, count($chamados));
        $this->assertEquals('20145715000007', $chamados[0]['numero']);
        $this->assertNotNull($chamados[0]['dependencia']);
    }

    /**
     * Tenta salvar com dados inválidos
     *
     */
    public function testSaveActionInvalidChamadoRequest()
    {
        // Dispara a ação
        $this->routeMatch->setParam('action', 'save');
        
        $this->request->setMethod('post');
        $this->request->getPost()->set('numero', '');
        
        $result = $this->controller->dispatch($this->request, $this->response);

        //verifica se existe um form
        $variables = $result->getVariables();
        $this->assertInstanceOf('Zend\Form\Form', $variables['form']);
        $form = $variables['form'];

        //testa os errors do formulário
        $numero = $form->get('numero');
        $numeroErrors = $numero->getMessages();
        $this->assertEquals("Value is required and can't be empty", $numeroErrors['isEmpty']);

        $status = $form->get('status');
        $statusErrors = $status->getMessages();
        $this->assertEquals("Value is required and can't be empty", $statusErrors['isEmpty']);
        
    }

    /**
     * Testa a exclusão sem passar o id do chamado
     * @expectedException Exception
     * @expectedExceptionMessage Código obrigatório
     */
    public function testInvalidDeleteAction()
    {
        $chamado = $this->addChamado();
        // Dispara a ação
        $this->routeMatch->setParam('action', 'delete');

        $result = $this->controller->dispatch($this->request, $this->response);
        // Verifica a resposta
        $response = $this->controller->getResponse();

    }

    /**
     * Testa a exclusão do chamado
     */
    public function testDeleteAction()
    {
        $chamado = $this->addChamado();
        // Dispara a ação
        $this->routeMatch->setParam('action', 'delete');
        $this->routeMatch->setParam('id', $chamado->id);

        $result = $this->controller->dispatch($this->request, $this->response);
        // Verifica a resposta
        $response = $this->controller->getResponse();
        //a página redireciona, então o status = 302
        $this->assertEquals(302, $response->getStatusCode());

        //verifica se excluiu
        $chamados = $this->getTable('Application\Model\Chamado')->fetchAll()->toArray();
        $this->assertEquals(0, count($chamados));
    }

    /**
     * Adiciona um chamado para os testes
     */
    private function addChamado()
    {
        $chamado = new Chamado();
        $chamado->numero = '12345678901234';
        $chamado->chamado_cobra = '123456789012345';
        $chamado->dependencia = 'Matriz I <script>alert("ok");</script><br>';
        $chamado->dtachamado = date('Y-m-d H:i:s');
        $chamado->dtalimite = date('Y-m-d H:i:s');
        $chamado->status = '12345678901234567890';
        $chamado->tecnico_alocado = 'Antonio';
        $chamado->agencia = '1234';
        $chamado->nrocontrato = '1234567890123';
        $chamado->grupo = 'TAA';
        $chamado->observacao = 'Teste OBS';

        $saved = $this->getTable('Application\Model\Chamado')->save($chamado);

        return $saved;
    }
}