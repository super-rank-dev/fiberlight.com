<?php if (get_sub_field('buttons')): ?>

    <?php while(has_sub_field('buttons')): ?>

        <? aor_button(); ?>

    <?php endwhile; ?>

<?php endif; ?>
