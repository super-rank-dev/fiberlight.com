<?php
if ($divideBackground):
	if($dividedBackgroundColor === 'white'): $divideBGColor = 'has-background has-background-background-color has-background-background';
	elseif($dividedBackgroundColor === 'tan'): $divideBGColor = 'has-background has-fl-tan-background-color has-fl-tan-background';
	elseif($dividedBackgroundColor === 'lightblue'): $divideBGColor = 'has-background has-fl-light-blue-background-color has-fl-light-blue-background';
	elseif($dividedBackgroundColor === 'medblue'): $divideBGColor = 'has-background has-fl-med-blue-background-color has-fl-med-blue-background';
	elseif($dividedBackgroundColor === 'darkblue'): $divideBGColor = 'has-background has-fl-dark-blue-background-color has-fl-dark-blue-background';
	elseif($dividedBackgroundColor === 'lightblueg'): $divideBGColor = 'has-background has-fl-gradient-light-blue-gradient-background';
	elseif($dividedBackgroundColor === 'medblueg'): $divideBGColor = 'has-background has-fl-gradient-med-blue-gradient-background';
	elseif($dividedBackgroundColor === 'darkblueg'): $divideBGColor = 'has-background has-fl-gradient-dark-blue-gradient-background';
	endif;
endif;