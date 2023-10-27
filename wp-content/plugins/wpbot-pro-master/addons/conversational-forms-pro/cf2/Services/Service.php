<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\Services;


abstract class Service implements ServiceContract
{



	final public function getIdentifier()
	{
		return static::class;
	}
}