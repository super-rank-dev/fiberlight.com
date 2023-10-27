<?php 

function update_2_2_2(){

    global $wpdb;
    $table2    = $wpdb->prefix.'wpbot_Conversation';
    $tableuser    = $wpdb->prefix.'wpbot_user';

    $results = $wpdb->get_results("select * from $table2 where 1 order by id DESC limit 500");
    if( ! empty( $results ) ){
        foreach( $results as $result ){
            $interaction = (int)substr_count($result->conversation, "wp-chat-user-msg");
            if( $interaction == 0 ){
                $interaction = (int)substr_count($result->conversation, "woo-chat-user-msg");
            }
            $wpdb->update(
				$table2,
				array(
					'interaction' => $interaction,
				),
				array('id'=>$result->id),
				array(
					'%d',
				),
				array('%d')
            );
            
            $wpdb->update(
				$tableuser,
				array(
					'interaction'	=> $interaction
				),
				array('id'=>$result->user_id),
				array(
					'%d',
				),
				array('%d')
			);

        }
    }
}

update_2_2_2();