<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\Services;


use qcformbuilderwp\qcformbuilderforms\cf2\QcformbuilderFormsV2Contract;
use qcformbuilderwp\qcformbuilderforms\cf2\Jobs\DatabaseConnection;
use WP_Queue\Queue;

class QueueService extends Service
{


	public function isSingleton()
	{
		return true;
	}

	public function register(QcformbuilderFormsV2Contract $container)
	{
		return new Queue(new DatabaseConnection($container->getWpdb()));
	}

}