<?php

class wbca_Database_Manager {

    public function __construct() {
		
    }

    public function create_custom_tables() {
        global $wpdb;
		$table_user = $wpdb->prefix . "users";
        $table_name = $wpdb->prefix . "wbca_message";
		$doc_flag = $wpdb->prefix . "wbca_doc_flag";
		$search_doc = $wpdb->prefix . "wbca_search_document";
		$search_term = $wpdb->prefix . "wbca_search_term";
		$search_index = $wpdb->prefix . "wbca_search_index";
		$table_department = $wpdb->prefix . "wbca_department";
		$table_user_department = $wpdb->prefix . "wbca_user_department";
		$table_user_personal_info = $wpdb->prefix . "wbca_user_personal_info";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $sql1 ="CREATE TABLE IF NOT EXISTS $table_name (
			id int(11) NOT NULL AUTO_INCREMENT, 
			user_sender int(11) NOT NULL, 
			user_receiver int(11) NOT NULL, 
			message mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, 
			chat_read tinyint(1) NOT NULL,
			has_attachment tinyint(1)  NULL,
			wbca_transferred TINYINT(1) NOT NULL DEFAULT '0', 
			chat_time TIMESTAMP NOT NULL, 
			PRIMARY KEY (id)
			) AUTO_INCREMENT=11 DEFAULT CHARSET=utf8";
		
		$sql2 ="CREATE TABLE IF NOT EXISTS $search_doc (
				DOCUMENT_ID     INTEGER UNSIGNED  NOT NULL  AUTO_INCREMENT,
				DOCUMENT_TITLE  VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
				DESCRIPTION     MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
			
				PRIMARY KEY (DOCUMENT_ID)

			) AUTO_INCREMENT=11 DEFAULT CHARSET=utf8";
			
		$sql3 ="CREATE TABLE IF NOT EXISTS $search_term (
				TERM_ID    INTEGER UNSIGNED  NOT NULL  AUTO_INCREMENT,
				TERM_VALUE VARCHAR(255)      NOT NULL,
			
				PRIMARY KEY (TERM_ID),
			
				CONSTRAINT UNIQUE (TERM_VALUE)
			) AUTO_INCREMENT=11 DEFAULT CHARSET=utf8";
			
		$sql4 ="CREATE TABLE IF NOT EXISTS $search_index (
				TERM_ID       INTEGER UNSIGNED  NOT NULL,
				DOCUMENT_ID   INTEGER UNSIGNED  NOT NULL,
				OFSET        INTEGER UNSIGNED  NOT NULL,
			
				PRIMARY KEY (DOCUMENT_ID, OFSET),
			
				FOREIGN KEY (TERM_ID)
					REFERENCES $search_term(TERM_ID),
					
				FOREIGN KEY (DOCUMENT_ID) 
					REFERENCES $search_doc(DOCUMENT_ID)
					ON DELETE CASCADE
       				ON UPDATE CASCADE
			) DEFAULT CHARSET=utf8";
			
		$sql5 ="CREATE TABLE IF NOT EXISTS $table_department (
			id       	 INTEGER UNSIGNED  AUTO_INCREMENT,
			department   VARCHAR(255) NOT NULL,
		
			PRIMARY KEY (ID)
		) DEFAULT CHARSET=utf8";
		$sql6 ="CREATE TABLE IF NOT EXISTS $table_user_department (
				id       	INTEGER UNSIGNED  AUTO_INCREMENT,
				user_id     bigint UNSIGNED  NOT NULL,
				dept_id   	INTEGER UNSIGNED  NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (user_id)
					REFERENCES $table_user(ID),
				FOREIGN KEY (dept_id)
					REFERENCES $table_department(id)
		) DEFAULT CHARSET=utf8";
		$sql7 ="CREATE TABLE IF NOT EXISTS $table_user_personal_info (
			id       	INTEGER UNSIGNED  AUTO_INCREMENT,
			USER_ID     		bigint UNSIGNED  NOT NULL,
			macadd      		VARCHAR(255),
			ipadd  	    		VARCHAR(255),
			browser	   			VARCHAR(255),
			page_url  			VARCHAR(255),
			is_phone    		VARCHAR(10),
			lang				VARCHAR(255),
			os_name     		VARCHAR(255),
			userAgent   		VARCHAR(255),
			time_zone   		VARCHAR(255),
			screen_resolution 	VARCHAR(255),
			CONSTRAINT UNIQUE INDEX (USER_ID),
			PRIMARY KEY (id),
			FOREIGN KEY (USER_ID)
			REFERENCES $table_user(ID)
		) DEFAULT CHARSET=utf8";
        dbDelta($sql1);
		dbDelta($sql2);
		dbDelta($sql3);
		dbDelta($sql4);
		dbDelta($sql5);
		dbDelta($sql6);
		dbDelta($sql7);
		/*
        $wpdb->query("ALTER TABLE $wpdb->users 
			ADD COLUMN wbca_status VARCHAR(50) NOT NULL AFTER display_name,
			ADD COLUMN wbca_last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER wbca_status");
			
		*/
    }

}

