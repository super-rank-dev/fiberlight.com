<?php


/**
 * Class init
 */
class Qcformbuilder_Forms_CDN_Init {

	/**
	 * In use CDN implementation
	 *
	 * @since 1.5.3
	 *
	 * @var Qcformbuilder_Forms_CDN_Jsdelivr|Qcformbuilder_Forms_CDN
	 */
	protected static $cdn;

	/**
	 * Implement core settings
	 *
	 * @since 1.5.3
	 */
	public static function init(){
		$cdn_enabled = Qcformbuilder_Forms::settings()->get_cdn()->enabled();
		if( $cdn_enabled ){
			self::$cdn = new Qcformbuilder_Forms_CDN_Jsdelivr( WFBCORE_URL, WFBCORE_VER );
			self::$cdn->add_hooks();
		}
	}

	/**
	 * Get CDN implementation
	 *
	 * @since 1.5.3
	 *
	 * @return Qcformbuilder_Forms_CDN_Jsdelivr|Qcformbuilder_Forms_CDN
	 */
	public static function get_cdn(){
		return self::$cdn;
	}
}