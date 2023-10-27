<?php 

final class Qcld_str_pro{
	
	public function __construct(){
		
		add_action('init', array($this, 'form_handle'));
		add_action( 'admin_post_qc_str_export', array($this, 'export_csv') );
		
		add_action('qcld_str_pro_stredit', array($this, 'stredit'));

		//category
		add_action('qcld_str_add_category', array($this, 'add_category'));
		add_action('qcld_str_edit_category', array($this, 'edit_category'));

		//entity
		add_action('qcld_str_add_entity', array($this, 'add_entity'));
		add_action('qcld_str_edit_entity', array($this, 'edit_entity'));

		add_action('qcld_str_import', array($this, 'import'));
	}
	

	function form_handle(){
		
		global $wpdb;
		
		if(isset($_POST['qc_bot_str_query']) && $_POST['qc_bot_str_query']!=''){

		
			$query = wp_unslash(sanitize_text_field($_POST['qc_bot_str_query']));
			$keyword = wp_unslash(sanitize_text_field($_POST['qc_bot_str_keyword']));
			$intent = wp_unslash(sanitize_text_field($_POST['qc_bot_str_intent']));
			if ( isset( $_POST['qc_bot_str_hide'] ) && $_POST['qc_bot_str_hide'] == 1 ) {
				$hidden = $_POST['qc_bot_str_hide'];
			} else {
				$hidden = 0;
			}
			
			//$custom = wp_kses(wp_unslash($_POST['qc_bot_str_follow_up']), 'post');
			$custom = wp_unslash( $_POST['qc_bot_str_follow_up'] );

			$trigger_intent = wp_unslash(sanitize_text_field($_POST['qc_bot_str_intent_trigger']));
			if( isset( $_POST['qc_bot_str_cate'] ) ){
				$category = implode(',', $_POST['qc_bot_str_cate']);
			}else{
				$category = '';
			}
			$response = wp_unslash( $_POST['qc_bot_str_response'] );

			$lang = ( isset( $_POST['qc_bot_str_lang'] ) ? sanitize_text_field($_POST['qc_bot_str_lang']) : get_wpbot_locale() );
			// user answer follow up section
			$users_answer = stripslashes_deep( $_POST['users_answer'] );
			$users_answer_build = array();
			$users_answer_build['answer'] = array_filter( $users_answer['answer'] );
			$users_answer_build['feedback'] = array_filter( $users_answer['feedback'] );
			$users_answer_build['not_match'] = wp_unslash($_POST['users_answer_not_match']);
			$users_answer_build['trigger_intent'] = sanitize_text_field( $users_answer['trigger_intent'] );
			$users_answer_build['entity_name'] = isset( $users_answer['entity_name'] ) ? sanitize_text_field( $users_answer['entity_name'] ) : '';
			$users_answer_build['entity_is_required'] = isset( $users_answer['entity_is_required'] ) && $users_answer['entity_is_required'] == 1 ? 1 : 0;
			$users_answer_build['response_type'] = isset( $users_answer['response_type'] ) && $users_answer['response_type'] > 0 ? $users_answer['response_type'] : 2;
			
			$users_answer_build['prompt_message'] = isset( $users_answer['prompt_message'] ) ? sanitize_text_field( $users_answer['prompt_message'] ) : '';
			$users_answer_build = maybe_serialize( $users_answer_build );

			$table = $wpdb->prefix.'wpbot_response';
			$data = array('query' => $query, 'keyword' => $keyword, 'response'=> $response, 'intent'=> $intent, 'category'=> $category, 'custom'=> $custom, 'lang'=> $lang, 'trigger_intent' => $trigger_intent, 'users_answer' => $users_answer_build, 'hidden' => $hidden);
			$format = array('%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d');
			
			if(isset($_POST['qc_bot_str_id']) && $_POST['qc_bot_str_id']!=''){
				$id = sanitize_text_field($_POST['qc_bot_str_id']);
				$where = array('id'=>$id);
				$whereformat = array('%d');
				$result = $wpdb->update( $table, $data, $where, $format, $whereformat );
			}else{
				$result = $wpdb->insert($table,$data,$format);
			}
			if($result === false ){
				echo $wpdb->last_error;exit;
			}

			$fields = get_option('qc_bot_str_fields');
			if(function_exists('qcstrpro_mysql_remove_existing_indexes')){
				qcstrpro_mysql_remove_existing_indexes();
			}
			if($fields){
				$wpdb->query("ALTER TABLE $table ADD FULLTEXT(".implode(', ', $fields).")");
			}else{
				$wpdb->query("ALTER TABLE $table ADD FULLTEXT(`query`, `keyword`, `response`)");
			}

			wp_redirect(admin_url('admin.php?page=simple-text-response'));exit;
		}
		
		if(isset($_POST['qc_bot_str_category']) && $_POST['qc_bot_str_category']!=''){
			$category = wp_unslash(sanitize_text_field($_POST['qc_bot_str_category']));
			$category_parent = '';
			if ( isset( $_POST['qc_bot_str_category_parent'] ) ) {
				$category_parent = wp_unslash(sanitize_text_field($_POST['qc_bot_str_category_parent']));
			}
			
			$table = $wpdb->prefix.'wpbot_response_category';
			$qtable = $wpdb->prefix.'wpbot_response';
			
			$data = array('name' => $category, 'custom' => $category_parent);
			$format = array('%s', '%d');
			
			if(isset($_POST['qc_bot_str_category_id']) && $_POST['qc_bot_str_category_id']!=''){
				
				$id = sanitize_text_field($_POST['qc_bot_str_category_id']);
				
				$chkcat = $wpdb->get_row("SELECT * FROM `$table` WHERE 1 and `id` = '".$id."'");
				
				
				
				$chkquery = $wpdb->get_results("SELECT * FROM `$qtable` WHERE 1 and `category` = '".$chkcat->name."'");
				
				foreach($chkquery as $rowq){
					$cdata = array('category' => $category, 'custom' => $category_parent);
					$cwhere = array('id'=>$rowq->id);
					$cwhereformat = array('%d');
					$cformat = array('%s', '%d');
					$wpdb->update( $qtable, $cdata, $cwhere, $cformat, $cwhereformat );
				}
				
				$where = array('id'=>$id);
				$whereformat = array('%d');
				$wpdb->update( $table, $data, $where, $format, $whereformat );
				
			}else{
				$wpdb->insert($table,$data,$format);
			}

			wp_redirect(admin_url('admin.php?page=simple-text-response&action=manage-categories'));exit;
			
		}
		
		if(isset($_GET['action']) && $_GET['action']=='manage-categories' && isset($_GET['opt']) && $_GET['opt']=='delete' && isset($_GET['id']) && $_GET['id']!=''){
			$id = sanitize_text_field($_GET['id']);
			$table = $wpdb->prefix.'wpbot_response_category';
			$wpdb->delete(
				$table,
				[ 'id' => $id ],
				[ '%d' ]
			);
			wp_redirect(admin_url('admin.php?page=simple-text-response&action=manage-categories'));exit;
			
		}

		if ( isset( $_POST['qc_bot_str_entity_name'] ) && $_POST['qc_bot_str_entity_name'] != '' ) {
			$entity_name = sanitize_text_field( $_POST['qc_bot_str_entity_name'] );
			$synonyms = sanitize_text_field( $_POST['qc_bot_str_entity_synonyms'] );
			$entity = '@' . sanitize_title( $entity_name );

			$table = $wpdb->prefix.'wpbot_response_entities';

			$data = array('entity_name' => $entity_name, 'entity' => $entity, 'synonyms' => $synonyms);
			$format = array('%s', '%s', '%s');

			if(isset($_POST['qc_bot_str_entity_id']) && $_POST['qc_bot_str_entity_id']!=''){
				$id = (int) $_POST['qc_bot_str_entity_id'];
				$where = array( 'id'=> $id );
				$whereformat = array( '%d' );
				$wpdb->update( $table, $data, $where, $format, $whereformat );
			} else {
				$wpdb->insert( $table, $data, $format );
				wp_redirect(admin_url('admin.php?page=simple-text-response&action=manage-entities'));exit;
			}
		}

		if(isset($_GET['action']) && $_GET['action']=='manage-entities' && isset($_GET['opt']) && $_GET['opt']=='delete' && isset($_GET['id']) && $_GET['id']!=''){
			$id = (int) $_GET['id'];
			$table = $wpdb->prefix.'wpbot_response_entities';

			if ( 0 === $id ) {
				$wpdb->query( "DELETE FROM `$table` WHERE 1" );
			} else {
				$wpdb->delete(
					$table,
					[ 'id' => $id ],
					[ '%d' ]
				);
			}

			wp_redirect(admin_url('admin.php?page=simple-text-response&action=manage-entities'));exit;
			
		}
		
	}
	
	function export_csv(){
		
		global $wpdb;
		$csvTitle = 'str';
		$table = $wpdb->prefix.'wpbot_response';
		
		$rows     = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table WHERE %d ", 1) );
		$mainArray = array();
		foreach($rows as $row){
			$sliderArray = array(
				'query'				=> $row->query,
				'keyword'			=> $row->keyword,
				'response'			=> $row->response,
				'category'			=> $row->category,
				'intent'			=> $row->intent,
				'language_code'		=> $row->lang
			);
			
			array_push($mainArray, $sliderArray);
		}
		
		$this->download_send_headers($csvTitle .'_'. date("Y-m-d") . ".csv");
		$result = $this->array2csv($mainArray);
		print $result;
		
	}
	
	public function download_send_headers($filename){
		// disable caching
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");

		// force download  
		header("Content-Type: application/force-download");
		/*header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");*/

		// disposition / encoding on response body
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	}
	
	public function array2csv(array &$array){
		if (count($array) == 0) {
		 return null;
	   }

	   ob_start();

	   $df = fopen("php://output", 'w');

		fputcsv($df, array_keys($array[0]));
	   foreach ($array as $row) {
		  fputcsv($df, $row);
	   }

	   fclose($df);

	   return ob_get_clean();
	}
	
	public function import(){
		global $wpdb;
	?>
	<div class="wrap">

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-3">

				<div id="post-body-content" style="padding: 50px;
	box-sizing: border-box;
	box-shadow: 0 8px 25px 3px rgba(0,0,0,.2);
	background: #fff;">

					

					<div style="padding: 15px; margin: 10px 0;">

					<h3><u>Import from a CSV File</u></h3>
					<p>
						<strong><u>Option Details:</u></strong>
					</p>
					<p>
						CSV file must be as per the exported format.
						
					</p>
					<p>
						CSV file should have minimum 5 columns. The following columns are Query, Keyword, Response, Intent & Category.
					</p>
					<!-- Handle CSV Upload -->

					<?php

					//Generate a 5 digit random number based on microtime
					$randomNum = substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 5);


					/*******************************
					 * If Add New or Delete then Add New button was pressed
					 * then proceed for further processing
					 *******************************/
					if( !empty($_POST) && isset($_POST['upload_csv']) || !empty($_POST) && isset($_POST['delete_upload_csv']) ) 
					{

						//First check if the uploaded file is valid
						$valid = true;
						
						$allowedTypes = array(
								'application/vnd.ms-excel',
								'text/comma-separated-values', 
								'text/csv', 
								'application/csv', 
								'application/excel', 
								'application/vnd.msexcel', 
								'text/anytext',
								'application/octet-stream',
							);
						//echo $_FILES['csv_upload']['type'];exit;
						if( !in_array($_FILES['csv_upload']['type'], $allowedTypes) ){
							$valid = false;
						}

						if( ! $valid ){
							echo "Status: Invalid file type.";
						}
						
						

						//If the file is valid and client is logged in
						if ( $valid && function_exists('is_user_logged_in') && is_user_logged_in() ) 
						{

							$tmpName = $_FILES['csv_upload']['tmp_name'];
							
							if( $tmpName != "" )
							{
							
								$file = fopen($tmpName, "r");
								$flag = true;
								
								//Reading file and building our array
								
								$baseData = array();

								$count = 0;

								$laps = 1;
								
								//Read fields from CSV file and dump in $baseData
								while(($data = fgetcsv($file)) !== FALSE) 
								{
									array_push($baseData, $data);
									
								}
								
								fclose($file);
								
								//Inserting Data from our built array
								$strcount = 0;
								$table = $wpdb->prefix.'wpbot_response';
								$table1    = $wpdb->prefix.'wpbot_response_category';
								
								
								
								foreach($baseData as $row){
									$strcount++;
									if( $strcount == 1 ) continue;
									
									$query = $row[0];
									$keyword = $row[1];
									$response = $row[2];
									$category = $row[3];
									$intent = $row[4];
									$lang = $row[5];
									
									//category management
									
									$categories = explode(',', $category);
									
									foreach($categories as $cate){
										$category = trim($cate);
										$cdata = array('name' => $cate);
										$cformat = array('%s');
										$chkcat = $wpdb->get_row("SELECT * FROM `$table1` WHERE 1 and `name` = '".$cate."'");
										
										if(empty($chkcat)){
											$wpdb->insert($table1,$cdata,$cformat);
										}else{
											$cwhere = array('name'=>$cate);
											$cwhereformat = array('%s');
											$wpdb->update( $table1, $cdata, $cwhere, $cformat, $cwhereformat );
										}
									}
									
									
									
									//response adding
									$chkquery = $wpdb->get_row("SELECT * FROM `$table` WHERE 1 and `query` = '".$query."'");
									
									$data = array('query' => sanitize_text_field($query), 'keyword' => sanitize_text_field($keyword), 'response'=> $response, 'intent'=> sanitize_text_field($intent), 'category'=> sanitize_text_field($category), 'lang' => sanitize_text_field( $lang ) );
									$format = array('%s','%s', '%s', '%s', '%s');
									
									if(empty($chkquery)){
										$wpdb->insert($table,$data,$format);
									}else{
										$where = array('query'=>$query);
										$whereformat = array('%s');
										$wpdb->update( $table, $data, $where, $format, $whereformat );
									}
									
								}
								


								//Display iteration result
								
								echo  '<div style="background: #dfe2df;padding: 10px;"><span style="color: red; font-weight: bold;">RESULT:</span> <strong>'.($strcount - 1).'</strong> Simple Text Responses was made successfully.</div>';
								
							
							}
							else
							{
							   echo "Status: Please upload a valid CSV file.";
							}

						}

					} 
					else 
					{
						//echo "Attached file is invalid!";
					}

					?>
						
						<p>
							<strong>
								<?php echo __('Upload a CSV file here to Import: '); ?>
							</strong>
						</p>

						<form name="uploadfile" id="uploadfile_form" method="POST" enctype="multipart/form-data" action="" accept-charset="utf-8">
							
							<?php wp_nonce_field('qchero_import_nonce', 'qc-opd'); ?>

							<p>
								<?php echo __('Select file to upload') ?>
								<input type="file" name="csv_upload" id="csv_upload" size="35" class="uploadfiles"/>
							</p>
							<p style="color:red;">**CSV File & Characters must be saved with UTF-8 encoding**</p>
							<p>
								<input class="button-primary sld-add-as-new" type="submit" name="upload_csv" id="" value="<?php echo __('Import') ?>"/>

							   
							</p>
							

						</form>

					</div>

					<div style="padding: 15px 10px; border: 1px solid #ccc; text-align: center; margin-top: 20px;">
						Crafted By: <a href="http://www.quantumcloud.com" target="_blank">Web Design Company</a> -
						QuantumCloud
					</div>

				</div>
				<!-- /post-body-content -->

			</div>
			<!-- /post-body-->

		</div>
		<!-- /poststuff -->


	</div>
	<!-- /wrap -->

	<?php 
		
	}
	
	public function edit_category(){
		
		global $wpdb;

		$id = $_GET['id'];

		$table = $wpdb->prefix.'wpbot_response_category';

		$data = $wpdb->get_row("select * from $table where 1 and id=$id");

		$data2 = $wpdb->get_results("select * from $table where 1 and ( custom = '' or custom = '0' )");

		$cat_hierarchy = array();
		if ( ! empty( $data2 ) ) {
			foreach ( $data2 as $cat ) {
				$cat_hierarchy[] = array( 'id' => $cat->id, 'name' => $cat->name );
				$cat_hierarchy = $this->manage_cat_hierarchy( $cat_hierarchy, $cat->id );
			}
		}

		?>

		<div class="qcwrap">
			<div class="wp-chatbot-wrap">
			
			
				<div class="wpbot_dashboard_header container">
					<h1>Edit Category</h1>
					
				</div>
				
				<div class="wpbot_addons_section container">
				
					<form method="post" action="">
				
					<div class="wpbot_single_addon_wrapper2">
					
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th scope="row">Name</th>
									<td>
										<input type="text" name="qc_bot_str_category" value="<?php echo esc_attr($data->name); ?>" style="width: 400px;" required />
										<br><i>*Required. Add the category name.</i>
									</td>
								</tr>
								<tr valign="top">
								<th scope="row">Parent</th>
								<td>
									<select name="qc_bot_str_category_parent" >
										<option value="">None</option>
										<?php 
										if ( !empty( $cat_hierarchy ) ) {
											foreach( $cat_hierarchy as $cat ) {
												if ( $cat['id'] == $data->id ) {
													continue;
												}
												echo '<option value="'.esc_attr( $cat['id'] ).'" '. ( $data->custom == $cat['id'] ? 'selected="selected"' : '' ) .'  > '. ( $cat['name'] ) .' </option>';
											}
										}
										?>
									<select>
									<br><i>Add parent category.</i>
								</td>
							</tr>

							</tbody>
						</table>
					
					</div>
					
					<footer class="wp-chatbot-admin-footer">
						<div class="row">
							<div class="text-left col-sm-3 col-sm-offset-3">
								
							</div>
							<div class="text-right col-sm-6">
								<input type="hidden" name="qc_bot_str_category_id" value="<?php echo $data->id; ?>" />
								<input type="submit" class="button button-primary" name="submit" id="submit" value="Update Category">
							</div>
						</div>
						<!--                    row-->
					</footer>

					</form>
				</div>
			</div>
		</div>
		<?php
	}

	public function manage_cat_hierarchy( $cat_array, $cat_id, $depth = 1 ) {
		global $wpdb;
		$table = $wpdb->prefix.'wpbot_response_category';
		$data = $wpdb->get_results("select * from $table where 1 and custom = '".$cat_id."'");
		if ( ! empty( $data ) ) {
			foreach ( $data as $cat ) {
				$cat_array[] = array( 'id' => $cat->id, 'name' => str_repeat('&nbsp;&nbsp;', $depth).$cat->name );
				$depth = $depth + 1;
				$cat_array = $this->manage_cat_hierarchy( $cat_array, $cat->id, $depth );
			}
			return $cat_array;
		} else {
			return $cat_array;
		}
	}
	
	public function add_category(){
		global $wpdb;
		$table = $wpdb->prefix.'wpbot_response_category';
		$data = $wpdb->get_results("select * from $table where 1 and ( custom = '' or custom = '0' )");

		$cat_hierarchy = array();
		if ( ! empty( $data ) ) {
			foreach ( $data as $cat ) {
				$cat_hierarchy[] = array( 'id' => $cat->id, 'name' => $cat->name );
				$cat_hierarchy = $this->manage_cat_hierarchy( $cat_hierarchy, $cat->id );
			}
		}

	?>
	<div class="qcwrap">
		<div class="wp-chatbot-wrap">
		
		
			<div class="wpbot_dashboard_header container">
				<h1>Add Category</h1>
				
			</div>
			
			<div class="wpbot_addons_section container">
			
				<form method="post" action="">
			
				<div class="wpbot_single_addon_wrapper2">
				
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">Name</th>
								<td>
									<input type="text" name="qc_bot_str_category" value="" style="width: 400px;" required />
									<br><i>*Required. Add the category name.</i>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Parent</th>
								<td>
									<select name="qc_bot_str_category_parent" >
										<option value="">None</option>
										<?php 
										if ( !empty( $cat_hierarchy ) ) {
											foreach( $cat_hierarchy as $cat ) {
												echo '<option value="'.esc_attr( $cat['id'] ).'" > '. ( $cat['name'] ) .' </option>';
											}
										}
										?>
									<select>
									<br><i>Add parent category.</i>
								</td>
							</tr>

						</tbody>
					</table>
				
				</div>
				
				<footer class="wp-chatbot-admin-footer">
					<div class="row">
						<div class="text-left col-sm-3 col-sm-offset-3">
							
						</div>
						<div class="text-right col-sm-6">
							<input type="submit" class="button button-primary" name="submit" id="submit" value="Add Category">
						</div>
					</div>
					<!--                    row-->
				</footer>

				</form>
			</div>
		</div>
	</div>
	<?php 
	}

	public function add_entity(){
	?>
	<div class="qcwrap">
		<div class="wp-chatbot-wrap">
		
		
			<div class="wpbot_dashboard_header container">
				<h1><?php echo esc_html('Add Cutom Entity'); ?></h1>
				
			</div>
			
			<div class="wpbot_addons_section container">
			
				<form method="post" action="">
			
				<div class="wpbot_single_addon_wrapper2">
				
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row"><?php echo esc_html('Entity Name'); ?></th>
								<td>
									<input type="text" name="qc_bot_str_entity_name" value="" style="width: 400px;" required />
									<br><i><?php echo esc_html('*Required. Add the entity name.'); ?></i>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row"><?php echo esc_html('Synonyms'); ?></th>
								<td>
									<textarea name="qc_bot_str_entity_synonyms" rows="10" cols="80" required></textarea>
									<br><i><?php echo esc_html('*Required. Add multiple with comma(,) seperated value. e.g. red, orange, blue'); ?></i>
								</td>
							</tr>
							

						</tbody>
					</table>
				
				</div>
				
				<footer class="wp-chatbot-admin-footer">
					<div class="row">
						<div class="text-left col-sm-3 col-sm-offset-3">
							
						</div>
						<div class="text-right col-sm-6">
							<input type="submit" class="button button-primary" name="submit" id="submit" value="Add Entity">
						</div>
					</div>
					<!--                    row-->
				</footer>

				</form>
			</div>
		</div>
	</div>
	<?php 
	}

	public function edit_entity(){
		global $wpdb;

		$id = $_GET['id'];

		$table = $wpdb->prefix.'wpbot_response_entities';

		$data = $wpdb->get_row("select * from $table where 1 and id=$id");

	?>
	<div class="qcwrap">
		<div class="wp-chatbot-wrap">
		
		
			<div class="wpbot_dashboard_header container">
				<h1><?php echo esc_html('Edit Cutom Entity'); ?></h1>
				
			</div>
			
			<div class="wpbot_addons_section container">
			
				<form method="post" action="">
			
				<div class="wpbot_single_addon_wrapper2">
				
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row"><?php echo esc_html('Entity Name'); ?></th>
								<td>
									<input type="text" name="qc_bot_str_entity_name" value="<?php echo esc_html( $data->entity_name ); ?>" style="width: 400px;" required />
									<br><i><?php echo esc_html('*Required. Add the entity name.'); ?></i>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row"><?php echo esc_html('Synonyms'); ?></th>
								<td>
									<textarea name="qc_bot_str_entity_synonyms" rows="10" cols="80" required><?php echo esc_html( $data->synonyms ); ?></textarea>
									<br><i><?php echo esc_html('*Required. Add multiple with comma(,) seperated value. e.g. red, orange, blue'); ?></i>
								</td>
							</tr>
							

						</tbody>
					</table>
				
				</div>
				
				<footer class="wp-chatbot-admin-footer">
					<div class="row">
						<div class="text-left col-sm-3 col-sm-offset-3">
							
						</div>
						<div class="text-right col-sm-6">
							<input type="hidden" class="button button-primary" name="qc_bot_str_entity_id" value="<?php echo (int) $id; ?>">
							<input type="submit" class="button button-primary" name="submit" id="submit" value="Update Entity">
						</div>
					</div>
					<!--                    row-->
				</footer>

				</form>
			</div>
		</div>
	</div>
	<?php 
	}
	
	public function stredit(){
		global $wpdb;
		
		$hasEdit = false;
		if(isset($_GET['query']) && $_GET['query']!=''){
			$hasEdit = true;
			$id = sanitize_text_field($_GET['query']);
			$table = $wpdb->prefix.'wpbot_response';
			$data = $wpdb->get_row("select * from $table where 1 and id = '".$id."'");
		}

		$users_answer = isset( $data->users_answer ) ? maybe_unserialize( $data->users_answer ) : array();
		
		$tablecat = $wpdb->prefix.'wpbot_response_category';

		$cats = $wpdb->get_results("select * from $tablecat where 1 and ( custom = '' or custom = '0' )");

		$cat_hierarchy = array();
		if ( ! empty( $cats ) ) {
			foreach ( $cats as $cat ) {
				$cat_hierarchy[] = array( 'id' => $cat->id, 'name' => $cat->name );
				$cat_hierarchy = $this->manage_cat_hierarchy( $cat_hierarchy, $cat->id );
			}
		}
		$allIntents = qc_get_all_intents();
		?>
		<div class="qcwrap">
			<div class="wp-chatbot-wrap">
			<div class="wpbot_dashboard_header container"><h1><?php echo ($hasEdit?'Edit':'Add') ?> <?php echo esc_html('Response'); ?></h1></div>
			<form method="post" action="">
			<div class="wpbot_addons_section container">
			<div class="wpbot_single_addon_wrapper2">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><?php echo esc_html('Query'); ?></th>
						<td>
							<input type="text" name="qc_bot_str_query" value="<?php echo ($hasEdit?$data->query:''); ?>" style="width: 400px;" required />
							<br><i><?php echo esc_html('*Required. Add the query here.'); ?></i>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html('Response'); ?></th>
						<td>	
							
							
							<?php 
							
							$content   = ($hasEdit?$data->response:'');
							$editor_id = 'qc_bot_str_response';
							$settings  = array( );
							 
							wp_editor( $content, $editor_id, $settings );
							
							?>
							
							<br><i><?php echo esc_html('*Required. Add the response here.'); ?></i>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo esc_html('Keyword'); ?></th>
						<td>
							<input type="text" name="qc_bot_str_keyword" value="<?php echo ($hasEdit?$data->keyword:''); ?>" style="width: 400px;" />
							<br><i><?php echo esc_html('Optional. Add multiple keyword or phrases as comma(,) seperated value. It will help to find the best match result.'); ?></i>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html('Category'); ?></th>
						<td>
							
							<select name="qc_bot_str_cate[]" multiple >
								<option value=""> None </option>
								<?php 
								
									if($hasEdit){
										$categories = explode(',', $data->category);
									}

									foreach($cat_hierarchy as $result):
										$result = (object) $result;
										$name = str_replace("&nbsp;", "", $result->name);
										echo '<option value="'.trim( $name ).'" '.($hasEdit && in_array(trim( $name ), $categories)?'selected="selected"':'').' >'.$result->name.'</option>';
									
									endforeach;
								?>
							</select>
							<br><i><?php echo esc_html('Please select categories. You can select multiple category by press CTRL.'); ?></i>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php echo esc_html('Hide this STR from Search'); ?></th>
						<td>
							<input type="checkbox" name="qc_bot_str_hide" value="1" <?php echo ($hasEdit && $data->hidden == 1 ? 'checked="checked"' : ''); ?> />
							<br><i></i>
						</td>
					</tr>

					<?php 
					if( function_exists( 'qcld_wpbotml' ) ):
						$languages = qcld_wpbotml()->languages;
					?>
					<tr valign="top">
						<th scope="row"><?php echo esc_html('Language'); ?></th>
						<td>
							
							<select name="qc_bot_str_lang" >
								
								<?php 
									foreach($languages as $language):
										echo '<option value="'.$language.'" '.($hasEdit && $data->lang==$language?'selected="selected"':'').' >'. qcld_wpbotml()->lanName( $language ) .'</option>';
									endforeach;
								?>
							</select>
							<br><i><?php echo esc_html('Please select a Language.'); ?></i>
						</td>
					</tr>
					<?php endif; ?>
					
					<tr valign="top">
						<th scope="row">Intent</th>
						<td>	
						<input type="text" name="qc_bot_str_intent" value="<?php echo ($hasEdit?$data->intent:''); ?>" style="width: 400px;" />
							<br><i><?php echo esc_html('Optional. Single keyword or Phrase. Leave it empty if you do not need to use this response as a intent. This will add as a custom intent in every intent selection field in wpbot settings. Also the intent can be used as system command to trigger the response.'); ?></i>
						<?php if($hasEdit): ?>

						<input type="hidden" name="qc_bot_str_id" value="<?php echo ($data->id); ?>" />

						<?php endif; ?>
						</td>
					</tr>
					<tr valign="top" style="border-bottom: 1px solid #ddd;">
						<th scope="row"><?php echo esc_html('Follow up Message'); ?></th>
						<td>	
							<?php 
							
							$content   = ($hasEdit?$data->custom:'');
							$editor_id = 'qc_bot_str_follow_up';
							$settings  = array( );
							 
							wp_editor( $content, $editor_id, $settings );
							
							?>
							<br><i><?php echo esc_html('Optional. Follow up message will show after the response.'); ?></i>

						</td>
						
					</tr>
					<tr valign="top" style="border-bottom: 1px solid #ddd;">
						<th scope="row"><a class="button btn-default str_advance_settings"> <?php echo esc_html('Show advance STR Settings'); ?> </a></th>
					</tr>
					<tr valign="top" class="str-hide-advance" style="border-bottom: 1px solid #ddd;">
						<th scope="row"><?php echo esc_html('User Answer Follow Up'); ?></th>
						<td>	
							<div class="users_answer_section" >
								<div id="users_answer_container">
									<?php if ( empty( $users_answer['answer'] ) ) { ?>
									<div class="users_answer_item">
										<input type="text" name="users_answer[answer][]" placeholder="User answers, comma seperated" />

										<select name="users_answer[feedback][]">
											<option value="" >Select an Intent</option>
											<?php 
												foreach($allIntents as $key => $value){
													?>
														<optgroup label="<?php echo $key ?>">
														<?php foreach($value as $val){ ?>
															<option value="<?php echo $val; ?>" ><?php echo $val; ?></option>
														<?php } ?>
														</optgroup>
													<?php
												}
											?>
										</select>

										<span class="users_answer_close">x</span>
									</div>
									<?php } else { 
										
										foreach( $users_answer['answer'] as $key => $answer ) {
										?>
										<div class="users_answer_item">
										<input type="text" name="users_answer[answer][]" placeholder="User answers, Hash(#) seperated" value="<?php echo ( $hasEdit ? esc_attr( $answer ) : '' ); ?>" />

										<select name="users_answer[feedback][]">
											<option value="" >Select an Intent</option>
											<?php 
											//print_r($allIntents);exit;
												foreach($allIntents as $key1 => $value){
													?>
														<optgroup label="<?php echo $key1 ?>">
														<?php foreach( $value as $val ){ ?>
															<option value="<?php echo trim($val); ?>" <?php echo ($hasEdit && isset( $users_answer['feedback'][$key] ) && $users_answer['feedback'][$key] == trim($val) ? 'selected="selected"' : '' ); ?> ><?php echo $val; ?></option>
														<?php } ?>
														</optgroup>
													<?php
												}
											?>
										</select>

										<span class="users_answer_close">x</span>
									</div>
										<?php
										}	
									?>

									<?php } ?>
								</div>
								<a href="#" id="users_answer_add_new" class="button button-secondary">Add More</a>
							</div>
						</td>
					</tr>

					<tr valign="top" class="str-hide-advance" style="border-bottom: 1px solid #ddd;">
						<th scope="row">Select Entity</th>
						<td>	
						<select name="users_answer[entity_name]">
							<option value="" >Select an Intent</option>
							<?php 
								foreach(Qcld_WPBot_Helper::entities() as $key2 => $value2){
									?>
										<optgroup label="<?php echo ucfirst( $key2 ); ?>">
										<?php foreach($value2 as $k => $val){ ?>
											<option value="<?php echo $k; ?>" <?php echo ($hasEdit && isset( $users_answer['entity_name'] ) && $users_answer['entity_name'] == $k ? 'selected="selected"' : '' ); ?> ><?php echo $k; ?></option>
										<?php } ?>
										</optgroup>
									<?php
								}
							?>
						</select>
						<input type="checkbox" name="users_answer[entity_is_required]" value="1" <?php echo ($hasEdit && isset( $users_answer['entity_is_required'] ) && $users_answer['entity_is_required'] == 1 ? 'checked="checked"' : '' ); ?> /> Is Required?
						<input type="text" name="users_answer[prompt_message]" value="<?php echo ($hasEdit && isset( $users_answer['prompt_message'] ) && $users_answer['prompt_message'] !== '' ? $users_answer['prompt_message'] : '' ); ?>" style="width: 400px;" placeholder="Prompt Message"/>
						</td>
					</tr>
					<?php if ( function_exists('qcld_wpbotva') && get_option( 'stt_service' ) == 'microsoft' ) { ?>
					<tr valign="top" class="" style="border-bottom: 1px solid #ddd;">
						<th scope="row">Response Type</th>
						<td>	
						<select name="users_answer[response_type]">
							<option value="1" <?php echo ($hasEdit && isset( $users_answer['response_type'] ) && $users_answer['response_type'] == 1 ? 'selected="selected"' : '' ); ?>>Text response only</option>
							<option value="2" <?php echo ($hasEdit && isset( $users_answer['response_type'] ) && $users_answer['response_type'] == 2 ? 'selected="selected"' : '' ); ?>>Microphone with Textarea</option>
							<option value="3" <?php echo ($hasEdit && isset( $users_answer['response_type'] ) && $users_answer['response_type'] == 3 ? 'selected="selected"' : '' ); ?>>Microphone only</option>
						</select>
						</td>
					</tr>
					<?php } ?>

					<tr valign="top" class="str-hide-advance" style="border-bottom: 1px solid #ddd;">
						<th scope="row">Follow Up Message If User Answer Does not Match</th>
						<td>	

							<?php 
							$content   = ($hasEdit && isset( $users_answer['not_match'] ) ? $users_answer['not_match']:'');
							$editor_id = 'users_answer_not_match';
							$settings  = array( );
							wp_editor( $content, $editor_id, $settings );
							?>
						</td>
					</tr>

					<tr valign="top" class="str-hide-advance" style="display:none">
						<th scope="row">If User Answer Matched, Trigger a STR Intent</th>
						<td>	
							<select id="qc_str_clone_intents" name="users_answer[trigger_intent]">
								<option value="" >Select an Intent</option>
								<?php 
									foreach($allIntents as $key => $value){
										?>
											<optgroup label="<?php echo $key ?>">
											<?php foreach($value as $val){ ?>
												<option value="<?php echo $val; ?>" ><?php echo $val; ?></option>
											<?php } ?>
											</optgroup>
										<?php
									}
								?>
							</select> 
						</td>
					</tr>

					<tr valign="top" class="str-hide-advance">
						<th scope="row">Trigger Another Intent If User Answer not Matched or No User Answer Follow Up</th>
						<td>
							<select name="qc_bot_str_intent_trigger">
								<option value="" >Go to Global Workflow</option>
								<?php 
									foreach($allIntents as $key => $value){
										?>
										<optgroup label="<?php echo $key ?>">
											<?php foreach($value as $val){ ?>
												<option value="<?php echo $val; ?>" <?php echo ($hasEdit && $data->trigger_intent == $val ? 'selected="selected"' : '' ); ?> ><?php echo $val; ?></option>
											<?php } ?>
										</optgroup>
										<?php
									}
								?>
							</select> 
						</td>
					</tr>
					
				</tbody>
			</table>
			</div>
			
			<footer class="wp-chatbot-admin-footer">
				<div class="row">
					<div class="text-left col-sm-3 col-sm-offset-3">
						
					</div>
					<div class="text-right col-sm-6">
						<input type="submit" class="button button-primary" name="submit" id="submit" value="Save Settings">
					</div>
				</div>
				<!--                    row-->
			</footer>


			</div></form>
			</div>
		</div>
		
		<?php 
		
	}
	
}

new Qcld_str_pro();