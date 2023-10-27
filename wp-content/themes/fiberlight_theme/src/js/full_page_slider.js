jQuery(document).ready(function(){
  jQuery('.page-slider-slides').slick({
    centerMode: false,
    // centerPadding: '150px',
    autoplay: false,
    autoplaySpeed: 4000,
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: true,
    fade: false,
    pauseOnFocus: false,
    appendDots: '.slider-dots',
    appendArrows: '.slider-arrow',
    prevArrow: '<div class="arrow-slider-prev">',
    nextArrow: '<div class="arrow-slider-next">',
    responsive: [
      {
        breakpoint: 1399.98,
        settings: {
        // centerPadding: '150px'
        }
      },
      {
        breakpoint: 991.98,
        settings: {
          // centerPadding: '50px'
        }
      },
      {
        breakpoint: 767.98,
        settings: {
          centerMode: false,
        }
      }
    ]
  });
});