<?php

class Stla_Addons_Page {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
	}

	public function register_menu() {

		add_submenu_page(  'stla_licenses', 'Add-Ons', 'Add-Ons', 'manage_options', 'stla-addons', array( $this, 'show_addons' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );


	}

	public function add_scripts() {
		wp_enqueue_style( 'stla-admin-css', GF_STLA_URL.'/css/customizer-controls.css', '', GF_STLA_VERSION );
	}

	public function show_addons() {

?>
		 <div class="wrap">
	

		<h2>Addons </h2>
		<p> You can use below addons to extend the functionality of Styles layouts for Gravity Forms</p>
		<br/>
	<div class="stla-layout-cont-left">
		<div class="stla-extend stla-box">
		<img src="<?php echo GF_STLA_URL; ?>/css/images/addon-bundle.jpg">
		<h2>Addon Bundle</h2>
		<div class="stla-extend-content">
		<p>Get all the addons at a special discounted price</p>
		<div class="stla-addon-list">
			<p class="stla-bndle-text">Addons included in bundle:</p>
			<ul>
				<li>Material Design</li>
				<li>Theme Pack</li>
				<li>Field Icons</li>
				<li>Custom Themes</li>
				<li>Bootstrap</li>
			</ul>
		</div>
		<div class="stla-extend-buttons">
		<a href="https://wpmonks.com/downloads/addon-bundle/?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" class="button-secondary nf-doc-button">Documentation</a>
		<a href="https://wpmonks.com/downloads/addon-bundle/?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" title="Conditional Logic" class="button-primary nf-button">Learn More</a>
		</div>
		</div>
		</div> <!-- End Stla Box -->
	</div>
	<div class="stla-layout-cont-right">
		<div class="stla-extend stla-box">
		<img src="<?php echo GF_STLA_URL; ?>/css/images/material-design.jpg">
		<h2>Material Design</h2>
		<div class="stla-extend-content">
		<p>Apply material design on forms with signle click</p>
		<div class="stla-extend-buttons">
		<a href="https://wpmonks.com/downloads/material-design/?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" class="button-secondary nf-doc-button">Documentation</a>
		<a href="https://wpmonks.com/downloads/material-design/?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" title="Conditional Logic" class="button-primary nf-button">Learn More</a>
		</div>
		</div>
		</div> <!-- End Stla Box -->
		
		<div class="stla-extend stla-box">
		<img src="<?php echo GF_STLA_URL; ?>/css/images/theme-pack.jpg">
		<h2>Theme Pack</h2>
		<div class="stla-extend-content">
		<p>Get beautifully crafted theme pack that will let you design your forms in seconds without any hassles</p>
		<div class="stla-extend-buttons">
		<a href="https://wpmonks.com/downloads/theme-pack/?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" class="button-secondary nf-doc-button">Documentation</a>
		<a href="https://wpmonks.com/downloads/theme-pack/?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" title="Conditional Logic" class="button-primary nf-button">Learn More</a>
		</div>
		</div>
		</div> <!-- End Stla Box -->


		<div class="stla-extend stla-box stla-admin-field-icons">
		<img src="<?php echo GF_STLA_URL; ?>/css/images/field-icons.jpg">
		<h2>Field Icons</h2>
		<div class="stla-extend-content">
		<p>Add icons inside form fields</p>
		<div class="stla-extend-buttons">
		<a href="https://wpmonks.com/downloads/field-icons?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" class="button-secondary nf-doc-button">Documentation</a>
		<a href="https://wpmonks.com/downloads/field-icons?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" title="Conditional Logic" class="button-primary nf-button">Learn More</a>
		</div>
		</div>
		</div> <!-- End Stla Box -->



		<div class="stla-extend stla-box">
		<img src="<?php echo GF_STLA_URL; ?>/css/images/custom-themes.jpg">
		<h2>Custom Themes</h2>
		<div class="stla-extend-content">
		<p>Save you current form style as theme and apply it on other forms</p>
		<div class="stla-extend-buttons">
		<a href="https://wpmonks.com/downloads/custom-themes?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" class="button-secondary nf-doc-button">Documentation</a>
		<a href="https://wpmonks.com/downloads/custom-themes?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" title="Conditional Logic" class="button-primary nf-button">Learn More</a>
		</div>
		</div>
		</div> <!-- End Stla Box -->



		

		<div class="stla-extend stla-box">
		<img src="<?php echo GF_STLA_URL; ?>/css/images/Bootstrap.png">
		<h2>Bootstrap</h2>
		<div class="stla-extend-content">
		<p>Easily add bootstrap to your forms</p>
		<div class="stla-extend-buttons">
		<a href="https://wpmonks.com/downloads/gravity-forms-bootstrap-addon/?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" class="button-secondary nf-doc-button">Documentation</a>
		<a href="https://wpmonks.com/downloads/gravity-forms-bootstrap-addon/?utm_source=dashboard&utm_medium=addons_menu&utm_campaign=styles_layout_plugin" target="_blank" title="Conditional Logic" class="button-primary nf-button">Learn More</a>
		</div>
		</div>
		</div> <!-- End Stla Box -->
		</div>
		 </div>
	<?php
	}



}

add_action( 'plugins_loaded', 'stla_addons_page' );

function stla_addons_page() {
	new Stla_Addons_Page();

}