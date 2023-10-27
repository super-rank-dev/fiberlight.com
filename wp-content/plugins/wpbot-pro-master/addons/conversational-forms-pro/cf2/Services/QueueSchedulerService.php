<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\Services;


use qcformbuilderwp\qcformbuilderforms\cf2\QcformbuilderFormsV2Contract;
use qcformbuilderwp\qcformbuilderforms\cf2\Jobs\DatabaseConnection;
use qcformbuilderwp\qcformbuilderforms\cf2\Jobs\Scheduler;

use WP_Queue\Queue;
use WP_Queue\QueueManager;

class QueueSchedulerService extends Service
{

	/** @inheritdoc */
	public function isSingleton()
	{
		return true;
	}

	/** @inheritdoc */
	public function register(QcformbuilderFormsV2Contract $container)
	{
		return new Scheduler( new Queue(new DatabaseConnection($container->getWpdb())) );
	}


}