<?php
function aor_custom_images() {
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'blog-post', 600, 370, true );
  // portrait-medium is a medium sized, portrait, cropped general purpose image size
  add_image_size('portrait-medium', 420, 550, true);
  add_image_size('split-section', 1200, 725, true);
  add_image_size('cta-banner', 1400, 500, true);
  add_image_size('mainstage-image', 1600, 800, true);
  add_image_size('small-square', 500, 500, true);
  add_image_size('gallery-thumbnail', 400, 300, true);
  add_image_size('success-story', 739, 889, true);
  add_image_size('success-logo', 250, 999, true);
  add_image_size( 'resource-thumbnail', 9999, 600, false);
}
add_action( 'after_setup_theme', 'aor_custom_images' );
