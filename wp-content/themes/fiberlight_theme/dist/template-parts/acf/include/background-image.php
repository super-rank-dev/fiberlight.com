<?php
	if ($backgroundImage || $backgroundImageMobile):
		$bgImageSizeXXL = 'bg-full-height-xxl';
		$bgImageSizeXL = 'bg-full-height-xl';
		$bgImageSizeLG = 'bg-full-height-lg';
		$bgImageSizeMD = 'bg-full-height-md';
		$bgImageSizeXS = 'bg-full-height-xs';
		$bgImageXXL = $backgroundImage['sizes'][ $bgImageSizeXXL ];
		$bgImageXL = $backgroundImage['sizes'][ $bgImageSizeXL ];
		$bgImageLG = $backgroundImage['sizes'][ $bgImageSizeLG ];
		$bgImageMD = $backgroundImage['sizes'][ $bgImageSizeMD ];
		$bgImageXS = $backgroundImageMobile['sizes'][ $bgImageSizeXS ];
	endif;