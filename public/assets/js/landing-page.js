var LandingPage = function() {
	"use strict";
	var $html = $('html'), $win = $(window), wrap = $('.app-aside'), MEDIAQUERY = {};

	MEDIAQUERY = {
		desktopXL : 1200,
		desktop : 992,
		tablet : 768,
		mobile : 480
	};
	// function for Header shrink size based on scroll
	var shrinkHeaderHandler = function() {

		var navbar = $('#landing-header'), shrinkOn = $('#topbar').length ? $('#topbar').outerHeight() : $('header').outerHeight();

		$win.scroll(function() {
			$(document).scrollTop() > shrinkOn ? navbar.addClass('min') : navbar.removeClass('min');
		});
	};

	// function to start animations when element appears on screen
	var appearAnimationHandler = function() {
		var appearGroupElement = $('*[data-appears-group-delay]'), appearAttribute = 'data-appears-class', appearElement = $('*[' + appearAttribute + ']'), appearDelay;
		if (appearGroupElement.length) {
			appearGroupElement.each(function() {
				var _group = $(this), groupDelay, delayIncrease, delayStep = 0;
				typeof _group.attr('data-appears-group-delay') !== 'undefined' ? groupDelay = parseInt(_group.attr('data-appears-group-delay')) : groupDelay = null;
				typeof _group.attr('data-appears-delay-increase') !== 'undefined' ? delayIncrease = parseInt(_group.attr('data-appears-delay-increase')) : delayIncrease = 0;
				if (groupDelay !== null) {
					delayStep = groupDelay;
					var groupElements = _group.find('*[' + appearAttribute + ']');
					groupElements.each(function() {
						var _appearElement = $(this);
						_appearElement.addClass('no-visible');
						_appearElement.attr('data-appears-delay', delayStep);
						delayStep = delayStep + delayIncrease;
					});
				}
				_group.appear();

				if (_group.is(':appeared')) {
					groupElements.each(function() {
						var _this = $(this);

						typeof _this.attr('data-appears-delay') !== 'undefined' ? appearDelay = parseInt(_this.attr('data-appears-delay')) : appearDelay = 0;
						setTimeout(function() {
							_this.removeClass('no-visible');
							_this.addClass(_this.attr(appearAttribute) + ' animated');
						}, appearDelay);
					});

				} else {
					_group.on('appear', function(event, $all_appeared_elements) {
						groupElements.each(function() {
							var _this = $(this);

							typeof _this.attr('data-appears-delay') !== 'undefined' ? appearDelay = parseInt(_this.attr('data-appears-delay')) : appearDelay = 0;

							setTimeout(function() {
								_this.removeClass('no-visible');
								_this.addClass(_this.attr(appearAttribute) + ' animated');
							}, appearDelay);

						});
					});
				}
			});
		}
		if (appearElement.length) {
			appearElement.each(function() {
				var _this = $(this);
				_this.addClass('no-visible');

				_this.appear();
				if (_this.is(':appeared')) {
					typeof _this.attr('data-appears-delay') !== 'undefined' ? appearDelay = parseInt(_this.attr('data-appears-delay')) : appearDelay = 0;

					setTimeout(function() {
						_this.removeClass('no-visible');
						_this.addClass(_this.attr(appearAttribute) + ' animated');
					}, appearDelay);

				} else {
					_this.on('appear', function(event, $all_appeared_elements) {
						typeof _this.attr('data-appears-delay') !== 'undefined' ? appearDelay = parseInt(_this.attr('data-appears-delay')) : appearDelay = 0;

						setTimeout(function() {
							_this.removeClass('no-visible');
							_this.addClass(_this.attr(appearAttribute) + ' animated');
						}, appearDelay);

					});
				}
			});

		}
	};
	
	$('.scroll-to').each(function(){
		var _this = $(this);
		_this.on('click', function(){
			if(isExtraSmallDevice()) {
				$('#landing-menu-toggler').trigger("click");
			}
			
			$('html, body').scrollTo($(_this.attr('href')) , 300, { offset:-$('header').outerHeight() });
		});
	});
	$('.close-handle').on('click', function(){
		$('#landing-menu-toggler').trigger("click");
	});
	
	// function to handle CountTo Plugin
	var animationNumberHandler = function() {
		var numberElement = $('.appear-counter');
		numberElement.each(function() {
			var _this = $(this), numberTo = _this.text();
			_this.appear();
			if (_this.is(':appeared')) {

				_this.numerator({
					toValue : _this.data('count-to'),
					duration : _this.data('duration'),
					delimiter : _this.data('delimiter')
				});

			} else {
				_this.one('appear', function(event, $all_appeared_elements) {

					_this.numerator({
						toValue : _this.data('count-to'),
						duration : _this.data('duration'),
						delimiter : _this.data('delimiter')
					});

				});
			}
		});
	};

	//function to get viewport/window size (width and height)
	var viewport = function() {
		var e = window, a = 'inner';
		if (!('innerWidth' in window)) {
			a = 'client';
			e = document.documentElement || document.body;
		}
		return {
			width : e[a + 'Width'],
			height : e[a + 'Height']
		};
	};

	function isSmallDevice() {
		return viewport().width < MEDIAQUERY.desktop;
	}

	function isExtraSmallDevice() {
		return viewport().width < MEDIAQUERY.tablet;
	}

	function isMobile() {
		if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			return true;
		} else {
			return false;
		};
	}

	return {
		init : function() {
			shrinkHeaderHandler();
			appearAnimationHandler();
			animationNumberHandler();
		}
	};
}();
