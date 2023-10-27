<?php if ( get_sub_field('title') ) : ?>
    <div class="row title">
        <div class="column">
            <?php if ( get_sub_field('title') ) : ?>
                <h1>
                    <? the_sub_field('title'); ?>
                </h1>
            <?php endif; ?>
            <?php if ( get_sub_field('description') ) : ?>
            <p><? thw_sub_field('description'); ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php if (get_sub_field('icons')): ?>
    <div class="row counterBar">
        <?php while(has_sub_field('icons')): ?>
            <div class="column countBox">
                <img src="<?= get_sub_field('image')['sizes']['gallery-thumbnail']; ?>">
                
                <?php if ( get_sub_field('data') ) : ?>
                    <h4><? the_sub_field('data'); ?></h4>
                <?php endif; ?>
                <?php if ( get_sub_field('title') ) : ?>
                    <h4><? the_sub_field('title'); ?></h4>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>