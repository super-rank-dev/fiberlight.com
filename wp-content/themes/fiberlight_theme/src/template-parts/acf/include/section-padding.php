<?php
$padding = get_field('padding');

if ($padding === 'no'):
  $sectionPadding = 'none';
elseif ($padding === 'half'):
  $sectionPadding = 'half';
elseif ($padding === 'third'):
	$sectionPadding = 'third';
else:
	$sectionPadding = 'default';
endif;
