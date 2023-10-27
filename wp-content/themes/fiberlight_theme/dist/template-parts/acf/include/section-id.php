<?php
 $anchorTag = get_field('anchor_tag');
if( $anchorTag ) {
  $id = $anchorTag;
}
else{
  $id = 'section-' . $block['id'];
}
