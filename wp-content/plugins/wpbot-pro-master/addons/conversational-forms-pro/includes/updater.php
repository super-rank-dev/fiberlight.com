<?php
/**
 * Updaters for DB structure/etc.
 *
 * @package   Qcformbuilder_Froms
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */

/**
 * Update Chatbot Form Builder DB system to v2
 *
 * @since 1.3.4
 */
function qcformbuilder_forms_db_v2_update(){
	//Before 1.3.4 forms were tracked in options -- each one was autoloaded
	//Also which forms exist tracked in a "registry" option _qcformbuilder_forms that was also autoload
	//Old registry had the "details" fields of forms -- duplicate data oh my.
	$forms = get_option( '_qcformbuilder_forms', array() );
	if( ! empty( $forms ) ){
		//set options storage to be not autoloaded
		$where = '`option_name` = "' . implode( '" OR `option_name` = "', array_keys( $forms ) ) . '"';

		global $wpdb;
		$sql = sprintf( "UPDATE `%s` SET `autoload`='no' WHERE %s", $wpdb->options, $where );
		$wpdb->get_results( $sql  );

		//Create new registry that is just ID and not autoloaded
		$new_registry = array();
		if( ! empty( $forms ) ){
			foreach( $forms as $id => $form ){
				$new_registry[ $id ] = $id;
			}


		}

		add_option( '_qcformbuilder_forms_forms', $new_registry, false );

		qcformbuilder_forms_write_db_flag( 2 );

	}

	//BTW old registry option didn't get deleted because maybe some one reverts...

}

/** BTW v3-5 did not require updater functions */

/**
 * Updated Chatbot Form Builder DB system to v6
 *
 * Moves form configuration to custom table
 *
 * @see https://github.com/QcformbuilderWP/Qcformbuilder-Forms/pull/1741
 *
 * @since 1.5.3
 */
function qcformbuilder_forms_db_v6_update(){
	if( ! class_exists( 'Qcformbuilder_Forms_Forms' ) ){
		return;
	}

	//This will make sure DB table is there if not already
	Qcformbuilder_Forms::check_tables();
	$forms = Qcformbuilder_Forms_Forms::get_forms( false, true );
	if( ! empty( $forms ) ){
		foreach ( $forms as $form ){
			//Migration happens automatically when getting form config
			//BTW means this isn't totally needed, but good to get it done in one go.
			Qcformbuilder_Forms_Forms::get_form( $form );

		}

	}

	//NOTE: Leaving options in place for now, especially beacuse of rollback.


}

function qcformbuilder_forms_db_v7_update(){
    $registry_forms = get_option('_qcformbuilder_forms_forms' );
    if( ! empty( $registry_forms ) ){
        foreach ( $registry_forms as $id ){
            delete_option( $id );
        }
    }
    delete_option( '_qcformbuilder_forms_forms' );
}





/**
 * Write DB version flag to options
 *
 * @since 1.3.4
 *
 * @param int $version Optional. The version number to write. Default is value of WFB_DB
 */
function qcformbuilder_forms_write_db_flag( $version = WFB_DB ){
	update_option( 'WFB_DB',  $version );
}

/**
 * Gets the last update version
 *
 * @since 1.5.0.9
 *
 * @return string
 */
function qcformbuilder_forms_get_last_update_version(){
	return get_option( '_qcformbuilderforms_lastupdate' );
}
