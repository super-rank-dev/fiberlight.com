<?php

/**
 * Auto-populate fields based on Easy Pods and Easy Queries
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Render_AutoPopulation {

	/**
	 * Add hooks for this class
	 *
	 * @since 1.4.3
	 */
	public function add_hooks(){
		add_filter( 'qcformbuilder_forms_render_get_field', array( $this, 'easy_pods' ), 11, 2 );
		add_filter( 'qcformbuilder_forms_autopopulate_post_type_args', array( $this, 'easy_queries' ), 11, 2 );
	}

	/**
	 * Remove hooks for this class
	 *
	 * @since 1.4.3
	 */
	public function remove_hooks(){
		remove_filter( 'qcformbuilder_forms_render_get_field', array( $this, 'easy_pods' ), 11 );
		remove_filter( 'qcformbuilder_forms_autopopulate_post_type_args', array( $this, 'easy_queries' ), 11 );
	}

	/**
	 * Auto-populate Easy Pods-based select fields
	 *
	 * @uses "qcformbuilder_forms_render_get_field"
	 *
	 * @since 1.4.3
	 *
	 * @param array $field Field config
	 * @param array $form Form config
	 *
	 * @return array
	 */
	public function easy_pods( $field, $form ){
		if ( ! empty( $field[ 'config' ][ 'auto' ] ) ) {
			if ( 'easy-pod' == $field[ 'config' ][ 'auto_type' ] && isset( $field[ 'config' ][ 'easy-pod' ] ) && function_exists( 'cep_get_easy_pod' ) && function_exists( 'pods' ) ) {
				$easy_pod = cep_get_easy_pod( $field[ 'config'][ 'easy-pod'] );
				if( ! empty( $easy_pod ) ){
					$pod = pods( $easy_pod['pod'] );

					$pod_params = Qcformbuilder_Easy_Pods::get_instance()->apply_query( array(), $pod, array('query' => $easy_pod ) );

					if( !empty( $params ) ){
						$pod_params = array_merge( $pod_params, (array) $params );
					}

					$pod->find( $pod_params );
					$fields = array_keys( $pod->fields() );
					$label_field = false;
					if( in_array( 'post_title', $fields ) ) {
						$label_field = 'post_title';
					}elseif( in_array( 'name', $fields) ){
						$label_field = 'name';
					}

					/**
					 * The name of the Pods field to use for the label of the auto-populated field
					 *
					 * @since 1.4.3
					 *
					 * @param string $label_field Name of field to use for labels
					 * @param array $form Form config
					 * @param Pods $pod Pods object
					 * @param array $easy_pod Easy Pod config
					 */
					$label_field = apply_filters( 'qcformbuilder_forms_easy_pods_autopopulate_label_field', $label_field, $form, $pod, $easy_pod );
					if( 0 < $pod->total() ){
						while( $pod->fetch() ){
							$label = $pod->display( $label_field );
							if( empty( $label ) ){
								$label = $pod->id();
							}
							$field['config']['option'][$pod->id()] = array(
								'value'	=>	$pod->id(),
								'label' =>	$label,
							);
						}
					}
				}

				$field = Qcformbuilder_Forms::format_select_options( $field );

			}
		}

		return $field;

	}

	/**
	 * Auto-populate Easy Queries-based select fields
	 *
	 * @since "qcformbuilder_forms_autopopulate_post_type_args"
	 *
	 * @param array $args WP_Query args
	 * @param array $field Field config
	 *
	 * @return array
	 */
	public function easy_queries( $args, $field ){
		if ( ! empty( $field[ 'config' ][ 'auto' ] ) ) {
			if ( 'easy-query' == $field[ 'config' ][ 'auto_type' ] && isset( $field[ 'config' ][ 'easy-query' ] ) && defined( 'CAEQ_PATH' ) ) {
				$easy_query = \qcformbuilderwp\caeq\options::get_single( $field[ 'config' ][ 'easy-query' ] );
				if ( ! empty( $easy_query ) ) {
					$args = \qcformbuilderwp\caeq\core::get_instance()->build_query_args( $easy_query );

				}

			}

		}

		return $args;

	}

}