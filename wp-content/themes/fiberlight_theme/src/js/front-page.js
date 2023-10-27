//Scroll Trigger
jQuery(document).ready(function(){

  // Adjust Full Page Stats to move down on home page
  let mm = gsap.matchMedia();
  mm.add("(min-width: 769px)", () => {
    gsap.to("#stats", {
      y: 3, 
        scrollTrigger: {
        trigger: "#stats",
        start: 'top center',
        end: 'top top',
        scrub: true,
        // toggleClass: {className: 'break-section-above', targets: '#stats'},
        markers: false,
      }
    });
    return () => { // optional
      // custom cleanup code here (runs when it STOPS matching)
    };
  });

  // later, if we need to revert all the animations/ScrollTriggers...
  //mm.revert();
});

