<?php

// Welcome Panel
add_filter("get_user_metadata", "aor_welcome_panel_custom", 1, 4);
function aor_welcome_panel_custom($null, $object_id, $meta_key, $single) {
// Only work with the show_welcome_panel
if($meta_key !== 'show_welcome_panel') { return null; }

$url = get_option('siteurl');
$homeurl = get_option('home');
$title = get_option('blogname');
$description = get_option('blogdescription');

 echo '

<div class="welcome-panel" style="padding-bottom: 23px">

  <div class="welcome-panel-content">
    <h3>'.$title.' - '.$description.'</h3>
    <div class="welcome-panel-column-container">

      <div class="welcome-panel-column  style="padding-right: 25px;"">

      </div>

      <div class="welcome-panel-column">
        <h4>Next Steps</h4>
        <ul>
          <li><a href="'. $url . '/wp-admin/post-new.php?post_type=page">Add a Page</a></li>
          <li><a href="'. $url . '/wp-admin/post-new.php?post_type=post">Add a Post</a></li>
          <li><a href="'. $homeurl . '">View your site</a></li>
        </ul>
      </div>

    </div>

  </div>
</div>
 ';

// Return 0 or else the original welcome panel will show as well.
return 0;
}
