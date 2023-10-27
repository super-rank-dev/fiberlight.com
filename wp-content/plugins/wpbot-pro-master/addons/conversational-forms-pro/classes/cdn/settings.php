<?php


/**
 * Settings for CDNs
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_CDN_Settings extends Qcformbuilder_Forms_Settings_Option {

	/**
	 * Get the defaults
	 *
	 * @since 1.5.3
	 *
	 * @var array
	 */
	protected $defaults = array(
		'cdn'     => false,
		'combine' => false,
	);

	/**
	 * Get allowed CDNs
	 *
	 * @since 1.5.3
	 *
	 * @var array
	 */
	protected $cdns = array(
		'jsdelivr'
	);

	/**
	 * @inheritdoc
	 * @since 1.5.3
	 */
	public function get_name(){
		return 'cdn';
	}

	/**
	 * @inheritdoc
	 * @since 1.5.3
	 */
	public function get_option_key(){
		return '_qcformbuilder_forms_cdn_settings';
	}

	/**
	 * Reverse CDN enabled state
	 *
	 * Enables if disabled, Disables if enabled
	 *
	 * @since 1.5.3
	 *
	 * @return array
	 */
	public function toggle_cdn_enable(){
		if( $this->enabled() ){
			return $this->disable();
		}

		return $this->enable();
	}

	/**
	 * Check if CDN is enable
	 *
	 * @since 1.5.3
	 *
	 * @return bool
	 */
	public function enabled(){
		$settings = $this->get_settings();
		if( $settings[ 'cdn' ] ){
			return true;
		}

		return false;
	}

	/**
	 * Is combine mode enabled?
	 *
	 * @since 1.5.3
	 *
	 * @return bool
	 */
	public function combine(){
		$settings = $this->get_settings();
		return $settings[ 'combine' ];
	}

	/**
	 * Enable CDN
	 *
	 * @since 1.5.3
	 *
	 * @return array
	 */
	public function enable(){
		$settings = $this->get_settings();
		$settings[ 'cdn' ] = $this->cdns[0];
		return $this->save_settings( $settings );
	}


	/**
	 * Disable CDN
	 *
	 * @since 1.5.3
	 *
	 * @return array
	 */
	public function disable(){
		$settings = $this->get_settings();
		$settings[ 'cdn' ] = false;
		return $this->save_settings( $settings );

	}

	/**
	 * @inheritdoc
	 * @since 1.5.3
	 */
	protected function prepare( array $settings ){
		foreach ( $settings as $key => $value ){
			if( ! array_key_exists( $key, $this->defaults ) ){
				unset( $settings[ $key ] );
				continue;
			}

			if( 'cdn' === $key && false != $value    ){
				if ( ! in_array( $value, $this->cdns  )  ) {
					$settings[ $key ] = $this->defaults[ 'cdn' ];
				}
			}

		}


		return wp_parse_args( $settings, $this->defaults );

	}


	/**
	 * @inheritdoc
	 * @since 1.5.3
	 */
	protected function get_defaults(){
		return $this->defaults;
	}


}