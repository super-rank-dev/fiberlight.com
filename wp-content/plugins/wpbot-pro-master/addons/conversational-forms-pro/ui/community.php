<div class="qcformbuilder-editor-header">
	<ul class="qcformbuilder-editor-header-nav">
		<li class="qcformbuilder-editor-logo">
			<span class="dashicons-wfb-logo"></span>
			<?php echo __('Chatbot Form Builder', 'qcformbuilder-forms'); ?>
		</li>
		
	</ul>
</div>

<div class="qcformbuilder-editor-header qcformbuilder-editor-subnav">
	<ul class="qcformbuilder-editor-header-nav ajax-trigger" data-load-class="spinner" data-request="<?php echo WFBCORE_EXTEND_URL . 'channels/community/?version=' . WFBCORE_VER; ?>" data-target="#main-cat-nav" data-target-insert="append" data-template="#nav-items-tmpl" data-event="loadchannels" data-autoload="true" id="main-cat-nav" >
	</ul>
</div>
<div class="form-extend-page-wrap" id="form-extend-viewer" style="visibility:visible;"></div>

<?php
	do_action('qcformbuilder_forms_admin_templates');
?>

<script type="text/javascript">

function wfb_clear_panel(el){
	jQuery(jQuery(el).data('target')).empty();
}
jQuery(function($){
	$('.qcformbuilder-editor-header').on('click', '.qcformbuilder-editor-header-nav a', function(e){
		e.preventDefault();

		var clicked = $(this);

		// remove active tab
		$('.qcformbuilder-editor-header-nav li').removeClass('active');

		// hide all tabs
		$('.form-extend-page-wrap').hide();

		// show new tab
		$( clicked.attr('href') ).show();

		// set active tab
		clicked.parent().addClass('active');

	});

})

</script>