<?php
if( ! defined( 'ABSPATH' ) ){
	exit;
}
?>
<div class="qcformbuilder-editor-header">
	<ul class="qcformbuilder-editor-header-nav">
		<li class="qcformbuilder-editor-logo">
			<span class="qcformbuilder-forms-name"><?php echo esc_html(  $form[ 'name' ] ); ?><span class="qcformbuilder-forms-name">
		</li>
		<?php if( current_user_can( Qcformbuilder_Forms::get_manage_cap( 'admin' ) ) && empty( $form['_external_form'] ) ){ ?>
			<li class="qcformbuilder-forms-toolbar-item">
				<a class="button" href="admin.php?page=qcformbuilder-forms&edit=<?php echo $form['ID']; ?>">
					<?php esc_html_e( 'Edit' ); ?>
				</a>
			</li>
		<?php } ?>
	</ul>
</div>
<div class="form-extend-page-wrap">
<?php
if( isset( $_GET[ 'wfb-alt-viewer' ] ) ){
	$form = Qcformbuilder_Forms_Forms::get_form( $_GET[ 'wfb-alt-viewer' ] );
	echo Qcformbuilder_Forms_Entry_Viewer::form_entry_viewer_2( $form );
}else{
	?>
	<span class="form_entry_row highlight">
	<?php echo Qcformbuilder_Forms_Entry_Viewer::entry_trigger( $form[ 'ID' ] ); ?>
</span>
	<?php
	$is_pinned = true;
	include WFBCORE_PATH . 'ui/entries/toolbar.php';
	?>

	<div id="form-entries-viewer"></div>
	<?php include WFBCORE_PATH . 'ui/entries/pagination.php'; ?>
</div>

<?php
Qcformbuilder_Forms_Entry_Viewer::print_scripts();
?>

<?php
}
?>
</div>





