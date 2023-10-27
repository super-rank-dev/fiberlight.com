<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Integration;


use function qcformbuilderwp\QcformbuilderFormsQueries\QcformbuilderFormsQueries;
use qcformbuilderwp\QcformbuilderFormsQuery\Features\FeatureContainer;

class FunctionsTest extends IntegrationTestCase
{

	/**
	 * Ensure that accessor function returns the right class type
	 * @covers QcformbuilderFormsQueries()
	 */
	public function testGetMainInstance()
	{
		$this->assertSame( FeatureContainer::class, get_class(QcformbuilderFormsQueries()) );
	}
	/**
	 * Ensure that accessor function returns the same class instance
	 * @covers QcformbuilderFormsQueries()
	 */
	public function testIsSameInstance()
	{
		$this->assertSame( QcformbuilderFormsQueries(), QcformbuilderFormsQueries() );
		QcformbuilderFormsQueries()->set('sivan', 'roy' );
		$this->assertEquals( 'roy', QcformbuilderFormsQueries()->get('sivan') );
	}


}