<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\Services;


use qcformbuilderwp\qcformbuilderforms\cf2\QcformbuilderFormsV2Contract;

interface ServiceContract
{

	/**
	 * Register a service for container
	 *
	 * Return instance of class container should provide.
	 *
	 * @since  1.8.0
	 *
	 * @param QcformbuilderFormsV2Contract $container
	 *
	 * @return QcformbuilderFormsV2Contract
	 */
	public function register(QcformbuilderFormsV2Contract $container );

	/**
	 * Get identifier for service
	 *
	 * @since  1.8.0
	 *
	 * @return string
	 */
	public function getIdentifier();

	/**
	 * Is service a singleton or not?
	 *
	 * @since  1.8.0
	 *
	 * @return bool
	 */
	public function isSingleton();

}