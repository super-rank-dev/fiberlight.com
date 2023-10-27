jQuery(document).ready(function () {
  // Scroll to Anchor
  jQuery(function () {
    jQuery('a[href^="#"]').click(function () {
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
        && location.hostname == this.hostname) {
        var target = jQuery(this.hash);
        target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
          jQuery('html,body').animate({
            scrollTop: target.offset().top - 100 //offsets for fixed header
          });
          return false;
        }
      }
    })
    //Executed on page load with URL containing an anchor tag.
    if (jQuery(location.href.split("#")[1])) {
      var target = jQuery('#' + location.href.split("#")[1]);
      if (target.length) {
        jQuery('html,body').animate({
          scrollTop: target.offset().top - 100 //offset height of header here too.
        });
        return false;
      }
    }
  })

  // Main Navigation Hamburger
  jQuery(".hamburger").on("click", function (e) {
    jQuery("#main-navigation").toggleClass("nav-active");
    jQuery(".hamburger").toggleClass("is-active");
    jQuery("html, body").toggleClass("no-scroll");
    jQuery("#wp-chatbot-ball").toggle();
  });
  jQuery(".nav-overlay").on("click", function (e) {
    jQuery("#main-navigation").toggleClass("nav-active");
    jQuery(".hamburger").toggleClass("is-active");
    jQuery("html, body").toggleClass("no-scroll");
    jQuery("#wp-chatbot-ball").toggle();

  });
  jQuery(document).on('keydown', function (event) {
    if (event.key == "Escape") {
      jQuery("#main-navigation").toggleClass("nav-active");
      jQuery(".hamburger").toggleClass("is-active");
      jQuery("html, body").toggleClass("no-scroll");
      jQuery("#wp-chatbot-ball").toggle();
    }
  });

  //Main Navigation Search
  jQuery(".header-search-btn").on("click", function (e) {
    jQuery(".header-search-form").toggleClass("active");
  });


  // Main Navigation Coverage Map Select
  jQuery('.coverage-map-select').bind('change', function () {
    var url = jQuery(this).val();
    if (url != '') {
      window.location = url;
    }
    return false;
  });

  // Chat Bot
  // jQuery("#nav-item-chat").on("click", function (e) {
  //   jQuery("#main-navigation").removeClass("nav-active");
  //   jQuery(".hamburger").removeClass("is-active");
  //   // jQuery( "html, body" ).removeClass("no-scroll");
  //   jQuery("#wp-chatbot-chat-container").addClass("chat-box-show");
  // });

  // jQuery("#chat-bar").on("click", function (e) {
  //   jQuery("#wp-chatbot-chat-container").addClass("chat-box-show");
  // });

  // jQuery("#nav-item-chat").on("click", function (e) {
  //   jQuery("#wp-chatbot-chat-container").addClass("chat-box-show");
  // });
  // jQuery(".ChatBotOpen").each(function (e) {
  //   var found = [];
  //   [].forEach.call(document.getElementsByClassName('ChatBotOpen'), function (element) {
  //     (function (names, i) {
  //       while (i < names.length) {
  //         var name = names[i];
  //         if (name.indexOf('DataIntent-') === 0) {
  //           names.remove(name);
  //           found.push(name);
  //         } else {
  //           ++i;
  //         }
  //       }
  //     }(element.classList, 0));
  //   });
  //   var parts = found[0].split('-').pop();
  //   jQuery(this).attr("data-intent", parts);
  //   jQuery(this).addClass("qc_wpbot_chat_link");
  //   jQuery(this).addClass("qc_click_to_button");
  //   // console.log(parts)
  // });


  // jQuery(".ChatBotOpen").on("click", function (e) {
  //   jQuery("#wp-chatbot-chat-container").addClass("chat-box-show");
  // });


  gsap.registerPlugin(ScrollTrigger);
  let showHeader = gsap.fromTo("#header", { yPercent: -100 }, { yPercent: 0 }).progress(1);

  // Make Header Items Dark for Light Backgrounds
  var sectionClassList = jQuery('section')[0];
  if (jQuery(sectionClassList).hasClass("makeHeaderDark")) {
    makeLogoDark();
    ScrollTrigger.create({
      start: 0,
      end: 99999,
      markers: false,
      // toggleClass: {className: 'header-bg', targets: '#header'},
      onEnter: makeLogoDark,
      onLeave: makeLogoDark,
      onEnterBack: makeLogoLight,
      onLeaveBack: makeLogoDark,
      onUpdate: self => {
        self.direction === 1 ? showHeader.reverse() : showHeader.play();
      },
      onLeave: () => showHeader.play() // we're at the bottom of the page
    });
    ScrollTrigger.create({
      start: 130,
      end: 99999,
      onEnter: backgroundDark,
      onLeaveBack: backgroundNone,
    });
  }
  // Make Header Items Light for Dark Backgrounds
  else {
    makeLogoLight();
    ScrollTrigger.create({
      start: 0,
      end: 99999,
      // toggleClass: {className: 'header-bg', targets: '#header'},
      onEnter: makeLogoLight,
      onLeave: makeLogoLight,
      onEnterBack: makeLogoLight,
      onLeaveBack: makeLogoLight,
      onUpdate: self => {
        self.direction === 1 ? showHeader.reverse() : showHeader.play();
      },
      onLeave: () => showHeader.play() // we're at the bottom of the page
    });
    ScrollTrigger.create({
      start: 100,
      end: 99999,
      onEnter: backgroundDark,
      onLeaveBack: backgroundNone,
    });
  }

  function backgroundDark() {
    jQuery("#header").addClass("header-bg");
    jQuery("#logo-dark").removeClass("show");
    jQuery("#logo-dark").addClass("hide");
    jQuery("#logo-light").removeClass("hide");
    jQuery("#logo-light").addClass("show");
    jQuery("#header-lg").removeClass("header-lg-dark");
    jQuery("#hamburger-inner").addClass("light");
    jQuery("#hamburger-title").addClass("light");
  }
  function backgroundNone() {
    jQuery("#header").removeClass("header-bg");
  }
  function makeLogoLight() {
    jQuery("#header-lg #logo-dark").removeClass("show");
    jQuery("#header-lg #logo-dark").addClass("hide");
    jQuery("#header-lg #logo-light").removeClass("hide");
    jQuery("#header-lg #logo-light").addClass("show");
    jQuery("#header-xd #logo-dark").removeClass("show");
    jQuery("#header-xd #logo-dark").addClass("hide");
    jQuery("#header-xd #logo-light").removeClass("hide");
    jQuery("#header-xd #logo-light").addClass("show");
    jQuery("#header-lg").removeClass("header-lg-dark");
    jQuery("#hamburger-inner").addClass("light");
    jQuery("#hamburger-title").addClass("light");
  };

  function makeLogoDark() {
    jQuery("#header-lg #logo-light").removeClass("show");
    jQuery("#header-lg #logo-light").addClass("hide");
    jQuery("#header-lg #logo-dark").removeClass("hide");
    jQuery("#header-lg #logo-dark").addClass("show");
    jQuery("#header-xd #logo-light").removeClass("show");
    jQuery("#header-xd #logo-light").addClass("hide");
    jQuery("#header-xd #logo-dark").removeClass("hide");
    jQuery("#header-xd #logo-dark").addClass("show");
    jQuery("#header-lg").addClass("header-lg-dark");
    // jQuery("#header-xd").addClass("header-lg-dark");
    jQuery("#hamburger-inner").removeClass("light");
    jQuery("#hamburger-title").removeClass("light");
  };


  //   jQuery("body").on("scroll", function () {
  //     //set scroll position in session storage
  //     sessionStorage.scrollPos = jQuery(window).scrollTop();
  // });
  // var init = function () {
  //     //get scroll position in session storage
  //     jQuery("body").scrollTop(sessionStorage.scrollPos || 0)
  // };
  // window.onload = init;

});


