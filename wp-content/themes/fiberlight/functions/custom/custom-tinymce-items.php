<?php
/**
 * Example filter to add text style to TinyMCE filter with Mark's "MRW TinyMCE Mods" plugin
 *
 * Adds a "Text Styles" submenu to the "Formats" dropdown
 *
 * This would go in a functions.php file or mu-plugin so you don't have to modify the original plugin.
 *
 * $styles  array   Contains arrays of style_format arguments to define styles.
 *          Note: Should be an "array of arrays"
 *
 * see tinymce.com/wiki.php/Configuration:style_formats
 * see also tinymce.com/wiki.php/Configuration:formats
 * see also also wordpress.stackexchange.com/a/128950/9844
 */
add_filter( 'aor_mce_text_style', 'aor_add_text_styles_example' );
function aor_add_text_styles_example( $styles ) {
  $new_styles = array(
    /* Inline style that only applies to links */
     array(
     'title' => "Link Button", /* Label in "Formats" menu */
     'selector' => 'a', /* this style can ONLY be applied to existing <a> elements in the selection! */
     'classes' => 'button' /* class to add, could be multiple, space-separated */
    ),
    /* Inline style applied with a <span> */
    // array(
    //   'title' => "Callout Text",
    //   'inline' => 'span',
    //   'classes' => 'callout'
    // ),
    // /* Block style applied to paragraph. Each paragraph in selection gets the classes. */
     array(
       'title' => "Intro Paragraph",
       'block' => 'p',
       'classes' => 'intro-paragraph'
     ),
    // /* Block style capable of containing other block-level elemeents */
    // array(
    //   'title' => "Feature Box",
    //   'block' => 'section',
    //   'classes' => 'feature-box',
    //   'wrapper' => true
    // )
  );
  return array_merge( $styles, $new_styles );
}
