<?php
namespace cherif\tactician\tests;

use Yii;
use yii\di\Container;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
	protected $containerLocator ;
	/**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        $this->destroyApplication();
        parent::tearDown();
    }
	protected function mockApplication($config = null)
	{
		Yii::$container = new Container;
		if( $config === null )
		{
			$config = [
				'id'=>'unit',
				'name'=>'Tactician Yii2 container unit tests',
				'basePath'=>__DIR__,
				'components'=>[
					'commandBus'=> [
						'class'=>'cherif\tactician\Tactician',
						'inflector' => 'League\Tactician\Handler\MethodNameInflector\HandleClassNameInflector',
						'extractor' => 'League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor',
						'commandHandlerMap'=> [
							'cherif\tactician\tests\fixtures\commands\CompleteTaskCommand' => 'cherif\tactician\tests\fixtures\handlers\CompleteTaskCommandHandler'
						]
					]
				]
			];
		}

		$config['class'] = 'yii\console\Application';

		Yii::createObject($config);
	}

	protected function destroyApplication()
	{
		Yii::$app= null;
		Yii::$container = new Container();
	}
}