<?php
// this is where we put custom functions for this specific build

//Custom gravity forms ajax spinner
add_filter("gform_ajax_spinner_url", "solera_spinner", 10, 2);
function solera_spinner($image_src, $form) {
    return get_template_directory_uri() ."/img/spinner.svg";
}

//Add column break field to Gravity Forms. Makes it easy to layout forms in unique columns (See Ivy Residences footer).
if(!class_exists('GF_Multi_Column')) {
	class GF_Multi_Column {

		public static $version = '1.0.0';


		public static function init() {
			add_action('init', array('GF_Multi_Column', 'register_gf_field_column'), 20);
			add_action('gform_field_standard_settings', array('GF_Multi_Column', 'add_gf_field_column_settings'), 10, 2);
			add_filter('gform_field_container', array('GF_Multi_Column', 'filter_gf_field_column_container'), 10, 6);
			add_filter('gform_pre_render', array('GF_Multi_Column', 'filter_gf_multi_column_pre_render'), 10, 3);
			add_action('gform_enqueue_scripts', array('GF_Multi_Column', 'enqueue_gf_multi_column_scripts'), 10, 2);
		}


		public static function register_gf_field_column() {
			if(!class_exists('GFForms') || !class_exists('GF_Field_Column')) return;
			GF_Fields::register(new GF_Field_Column());
		}


		public static function add_gf_field_column_settings($placement, $form_id) {
			if($placement == 0) {
				$description = 'Column breaks should be placed between fields to split form into separate columns. You do not need to place any column breaks at the beginning or end of the form, only in the middle.';
				echo '<li class="column_description field_setting">'.$description.'</li>';
			}
		}


		public static function filter_gf_field_column_container($field_container, $field, $form, $css_class, $style, $field_content) {
			if(IS_ADMIN) return $field_container;
			if($field['type'] == 'column') {
				$column_index = 2;
				foreach($form['fields'] as $form_field) {
					if($form_field['id'] == $field['id']) break;
					if($form_field['type'] == 'column') $column_index++;
				}
				return '</ul><ul class="'.GFCommon::get_ul_classes($form).' column column_'.$column_index.' '.$field['cssClass'].'">';
			}
			return $field_container;
		}


		public static function filter_gf_multi_column_pre_render($form, $ajax, $field_values) {
			$column_count = 0;
			$prev_page_field = null;
			foreach($form['fields'] as $field) {
				if($field['type'] == 'column') {
					$column_count++;
				} else if($field['type'] == 'page') {
					if($column_count > 0 && empty($prev_page_field)) {
						$form['firstPageCssClass'] = trim((isset($field['firstPageCssClass']) ? $field['firstPageCssClass'] : '').' gform_page_multi_column gform_page_column_count_'.($column_count + 1));
					} else if($column_count > 0) {
						$prev_page_field['cssClass'] = trim((isset($prev_page_field['cssClass']) ? $prev_page_field['cssClass'] : '').' gform_page_multi_column gform_page_column_count_'.($column_count + 1));
					}
					$prev_page_field = $field;
					$column_count = 0;
				}
			}
			if($column_count > 0 && empty($prev_page_field)) {
				$form['cssClass'] = trim((isset($form['cssClass']) ? $form['cssClass'] : '').' gform_multi_column gform_column_count_'.($column_count + 1));
			} else if($column_count > 0) {
				$prev_page_field['cssClass'] = trim((isset($prev_page_field['cssClass']) ? $prev_page_field['cssClass'] : '').' gform_page_multi_column gform_page_column_count_'.($column_count + 1));
			}
			return $form;
		}


		public static function enqueue_gf_multi_column_scripts($form, $ajax) {
			if(!get_option('rg_gforms_disable_css')) {
				wp_enqueue_style('gforms_multi_column_css', plugins_url('gravityforms-multi-column.css', __FILE__), null, self::$version);
			}
		}


	}
	GF_Multi_Column::init();
}


if(!class_exists('GF_Field_Column') && class_exists('GF_Field')) {
	class GF_Field_Column extends GF_Field {

		public $type = 'column';

		public function get_form_editor_field_title() {
			return esc_attr__('Column Break', 'gravityforms');
		}

		public function is_conditional_logic_supported() {
			return false;
		}

		function get_form_editor_field_settings() {
			return array(
				'column_description',
				'css_class_setting'
			);
		}

		public function get_field_input($form, $value = '', $entry = null) {
			return '';
		}

		public function get_field_content($value, $force_frontend_label, $form) {

			$is_entry_detail = $this->is_entry_detail();
			$is_form_editor = $this->is_form_editor();
			$is_admin = $is_entry_detail || $is_form_editor;

			if($is_admin) {
				$admin_buttons = $this->get_admin_buttons();
				return $admin_buttons.'<label class=\'gfield_label\'>'.$this->get_form_editor_field_title().'</label>{FIELD}<hr>';
			}

			return '';
		}

	}
}
function displayStory($id, $size, $style = '') {
	
		if ( class_exists('WPSEO_Primary_Term') ){
			// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			$wpseo_primary_term = new WPSEO_Primary_Term( 'Solution', $id );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			$termName = $term->name;
			$termID = $term->term_id;
		} 
		else {
		// Default, display the first category in WP's list of assigned categories
		$terms = wp_get_object_terms($id, 'Solution');
		
		if(!empty($terms)){
			foreach($terms as $term){
				$termName = $term->name;
				$termID = $term->term_id;
			}
		}
	}
	


?>
	<div class="story <?= $size; ?>" style="background-image:url('<?= get_field('tile_image', $id)['sizes']['success-story']; ?>'); <?= $style; ?>" onclick="javascript:window.location.href='<?= get_the_permalink($id); ?>'">

		<?php if ( $termName ) : ?>
			<div class="solution">
				<div class="hold-me">
					<?= $termName; ?>
					
					<div class="icon">
						
						<img src="<?= get_field('icon','term_' . $termID); ?>">
					</div>
				</div>
				
			</div>
		<?php endif; ?>
		
		<div class="info">
			
			<div class="hold-me">
				<h4>
					<?= get_field('client_name', $id); ?> <?= $exampleName; ?>
				</h4>
				<h3>
					<?= get_the_title($id); ?>
				</h3>
				<? the_field('short_description', $id); ?>
				<a href="<?= get_the_permalink($id); ?>" class="button">
					Learn More
				</a>
			</div>
		
			
		</div>
	</div>
<?php
}

function displayResource($id) {
    $title = get_the_title($id);
    $content = get_field('content', $id);
    $link = get_field('file', $id);
    $image = get_field('image', $id);
    
    ?>
    
    <div class="resource-tile">
        <div class="hold-me">
            <?php if ($image) : ?>
                <div class="image" style="background-image: url('<?php echo $image['sizes']['blog-post']; ?>;);" alt="<?php echo $image['alt']; ?>"></div>
            <?php endif; ?>
            <div class="content">
                <h5><?php echo $title; ?></h5>
                <p><?php echo wp_trim_words( $content, 22, '...' ); ?></p>
                <a target="_blank" href="<?php echo $link['url']; ?>" class="button tertiary">
                    Download Now
                </a>
            </div>
        </div>
    </div>
<?php
}

function displayResource2($id, $id2) {
    $title = get_the_title($id);
    $content = get_field('content', $id);
    $link = get_field('file', $id);
    $image = get_field('image', $id);
    
    $title2 = get_the_title($id2);
    $content2 = get_field('content', $id2);
    $link2 = get_field('file', $id2);
    $image2 = get_field('image', $id2);
    
    ?>
    
    <div class="resource-tile">
        <div class="hold-me">
            <?php if ($image) : ?>
                <div class="image" style="background-image: url('<?php echo $image['sizes']['blog-post']; ?>" alt="<?php echo $image['alt']; ?>"></div>
            <?php endif; ?>
            <div class="content">
                <h5><?php echo $title; ?></h5>
                <p><?php echo wp_trim_words( $content, 22, '...' ); ?></p>
                <a target="_blank" href="<?php echo $link['url']; ?>" class="button tertiary">
                    Download Now
                </a>
            </div>
        </div>
    </div>
    
    <div class="resource-tile resource-tile-2">
        <div class="hold-me">
            <?php if ($image2) : ?>
                <div class="image" style="background-image: url('<?php echo $image2['sizes']['blog-post']; ?>" alt="<?php echo $image2['alt']; ?>"></div>
            <?php endif; ?>
            <div class="content">
                <h5><?php echo $title2; ?></h5>
                <p><?php echo wp_trim_words( $content2, 22, '...' ); ?></p>
                <a target="_blank" href="<?php echo $link2['url']; ?>" class="button tertiary">
                    Download Now
                </a>
            </div>
        </div>
    </div>
<?php
}

function get_previous_post_id( $post_id ) {
    // Get a global post reference since get_adjacent_post() references it
    global $post;
    // Store the existing post object for later so we don't lose it
    $oldGlobal = $post;
    // Get the post object for the specified post and place it in the global variable
    $post = get_post( $post_id );
    // Get the post object for the previous post
    $previous_post = get_previous_post();
    // Reset our global object
    $post = $oldGlobal;
    if ( '' == $previous_post ) 
        return 0;
    return $previous_post->ID; 
} 

function get_next_post_id( $post_id ) {
    // Get a global post reference since get_adjacent_post() references it
    global $post;
    // Store the existing post object for later so we don't lose it
    $oldGlobal = $post;
    // Get the post object for the specified post and place it in the global variable
    $post = get_post( $post_id );
    // Get the post object for the next post
    $next_post = get_next_post();
    // Reset our global object
    $post = $oldGlobal;
    if ( '' == $next_post ) 
        return 0;
    return $next_post->ID; 
} 

//Add active class to menu on single custom posts.
add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );
	
function add_current_nav_class($classes, $item) {
	
	// Getting the current post details
	global $post;
	
	// Getting the post type of the current post
	$current_post_type = get_post_type_object(get_post_type($post->ID));
	$current_post_type_slug = $current_post_type->rewrite[slug];
		
	// Getting the URL of the menu item
	$menu_slug = strtolower(trim($item->url));
	
	// If the menu item URL contains the current post types slug add the current-menu-item class
	if (strpos($menu_slug,$current_post_type_slug) !== false) {
	
	   $classes[] = 'current-menu-item';
	
	}
	
	// Return the corrected set of classes to be added to the menu item
	return $classes;

}
//Add active class to menu on single blog posts.
function add_custom_class($classes=array(), $menu_item=false) {
    if ( !is_page() && 'Blog' == $menu_item->title && 
            !in_array( 'current-menu-item', $classes ) ) {
        $classes[] = 'current-menu-item';        
    }                    
    return $classes;
}
add_filter('nav_menu_css_class', 'add_custom_class', 100, 2); 

/********
 * Savings Calculator
 * ******/
 function all_savings_calculator() {
	 if (is_page('Savings Calculator') || is_page('Savings Calculator (Internal Use)')) :
	
		//Temporary hack, because form ID's are all messed up, and it's a pain...
		//$savings_form_id = get_field('savings_form_id', 'options');
		
		//Savings Calculator - adjust anchor
		add_filter( 'gform_confirmation_anchor', '__return_false' );
		
		//Savings Calculator - add read only to fields
		add_filter( 'gform_pre_render', 'add_readonly_script' );
		function add_readonly_script( $form ) {
		    ?>
		 
		    <script type="text/javascript">
		        jQuery(document).ready(function(){
		            /* apply only to a input with a class of gf_readonly */
		            jQuery("li.static-field input").attr("readonly","readonly");
		            jQuery("li.savings-total input").attr("readonly","readonly");
		            
		            jQuery(".gf_step_last").after('<div id="gf_step_3_4" class="gf_step"><span class="gf_step_number">4</span>&nbsp;<span class="gf_step_label">Savings Results</span></div>');
		        });
		    </script>
		 
		    <?php
		    return $form;
		}
		
		
		//Savings Calculator - add content to first page of form
		add_action( 'gform_enqueue_scripts', 'savings_stats_content_first', 10, 3 );
		function savings_stats_content_first( ) {
		    	$step = 'basic_info';
		    	include( locate_template( '/includes/calculator/step-content.php', false, false ) ); 
		}
		//Savings Calculator - add content to each page of form
		add_action( 'gform_post_paging', 'savings_stats_content', 10, 3 );
		function savings_stats_content( $form, $source_page_number, $current_page_number ) {
			//logic
		    if ( $current_page_number == 2 ) {
		    	remove_action( 'gform_enqueue_scripts', 'savings_stats_content_first', 10, 3 );
		    	$step = 'cloud_provider';
		    	include( locate_template( '/includes/calculator/step-content.php', false, false ) ); 
		    }
		    elseif ( $current_page_number == 3 ) {
		    	remove_action( 'gform_enqueue_scripts', 'savings_stats_content_first', 10, 3 );
		    	$step = 'data_transfer';
		    	include( locate_template( '/includes/calculator/step-content.php', false, false ) ); 
		    }
		}
	endif;
}
add_action( 'wp_head', 'all_savings_calculator' );