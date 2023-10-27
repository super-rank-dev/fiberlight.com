<?php
    //vars
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $form_code = get_sub_field('form_code');
?>
        
<div class="row">
    <?php if ($title || $description) : ?>
    <div class="small-12 large-4 columns content" data-aos="fade-right">
        <?php if ($title) : ?>
            <h2><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if ($description) : ?>
            <p class="intro-paragraph"><?php echo $description; ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="small-12 columns form <?php if ($title || $description) : ?>large-8 <?php else: ?>large-12<?php endif; ?>" data-aos="fade-left">
        <?php if ($form_code) : ?>
            <div class="code-block">
                <?php echo $form_code; ?>
            </div>
            <p class="form-information" style="position:relative;right:unset !important;bottom:unset !important;left:20px;">*Required Field</p>
        <?php else : ?>
            <?php  gravity_form( 1, false, false, false, '', true ); ?>
            <p class="form-information"  style="position:relative;right:unset !important;bottom:unset !important;left:20px;">*Required Field</p>
        <?php endif; ?>
    </div>
</div>
