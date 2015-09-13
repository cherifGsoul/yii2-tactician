<?php
namespace cherif\tactician\tests;

use Yii;

use cherif\tactician\ContainerLocator;
use cherif\tactician\tests\fixtures\commands\CompleteTaskCommand;
use cherif\tactician\tests\fixtures\commands\DeleteTaskCommand;
use cherif\tactician\tests\fixtures\container\Mailer;
use cherif\tactician\tests\fixtures\handlers\CompleteTaskCommandHandler;

class ContainerLocatorTest extends TestCase
{

	/**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
     
        $mapping = array(
        'cherif\tactician\tests\fixtures\commands\CompleteTaskCommand' => 'cherif\tactician\tests\fixtures\handlers\CompleteTaskCommandHandler',
        	);
        $this->containerLocator = new ContainerLocator(
        	$mapping
        );
    }
	
	public function testHandlerIsReturnedForSpecificClass()
	{
		$this->assertInstanceOf(
            CompleteTaskCommandHandler::class,
            $this->containerLocator->getHandlerForCommand(CompleteTaskCommand::class)
        );
	}

    public function testHandlerIsReturnedForAddedClass()
    {
        $this->containerLocator->addHandler('stdClass', CompleteTaskCommand::class);
        $this->assertInstanceOf(
            'stdClass',
            $this->containerLocator->getHandlerForCommand(CompleteTaskCommand::class)
        );
    }

    public function testHandlerIsReturnedForAddedClasses()
    {
        $this->containerLocator->addHandlers([CompleteTaskCommand::class => 'stdClass']);
        $this->assertInstanceOf(
            'stdClass',
            $this->containerLocator->getHandlerForCommand(CompleteTaskCommand::class)
        );
    }

    /**
     * @expectedException League\Tactician\Exception\MissingHandlerException
     */
    public function testMissingCommandException()
    {
        $this->containerLocator->getHandlerForCommand(DeleteTaskCommand::class);
    }
}