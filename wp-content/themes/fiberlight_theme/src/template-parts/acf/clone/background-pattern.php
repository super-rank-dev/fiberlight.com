<?php 
	if($backgroundPattern && $backgroundPattern != 'none'):
?>
<div class="background-pattern">
	<?php if($backgroundPattern === 'geodesic'): ?>
		<img class="geodesic-pattern" src="/wp-content/themes/fiberlight_theme/dist/images/bg_geodesic.svg" alt="Geodesic Pattern" />
	<?php elseif($backgroundPattern === 'geodesic-light'): ?>
		<img class="geodesic-pattern-light" src="/wp-content/themes/fiberlight_theme/dist/images/bg_geodesic-light.svg" alt="Geodesic Pattern Light" />
	<?php endif; ?>
</div>
<?php
	endif;
?>