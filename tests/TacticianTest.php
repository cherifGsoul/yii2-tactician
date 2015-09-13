<?php
namespace cherif\tactician\tests;

use Yii;
use cherif\tactician\tests\fixtures\commands\CompleteTaskCommand;
use cherif\tactician\tests\fixtures\commands\DeleteTaskCommand;

class TacticianTests extends TestCase
{
	/**
	 * @test
	 */
	public function should_return_tactician_component()
	{
		$this->assertInstanceOf('cherif\tactician\Tactician',Yii::$app->tactician);
	}

	/**
	 * @test
	 */
	public function should_return_instance_of_container_locator()
	{
		$containerLocator = Yii::$container->get('League\Tactician\Handler\Locator\HandlerLocator');
		$extractor = Yii::$container->get('League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor');
		$inflector = Yii::$container->get('League\Tactician\Handler\MethodNameInflector\MethodNameInflector');

		
		$this->assertInstanceOf('cherif\tactician\containerLocator',$containerLocator);
		$this->assertInstanceOf('League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor',$extractor);
		$this->assertInstanceOf('League\Tactician\Handler\MethodNameInflector\MethodNameInflector',$inflector);
	}

	/**
	 * @test
	 */

	public function should_return_insrance_of_command_bus()
	{
		$commandBus = Yii::$container->get('commandBus');
		$this->assertInstanceOf('League\Tactician\CommandBus',$commandBus);
	}

	/**
	 * @test
	 */

	public function should_handle_command()
	{
		$commandBusComponent = Yii::$app->tactician;
		$commandBusContainer = Yii::$container->get('commandBus');
		$this->assertEquals(
            'foobar',
            $commandBusComponent->handle(new CompleteTaskCommand())
        );

        $this->assertEquals('foobar',
        	$commandBusContainer->handle(new CompleteTaskCommand())
        	);
	}


	/**
	 * @test
	 * @expectedException League\Tactician\Exception\MissingHandlerException
	 */

	public function should_throw_exception_on_missing_handler()
	{
		$commandBus = Yii::$container->get('commandBus');
		$commandBus->handle(new DeleteTaskCommand());
	}

}