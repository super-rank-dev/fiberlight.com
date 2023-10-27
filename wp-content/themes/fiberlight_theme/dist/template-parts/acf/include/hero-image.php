<?php
	if ($heroImage || $heroImageMobile):
		$heroSizeXXL = 'bg-half-height-xxl';
		$heroSizeXL = 'bg-half-height-xl';
		$heroSizeLG = 'bg-half-height-lg';
		$heroSizeMD = 'bg-half-height-md';
		$heroSizeXS = 'bg-half-height-xs';
		$heroXXL = $heroImage['sizes'][ $heroSizeXXL ];
		$heroXL = $heroImage['sizes'][ $heroSizeXL ];
		$heroLG = $heroImage['sizes'][ $heroSizeLG ];
		$heroMD = $heroImage['sizes'][ $heroSizeMD ];
		$heroXS = $heroImageMobile['sizes'][ $heroSizeXS ];
	endif;