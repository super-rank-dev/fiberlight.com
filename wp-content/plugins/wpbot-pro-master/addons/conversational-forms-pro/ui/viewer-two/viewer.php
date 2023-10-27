<?php
if( ! defined( 'ABSPATH' ) ){
	exit;
}
?>


<script type="text/html" id="qcformbuilder-forms-entry-tmpl">
	<div v-bind="{'data-remodal-id': entry.id }" class="qcformbuilder-forms-entry-viewer">
		<button data-remodal-action="close" class="remodal-close"  title="<?php esc_attr_e( 'Click To Close', 'qcformbuilder-forms' ); ?>" v-on:click="close" ></button>

		<div class="qcformbuilder-forms-entry-left">

		</div>
		<div class="qcformbuilder-forms-entry-right">
			<ul v-for="field in fields">
				<li class="entry-detail">
					<span class="entry-label">{{field.label}}</span> <div class="entry-content">{{ fieldValue( field.id, entry ) }}</div>

				</li>
			</ul>
		</div>

	</div>
</script>

<div id="qcformbuilder-forms-entries">
	<div class="qcformbuilder-table" v-cloak>
		<table class="table table-striped">
			<thead>
				<tr>
					<th v-for="field in form.listFields">
						{{field.label}}
					</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(entry, id) in entries.entries">
					<td v-for="field in form.listFields">
						{{ fieldValue( field.id, entry ) }}
					</td>
					<td>
						<a class="btn btn-default qcformbuilder-forms-entry-viewer-btn qcformbuilder-forms-entry-viewer-details-btn" role="button" href="#" title="<?php esc_html_e( 'View Entry Details', 'qcformbuilder-forms' ); ?>" @click="showSingle(id)" >
							<?php esc_html_e( 'Details', 'qcformbuilder-forms' ); ?>
						</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="qcformbuilder-forms-entries-nav" role="navigation">
		<a href="#" v-on:click.prevent="prevPage" class="qcformbuilder-forms-entry-viewer-prev-btn btn btn-default qcformbuilder-forms-entry-viewer-btn qcformbuilder-forms-entry-viewer-nav-btn" title="<?php esc_attr_e( 'Previous page of entries', 'qcformbuilder-forms' ); ?>">
			<?php esc_html_e( 'Previous', 'qcformbuilder-forms' ); ?>
		</a>
		<a href="#" v-on:click.prevent="nextPage" class="qcformbuilder-forms-entry-viewer-next-btn btn btn-default qcformbuilder-forms-entry-viewer-btn qcformbuilder-forms-entry-viewer-nav-bt"  title="<?php esc_attr_e( 'Next page of entries', 'qcformbuilder-forms' ); ?>">
			<?php esc_html_e( 'Next', 'qcformbuilder-forms' ); ?>
		</a>
		<label for="qcformbuilder-entry-viewer-2-per-page" class="screen-reader-text sr-only">
			<?php esc_html_e( 'Entries Per Page', 'qcformbuilder-forms' ); ?>
		</label>
		<input type="number" min="1" max="100" v-model="perPage" v-on:change="updatePerPage" id="qcformbuilder-entry-viewer-2-per-page">


	</div>

</div>
<div id="qcformbuilder-forms-entry"></div>

