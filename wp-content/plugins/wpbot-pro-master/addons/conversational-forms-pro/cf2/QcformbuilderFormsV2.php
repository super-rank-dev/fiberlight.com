<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2;


use qcformbuilderwp\qcformbuilderforms\cf2\Fields\FieldTypeFactory;
use qcformbuilderwp\qcformbuilderforms\cf2\Transients\Cf1TransientsApi;
use qcformbuilderwp\qcformbuilderforms\cf2\Services\ServiceContract;
class QcformbuilderFormsV2 extends \qcformbuilderwp\QcformbuilderContainers\Service\Container implements QcformbuilderFormsV2Contract
{

	/**
	 * Path to main plugin file
	 *
	 * @since 1.8.0
	 *
	 * @var string
	 */
	protected $coreDirPath;

	/**
	 * URL for main plugin file
	 *
	 * @since 1.8.0
	 *
	 * @var string
	 */
	protected $coreUrl;

	/**
	 * QcformbuilderFormsV2 constructor.
	 *
	 * @since 1.8.0
	 */
    public function __construct()
    {
        $this->singleton(Hooks::class, function(){
            return new Hooks($this);
        });
        $this->singleton(Cf1TransientsApi::class, function(){
            return new Cf1TransientsApi();
        });
		$this->singleton(FieldTypeFactory::class, function(){
			return new FieldTypeFactory();
		});
    }

	/**
	 * Register a service with container
	 *
	 * @since 1.8.0
	 *
	 * @param ServiceContract $service The service to register
	 *
	 * @param boolean $isSingleton Is service a singleton?
	 *
	 * @return $this
	 */
    public function registerService( ServiceContract $service, $isSingleton ){
		if (! $service->isSingleton()) {
			$this->bind($service->getIdentifier(),  $service->register($this) );
		}else{
			$this->singleton($service->getIdentifier(), $service->register($this) );
		}
		return $this;
	}


	/**
	 * Get service from container
	 *
	 * @since 1.8.0
	 *
	 * @param string $identifier
	 *
	 * @return mixed
	 */
	public function getService($identifier){
    	return $this->make($identifier);
	}

	/**
	 * Set path to main plugin file
	 *
	 * @since 1.8.0
	 *
	 * @param string $coreDirPath
	 *
	 * @return $this
	 */
    public function setCoreDir($coreDirPath)
	{
		$this->coreDirPath  = $coreDirPath;
		return $this;
	}

	/**
	 * Get path to main plugin file
	 *
	 * @since 1.8.0
	 *
	 * @return string
	 */
	public function getCoreDir(){
    	if( is_string( $this->coreDirPath ) ){
    		return $this->coreDirPath;
		}
		if( defined( 'WFBCORE_PATH' ) ){
			return WFBCORE_PATH;
		}

		return '';
	}

	/* @inheritdoc */
	public function setCoreUrl($coreUrl)
	{
		$this->coreUrl = $coreUrl;
		return $this;
	}

	/** @inheritdoc */
	public function getCoreUrl()
	{
		if( $this->coreUrl ){
			return $this->coreUrl;
		}

		if( defined( 'WFBCORE_URL') ){
			return WFBCORE_URL;
		}

		return '';
	}

	/**
	 * Get the singleton hooks instance
	 *
	 * @since 1.8.0
	 *
	 * @return \qcformbuilderwp\QcformbuilderContainers\Interfaces\ProvidesService|Hooks
	 */
    public function getHooks(){
        return $this->make(Hooks::class);
    }

	/**
	 * Get our transients API
	 *
	 * @since 1.8.0
	 *
	 * @return \qcformbuilderwp\QcformbuilderContainers\Interfaces\ProvidesService|Cf1TransientsApi
	 */
    public function getTransientsApi()
    {
       return $this->make(Cf1TransientsApi::class );
    }

	/**
	 * Get field type factory
	 *
	 * @since 1.8.0
	 *
	 * @return FieldTypeFactory
	 */
	public function getFieldTypeFactory()
	{
		return $this->make(FieldTypeFactory::class );
	}

	/** @inheritdoc */
	public function getWpdb()
	{
		global $wpdb;
		return $wpdb;
	}
}
