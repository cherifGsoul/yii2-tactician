Yii2 Tactician
==============
Tactician command bus library wrapper for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist cherif/yii2-tactician "*"
```

or add

```
"cherif/yii2-tactician": "*"
```

to the require section of your `composer.json` file.


Usage
-----
In the configuration file the component must be in the application bootstrap configuration:

```php
...
'bootstrap'=>[...,'commandBus'],
...
'components'=>[
...
				'commandBus'=> [
					'class'=>'cherif\tactician\Tactician',
					'inflector' => 'League\Tactician\Handler\MethodNameInflector\HandleClassNameInflector',
					'extractor' => 'League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor',
					'commandHandlerMap'=> [
						'cherif\tactician\tests\fixtures\commands\CompleteTaskCommand' => 'cherif\tactician\tests\fixtures\handlers\CompleteTaskCommandHandler',
					],
					'middlewares'=> [],
				]
			]
```

Somewhere in your app (maybe controller):

```php
	Yii:$app->commandBus->handle(new CompleteTaskCommand)
```

For more information about configuration please visit [Tactician library homepage](http://tactician.thephpleague.com/).