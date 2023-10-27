<?php
function aor_button($trigger_video_from_button = false, $num = 0, $video_url = '') {

   unset($target, $color, $size, $url);

   if ( get_sub_field('button_text') ) :

      $target =
         get_sub_field('open_in_a_new_tab')
         ? "target='_blank'"
         : "";

      $color = get_sub_field('button_color');

      $size =
         get_sub_field('button_size') == "large"
         ? "large"
         : ""
         ;

      $url =
         get_sub_field('url_type') == "URL"
         ? get_sub_field('url')
         : get_the_permalink(get_sub_field('wordpress_content'))
         ;
      $trigger_class = '';
      if($trigger_video_from_button) {
         $url = $video_url;
         $trigger_class = "video_popup_$num";
      }
      ?>
      <a href="<?= $url; ?>" class="button <?= $size; ?> <?= $color; ?> <?= $trigger_class; ?>" <?= $target; ?>>
         <? the_sub_field('button_text'); ?>
      </a>

   <?php
   endif;

   unset($target, $color, $size, $url);

}
