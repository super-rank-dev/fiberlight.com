<?php

/**
 * Add auto-populate option for Easy Queries to select fields
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Admin_APEasyQueries extends Qcformbuilder_Forms_Admin_APSetup {

	/**
	 * @inheritdoc
	 */
	public function add_type() {
		if( defined( 'CAEQ_PATH' ) ){
			printf( '<option value="easy-query"{{#is auto_type value="easy-query"}} selected="selected"{{/is}}>%s</option>', esc_html__( 'Easy Query', 'qcformbuilder-forms' ) );
		}
	}

	/**
	 * @inheritdoc
	 */
	public function add_options() {
		if( ! defined( 'CAEQ_PATH' ) ){
			return;
		}
		$easy_queries = \qcformbuilderwp\caeq\options::get_registry();
		?>
		<div class="qcformbuilder-config-group qcformbuilder-config-group-auto-easy-query auto-populate-type-panel" style="display:none;">
			<label for="wfb-auto-populate-easy-queries">
				<?php esc_html_e( 'Easy Queries', 'qcformbuilder-forms' ); ?>
			</label>
			<div class="qcformbuilder-config-field">
				<select id="wfb-auto-populate-easy-queries" class="block-input field-config" name="{{_name}}[easy-query]">";
					<?php
					foreach( $easy_queries as $easy_query ){
						printf(  '<option value="%s" {{#is easy-query value="%s"}}selected="selected"{{/is}}>%s</option>',
							esc_attr( $easy_query[ 'id' ] ), esc_attr( $easy_query[ 'id' ] ), esc_html__( $easy_query[ 'name' ] ));
					}

					?></select>

			</div>
		</div>
		<?php
	}

}