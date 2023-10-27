<?php
if( ! defined( 'ABSPATH' ) ){
	exit;
}
$entry_perpage = Qcformbuilder_Forms_Entry_Viewer::entries_per_page();
?>
<div class="tablenav qcformbuilder-table-nav" style="display:none;">

	<div class="tablenav-pages">
		<label class="screen-reader-text" id="wfb-entries-list-items">
			<?php esc_html__( 'Posts Per Page', 'qcformbuilder-forms' ); ?>
		</label>
		<input title="<?php echo esc_attr( esc_html__( 'Entries Per Page', 'qcformbuilder-forms' ) ); ?>" id="wfb-entries-list-items" type="number" value="<?php echo esc_attr( $entry_perpage ); ?>" class="screen-per-page" data-perpage="<?php echo esc_attr( $entry_perpage ); ?>" min="1" />
		<span class="pagination-links">
				<a href="#first" title="<?php esc_attr_e( 'Go to the first page', 'qcformbuilder-forms' ); ?>" data-page="first" class="first-page">«</a>
				<a href="#prev" title="<?php esc_attr_e( 'Go to the previous page', 'qcformbuilder-forms' ); ?>" data-page="prev" class="prev-page">‹</a>
				<span class="paging-input"><input type="text" size="1" name="paged" title="Current page" class="current-page"> <?php esc_html_e( 'of'); ?> <span class="total-pages"></span></span>
				<a href="#next" title="<?php esc_attr_e( 'Go to the next page', 'qcformbuilder-forms' ); ?>" data-page="next" class="next-page">›</a>
				<a href="#last" title="<?php esc_attr_e( 'Go to the last page', 'qcformbuilder-forms' ); ?>" data-page="last" class="last-page">»</a>
			</span>
	</div>
</div>
