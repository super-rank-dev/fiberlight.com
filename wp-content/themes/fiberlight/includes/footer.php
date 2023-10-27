<footer>
   <div class="footer-wrap" data-aos="fade-up">
       <a href="#top" class="hide-for-medium back-to-top">
           <span style="position: absolute; right: 0; right: 0; top: -20px; margin-right: 15px; font-weight: 700; font-size: 18px; color: #93d518;">Back to Top</span>
        </a>
      <div class="row main-footer" data-aos="fade-up">
         <div class="columns small-12 large-4 contact">
            <h5>
               <a href="https://www.fiberlight.com/contact">Contact</a>
            </h4>
            <div class="hold-me">
               <div class="left">
                  <? the_field('address','options'); ?>
                  <?php if (get_field('social_icons', 'options')): ?>
                  	<?php while(has_sub_field('social_icons', 'options')): ?>
                  
                        <a href="<? the_sub_field('link_url', 'options'); ?>" target="_blank" class="social-link">
                           <img src="<?= get_sub_field('icon')['sizes']['thumbnail']; ?>">
                        </a>
                  
                  	<?php endwhile; ?>
                  <?php endif; ?>
               </div>
               <div class="right">
                  <? the_field('contact_info','options'); ?>
               </div>
            </div>
         </div>
         <div class="columns small-12 large-4 solutions">
            <h5>
                <a href="https://www.fiberlight.com/solutions">Solutions</a>
            </h4>
            <?php aor_menu('footer-solutions', 'footer-solutions', '', '1'); ?>
         </div>
         <div class="columns small-12 large-4 quick-links">
            <h5>
               Quick Links
            </h4>
            <?php aor_menu('footer-quick-links', 'footer-quick-links', '', '1'); ?>
         </div>
      </div>
      <div class="row sub-footer">
         <div class="column small-12 medium-12 links">
            <?php if (get_field('sub_footer_links', 'options')): ?>
            	<?php while(has_sub_field('sub_footer_links', 'options')): ?>
            
                  <a href="<? the_sub_field('link_url'); ?>" <?php if (get_sub_field('open_in_new_tab') == true ) : ?>target="_blank"<?php endif; ?>>
                     <?= get_sub_field('link_text'); ?>
                  </a>
            
            	<?php endwhile; ?>
            <?php endif; ?>
         </div>
         
      </div>
   </div>
   <? the_field('acton_code', 'options'); ?>
</footer>


<? wp_footer(); ?>

<script>
   (function($) {
      $(document).foundation();
   })(jQuery);
</script>
<script>
   AOS.init();
</script>
<script>
   jQuery(document).ready(function($){
   		$.fn.moveIt = function(){
        var $window = $(window);
        var instances = [];
        
        $(this).each(function(){
          instances.push(new moveItItem($(this)));
        });
        
        window.onscroll = function(){
          var scrollTop = $window.scrollTop();
          instances.forEach(function(inst){
            inst.update(scrollTop);
          });
        }
      }
      
      var moveItItem = function(el){
        this.el = $(el);
        this.speed = parseInt(this.el.attr('data-scroll-speed'));
      };
      
      moveItItem.prototype.update = function(scrollTop){
        if ( $(window).width() > 640 ) {
            this.el.css('transform', 'translateX(' + (scrollTop / this.speed) + 'px)');
        }
        else {
            /* Commenting out so waermark can scale down on mobile this.el.css('transform', 'translateY(0px)'); */
        }
      };
      
      // Initialization
      $(function(){
        $('[data-scroll-speed]').moveIt();
      });
      
      // Savings calculator labels
       $('.amazon label').prepend('<span class="field-title">Amazon</span>');
       $('.azure label').prepend('<span class="field-title">Azure</span>');
       $('.google label').prepend('<span class="field-title">Google</span>');
   	   
           
       });
   	
   	if (("ontouchstart" in document.documentElement)) {
        document.documentElement.className += " touch";
   	}
   	// Savings calculator
   	$(window).load(function() {
   	    $('.savings-results').delay(100).animate({'opacity':'1'},400);
       $('.savings-results .number').html(function(i, oldhtml) {
          //return oldhtml.replace('-','');
        });
});


</script>
<? the_field('footer_code','options'); ?>

</body>
</html>

