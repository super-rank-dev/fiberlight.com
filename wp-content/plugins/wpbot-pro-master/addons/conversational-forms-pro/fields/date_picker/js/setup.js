
jQuery(function($){

	$('.qcformbuilder-editor-body').on('keyup', '.cfdatepicker-set-format', function(){
		var format_field	= $(this),
			default_field	= format_field.closest('.qcformbuilder-config-field-setup').find('.is-cfdatepicker');

		default_field.data('date-format', format_field.val());

		default_field.cfdatepicker('remove');

	});

});









