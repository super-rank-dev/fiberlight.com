<?
$current = $alm_current;

if ( $current % 3 == 1 ) : 
    
    if ( $current % 12 < 4 ) :
        $class="two-right";
    elseif ( $current % 12 < 7 ) :
        $class="two-left";
    elseif ( $current % 12 < 10 ) :
        $class="two-right";
    else :
        $class="three";
    endif;

?>

<div class="row <?= $class; ?>">
<? endif; 
// if two-right  
?>

    <? 
    if ( $current % 12 == 1  ) : ?>
        <div class=" columns big-column">
            <? displayStory(get_the_ID(), 'large'); ?>
        </div>
    <? endif; 
    
    if ( $current % 12 == 2  ) : ?>
        <div class="columns small-column">
            <? displayStory(get_the_ID(), 'small', 'margin-bottom:40px;'); ?>
    <? endif;
    if ( $current % 12 == 3 ) : ?>
            <? displayStory(get_the_ID(), 'small'); ?>
        </div>
    <? endif; 
// if two-left
    if ( $current % 12 == 4  ) : ?>
        <div class="columns small-column">
            <? displayStory(get_the_ID(), 'small', 'margin-bottom:40px;'); ?>
    <? endif;
    if ( $current % 12 == 5 ) : ?>
            <? displayStory(get_the_ID(), 'small'); ?>
        </div>
    <? endif; 
    if ( $current % 12 == 6  ) : ?>
        <div class=" columns big-column">
            <? displayStory(get_the_ID(), 'large'); ?>
        </div>
    <? endif; 
// if two-right  

    if ( $current % 12 == 7  ) : ?>
        <div class=" columns big-column">
            <? displayStory(get_the_ID(), 'large'); ?>
        </div>
    <? endif; 
    
    if ( $current % 12 == 8  ) : ?>
        <div class="columns small-column">
            <? displayStory(get_the_ID(), 'small', 'margin-bottom:40px;'); ?>
    <? endif;
    if ( $current % 12 == 9 ) : ?>
            <? displayStory(get_the_ID(), 'small'); ?>
        </div>
    <? endif;
    
// if three

    if ( $current % 12 == 10  ) : ?>
        <div class=" columns">
            <? displayStory(get_the_ID(), 'small'); ?>
        </div>
    <? endif; 
    
    if ( $current % 12 == 11  ) : ?>
        <div class="columns ">
            <? displayStory(get_the_ID(), 'small'); ?>
        </div>
    <? endif;
    if ( $current % 12 == 0 ) : ?>
        <div class="columns ">
            <? displayStory(get_the_ID(), 'small'); ?>
        </div>
    <? endif; ?>
    
    
    
    

 
<? if ( $current % 3 == 0 ) : ?>
</div>
<? endif; ?>