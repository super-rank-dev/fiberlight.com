<?php 

function qcld_wpbot_updater_10_4_4(){

    global $wpdb;

    $collate = '';
    if ( $wpdb->has_cap( 'collation' ) ) {

        if ( ! empty( $wpdb->charset ) ) {

            $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
        }
        if ( ! empty( $wpdb->collate ) ) {

            $collate .= " COLLATE $wpdb->collate";

        }
    }

    $table1    = $wpdb->prefix.'wpbot_user';
    if ( ! Qcld_WPBot_Install::qcwp_isset_table_column( $table1, 'user_id' ) ) {
        $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `user_id` int(11) NOT NULL;";
        $wpdb->query( $sql_wp_Table_update_1 );
    }
    $table1    = $wpdb->prefix.'wpbot_response';
    if ( ! Qcld_WPBot_Install::qcwp_isset_table_column( $table1, 'lang' ) ) {
        $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `lang` varchar(25) NOT NULL;";
        $wpdb->query( $sql_wp_Table_update_1 );
    }
    if ( ! Qcld_WPBot_Install::qcwp_isset_table_column( $table1, 'trigger_intent' ) ) {
        $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `trigger_intent` varchar(100) NOT NULL;";
        $wpdb->query( $sql_wp_Table_update_1 );
    }

    if ( ! Qcld_WPBot_Install::qcwp_isset_table_column( $table1, 'users_answer' ) ) {
        $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `users_answer` TEXT NOT NULL;";
        $wpdb->query( $sql_wp_Table_update_1 );
    }

    if ( ! Qcld_WPBot_Install::qcwp_isset_table_column( $table1, 'hidden' ) ) {
        $sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `hidden` INT NOT NULL;";
        $wpdb->query( $sql_wp_Table_update_1 );
    }

    $sql_wp_Table_update_1 = "ALTER TABLE `$table1` CHANGE `custom` `custom` TEXT NOT NULL;";
    $wpdb->query( $sql_wp_Table_update_1 );

    $rescount = $wpdb->get_var( "SELECT count(*) as cnt FROM `$table1` WHERE 1 and `lang` = ''" );
    if( $rescount > 0 ){
        $wpdb->query( "UPDATE `$table1` SET `lang`= '". get_wpbot_locale() ."' WHERE 1 and `lang` = ''" );
    }
    //Bot Response entities Table
    $table1    = $wpdb->prefix.'wpbot_response_entities';
    if($wpdb->get_var("SHOW TABLES LIKE '$table1'") != $table1) {
        $sql_sliders_Table1 = "
            CREATE TABLE IF NOT EXISTS `$table1` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `entity_name` varchar(256) NOT NULL,
            `entity` varchar(256) NOT NULL,
            `synonyms` TEXT NOT NULL,
            PRIMARY KEY (`id`)
            )  $collate AUTO_INCREMENT=1 ";
            
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql_sliders_Table1 );
    }
    $table_failed_response   = $wpdb->prefix.'wpbot_failed_response';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_failed_response'") != $table_failed_response ){

        $table_failed_response    = $wpdb->prefix.'wpbot_failed_response';
        $sql_sliders_Table = "
            CREATE TABLE IF NOT EXISTS `$table_failed_response` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `query` varchar(256) NOT NULL,
            `count` int(11) NOT NULL,
            `status` int(11) NOT NULL,
            PRIMARY KEY (`id`)
            )  $collate AUTO_INCREMENT=1 ";
            
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql_sliders_Table );

        update_option( 'qc_wpbotpro_failed_query', '1' );
    }
    require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/settings-fields.php" );

    foreach( $wpbot_languages as $key ){

        if( $option = get_option( $key ) ){
            $option = maybe_unserialize( $option );
            if( is_array( $option ) && ! array_key_exists( get_wpbot_locale() , $option ) ){
                $option = serialize( array( get_wpbot_locale() => $option ) );
                update_option( $key, $option );
            }elseif( ! is_array( $option ) ){
                $option = array( get_wpbot_locale() => $option );
                update_option( $key, $option );
            }

        }

    }
    update_option( 'enable_floating_icon', '1' );

    //Livechat data update
    $data = get_option('wbca_options');
    $livechatfields = array(
        'wbca_lg_ochat',
        'wbca_lg_online',
        'wbca_lg_offline',
        'wbca_lg_we_are_here',
        'wbca_lg_chat',
        'wbca_lg_sendq',
        'wbca_lg_subject',
        'wbca_lg_msg',
        'wbca_lg_send',
        'wbca_lg_fname',
        'wbca_lg_email',
        'wbca_msg_success',
        'wbca_msg_failed',
        'wbca_lg_chat_type',
        'wbca_lg_chat_welcome',
        'wbca_lg_please_wait',
        'wbca_lg_operator_offline',
    );
    foreach( $livechatfields as $livechatfield ){
        if( ! get_option( $livechatfield ) && isset( $data[$livechatfield] ) ){

            $option = array( get_wpbot_locale() => $data[$livechatfield] );
            update_option( $livechatfield, $option );

        }
    }
    
}
qcld_wpbot_updater_10_4_4();