<?php

namespace cherif\tactician;

use Yii;
use yii\base\Object;

use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;

class ContainerLocator extends Object implements HandlerLocator
{
	public $commandNameToHandlerMap = [];

	protected $container;
	
	public function __construct(array $commandNameToHandlerMap = [])
	{
		$this->container = Yii::$container;
		
		$this->addHandlers($commandNameToHandlerMap);
	}

	public function addHandler($handler,$commandName)
	{
		$this->commandNameToHandlerMap[$commandName] = $handler;
	}

	public function addHandlers(array $commandNameToHandlerMap)
	{
		foreach ($commandNameToHandlerMap as $commandName => $handler) {
			$this->addHandler($handler,$commandName);	
		}
	}

	public function getHandlerForCommand($commandName)
	{
		if (!isset($this->commandNameToHandlerMap[$commandName])) {
            throw MissingHandlerException::forCommand($commandName);
        }

		$serviceId = $this->commandNameToHandlerMap[$commandName];
		return $this->container->get($serviceId);
	}
}