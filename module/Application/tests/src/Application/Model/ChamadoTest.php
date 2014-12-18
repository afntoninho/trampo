<?php
namespace Application\Model;

use Core\Test\ModelTestCase;
use Application\Model\Chamado;
use Zend\InputFilter\InputFilterInterface;

/**
 * @group Model
 */
class ChamadoTest extends ModelTestCase
{
    public function testGetInputFilter()
    {
        $chamado = new Chamado();
        $if = $chamado->getInputFilter();
 
        $this->assertInstanceOf("Zend\InputFilter\InputFilter", $if);
        return $if;
    }
 
    /**
     * @depends testGetInputFilter
     */
    public function testInputFilterValid($if)
    {
        $this->assertEquals(12, $if->count());
 
        $this->assertTrue($if->has('id'));
        $this->assertTrue($if->has('numero'));
        $this->assertTrue($if->has('chamado_cobra'));
        $this->assertTrue($if->has('dependencia'));
        $this->assertTrue($if->has('dtachamado'));
        $this->assertTrue($if->has('dtalimite'));
        $this->assertTrue($if->has('status'));
        $this->assertTrue($if->has('tecnico_alocado'));
        $this->assertTrue($if->has('agencia'));
        $this->assertTrue($if->has('nrocontrato'));
        $this->assertTrue($if->has('grupo'));
        $this->assertTrue($if->has('observacao'));
    }
    
    /**
     * @expectedException Core\Model\EntityException
     * @expectedExceptionMessage Input inválido: numero = 
     */
    public function testInputFilterInvalido()
    {
        $chamado = new Chamado();
        //número deve ser inválido
        $chamado->numero = '123456789012345';
    }

    /**
     * Teste de inserção de um chamado válido
     */
    public function testInsert()
    {
        $chamado = $this->addChamado();

        $saved = $this->getTable('Application\Model\Chamado')->save($chamado);

        $this->assertEquals('Matriz I alert("ok");', $saved->dependencia);
        $this->assertEquals(1, $saved->id);
    }

    /**
     * @expectedException Core\Model\EntityException
     * @expectedException Zend\Db\Adapter\Exception\InvalidQueryException
     */
    public function testInsertInvalido()
    {
        $chamado = new Chamado();
        $chamado->status = '12345678901234567890';
        $chamado->agencia = '12345';

        $saved = $this->getTable('Application\Model\Chamado')->save($chamado);
    }    

    public function testUpdate()
    {
        $tableGateway = $this->getTable('Application\Model\Chamado');
        $chamado = $this->addChamado();

        $saved = $tableGateway->save($chamado);
        $id = $saved->id;

        $this->assertEquals(1, $id);

        $chamado = $tableGateway->get($id);
        $this->assertEquals('12345678901234', $chamado->numero);

        $chamado->numero = '43210987654321';
        $updated = $tableGateway->save($chamado);

        $chamado = $tableGateway->get($id);
        $this->assertEquals('43210987654321', $chamado->numero);

    }

    /**
     * @expectedException Core\Model\EntityException
     * @expectedException Zend\Db\Adapter\Exception\InvalidQueryException
     */
    public function testUpdateInvalido()
    {
        $tableGateway = $this->getTable('Application\Model\Chamado');
        $chamado = $this->addChamado();

        $saved = $tableGateway->save($chamado);
        $id = $saved->id;

        $chamado = $tableGateway->get($id);
        $chamado->agencia = '12345';
        $updated = $tableGateway->save($chamado);
    }

    /**
     * @expectedException Core\Model\EntityException
     * @expectedExceptionMessage Could not find row 1
     */
    public function testDelete()
    {
        $tableGateway = $this->getTable('Application\Model\Chamado');
        $chamado = $this->addChamado();

        $saved = $tableGateway->save($chamado);
        $id = $saved->id;

        $deleted = $tableGateway->delete($id);
        $this->assertEquals(1, $deleted); //numero de linhas excluidas

        $chamado = $tableGateway->get($id);
    }

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

        return $chamado;
    }
}