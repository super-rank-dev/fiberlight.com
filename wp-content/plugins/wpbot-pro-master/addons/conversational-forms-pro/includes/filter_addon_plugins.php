<?php

// Simple Filter for plugins page to help filter qcformbuilder forms addons into its own lost.

	add_filter( 'views_plugins', 'wfb_filter_addons_filter_addons' );
	add_filter( 'show_advanced_plugins', 'wfb_filter_addons_do_filter_addons' );
	add_action( 'check_admin_referer', 'wfb_filter_addons_prepare_filter_addons_referer', 10, 2 );

	function wfb_filter_addons_prepare_filter_addons_referer($a, $b){
		global $status;
		if( !function_exists('get_current_screen')){
			return;
		}
		$screen = get_current_screen();
		if( is_object($screen) && $screen->base === 'plugins' && !empty($_REQUEST['plugin_status']) && $_REQUEST['plugin_status'] === 'qcformbuilder_forms'){
			$status = 'qcformbuilder_forms';
		}

	}
	function wfb_filter_addons_do_filter_addons($a){
		global $plugins, $status;

		foreach($plugins['all'] as $plugin_slug=>$plugin_data){
			if( false !== strpos($plugin_data['Name'], 'Chatbot Form Builder') || false !== strpos($plugin_data['Description'], 'Chatbot Form Builder') ){
				$plugins['qcformbuilder_forms'][$plugin_slug] = $plugins['all'][$plugin_slug];
				$plugins['qcformbuilder_forms'][$plugin_slug]['plugin'] = $plugin_slug;
				// replicate the next step
				if ( current_user_can( 'update_plugins' ) ) {
					$current = get_site_transient( 'update_plugins' );
					if ( isset( $current->response[ $plugin_slug ] ) ) {
						$plugins['qcformbuilder_forms'][$plugin_slug]['update'] = true;
					}
				}

			}
		}

		return $a;
	}


	function wfb_filter_addons_filter_addons($views){
		global $status, $plugins;

		if( !empty( $plugins['qcformbuilder_forms'] ) ){
			$class = "";
			if( $status == 'qcformbuilder_forms' ){
				$class = 'current';
			}
			$views['qcformbuilder_forms'] = '<a class="' . $class . '" href="plugins.php?plugin_status=qcformbuilder_forms">' . __('Chatbot Form Builder', 'qcformbuilder-forms') .' <span class="count">(' . count( $plugins['qcformbuilder_forms'] ) . ')</span></a>';
		}
		return $views;
	}