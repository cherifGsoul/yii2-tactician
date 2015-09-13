<?php
namespace cherif\tactician;

use Yii;
use yii\base\Component;
use yii\base\BootstrapInterface;

use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\CommandBus;

class Tactician extends Component implements BootstrapInterface
{
	public $inflector;
	public $extractor;
	public $commandHandlerMap = [];
	public $middlewares = [];

	public function bootstrap($app)
	{
		$this->buildTactician();
	}

	public function init()
	{
	}

	protected function buildTactician()
	{
		$this->createExtractor($this->extractor);
		$this->createContainerLocator($this->commandHandlerMap);
		$this->createInflector($this->inflector);
		$this->createHandlerMiddleware();
		$this->createCommandBus();
	}

	protected function createInflector($inflectorClass)
	{
		return Yii::$container->set('League\Tactician\Handler\MethodNameInflector\MethodNameInflector',[
			'class'=>$inflectorClass
			]);
	}

	protected function createExtractor($extractorClass)
	{
		return Yii::$container->set('League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor',[
			'class'=>$extractorClass
			]);
	}

	protected function createContainerLocator($mapping = [])
	{
		return Yii::$container->set('League\Tactician\Handler\Locator\HandlerLocator',[
			'class'=>'cherif\tactician\ContainerLocator',
			],[$mapping]);
	}

	/**
	 * 
	 */

	protected function createHandlerMiddleware()
	{
		return Yii::$container->set('commandHandlerMiddleware',
			[
				'class'=>'League\Tactician\Handler\CommandHandlerMiddleware'
			],
			[
				Yii::$container->get('League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor'),
				Yii::$container->get('League\Tactician\Handler\Locator\HandlerLocator'), 
				Yii::$container->get('League\Tactician\Handler\MethodNameInflector\MethodNameInflector')
			]
			);
	}


	/**
	 * 
	 */
	protected function createCommandBus()
	{
		$handlerMiddleware = Yii::$container->get('commandHandlerMiddleware');
		Yii::$container->set('commandBus',[
			'class'=>'League\Tactician\CommandBus'
			],
			[[$handlerMiddleware]]
			);
	}



	public function __call($name,$args)
	{
		try {
			$commandBus = Yii::$container->get('commandBus');
			return call_user_func_array([$commandBus,$name], $args);
		} catch (Exception $e) {
			parent::__call($name,$args);
		}
	}
}