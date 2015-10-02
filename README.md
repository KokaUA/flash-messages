# Flash messages
Flash messages for phpixie3

### Установка
1) Подключаем библиотеку в проект
```sh
composer require koka/flash:dev-master
```
2) Подключить библиотеку глобально для всех бандлов
```php
// /src/Project/Framework/Builder.php
    protected function buildComponents()
    {
        return new Components($this);
    }
```
```php
// /src/Project/Framework/Components.php
   
namespace Project\Framework;

class Components extends \PHPixie\BundleFramework\Components
{
    public function flash()
    {
        return $this->instance('flash');
    }

    protected function buildFlash()
    {
        $http = $this->http();
        $container = $http->contextContainer($http->context($http->request()));
        return new \Koka\Flash\Messages($container);
    }
}
```

### Использование
```php
	// /bundles/app/src/Project/App/HTTPProcessor.php
	
namespace Project\App;

class HTTPProcessor extends \PHPixie\DefaultBundle\Processor\HTTP\Builder
{
    protected $builder;
    protected $attribute = 'processor';

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    protected function buildGreetProcessor()
    {
        return new HTTPProcessors\Greet($this->builder->components());
    }
}

```
```php
	// /bundles/app/src/Project/App/HTTPProcessors/Greet.php

namespace Project\App\HTTPProcessors;

class Greet extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
{
    protected $template;
    protected $flash;

    public function __construct($components)
    {
        $this->template = $components->template();
        $this->flash    = $components->flash();
    }

    public function defaultAction($request)
    {
        // add test info message
        $this->flash->info('Test info message');

        $container = $this->template->get('app:greet');
        $container->message = "Have fun coding!";
        $container->flash = $this->flash;
        return $container;
    }
}
```

```php
	// /bundles/app/assets/templates/layout.php
	<!DOCTYPE html>
	<html>
	<head>
		<title>PHPixie 3.0</title>
	</head>
	<body>
	       <h1>PHPixie 3.0</h1>
		<?php
		if ($flash->hasMessages()) {
			$messages = $flash->popAll();
			foreach ($messages as $msg) {
				echo "<p>type:{$msg->getType()}<br> message: {$msg}</p>";
			}
		}
		?>
		<?php $this->childContent();?>
	</body>
	</html>
```
