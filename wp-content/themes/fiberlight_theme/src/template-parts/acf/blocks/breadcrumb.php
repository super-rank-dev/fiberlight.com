<?php
/**
 * Breadcrumb
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

 // Create id attribute allowing for custom "anchor" value and section classes.
 include(dirname(__DIR__).'/include/section-id.php');
 include(dirname(__DIR__).'/include/div-classes.php');
 include(dirname(__DIR__).'/include/breadcrumb.php');

?>


</div>