(function ($, window) {

	'use strict';

	$.cryptex_woocommerce_mod = $.cryptex_woocommerce_mod || {};

	$.cryptex_woocommerce_mod = {
		sameheight : function (obj) {
			var $this = $(this), max = 0,
				$item = $this.find('.owl-item').children();

			$item.css('height','auto').each(function () {
				max = Math.max( max, $(this).outerHeight() );
			}).promise().done(function () {
				$(this).css('height', max);
			});
		},
		owlGetVisibleElements : function () {
			var $this = $(this);

			$this.find('.owl-item').removeClass('first last');
			$this.find('.owl-item.active').first().addClass('first');
			$this.find('.owl-item.active').last().addClass('last');
		}
	}


	/*	Elevate Zoom
	/* --------------------------------------------- */

	$.cryptex_woocommerce_mod.zoom = function () {

		if ( $('.image-preview-container').length ) {

			var $image_preview_container = $('.image-preview-container');

			$image_preview_container.each(function () {

				var $el = $(this);

				if ( $('#img-zoom', $el).length ) {
					$( '#img-zoom', $el ).elevateZoom({
						gallery: 'thumbnails',
						galleryActiveClass: 'active',
						zoomType: "inner",
						cursor: "crosshair",
						responsive:true,
						zoomWindowFadeIn: 500,
						zoomWindowFadeOut: 500,
						easing:true,
						lensFadeIn: 500,
						lensFadeOut: 500
					});
				}

			});

		}

	}

	/*	Product Thumbs Carousel
	/* --------------------------------------------- */

	$.cryptex_woocommerce_mod.thumbs_carousel = function () {

		if ($('.flex-control-nav').length) {

			var $thumbs_carousel = $('.flex-control-nav');

			var $owl = $thumbs_carousel.owlCarousel({
				items : 4,
				URLhashListener : false,
				navSpeed : 800,
				nav : true,
				loop : true,
				margin: 10,
				rtl: $.cryptex_core.SUPPORT.ISRTL ? true : false,
				navText:false,
				responsive : {
					0: {
						items: 3
					},
					481: {
						items: 3
					},
					1200: {
						items: 4
					}
				}
			});

			$owl.off('change.owl.carousel');

		}

	}

	/*	Qty
	 /* --------------------------------------------- */

	$.cryptex_woocommerce_mod.qty = function () {

		$(document).on('click', '.qty-plus, .qty-minus', function (e) {

			e.preventDefault();

			// Get values
			var $qty = $(this).closest('.quantity').find('.input-text'),
				currentVal = parseFloat($qty.val()),
				max = parseFloat($qty.attr('max')),
				min = parseFloat($qty.attr('min')),
				step = $qty.attr('step');

			// Format values
			if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
			if (max === '' || max === 'NaN') max = '';
			if (min === '' || min === 'NaN') min = 0;
			if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

			// Change the value
			if ($(this).is('.qty-plus')) {
				if (max && ( max == currentVal || currentVal > max )) {
					$qty.val(max);
				} else {
					$qty.val(currentVal + parseFloat(step));
				}
			} else {
				if (min && ( min == currentVal || currentVal < min )) {
					$qty.val(min);
				} else if (currentVal > 0) {
					$qty.val(currentVal - parseFloat(step));
				}
			}

			// Trigger change event
			$qty.trigger('change input');

			$( '.woocommerce-cart-form :input[name="update_cart"]' ).prop( 'disabled', false );

		});

	}

	/*	Cart
	/* --------------------------------------------- */

	$.cryptex_woocommerce_mod.cart = function () {
		({
			init: function () {
				var base = this;

				base.support = {
					touchevents: Modernizr.touchevents,
					transitions: Modernizr.csstransitions
				};

				base.eventtype = base.support.touchevents ? 'touchstart' : 'click';
				base.listeners();
			},
			listeners: function () {
				var base = this;

				base.track_ajax_refresh_cart(base);
				base.track_ajax_adding_to_cart();
				base.track_ajax_added_to_cart(base);
			},
			track_ajax_refresh_cart: function (base) {

				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: cryptex_global_vars.ajaxurl,
					data: {
						action: "cryptex_refresh_cart_fragment"
					},
					success: function (response) {
						base.update_cart_fragment(response.fragments);
						$('body').trigger('wc_fragments_loaded');
					}
				});

				$('body').on('wc_fragments_refreshed wc_fragments_loaded', function (e) {
					base.update_cart_dropdown(base);
				});

			},
			track_ajax_adding_to_cart: function () {

				$('body').on('adding_to_cart', function (e, $thisbutton, $data) {
					e.preventDefault();

					$thisbutton.block({
							message: null,
							overlayCSS: {
								background: '#fff url(' + cryptex_global_vars.ajax_loader_url + ') no-repeat center',
								backgroundSize: '16px 16px',
								borderRadius: cryptex_global_vars.button_border_small,
								opacity: 0.6
							}
						}
					);

				});

			},
			track_ajax_added_to_cart: function (base) {

				$('body').on('added_to_cart', function (e, fragments, cart_hash, $thisbutton) {

					$thisbutton.unblock().hide();
				});

			},
			update_cart_dropdown: function (e) {
				this.ajax_remove_cart_item(this);
			},
			update_cart_fragment: function (fragments) {
				if ( fragments ) {
					$.each(fragments, function (key, value) {
						$(key).replaceWith(value);
					});
				}
			},
			ajax_remove_cart_item: function (base) {

				$('.shopping-cart .remove').on( base.eventtype, function (e) {

					e.preventDefault();

					var $this = $(this);

					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: cryptex_global_vars.ajaxurl,
						data: {
							action: "cryptex_cart_item_remove",
							_wpnonce: cryptex_woocommerce_mod.nonce_cart_item_remove,
							cart_item_key: $this.data('cart_item_key')
						},
						success: function ( response ) {

							var fragments = response.fragments;

							if ( fragments ) {

								$this.parent().animate({
									opacity: 0
								}, function () {
									var $this = $(this);

									$this.slideUp(350, function () {
										$this.remove();
										base.update_cart_fragment( fragments );
										$('body').trigger('wc_fragments_refreshed');
									});

								});

							}

						}
					});

				});

			}

		}.init());
	}

	/*	DOM READY
	/* --------------------------------------------- */

	$(window).load(function() {
		$.cryptex_woocommerce_mod.thumbs_carousel();
	});

	$(function () {

		$(document).on('click', '.zoomImg', function(e) {
			e.preventDefault();
			$('.woocommerce-product-gallery__trigger').trigger('click');
		});

		$.cryptex_woocommerce_mod.cart();
		$.cryptex_woocommerce_mod.zoom();
		$.cryptex_woocommerce_mod.qty();
	});

})(jQuery, window);

