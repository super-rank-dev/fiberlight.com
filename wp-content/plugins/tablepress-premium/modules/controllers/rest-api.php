<?php
/**
 * TablePress REST API Integration.
 *
 * @package TablePress
 * @subpackage REST API
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Class that contains the logic for the TablePress REST API integration.
 *
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Module_REST_API extends WP_REST_Controller {
	use TablePress_Module; // Use properties and methods from trait.

	/**
	 * Constructor.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		$this->namespace = 'tablepress/v1';
		$this->rest_base = 'tables';

		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Registers the routes for the objects of the controller.
	 *
	 * @since 2.0.0
	 */
	public function register_routes() {
		// Return the List of Tables.
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			array(
				// Individual endpoints.
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				// Options for all endpoints.
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);

		// Return information about a single table.
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base . '/(?P<table_id>[A-Za-z1-9_-]|[A-Za-z0-9_-]{2,})',
			array(
				// Common arguments for all endpoints.
				'args'   => array(
					'table_id' => array(
						'description'       => __( 'A table ID consisting of letters, numbers, hyphens, and underscores.', 'tablepress' ),
						'type'              => 'string',
						'validate_callback' => array( $this, 'item_validate_callback_arg_table' ),
					),
				),
				// Individual endpoints.
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' ),
					'args'                => array(
						'context' => $this->get_context_param( array( 'default' => 'edit' ) ),
					),
				),
				// Options for all endpoints.
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);
	}

	/**
	 * Checks if a given request has permission to read tables.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|true True if the request has read access, WP_Error otherwise.
	 */
	public function get_items_permissions_check( /* WP_REST_Request */ $request ) {
		/**
		 * Allows overriding the TablePress REST API permission check.
		 *
		 * If the filter returns `true` or `false` that will be used to short-circuit the permissions checks.
		 *
		 * @since 2.1.0
		 *
		 * @param boolean|null    $permissions_check Overriding permission check value.
		 * @param WP_REST_Request $request           Full details about the request.
		 */
		$permissions_check = apply_filters( 'tablepress_rest_api_permissions_check', null, $request );
		if ( ! is_null( $permissions_check ) ) {
			return $permissions_check;
		}

		if ( current_user_can( 'tablepress_list_tables' ) ) {
			return true;
		}

		return new WP_Error(
			'tablepress_rest_api:missing_capability:tablepress_list_tables',
			__( 'Sorry, you are not allowed to view the list of tables.', 'tablepress' ),
			array( 'status' => rest_authorization_required_code() )
		);
	}

	/**
	 * Retrieves all tables.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|WP_REST_Response Response object on success, or WP_Error on failure.
	 */
	public function get_items( /* WP_REST_Request */ $request ) {
		$data = array();

		$table_ids = TablePress::$model_table->load_all( true );

		foreach ( $table_ids as $table_id ) {
			// @TODO: Potentially add other fields here by instead calling $table = TablePress::$model_table->load( $table_id );
			$table = array(
				'id' => $table_id,
			);
			$table = $this->prepare_item_for_response( $table, $request );
			$data[] = $this->prepare_response_for_collection( $table );
		}

		return rest_ensure_response( $data );
	}

	/**
	 * Validates that a passed table ID has a valid format.
	 *
	 * @since 2.0.0
	 *
	 * @param string          $table_id The table ID.
	 * @param WP_REST_Request $request  Full details about the request.
	 * @param string          $key      Name of the passed variable (here: "table").
	 * @return bool True if the passed value is valid, false otherwise.
	 */
	public function item_validate_callback_arg_table( $table_id, $request, $key ) {
		// Table IDs must only contain letters, numbers, hyphens (-), and underscores (_). The string "0" is not allowed.
		if ( 0 === preg_match( '/[^a-zA-Z0-9_-]/', $table_id ) && '0' !== $table_id ) {
			return true;
		}

		return new WP_Error(
			'tablepress_rest_api:invalid_argument:table_id',
			__( 'Table IDs must only contain letters, numbers, hyphens (-), and underscores (_). The string "0" is not allowed.', 'tablepress' )
		);
	}

	/**
	 * Checks if a given request has permission to edit a specific table.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|true True if the request has read access, WP_Error otherwise.
	 */
	public function get_item_permissions_check( /* WP_REST_Request */ $request ) {
		/** This filter is documented in modules/controllers/rest-api.php */
		$permissions_check = apply_filters( 'tablepress_rest_api_permissions_check', null, $request );
		if ( ! is_null( $permissions_check ) ) {
			return $permissions_check;
		}

		if ( current_user_can( 'tablepress_list_tables' ) && current_user_can( 'tablepress_edit_table', $request['table_id'] ) ) {
			return true;
		}

		return new WP_Error(
			'tablepress_rest_api:missing_capability:tablepress_edit_table',
			__( 'Sorry, you are not allowed to view this table.', 'tablepress' ),
			array( 'status' => rest_authorization_required_code() )
		);
	}

	/**
	 * Retrieves a specific table.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_Error|WP_REST_Response Response object on success, or WP_Error on failure.
	 */
	public function get_item( /* WP_REST_Request */ $request ) {
		if ( ! TablePress::$model_table->table_exists( $request['table_id'] ) ) {
			return new WP_Error(
				'tablepress_rest_api:table_not_found',
				__( 'Table not found.', 'tablepress' ),
				array( 'status' => 404 )
			);
		}

		// Load table, with table data, options, and visibility settings.
		$table = TablePress::$model_table->load( $request['table_id'], true, true );

		if ( is_wp_error( $table ) ) {
			$error = new WP_Error(
				'tablepress_rest_api:error_load_table',
				__( 'Could not load table', 'tablepress' ),
				array( 'status' => 500 )
			);
			$error->merge_from( $table );
			return $error;
		}

		$data = $this->prepare_item_for_response( $table, $request );

		return rest_ensure_response( $data );
	}

	/**
	 * Prepares a table for the response.
	 *
	 * @since 2.0.0
	 *
	 * @param array           $table   The TablePress table.
	 * @param WP_REST_Request $request Full details about the request.
	 * @return WP_REST_Response Response object.
	 */
	public function prepare_item_for_response( /* array */ $table, /* WP_REST_Request */ $request ) {
		// Don't use `array` type hint in method declaration to prevent a Strict Standards notice, as the method is inherited.
		$fields = $this->get_fields_for_response( $request );

		$table = $this->add_additional_fields_to_object( $table, $request );
		$table = $this->filter_response_by_context( $table, $request['context'] );

		$response = rest_ensure_response( $table );
		if ( rest_is_field_included( '_links', $fields ) || rest_is_field_included( '_embedded', $fields ) ) {
			$response->add_links( $this->prepare_links( $table ) );
		}

		return $response;
	}

	/**
	 * Prepares links for the table request.
	 *
	 * @since 2.0.0
	 *
	 * @param array $table The TablePress table.
	 * @return array Links for the given table.
	 */
	protected function prepare_links( array $table ) {
		$links = array(
			'self'       => array(
				'href' => rest_url( sprintf( '%s/%s/%s', $this->namespace, $this->rest_base, $table['id'] ) ),
			),
			'collection' => array(
				'href' => rest_url( sprintf( '%s/%s', $this->namespace, $this->rest_base ) ),
			),
		);
		return $links;
	}

	/**
	 * Retrieves the table's schema, conforming to JSON Schema.
	 *
	 * @since 2.0.0
	 *
	 * @return array Item schema data.
	 */
	public function get_item_schema() {
		if ( $this->schema ) {
			return $this->add_additional_fields_schema( $this->schema );
		}

		$this->schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'TablePress table',
			'type'       => 'object',
			'properties' => array(
				'id'            => array(
					'description' => __( 'The table ID.', 'tablepress' ),
					'type'        => 'string',
					'pattern'     => '[A-Za-z1-9_-]|[A-Za-z0-9_-]{2,}',
					'context'     => array( 'edit', 'view' ),
					'readonly'    => true,
				),
				'name'          => array(
					'description' => __( 'The table name.', 'tablepress' ),
					'type'        => 'string',
					'context'     => array( 'edit' ),
					'readonly'    => true,
				),
				'description'   => array(
					'description' => __( 'The table description.', 'tablepress' ),
					'type'        => 'string',
					'context'     => array( 'edit' ),
					'readonly'    => true,
				),
				'data'          => array(
					'description' => __( 'The table data.', 'tablepress' ),
					'type'        => 'array',
					'context'     => array( 'edit', 'view' ),
					'readonly'    => true,
				),
				'options'       => array(
					'description' => __( 'The table options.', 'tablepress' ),
					'type'        => 'array',
					'context'     => array( 'edit' ),
					'readonly'    => true,
				),
				'visibility'    => array(
					'description' => __( 'The table visibility settings.', 'tablepress' ),
					'type'        => 'array',
					'context'     => array( 'edit' ),
					'readonly'    => true,
				),
				'author'        => array(
					'description' => __( 'The table author.', 'tablepress' ),
					'type'        => 'string',
					'context'     => array( 'edit' ),
					'readonly'    => true,
				),
				'last_modified' => array(
					'description' => __( 'The table\'s Last Modified time and date.', 'tablepress' ),
					'type'        => 'string',
					'context'     => array( 'edit' ),
					'readonly'    => true,
				),
			),
		);
		return $this->add_additional_fields_schema( $this->schema );
	}

	/**
	 * Retrieves the query params for collections.
	 *
	 * @since 2.0.0
	 *
	 * @return array Collection parameters.
	 */
	public function get_collection_params() {
		return array(
			'context' => $this->get_context_param( array( 'default' => 'edit' ) ),
		);
	}

} // class TablePress_Module_REST_API
