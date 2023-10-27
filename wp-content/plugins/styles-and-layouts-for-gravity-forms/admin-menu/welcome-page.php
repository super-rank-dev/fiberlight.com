<?php

class Gf_Stla_Welcome_Page {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
	}

	public function register_menu() {

		add_submenu_page( 'stla_licenses', 'Documentation', 'Documentation', 'manage_options', 'stla-documentation', array( $this, 'show_documentation' ) );
		// add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
	}

	function show_documentation() {
		$gf_stla_version = get_plugin_data( GF_STLA_DIR . '/styles-layouts-gravity-forms.php', $markup = true, $translate = true );

		?>

<div class="stla-wel-page-wrap" >
	<div class="stla-wel-header-info">
		<img class="stla-intro-image" src="<?php echo GF_STLA_URL . '/css/images/style&layoutlogo.png'; ?>" />
		<div class="stla-wel-heading-text stla-wel-padding-container">
			<h2 class="stla-welcome-heading">Welcome to Styles & Layouts for Gravity Forms</h2>
			<p >Thank you for choosing Styles & Layout for Gravity Forms - the most used, cost free plugin that let you style Gravity forms without any problem.</p>
		</div>

		<div class="stla-wel-video-section">
			<?php add_thickbox(); ?>

			<a href="https://www.youtube.com/embed/bkiBdaxIPjY?autoplay=1?TB_iframe=true&width=1180&height=750" class="thickbox">
			<img class="" src="<?php echo GF_STLA_URL . '/css/images/video-image.jpg'; ?>" />
			</a>
		</div>

	</div>
	<div class="stla-wel-feature">
		<div class="stla-wel-padding-container">
			<h2> Plugin Features & Addon</h2>
			<p>It comes with 100+ options to customize various parts of gravity form like form wrapper, form header, form title and description, submit button, radio inputs, checkbox inputs, paragraph textarea, labels, section breaks, descriptions, text inputs , dropdown menus, labels, sub labels, placeholders, list fields, confirmation message, error messages and more.
			</p>
			<div class="stla-wel-feature-info-cont">
				<div class="stla-wel-left-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome-feature-icon-1.png'; ?>">
					<h5>100+ Styling options</h5>
					<h6>Easily create an amazing form designs in just a few minutes without writing any code.</h6>
				</div>
				<div class="stla-wel-right-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/preview.png'; ?>">
					<h5>Live Preview Changes</h5>
					<h6>All the changes you make are previed instantly without any need to refresh the page.</h6>
				</div>

				<div class="stla-wel-left-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/responsive.png'; ?>">
					<h5>Responsive Options</h5>
					<h6>Style your form differently for Desktops, Tablets and Mobile devices.</h6>
				</div>
				<div class="stla-wel-right-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/individual-from.png'; ?>">
					<h5>Style Individual Form</h5>
					<h6>Each form can be designed separtely even if they are added into same page</h6>
				</div>

				<div class="stla-wel-left-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/theme.png'; ?>">
					<h5>Compatible with Every Theme</h5>
					<h6>Ability to overwrite default theme styles by making Styles & Layouts design as important.</h6>
				</div>
				<div class="stla-wel-right-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/easy-to-use.png'; ?>">
					<h5>Easy to Use</h5>
					<h6>Easy to use controls like color picker, range slider and ability to give values in px, %, rem, em etc.</h6>
				</div>

				<div class="stla-wel-left-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/flexible.png'; ?>">
					<h5>Flexible</h5>
					<h6>Multiple settings for each field type to create the design you want to have.</h6>
				</div>
				<div class="stla-wel-right-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/customer-service.png'; ?>">
					<h5><a href="https://wpmonks.com/contact-us/?utm_source=dashboard&utm_medium=welcome&utm_campaign=styles_layout_plugin" target="_blank">Premium Support</a></h5>
					<h6>Need custom design, functionality or want to report an issue then get in touch.</h6>
				</div>
				<div class="stla-wel-left-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/recommend.png'; ?>">
					<h5><a href="https://www.gravityforms.com/community/styles-layouts/" target="_blank">Recommended by Gravity Forms</a></h5>
					<h6>Gravity Forms recommend using Styles & Layouts if you don't want to write custom CSS.</h6>
				</div>
				<div class="stla-wel-right-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/addons.png'; ?>">
					<h5><a href="https://wpmonks.com/downloads/addon-bundle/?utm_source=dashboard&utm_medium=welcome&utm_campaign=styles_layout_plugin" target="_blank">Addons With Rich Settings</a></h5>
					<h6>Carefully designed set of addons to make your forms look amazing with minimal effort.</h6>
				</div>
				<div class="stla-wel-left-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/material.png'; ?>">
					<h5><a href="https://wpmonks.com/downloads/material-design/?utm_source=dashboard&utm_medium=welcome&utm_campaign=styles_layout_plugin" target="_blank">Material Design</a></h5>
					<h6>Implement Material design on your form with single click.</h6>
				</div>
				<div class="stla-wel-right-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/bootstrap-icon.png'; ?>">
					<h5><a href="https://wpmonks.com/downloads/gravity-forms-bootstrap-addon/?utm_source=dashboard&utm_medium=welcome&utm_campaign=styles_layout_plugin" target="_blank">Bootstrap</a></h5>
					<h6>Implement Bootstrap design on your form with single click.</h6>
				</div>
				<div class="stla-wel-left-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/field-icons.png'; ?>">
					<h5><a href="http://wpmonks.com/downloads/field-icons/?utm_source=dashboard&utm_medium=welcome&utm_campaign=styles_layout_plugin" target="_blank">Field Icons</a></h5>
					<h6>Add image or fontawesome icons to form fields and position them.</h6>
				</div>
				<div class="stla-wel-right-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/tooltip.png'; ?>">
					<h5><a href="http://wpmonks.com/downloads/tooltips/?utm_source=dashboard&utm_medium=welcome&utm_campaign=styles_layout_plugin" target="_blank">Tooltip</a></h5>
					<h6>Add helpful tips for each form field with a wide range of tooltip icon selection</h6>
				</div>
				<div class="stla-wel-left-cont stla-wel-feature-box">
					<img src="<?php echo GF_STLA_URL . '/css/images/welcome/cs-theme.png'; ?>">
					<h5><a href="http://wpmonks.com/downloads/custom-themes/?utm_source=dashboard&utm_medium=welcome&utm_campaign=styles_layout_plugin" target="_blank">Custom Themes</a></h5>
					<h6>Save your current form theme design and implement it on other forms in one click.</h6>
				</div>
			</div>
		</div>

		<div class="stla-wel-addon-feature stla-wel-padding-container">
			<div class="stla-update-left">
				<h2> Addon Bundle</h2>
				<ul>
					<li><span class="dashicons dashicons-yes"></span> Material Design </li>
					<li><span class="dashicons dashicons-yes"></span> Bootstrap </li>
					<li><span class="dashicons dashicons-yes"></span> Theme Pack </li>
					<li><span class="dashicons dashicons-yes"></span> Tooltips </li>
					<li><span class="dashicons dashicons-yes"></span> Field Icons </li>
					<li><span class="dashicons dashicons-yes"></span> Custom Themes </li>
					<li><span class="dashicons dashicons-yes"></span> Premium Support </li>

				</ul>
			</div>
			<div class="stla-update-right">
				<h2> <span> PRO</span> </h2>
				<div class="stla-wel-addon-price">
					<span class="stla-wel-amount">59.99</span> 
					<br>
					<span  class="stla-wel-term">per year</span>
				</div>
				<a class="stla-wel-btn" href="http://wpmonks.com/downloads/addon-bundle/?utm_source=dashboard&utm_medium=welcome&utm_campaign=styles_layout_plugin">Buy Now</a>
			</div>
		</div>
		<div class="stla-wel-testimonials stla-wel-padding-container">
			<h2> Testimonials </h2>
			<div class="stla-wel-testimonial-block stla-first-test-block">
				<p>
				"I just started using Gravity Forms today because Zoho web forms were not responsive, and our forms looked terrible on mobile devices. So, I bought Gravity Forms with the Zoho Add On. Works great! But, the form was really difficult to design. I looked for help, and found this plugin. Styles and Layouts Gravity Forms really helped make the forms look good on any device. I highly recommend this plugin, especially for first time Gravity Forms users."<span class="stla-testimonial-author"> -ltcshop</span>
				</p>
			</div>
			<div class="stla-wel-testimonial-block">
				<p>
				"Currently using this on a few sites. Haven’t had any significant issues, and developer was very responsive when I suggested an improvement. It’s a great time-saver."<span class="stla-testimonial-author"> -ebeacon</span>
				</p>
			</div>
		</div>

		<div class="sk-donate-cont stla-wel-padding-container">
			<div class="stla-wel-btn-wrapper">
				<div class="stla-wel-left-cont">
					<a href="https://paypal.me/wpmonks" class="stla-wel-btn stla-wel-btn-block"> Donate to Support Plugin</a>
				</div>
				<div class="stla-wel-right-cont"> 
					<a href="https://twitter.com/wp_monk" class="stla-wel-btn stla-wel-btn-custom"> 
						<span class="stla-wel-custom-btn-text"> Follow us on Twitter 
							<span class="dashicons dashicons-arrow-right"></span>  
						<span> 
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="stla-wel-review-cont" style="background:url('<?php echo GF_STLA_URL . '/css/images/suggestions.jpg'; ?>')">
		<div class="stla-wel-padding-container">
			<div class="stla-update-left">
				<h2> Let us Know your Suggestions.</h2>
				<p>
				Your suggestion and reviews are valuable for us. Let us know if you have any problem with plugin.
				</p>
				<a class="stla-wel-btn stla-wel-btn-space" href="https://wpmonks.com/contact-us/?utm_source=dashboard&utm_medium=welcome&utm_campaign=styles_layout_plugin">Contact Us</a>
			</div>
		</div>
	</div>
</div>
		<?php
	}
}

new Gf_Stla_Welcome_Page();
