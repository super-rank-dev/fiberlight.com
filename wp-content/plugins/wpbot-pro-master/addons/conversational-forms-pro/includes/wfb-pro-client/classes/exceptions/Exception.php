<?php


namespace qcformbuilderwp\qcformbuilderforms\pro\exceptions;

use qcformbuilderwp\qcformbuilderforms\pro\container;


/**
 * Class Exception
 * @package qcformbuilderwp\qcformbuilderforms\pro\exceptions
 */
class Exception extends \Exception
{

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @param array $data
	 *
	 * @return $this
	 */
	public function log(array $data)
	{
		if ( is_array($this->data) ) {
			$this->data = array_merge($data, $this->data);
		}

		container::get_instance()->get_logger()->send($this->message, $this->data);
		return $this;
	}


	/**
	 * Convert to WP_Error object
	 *
	 * @since 0.0.1
	 *
	 * @param array $data
	 *
	 * @return \WP_Error
	 */
	public function to_wp_error(array $data = [])
	{
		if ( is_array($this->data) ) {
			$data = array_merge($data, $this->data);
		}
		$wp_error = new \WP_Error($this->getCode(), $this->getMessage(), $data);
		return $wp_error;

	}

}
