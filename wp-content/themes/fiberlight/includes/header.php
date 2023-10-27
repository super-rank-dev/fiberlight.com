<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
   <? the_field('tag_manager_script_code','options'); ?>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
   <?php wp_head(); ?>
   <? the_field('header_code','options'); ?>

    
</head>

<body <?php body_class(); ?> >
   <? the_field('tag_manager_noscript_code','options'); ?>
   
   <?php if( get_field('show_announcement_bar', 'option') == true ): ?>
        
        <section class="announcement alert-bar" data-closable>
           <div class="row">
            <div class="column">
                <?php echo  the_field( 'announcement_bar_content', 'options' ); ?> <a class="alert-close" data-close>&times;</a>
            </div>
         </div>
        </section>
   <?php endif; ?>
   
   <header <?php if (get_field('header_border') == true) : ?>class="header-border"<?php endif; ?>>
      <progress value="0" id="progressBar" class="single">
        <div class="progress-container">
          <span class="progress-bar"></span>
        </div>
      </progress>
      <div class="row">
         <div class="shrink columns logo" >
            <a href="<?php echo home_url(); ?>">
               <?
               if ( get_field('logo','options') ) :
               ?>
                  <img src="<?= get_field('logo','options')['sizes']['medium']; ?>" alt="<? bloginfo('name'); ?>">
               <?
               else :
               ?>
                  <h1><? bloginfo('name'); ?></h1>
               <?
               endif
               ?>
            </a>
         </div>
         <div class="columns navigation align-right align-middle">
            <nav class="menu-utility-wrap">
               <?php aor_menu('menu-utility', 'menu-utility', '', '2'); ?>
               <form class="search" role="search" method="get" id="search-form" action="/">
                  <input type="text" placeholder="Enter Search..." name="s" id="s">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/icon-search.svg" />
               </form>
            </nav>
            <nav class="menu-desktop">
               <? aor_display_ubermenu(); ?>
            </nav>
            
            
            <div class="menu-trigger-holder">
               <a href="javascript:void(0)" class="menu-trigger shiftnav-toggle shiftnav-toggle-button" data-shiftnav-target="shiftnav-main">
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
               </a>
            </div>
         </div>
         <!--<div class="small-12 columns">
            <hr>
         </div>-->
      </div>
  </header>
  
  <?php 
     get_template_part('includes/page-hero');
   ?>

  
  <script type="text/javascript">
	jQuery(document).ready(function($){
	   
	   //Add active class to parent if child has class (used to add class to parent when on single pages.)
      $('.ubermenu-submenu .current-menu-item').parent().parent().addClass('ubermenu-current_page_item')
	   
	   //Search Functionality
		$(".menu-utility-wrap .search").hover(function(){
         $('.menu-utility-wrap .search input').css('width','150');
      }, function(){
         if ( 
            ( 
               !$('.menu-utility-wrap .search input').is(':focus') 
            )
            &&
            (
               $('.menu-utility-wrap .search input').val().length === 0
            )
         
         ) {
            $('.menu-utility-wrap .search input').css('width','0');
         }
      });
      
      $('.menu-utility-wrap .search img').click(function() {
         $('#search-form').submit();
      })
      
      //Menu on Scroll
          var  mn = $("body");
          $(window).scroll(function() {
            if( $(this).scrollTop() > 100 ) {
              mn.addClass("header-scroll");
            } else {
              mn.removeClass("header-scroll");
            }
          });
      
        $(window).load(function () {
      
              
              //Progress Bar
              
               var getMax = function(){
                return $(document).height() - $(window).height();
               }
               
               var getValue = function(){
                   
                   return $(window).scrollTop();
               }
               
               if('max' in document.createElement('progress')){
                   // Browser supports progress element
                   var progressBar = $('progress');
                   
                   // Set the Max attr for the first time
                   progressBar.attr({ max: getMax() });
           
                   $(document).on('scroll', function(){
                       // On scroll only Value attr needs to be calculated
                       progressBar.attr({ value: getValue() });
                   });
                 
                   $(window).resize(function(){
                       // On resize, both Max/Value attr needs to be calculated
                       progressBar.attr({ max: getMax(), value: getValue() });
                   });   
               }
               else {
                   var progressBar = $('.progress-bar'), 
                       max = getMax(), 
                       value, width;
                   
                   var getWidth = function(){
                       // Calculate width in percentage
                       value = getValue();            
                       width = (value/max) * 100;
                       
                       width = width + '%';
                       return width;
                   }
                   
                   var setWidth = function(){
                       console.log('h');
                       progressBar.css({ width: getWidth() });
                   }
                   
                   $(document).on('scroll', setWidth);
                   $(window).on('resize', function(){
                       // Need to reset the Max attr
                       max = getMax();
                       setWidth();
                   });
               }
          
        });
      
      

      

	});
</script>
