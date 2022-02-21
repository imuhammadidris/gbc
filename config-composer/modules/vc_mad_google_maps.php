<?php
if ( !class_exists('cryptex_google_maps') ) {

	class cryptex_google_maps {

		function __construct() {
//			add_action( 'wp_enqueue_scripts', array($this, 'google_map_script'), 1 );
			add_action( 'vc_before_init', array( $this, 'add_map_google_maps' ) );
		}

//		function google_map_script() {
//			wp_register_script( 'googleapis', "https://maps.googleapis.com/maps/api/js?v=3.24", null, null, false );
//		}

		function add_map_google_maps() {

			if ( function_exists('vc_map')) {

				vc_map( array(
					"name" => esc_html__('Google Map', 'cryptox'),
					"base" => "vc_mad_google_map",
					"class" => "vc_google_map",
					"controls" => "full",
					"show_settings_on_create" => true,
					"icon" => "icon-wpb-mad-google-map",
					"description" => esc_html__("Display Google Maps to indicate your location.", 'cryptox'),
					"category"  => esc_html__('Cryptex', 'cryptox'),
					"params" => array(
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Width (in %)", 'cryptox'),
							"param_name" => "width",
							"admin_label" => true,
							"value" => "100%",
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Height (in px)", 'cryptox'),
							"param_name" => "height",
							"admin_label" => true,
							"value" => "350px",
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Map type", 'cryptox'),
							"param_name" => "map_type",
							"admin_label" => true,
							"value" => array(
								esc_html__("Roadmap", 'cryptox') => "ROADMAP",
								esc_html__("Satellite", 'cryptox') => "SATELLITE",
								esc_html__("Hybrid", 'cryptox') => "HYBRID",
								esc_html__("Terrain", 'cryptox') => "TERRAIN"),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Latitude", 'cryptox'),
							"param_name" => "lat",
							"admin_label" => true,
							"value" => "40.7707307",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','cryptox').'</a> '. esc_html__('where you can find Latitude & Longitude of your location', 'cryptox'),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Longitude", 'cryptox'),
							"param_name" => "lng",
							"admin_label" => true,
							"value" => "-74.0210859",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','cryptox').'</a> '. esc_html__('where you can find Latitude & Longitude of your location', 'cryptox'),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Latitude 2", 'cryptox'),
							"param_name" => "lat_2",
							"admin_label" => true,
							"value" => "40.7707307",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','cryptox').'</a> '. esc_html__('where you can find Latitude & Longitude of your location', 'cryptox'),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Longitude 2", 'cryptox'),
							"param_name" => "lng_2",
							"admin_label" => true,
							"value" => "-74.0210859",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','cryptox').'</a> '. esc_html__('where you can find Latitude & Longitude of your location', 'cryptox'),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Latitude 3", 'cryptox'),
							"param_name" => "lat_3",
							"admin_label" => true,
							"value" => "40.7707307",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','cryptox').'</a> '. esc_html__('where you can find Latitude & Longitude of your location', 'cryptox'),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Longitude 3", 'cryptox'),
							"param_name" => "lng_3",
							"admin_label" => true,
							"value" => "-74.0210859",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','cryptox').'</a> '. esc_html__('where you can find Latitude & Longitude of your location', 'cryptox'),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Map Zoom", 'cryptox'),
							"param_name" => "zoom",
							"value" => array(
								esc_html__("15 - Default", 'cryptox') => 15, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 14, 15, 16, 17, 18, 19, 20
							),
							"group" => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "checkbox",
							"heading" => "",
							"param_name" => "scrollwheel",
							"value" => array(
								esc_html__("Disable map zoom on mouse wheel scroll", 'cryptox') => "disable",
							),
							"group" => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "textarea_html",
							"class" => "",
							"heading" => esc_html__("Info Window Text", 'cryptox'),
							"param_name" => "content",
							"value" => "",
							"group"  => esc_html__('Info Window', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Marker/Point icon", 'cryptox'),
							"param_name" => "marker_icon",
							"value" => array(
								esc_html__("Use Google Default", 'cryptox') => "default",
								esc_html__('Use Theme Default', 'cryptox') => "default_self",
								esc_html__("Upload Custom", 'cryptox') => "custom"
							),
							"group"  => esc_html__('Marker', 'cryptox')
						),
						array(
							"type" => "attach_image",
							"class" => "",
							"heading" => esc_html__("Upload Image Icon:", 'cryptox'),
							"param_name" => "icon_img",
							"admin_label" => true,
							"value" => "",
							"description" => esc_html__("Upload the custom image icon.", 'cryptox'),
							"dependency" => array(
								"element" => "marker_icon",
								"value" => array("custom")
							),
							"group"  => esc_html__('Marker', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Street view control", 'cryptox'),
							"param_name" => "streetviewcontrol",
							"value" => array(
								esc_html__("Disable", 'cryptox') => "false",
								esc_html__("Enable", 'cryptox') => "true"
							),
							"group"  => esc_html__('Advanced', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Map type control", 'cryptox'),
							"param_name" => "maptypecontrol",
							"value" => array(
								esc_html__("Disable", 'cryptox') => "false",
								esc_html__("Enable", 'cryptox') => "true"
							),
							"group"  => esc_html__('Advanced', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Map pan control", 'cryptox'),
							"param_name" => "pancontrol",
							"value" => array(
								esc_html__("Disable", 'cryptox') => "false",
								esc_html__("Enable", 'cryptox') => "true"
							),
							"group" => "Advanced"
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Zoom control", 'cryptox'),
							"param_name" => "zoomcontrol",
							"value" => array(esc_html__("Disable", 'cryptox') => "false", esc_html__("Enable", 'cryptox') => "true"),
							"group"  => esc_html__('Advanced', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Zoom control size", 'cryptox'),
							"param_name" => "zoomcontrolsize",
							"value" => array(esc_html__("Small", 'cryptox') => "SMALL", esc_html__("Large", 'cryptox') => "LARGE"),
							"dependency" => Array("element" => "zoomControl","value" => array("true")),
							"group"  => esc_html__('Advanced', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Disable dragging on Mobile", 'cryptox'),
							"param_name" => "dragging",
							"value" => array( esc_html__("Enable", 'cryptox') => "true", esc_html__("Disable", 'cryptox') => "false"),
							"group"  => esc_html__('Advanced', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Top margin", 'cryptox'),
							"param_name" => "top_margin",
							"value" => array(
								esc_html__("Page (small)", 'cryptox') => "page_margin_top",
								esc_html__("Section (large)", 'cryptox') => "page_margin_top_section",
								esc_html__("None", 'cryptox') => "none"
							),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Map Width Override", 'cryptox'),
							"param_name" => "map_override",
							"value" =>array(
								esc_html__("Default Width", 'cryptox')=>"0",
								esc_html__("Apply 1st parent element's width", 'cryptox')=>"1",
								esc_html__("Apply 2nd parent element's width", 'cryptox')=>"2",
								esc_html__("Apply 3rd parent element's width", 'cryptox')=>"3",
								esc_html__("Apply 4th parent element's width", 'cryptox')=>"4",
								esc_html__("Apply 5th parent element's width", 'cryptox')=>"5",
								esc_html__("Apply 6th parent element's width", 'cryptox')=>"6",
								esc_html__("Apply 7th parent element's width", 'cryptox')=>"7",
								esc_html__("Apply 8th parent element's width", 'cryptox')=>"8",
								esc_html__("Apply 9th parent element's width", 'cryptox')=>"9",
								esc_html__('Full Width', 'cryptox')=>"full",
								esc_html__('Maximum Full Width', 'cryptox')=>"ex-full",
							),
							"description" => esc_html__("By default, the map will be given to the Visual Composer row. However, in some cases depending on your theme's CSS - it may not fit well to the container you are wishing it would. In that case you will have to select the appropriate value here that gets you desired output..", 'cryptox'),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "textarea",
							"class" => "",
							"heading" => esc_html__("Google Styled Map JSON", 'cryptox'),
							"param_name" => "map_style",
							"value" => "",
							"description" => "<a target='_blank' href='http://googlemaps.github.io/js-samples/styledmaps/wizard/index.html'>".esc_html__("Click here",'cryptox')."</a> ".__("to get the style JSON code for styling your map.",'cryptox'),
							"group"  => esc_html__('Styling', 'cryptox')
						),
						array(
							"type" => "textfield",
							"heading" => esc_html__("Extra class name", 'cryptox'),
							"param_name" => "el_class",
							"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'cryptox'),
							"group"  => esc_html__('General Settings', 'cryptox')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("MapBorder Style", 'cryptox'),
							"param_name" => "map_border_style",
							"value" => array(
								esc_html__('None', 'cryptox')=> "",
								esc_html__('Solid', 'cryptox')=> "solid",
								esc_html__('Dashed', 'cryptox') => "dashed",
								esc_html__('Dotted', 'cryptox') => "dotted",
								esc_html__('Double', 'cryptox') => "double",
								esc_html__('Inset', 'cryptox') => "inset",
								esc_html__('Outset', 'cryptox') => "outset",
							),
							"description" => "",
							"group"  => esc_html__('Border', 'cryptox')
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => esc_html__("Border Color", 'cryptox'),
							"param_name" => "map_color_border",
							"value" => "",
							"description" => "",
							"dependency" => array(
								"element" => "map_border_style",
								"not_empty" => true
							),
							"group"  => esc_html__('Border', 'cryptox')
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => esc_html__("Border Width", 'cryptox'),
							"param_name" => "map_border_size",
							"value" => 1,
							"min" => 1,
							"max" => 10,
							"suffix" => "px",
							"description" => "",
							"dependency" => array(
								"element" => "map_border_style",
								"not_empty" => true
							),
							"group"  => esc_html__('Border', 'cryptox')
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => esc_html__("Border Radius",'cryptox'),
							"param_name" => "map_radius",
							"value" => 3,
							"min" => 0,
							"max" => 500,
							"suffix" => "px",
							"description" => "",
							"dependency" => array(
								"element" => "map_border_style",
								"not_empty" => true
							),
							"group"  => esc_html__('Border', 'cryptox')
						)
					)
				));
			}
		}

	}

	if (class_exists('WPBakeryShortCode')) {

		class WPBakeryShortCode_vc_mad_google_map extends WPBakeryShortCode {

			protected function content($atts, $content = null) {

				$width = $height = $map_type = $lat = $lng = $zoom = $streetviewcontrol = $maptypecontrol = $map_style = $top_margin = $pancontrol = $zoomcontrol = $zoomcontrolsize = $dragging = $marker_icon = $icon_img = $map_override = $output = $scrollwheel = $el_class = $map_border_style = $map_color_border = $map_border_size = $map_radius ='';

				extract(shortcode_atts(array(
					"width" => "100%",
					"height" => "400px",
					"map_type" => "ROADMAP",
					"lat" => "51.503454",
					"lng" => "-0.101562",
					"lat_2" => "51.501454",
					"lng_2" => "-0.124755",
					"lat_3" => "51.499633",
					"lng_3" => "-0.148755",
					"zoom" => "13",
					"scrollwheel" => "disable",
					"streetviewcontrol" => "false",
					"maptypecontrol" => "false",
					"pancontrol" => "false",
					"zoomcontrol" => "false",
					"zoomcontrolsize" => "SMALL",
					"dragging" => "true",
					"marker_icon" => "default",
					"icon_img" => "",
					"top_margin" => "page_margin_top",
					"map_override" => "0",
					"map_style" => "",
					"el_class" => "",
					"map_border_style" => "",
					"map_color_border" => "",
					"map_border_size" => "",
					"map_radius" => ""
				), $atts));

				$border_css = $gmap_design_css ='';
				$marker_lat = $lat;
				$marker_lng = $lng;

				$marker_lat_2 = $lat_2;
				$marker_lng_2 = $lng_2;

				$marker_lat_3 = $lat_3;
				$marker_lng_3 = $lng_3;

				if ( $marker_icon == "default_self" ) {
					$icon_url = get_theme_file_uri('images/map_marker.png');
				} elseif ( $marker_icon == "default" ) {
					$icon_url = "";
				} else {
					$icon_url = Cryptex_Helper::get_post_attachment_image($icon_img, '');
				}

				$id = "map_" . uniqid();
				$wrap_id = "wrap_" . $id;
				$map_type = strtoupper($map_type);
				$width = (substr($width, -1)!="%" && substr($width, -2) != "px" ? $width . "px" : $width);
				$map_height = (substr($height, -1)!="%" && substr($height, -2) != "px" ? $height . "px" : $height);

				$margin_css = '';

				if ( $top_margin != 'none' ) {
					$margin_css = $top_margin;
				}

				if ( $map_border_style !='' ) {
					$border_css .= 'border-style:'.$map_border_style.';';
				}

				if ( $map_color_border != '' ) {
					$border_css .= 'border-color:'. $map_color_border .';';
				}

				if ( $map_border_size != '' ) {
					$border_css .= 'border-width:'. $map_border_size .'px;';
				}

				if ( $map_radius !='' ) {
					$border_css .= 'border-radius:'. $map_radius .'px;';
				}

				$output .= "<div id='". $wrap_id ."' class='hh-map-wrapper ". $el_class ."' style='".( $map_height != "" ? "height:" . $map_height . ";" : "")."'>";

				$output .= "<div id='" . $id . "' data-map_override='". $map_override ."' class='kw-gmap ". $margin_css. "'" . ($width!="" || $map_height!="" ? " style='".$border_css . ($width!="" ? "width:" . $width . ";" : "") . ($map_height!="" ? "height:" . $map_height . ";" : "") . "'" : "") . "></div>";

					if ( $scrollwheel == "disable" ) {
						$scrollwheel = 'false';
					} else {
						$scrollwheel = 'true';
					}

					$output .= "<script type='text/javascript'>

						(function($) {

							'use strict';

							var map_$id = null;
							var coordinate_$id;
							var isDraggable = $(document).width() > 641 ? true : $dragging;
							try {
								var map_$id = null;
								var coordinate_$id;
								coordinate_$id=new google.maps.LatLng($lat_2, $lng_2);
								var mapOptions = {
									zoom: $zoom,
									center: coordinate_$id,
									scaleControl: true,
									streetViewControl: $streetviewcontrol,
									mapTypeControl: $maptypecontrol,
									panControl: $pancontrol,
									zoomControl: $zoomcontrol,
									scrollwheel: $scrollwheel,
									draggable: isDraggable,
									zoomControlOptions: {
									  style: google.maps.ZoomControlStyle.$zoomcontrolsize
									},";

								if ( $map_style == "" ) {
									$output .= "mapTypeId: google.maps.MapTypeId.$map_type,";
								} else {
									$output .= " mapTypeControlOptions: {
											mapTypeIds: [google.maps.MapTypeId.$map_type, 'map_style']
										}";
								}

								$output .= "};";

								if ( $map_style !== "" ) {
									$output .= 'var styles = '. rawurldecode(strip_tags($map_style)) .';
										var styledMap = new google.maps.StyledMapType(styles, { name: "'. esc_html__('Styled Map', 'cryptox') .'" });';
								}

								$output .= "var map_$id = new google.maps.Map(document.getElementById('$id'), mapOptions);";

								if ( $map_style !== "" ) {
									$output .= "map_$id.mapTypes.set('map_style', styledMap);
											 map_$id.setMapTypeId('map_style');";
								}

								if ( $marker_lat != "" && $marker_lng != "" ) {

									$output .= "
										var marker_$id = new google.maps.Marker({
										position: new google.maps.LatLng($marker_lat, $marker_lng),
										animation:  google.maps.Animation.DROP,
										map: map_$id,
										icon: '". $icon_url ."'
									});

									google.maps.event.addListener(marker_$id, 'click', Cryptex_VC_ToggleBounce);";

									if ( trim($content) !== "" ) {
										$output .= "var infowindow = new google.maps.InfoWindow();
											infowindow.setContent('<div class=\"map_info_text\" style=\'color:#000;\'>".trim(preg_replace('/\s+/', ' ', do_shortcode($content)))."</div>');";

										$output .= "google.maps.event.addListener(marker_$id, 'click', function() {
												infowindow.open(map_$id,marker_$id);
											});";

									}

								}

								if ( $marker_lat_2 != "" && $marker_lng_2 != "" ) {

									$output .= "
														var marker_$id = new google.maps.Marker({
														position: new google.maps.LatLng($marker_lat_2, $marker_lng_2),
														animation:  google.maps.Animation.DROP,
														map: map_$id,
														icon: '". $icon_url ."'
													});
				
													google.maps.event.addListener(marker_$id, 'click', Cryptex_VC_ToggleBounce);";

											if ( trim($content) !== "" ) {
												$output .= "var infowindow = new google.maps.InfoWindow();
																	infowindow.setContent('<div class=\"map_info_text\" style=\'color:#000;\'>".trim(preg_replace('/\s+/', ' ', do_shortcode($content)))."</div>');";

												$output .= "google.maps.event.addListener(marker_$id, 'click', function() {
																		infowindow.open(map_$id,marker_$id);
																	});";

											}

								}

									if ( $marker_lat_3 != "" && $marker_lng_3 != "" ) {

										$output .= "
																			var marker_$id = new google.maps.Marker({
																			position: new google.maps.LatLng($marker_lat_3, $marker_lng_3),
																			animation:  google.maps.Animation.DROP,
																			map: map_$id,
																			icon: '". $icon_url ."'
																		});
									
																		google.maps.event.addListener(marker_$id, 'click', Cryptex_VC_ToggleBounce);";

										if ( trim($content) !== "" ) {
											$output .= "var infowindow = new google.maps.InfoWindow();
																						infowindow.setContent('<div class=\"map_info_text\" style=\'color:#000;\'>".trim(preg_replace('/\s+/', ' ', do_shortcode($content)))."</div>');";

											$output .= "google.maps.event.addListener(marker_$id, 'click', function() {
																							infowindow.open(map_$id,marker_$id);
																						});";

										}

									}

								$output .= "}
							catch(e){};

								jQuery(document).ready(function($){
									google.maps.event.trigger(map_$id, 'resize');
									$(window).resize(function(){
										google.maps.event.trigger(map_$id, 'resize');
										if(map_$id!=null)
											map_$id.setCenter(coordinate_$id);
									});
								});

								$(window).load(function(){
									setTimeout(function(){
										$(window).trigger('resize');
									},200);
								});

								function Cryptex_VC_ToggleBounce() {
								  if (marker_$id.getAnimation() != null) {
									marker_$id.setAnimation(null);
								  } else {
									marker_$id.setAnimation(google.maps.Animation.BOUNCE);
								  }
								}

						})(jQuery);
				</script>";

				$output .= '</div>';

				return $output;

			}

		}

	}

	new cryptex_google_maps();

}