<?php
namespace cherif\tactician;

use Yii;
use yii\base\Component;

use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\CommandBus;

class Tactician extends Component
{
	public $inflector;
	public $extractor;
	public $commandHandlerMap = [];

	protected $tactician;
	protected $middlewares = [];

	public function init()
	{
		$this->buildTactician();
	}

	protected function buildTactician()
	{
		$extractor = Yii::createObject($this->extractor);
		
		$containerLocator = Yii::createObject('cherif\tactician\ContainerLocator',[
				$this->commandHandlerMap
			]
		);

		$inflector = Yii::createObject($this->inflector);

		$handlerMiddleware = Yii::createObject('League\Tactician\Handler\CommandHandlerMiddleware',[
				$extractor,
				$containerLocator, 
				$inflector
			]
		);

		$this->registerMiddleware($handlerMiddleware);

	}


	public function registerMiddleware($middleware)
	{
		array_push($this->middlewares,$middleware);
	}


	public function handle( $command )
	{
		Yii::trace(sprintf('Handle command class for %s',  get_class( $command ) ) );
		
		$tactician =  Yii::createObject('League\Tactician\CommandBus',[
				$this->middlewares
			]
		);
		return $tactician->handle( $command );
	}
	
	public function getMiddlewares()
	{
		return $this->middlewares;
	}

	public function getTactician()
	{
		return $this->tactician;
	}
}