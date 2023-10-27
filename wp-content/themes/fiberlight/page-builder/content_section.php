<?php
// determine if we should add full width to the mix
// http://foundation.zurb.com/sites/docs/grid.html#fluid-row
if ( get_sub_field('full_width_content') == 1 ) {
    $class__full_width = " expanded";
} else {
    $class__full_width = "";
}
?>

<section class="content-section">
    <div class="row<?= $class__full_width; ?>">
        <?php
        $pb = 'page-builder/';
        // check if the flexible content field has rows of data
        if( have_rows('columns') ):

            // loop through the rows of data
            while ( have_rows('columns') ) : the_row();

                if( get_row_layout() == 'column' ):
                    get_template_part( $pb.'columns/column' );

                endif;

            endwhile;

        endif;
        ?>
    </article>
</section>

