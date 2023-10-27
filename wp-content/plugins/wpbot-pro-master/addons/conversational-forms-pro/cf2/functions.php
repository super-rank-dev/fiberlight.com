<?php

/**
 * Get the cf2 container
 *
 * @since 1.8.0
 *
 * @return \qcformbuilderwp\qcformbuilderforms\cf2\QcformbuilderFormsV2Contract
 */
function qcformbuilder_forms_get_v2_container()
{

	static $container;
	if ( !$container ) {
		$container = new \qcformbuilderwp\qcformbuilderforms\cf2\QcformbuilderFormsV2();
		do_action('qcformbuilder_forms_v2_init', $container);
	}

	return $container;
}

/**
<<<<<<< HEAD
 * Setup Cf2 container
 *
 * @since 1.8.0
 *
 * @uses "qcformbuilder_forms_v2_init" action
 *
 * @param \qcformbuilderwp\qcformbuilderforms\cf2\QcformbuilderFormsV2Contract $container
 */
function qcformbuilder_forms_v2_container_setup(\qcformbuilderwp\qcformbuilderforms\cf2\QcformbuilderFormsV2Contract $container)
{
	$container
		//Set paths
		->setCoreDir(WFBCORE_PATH)
		->setCoreUrl(WFBCORE_URL)
		//Setup field types
		->getFieldTypeFactory()
		->add(new \qcformbuilderwp\qcformbuilderforms\cf2\Fields\FieldTypes\FileFieldType());

	//Add hooks
	$container->getHooks()->subscribe();

	//Register other services
	$container
		->registerService(new \qcformbuilderwp\qcformbuilderforms\cf2\Services\QueueService(), true)
		->registerService(new \qcformbuilderwp\qcformbuilderforms\cf2\Services\QueueSchedulerService(), true);

	//Run the scheduler with CRON
	/** @var \qcformbuilderwp\qcformbuilderforms\cf2\Jobs\Scheduler $scheduler */
	$scheduler = $container->getService(\qcformbuilderwp\qcformbuilderforms\cf2\Services\QueueSchedulerService::class);
	$running = $scheduler->runWithCron();
}

/**
 * Schedule delete with job manager
 *
 * @since 1.8.0
 *
 * @param \qcformbuilderwp\qcformbuilderforms\cf2\Jobs\Job $job Job to schedule
 * @param int $delay Optional. Minimum delay before job is run. Default is 0.
 */
function qcformbuilder_forms_schedule_job(\qcformbuilderwp\qcformbuilderforms\cf2\Jobs\Job $job, $delay = 0)
{

	qcformbuilder_forms_get_v2_container()
		->getService(\qcformbuilderwp\qcformbuilderforms\cf2\Services\QueueSchedulerService::class)
		->schedule($job, $delay);
}

