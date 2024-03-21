(function ($, root, undefined) {
	$(function () {

		'use strict';

    // effects control
    gsap.registerPlugin(ScrollTrigger);
    if (document.querySelector('.s-circles')) {
      let approach = gsap.timeline({
        scrollTrigger: {
          trigger: "#et-main-area",
          start: "top top",
          end: "+=300",
          scrub: 1,
          // markers: true
        }
      });
      approach
        .fromTo(".s-circles .et_pb_column_2", {xPercent: -15}, {duration: 1, xPercent: 0})
        .fromTo(".s-circles .et_pb_column_4", {xPercent: 15}, {duration: 1, xPercent: 0}, "<");
    }

    // Create Elements For The Animation Timeline
    if (document.querySelector('#gsap-timeline')) {
      const gsapTimeline = document.querySelector('#gsap-timeline');
      // Create the div and span elements
      var barIndicator = document.createElement('div');
      barIndicator.setAttribute('id', 'progress-indicator');
      var dotIndicator = document.createElement('div');
      dotIndicator.setAttribute('id', 'dot-indicator');
      var barBaseIndicator = document.createElement('div');
      barBaseIndicator.setAttribute('id', 'bar-base-indicator');
      // Insert the dot inside the bar
      barIndicator.appendChild(dotIndicator);
      barIndicator.appendChild(barBaseIndicator);
      // Append the bar to the element with the ID "gsap-timeline"
      gsapTimeline.appendChild(barIndicator);


      gsapTimeline.addEventListener('mousemove', (e) => {
        let rect = gsapTimeline.getBoundingClientRect(); // Get bounding box of the timeline element
        let mouseX = e.clientX - rect.left; // Get the mouse position relative to the timeline's left edge        
        let percentage = (mouseX / rect.width) * 100; // Calculate percentage        
        // Use GSAP to smoothly update the width of the progress indicator
        gsap.to(dotIndicator, { width: `${percentage}%`, duration: 0.3 });
      });

      // Animate the bar based on mouse position
      gsapTimeline.addEventListener('mouseleave', (e) => {
        gsap.to(dotIndicator, { width: 0, duration: 0.8 });
      })
    }

    // slider gallery
		$('.slider-gallery').slick({
			arrows: true,
			dots: false,
			infinite: false,
			speed: 500,
			slidesToShow: 4,
      slidesToScroll: 1,
      rows: 0,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 4,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
				}
			]
    });
	});
})(jQuery, this);