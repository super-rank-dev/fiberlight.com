<?
unset($align);
$align = get_sub_field('align');
?>
<div class="subheader-wrapper">
  <h3 class="subheader <?= $align; ?>">
    <? the_sub_field('text'); ?>
  </h3>
</div>
