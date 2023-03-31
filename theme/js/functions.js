/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */

( function( $ ) {
	$('.sub-menu-toggle').click(function() {
		$(this).toggleClass('active');
		$(this).siblings('.sub-menu').slideToggle();
	});

	$('.wpml-ls a.wpml-ls-item-toggle').click(function(e) {
		$('.wpml-ls ul ul').slideToggle('fast');
		$('.wpml-ls').toggleClass('active');
		e.stopPropagation();
	});
	$(document).click(function() {
		$('.wpml-ls ul ul').slideUp('fast');
		$('.wpml-ls').removeClass('active');
	});


	/*==================== sliders ====================*/
	var elms = document.getElementsByClassName('splide');
	for ( var i = 0; i < elms.length; i++ ) {
		new Splide( elms[ i ]).mount();
	}


	var elms = document.getElementsByClassName('bound-splide');
	for ( var i = 0; i < elms.length; i++ ) {

		var primary = new Splide(elms[i].getElementsByClassName('primary__splide')[0]);
		var secondary = new Splide(elms[i].getElementsByClassName('secondary__splide')[0]);

		
		primary.sync( secondary );
		primary.mount();
		secondary.mount();
	}


	/*==================== contact form 7 ====================*/
	var contactFormInputs = document.querySelectorAll('.wpcf7-form-control'); // or your custom input class
	contactFormInputs.forEach(function(element) {
		element.addEventListener('focus', function(event) {
			event.target.parentElement.classList.add("focused");
		});
		element.addEventListener('blur', function(event) {
			event.target.parentElement.classList.remove("focused");
		});
		element.addEventListener('change', function(event) {
			event.target.value
			? event.target.parentElement.classList.add("valid")
			: event.target.parentElement.classList.remove("valid")
		});
	});

	/*==================== header scroll class ====================*/
	function scrollHeader(){
		const header = document.getElementById('header')
		const text = document.getElementById('kiviluks');
		// When the scroll is greater than 100 viewport height, add the scroll-header class to the header tag
		if(this.scrollY >= 10) header.classList.add('scroll-header'); else header.classList.remove('scroll-header')
	}
	window.addEventListener('scroll', scrollHeader);

	$(document).ready(function () {
		'use strict';

		var c, currentScrollTop = 0,
			siteHeader = $('#header');

		$(window).scroll(function () {
			var a = $(window).scrollTop();
			var b = siteHeader.height();
			
			currentScrollTop = a;
			
			if (c < currentScrollTop && a > b + b) {
				siteHeader.addClass("scrollUp");
			} else if (c > currentScrollTop && !(a <= b)) {
				siteHeader.removeClass("scrollUp");
			}
			c = currentScrollTop;
		});	
	});

	/*==================== scroll animations ====================*/
    var animation_elements_load = function() {
        return $('body').find('[data-animate]:not(.animate)');
    };
    var animation_elements = animation_elements_load();
    var animate = function() {
        animation_elements.each(function() {
            var t = $(this);
            if (t.offset().top - window.scrollY - window.innerHeight - 50 < 0) {
                var delay = (t.data('animate') || '').replace(/\D+/g, '') || 0;
                setTimeout(function () {
                    t.addClass('animate');
                    animation_elements = animation_elements_load();
                }, delay);
            }
        });
    };
    $(window).on('load resize scroll', animate);

	/*==================== scroll back up ====================*/
	const scrollBtn = document.querySelector(".scroll-to-top__btn");

	const btnVisibility = () => {
		if (window.scrollY > 200) {
			scrollBtn.style.visibility = "visible";
		} else {
			scrollBtn.style.visibility = "hidden";
		}
	};

	document.addEventListener("scroll", () => {
		btnVisibility();
	});

	scrollBtn.addEventListener("click", () => {
		window.scrollTo({
			top: 0,
			behavior: "smooth"
		});
	});


	/*==================== More Scrolling ====================*/ 

	$(window).scroll(function(){
    if ($(this).scrollTop() > 10) {
       $('.transparent-logo').addClass('scrolled-down_transparent-svg');
    } else {
       $('.transparent-logo').removeClass('scrolled-down_transparent-svg');
    }
});


$(window).scroll(function(){
	if ($(this).scrollTop() > 10) {
		 $('.regular-logo').addClass('scrolled-down_regular-svg');
	} else {
		 $('.regular-logo').removeClass('scrolled-down_regular-svg');
	}
});

	/*==================== mixitup ====================*/
	var mixer = mixitup('.careers-list', {
		selectors: {
				control: '[data-mixitup-control]'
		}
});


})( jQuery );






