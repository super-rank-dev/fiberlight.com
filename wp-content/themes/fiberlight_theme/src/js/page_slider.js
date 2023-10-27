jQuery(document).ready(function(){
  jQuery('.page-slider-slides').slick({
    centerMode: true,
    centerPadding: '250px',
    autoplay: true,
    autoplaySpeed: 4000,
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    responsive: [
      {
        breakpoint: 1399.98,
        settings: {
        centerPadding: '150px'
        }
      },
      {
        breakpoint: 991.98,
        settings: {
          centerPadding: '50px'
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