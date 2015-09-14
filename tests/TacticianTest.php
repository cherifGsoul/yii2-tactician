<?php
namespace cherif\tactician\tests;

use Yii;
use cherif\tactician\tests\fixtures\commands\CompleteTaskCommand;
use cherif\tactician\tests\fixtures\commands\DeleteTaskCommand;

use League\Tactician\Middleware;

class TacticianTests extends TestCase
{
	private $_commandBus;

	protected function setUp()
	{
		parent::setUp();
		$this->_commandBus = Yii::$app->commandBus;
	}

	/**
	 * @test
	 */
	public function should_handle_command()
	{	
		$this->assertEquals(
            'foobar',
            $this->_commandBus->handle(new CompleteTaskCommand())
        );
	}

	/**
	 * @test
	 */
	public function should_register_middleware_to_be_executed()
	{
		$middleware = $this->getMock('League\Tactician\Middleware');
					
		$this->_commandBus->registerMiddleware($middleware);
		
		$this->assertEquals(2,count($this->_commandBus->middlewares));
	
		$this->assertEquals(
            'foobar',
            $this->_commandBus->handle(new CompleteTaskCommand())
        );
	}


	/**
	 * @test 
	 * @expectedException League\Tactician\Exception\MissingHandlerException
	 */

	public function should_throw_exception_on_missing_handler()
	{
		$this->_commandBus->handle(new DeleteTaskCommand());
	}

}