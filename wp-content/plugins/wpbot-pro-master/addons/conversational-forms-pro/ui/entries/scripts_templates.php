<?php
if( ! defined( 'ABSPATH' ) ){
	exit;
}
?>
<script type="text/javascript">
	var init_wfb_baldrick;
	var perPage = jQuery('#wfb-entries-list-items').val();
	function wfb_set_limits( el ){
		jQuery( el ).data('perpage', perPage );
	}

	function wfb_refresh_view(obj){

		jQuery('.entry_count_' + obj.params.trigger.data('form')).html(obj.rawData.total);
		jQuery('.status_toggles[data-status="trash"] .current-status-count').html(obj.rawData.trash);
		jQuery('.status_toggles[data-status="active"] .current-status-count').html(obj.rawData.total);
		if(obj.rawData.undo === obj.params.trigger.data('panel')){
			obj.params.trigger.closest('tr').addClass('wfb-deleted-row');
		}else{
			obj.params.trigger.closest('tr').removeClass('wfb-deleted-row');
		}
		obj.params.trigger.data('do', obj.rawData.undo).html(obj.rawData.undo_text).removeClass('disabled');
	}

	function setup_pagination(obj){

		var total			= obj.rawData.total,
			trash			= obj.rawData.trash,
			active			= obj.rawData.active,
			toggles			= jQuery('.status_toggles'),
			exporter		= jQuery('.qcformbuilder-entry-exporter'),
			tense			= ( total === 1 ? ' <?php _e('item'); ?>' : ' <?php _e('items'); ?>' ),
			pages			= obj.rawData.pages,
			current			= obj.rawData.current_page,
			form			= obj.params.trigger.data('form'),
			status			= obj.params.trigger.data('status'),
			pagenav			= jQuery('.qcformbuilder-table-nav'),
			page_links		= pagenav.find('.pagination-links'),
			entries_total	= pagenav.find('.displaying-num'),
			pages_total		= pagenav.find('.total-pages'),
			current_display	= pagenav.find('.current-page'),
			first_page		= pagenav.find('.first-page'),
			prev_page		= pagenav.find('.prev-page'),
			next_page		= pagenav.find('.next-page'),
			last_page		= pagenav.find('.last-page'),
			form_trigger	= jQuery('.form_entry_row.highlight').find('.form-entry-trigger'),
			bulk_actions	= jQuery('#wfb_bulk_action'),
			bulk_template	= jQuery('#bulk-actions-'+status+'-tmpl').html(),
			entry_count		= jQuery('.entry_count_' + form);

		obj.params.trigger.data('page', current);
		form_trigger.data('status', status);
		bulk_actions.html(bulk_template);

		toggles.removeClass('button-primary').removeClass('disabled');
		toggles.filter('[data-status="'+status+'"]').addClass('button-primary');
		toggles.each(function(k,v){
			var el = jQuery(v);
			if(typeof obj.rawData[el.data('status')] === 'number'){
				if(obj.rawData[el.data('status')] > 0){
					el.find('.current-status-count').html(obj.rawData[el.data('status')]);
				}else{
					el.find('.current-status-count').html('');
				}
			}
		});
		// update count
		entry_count.html(active);
		//bulk-actions-active-tmpl

		// add form id to toggles
		toggles.data('form', form)
		pagenav.data('total', pages);

		if(pages <= 1){
			page_links.hide();
		}else{
			page_links.show();
		}
		exporter.find('.qcformbuilder-forms-entry-exporter').attr('href', 'admin.php?page=qcformbuilder-forms&export=' + form);
		exporter.show();
		pagenav.show();
		page_links.find('a').removeClass('disabled');

		// setup values
		page_links.data('total', total);
		entries_total.html(total + tense);
		pages_total.html(pages);
		current_display.val(current);

		if(current === 1){
			first_page.addClass('disabled');
			prev_page.addClass('disabled');
		}else if(current === pages){
			last_page.addClass('disabled');
			next_page.addClass('disabled');
		}

		jQuery( 'html, body').animate({
			scrollTop: 0
		}, 250 );


		init_wfb_baldrick();
		jQuery( window ).trigger('resize');
	}

	jQuery(function($){

		init_wfb_baldrick = function(){
			$('.cfajax-trigger').baldrick({
				before			: function(el, ev){

					var form	=	$(el),
						buttons = 	form.find(':submit');
					ev.preventDefault();
					if( form.is( 'form' ) ){

						var validate = form.parsley({
							errorsWrapper : '<span class="help-block qcformbuilder_ajax_error_block"></span>',
							errorTemplate : '<span></span>'
						});

						if( !validate.isValid() ){
							$(window).trigger('resize');
							return false;
						}
					}
				},
				callback : function( obj ){
					var form;
					if( obj.params.trigger.is( 'form' ) ){
						form = obj.params.trigger;
					}else{
						form = obj.params.target.find( 'form.qcformbuilder_forms_form' );
					}
					if( form.length ){
						var validate = form.parsley({
							errorsWrapper : '<span class="help-block qcformbuilder_ajax_error_block"></span>',
							errorTemplate : '<span></span>'
						});
					}
					calders_forms_init_conditions();

				}
			});

			window.Parsley.on('field:validated', function() {
				setTimeout( function(){ $(window).trigger('resize') }, 10 );
			});
		}

		function do_page_navigate(el){

			var clicked 		= $(el);

			if(clicked.hasClass('disabled')){
				return;
			}

			var	form_trigger	= $('.form_entry_row.highlight').find('.form-entry-trigger'),
				current			= parseInt(form_trigger.data('page')),
				pagenav			= jQuery('.qcformbuilder-table-nav'),
				page_links		= pagenav.find('.pagination-links'),
				total			= parseInt(pagenav.data('total')),
				perpage         = parseInt( $( '#wfb-entries-list-items' ).val() );


			if(clicked.data('page') === 'first'){
				form_trigger.data('page', 1).trigger('click');
			}else if(clicked.data('page') === 'prev'){
				var next = current - 1;
				form_trigger.data('page', next).trigger('click');
			}else if(clicked.data('page') === 'next'){
				var next = current + 1;
				form_trigger.data('page', next).trigger('click');
			}else if(clicked.data('page') === 'last'){
				form_trigger.data('page', total).trigger('click');
			}else{
				form_trigger.data('page', clicked.val()).trigger('click');
			}
		}

		$( document ).on('change','.current-page', function(e){
			do_page_navigate(this);
		});
		$( document ).on('click','.pagination-links a', function(e){
			e.preventDefault();
			do_page_navigate(this);
		});
		$( document ).on('cf.add cf.remove cf.enable cf.disable', function(){
			$(window).trigger('resize');
		});
	});

	function wfb_clear_panel(el){
		jQuery(jQuery(el).data('target')).empty();
	}

	var ready_limit_change;
	jQuery(document).on('change', '#wfb-entries-list-items', function(){
		perPage = jQuery( this ).val();

		if( ready_limit_change ){
			clearTimeout( ready_limit_change );
		}
		ready_limit_change = setTimeout( function(){
			jQuery('.status_toggles.button-primary').trigger('click');
		}, 280 );

	});


	jQuery(function($){

		$('body').on('change', '.wfb-bulkcheck', function(){

			var checked = $(this),
				parent = checked.closest('.wfb-table-viewer'),
				checks = parent.find('.wfb-entrycheck'),
				action = $('#wfb_bulk_action');

			checks.prop('checked', checked.prop('checked'));

		});

		$('body').on('change', '.wfb-entrycheck', function(){

			var checkall	= $('.wfb-bulkcheck'),
				allchecks	= $('.wfb-entrycheck'),
				checked 	= $('.wfb-entrycheck:checked');

			if(allchecks.length != checked.length){
				checkall.prop('checked', false);
			}else{
				checkall.prop('checked', true);
			}

		});
		$('body').on('click', '.wfb-bulk-action', function(){

			var action 		= $('#wfb_bulk_action'),
				bulkCheck 	= $('.wfb-bulkcheck'),
				nonce 		= $('#wfb_toolbar_actions'),
				referer		= nonce.parent().find('[name="_wp_http_referer"]');

			if( !action.val().length){
				return;
			}

			action.prop('disabled', true);
			var checks 	= $('#form-entries-viewer .wfb-entrycheck:checked'),
				form	= $('#form-entries-viewer .list.form-panel').data('form');

			if(checks.length){

				var list = [],
					rows = [];
				for( var i = 0; i<checks.length; i++){
					list.push(checks[i].value);
					rows.push('#entry_row_' + checks[i].value);
				}
				var row_items = $(rows.join(','));

				var data = {
					'action'	:	'wfb_bulk_action',
					'do'		:	action.val(),
					'items'		:	list,
					'form'		:	form,
					'wfb_toolbar_actions' : nonce.val(),
					'_wp_http_referer' : referer.val()
				}

				row_items.animate({"opacity": .4}, 500);
				$.post(ajaxurl, data, function(res){
					if(res.status && res.entries && res.total){
						row_items.remove();
						$('.entry_count_' + form).html(res.total);
						$('input.current-page').trigger('change');
					}else if(res.url){
						row_items.animate({"opacity": 1}, 500);
						window.location = res.url;
					}else if(res.status === 'reload'){
						$('input.current-page').trigger('change');
					}
					action.val('').prop('disabled', false);
					bulkCheck.prop('checked', false);
				});
			}else{
				action.prop('disabled', false);
			}

		});

	});

</script>

<script type="text/html" id="forms-list-alt-tmpl">

	{{#if entries}}
	<div class="list form-panel postbox" data-form="{{form}}">
		<table class="table table-condensed wfb-table-viewer">
			<thead>
			<tr>
				<th style="width:16px;"><input type="checkbox" class="wfb-bulkcheck"></th>
				<th><?php esc_html_e('ID', 'qcformbuilder-forms' ); ?></th>
				<th><?php esc_html_e('Submitted', 'qcformbuilder-forms' ); ?></th>
				{{#each fields}}
				<th>{{this}}</th>
				{{/each}}
				<th style="width: 100px;"></th>
			</tr>
			</thead>
			<tbody>
			{{#if entries}}
			{{#each entries}}
			<tr id="entry_row_{{_entry_id}}">
				<td style="width:16px;"><input type="checkbox" class="wfb-entrycheck" value="{{_entry_id}}"></td>
				<td>{{_entry_id}}</td>
				<td>{{_date}}</td>
				{{#each data}}
				<td>{{#if label}}{{value}}{{else}}{{{this}}}{{/if}}</td>
				{{/each}}
				<td style="text-align: right; width: 100px;white-space: nowrap;">
					<?php
						do_action('qcformbuilder_forms_entry_actions');
					?>
				</td>
			</tr>
			{{/each}}
			{{else}}
			<tr><td colspan="100"><?php esc_html_e('No entries found', 'qcformbuilder-forms' ); ?></td></tr>
			{{/if}}
			</tbody>
		</table>
	</div>
	{{else}}
	<p class="description"><?php esc_html_e('No entries yet.', 'qcformbuilder-forms' ); ?></p>
	{{/if}}
</script>

<script type="text/html" id="view-entry-tmpl">
	{{#if user}}
	<div class="user-avatar user-avatar-{{user/ID}}"{{#if user/name}} title="{{user/name}}"{{/if}} style="margin-top:-1px;">
	{{{user/avatar}}}
	</div>
	{{/if}}

	<div id="main-entry-panel" class="tab-detail-panel" data-tab="<?php esc_html_e('Entry', 'qcformbuilder-forms' ); ?>">
		<h4>
			<?php  esc_html_e('Submitted', 'qcformbuilder-forms' ); ?> <small class="description">{{date}}</small>
		</h4>
		<hr>
		{{#each data}}
		<div class="entry-line">
			<label>{{label}}</label>
			<div>{{#if view/label}}{{view/value}}{{else}}{{{view}}}{{/if}}&nbsp;</div>
		</div>
		{{/each}}
	</div>


	{{#if meta}}
	{{#each meta}}
	<div id="meta-{{@key}}" data-tab="{{name}}" class="tab-detail-panel">
		<h4>{{name}}</h4>
		<hr>
		{{#unless template}}
		{{#each data}}
		{{#if title}}
		<h4>{{title}}</h4>
		{{/if}}
		{{#each entry}}
		<div class="entry-line">
			<label>{{meta_key}}</label>
			<div>{{{meta_value}}}&nbsp;</div>
		</div>
		{{/each}}
		{{/each}}
		{{/unless}}
		<?php do_action('qcformbuilder_forms_entry_meta_templates'); ?>
	</div>
	{{/each}}
	{{/if}}

</script>