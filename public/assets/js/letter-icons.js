'use strict';( function($) {

		$.fn.letterIcon = function(options) {

			var settings = $.extend({
				color : "#556b2f",
				backgroundColor : "white"
			}, options);

			var parseColourString = function(s) {

				// Tokenise input
				var m = s.match(/^\#|^rgb\(|[\d\w]+$|\d{3}/g);

				// Other variables
				var value, values;
				var valid = true, double = false;

				// If no matches, return false
				if (!m)
					return false;

				// If hex value
				if (m.length < 3) {
					// Get the value
					value = m[m.length - 1];

					// Split into parts, either x,x,x or xx,xx,xx
					values = value.length == 3 ? double = true && value.split('') : value.match(/../g);

					// Convert to decimal values - if #nnn, double up on values 345 => 334455
					values.forEach(function(v, i) {
						values[i] = parseInt( double ? '' + v + v : v, 16);
					});

					// Otherwise it's rgb, get the values
				} else {
					values = m.length == 3 ? m.slice() : m.slice(1);
				}

				// Check that each value is between 0 and 255 inclusive and return the result
				values.forEach(function(v) {
					valid = valid ? v >= 0 && v <= 255 : false;
				});

				// If string is invalid, return false, otherwise return an array of the values
				return valid && values;
			};

			return this.each(function() {
				var _this = $(this);

				var string = '', letter = '';
				if (typeof _this.data('text') !== "undefined" && _this.data('text') !== null) {
					string = _this.data('text').toString().trim();					
				}

				if (_this.data('charCount') && !isNaN(_this.data('charCount'))) {
					var newString = string.split(/(?=[A-Z])/), count = parseInt(_this.data('charCount'));

					if (count > newString.length) {
						count = newString.length;
					}
					for (var i = 0; i < count; i++) {
						letter = letter + newString[i].charAt(0);

					}
					letter = letter.toUpperCase();
				} else {
					letter = string.charAt(0).toUpperCase();
				}

				_this.append("<div class='letter-icon-wrapper'><span class='letter-icon'>" + letter + "</span></div>");

				var elem = _this.children();

				if (_this.data('size') && (_this.data('size') == 'sm' || _this.data('size') == 'lg')) {
					elem.addClass('size-' + _this.data('size'));
				}
				if (_this.data('icon')) {
                    elem.append('<i class="' + _this.data('icon') + '"></i>');
                }
				if (_this.data('customClass')) {
					if (_this.data('customClass').charAt(0) === '.')
						_this.data('customClass', _this.data('customClass').substr(1));
					elem.addClass(_this.data('customClass'));
				}

				if (_this.data('box') && (_this.data('box') == 'round' || _this.data('box') == 'circle')) {
					elem.addClass('box-' + _this.data('box'));
				}

				if (_this.data('color') && _this.data('color') == 'auto') {

					elem.removeClass(function(index, css) {
						return (css.match(/(^|\s)letter-color-\S+/g) || []).join(' ');
					});
					elem.addClass('letter-color-' + string.charAt(0).toLowerCase());

				}

				if (_this.data('color') && (parseColourString(_this.data('color')) !== false || _this.data('color') !== 'auto')) {
					var boxColor;
					elem.removeClass(function(index, css) {
						return (css.match(/(^|\s)letter-color-\S+/g) || []).join(' ');
					});
					boxColor = parseColourString(_this.data('color'));
					elem.css({
						backgroundColor : 'rgb(' + boxColor + ')'
					});
				}
				if (_this.data('colorHover') && (parseColourString(_this.data('colorHover')) !== false || _this.data('colorHover') == 'auto')) {
					if (_this.data('colorHover') == 'auto') {
						elem.add(elem.closest("a")).on('mouseenter', function() {
							elem.addClass('hover');
						}).on('mouseleave', function() {
							elem.removeClass('hover');
						});
					} else {
						var hoverColor, originalColor;
						hoverColor = parseColourString(_this.data('colorHover'));
						if (_this.data('color') && _this.data('color') !== 'auto') {
							originalColor = _this.data('color');

						} else {
							originalColor = elem.css("background-color");
						}
						elem.add(elem.closest("a")).on('mouseenter', function() {
							elem.css({
								backgroundColor : 'rgb(' + hoverColor + ')'
							});
						}).on('mouseleave', function() {
							elem.css({
								backgroundColor : originalColor
							});
						});
					}
				}
			});

		};

	}(jQuery));
