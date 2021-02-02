/* Template	:	CryptoCoin v1.0.0 */
;(function($){
	'use strict';
	var $win = $(window), $body_m = $('body');
	// Touch Class
	if (!("ontouchstart" in document.documentElement)) {
		$body_m.addClass("no-touch");
	}
	// Get Window Width
	function winwidth () {
		return $win.width();
	}
	var wwCurrent = winwidth();
	$win.on('resize', function () { 
		wwCurrent = winwidth(); 
	});
	// Sticky
	var $is_sticky = $('.is-sticky');
	if ($is_sticky.length > 0 ) {
		var $navm = $('#mainnav').offset();
		$win.scroll(function(){
			var $scroll = $win.scrollTop();
			if ($win.width() > 991) {
				if($scroll > $navm.top+4 ){
				  if(!$is_sticky.hasClass('has-fixed')) {$is_sticky.addClass('has-fixed');}
				} else {
				  if($is_sticky.hasClass('has-fixed')) {$is_sticky.removeClass('has-fixed');}
				}
			} else {
				if($is_sticky.hasClass('has-fixed')) {$is_sticky.removeClass('has-fixed');}
			}
		});
	}
	
	// Active page menu when click
	var CurURL = window.location.href, urlSplit = CurURL.split("#");
	var $nav_link = $(".nav li a");
	if ($nav_link.length > 0) {
		$nav_link.each(function() {
			if (CurURL === (this.href) && (urlSplit[1]!=="")) {
				$(this).closest("li").addClass("active").parent().closest("li").addClass("active");
			}
		});
	}
	// Mobile Menu With Tap @iO
	var $nav = $('#mainnav'), $navbar = $(".navbar"); var $navitem = $nav.find('li'), $navlink = $nav.find('a');
	function NavToggle($elem, $state) {
		var elm = $elem, sts = ($state===true||$state==="open"||$state===1) ? true : false;
		if (sts===true) {
			elm.slideDown(600);
		} else {
			elm.slideUp(500);
			elm.find('li.nav-opened').removeClass('nav-opened').children('ul').slideUp(300);
		}
	}
	function NavMobile() {
		if ($win.width() > 767) {
			$nav.removeClass("nav-mobile");
			$nav.find('.has-children').removeClass('nav-opened').removeClass('rollover').children('ul').removeAttr('style');
		} else {
			$nav.addClass("nav-mobile");
		}
	}
	NavMobile(); 
	$win.on('resize', function () { NavMobile(); });
	$navitem.has('ul').addClass('has-children');
	$navitem.on({
		mouseenter: function() {
			$(this).addClass('rollover'); 
		},
		mouseleave: function() {
			$(this).removeClass('rollover'); 
		}
			
	});
	$navlink.on('click touchstart', function(e) {
			var $self = $(this), $selfP = $self.parent(), selfHref = $self.attr('href');
			if (e.type==='click' && wwCurrent > 1366) {return true;}
			if ($selfP.hasClass('has-children')) {
				if ($selfP.hasClass('nav-opened')){
					$selfP.removeClass('nav-opened');
					if (selfHref==="#") {
						NavToggle($selfP.children('ul'), 'close');
						return false;
					}
					return true;
				} else {
					$selfP.addClass('nav-opened');
					$selfP.siblings().removeClass('nav-opened');
					NavToggle($selfP.siblings().children('ul'), 'close');
					setTimeout(function() {
						NavToggle($selfP.children('ul'), 'open');
					}, 150);
					return false;
				}
			}
			if (selfHref==="#") { return false; }
	});
	
	
	// Nav collapse
	$('.nav-item').on("click",function() {
		$('.navbar-collapse').collapse('hide');
	});
	
	// Active page menu when click
	var url = window.location.href;
	var $nav_link = $(".nav li a");
	$nav_link.each(function() {
	  if (url === (this.href)) {
		  $(this).closest("li").addClass("active");
	  }
	});
	
	//magnificPopup	Video
	var $video_play = $('.video-play');
	if ($video_play.length > 0 ) {
		$video_play.magnificPopup({
			type: 'iframe',
			removalDelay: 160,
			preloader: true,
			fixedContentPos: false,
			callbacks: {
			beforeOpen: function() {
					this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
					this.st.mainClass = this.st.el.attr('data-effect');
				}
			},
		});
	}
	
	//Switch Tab
	var $switch_tab = $('.switch-tab');
	if ($switch_tab.length > 0 ) {
		$switch_tab.on("click",function() {
			var $self = $(this), _target = $self.data('tabnav'), _href = $self.attr('href');
			var $tabnav = $('#'+_target), $tabnav_a = $tabnav.find('a');
			$tabnav_a.each(function(){
				$(this).parent().removeClass('active');
				if ($(this).attr('href')===_href) {
					$(this).parent().addClass('active');
				}
			});
		});
	}
	
	//Carousel
	var $has_carousel = $('.has-carousel');
	if ($has_carousel.length > 0 ) {
		$has_carousel.each(function(){
			var $self = $(this);
			var c_item = ($self.data('items')) ? $self.data('items') : 4;
			var c_item_t = (c_item >= 3) ? 3 : c_item;
			var c_item_m = (c_item_t >= 2) ? 2 : c_item_t;
			var c_delay =($self.data('delay')) ? $self.data('delay') : 6000;
			var c_auto =($self.data('auto')) ? true : false;
			var c_loop =($self.data('loop')) ? true : false;
			var c_dots = ($self.data('dots')) ? true : false;
			var c_navs = ($self.data('navs')) ? true : false;
			var c_ctr = ($self.data('center')) ? true : false;
			var c_mgn = ($self.data('margin')) ? $self.data('margin') : 30;
			$self.owlCarousel({
				navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
				items: c_item, loop: c_loop, nav: c_navs, dots: c_dots, margin: c_mgn, center: c_ctr,
				autoplay: c_auto, autoplayTimeout: c_delay, autoplaySpeed: 300, 
				responsive:{ 0:{ items:1 }, 480:{ items: c_item_m }, 768:{ items: c_item_t }, 1170:{ items: c_item } }
			});
		});
	}
	
	// Bitcoin Ticker
	var $btc_ticker = $('.btc-ticker');
	if ($btc_ticker.length > 0 ) {
		$btc_ticker.owlCarousel({
			items:7,
			loop:true,
			margin:0,
			center:true,
			stagePadding:0,
			responsive:{
				0 : {
					items:1,
				},
				400 : {
					items:2,
					center:false,
				},
				599 : {
					items:3,
				},
				1024 : {
					items:5,
				},
				1170 : {
					items:7,
				}
			}
		});
	}
	
	
	// Header Slider
	var $header_slider = $('.header-slider');
	if ($header_slider.length > 0 ) {
		$header_slider.owlCarousel({
			items:1,
			margin:0,
			dots:false,
			loop:true,
			nav:true,
			autoplay:false,
			animateIn:'fadeIn',
			animateOut:'fadeOut',
			navText: ["<span class='pe pe-7s-angle-left'></span>","<span class='pe pe-7s-angle-right'></span>"],
		});
	}
	

	//ImageBG
	var $imageBG = $('.imagebg');
	if ($imageBG.length > 0) {
		$imageBG.each(function(){
			var $this = $(this), 
				$that = $this.parent(),
				overlay = $this.data('overlay'),
				image = $this.children('img').attr('src');
			var olaytyp = (typeof overlay!=='undefined' && overlay!=='') ? overlay.split('-') : false;
			
			// If image found
			if (typeof image!=='undefined' && image !==''){
				if (!$that.hasClass('has-bg-image')) {
					$that.addClass('has-bg-image');
				}
				if ( olaytyp!=='' && (olaytyp[0]==='dark') ) {
					if (!$that.hasClass('light')) {
						$that.addClass('light');
					}
				}
				$this.css("background-image", 'url("'+ image +'")').addClass('bg-image-loaded');
			}
		});
	}
	
	// Parallax
	var $parallax = $('.has-parallax');
	if ($parallax.length > 0 ) {
		$parallax.each(function() {
			$(this).parallaxie({ speed: 0.3, offset: 0 });
		});
	}

	// FORMS
	var quoteForm = $('#contact-form');
	if (quoteForm.length > 0) {
		if( !$().validate || !$().ajaxSubmit ) {
			console.log('quoteForm: jQuery Form or Form Validate not Defined.');
			return true;
		}
		// Quote Form - home page
		if (quoteForm.length > 0) {
		var selectRec = quoteForm.find('select.required'), 
		qf_results = quoteForm.find('.form-results');
		quoteForm.validate({
		invalidHandler: function () { qf_results.slideUp(400); },
		submitHandler: function(form) {
			qf_results.slideUp(400);
			$(form).ajaxSubmit({
				target: qf_results, dataType: 'json',
				success: function(data) {
					var type = (data.result==='error') ? 'alert-danger' : 'alert-success';
					qf_results.removeClass( 'alert-danger alert-success' ).addClass( 'alert ' + type ).html(data.message).slideDown(400);
					if (data.result !== 'error') { $(form).clearForm(); }
				}
			});
			}
		});
		selectRec.on('change', function() { $(this).valid(); });
		}
	}
	
	// Preloader
	var $preload = $('#preloader');
	if ($preload.length > 0) {
		$win.on('load', function() {
			$preload.children().fadeOut(300);
			$preload.delay(150).fadeOut(500);
			$('body').delay(100).css({'overflow':'visible'});
		});
	}

})(jQuery);

