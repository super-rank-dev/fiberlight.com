<?php
global $post;
$current = $alm_item;

$isSorted = wp_count_posts( 'success-story' )->publish 
            + wp_count_posts( 'resource' )->publish
            == $alm_found_posts 
            ? 0 
            : 1;
?>

<?php 
// if this is the first one and is the first page and it hasnt been sorted and is success story
if ($current == 1 && $alm_page == 1  && $post->post_type == "success-story" && !$isSorted) : ?>
    <div class="small-12 large-8 columns filter-item">
        <?php displayStory(get_the_ID(), 'large'); ?>
    </div>
<?php endif; ?>
<?php if ($current == 2 && !$isSorted ) : ?>
<div class="small-12 large-4 columns filter-item filter-item-small two-per">

    <?
    //if success story
    if ( $post->post_type == "success-story") :
        displayStory(get_the_ID(), 'small'); 
    else:
        displayResource(get_the_ID());
    endif; ?>

<?php endif; ?>
<?php if ($current == 3 && !$isSorted ) :
    
    
    //if success story
    if ( $post->post_type == "success-story") :
        displayStory(get_the_ID(), 'small'); 
    else:
        displayResource(get_the_ID());
    endif; ?>
        
    </div>
<?php endif; ?>
<?php if ($current >= 4 || $isSorted) : ?>
<div class="small-12 large-4 columns filter-item filter-item-small">
    <?php
    //if success story
    if ( $post->post_type == "success-story") :
        displayStory(get_the_ID(), 'small'); 
    else:
        displayResource(get_the_ID());
    endif; ?>
</div>
<?php endif; ?>