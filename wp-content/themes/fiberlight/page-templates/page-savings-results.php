<?php
/*
Template Name: Savings calculator Results
*/

get_template_part( 'includes/header' ); ?>
<div class="results-wrap">
<?php
        // Start the loop.
        while ( have_posts() ) : the_post(); ?>
           <div class="row stats-content">
              <div class="small-12 columns">
                     <?php
                      $step = 'savings_results';
         			    include( locate_template( '/includes/calculator/step-content.php', false, false ) ); 
         			   ?>
                  </div>
           </div>
            <div class="row savings-wrap">
               <div class="small-12 columns">
                  <div id="gf_page_steps_3" class="gf_page_steps">
                     <div id="gf_step_3_1" class="gf_step gf_step_first gf_step_completed gf_step_previous"><span class="gf_step_number">1</span>&nbsp;<span class="gf_step_label">Cloud Provider</span></div>
                     <div id="gf_step_3_2" class="gf_step gf_step_completed "><span class="gf_step_number">2</span>&nbsp;<span class="gf_step_label">Data Transfer</span></div>
                     <div id="gf_step_3_3" class="gf_step gf_step_last gf_step_next gf_step_completed"><span class="gf_step_number">3</span>&nbsp;<span class="gf_step_label">Basic Information</span></div>
                     <div id="gf_step_3_4" class="gf_step gf_step_active"><span class="gf_step_number">4</span>&nbsp;<span class="gf_step_label">Savings Results</span></div><div class="gf_step_clear"></div>
                  </div>
               </div>
               <div class="small-12 medium-6 columns">
                <div class="savings-results monthly-savings">
                   <div class="title">
                        <h2>Monthy Savings</h2>
                   </div>
                   <div class="number">
                     <?php
                        //amazon
                        echo do_shortcode('[eid]{Amazon Monthly Savings (1GB - 10TB):17}[/eid]'); 
                        echo do_shortcode('[eid]{Amazon Monthly Savings (10TB - 50TB):32}[/eid]'); 
                        echo do_shortcode('[eid]{Amazon Monthly Savings (50TB - 150TB):34}[/eid]'); 
                        echo do_shortcode('[eid]{Amazon Monthly Savings (150TB - 500TB):36}[/eid]'); 
                        
                        //azure
                        echo do_shortcode('[eid]{Azure Monthly Savings (1GB - 10TB):51}[/eid]'); 
                        echo do_shortcode('[eid]{Azure Monthly Savings (10TB - 50TB):52}[/eid]'); 
                        echo do_shortcode('[eid]{Azure Monthly Savings (50TB - 150TB):53}[/eid]'); 
                        echo do_shortcode('[eid]{Azure Monthly Savings (150TB - 500TB):54}[/eid]'); 
                        
                        //google
                        echo do_shortcode('[eid]{Google Monthly Savings (0 - 1TB):71}[/eid]'); 
                        echo do_shortcode('[eid]{Google Monthly Savings (1TB - 10TB):72}[/eid]'); 
                        echo do_shortcode('[eid]{Google Monthly Savings (10TB+):73}[/eid]'); 
                     ?>
                     </div>
                 </div>
               </div>
               <div class="small-12 medium-6 columns">
                <div class="savings-results yearly-savings">
                   <div class="title">
                        <h2>Annual Savings</h2>
                   </div>
                   <div class="number">
                     <?php
                        //amazon
                        echo do_shortcode('[eid]{Amazon Yearly Savings (1GB - 10TB):20}[/eid]'); 
                        echo do_shortcode('[eid]{Amazon Yearly Savings (10TB - 50TB):33}[/eid]'); 
                        echo do_shortcode('[eid]{Amazon Yearly Savings (50TB - 150TB):35}[/eid]'); 
                        echo do_shortcode('[eid]{Amazon Yearly Savings (150TB - 500TB):37}[/eid]');
                        
                        //azure
                        echo do_shortcode('[eid]{Azure Yearly Savings (1GB - 10TB):55}[/eid]'); 
                        echo do_shortcode('[eid]{Azure Yearly Savings (10TB - 50TB):57}[/eid]'); 
                        echo do_shortcode('[eid]{Azure Yearly Savings (50TB - 150TB):58}[/eid]'); 
                        echo do_shortcode('[eid]{Azure Yearly Savings (150TB - 500TB):59}[/eid]');
                        
                        //google
                        echo do_shortcode('[eid]{Google Yearly Savings (0 - 1TB):74}[/eid]'); 
                        echo do_shortcode('[eid]{Google Yearly Savings (1TB - 10TB):75}[/eid]'); 
                        echo do_shortcode('[eid]{Google Yearly Savings (10TB+):76}[/eid]'); 
                     ?>
                  </div>
               </div>
               </div>
            </div>
            
            <div class="row">
               <div class="small-12 columns">
                  <div class="savings-footer">
                     <a href="/resources/savings-calculator/" class="button secondary">Return to Calculator</a>
                     <a target="_blank" href="/solutions/cloud-connect/" class="button primary">Learn more about FiberLight Cloud Connect</a>
                  </div>
               </div>
            </div>
               
       <?php
         // End of the loop.
        endwhile;
        ?>
</div>


<script>
var aoExternalPostURL = "http://go.fiberlight.com/l/749543/2019-06-17/59fd";
window.onload = function () {
if (String(window.location).search("%40")>0) { 
var aoUrlParams;var aoQuery = window.location.search.substring(1);
(window.onpopstate = function () {var e, t = /([^&=]+)=?([^&]*)/g;
aoUrlParams = {};
while (e = t.exec(aoQuery)) aoUrlParams[encodeURIComponent(e[1])] = e[2]})();
for (i in aoUrlParams) {var aoUrlParamsArray = aoUrlParams[i];
try {document.getElementsByName(i)[0].value = decodeURIComponent(aoUrlParamsArray)} 
catch (err) {}
};
var aoIfrm = document.createElement("iframe");
document.body.appendChild(aoIfrm);
aoIfrm.setAttribute("id", "ifrm");
aoIfrm.style.backgroundColor = "transparent";
aoIfrm.style.border = "none";
aoIfrm.style.width = "1px";
aoIfrm.style.height = "1px";
aoIfrm.src = aoExternalPostURL + "?" + aoQuery;
};
};
</script>

<?php get_template_part( 'includes/footer' ); ?>
