<div class="row">
    <div class="small-12 columns title">
        <h2><? the_sub_field('title'); ?></h2>
    </div>
    <?= do_shortcode('[ajax_load_more container_type="div" post_type="team-member" posts_per_page="12" images_loaded="true" button_label="MORE"]'); ?>

</div>