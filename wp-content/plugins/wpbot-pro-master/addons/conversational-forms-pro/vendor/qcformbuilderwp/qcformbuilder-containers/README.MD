# Qcformbuilder Containers
A collection of useful containers for Qcformbuilder (or your) development.

## Install
`composer require qcformbuilder-containers`

## Requires PHP 5.6+
* [Not tested in 5.6 or 7.0, but should work](https://github.com/QcformbuilderWP/qcformbuilder-containers/issues/1)
## Containers

* `qcformbuilderwp\QcformbuilderContainers\Container`
Basic PSR-11 compatible container decorating Pimple.
    - Is abstract.
    - Converts to arrays. `qcformbuilderwp\QcformbuilderContainers\Interfaces\Arrayable`
    - Converts to JSON. `JsonSerializable`

* `qcformbuilderwp\QcformbuilderContainers\ControlledContainer`
Extends the base container but only allows in specified attributes.
    - Is abstract
* `qcformbuilderwp\QcformbuilderContainers\Service\Coantainer`
A basic service container, with provider bindings, lazy-loaded objects, and singletons.

### Usage
#### `qcformbuilderwp\QcformbuilderContainers\Container`

#### `qcformbuilderwp\QcformbuilderContainers\ControlledContainer`

#### `qcformbuilderwp\QcformbuilderContainers\Service\Coantainer`

#### Binding As Factory
Add a binding that returns a _new_ object of the same class using the alias `std`

```php

$container = new \qcformbuilderwp\QcformbuilderContainers\Service\Container();
$container->bind( 'std', function (){
     $obj = new \stdClass();
     $obj->foo = rand();
     return $obj;
});

//$obj1->foo !== $obj2->foo
$obj1 = $container->make('std');
$obj2 = $container->make('std');

```

#### Binding A Singleton
Add a binding that returns a _the same_ object of the same class using the alias `std`. You MUST instantiate class before binding.

```php

$container = new \qcformbuilderwp\QcformbuilderContainers\Service\Container();
$obj = new \stdClass();
$obj->foo = rand();
$container->singleton( 'std', $obj );

//$obj1->foo === $obj2->foo
$obj1 = $container->make('std');
$obj2 = $container->make('std');
```

#### Binding A Lazy-Loaded Singleton
Add a binding that returns a _the same_ object of the same class using the alias `std`. Class is instantiated 1 times, but is not instantiated until used, if ever.


```php

$container = new \qcformbuilderwp\QcformbuilderContainers\Service\Container();
$container->singleton( 'std', function (){
     $obj = new \stdClass();
     $obj->foo = rand();
     return $obj;
});

//$obj1->foo === $obj2->foo
$obj1 = $container->make('std');
$obj2 = $container->make('std');

## Stuff.
Copyright 2018 QcformbuilderWP LLC. License: GPL v2 or later.
