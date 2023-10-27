<?php

	$id = $block['anchor'];
	$anchorTag = get_field('anchor_tag');
	if( $anchorTag ) {
		$id = $anchorTag;
	}
	else{
		$id = 'section-' . $block['id'];
	}


// Create class attribute allowing for custom "className" and "align" values.
$classes = [ $sectionClass, $sectionClasses ];
if ( ! empty( $block['className'] ) ) {
	$classes = array_merge( $classes, explode( ' ', $block['className'] ) );
}
if ( ! empty( $block['align'] ) ) {
	$classes[] = 'align' . $block['align'];
}
if ( ! empty( $block['backgroundColor'] ) ) {
	$classes[] = 'has-background';
	$classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
	$classes[] = 'has-' . $block['backgroundColor'] . '-background';
}
if ( ! empty( $block['gradient'] ) ) {
	$classes[] = 'has-background';
	$classes[] = 'has-' . $block['gradient'] . '-gradient-background';
}
// if ( ! empty( $block['style'] )) {
// 	$block_class .= ' has-background ';
// 	$block_style .= 'background-color: ' . $block['style']['color']['background'] . ';';
// }



// if ( ! empty( $block['textColor'] ) ) {
// 	$classes[] = 'has-text-color';
// 	$classes[] = 'has-' . $block['textColor'] . '-color';
// }

printf(
	'<section id="'. esc_attr($id) .'" class="%s"%s>',
	esc_attr( join( ' ', $classes ) ),
	! empty( $block['anchor'] ) ? ' id="' . esc_attr( sanitize_title( $block['anchor'] ) ) . '"' : '',
);