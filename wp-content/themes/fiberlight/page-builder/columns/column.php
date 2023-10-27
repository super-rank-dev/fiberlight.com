<?
unset($width, $center, $align);
$width = get_sub_field('width');
$align = get_sub_field('center_column');
if ( $align  ) { $center = "small-centered"; } else { $center = false; }

$col_class__group = array( 'small-12', 'columns', $width, $center );
$col_class        = implode( " ", $col_class__group );
?>

<div class="<?= $col_class ?>">
  <?php if( get_sub_field('column_content') ):
    while ( has_sub_field('column_content') ) :
      $rowName = get_row_layout();
      // make sure that file name matches field name ie: example_module = example_module.php
      include(dirname(__FILE__) . '/column-content/'.$rowName.'.php');
    endwhile;
  endif;?>
</div>
