<?php
/**
 * Base class for CDN integrations
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 QcformbuilderWP LLC
 */

abstract class Qcformbuilder_Forms_CDN implements Qcformbuilder_Forms_CDN_Contract{

	/**
	 * Slugs of all registered styles
	 *
	 * @since 1.5.3
	 *
	 * @var array
	 */
	protected $style_slugs;

	/**
	 * Slugs of all registered scripts
	 *
	 * @since 1.5.3
	 *
	 * @var array
	 */
	protected $script_slugs;

	/**
	 * Current version
	 *
	 * @since 1.5.3
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Version to provide to CDN
	 *
	 * @since 1.5.3
	 *
	 * @var string
	 */
	protected $cdn_version;

	/**
	 * Url for Chatbot Form Builder dir to be replaces
	 *
	 * @since 1.5.3
	 *
	 * @var string
	 */
	protected $base_url;

	/**
	 * Transfer protocol
	 *
	 * @since 1.5.3
	 *
	 * @var string
	 */
	protected $protocol;

	/**
	 * Qcformbuilder_Forms_CDN constructor.
	 *
	 * @since 1.5.3
	 *
	 * @param $base_url
	 * @param $version
	 */
	public function __construct( $base_url, $version){
		$this->base_url = $base_url;
		$this->version = $version;
		$this->set_protocol();
		$this->set_cdn_version();
	}

	/**
	 * Add hooks
	 *
	 * @since 1.5.3
	 */
	public function add_hooks(){
		add_filter( 'qcformbuilder_forms_script_urls', array( $this, 'filter_script_urls' ) );
		add_filter( 'qcformbuilder_forms_style_urls', array( $this, 'filter_style_urls' ) );
	}

	/**
	 * Remove hooks
	 *
	 * @since 1.5.3
	 */
	public function remove_hooks(){
		remove_filter( 'qcformbuilder_forms_script_urls', array( $this, 'filter_script_urls' ) );
		remove_filter( 'qcformbuilder_forms_style_urls', array( $this, 'filter_style_urls' ) );
	}

	/**
	 * Replace urls for scripts
	 *
	 * @uses "qcformbuilder_forms_script_urls" filter
	 *
	 * @since 1.5.3
	 *
	 * @param array $urls Array of slug => url
	 *
	 * @return array
	 */
	public function filter_script_urls( $urls ){
		$this->script_slugs = array_keys( $urls );
		return $this->replace_urls( $urls );
	}

	/**
	 * Replace urls for styles
	 *
	 * @uses "qcformbuilder_forms_style_urls" filter
	 *
	 * @since 1.5.3
	 *
	 * @param array $urls Array of slug => url
	 *
	 * @return array
	 */
	public function filter_style_urls( $urls ){
		$this->style_slugs = array_keys( $urls );

		return $this->replace_urls( $urls );
	}

	/**
	 * Replace all urls in an array with CDN url
	 *
	 * @since 1.5.3
	 *
	 * @param array $urls Array of slug => url
	 *
	 * @return array
	 */
	protected function replace_urls( $urls ){
		foreach ( $urls as $slug => $url ) {
			$urls[ $slug ] = $this->replace_url( $url );
		}

		return $urls;
	}



	/**
	 * Replace one URL with CDN url
	 *
	 * @since 1.5.3
	 *
	 * @param string $url The URL
	 *
	 * @return string
	 */
	protected function replace_url( $url ){
		return str_replace( $this->base_url, $this->protocol . $this->cdn_url(), $url );
	}

	/**
	 * Set the protocol property based on is_ssl()
	 *
	 * @since 1.5.3
	 */
	protected function set_protocol(){
		if( is_ssl() ){
			$this->protocol = 'https:';
		}else{
			$this->protocol = 'http:';
		}

		/**
		 * Change protocol for CDN links
		 *
		 * Should not be needed, but WordPress' is_ssl() is sometimes wrong.
		 *
		 * @since 1.5.3
		 *
		 * NOTE: return with : IE http: or https"
		 */
		$this->protocol = apply_filters( 'qcformbuilder_forms_cdn_protocol', $this->protocol );
	}

	/**
	 * Set version to use with CDN
	 *
	 * @since 1.5.3
	 */
	protected function set_cdn_version(){
		/**
		 * Use to set version of scripts and styles to request via CDN
		 *
		 * If you have checked out Chatbot Form Builder from Github and are on master branch current version might not exist in CDN yet, setting to "latest" will pull latest form Github
		 *
		 * @since 1.5.3
		 */
		$this->cdn_version = apply_filters( 'qcformbuilder_forms_cdn_version', $this->version );
	}

}