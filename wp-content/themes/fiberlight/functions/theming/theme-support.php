<?php
function aor_theme_support() {
  // Add Support for WP Controlled Title Tag
  add_theme_support( 'title-tag' );

  // Add HTML5 Support
  add_theme_support( 'html5',
    array(
      'comment-list',
      'comment-form',
      'search-form',
      'gallery',
      'caption',
    )
  );

  // Set the maximum allowed width for any content in the theme, like oEmbeds and images added to posts.
  $GLOBALS['content_width'] = apply_filters( 'aor_theme_support', 1400 );
}

add_action( 'after_setup_theme', 'aor_theme_support' );
