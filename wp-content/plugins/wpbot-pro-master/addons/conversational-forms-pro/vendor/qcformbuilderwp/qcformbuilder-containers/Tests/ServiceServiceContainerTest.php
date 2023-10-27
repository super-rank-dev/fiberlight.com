<?php


class ServiceContainerTest extends TestCase
{

    /**
     * Test provider registration
     *
     * @covers Container::bind()
     * @covers Container::make()
     */
    public function testRegisterProvider()
    {
        $ref = 'roy';
        $container = new \qcformbuilderwp\QcformbuilderContainers\Service\Container();
        $container->bind( $ref, function (){
            return new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Something();
        });

        $this->assertSame( \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Something::class, get_class( $container->make($ref )) );
    }

    /**
     *
     * @covers Container::bind()
     * @covers Container::make()
     */
    public function testRegisterTwoProviders()
    {
        $classRef1 = \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Something::class;
        $container = new \qcformbuilderwp\QcformbuilderContainers\Service\Container();
        $container->bind( $classRef1, function (){
            return new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Something();
        });

        $classRef2 = \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\SomethingElse::class;
        $container->bind( $classRef2, function (){
            return new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\SomethingElse();
        });

        $this->assertSame( $classRef1, get_class( $container->make($classRef1 )) );
        $this->assertSame( $classRef2, get_class( $container->make($classRef2 )) );
    }

	/**
	 * Test using a service provider class
	 *
	 * @covers \qcformbuilderwp\QcformbuilderContainers\Interfaces\ProvidesService::registerService()
	 * @covers \qcformbuilderwp\QcformbuilderContainers\ServiceContainer::bind()
	 */
    public function testProvidesService()
	{
		$container = new \qcformbuilderwp\QcformbuilderContainers\Service\Container();
		$provider = new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Provider();
		$provider->registerService($container);
		$providedData = $container->make( $provider->getAlias() );
		$this->assertObjectHasAttribute( 'Roy',$providedData );
		$this->assertObjectHasAttribute( 'Mike',$providedData );
		$this->assertSame( $providedData->Mike, 'Corkum' );
		$this->assertSame( $providedData->Roy, 'Sivan' );
	}

    /**
     * Test that each object returned by bind, that is not set to be a singleton
     *
     * @covers Container::bind()
     * @covers Container::make()
     */
    public function testBindNotSingleton()
    {

        $classRef1 = \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Something::class;
        $container = new \qcformbuilderwp\QcformbuilderContainers\Service\Container();
        $container->bind( $classRef1, function (){
            $entity = new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Something();
            $entity->prop = rand();
            return $entity;
        });

        $this->assertNotEquals( $container->make($classRef1),$container->make($classRef1));
        $this->assertNotEquals( $container->make($classRef1)->prop,$container->make($classRef1)->prop);

    }

    /**
     * Test that objects bound as singletons always return the same instance
     *
     * @covers Container::singleton()
     * @covers Container::bind()
     * @covers Container::make()
     */
    public function testSingleton()
    {
        $container = new \qcformbuilderwp\QcformbuilderContainers\Service\Container();

        $classRef =\qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Something::class;
        $container->singleton( $classRef, new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Something());

        $this->assertSame( $container->make($classRef), $container->make($classRef));
	}

	/**
	 * Test that we can use a function to create a lazy-loaded singleton
	 */
	public function testLazySingleton()
	{
		$container = new \qcformbuilderwp\QcformbuilderContainers\Service\Container();
		$container->singleton( 'X', function (){
			$x = new stdClass();
			$x->sivan = 'Roy';
			return $x;
		});

		$this->assertSame( $container->make('X'), $container->make('X' ) );
	}
}