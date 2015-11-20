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
        $types = $this->builder->assets()->configStorage()->get('flash');
        if (!$types) {
            $types = [];
		}
        return new \Koka\Flash\Flash($this->builder->context(), $types);
    }
}
```
### Для кастомизации типов создайте файл
Значения массива можно изменять под свои нужды, главное сохранять ключи.
Если файл не создавать то по умолчанию тип равен ключу.
```php
// /assets/config/flash.php

<?php
return [
    'error' => 'alert alert-error',
    'danger' => 'alert alert-danger',
    'warning' => 'alert alert-warning',
    'notice' => 'alert alert-notice',
    'alert' => 'alert alert-alert',
    'info' => 'alert alert-info',
    'success' => 'alert alert-success'

];
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
        return new HTTPProcessors\Greet($this->builder);
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

    public function __construct($builder)
    {
        $this->template = $builder->components->template();
        $this->flash    = $builder->components->flash();
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
		   <div class="row">
        <?php foreach ($flash as $msg):?>
                <div class="<?=$msg->getType()?>" role='alert'><?=$_($msg)?></div>
        <?php endforeach;?>
            </div>
		<?php $this->childContent();?>
	</body>
	</html>
```
