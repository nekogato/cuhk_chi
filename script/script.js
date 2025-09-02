var swiperArr = [];
var scrollArr = [];

if (!("ontouchstart" in document.documentElement)) {
document.documentElement.className += " no-touch";
}

var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();



function doscroll(){
	
	
	var scrolltop = $(window).scrollTop();
	var hh = $(window).height();
	
	if(scrolltop>0){
		$("body").addClass("nottop")
	}else{
		$("body").removeClass("nottop")
	}

	$(".scrollin").not($(".scrollin_p .scrollin")).each(function(i){
		var $this = $(this);
		var mytop = $this.offset().top;
		var myh = $this.height();
		
		var dis = (scrolltop+hh)-mytop;

		
		if(dis>0 ){
			$this.removeClass("leavescreen");
			$this.addClass("onscreen");
			
			if(dis<hh+myh){
				$this.find(".scrollin").removeClass("stop");
			}else{
				$this.find(".scrollin").addClass("stop");
			}
			
		}else{
			$this.removeClass("onscreen");
			$this.addClass("leavescreen");
		}
	});

	
	
	$(".scrollin_p").each(function(i){
		var $this = $(this);
		var mytop = $this.offset().top;
		var myh = $this.height();
		
		var dis = (scrolltop+hh)-mytop;
		//$(this).attr("data-dis",scrolltop+","+hh+","+mytop+","+dis)
		if(dis>0 ){
			
			$this.find(".scrollin").removeClass("leavescreen");
			$this.find(".scrollin").addClass("onscreen");
			
			if(dis<hh+myh){
				$this.find(".scrollin").removeClass("stop");
			}else{
				$this.find(".scrollin").addClass("stop");
			}
			
		}else{
			$this.find(".scrollin").removeClass("onscreen");
			$this.find(".scrollin").addClass("leavescreen");
			//$this.find(".scrollin").removeClass("stop");
		}
	});
	
	$(".scrollin.onscreen").not($(".scrollin_p .scrollin")).not($(".scrollin.onscreen.stop")).not($(".startani")).each(function(i){
		$(this).css({
			"-webkit-transition-delay": i*200+100+"ms",
			"transition-delay": i*200+100+"ms",
		})
		
		if($(this).hasClass("moredelay")){
			$(this).css({
				"-webkit-transition-delay": i*200+600+"ms",
				"transition-delay": i*200+600+"ms",
			})
		}
		
		if($(this).hasClass("moredelay2")){
			$(this).css({
				"-webkit-transition-delay": i*200+1200+"ms",
				"transition-delay": i*200+1200+"ms",
			})
		}

		if($(this).hasClass("lessdelay")){
			$(this).css({
				"-webkit-transition-delay": i*80+100+"ms",
				"transition-delay": i*80+100+"ms",
			})
		}
		
		
		if($(this).hasClass("nodelay")){
			$(this).css({
			"-webkit-transition-delay": 0+"ms",
			"transition-delay": 0+"ms",
			})
		}
		
		$(this).addClass("startani");
	});

	$(".scrollin_p").each(function(){
		$(this).find(".scrollin.onscreen").not($(".scrollin.onscreen.stop")).not($(".startani")).each(function(i){
			$(this).css({
				"-webkit-transition-delay": i*200+100+"ms",
				"transition-delay": i*200+100+"ms",
			})
			
			if($(this).hasClass("moredelay")){
				$(this).css({
					"-webkit-transition-delay": i*200+600+"ms",
					"transition-delay": i*200+600+"ms",
				})
			}
		
			if($(this).hasClass("moredelay2")){
				$(this).css({
					"-webkit-transition-delay": i*200+1200+"ms",
					"transition-delay": i*200+1200+"ms",
				})
			}
			
			if($(this).hasClass("nodelay")){
				$(this).css({
				"-webkit-transition-delay": 0+"ms",
				"transition-delay": 0+"ms",
				})
			}
			
			$(this).addClass("startani");
		});
	})
	
	
	$(".scrollin.leavescreen").each(function(i){
		$(this).css({
			"-webkit-transition-delay": 0+"ms",
    		"transition-delay": 0+"ms",
		})
		$(this).removeClass("startani");
	});
	
	$(".scrollin.stop").each(function(i){
		$(this).css({
			"-webkit-transition-delay": 0+"ms",
    		"transition-delay": 0+"ms",
		})
		$(this).addClass("startani");
	});

	$(".bottom_logo_section.leavescreen").each(function(i){
		$(this).removeClass("played");
	});
	
	$(".bottom_logo_section.onscreen").each(function(){
		if(!$(this).hasClass("played")){
			logo_animate();
			$(this).addClass("played")
		}
	})
}


function change_svg(){
	$('img.svg').each(function(){
		var $img = $(this);
		var imgID = $img.attr('id');
		var imgClass = $img.attr('class');
		var imgURL = $img.attr('src');
	
		$.get(imgURL, function(data) {
			// Get the SVG tag, ignore the rest
			var $svg = jQuery(data).find('svg');
	
			// Add replaced image's ID to the new SVG
			if(typeof imgID !== 'undefined') {
				$svg = $svg.attr('id', imgID);
			}
			// Add replaced image's classes to the new SVG
			if(typeof imgClass !== 'undefined') {
				$svg = $svg.attr('class', imgClass+' replaced-svg');
			}
	
			// Remove any invalid XML tags as per http://validator.w3.org
			$svg = $svg.removeAttr('xmlns:a');
	
			// Check if the viewport is set, if the viewport is not set the SVG wont't scale.
			if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
				$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
			}
	
			// Replace image with new SVG
			$img.replaceWith($svg);
	
		}, 'xml');
	
	});
}

function loading_finish(){
	$("body").addClass("loadfinish")
	$(".loading").fadeOut(function(){
		doscroll();
		dosize();
	})

	$(".people_detail_text").each(function () {
		var $this = $(this);

		var ps  = new PerfectScrollbar($(this)[0],{
			suppressScrollX:true,
			scrollYMarginOffset:20
		});

		scrollArr.push(ps)
    });


	if($(".bg_video_wrapper").length){

		const videos = [
			{ element: document.getElementById('video1'), section: '#section1' },
		];

		const controller = new ScrollMagic.Controller();

		videos.forEach((video) => {
			const videoElement = video.element;

			// ScrollMagic scene for entering the section
			new ScrollMagic.Scene({
				triggerElement: video.section,
				triggerHook: 0.5, // Trigger when the section is in the middle of the viewport
				duration: '50%', // The effect lasts for the height of the section
			})
			.on('enter', () => {
				console.log('enter',video.section)
				videoElement.currentTime = 0; // Reset to the beginning
				gsap.to(videoElement, {
					opacity: 1,
					duration: 1,
					onStart: () => {
					videoElement.currentTime = 0; // Reset to the beginning
					videoElement.play(); // Start playing
					},
				});
			})
			.on('leave', () => {
				console.log('leave',video.section)
				gsap.to(videoElement, {
					opacity: 0,
					duration: 1,
					onComplete: () => {
					//videoElement.pause(); // Pause playback
					videoElement.currentTime = 0; // Reset to the first frame
					console.log("video reset",video.section)
					},
				});
			})
			.addTo(controller);
		});

	}
}


function init_event(){
	$(".menu_dropdown").click(function(){
		if($("body").hasClass("openmenu")){
			$("body").removeClass("openmenu")
			$(".dropdown").stop().fadeOut();
		}else{
			$("body").addClass("openmenu")
			$(".dropdown").stop().fadeIn();
		};
		return false;
	})

	

	$(".scheme_unit_expandable_box .title").click(function(){
		var $p = $(this).parents(".scheme_unit_expandable_box")
		if($p.hasClass("active")){
			$p.removeClass("active").find(".hidden").show();
			setTimeout(function(){
			$p.find(".hidden").stop().slideUp();
			},0)
		}else{
			$p.addClass("active").find(".hidden").hide();
			setTimeout(function(){
			$p.find(".hidden").stop().slideDown();
			},0)
		}
	})

	$(".scheme_groups_dropdown .selected").click(function(){
		var $p = $(this).parents(".scheme_groups_dropdown")
		if($p.hasClass("opened")){
			$p.removeClass("opened").find(".hidden").show();
			setTimeout(function(){
			$p.find(".hidden").stop().slideUp();
			},0)
		}else{
			$p.addClass("opened").find(".hidden").hide();
			setTimeout(function(){
			$p.find(".hidden").stop().slideDown();
			},0)
		}
	})


	$(".scheme_groups_dropdown .hidden a").click(function(){
		$(".scheme_groups_dropdown .hidden li.active").removeClass("active");
		$(this).parent().addClass("active")
		var $p = $(this).parents(".scheme_groups_dropdown");
		var target = $(this).attr("data-target");
		$(".scheme_group").removeClass("active").hide();
		$(".scheme_group[data-id='"+target+"']").addClass("active").hide();
		setTimeout(function(){
			$(".scheme_group[data-id='"+target+"']").stop().fadeIn();
		},0)

		$p.removeClass("opened").find(".hidden").show();
		setTimeout(function(){
		$p.find(".hidden").stop().slideUp();
		},0)

		$(".scheme_groups_dropdown .selected .text").text($(".scheme_groups_dropdown .hidden li.active").text());
		
		return false;
	})
	

	$(document).on("click", ".scheme_group_expandable_item .title", function () {
		if(!$(this).hasClass("disable")){
			var $p = $(this).parents(".scheme_group_expandable_item")
			if($p.hasClass("active")){
				$p.removeClass("active").find(".hidden").show();
				setTimeout(function(){
				$p.find(".hidden").stop().slideUp();
				},0)
			}else{
				$p.addClass("active").find(".hidden").hide();
				setTimeout(function(){
				$p.find(".hidden").stop().slideDown();
				},0)
			}
		}
	})

	$(document).on("click", ".expandable_item .expandable_title", function () {
		if(!$(this).hasClass("disable")){
			var $p = $(this).parents(".expandable_item")
			if($p.hasClass("active")){
				$p.removeClass("active").find(".hidden").show();
				setTimeout(function(){
				$p.find(".hidden").stop().slideUp();
				},0)
			}else{
				$p.addClass("active").find(".hidden").hide();
				setTimeout(function(){
				$p.find(".hidden").stop().slideDown();
				},0)
			}
		}
	})

	$(document).on("click", ".filter_dropdown_btn", function () {
		var $p = $(this).parents(".filter_dropdown_wrapper")
		if($p.hasClass("active")){
			$p.removeClass("active").find(".filter_dropdown").show();
			setTimeout(function(){
			$p.find(".filter_dropdown").stop().slideUp();
			},0)
		}else{
			$p.addClass("active").find(".filter_dropdown").hide();
			setTimeout(function(){
			$p.find(".filter_dropdown").stop().slideDown();
			},0)
		}
		return false;
	})

	$(document).on("click", ".filter_dropdown a", function () {
		var $p = $(this).parents(".filter_dropdown_wrapper")
		if($p.hasClass("active")){
			$p.removeClass("active").find(".filter_dropdown").show();
			setTimeout(function(){
			$p.find(".filter_dropdown").stop().slideUp();
			},0)
		}else{
			$p.addClass("active").find(".filter_dropdown").hide();
			setTimeout(function(){
			$p.find(".filter_dropdown").stop().slideDown();
			},0)
		}
	})

	$(".popup_close_btn").click(function(){
		var $p = $(this).parents(".people_popup")
		$p.stop().fadeOut();
		return false;
	})


	$(document).on('click', '.popup_btn', function(){
		var target = $(this).attr("data-target");
		var $target = $(".popup[data-id='"+target+"']");
		$target.stop().fadeIn();
		for ( var i = 0; i < scrollArr.length; i++ ) { 
			scrollArr[i].update();
		}
		return false;
	})



	$(".song_btn").click(function(){
		var $this = $(this);
		if($this.hasClass("active")){
		}else{
			$(".song_btn.active").removeClass("active");
			$this.addClass("active");
			var myname  = $this.text();
			$(".song_text .t2 .version_name").text(myname);
			var mysong  = $this.attr("data-song");
			changeAudioSource($(".audio-player"),mysong);
		}
		return false;
	})

	

	$('.scholarship_filter input[name="filter"]').on('change', function () {
		$(".section_expandable_list").height($(".section_expandable_list").height());
		let selectedValue = $(this).attr('id'); 
		if(selectedValue!=="all"){
			$(".expandable_item").hide();
			$(".expandable_item."+selectedValue).stop().fadeIn();
		}else{
			$(".expandable_item").stop().fadeIn();
		}
		setTimeout(function(){
			$(".section_expandable_list").height("auto");
		},0)
		setTimeout(function(){
			doscroll();
		},900)
	});

	$('.filter_switchable_wrapper input[name="filter"]').on('change', function () {
		$(".resource_filter_menu_section").height($(".resource_filter_menu_section").height());
		let selectedValue = $(this).attr('id'); 
		$(".switchable_section_expandable_list.active").hide();
		$(".switchable_section_expandable_list.active").removeClass("active");
		$(".switchable_section_expandable_list[data-id="+selectedValue+"]").hide();
		$(".switchable_section_expandable_list[data-id="+selectedValue+"]").addClass("active");
		setTimeout(function(){
			$(".resource_filter_menu_section").height("auto");
			$(".switchable_section_expandable_list[data-id="+selectedValue+"]").stop().fadeIn();
		},0)
	});

	$(".f_btn").click(function(){
		$(this).parent().find(".fancybox:first").click();
	});



	$(".scrollinbottom_dropdown").click(function(){
		var $p = $(this).parents(".scrollinbottom_dropdown_wrapper")
		if($p.hasClass("active")){
			$p.removeClass("active").find(".hidden").show();
			setTimeout(function(){
			$p.find(".hidden").stop().slideUp();
			},0)
		}else{
			$p.addClass("active").find(".hidden").hide();
			setTimeout(function(){
			$p.find(".hidden").stop().slideDown();
			},0)
		}
		return false;
	})
}



 



function initMap(){
	$(".map").each(function(){
		var macc = {lat: parseFloat($(this).attr("data-lat")) , lng: parseFloat($(this).attr("data-lng")) };
		var map = new google.maps.Map(
			$(this)[0], {
				zoom: 16, 
				center: macc , 
				styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
			}
		);
		var marker = new google.maps.Marker({position: macc, map: map});
	});
}

function updateHorizontalAlignment() {
	$('.horizontal-scroll-wrapper').each(function () {
		const $wrapper = $(this);
		const $track = $wrapper.find('.scroll-inner');

		const wrapperWidth = $wrapper.innerWidth();
		const contentWidth = $track[0].scrollWidth;

		if (contentWidth <= wrapperWidth) {
			$track.addClass('centered');
		} else {
			$track.removeClass('centered');
		}
	});
}

function init_function(){
	const isMobile = window.innerWidth < 1024;

	$('.horizontal-scroll-wrapper').each(function () {
		const $wrapper = $(this);
		const $track = $wrapper.find('.js-drag-scroll');

		let isDragging = false;
		let startX = 0;
		let lastX = 0;
		let currentTranslate = 0;
		let velocity = 0;
		let animationFrame;

		const updateTransform = (x) => {
			currentTranslate = x;
			$track.css('transform', `translate3d(${currentTranslate}px, 0, 0)`);
		};

		const clamp = (value, min, max) => Math.min(Math.max(value, min), max);

		const getMinTranslate = () => {
			return -($track[0].scrollWidth - $wrapper.outerWidth());
		};

		const startInertiaScroll = () => {
			const decay = 0.95;
			const threshold = 0.5;

			function step() {
				velocity *= decay;
				if (Math.abs(velocity) > threshold) {
					let nextTranslate = currentTranslate + velocity;
					const minTranslate = getMinTranslate();
					nextTranslate = clamp(nextTranslate, minTranslate, 0);
					updateTransform(nextTranslate);
					animationFrame = requestAnimationFrame(step);
				} else {
					cancelAnimationFrame(animationFrame);
				}
			}

			step();
		};

		$wrapper.on('mousedown touchstart', function (e) {
			
			if (e.type === 'mousedown' && e.button !== 0) return;
			isDragging = true;
			startX = lastX = (e.pageX || e.originalEvent.touches[0].pageX);
			$wrapper.addClass('dragging');
			$('body').addClass('dragging-scroll');
			cancelAnimationFrame(animationFrame);
		});

		

		$(document).on('mousemove touchmove', function (e) {
			if (!isDragging) return;

			const x = (e.pageX || e.originalEvent.touches[0].pageX);
			const delta = x - lastX;
			lastX = x;
			velocity = delta * 1.5;

			let newTranslate = currentTranslate + delta;
			newTranslate = clamp(newTranslate, getMinTranslate(), 0);
			updateTransform(newTranslate);
		});

		$(document).on('mouseup touchend', function () {
			if (!isDragging) return;

			isDragging = false;
			$wrapper.removeClass('dragging');
			$('body').removeClass('dragging-scroll');
			startInertiaScroll();
		});

		$('.js-drag-scroll a').on('dragstart', function (e) {
			e.preventDefault();
		});
	});

	$(".js-drag-scroll .has_dropdown > .a_wrapper > a").click(function(){
		var $p = $(this).closest(".has_dropdown");
		if($p.hasClass("opened")){
			$p.removeClass("opened")
			$p.find(".swiper_dropdown").stop().fadeOut();
		}else{
			$p.addClass("opened")
			$p.find(".swiper_dropdown").stop().fadeIn();
		}
		return false;
	})

	$(".roll_top_menu").each(function(){

		var $current_has_dropdown_a = $(this).find(".slide-has_dropdown .swiper_dropdown a.selected");

		if ($current_has_dropdown_a.length) {
			var $main_link = $(this).find(".slide-has_dropdown .a_wrapper > a");

			//$main_link.attr("href", $current_has_dropdown_a.attr("href"));
			$main_link.append("<span> - " + $current_has_dropdown_a.text() + "</span>");
		}

		var slidenum = $(this).find(".swiper-slide").length;
		
		$(this).find(".swiper-slide").each(function(){
			//$(this).width($(this).find("a").outerWidth())
		})

		var roll_top_menu_slider = new Swiper($(this).find(".swiper-container")[0], {
			autoplay: false,
			slidesPerView: "auto",
			speed: 1600,
			loop: false,
			spaceBetween: 50,
      		freeMode: true,
			breakpoints: {
				// when window width is >= 320px
				320: {
					spaceBetween: 0,
				},
				// when window width is >= 480px
				480: {
					spaceBetween: 0,
				},
				// when window width is >= 640px
				640: {
					spaceBetween: 0,
				}
			},
			on: {
				init: function () {
					

					$(".slide-has_dropdown > .a_wrapper > a").click(function(){
						var $p = $(this).closest(".slide-has_dropdown");
						if($p.hasClass("opened")){
							$p.removeClass("opened")
							$p.find(".swiper_dropdown").stop().fadeOut();
						}else{
							$p.addClass("opened")
							$p.find(".swiper_dropdown").stop().fadeIn();
						}
						return false;
					})

				},
			}
		});
	})

	


	$(".roll_bottom_menu").each(function(){
		var slidenum = $(this).find(".swiper-slide").length;
		var roll_bottom_menu_slider = new Swiper($(this).find(".swiper-container")[0], {
			autoplay: false,
			slidesPerView: "auto",
			speed: 1600,
			loop: false,
      		freeMode: true,
			breakpoints: {
				// when window width is >= 320px
				320: {
					spaceBetween: 0,
				},
				// when window width is >= 480px
				480: {
					spaceBetween: 0,
				},
				// when window width is >= 640px
				640: {
					spaceBetween: 0,
				},
				// when window width is >= 640px
				1600: {
					spaceBetween: 0,
				}
			}
		});
	})

	$(".top_photo_slider").each(function(){
		var top_photo_slider = new Swiper($(this), {
			 effect : 'fade',
			fadeEffect: {
				crossFade: true,
			},
			autoplay: {
				delay: 3000,
			},
			slidesPerView: 1,
			speed: 1600,
			loop: true,
			spaceBetween: 0,
		});

	});

	$(".thumb_text_box_slider_wrapper").each(function(){
		var thumb_text_box_slider = new Swiper($(this).find(".swiper-container")[0], {
			autoplay: false,
			slidesPerView: 6,
			centeredSlides: true,
			speed: 1600,
			loop: true,
			spaceBetween: 50,
			breakpoints: {
				// when window width is >= 320px
				320: {
					spaceBetween: 20,
					slidesPerView: 2,
				},
				// when window width is >= 480px
				640: {
					spaceBetween: 30,
					slidesPerView: 2,
				},
				// when window width is >= 480px
				1024: {
					spaceBetween: 30,
					slidesPerView:3,
				},
				// when window width is >= 640px
				1200: {
					spaceBetween: 50,
					slidesPerView: 4,
				},
				// when window width is >= 640px
				1600: {
					spaceBetween: 50,
					slidesPerView: 5,
				}
			}
		});

		$(this).find(".next_btn").click(function(){
			thumb_text_box_slider.slideNext()
		})

		$(this).find(".prev_btn").click(function(){
			thumb_text_box_slider.slidePrev()
		})
	});

	$(".thumb_text_box_slider_wrapper2").each(function(){
		var thumb_text_box_slider = new Swiper($(this).find(".swiper-container")[0], {
			autoplay: false,
			slidesPerView: 2,
			speed: 1600,
			loop: false,
			spaceBetween: 50,
			breakpoints: {
				// when window width is >= 320px
				320: {
					spaceBetween: 20,
					slidesPerView: 1,
				},
				// when window width is >= 480px
				640: {
					spaceBetween: 30,
					slidesPerView: 1,
				},
				// when window width is >= 480px
				1024: {
					spaceBetween: 30,
					slidesPerView:2,
				},
				// when window width is >= 640px
				1200: {
					spaceBetween: 50,
					slidesPerView: 2,
				},
				// when window width is >= 640px
				1600: {
					spaceBetween: 50,
					slidesPerView: 2,
				}
			}
		});

		$(this).find(".next_btn").click(function(){
			thumb_text_box_slider.slideNext()
		})

		$(this).find(".prev_btn").click(function(){
			thumb_text_box_slider.slidePrev()
		})
	});

	$(".border_thumb_text_box_slider_wrapper").each(function(){
		var $this = $(this);
		var border_thumb_text_box_slider = new Swiper($(this).find(".swiper-container")[0], {
			autoplay: false,
			slidesPerView: 4,
			speed: 1600,
			loop: false,
			spaceBetween: 0,
			pagination: {
				el: $(this).find('.dot_wrapper'),
				clickable: true
			  },
			breakpoints: {
				// when window width is >= 320px
				320: {
					spaceBetween: 0,
					slidesPerView: 2,
				},
				// when window width is >= 480px
				640: {
					spaceBetween: 0,
					slidesPerView: 2,
				},
				// when window width is >= 480px
				1024: {
					spaceBetween: 0,
					slidesPerView:3,
				},
				// when window width is >= 640px
				1200: {
					spaceBetween: 0,
					slidesPerView: 4,
				},
				// when window width is >= 640px
				1600: {
					spaceBetween: 0,
					slidesPerView: 4,
				}
			},
			on: {
				init: function () {
					const bullets = $this.find('.swiper-pagination-bullet');
					if (bullets.length <= 1) {
						$this.find('.dot_wrapper').hide()
					}else{
						$this.find('.dot_wrapper').show()
					}
				},
				slideChange: function () {
					const bullets = $this.find('.swiper-pagination-bullet');
					if (bullets.length <= 1) {
						$this.find('.dot_wrapper').hide()
					}else{
						$this.find('.dot_wrapper').show()
					}
				},
			}
		});

		// $(this).find(".next_btn").click(function(){
		// 	border_thumb_text_box_slider.slideNext()
		// })

		// $(this).find(".prev_btn").click(function(){
		// 	border_thumb_text_box_slider.slidePrev()
		// })
	});


	$(".home_about_slider_section").each(function(){
		if($(this).find(".swiper-slide").length<2){
			$(this).find(".next_btn").hide();
			$(this).find(".prev_btn").hide();
			$(this).find(".dot_wrapper").hide();
		}
		var home_about_slider = new Swiper($(this).find(".swiper-container")[0], {
			autoplay: false,
			slidesPerView: 1,
			speed: 1600,
			loop: true,
			spaceBetween: 60,
			pagination: {
				el: $(this).find('.dot_wrapper'),
				clickable: true
			}
		});

		$(this).find(".next_btn").click(function(){
			home_about_slider.slideNext()
		})

		$(this).find(".prev_btn").click(function(){
			home_about_slider.slidePrev()
		})
	});

	// $(".home_news_section").each(function(){
	// 	var home_news_year_slider = new Swiper($(this).find(".home_news_year_slider .swiper-container")[0], {
	// 		autoplay: false,
	// 		slidesPerView: 1,
	// 		speed: 1600,
	// 		loop: false,
	// 		spaceBetween: 0
	// 	});
	// 	var home_news_date_slider = new Swiper($(this).find(".home_news_date_slider .swiper-container")[0], {
	// 		autoplay: false,
	// 		slidesPerView: "auto",
	// 		speed: 1600,
	// 		loop: false,
	// 		spaceBetween: 0
	// 	});
		

	// 	$(this).find(".next_btn").click(function(){
	// 		home_news_date_slider.slideNext()
	// 	})

	// 	$(this).find(".prev_btn").click(function(){
	// 		home_news_date_slider.slidePrev()
	// 	})


		
	// });
		

	// $(".filter_dropdown").each(function(){
	// 	var filter_dropdown_slider = new Swiper($(this).find(".swiper-container")[0], {
	// 		autoplay: false,
	// 		slidesPerView: "auto",
	// 		speed: 1600,
	// 		loop: false,
	// 		spaceBetween: 0,
	// 	});

	// 	$(this).find(".next_btn").click(function(){
	// 		filter_dropdown_slider.slideNext()
	// 	})

	// 	$(this).find(".prev_btn").click(function(){
	// 		filter_dropdown_slider.slidePrev()
	// 	})
	// });


	$('.sentinel').each(function () {
		const $sentinel = $(this);
		const $sticky = $sentinel.next('.sticky_section')[0]; // raw DOM element

		const observer = new IntersectionObserver(
			([entry]) => {
			if (!entry.isIntersecting) {
				$($sticky).addClass('is_stuck');
			} else {
				$($sticky).removeClass('is_stuck');
			}
			},
			{ threshold: [0] }
		);

		observer.observe(this); // observe the sentinel
	});

	$(".year_list_slider_wrapper").each(function(){
		var $this = $(this);
		var year_list_slider = new Swiper($this.find(".swiper-container")[0], {
			autoplay: false,
			slidesPerView: 6,
			speed: 1600,
			loop: false,
			spaceBetween: 0,
			breakpoints: {
				// when window width is >= 320px
				320: {
					slidesPerView: 4,
				},
				// when window width is >= 480px
				480: {
					slidesPerView: 4,
				},
				// when window width is >= 640px
				640: {
					slidesPerView: 6,
				}
			}
		});

		$this.find(".next_btn").click(function(){
			var currentIndex = year_list_slider.activeIndex;
			var slidesPerView = year_list_slider.params.slidesPerView;
			// Jump by slidesPerView, or replace with 2, 3, etc.
			year_list_slider.slideTo(currentIndex + slidesPerView);
		});

		$this.find(".prev_btn").click(function(){
			var currentIndex = year_list_slider.activeIndex;
			var slidesPerView = year_list_slider.params.slidesPerView;
			year_list_slider.slideTo(currentIndex - slidesPerView);
		});
	})


	

	$(".border_box_item_wrapper").each(function(){
		var $this = $(this);
		var border_box_item_slider = new Swiper($this.find(".swiper-container")[0], {
			autoplay: false,
			slidesPerView: 4,
			speed: 1600,
			loop: false,
			spaceBetween: 0,
			breakpoints: {
				// when window width is >= 320px
				320: {
					slidesPerView: 2,
				},
				// when window width is >= 480px
				480: {
					slidesPerView: 2,
				},
				// when window width is >= 640px
				800: {
					slidesPerView: 3,
				},
				// when window width is >= 800px
				1024: {
					slidesPerView: 3,
				},
				// when window width is >= 800px
				1280: {
					slidesPerView: 4,
				}
			},
			pagination: {
				el: $this.find('.dot_wrapper'),
				clickable: true
			},
			on: {
				init: function () {
					const bullets = $this.find('.swiper-pagination-bullet');
					if (bullets.length <= 1) {
						$this.find('.dot_wrapper').hide()
					}else{
						$this.find('.dot_wrapper').show()
					}
				},
				slideChange: function () {
					const bullets = $this.find('.swiper-pagination-bullet');
					if (bullets.length <= 1) {
						$this.find('.dot_wrapper').hide()
					}else{
						$this.find('.dot_wrapper').show()
					}
				},
			}
		});
	})

	$(".flexible_layout_slider").each(function(){
		var $this = $(this);
		var flexible_layout_slider = new Swiper($this.find(".swiper-container")[0], {
			autoplay: false,
			slidesPerView: 1,
			speed: 1600,
			loop: true,
			spaceBetween: 0,
		});

		$this.find(".next_btn").click(function(){
			flexible_layout_slider.slideNext();
		})

		$this.find(".prev_btn").click(function(){
			flexible_layout_slider.slidePrev();
		})
	})

	$(".committee_list_slider").each(function(){
		var $this = $(this);
		if($this.find(".swiper-slide").length>2){
			var committee_list_slider = new Swiper($this.find(".swiper-container")[0], {
				autoplay: false,
				slidesPerView: 3,
				speed: 1600,
				loop: false,
				spaceBetween: 30,
				breakpoints: {
					// when window width is >= 320px
					320: {
						slidesPerView: 1,
					},
					// when window width is >= 480px
					480: {
						slidesPerView: 1,
					},
					// when window width is >= 640px
					640: {
						slidesPerView: 3,
					}
				},
			});

			$this.find(".next_btn").click(function(){
				committee_list_slider.slideNext();
			})

			$this.find(".prev_btn").click(function(){
				committee_list_slider.slidePrev();
			})
		}else{
			$this.find(".next_btn").hide();
			$this.find(".prev_btn").hide();
			$this.find(".dot_wrapper").hide();
		}
	})



	$(".committee_albums_slider").each(function(){
		var $this = $(this);
		if($this.find("> .swiper-container > .swiper-wrapper >.swiper-slide").length>1){
			var committee_albums_slider = new Swiper($this.find(" > .swiper-container")[0], {
				autoplay: false,
				slidesPerView: 2,
				speed: 1600,
				loop: false,
				spaceBetween: 50,
			});

			$this.find(".next_btn").click(function(){
				committee_albums_slider.slideNext();
			})

			$this.find(".prev_btn").click(function(){
				committee_albums_slider.slidePrev();
			})
		}else{
			$this.find(".next_btn").hide();
			$this.find(".prev_btn").hide();
			$this.find(".dot_wrapper").hide();
		}
	})



	$(".committee_album_slider").each(function(){
		var $this = $(this);
		var committee_album_slider = new Swiper($this.find(" > .swiper-container")[0], {
			effect : 'fade',
			fadeEffect: {
				crossFade: true,
			},
			autoplay: false,
			slidesPerView: 1,
			speed: 1600,
			loop: false,
			spaceBetween: 0,
			pagination: {
				el: $this.find('.dot_wrapper'),
				clickable: true,
    			type: isMobile ? 'fraction' : 'bullets',
			},
            allowTouchMove: false,
			init: function () {
				const bullets = $this.find('.swiper-pagination-bullet');
				if (bullets.length <= 1) {
					$this.find('.dot_wrapper').hide()
				}else{
					$this.find('.dot_wrapper').show()
				}
			},
			slideChange: function () {
				const bullets = $this.find('.swiper-pagination-bullet');
				if (bullets.length <= 1) {
					$this.find('.dot_wrapper').hide()
				}else{
					$this.find('.dot_wrapper').show()
				}
			},
		});
		
	})

	

	$(".home_promotion_box .title").click(function(){

		var normal_w = $(".home_promotion_box:not(.active)").width();
		var final_w = $(".home_promotion_box_wrapper .section_center_content").width() - ($(".home_promotion_box").length-1)*$(".home_promotion_box:not(.active)").outerWidth();
		var $this = $(this).parents(".home_promotion_box");
		if($this.hasClass("active")){
			//$(this).removeClass("active")
		}else{
			var $currentslide = $(".home_promotion_box.active");
			$currentslide.width($currentslide.width());
			$currentslide.removeClass("active");
			


			$this.css({
				"width":normal_w+"px",
			});
			$this.addClass("active")
			setTimeout(function(){
				$currentslide.stop().animate({
					"width":normal_w+"px",
					"opacity":1
				},1200,function(){
					
				})

				$this.stop().animate({
					"width":final_w+"px",
				},1200,function(){
					$this.width("auto");
				})
			},0)
		}
		return false;
	})

	$(".menu_lang").click(function(){
		if($(".hidden_lang_wrapper").hasClass("opened")){
			$(".hidden_lang_wrapper").removeClass("opened")
			$(".hidden_lang").stop().fadeOut(300);
		}else{
			$(".hidden_lang_wrapper").addClass("opened")
			$(".hidden_lang").stop().fadeIn(300);
		}
		return false;
	})
	
	$(".publication_filter_btn").click(function(){
		var mylink = $(this).attr("data-link");
		var $mytarget = $(".publication_box_list_wrapper[data-id='"+mylink+"']");
		var mytop = $mytarget.offset().top;
		var body = $("html");
		body.stop().animate({scrollTop:mytop-parseInt($(".header_bg").outerHeight())-100}, 1200, 'easeInOutQuad', function() { 
		});
		return false;
	})

	$(".scheme_slide_btn").click(function(){
		var mylink = $(this).attr("data-target");
		var $mytarget = $(".scheme_item[data-id='"+mylink+"']");
		var mytop = $mytarget.offset().top;
		var body = $("html");
		body.stop().animate({scrollTop:mytop-parseInt($(".header_bg").outerHeight())-100}, 1200, 'easeInOutQuad', function() { 
		});
		return false;
	})
	
}



function dosize(){

	$(".flexible_layout_slider").each(function(){
		var $this = $(this);
		var photoheight = $this.find(".photo").outerHeight()
		var btnheight = $this.find(".next_btn").outerHeight()

		$this.find(".prev_btn").css({
			top: (photoheight-btnheight)/2+"px",
			bottom:"auto"
		})

		$this.find(".next_btn").css({
			top: (photoheight-btnheight)/2+"px",
			bottom:"auto"
		})
	})

	$(".home_news_date_slider .news_item").each(function(){
		var pwidth = $(".home_news_date_slider_inwrapper").width();
		if($(window).width()<360){
			$(this).width(pwidth/2)
		}else if($(window).width()<480){
			$(this).width(pwidth/3)
		}else if($(window).width()<800){
			$(this).width(pwidth/4)
		}else if($(window).width()<1024){
			$(this).width(pwidth/4)
		}else if($(window).width()<1280){
			$(this).width(pwidth/4)
		}else if($(window).width()<1600){
			$(this).width(pwidth/4)
		}else{
			$(this).width(pwidth/4)
		}
	})

	$(".home_promotion_box").each(function(){
		var hiddenwidth = $(".home_promotion_box_wrapper .section_center_content").width() - ($(".home_promotion_box").length-1)*$(".home_promotion_box:not(.active)").outerWidth();
		$(this).find(".hidden").width(hiddenwidth);
	});

	if($(window).width()<800){
		$(".home_promotion_box:not(.active)").width(60)
	}else{
		$(".home_promotion_box:not(.active)").width(100)
	}

	// $(".filter_dropdown_wrapper .filter_dropdown .prev_btn").height($(".filter_dropdown .swiper-slide").height());
	// $(".filter_dropdown_wrapper .filter_dropdown .next_btn").height($(".filter_dropdown .swiper-slide").height());

	
	// if($(window).width()<1024){
	// 	$(".filter_dropdown").css({
	// 		"width": $(window).width()+'px'
	// 	})
	// }else{
	// 	$(".filter_dropdown").css({
	// 		"width": 'auto'
	// 	})
	// }

	$(".top_photo_banner_section .vertical_text_wrapper .project_title").each(function(){
		var $p = $(this).parents(".top_photo_banner_section");
		if($p.find(".photo").length){
			$(this).css({
				"max-height":$p.find(".photo").outerHeight()*0.8+"px"
			})
		}else{
			$(this).css({
				"max-height": $(window).height()+"px"
			})
		}
		
	})

	$(".top_photo_banner_section_absolute .vertical_text_wrapper .project_title").each(function(){
		var $p = $(this).parents(".top_photo_banner_section_absolute");
		if( $p.find(".date").length ){
			var maxh = $(window).width()/4
		}else{
			var maxh = $(window).width()/3
		}
		var mytop = $(this).offset().top;
		$(this).css({
			"max-height":maxh+"px",
			"min-height":$(window).height()/1.2-mytop-50+"px"
		})
		
	})

	do_committee_list_name_height();

	function do_committee_list_name_height(){
		$(".committee_list_slider .name").height("auto")
		var titleheight = 0;
		$(".committee_list_slider .name").each(function(){
			var myheight = $(this).height();
			if(myheight>titleheight){
				titleheight = myheight;
			}
		})
		$(".committee_list_slider .name").height(titleheight)
	}

	updateHorizontalAlignment();
	$(".home_news_loading").height($(".home_news_date_slider_inwrapper").outerHeight())
}


$(function(){
	$(".free_text table").each(function(){
		$(this).wrap( "<div class='table-responsive'></div>" );
	});

	$(".free_text table").not($(".free_text table.border_table")).each(function(){
		$(this).addClass("table-bg")
	});

	$(".free_text iframe").each(function(){
		if($(this).parents(".video_wrapper").length<=0){
			var my_src = $(this).attr("src")
			$(this).wrap( "<div class='video_wrapper'></div>" );
		}
	});

	$(".zh_body .project_title span").each(function () {
		const $el = $(this);

		$el.contents().each(function () {
			if (this.nodeType === Node.TEXT_NODE) {
				const text = this.nodeValue;
				const wrapped = Array.from(text).map(char => {
					// 中文或標點符號就保留原樣
					if (/[\u4E00-\u9FFF]/.test(char) || /[，。！？：；、“”‘’（）《》〈〉『』「」【】—……·\[\]]/.test(char)) {
						return char;
					} else {
						return `<span class="horizontal-text">${char}</span>`;
					}
				}).join('');

				$(this).replaceWith(wrapped);
			}
		});
	});

	init_event();
	init_function();

});


$(window).on('load', function() {
	dosize();
	loading_finish();
});

$(window).on('resize', function() {
	$("body").addClass("resizing")
	dosize();
	waitForFinalEvent(function(){
		dosize();
		doscroll();
		$("body").removeClass("resizing")
	}, 300, "some unique string");
});


$(window).on('scroll', function() {
	$("body").addClass("doingscroll")
	doscroll();
	dosize();
});
	