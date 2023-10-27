<?php get_template_part( 'includes/header' ); ?>

<section class="error row column">
   <?php if (get_field('404_page_description', 'options')) : ?>
         <div class="error-content"><?php echo the_field('404_page_description', 'options'); ?></div>
      <?php endif; ?>
      <?php if (get_field('404_page_buttons', 'options')): ?>
         <?php while(has_sub_field('404_page_buttons', 'options')): ?>
            <? aor_button(); ?>
         <?php endwhile; ?>
      <?php endif; ?>
</section>

<?


get_template_part( 'includes/footer' );
?>
