<?php


namespace qcformbuilderwp\QcformbuilderContainers\Tests\Mocks;


use qcformbuilderwp\QcformbuilderContainers\Interfaces\ProvidesService;
use qcformbuilderwp\QcformbuilderContainers\Interfaces\ServiceContainer;

class Provider implements ProvidesService
{

	/** @inheritdoc */
	public function registerService(ServiceContainer $container)
	{
		$container->bind( $this->getAlias(), function (){
			return (object) [
				'Roy' => 'Sivan',
				'Mike' => 'Corkum'
			];
		} );
	}

	/** @inheritdoc */
	public function getAlias()
	{
		return 'SIVAN';
	}
}