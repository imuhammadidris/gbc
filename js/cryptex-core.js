;(function($){

	'use strict';

	$.cryptex_core = $.cryptex_core || {};

	$.cryptex_core = {

		setUp: function (options) {
			var base = this;

			var animEndEventNames = {
					'WebkitAnimation' : 'webkitAnimationEnd',
					'OAnimation' : 'oAnimationEnd',
					'msAnimation' : 'MSAnimationEnd',
					'animation' : 'animationend'
				},
				transEndEventNames = {
					'WebkitTransition': 'webkitTransitionEnd',
					'MozTransition': 'transitionend',
					'OTransition': 'oTransitionEnd',
					'msTransition': 'MSTransitionEnd',
					'transition': 'transitionend'
				}

			base.$window = $(window);
			base.ANIMATIONEND = animEndEventNames[ Modernizr.prefixed('animation') ];
			base.TRANSITIONEND = transEndEventNames[ Modernizr.prefixed('transition') ];
			base.SUPPORT = {
				animations : Modernizr.csstransitions && Modernizr.cssanimations,
				ANIMATIONSUPPORTED: Modernizr.cssanimations,
				TRANSITIONSUPPORTED: Modernizr.csstransitions,
				ISRTL: getComputedStyle(document.body).direction === 'rtl',
				ISTOUCH: Modernizr.touch
			};
			base.XHRLEVEL2 = !!window.FormData;
			base.event = base.SUPPORT.ISTOUCH ? 'touchstart' : 'click';

			base.browserSelector();
			base.refresh();
		},

		DOMLoaded: function(options) {

			var base = this;

			// set up
			base.setUp(options);

			// counters
			if ($('.counter').length) base.counters();

			// responsive menu
			if ($('#header').length) base.navInit.init(this);

			// search
			if ($('.search-holder').length) base.searchHolder();

			// background load
			if ($('[data-bg]').length) base.bg();

			// sync carousel
			if ($('.owl-carousel[data-sync]').length) base.syncOwlCarousel.init();

			// hidden elements init
			if ($('.hidden-section').length) base.hiddenSections();

			// dropdown elements init
			if ($('.dropdown-invoker').length) base.dropdown();

			if ( 'fancybox' in $ ) {
				if ( $('.social-post-btn').length ) base.ajaxSocialPopup();
			}

			var $ImageLinks = $('.page-content-wrap a[href$=".jpg"], .page-content-wrap a[href$=".jpeg"], .page-content-wrap a[href$=".png"], .page-content-wrap a[href$=".jpg"], .page-content-wrap a[href$=".jpeg"], .page-content-wrap a[href$=".png"]');

			if ( $ImageLinks.length ) {
				$ImageLinks.fancybox();
			}

		},

		elements: {
			'.main-navigation, .topbar:not(.no-mobile-advanced)': 'navMain',
			'#mobile-advanced': 'navMobile',
			'#wrapper': 'wrapper',
			'#header' : 'header'
		},

		/*
		 Plugin Name: 	Refresh
		 */
		$: function (selector) {
			return $(selector);
		},

		refresh: function() {
			for (var key in this.elements) {
				this[this.elements[key]] = this.$(key);
			}
		},

		browserSelector: function() {

			var u = navigator.userAgent,
				ua = u.toLowerCase(),
				is = function (t) {
					return ua.indexOf(t) > -1;
				},
				g = 'gecko',
				w = 'webkit',
				s = 'safari',
				o = 'opera',
				h = document.documentElement,
				b = [(!(/opera|webtv/i.test(ua)) && /msie\s(\d)/.test(ua)) ? ('ie ie' + parseFloat(navigator.appVersion.split("MSIE")[1])) : is('firefox/2') ? g + ' ff2' : is('firefox/3.5') ? g + ' ff3 ff3_5' : is('firefox/3') ? g + ' ff3' : is('firefox/6') ? g + ' ff6' : is('gecko/') ? g : is('opera') ? o + (/version\/(\d+)/.test(ua) ? ' ' + o + RegExp.jQuery1 : (/opera(\s|\/)(\d+)/.test(ua) ? ' ' + o + RegExp.jQuery2 : '')) : is('konqueror') ? 'konqueror' : is('chrome') ? w + ' chrome' : is('iron') ? w + ' iron' : is('applewebkit/') ? w + ' ' + s + (/version\/(\d+)/.test(ua) ? ' ' + s + RegExp.jQuery1 : '') : is('mozilla/') ? g : '', is('j2me') ? 'mobile' : is('iphone') ? 'iphone' : is('ipod') ? 'ipod' : is('mac') ? 'mac' : is('darwin') ? 'mac' : is('webtv') ? 'webtv' : is('win') ? 'win' : is('freebsd') ? 'freebsd' : (is('x11') || is('linux')) ? 'linux' : '', 'js'];

			var c = b.join(' ');
			h.className += ' ' + c;

		},

		/*
		 Plugin Name: 	SearchHolder
		 */
		searchHolder : function () {

			$.searchClick = function (el, options) {
				this.el = $(el);
				this.init(options);
			}

			$.searchClick.DEFAULTS = {
				key_esc: 27
			}

			$.searchClick.prototype = {
				init: function (options) {
					var base = this;
					base.o = $.extend({}, $.searchClick.DEFAULTS, options);
					base.key_esc = base.o.key_esc;
					base.searchWrap = $('.searchform-wrap');
					base.searchBtn = $('.search-button', base.el);
					base.searchClose = $('.close-search-form', base.el);
					base.searchField = $('#s', base.el);
					base.event = Modernizr.touch ? 'touchstart' : 'click';

					base.set();
					base.bind();
				},
				set: function () {
					var transEndEventNames = {
						'WebkitTransition': 'webkitTransitionEnd',
						'MozTransition': 'transitionend',
						'OTransition': 'oTransitionEnd',
						'msTransition': 'MSTransitionEnd',
						'transition': 'transitionend'
					};
					this.transEndEventName = transEndEventNames[Modernizr.prefixed( 'transition' )];
					this.animations = Modernizr.csstransitions;
				},
				hide: function () {
					var base = this;
					base.searchWrap.addClass('closed').removeClass('opened');
					var onEndTransitionFn = function () {
						base.searchWrap.removeClass('closed');
					};
					if (base.animations) {
						base.searchWrap.on(base.transEndEventName, onEndTransitionFn);
					} else {
						onEndTransitionFn();
					}

					var $body = $(document.body),
						$popup = $(".searchform-wrap");

				},
				bind: function () {
					this.searchBtn.on(this.event, $.proxy(this.display_show, this));
					this.searchClose.on(this.event, $.proxy(function (e) {
						this.display_hide(e, this.key_esc);
					}, this));
					this.keyDownHandler(this.key_esc);

					$(window).on("load",function(){

						var $win = $('.wrapper-container'); // or $box parent container
						var $box = $(".search-form");
						var $sb = $(".search-button");

						$win.on("click.Bst", function(event){
							if (
								$box.has(event.target).length == 0 //checks if descendants of $box was clicked
								&&
								!$box.is(event.target) //checks if the $box itself was clicked
								&&
								!$sb.is(event.target) //checks if the $box itself was clicked
							){
								$('.searchform-wrap').removeClass('opened');;
							}
						});

						$('.close-search-form').on( "click", function() {
							$('.searchform-wrap').removeClass('opened');
						});

					});

				},
				display_show: function (e) {
					e.preventDefault();
					if (!this.searchWrap.hasClass('opened')) {
						this.searchWrap.addClass('opened');
						this.searchField.focus();
					}
				},
				display_hide: function (e, key) {
					var base = this;
					if (base.searchWrap.hasClass('opened')) {
						if (e.type == base.event || e.type == 'keydown' && e.keyCode === key) {
							e.preventDefault();
							base.hide();
							base.searchField.blur();
						}
					}
				},
				keyDownHandler: function (key) {
					$(window).on('keydown', $.proxy(function (e) {
						this.display_hide(e, key);
					}, this));
				}
			}

			$.fn.extend({
				searchClick: function (option) {
					if (!this.length) return this;
					return this.each(function () {
						var $this = $(this), data = $this.data('searchClick'),
							options = typeof option == 'object' && option;
						if (!data) {
							$this.data('searchClick', new $.searchClick(this, options));
						}
					});
				}
			});

			var searchHolder = $('.search-holder');

			if (searchHolder.length) {
				searchHolder.searchClick();
			}

		},

		/**
		 Counters
		 **/
		counters : function(){

			var counter = $('.counter');

			counter.each(function(){

				var $this = $(this),
					offset = $this.offset().top - 3000;

				$(window).on('scroll',function(){
					if($this.hasClass('counted')) return false;

					if($(this).scrollTop() >= offset){

						$this.addClass('counted');

						(function ($) {
							$.fn.countTo = function (options) {
								options = options || {};

								return $(this).each(function () {
									// set options for current element
									var settings = $.extend({}, $.fn.countTo.defaults, {
										from:            $(this).data('from'),
										to:              $(this).data('to'),
										speed:           $(this).data('speed'),
										refreshInterval: $(this).data('refresh-interval'),
										decimals:        $(this).data('decimals')
									}, options);

									// how many times to update the value, and how much to increment the value on each update
									var loops = Math.ceil(settings.speed / settings.refreshInterval),
										increment = (settings.to - settings.from) / loops;

									// references & variables that will change with each update
									var self = this,
										$self = $(this),
										loopCount = 0,
										value = settings.from,
										data = $self.data('countTo') || {};

									$self.data('countTo', data);

									// if an existing interval can be found, clear it first
									if (data.interval) {
										clearInterval(data.interval);
									}
									data.interval = setInterval(updateTimer, settings.refreshInterval);

									// initialize the element with the starting value
									render(value);

									function updateTimer() {
										value += increment;
										loopCount++;

										render(value);

										if (typeof(settings.onUpdate) == 'function') {
											settings.onUpdate.call(self, value);
										}

										if (loopCount >= loops) {
											// remove the interval
											$self.removeData('countTo');
											clearInterval(data.interval);
											value = settings.to;

											if (typeof(settings.onComplete) == 'function') {
												settings.onComplete.call(self, value);
											}
										}
									}

									function render(value) {
										var formattedValue = settings.formatter.call(self, value, settings);
										$self.html(formattedValue);
									}
								});
							};

							$.fn.countTo.defaults = {
								from: 0,               // the number the element should start at
								to: 0,                 // the number the element should end at
								speed: 1000,           // how long it should take to count between the target numbers
								refreshInterval: 100,  // how often the element should be updated
								decimals: 0,           // the number of decimal places to show
								formatter: formatter,  // handler for formatting the value before rendering
								onUpdate: null,        // callback method for every time the element is updated
								onComplete: null       // callback method for when the element finishes updating
							};

							function formatter(value, settings) {
								return value.toFixed(settings.decimals);
							}
						}(jQuery));

						jQuery(function ($) {
							// custom formatting example
							$('.count-number').data('countToOptions', {
								formatter: function (value, options) {
									return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, '');
								}
							});

							// start all the timers
							$('.timer').each(count);

							function count(options) {
								var $this = $(this);
								options = $.extend({}, options || {}, $this.data('countToOptions') || {});
								$this.countTo(options);
							}
						});

					}

				});

			});

		},

		/**
		 * Emulates single accordion item
		 * @param Function callback
		 * @return jQuery collection;
		 **/
		hiddenSections: function(callback){

			var collection = $('.hidden-section');
			if(!collection.length) return;

			collection.each(function(i, el){
				$(el).find('.content').hide();
			});

			collection.on('click.hidden', '.invoker', function(e){

				e.preventDefault();

				var content = $(this).closest('.hidden-section').find('.content');

				content.slideToggle({
					duration: 500,
					easing: 'easeOutQuint',
					complete: callback ? callback : function(){}
				});

			});

			return collection;

		},

		/**
		 * Initializes dropdown module
		 * @return Object Core;
		 **/
		dropdown: function(){

			var dropdown = {

				init: function(){
					this.bindEvents();
				},

				bindEvents: function(){

					var self = this;

					$('body').on('click', '.dropdown-invoker', function(e) {

						e.preventDefault();
						e.stopPropagation();

						var invoker = $(this),
							dropdown = invoker.next('.dropdown-window');

						self.smartPosition(dropdown);

						invoker.add(dropdown).toggleClass('opened');
						dropdown.parent().toggleClass('dropdown-over');

					});

					$(document).on('click', function(e){

						var dropdown = $('.dropdown-window');

						if(!$(e.target).closest(dropdown).length){

							dropdown.add(dropdown.prev('.dropdown-invoker')).removeClass('opened');
							dropdown.parent().removeClass('dropdown-over');

						}

					});

				},

				smartPosition: function(dropdown){

					var dWidth = dropdown.outerWidth(),
						dOfsset = dropdown.offset().left,
						$wW = $(window).width();

					if(dOfsset + dWidth > $wW) dropdown.addClass('reverse');

				}

			}

			dropdown.init();

			return this;

		},

		/**
		 Isotope
		 **/
		isotope : function(){
			var cthis = this;
			$('[data-isotope-options]').each(function(){

				var self = $(this),
					options = self.data('isotope-options');

				self.isotope(options);

			});
		},

		/**
		 Sync Owl Carousel
		 **/
		syncOwlCarousel: {

			init: function(){

				this.collection = $('.owl-carousel[data-sync]');
				if(!this.collection.length) return false;

				this.bindEvents();

			},

			bindEvents: function(){

				var self = this;

				this.collection.each(function(i, el){

					var $this = $(el),
						sync = $($this.data('sync'));

					if(!sync.length){
						console.log('Not found carousel with selector ' + $this.data('sync'));
						return;
					}

					// nav
					$this.on('click', '.owl-prev', function(e){
						sync.trigger('prev.owl.carousel');
					});
					$this.on('click', '.owl-next', function(e){
						sync.trigger('next.owl.carousel');
					});

					sync.on('click', '.owl-prev', function(e){
						$this.trigger('prev.owl.carousel');
					});
					sync.on('click', '.owl-next', function(e){
						$this.trigger('next.owl.carousel');
					});

					// // drag
					$this.on('dragged.owl.carousel', function(e){

						if(e.relatedTarget.state.direction == 'left'){
							sync.trigger('next.owl.carousel');
						}
						else{
							sync.trigger('prev.owl.carousel');
						}

					});

					sync.on('dragged.owl.carousel', function(e){

						if(e.relatedTarget.state.direction == 'left'){
							$this.trigger('next.owl.carousel');
						}
						else{
							$this.trigger('prev.owl.carousel');
						}

					});

				});

			}

		},

		/**
		 Adds background image
		 * @return undefined;
		 **/
		bg: function(collection){

			var collection = collection ? collection : $('[data-bg]');

			collection.each(function(){

				var $this = $(this),
					bg = $this.data('bg');

				if(bg) $this.css('background-image', 'url('+bg+')');

			});

		},

		ajaxSocialPopup: function() {

			$('.social-post-btn').on( 'click', function(e) {

				e.preventDefault();

				$.fancybox.open({
					src  : cryptex_global_vars.ajaxurl + '?action=cryptex_social_popup',
					type : 'ajax',
					opts : {
						ajax: {
							settings: {
								type: 'POST',
								data: {
									id: $(this).data('post-id')
								}
							}
						}
					}

				});

			});

		},

		navInit : {

			init : function (base) {

				this.createResponsiveButtons.call(base);
				this.navProcess(base);

				if ( base.SUPPORT.ISTOUCH ) {
					this.touchNavEvent(base);
				}
			},

			touchNavEvent: function (base) {
				var clicked = false;

				$("li.menu-item-has-children > a, li.cat-parent > a, li.page-item-has-children > a").on(base.event, function (e) {
					if (clicked != this) {
						e.preventDefault();
						clicked = this;
					}
				});
			},

			navProcess: function (base) {

				base.navInit.touchNav(base, base.$window);

				$(window).resize(function (e) {
					setTimeout(function () {
						base.navInit.touchNav(base, e.currentTarget);
					}, 30);
				});

			},

			touchNav: function (base, target) {

				if (base.SUPPORT.ISTOUCH || $(target).width() < 992) {

					if (!base.navMobile.children('ul').length) {
						base.navMobile.append(base.navMain.html());
					}

					base.navButton.on(base.event, function (e) {
						e.preventDefault();

						if (!base.wrapper.is('.active')) {
							$('html, body').animate({ scrollTop: 0 }, 0, function () {
								base.wrapper.css({
									height: base.navMobile.children('ul').outerHeight(true)
								}).addClass('active');
							});
						}
					});

					base.navHide.on(base.event, function (e) {
						e.preventDefault();
						if (base.wrapper.is('.active')) {
							base.wrapper.css({ height: 'auto' }).removeClass('active');
						}
					});

				} else {
					base.navMobile.children('ul').remove();
				}
			},

			createResponsiveButtons : function () {

				this.navButton = $('<button></button>', {
					id: 'responsive-nav-button',
					'class': 'responsive-nav-button'
				}).insertBefore(this.navMain);

				this.navHide = $('<a></a>', {
					id: 'advanced-menu-hide',
					'href' : '#'
				}).insertBefore(this.navMobile);

			},

		}

	}

	$(function(){

		$.cryptex_core.DOMLoaded();

	});

})(jQuery);

(function($) {

	;(function($){

		'use strict';

		/**
		 * CustomSelect construct function
		 * @return undefined;
		 **/
		function cryptex_custom_select(element, options){

			this.el = element;

			this.config = {
				cssPrefix: 'cryptex-'
			}

			this.select = element.find('select');

			$.extend(this.config, options);

			if ( element.children('select').length ) {
				this.select = element.find('select');
				this.select.hide();
			}

			this.build();
			this.bindEvents();
		}

		/**
		 * Creates necessary select elements and adds them to container element
		 * @return undefined;
		 **/
		cryptex_custom_select.prototype.build = function(){

			var self = this,
				options = this.select.children(),
				selectedFlag = false;

			if ( self.el.children('.' + self.config.cssPrefix + 'selected-option').length ) {
				self.selectedOption = self.el.children('.' + self.config.cssPrefix + 'selected-option');
			} else {
				self.selectedOption = $('<div></div>', {
					'class': self.config.cssPrefix + 'selected-option',
					'text': self.select.data('default-text')
				});
			}

			if ( self.el.children('ul.' + self.config.cssPrefix + 'options-list').length ) {
				self.optionsList = self.el.children('ul.' + self.config.cssPrefix + 'options-list');
			} else {
				self.optionsList = $('<ul></ul>', {
					'class': self.config.cssPrefix + 'options-list'
				});
			}

		}

		cryptex_custom_select.prototype.toDefaultState = function(e){

			e.preventDefault();
			e.stopPropagation();

			var container = $(this),
				self = e.data.self;

			if ( !container.hasClass(self.config.cssPrefix + 'opened') ){
				container.removeClass(self.config.cssPrefix + 'over');
			}

		}

		/**
		 * Binds events to select elements
		 * @return undefined;
		 **/
		cryptex_custom_select.prototype.bindEvents = function(){

			var self = this;

			this.selectedOption.on('click', function(e){

				self.el.addClass(self.config.cssPrefix + 'over');
				self.el.toggleClass(self.config.cssPrefix + 'opened');

				e.stopPropagation();

			});

			this.select.on('focus', function(e){

				e.preventDefault();
				self.el.addClass(self.config.cssPrefix + 'opened');

			});

			this.optionsList.on('click', 'li', function(e) {

				var $this = $(this),
					value = $this.data('value');

				$this.addClass(self.config.cssPrefix + 'active').siblings().removeClass(self.config.cssPrefix + 'active');

				self.selectedOption.text($this.text());

				self.select.val(value);
				self.select.trigger('change');
				self.el.removeClass(self.config.cssPrefix + 'opened');

				e.stopPropagation();

			});

			$(document).on('click.selectFocusOut', function(e){
				e.stopPropagation();
				if(!$(e.target).closest('.' + self.config.cssPrefix + 'custom-select').length) $('.' + self.config.cssPrefix +  'custom-select').removeClass(self.config.cssPrefix + 'opened');

			});

			this.optionsList.on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', {self: this},  this.toDefaultState.bind(this.el));

		}

		$.fn.cryptex_custom_select = function(options){

			return this.each(function() {
				if (!$(this).data('cryptexCustomSelect')) {
					$(this).data('cryptexCustomSelect', new cryptex_custom_select($(this), options));
				}
			});

		};

	})(jQuery);

	/**
	 Custom select
	 **/
	$.fn.madCustomSelect = function () {

		return this.each(function(){

			var list = $(this).children('ul'),
				select = $(this).find('select'),
				title = $(this).find('.select-title');


			// select items to list items

			if($(this).find('[data-filter]').length){
				for(var i = 0,len = select.children('option').length;i < len;i++){
					list.append('<li data-filter="'+select.children('option').eq(i).data('filter')+'">'+select.children('option').eq(i).text()+'</li>')
				}
			}
			else{
				for(var i = 0,len = select.children('option').length;i < len;i++){
					list.append('<li>'+select.children('option').eq(i).text()+'</li>')
				}
			}
			select.hide();

			// open list

			title.on('click',function(){
				list.slideToggle(400);
				$(this).toggleClass('active');
			});

			// selected option

			list.on('click','li',function(){
				var val = $(this).text();
				title.text(val);
				list.slideUp(400);
				select.val(val);
				title.toggleClass('active');
				// return false;
			});

		});

	}

})(jQuery);

// Sticky and Go-top

(function ($, window) {

	function cryptex_sticky_menu(el, options) {
		this.el = $(el);
		this.init(options);
	}

	cryptex_sticky_menu.DEFAULTS = {
		sticky: true
	}

	cryptex_sticky_menu.prototype = {
		init: function (options) {
			var base = this;
				base.window = $(window);
				base.options = $.extend({}, cryptex_sticky_menu.DEFAULTS, options);
				base.stickyWrap = $('.sticky-header');
				base.goTop = $('<button class="go-to-top" id="go-to-top"></button>').appendTo(base.el);

			// Sticky
			if ( base.options.sticky ) {
				base.stickyWrap.before($('.sticky-header').clone(true).addClass('clone-fixed'));
				base.sticky.stickySet.call(base, base.window);

				// $(".sticky-header.clone-fixed").css('top', '-' + $('#header').outerHeight() + 'px');

				$( window ).on('load resize', function() {
					// $(".sticky-header.clone-fixed").css('top', '-' + $('#header').outerHeight() + 'px');
				});

			}

			// Scroll Event
			base.window.on('scroll', function (e) {
				base.gotoTop.scrollHandler.call(base, e.currentTarget);
			});

			// Click Handler Button GotoTop
			base.gotoTop.clickHandler(base);
		},

		sticky: {

			stickySet: function () {

				// Script
				var stickyWrap = $('.sticky-header.clone-fixed');

				if ( stickyWrap.length ) {
					$(window).on('scroll',function() {
						var scroll = $(window).scrollTop();

						if ( scroll > 400 ) {
							if ( !stickyWrap.hasClass('sticky') ) {
								stickyWrap.addClass('sticky');
							}
						} else {
							stickyWrap.removeClass('sticky');
						}
					});
				}

			}

		},
		gotoTop: {
			scrollHandler: function (win) {
				$(win).scrollTop() > 200 ?
					this.goTop.addClass('go-top-visible'):
					this.goTop.removeClass('go-top-visible');
				$('.fb-link').addClass('fb-visible');
			},
			clickHandler: function (self) {
				self.goTop.on('click', function (e) {
					e.preventDefault();
					$('html, body').animate({ scrollTop: 0 }, 800);
				});
			}
		}

	}

	/* Sticky Plugin
	 * ================================== */

	$.fn.sticky_menu = function ( option ) {
		return this.each( function () {
			var $this = $(this), data = $this.data('sticky_menu'),
				options = typeof option == 'object' && option;
			if ( !data ) {
				$this.data('cryptex_sticky_menu', new cryptex_sticky_menu(this, options));
			}
		} );
	}

})(jQuery, window);

;(function($){

	'use strict';

	$(function(){

		/*Donut chart*/

		if ( $('.ct-chart').length ) {

			$('.ct-chart').each(function() {

				var $this = $(this),
					$series = $this.data('series');

				new Chartist.Pie($this[0], {
					series: $series
				}, {
					donut: true,
					donutWidth: 5,
					donutSolid: true,
					startAngle: 90,
					showLabel: false
				});

			});

		}

		/*Pie chart*/

		if ( $('.ct-chart3').length ) {

			$('.ct-chart3').each(function() {

				var $this = $(this),
					$labels = $this.data('labels'),
					$series = $this.data('series');

				new Chartist.Pie( $this[0], {
					labels: ['Satisfied Clients: 75', 'Completed Projects: 25'],
					series: $series
				}, {
					labelInterpolationFnc: function(value) {
						return value[0]
					}
				}, [
					['screen and (min-width: 640px)', {
						chartPadding: 0,
						labelOffset: 0,
						labelDirection: 'explode',
						labelInterpolationFnc: function(value) {
							return value;
						}
					}],
					['screen and (min-width: 1024px)', {
						labelOffset: 0,
						chartPadding: 0
					}]
				] );

			});

		}

		/* Bar chart */

		if ( $('.ct-chart4').length ) {

			$('.ct-chart4').each(function () {

				var $this = $(this),
					$labels = $this.data('labels'),
					$series = $this.data('series'),
					$low = $this.data('low') ? $this.data('low') : 0,
					$high = $this.data('high') ? $this.data('high') : 40;

				new Chartist.Bar( $this[0], {
					labels: $labels,
					series: $series
				}, {
					seriesBarDistance: 27,
					high: $high,
					low: $low
				}, [
					['screen and (max-width: 769px)', {
						seriesBarDistance: 10,
						axisX: {
							labelInterpolationFnc: function (value) {
								return value[0];
							}
						}
					}]
				] );

			});

		}

		/* Line chart */

		if ( $('.ct-chart5').length ) {

			$('.ct-chart5').each(function () {

				var $this = $(this),
					$labels = $this.data('labels') ? $this.data('labels') : '',
					$series = $this.data('series') ? $this.data('series') : '',
					$symbol = $this.data('symbol') ? $this.data('symbol') : '',
					$low = $this.data('low') ? $this.data('low') : 0,
					$high = $this.data('high') ? $this.data('high') : 40;

				new Chartist.Line( $this[0], {
					labels: $labels,
					series: $series
				}, {
					fullWidth: true,
					high: $high,
					low: $low,
					showArea: true,
					axisY: {
						labelInterpolationFnc: function (value) {
							return $symbol + value;
						},
						scaleMinSpace: 45
					}
				}, [
					['screen and (max-width: 769px)', {
						axisX: {
							labelInterpolationFnc: function (value) {
								return value[0];
							}
						}
					}]
				] );

			});

		}

		/* ---------------------------------------------------- */
		/*	Countdown											*/
		/* ---------------------------------------------------- */

		if ( $('.countdown').length ) {

			$('.countdown').each(function() {
				var $this = $(this),
					endDate = $this.data('terminal-date');

				$this.countdown({
					until : new Date(endDate),
					format : 'dHMS',
					labels : ['Years', 'Month', 'Weeks', 'Days', 'Hours', 'Minutes', 'Seconds']
				});
			} );

		}

		/* ---------------------------------------------------- */
        /*	Custom Select										*/
        /* ---------------------------------------------------- */

		if ( $('.custom-select').length ) {
			$('.custom-select').madCustomSelect();
		}

		var select = $('.cryptex-custom-select');

		if ( select.length ) {
			select.cryptex_custom_select();
		}

		/* ---------------------------------------------------- */
        /*	Tabs												*/
        /* ---------------------------------------------------- */

        $(window).on( 'load', function() {

        	var tabsSection = $('.tabs-section');
			if ( tabsSection.length ) {
				tabsSection.tabs({
					beforeActivate: function(event, ui) {
				        var hash = ui.newTab.children("li a").attr("href");
				   	},
					hide : {
						effect : "fadeOut",
						duration : 450
					},
					show : {
						effect : "fadeIn",
						duration : 450
					},
					updateHash : false
				});
			}

			/* ------------------------------------------------
				Tabs - opacity
			------------------------------------------------ */

			var tabs = $('.mad-tabs');

			if ( tabs.length ) {

				tabs.MadTabs({
					easing: 'easeOutQuint',
					speed: 600,
					cssPrefix: 'mad-'
				});

			}

			var $container = $('.isotope');
			// filter buttons
			$('#filters button').on('click', function(){
				var $this = $(this);
				// don't proceed if already selected
				if ( !$this.hasClass('is-checked') ) {
					$this.parents('#options').find('.is-checked').removeClass('is-checked');
					$this.addClass('is-checked');
				}
				var selector = $this.attr('data-filter');
				$container.isotope({  itemSelector: '.item', filter: selector });
				return false;
			});

			$.cryptex_core.isotope();

			if ( $('.str').length ) {
				$('.str').liMarquee();
			}

        });

		/* ---------------------------------------------------- */
        /*	Sticky menu											*/
        /* ---------------------------------------------------- */

		$('body').sticky_menu({
			sticky: true
		});

		/* ------------------------------------------------
		Instagram Carousel
		------------------------------------------------ */

		if ( $('.instagram-carousel').length ) {

	    	$('.instagram-carousel').each(function() {

	    		var $this = $(this);

				$this.owlCarousel({
					items: 1,
					nav : false,
					dots: true,
					loop  : true,
					autoplay : true,
					navText: false
				});

			});

		}

		/* ---------------------------------------------------- */
        /*	Accordion & Toggle									*/
        /* ---------------------------------------------------- */

		var aItem = $('.accordion:not(.toggle) .accordion-item'),
			link = aItem.find('.a-title'),
			$label = aItem.find('label'),
			aToggleItem = $('.accordion.toggle .accordion-item'),
			tLink = aToggleItem.find('.a-title');

			aItem.add(aToggleItem).children('.a-title').not('.active').next().hide();

		function triggerAccordeon($item) {
			$item
			.addClass('active')
			.next().stop().slideDown()
			.parent().siblings()
			.children('.a-title')
			.removeClass('active')
			.next().stop().slideUp();
		}


		if ($label.length) {
			$label.on('click',function(){
				triggerAccordeon($(this).closest('.a-title'))
			});
		} else {
			link.on('click',function(){
				triggerAccordeon($(this))
			});
		}

		tLink.on('click',function(){
			$(this).toggleClass('active')
			.next().stop().slideToggle();

		});

		/* ---------------------------------------------------- */
        /*	Quantity											*/
        /* ---------------------------------------------------- */

		var q = $('.quantity');

		q.each(function(){
			var $this = $(this),
				button = $this.children('button'),
				input = $this.children('input[type="number"]'),
				val = +input.val();

			button.on('click',function(){
				if($(this).hasClass('qty-minus')){
					if(val === 1) return false;
					input.val(--val);
				}
				else{
					input.val(++val);
				}
			});
		});

	});

	$(window).on('load', function () {

		/* ---------------------------------------------------- */
		/*	Gallery carousel									*/
		/* ---------------------------------------------------- */

		var pageCarousel = $('.owl-carousel');

		if ( pageCarousel.length ) {

			pageCarousel.not('#thumbnails').each(function() {

				var owl = $(this),
					max_items = owl.data('max-items'),
					smart_items = max_items,
					tablet_items = max_items;

				if ( max_items > 1 ){
					tablet_items = max_items - 1;
				}

				if ( max_items > 3 ) {
					smart_items = max_items - 2;
				} else {
					smart_items = max_items - 1;
				}

				var mobile_items = 1,
					autoplay_carousel = owl.data('autoplay'),
					autoplay_timeout = $(this).data('autoplaytimeout'),
					center_carousel = owl.data('center'),
					item_margin = owl.data('item-margin'),
					owlOptions = {
						smartSpeed : 450,
						nav : true,
						loop  : true,
						autoplay : autoplay_carousel,
						autoplayTimeout : autoplay_timeout,
						center: center_carousel,
						navText : false,
						margin: item_margin,
						lazyLoad: false,
						rtl: $.cryptex_core.SUPPORT.ISRTL ? true : false,
						responsiveClass:true,
						responsive : {
							0   : { items: mobile_items  },
							480 : { items: tablet_items  },
							768 : { items: tablet_items },
							992 : { items: max_items }
						},
						dotsEach: true
					};

				if ( owl.is('.blog-carousel') ) {
					owlOptions.animateIn = 'fadeIn';
					owlOptions.animateOut = 'fadeOut';
					owlOptions.autoHeight = true;
				}

				if ( owl.is('.products-holder') ) {
					owl
						.on( 'initialized.owl.carousel resized.owl.carousel', $.cryptex_woocommerce_mod.sameheight )
						.on( 'initialized.owl.carousel translated.owl.carousel', $.cryptex_woocommerce_mod.owlGetVisibleElements )
				}

				owl.owlCarousel(owlOptions);

			});

		}

		/* ---------------------------------------------------- */
		/*	Gallery post carousel								*/
		/* ---------------------------------------------------- */

		var postGalleryCarousel = $('.gallery.gallery-size-full');

		if ( postGalleryCarousel.length ) {

			postGalleryCarousel.each(function () {

				var $this = $(this);

				$this.owlCarousel({
					smartSpeed : 450,
					nav : true,
					dots: false,
					loop  : true,
					autoplay : false,
					autoplayTimeout: 3000,
					navText : false,
					lazyLoad: true,
					rtl: $.cryptex_core.SUPPORT.ISRTL ? true : false,
					responsiveClass:true,
					items: 1
				});

			});

		}

		/* ---------------------------------------------------- */
		/*	Gallery post carousel								*/
		/* ---------------------------------------------------- */

		var testimonials = $('.testimonial-holder.style-2');

		if ( testimonials.length ) {

			testimonials.each( function () {

				var $el = $(this),
					$carousel = $( '.tm-carousel', $el );

				$carousel.owlCarousel({
					smartSpeed : 450,
					nav : true,
					dots: false,
					loop  : true,
					autoplay : false,
					autoplayTimeout: 3000,
					navText : false,
					margin: 30,
					lazyLoad: true,
					rtl: $.cryptex_core.SUPPORT.ISRTL ? true : false,
					responsiveClass:true,
					items: 1
				});

				// Call Vars
				$( '.author-link', $el ).on( 'click', function (e) {
					e.preventDefault();
					var $item = $(this).parents( '.author-item ');
					$carousel.trigger( 'to.owl.carousel', [ $item.index(), 300, true ] );
					$( '.author-item', $el ).removeClass( 'active' );
					$item.addClass( 'active' );
				});

				$el.on('changed.owl.carousel', function(e) {
					var $index = e.item.index - e.relatedTarget._clones.length / 2;
					var $item = $el.find( '.author-item ').eq($index);
					$carousel.trigger( 'to.owl.carousel', [ $index, 300, true ] );
					$( '.author-item', $el ).removeClass( 'active' );
					$item.addClass( 'active' );
				});

			});

		}

		$('.toggle-currency .select-list').on('click', 'a', function (e) {
			e.preventDefault();
			cryptext_ccn.header.changeSymbols($(this).data('val'));
		});

	});

	function cryptex_sticky_sidebar() {
		if ( $('.widget-area-1').length ) {

			new StickySidebar('.widget-area-1', {
				topSpacing: 0,
				bottomSpacing: 0,
				containerSelector: '.page-section.sticky',
				innerWrapperSelector: '.widget-area-1 .wpb_wrapper'
			});

		}
	}

})(jQuery);
