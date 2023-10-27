<?php

function remove_default_format_select( $buttons ) {
    //Remove the format dropdown select and text color selector
    $remove = array( 'formatselect' );

    return array_diff( $buttons, $remove );
 }
add_filter( 'mce_buttons', 'remove_default_format_select' );

add_filter( 'mce_buttons', 'aor_mce_buttons_1' );
function aor_mce_buttons_1( $buttons ) {
  array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

//add_filter( 'mce_buttons_2', 'aor_mce_buttons_2' );
function aor_mce_buttons_2( $buttons ) {
  $buttons = array();
  return $buttons;
}

add_filter( 'tiny_mce_before_init', 'aor_mce_init' );
function aor_mce_init( $args ) {
  $style_formats = array(
    array(
      'title' => 'Header 1',
      'format' => 'h1'
    ),
    array(
      'title' => 'Header 2',
      'format' => 'h2'
    ),
    array(
      'title' => 'Header 3',
      'format' => 'h3'
    ),
    array(
      'title' => 'Header 4',
      'format' => 'h4'
    ),
    array(
      'title' => 'Header 5',
      'format' => 'h5'
    ),
    array(
      'title' => 'Header 6',
      'format' => 'h6'
    ),
    array(
      'title' => 'Paragraph',
      'format' => 'p'
      ),
    array(
      'title' => 'Blockquote',
      'format' => 'blockquote',
      'icon' => 'blockquote'
    ),
  );

  // Special custom filter to add text styles from a theme's functions.php file
  $text_styles = array();
  $text_styles = apply_filters( 'aor_mce_text_style', $text_styles );
  if( !empty( $text_styles) ) {
    $text_styles = array(
      'title' => 'Text Styles',
      'items' => $text_styles
    );
    // put style formats second-to-last
    $other_formats = array_pop( $style_formats );
    $style_formats = array_merge( $style_formats, array( $text_styles ), array( $other_formats ) );
  }

  // Last minute filter for anything more complicated before json_encoded
  $style_formats = apply_filters( 'aor_mce_style_formats', $style_formats );

  $args['style_formats'] = json_encode( $style_formats );

  return $args;
}
