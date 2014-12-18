<?php

use Core\Test\ControllerTestCase;
use Application\Controller\IndexController;
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
    protected $controllerFQDN = 'Application\Controller\IndexController';

    /**
     * Nome da rota. Geralmente o nome do módulo
     * @var string
     */
    protected $controllerRoute = 'application';

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
     * Testa a página inicial, que deve mostrar os chamados
     */
    public function testIndexAction()
    {
        // Cria técnicos para testar
        $chamadoA = $this->addChamado();
        $chamadoB = $this->addChamado();

        // Invoca a rota index
        $this->routeMatch->setParam('action', 'index');
        $result = $this->controller->dispatch($this->request, $this->response);

        // Verifica o response
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        // Testa se um ViewModel foi retornado
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);

        // Testa os dados da view
        $variables = $result->getVariables();

        $this->assertArrayHasKey('chamados', $variables);

        // Faz a comparação dos dados
        $controllerData = $variables["chamados"];
        $this->assertEquals($chamadoA->chamado_cobra, $controllerData[0]['chamado_cobra']);
        $this->assertEquals($chamadoB->chamado_cobra, $controllerData[1]['chamado_cobra']);
    }
    
    /**
    * Testa a página inicial, que deve mostrar os chamados com paginador
    */
    /*public function testIndexActionPaginator()
    {
       // Cria chamados para testar
       $chamado = array();
       for($i=0; $i< 25; $i++) {
           $chamado[] = $this->addChamado();
       }

       // Invoca a rota index
       $this->routeMatch->setParam('action', 'index');
       $result = $this->controller->dispatch($this->request, $this->response);

       // Verifica o response
       $response = $this->controller->getResponse();
       $this->assertEquals(200, $response->getStatusCode());

       // Testa se um ViewModel foi retornado
       $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);

       // Testa os dados da view
       $variables = $result->getVariables();

       $this->assertArrayHasKey('chamados', $variables);

       //testa o paginator
       $paginator = $variables["chamados"];
       $this->assertEquals('Zend\Paginator\Paginator', get_class($paginator));
       $chamados = $paginator->getCurrentItems()->toArray();
       $this->assertEquals(10, count($chamados));
       $this->assertEquals($chamado[0]->id, $chamados[0]['id']);
       $this->assertEquals($chamado[1]->id, $chamados[1]['id']);

       //testa a terceira página da paginação
       $this->routeMatch->setParam('action', 'index');
       $this->routeMatch->setParam('page', 3);
       $result = $this->controller->dispatch($this->request, $this->response);
       $variables = $result->getVariables();
       $controllerData = $variables["chamados"]->getCurrentItems()->toArray();
       $this->assertEquals(5, count($controllerData));
    }*/

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

        return $chamado;
    }
}