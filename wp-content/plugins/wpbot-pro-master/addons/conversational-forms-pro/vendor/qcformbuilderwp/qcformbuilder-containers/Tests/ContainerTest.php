<?php


class ContainerTest extends TestCase
{

    /**
     *
     * @covers  \qcformbuilderwp\QcformbuilderContainers\Container::get()
     * @covers  \qcformbuilderwp\QcformbuilderContainers\Container::set()
     * @covers  \qcformbuilderwp\QcformbuilderContainers\Container::offsetGet()
     * @covers  \qcformbuilderwp\QcformbuilderContainers\Container::offsetSet()
     */
    public function testSet()
    {
        $container = new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Container();
        $container->set('hi', 'roy' );
        $this->assertEquals( $container[ 'hi'], $container->get('hi' ) );

        $container = new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Container();
        $container[ 'x' ] = 1;
        $this->assertEquals( 1, $container[ 'x' ] );
        $this->assertEquals( $container->get('x'), $container[ 'x' ] );


        $container = new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Container();
        $y = new stdClass();
        $y->x = 1;
        $container->set( 'y', $y );
        $this->assertSame( $y, $container->get( 'y' ) );



    }

    /**
     * @covers  \qcformbuilderwp\QcformbuilderContainers\Container::has()
     * @covers  \qcformbuilderwp\QcformbuilderContainers\Container::offsetExists()
     */
    public function testHas()
    {
        $container = new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Container();
        $container[ 'x' ] = 1;
        $this->assertTrue( $container->has('x' ) );
        $this->assertFalse( $container->has('y' ) );
    }

    /**
     * @covers  \qcformbuilderwp\QcformbuilderContainers\Container::has()
     * @covers  \qcformbuilderwp\QcformbuilderContainers\Container::offsetUnset()
     */
    public function testUnset()
    {
        $container = new \qcformbuilderwp\QcformbuilderContainers\Tests\Mocks\Container();
        $container[ 'x' ] = 1;
        unset( $container['x'] );
        $this->assertFalse( $container->has('x' ) );
    }
}