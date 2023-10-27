<?php 

/*
* Creating a function to create our CPT
*/
 
function wpbot_fb_custom_post_type() {

// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Fb Posts', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Fb Post', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Fb Posts', 'twentythirteen' ),
        'all_items'           => __( 'All Fb Posts', 'twentythirteen' ),
        'view_item'           => __( 'View Fb Post', 'twentythirteen' ),
        'add_new_item'        => __( 'Add New Fb Post', 'twentythirteen' ),
        'add_new'             => __( 'Reload Post', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Fb Post', 'twentythirteen' ),
        'update_item'         => __( 'Update Fb Post', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'Fb Post', 'twentythirteen' ),
        'description'         => __( 'All Fb Posts', 'twentythirteen' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title' ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
		
		'capability_type' => 'post',
		'capabilities' => array(
			'create_posts' => 'do_not_allow', // false < WP 4.5, credit @Ewout
		),
		
		'map_meta_cap' => true,
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => false,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => false,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'capability_type'     => 'page',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'wpfbposts', $args );

}
add_action( 'init', 'wpbot_fb_custom_post_type', 0 );

// Add the custom columns to the book post type:
add_filter( 'manage_wpfbposts_posts_columns', 'qc_set_custom_edit_wpfbposts_columns' );
function qc_set_custom_edit_wpfbposts_columns($columns) {
    
    $columns['auto_reply'] = __( 'Private Reply', 'wpfb' );
    $columns['auto_comment'] = __( 'Comment Reply', 'wpfb' );
    $columns['comment_campaign'] = __( 'Comment Campaign', 'wpfb' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_wpfbposts_posts_custom_column' , 'qc_custom_wpfbposts_column', 10, 2 );
function qc_custom_wpfbposts_column( $column, $post_id ) {
	
    switch ( $column ) {

        case 'auto_reply' :
            $terms = get_post_meta( $post_id, 'private_reply', true );;
            if ( $terms=='on' )
                echo '<span class="wpfb_pr_status">Enabled</span>';
            break;

        case 'auto_comment' :
            $comment_reply = get_post_meta( $post_id, 'comment_reply', true );
			if($comment_reply=='on')
				echo '<span class="wpfb_cr_status">Enabled</span>';
            break;
			
		case 'comment_campaign' :
            $comment_campaign = get_post_meta( $post_id, 'wpfb_enable_comment_campaign', true );
			if($comment_campaign=='on')
				echo '<span class="wpfb_cc_status">Enabled</span>';
            break;

    }
}


add_filter( 'views_edit-wpfbposts', 'wpfb_post_reload_button' );
function wpfb_post_reload_button( $views )
{

    $views['my-button'] = '<button id="wpfb_reload_fb_post" type="button" class="button button-primary" title="Reload Posts">Reload Posts</button><span class="wpfb_posts_load">Loading...</span>';
    return $views;
}

/**
 * Filter Page
 * @since 1.0
 * @return void
 */
function qcwpfb_filter_post_page() {
  global $typenow;
  global $wp_query;
    if ( $typenow == 'wpfbposts' ) { // Your custom post type slug
      
	  
      $current_page = '';
      if( isset( $_GET['fbpage'] ) ) {
        $current_page = $_GET['fbpage']; 
      } 
	  $pages = wpfb_get_all_pages();
	  ?>
      <select name="fbpage" id="fbpage">
        <option value="all" <?php selected( 'all', $current_page ); ?>><?php _e( 'All Pages', 'qcwpfb' ); ?></option>
        <?php foreach( $pages as $page ) { ?>
          <option value="<?php echo esc_attr( $page->page_id ); ?>" <?php selected( $page->page_id, $current_page ); ?>><?php echo esc_attr( $page->page_name ); ?></option>
        <?php } ?>
      </select>
  <?php }
}
add_action( 'restrict_manage_posts', 'qcwpfb_filter_post_page' );

/**
 * Update query
 * @since 1.0
 * @return void
 */
function qcwpfb_sort_posts_by_page( $query ) {
  global $pagenow;
  // Get the post type
  $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
  if ( is_admin() && $pagenow=='edit.php' && $post_type == 'wpfbposts' && isset( $_GET['fbpage'] ) && $_GET['fbpage'] !='all' ) {
    $query->query_vars['meta_key'] = 'fb_page_id';
    $query->query_vars['meta_value'] = $_GET['fbpage'];
    $query->query_vars['meta_compare'] = '=';
  }
}
add_filter( 'parse_query', 'qcwpfb_sort_posts_by_page' );

function qcwp_fb_add_metaboxes() {
	add_meta_box(
		'qcwp_fb_custom_post_metabox_private_reply',
		'Private Reply Settings',
		'qcwp_fb_custom_post_metabox_private_reply',
		'wpfbposts',
		'normal',
		'default'
	);
	
	add_meta_box(
		'qcwp_fb_custom_post_metabox_comment_reply',
		'Comment Reply Settings',
		'qcwp_fb_custom_post_metabox_comment_reply',
		'wpfbposts',
		'normal',
		'default'
	);
	
	add_meta_box(
		'qcwp_fb_custom_post_metabox_comment_campaign',
		'Auto Comment Campaign Settings',
		'qcwp_fb_custom_post_metabox_comment_campaign',
		'wpfbposts',
		'normal',
		'default'
	);
	
	add_meta_box(
		'qcwp_fb_custom_post_metabox_df',
		'Reply from Dialogflow',
		'qcwp_fb_custom_post_metabox_df',
		'wpfbposts',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'qcwp_fb_add_metaboxes' );

function qcwp_fb_custom_post_metabox_private_reply(){
	
	global $post;
	
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'wpfbposts_fields' );
	// Get the location data if it's already been entered
	
	$private_reply = get_post_meta( $post->ID, 'private_reply', true );
	$private_reply_condition_array = get_post_meta( $post->ID, 'private_reply_condition', true );
	$reply_condition_array = get_post_meta( $post->ID, 'reply_condition', true );
	$condition_value_array = get_post_meta( $post->ID, 'condition_value', true );
	$reply_text_array = get_post_meta( $post->ID, 'reply_text', true );
	
	// Output the field
	?>
		<p class="wpfb_post_title"><?php echo $post->post_title ?></p>
		<input type="checkbox" name="wpfb_enable_private_reply" value="on" <?php echo ($private_reply=='on'?'checked="checked"':''); ?> />
		<i><?php echo esc_html__('Enable Private reply for this post', 'wpfb'); ?></i>

		<div class="fb_condition_container" <?php echo ($private_reply=='on'? 'style="display:block"' : 'style="display:none"' ); ?>>
			
			<?php 
				if( ! empty( $private_reply_condition_array ) && is_array( $private_reply_condition_array ) ):
				foreach( $private_reply_condition_array as $key => $value ): 
				$private_reply_condition = $private_reply_condition_array[$key];
				$reply_condition = $reply_condition_array[$key];
				$condition_value = $condition_value_array[$key];
				$reply_text = $reply_text_array[$key];
			?>

			<div class="fb_condition_item" data-itemid="<?php echo $key; ?>">
				<span class="fb_condition_item_close">x</span>
				<div class="wpfb_private_reply_conditional_area">
					<input type="radio" name="wpfb_private_reply_condition[<?php echo $key; ?>]" value="0" <?php echo ($private_reply_condition==0?'checked="checked"':''); ?> />
					<i><?php echo esc_html__('Reply anytime', 'wpfb'); ?></i>
					<input type="radio" name="wpfb_private_reply_condition[<?php echo $key; ?>]" value="1" <?php echo ($private_reply_condition==1?'checked="checked"':''); ?> />
					<i><?php echo esc_html__('Reply if', 'wpfb'); ?></i>
					
					<div class="wpfb_logical_container" <?php echo ($private_reply_condition==1?'style="display:block"':'style="display:none"') ?>>
					<?php if(!empty($reply_condition) or is_array($reply_condition)): ?>
						<?php foreach($reply_condition as $keyy=>$value): ?>
						<div class="wpfb_logic_elem">
							<span>Comment</span><select name="wpfb_condition[<?php echo $key; ?>][<?php echo $keyy; ?>]">
								<option value="1" <?php echo ($value==1?'selected="selected"':''); ?>>is equal to</option>
								<option value="2" <?php echo ($value==2?'selected="selected"':''); ?>>contains</option>
								<option value="3" <?php echo ($value==3?'selected="selected"':''); ?>>match any</option>
								<option value="4" <?php echo ($value==4?'selected="selected"':''); ?>>match all</option>
								<option value="5" <?php echo ($value==5?'selected="selected"':''); ?>>if tagged people more than or equal to</option>
							</select><input type="text" name="wpfb_condition_value[<?php echo $key; ?>][<?php echo $keyy; ?>]" value="<?php echo (isset($condition_value[$keyy]) && $condition_value[$keyy]!=''?$condition_value[$keyy]:''); ?>" /><a class="button button-secondary wpfb_logic_remove">Remove</a><br>
							<i class="fb_condition_description"></i><br>
							Or
						</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="wpfb_logic_elem">
							<span>Comment</span><select name="wpfb_condition[<?php echo $key; ?>][]">
								<option value="1">is equal to</option>
								<option value="2">contains</option>
								<option value="3">match any</option>
								<option value="4">match all</option>
								<option value="5">if tagged people more than or equal to</option>
							</select><input type="text" name="wpfb_condition_value[<?php echo $key; ?>][]" value="" /><a class="button button-secondary wpfb_logic_remove">Remove</a><br>
							<i class="fb_condition_description"></i><br>
							Or
						</div>
					<?php endif; ?>
					
					</div>
					<br>
					<a class="button button-secondary wpfb_condition_add" <?php echo ($private_reply_condition==1?'style="display:inline-block"':'style="display:none"') ?>>Add New</a>
					
				</div>
				<div class="wpfb_reply_comment_area">
					<p>Reply Content:</p>
					<textarea name="wpfb_reply_text[<?php echo $key; ?>]"><?php echo $reply_text; ?></textarea>
					<span>[sender_name], [sender_comment]</span>
				</div>
			</div>
			<?php endforeach; else: ?>
				<div class="fb_condition_item">
				<span class="fb_condition_item_close">x</span>
					<div class="wpfb_private_reply_conditional_area">
						<input type="radio" name="wpfb_private_reply_condition[first]" checked="checked" value="0" />
						<i><?php echo esc_html__('Reply anytime', 'wpfb'); ?></i>
						<input type="radio" name="wpfb_private_reply_condition[first]" value="1" />
						<i><?php echo esc_html__('Reply if', 'wpfb'); ?></i>
						
						<div class="wpfb_logical_container" style="display:none">
							<div class="wpfb_logic_elem">
								<span>Comment</span><select name="wpfb_condition[first][]">
									<option value="1">is equal to</option>
									<option value="2">contains</option>
									<option value="3">match any</option>
									<option value="4">match all</option>
									<option value="5">if tagged people more than or equal to</option>
								</select><input type="text" name="wpfb_condition_value[first][]" value="" /><a class="button button-secondary wpfb_logic_remove">Remove</a><br>
								<i class="fb_condition_description"></i><br>
								Or
							</div>
						</div>
						<br>
						<a class="button button-secondary wpfb_condition_add" style="display:none">Add New</a>
					</div>
					<div class="wpfb_reply_comment_area">
						<p>Reply Content:</p>
						<textarea name="wpfb_reply_text[first]"></textarea>
						<span>[sender_name], [sender_comment]</span>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="fb_add_new_condition"><?php echo esc_html( '+ Add New Condition', 'wpfb' ); ?></div>
			<div style="clear:both"></div>
	<?php

}

function qcwp_fb_custom_post_metabox_comment_reply(){
	
	global $post;
	
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'wpfbposts_fields' );
	// Get the location data if it's already been entered
	
	$comment_reply = get_post_meta( $post->ID, 'comment_reply', true );
	$comment_reply_is_condition_array = get_post_meta( $post->ID, 'comment_reply_is_condition', true );
	$comment_reply_condition_array = get_post_meta( $post->ID, 'comment_reply_condition', true );
	$comment_condition_value_array = get_post_meta( $post->ID, 'comment_condition_value', true );
	$comment_reply_text_array = get_post_meta( $post->ID, 'comment_reply_text', true );
		
	
	
	// Output the field
	?>
		
		<input type="checkbox" name="wpfb_enable_comment_reply" value="on" <?php echo ($comment_reply=='on'?'checked="checked"':''); ?> />
		<i><?php echo esc_html__('Enable comment reply for this post', 'wpfb'); ?></i>
		
		<div class="fb_condition_container" <?php echo ($comment_reply=='on'? 'style="display:block"' : 'style="display:none"' ); ?>>
			
			<?php 
				if( ! empty( $comment_reply_is_condition_array ) && is_array( $comment_reply_is_condition_array ) ):
				foreach( $comment_reply_is_condition_array as $key => $value ): 
				$comment_reply_is_condition = $comment_reply_is_condition_array[$key];
				$comment_reply_condition = $comment_reply_condition_array[$key];
				$comment_condition_value = $comment_condition_value_array[$key];
				$comment_reply_text = $comment_reply_text_array[$key];
			?>

			<div class="fb_condition_item" data-itemid="<?php echo $key; ?>">
				<span class="fb_condition_item_close">x</span>
				<div class="wpfb_private_reply_conditional_area">
					
					<input type="radio" name="wpfb_comment_reply_condition[<?php echo $key; ?>]" value="0" <?php echo ($comment_reply_is_condition==0?'checked="checked"':''); ?> />
					<i><?php echo esc_html__('Reply anytime', 'wpfb'); ?></i>
					<input type="radio" name="wpfb_comment_reply_condition[<?php echo $key; ?>]" value="1" <?php echo ($comment_reply_is_condition==1?'checked="checked"':''); ?> />
					<i><?php echo esc_html__('Reply if', 'wpfb'); ?></i>
					
					<div class="wpfb_logical_container_comment" <?php echo ($comment_reply_is_condition==1?'style="display:block"':'style="display:none"') ?>>
					<?php if(!empty($comment_reply_condition) or is_array($comment_reply_condition)): 
					
					?>
						<?php foreach($comment_reply_condition as $keyy=>$value): ?>
						<div class="wpfb_logic_elem">
							<span>Comment</span><select name="wpfb_comment_condition[<?php echo $key; ?>][<?php echo $keyy; ?>]">
								<option value="1" <?php echo ($value==1?'selected="selected"':''); ?>>is equal to</option>
								<option value="2" <?php echo ($value==2?'selected="selected"':''); ?>>contains</option>
								<option value="3" <?php echo ($value==3?'selected="selected"':''); ?>>match any</option>
								<option value="4" <?php echo ($value==4?'selected="selected"':''); ?>>match all</option>
								<option value="5" <?php echo ($value==5?'selected="selected"':''); ?>>if tagged people more than or equal to</option>
							</select><input type="text" name="wpfb_comment_condition_value[<?php echo $key; ?>][<?php echo $keyy; ?>]" value="<?php echo (isset($comment_condition_value[$keyy]) && $comment_condition_value[$keyy]!=''?$comment_condition_value[$keyy]:''); ?>" /><a class="button button-secondary wpfb_logic_remove">Remove</a><br>
							<i class="fb_condition_description"></i><br>
							Or
						</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="wpfb_logic_elem">
							<span>Comment</span><select name="wpfb_comment_condition[<?php echo $key; ?>][]">
								<option value="1">is equal to</option>
								<option value="2">contains</option>
								<option value="3">match any</option>
								<option value="4">match all</option>
								<option value="5">if tagged people more than or equal to</option>
							</select><input type="text" name="wpfb_comment_condition_value[<?php echo $key; ?>][]" value="" /><a class="button button-secondary wpfb_logic_remove">Remove</a><br>
							<i class="fb_condition_description"></i><br>
							Or
						</div>
					<?php endif; ?>
					
					</div>
					<br>
					<a class="button button-secondary wpfb_comment_condition_add" <?php echo ($comment_reply_is_condition==1?'style="display:inline-block"':'style="display:none"') ?>>Add New</a>
					
				</div>
				<div class="wpfb_reply_comment_area">
					<p>Reply Content:</p>
					<textarea name="wpfb_comment_reply_text[<?php echo $key; ?>]"><?php echo $comment_reply_text; ?></textarea>
					<span>[sender_name], [sender_comment]</span>
				</div>
			</div>
			<?php endforeach; else: ?>
				<div class="fb_condition_item" data-itemid="first">
					<span class="fb_condition_item_close">x</span>
					<div class="wpfb_private_reply_conditional_area">
						<input type="radio" name="wpfb_comment_reply_condition[first]" checked="checked" value="0" />
						<i><?php echo esc_html__('Reply anytime', 'wpfb'); ?></i>
						<input type="radio" name="wpfb_comment_reply_condition[first]" value="1" />
						<i><?php echo esc_html__('Reply if', 'wpfb'); ?></i>
						<div class="wpfb_logical_container_comment" style="display:none">
							<div class="wpfb_logic_elem">
								<span>Comment</span><select name="wpfb_comment_condition[first][]">
									<option value="1">is equal to</option>
									<option value="2">contains</option>
									<option value="3">match any</option>
									<option value="4">match all</option>
									<option value="5">if tagged people more than or equal to</option>
								</select><input type="text" name="wpfb_comment_condition_value[first][]" value="" /><a class="button button-secondary wpfb_logic_remove">Remove</a><br>
								<i class="fb_condition_description"></i><br>
								Or
							</div>
						</div>
						<br>
						<a class="button button-secondary wpfb_comment_condition_add" style="display:none">Add New</a>
					</div>
					<div class="wpfb_reply_comment_area">
						<p>Reply Content:</p>
						<textarea name="wpfb_comment_reply_text[first]"></textarea>
						<span>[sender_name], [sender_comment]</span>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<div class="fb_add_new_condition_comment"><?php echo esc_html( '+ Add New Condition', 'wpfb' ); ?></div>
		<div style="clear:both"></div>
	<?php
}

function qcwp_fb_custom_post_metabox_comment_campaign(){
	
	global $post;
	
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'wpfbposts_fields' );
	// Get the location data if it's already been entered
	
	$wpfb_enable_comment_campaign = get_post_meta( $post->ID, 'wpfb_enable_comment_campaign', true );
	$wpfb_comment_campaign_schedule = get_post_meta( $post->ID, 'wpfb_comment_campaign_schedule', true );
	$wpfb_periodic_schedule_time = get_post_meta( $post->ID, 'wpfb_periodic_schedule_time', true );
	$wpfb_campaign_start_time = get_post_meta( $post->ID, 'wpfb_campaign_start_time', true );
	$wpfb_campaign_end_time = get_post_meta( $post->ID, 'wpfb_campaign_end_time', true );
	$wpfb_campaign_comment_text = get_post_meta( $post->ID, 'wpfb_campaign_comment_text', true );
	
	
	
	
	
	// Output the field
	?>
		
		<input type="checkbox" name="wpfb_enable_comment_campaign" value="on" <?php echo ($wpfb_enable_comment_campaign=='on'?'checked="checked"':''); ?> />
		<i><?php echo esc_html__('Enable auto comment campaign for this post', 'wpfb'); ?></i>
		<br>
		<br>
		<div class="wpfb_comment_campaign_schedule">
			<div class="wpfb_schedule_type">
				<label>Schedule Type : </label>
				<input type="radio" name="wpfb_comment_campaign_schedule" value="0" <?php echo ($wpfb_comment_campaign_schedule==0?'checked="checked"':''); ?> />
				<i><?php echo esc_html__('One Time', 'wpfb'); ?></i>
				<input type="radio" name="wpfb_comment_campaign_schedule" value="1" <?php echo ($wpfb_comment_campaign_schedule==1?'checked="checked"':''); ?> />
				<i><?php echo esc_html__('Preiodic', 'wpfb'); ?></i>
			</div>
			
			<div class="wpfb_schedule_time">
				<br>
				<label>Periodic Schedule Time : </label>
				<select name="wpfb_periodic_schedule_time">
					
					<option value="5 minutes" <?php echo ($wpfb_periodic_schedule_time=='5 minutes'?'selected="selected"':''); ?>>every 5 minutes</option>
					<option value="10 minutes" <?php echo ($wpfb_periodic_schedule_time=='10 minutes'?'selected="selected"':''); ?>>every 10 minutes</option>
					<option value="15 minutes" <?php echo ($wpfb_periodic_schedule_time=='15 minutes'?'selected="selected"':''); ?>>every 15 minutes</option>
					<option value="30 minutes" <?php echo ($wpfb_periodic_schedule_time=='30 minutes'?'selected="selected"':''); ?>>every 30 minutes</option>
					<option value="1 hours" <?php echo ($wpfb_periodic_schedule_time=='1 hours'?'selected="selected"':''); ?>>every 1 hours</option>
					<option value="2 hours" <?php echo ($wpfb_periodic_schedule_time=='2 hours'?'selected="selected"':''); ?>>every 2 hours</option>
					<option value="5 hours" <?php echo ($wpfb_periodic_schedule_time=='5 hours'?'selected="selected"':''); ?>>every 5 hours</option>
					<option value="12 hours" <?php echo ($wpfb_periodic_schedule_time=='12 hours'?'selected="selected"':''); ?>>every 12 hours</option>
					<option value="24 hours" <?php echo ($wpfb_periodic_schedule_time=='24 hours'?'selected="selected"':''); ?>>every 24 hours</option>
					<option value="48 hours" <?php echo ($wpfb_periodic_schedule_time=='48 hours'?'selected="selected"':''); ?>>every 48 hours</option>
					<option value="72 hours" <?php echo ($wpfb_periodic_schedule_time=='72 hours'?'selected="selected"':''); ?>>every 72 hours</option>
				</select>
				<i><?php echo esc_html__('Please Select Periodic Time Schedule', 'wpfb'); ?></i>
			</div>
			
			<div class="wpfb_campaign_start_time">
				<br>
				<label>Campaign Start Time : </label>
				<input type="text" class="wpfb_campaign_start" name="wpfb_campaign_start_time" value="<?php echo $wpfb_campaign_start_time; ?>" />
				<i><?php echo esc_html__('Please Select Periodic Time Schedule', 'wpfb'); ?></i>
			</div>
			
			<div class="wpfb_campaign_end_time">
				<br>
				<label>Campaign End Time : </label>
				<input type="text" class="wpfb_campaign_end" name="wpfb_campaign_end_time" value="<?php echo $wpfb_campaign_end_time; ?>" />
				<i><?php echo esc_html__('Please Select Periodic Time Schedule', 'wpfb'); ?></i>
			</div>
			
			<div class="wpfb_comment_text_area">
				<p>Comment Content:</p>
				<?php 
					$comments = array();
					if($wpfb_campaign_comment_text!=''){
						$comments = unserialize($wpfb_campaign_comment_text);
					}
					
					for($i=0;$i<sizeof($comments); $i++){						
					?>
					
					<div class="wpfb_campaign_comment_repeatable">
						<textarea name="wpfb_campaign_comment_text[]"><?php echo $comments[$i]; ?></textarea>
						<?php if($i>0): ?>
						<a class="button button-secondary" id="wpfb_campaign_comment_remove">remove</a>
						<?php endif; ?>
					</div>
					
					<?php						
					}
				?>
				
			</div>
			<a class="button button-secondary" id="wpfb_campaign_comment_add">Add New Comment</a>
		</div>
		
	<?php

}

function qcwp_fb_custom_post_metabox_df(){
	
	global $post;
	$enable_private_reply_from_df = get_post_meta( $post->ID, 'enable_private_reply_from_df', true );
	$enable_comment_reply_from_df = get_post_meta( $post->ID, 'enable_comment_reply_from_df', true );
	
	wp_nonce_field( basename( __FILE__ ), 'wpfbposts_fields' );
	?>
	<input type="checkbox" name="wpfb_enable_private_reply_from_df" value="on" <?php echo ($enable_private_reply_from_df=='on'?'checked="checked"':''); ?> />
		<i><?php echo esc_html__('Enable Private Reply from Dialogflow for this post', 'wpfb'); ?></i>
	<br>
	<br>
	<input type="checkbox" name="wpfb_enable_comment_reply_from_df" value="on" <?php echo ($enable_comment_reply_from_df=='on'?'checked="checked"':''); ?> />
		<i><?php echo esc_html__('Enable Comment Reply from Dialogflow for this post', 'wpfb'); ?></i>
	<br>
	<p style="color:red">You must Enable DialogFlow as AI Engine from WPBot Pro > Artificial Intelligence for these above options. If you enable these options then the Private Reply Settings & Comment Reply Settings will not work.</p>
	<?php 
}


/**
 * Save the metabox data
 */
function qcwpfb_save_fbposts_meta( $post_id ) {

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if (isset($_POST['wpfbposts_fields']) && ! wp_verify_nonce( $_POST['wpfbposts_fields'], basename(__FILE__) ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
	if ( isset( $_POST['post_type'] ) && 'wpfbposts' === $_POST['post_type'] ) {
 
        if(isset($_POST['wpfb_enable_private_reply_from_df'])){
			delete_post_meta($post_id, 'enable_private_reply_from_df');
			add_post_meta($post_id, 'enable_private_reply_from_df', sanitize_text_field($_POST['wpfb_enable_private_reply_from_df']), true);
		}else{
			delete_post_meta($post_id, 'enable_private_reply_from_df');
		}
		
		if(isset($_POST['wpfb_enable_comment_reply_from_df'])){
			delete_post_meta($post_id, 'enable_comment_reply_from_df');
			add_post_meta($post_id, 'enable_comment_reply_from_df', sanitize_text_field($_POST['wpfb_enable_comment_reply_from_df']), true);
		}else{
			delete_post_meta($post_id, 'enable_comment_reply_from_df');
		}
		
		if(isset($_POST['wpfb_enable_private_reply'])){
			delete_post_meta($post_id, 'private_reply');
			add_post_meta($post_id, 'private_reply', sanitize_text_field($_POST['wpfb_enable_private_reply']), true);
		}else{
			delete_post_meta($post_id, 'private_reply');
		}
		if(isset($_POST['wpfb_enable_comment_reply'])){
			delete_post_meta($post_id, 'comment_reply');
			add_post_meta($post_id, 'comment_reply', sanitize_text_field($_POST['wpfb_enable_comment_reply']), true);
		}else{
			delete_post_meta($post_id, 'comment_reply');
		}
		
		if(isset($_POST['wpfb_private_reply_condition'])){
			delete_post_meta($post_id, 'private_reply_condition');
			add_post_meta($post_id, 'private_reply_condition', ($_POST['wpfb_private_reply_condition']), true);
		}
		if(isset($_POST['wpfb_comment_reply_condition'])){
			delete_post_meta($post_id, 'comment_reply_is_condition');
			add_post_meta($post_id, 'comment_reply_is_condition', ($_POST['wpfb_comment_reply_condition']), true);
		}
		
		if(isset($_POST['wpfb_condition'])){
			delete_post_meta($post_id, 'reply_condition');
			add_post_meta($post_id, 'reply_condition', $_POST['wpfb_condition'], true);
		}
		if(isset($_POST['wpfb_comment_condition'])){
			delete_post_meta($post_id, 'comment_reply_condition');
			add_post_meta($post_id, 'comment_reply_condition', $_POST['wpfb_comment_condition'], true);
		}
		if(isset($_POST['wpfb_condition_value'])){
			delete_post_meta($post_id, 'condition_value');
			add_post_meta($post_id, 'condition_value', $_POST['wpfb_condition_value'], true);
		}
		if(isset($_POST['wpfb_comment_condition_value'])){
			delete_post_meta($post_id, 'comment_condition_value');
			add_post_meta($post_id, 'comment_condition_value', $_POST['wpfb_comment_condition_value'], true);
		}
		
		if(isset($_POST['wpfb_reply_text'])){
			delete_post_meta($post_id, 'reply_text');
			add_post_meta($post_id, 'reply_text', ($_POST['wpfb_reply_text']), true);
		}
		
		if(isset($_POST['wpfb_comment_reply_text'])){
			delete_post_meta($post_id, 'comment_reply_text');
			add_post_meta($post_id, 'comment_reply_text', ($_POST['wpfb_comment_reply_text']), true);
		}
		
		//campaign comment settngs save section
		if(isset($_POST['wpfb_enable_comment_campaign'])){
			delete_post_meta($post_id, 'wpfb_enable_comment_campaign');
			add_post_meta($post_id, 'wpfb_enable_comment_campaign', sanitize_text_field($_POST['wpfb_enable_comment_campaign']), true);
		}
		
		if(isset($_POST['wpfb_comment_campaign_schedule'])){
			delete_post_meta($post_id, 'wpfb_comment_campaign_schedule');
			add_post_meta($post_id, 'wpfb_comment_campaign_schedule', sanitize_text_field($_POST['wpfb_comment_campaign_schedule']), true);
		}
		
		if(isset($_POST['wpfb_periodic_schedule_time'])){
			delete_post_meta($post_id, 'wpfb_periodic_schedule_time');
			add_post_meta($post_id, 'wpfb_periodic_schedule_time', sanitize_text_field($_POST['wpfb_periodic_schedule_time']), true);
		}
		
		if(isset($_POST['wpfb_campaign_start_time'])){
			delete_post_meta($post_id, 'wpfb_campaign_start_time');
			add_post_meta($post_id, 'wpfb_campaign_start_time', sanitize_text_field($_POST['wpfb_campaign_start_time']), true);
		}
		
		if(isset($_POST['wpfb_campaign_end_time'])){
			delete_post_meta($post_id, 'wpfb_campaign_end_time');
			add_post_meta($post_id, 'wpfb_campaign_end_time', sanitize_text_field($_POST['wpfb_campaign_end_time']), true);
		}
		
		if(isset($_POST['wpfb_campaign_comment_text'])){
			delete_post_meta($post_id, 'wpfb_campaign_comment_text');
			add_post_meta($post_id, 'wpfb_campaign_comment_text', serialize($_POST['wpfb_campaign_comment_text']), true);
		}
		
    }
}
add_action( 'save_post', 'qcwpfb_save_fbposts_meta');