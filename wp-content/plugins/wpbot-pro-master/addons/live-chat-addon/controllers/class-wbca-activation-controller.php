<?php

class wbca_Activation_Controller {

    public function initialize_activation_hooks() {
        register_activation_hook("live-chat-addon/wpbot-chat-addon.php", array($this, 'execute_activation_hooks'));
		register_activation_hook("live-chat-addon/wpbot-chat-addon.php", array($this, 'add_operator_roles'));
		add_action('admin_init',  array($this, 'add_operator_roles'));
		add_action('wp_login', array($this, 'update_user_login'), 10, 2);
		add_action('clear_auth_cookie', array($this, 'update_login_status'), 10);
		add_action('admin_init', array($this, 'operator_make_online'), 10);
		add_action( 'admin_menu', array($this,'remove_operator_menu_items'), 10 );
    }

	public function operator_make_online(){
		$user = wp_get_current_user();
		if ( in_array( 'operator', (array) $user->roles ) ) {
			$blogtime = current_time( 'mysql' ); 
			update_user_meta( $user->ID, 'wbca_login_time', $blogtime );
			//update_user_meta( $user->ID, 'wbca_login_status', 'online' );
		}
	}

    public function execute_activation_hooks() {
        $database_manager = new wbca_Database_Manager();
		
        $database_manager->create_custom_tables();
		
		        
    }
	
	public function execute_deactivation_hooks() {
		flush_rewrite_rules();
		// Will be executed when the client deactivates the plugin
    }
	function remove_operator_menu_items() {
		$user = wp_get_current_user();
		if( $user->roles[0]  == 'operator'  ){
			remove_menu_page( 'edit.php' );                   //Posts
			remove_menu_page( 'edit-comments.php' );          //Comments
			remove_menu_page( 'tools.php' );

		}
	}
	
	public function add_operator_roles() {
		remove_role( 'operator' );
        add_role('operator', 'Operator', array('read' => true));
		$role = get_role('operator');
        $operator_capabilities = array(
            "read",
        );

        foreach ($operator_capabilities as $capability) {
            $role->add_cap($capability);
        }
		

    }
	public function flush_application_rewrite_rules() {
		flush_rewrite_rules();
	}
	
	public function update_user_login( $user_login, $user ) {
		// your code
		
		$user = get_user_by( 'login', $user_login );
		$blogtime = current_time( 'mysql' ); 
		update_user_meta( $user->ID, 'wbca_login_time', $blogtime );
		update_user_meta( $user->ID, 'wbca_login_status', 'online' );
	}
	public function update_login_status() {
		$blogtime = current_time( 'mysql' ); 
		$user = wp_get_current_user();
		delete_user_meta( $user->ID, 'wbca_login_time' );
		update_user_meta( $user->ID, 'wbca_login_status', 'offline' );
	}
	

}

?>