<?php
/*
Template Name: Page Builder
*/

get_template_part( 'includes/header' ); ?>

<?
while (have_posts()) : the_post();

   if( have_rows('page_builder') ):

      while ( have_rows('page_builder') ) : the_row();

         $layout = get_row_layout();
         
         //If module has custom ID, then add a target link so we can adjust for the sticky header.
         if ( get_sub_field('custom_id') ) :
            echo " <a class='section-anchor' id='" . get_sub_field('custom_id') . "'></a>";
         endif;

         echo "<section class='pb-" . $layout;
         
         
         // if additional modules, add a class
         if ( $layout == "additional_modules" ) :
            $module = get_sub_field('module');
            echo " am-" . $module;
         endif;
         
         if ( $layout == "recent_news" ) :
           
            echo " background-pattern ";
         endif;

         // if bg color is not default add a class
         if ( get_sub_field('background_color') !== "default" ) :
            echo " " . get_sub_field('background_color');
         endif;
         
          // if bg pattern is true a class
          if (get_sub_field('background_pattern') == true ) :
               echo " background-pattern";
          endif;
         
         // if top padding is not default add a class
         if ( get_sub_field('top_padding') !== "default" ) :
            echo " " . get_sub_field('top_padding');
         endif;
         
         // if bottom padding is not default add a class
         if ( get_sub_field('bottom_padding') !== "default" ) :
            echo " " . get_sub_field('bottom_padding');
         endif;
         
         // if top margin is not default add a class
         if ( get_sub_field('top_margin') !== "default" ) :
            echo " " . get_sub_field('top_margin');
         endif;
         
         // if bottom margin is not default add a class
         if ( get_sub_field('bottom_margin') !== "default" ) :
            echo " " . get_sub_field('bottom_margin');
         endif;
         
         // if bottom margin is not default add a class
         if ( get_sub_field('custom_css_classes') ) :
            echo " " . get_sub_field('custom_css_classes');
         endif;
         
         echo "'";
         
         if ( 
            get_sub_field('top_padding') == "custom-padding-top"
            ||
            get_sub_field('bottom_padding') == "custom-padding-bottom"
            ||
            get_sub_field('top_margin') == "custom-margin-top"
            ||
            get_sub_field('bottom_margin') == "custom-margin-bottom"
            ||
            get_sub_field('custom_inline_css')
         ) :
            echo " style='";
            
            if ( get_sub_field('top_padding') == "custom-padding-top" ) :
               echo "padding-top:" . get_sub_field('custom_top_padding') . "px !important;";
            endif;
            
            if ( get_sub_field('bottom_padding') == "custom-padding-bottom" ) :
               echo "padding-bottom:" . get_sub_field('custom_bottom_padding') . "px !important;";
            endif;
            
            if ( get_sub_field('top_margin') == "custom-margin-top" ) :
               echo "margin-top:" . get_sub_field('custom_top_margin') . "px !important;";
            endif;
            
            if ( get_sub_field('bottom_margin') == "custom-margin-bottom" ) :
               echo "margin-bottom:" . get_sub_field('custom_bottom_margin') . "px !important;";
            endif;
            
            echo get_sub_field('custom_inline_css');
               
            echo "'";
         endif;
         
         if ( get_sub_field('custom_id') ) :
            echo " id='" . get_sub_field('custom_id') . "'";
         endif;
         
         echo ">";
         
         
         get_template_part('page-builder/' . $layout);
         echo "</section>";
         
        
      endwhile;

   endif;

endwhile;
?>

<?php get_template_part( 'includes/footer' ); ?>
