<?php if( have_rows('breadcrumbs') ): ?>
    <?php echo '<div id="'. esc_attr($id) .'" class="breadcrumbs">'; ?>
      <?php
        while( have_rows('breadcrumbs') ) : the_row();

        $label = get_sub_field('label');
        $link = get_sub_field('link');

        if($link) :
        $link_url = $link['url'];
        $link_target = $link['target'] ? $link['target'] : '_self';
        endif;

      ?>
        <div class="item">
          <?php 
            if($link) : echo '<a href="'. $link_url .'" target="'. $link_target .'">'; endif; 
            echo $label; 
            if($link): echo '</a>'; endif;
          ?>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>