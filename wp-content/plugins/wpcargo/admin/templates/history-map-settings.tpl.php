<form method="post" action="options.php">
	<?php
	settings_fields( 'wpc_shmap_option_group' );
	do_settings_sections( 'wpc_shmap_option_group' ); ?>
	<?php $route_origin = array(); ?>
	<table class="form-table">
		<tr>
			<th><?php esc_html_e('Enable Shipment History Map', 'wpcargo' ); ?></th>
			<td>
				<input type="checkbox" name="shmap_active" value="1" <?php checked( $shmap_active, 1 ); ?>>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Display Map in result page?', 'wpcargo' ); ?></th>
			<td>
				<input type="checkbox" name="shmap_result" value="1" <?php checked( $shmap_result, 1 ); ?>>
				<p class="description"><?php esc_html_e( 'Note: This option will take effect only in the result page when "Shipment History Map" option is enabled.', 'wpcargo' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Map Type', 'wpcargo' ); ?></th>
			<td>
				<select id="maptype" name="shmap_type" required="required">
					<option value=""><?php esc_html_e( '--Select Map Type--', 'wpcargo' ); ?></option>
					<option value="terrain" <?php selected( $shmap_type, 'terrain' ); ?>><?php esc_html_e( 'Terrain', 'wpcargo' ); ?></option>
					<option value="satellite" <?php selected( $shmap_type, 'satellite' ); ?>><?php esc_html_e( 'Satellite', 'wpcargo' ); ?></option>
					<option value="roadmap" <?php selected( $shmap_type, 'roadmap' ); ?>><?php esc_html_e( 'Roadmap', 'wpcargo' ); ?></option>
					<option value="hybrid" <?php selected( $shmap_type, 'hybrid' ); ?>><?php esc_html_e( 'Hybrid', 'wpcargo' ); ?></option>
				</select>
				<p class="description"><?php esc_html_e('note: Default is Terrain.', 'wpcargo'); ?></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Zoom Level', 'wpcargo' ); ?></th>
			<td>
				<select id="maptype" name="shmap_zoom" required="required">
					<option value=""><?php esc_html_e( '--Select Zoom Level--', 'wpcargo' ); ?></option>
					<option value="1" <?php selected( $shmap_zoom, 1 ); ?>><?php esc_html_e( 'World', 'wpcargo' ); ?></option>
					<option value="5" <?php selected( $shmap_zoom, 5 ); ?>><?php esc_html_e( 'Landmass/continent', 'wpcargo' ); ?></option>
					<option value="10" <?php selected( $shmap_zoom, 10 ); ?>><?php esc_html_e( 'City', 'wpcargo' ); ?></option>
					<option value="15" <?php selected( $shmap_zoom, 15 ); ?>><?php esc_html_e( 'Streets', 'wpcargo' ); ?></option>
					<option value="20" <?php selected( $shmap_zoom, 20 ); ?>><?php esc_html_e( 'Buildings', 'wpcargo' ); ?></option>
				</select>
				<p class="description"><?php esc_html_e('note: Default is Streets.', 'wpcargo'); ?></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Google Map API Key', 'wpcargo' ); ?></th>
			<td>
				<input style="width: 380px;" type="text" name="shmap_api" value="<?php echo $shmap_api; ?>">
				<p class="description"><?php esc_html_e('Please click here to get Google Map API Key', 'wpcargo' ); ?> <a class="button button-primary button-small" href="https://developers.google.com/maps/documentation/embed/get-api-key" target="_blank"><?php esc_html_e('Get API Key','wpcargo' ); ?></a></p>
				<p class="description" style="color: #900; font-size: 16px; font-weight: 500;"><?php esc_html_e("Note: Google Map API Key needs to enable the following API's to make it work.", 'wpcargo' ); ?></p>
				<ol style="font-weight: 500; color: #900;font-style: italic;">
					<li><?php esc_html_e( 'Places API', 'wpcargo' ); ?></li>
					<li><?php esc_html_e( 'Maps JavaScript API', 'wpcargo' ); ?></li>
					<li><?php esc_html_e( 'Geolocation API', 'wpcargo' ); ?></li>
					<li><?php esc_html_e( 'Geocoding API', 'wpcargo' ); ?></li>
				</ol>
			</td>
		</tr>
		<tr>
		<?php if( get_option('shmap_api') ): ?>
		<th scope="row"><?php _e( 'Point of Orgin', 'wpcargo-pod' ); ?></th>
			<td>
				<input type="hidden" name="shmap_longitude" id="shmap_longitude" value="<?php echo esc_html($shmap_longitude); ?>">
				<input type="hidden" name="shmap_latitude" id="shmap_latitude" value="<?php echo esc_html($shmap_latitude); ?>">
				<input style="min-width: 400px;" type="text" name="shmap_origin_marker" id="shmap_origin_marker" value="<?php echo esc_html($shmap_origin_marker); ?>" required>
				<div id="wpcpod-route-origin">
					<p class="description"><?php esc_html_e( 'Note: Dag the map marker to generate Point of Orgin', 'wpcargo' ) ; ?></p>
					<div id="wpcpod-ro-map" style="width: 600px;height: 300px;margin: 24px 0 0 0; border: 1px solid #7e8993;"></div>
				</div>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<th><?php esc_html_e('Longitude', 'wpcargo' ); ?></th>
			<td>
				<input type="text" name="shmap_longitude" value="<?php echo esc_html($shmap_longitude); ?>">
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Latitude', 'wpcargo' ); ?></th>
			<td>
				<input type="text" name="shmap_latitude" value="<?php echo esc_html($shmap_latitude); ?>">
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Country Restriction', 'wpcargo' ); ?></th>
			<td>
				<input type="text" name="shmap_country_restrict" value="<?php echo esc_html($shmap_country_restrict); ?>">
				<p><i><b><?php 
					printf( esc_html__( 'Please enter %s compatible country code. This is to limit the results for you chosen country only.', 'wpcargo' ), '<a href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements" target="_blank">ISO 3166-1 Alpha-2</a>' );
					
				?></b></i></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Google Map Label Color', 'wpcargo' ); ?></th>
			<td>
				<p><input type="text" class="color-field" name="shmap_label_color" value="<?php echo esc_html($shmap_label_color); ?>" placeholder="#000"/></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Google Map Label Size', 'wpcargo' ); ?></th>
			<td>
				<p><input type="text" name="shmap_label_size" value="<?php echo esc_html($shmap_label_size); ?>" placeholder=""/>px</p>
			</td>
		</tr>
		<th scope="row"><?php esc_html_e( 'Google Map Marker', 'wpcargo' ) ; ?></th>
			<td>
				<input type="text" name='shmap_marker' id="image-chooser" value="<?php echo esc_html($shmap_marker); ?>"><a id="choose-image" class="button" ><?php esc_html_e( 'Upload Logo', 'wpcargo' ) ; ?></a>
				<script>
				jQuery(document).ready(function($){
				 // Uploading files
					var file_frame;
					$('#choose-image').on('click', function( event ){
						event.preventDefault();
						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;                        }
							// Create the media frame.
							file_frame = wp.media.frames.file_frame = wp.media({
								title: $( this ).data( 'uploader_title' ),
								button: {
									text: $( this ).data( 'uploader_button_text' ),
								},
								multiple: false
								// Set to true to allow multiple files to be selected
							});
							// When an image is selected, run a callback.
							file_frame.on( 'select', function() {
							// We set multiple to false so only get one image from the uploader
							attachment = file_frame.state().get('selection').first().toJSON();
							// Do something with attachment.id and/or attachment.url here
							$('#image-chooser').val( attachment.url );
						});
						// Finally, open the modal
						file_frame.open();
					});
				});
				</script>
				<p class="description"><?php esc_html_e( 'Note: Marker must be 55px X 55px dimension for best output.', 'wpcargo'); ?></p>
			</td>
	</table>
	<input class="button button-primary button-large" type="submit" name="submit" value="<?php esc_html_e('Save Map Settings', 'wpcargo' ); ?>">
</form>
<?php if( get_option('shmap_api') ): ?>
	<script
		src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_option('shmap_api'); ?>&callback=initialize&libraries=&v=weekly"
		defer
	></script>
	<script>
		// In the following example, markers appear when the user clicks on the map.
		// Each marker is labeled with a single alphabetical character.
		var geocoder;
		function initialize() {
			geocoder = new google.maps.Geocoder();
			var geoCooridinates = { lat: <?php echo $shmap_latitude; ?>, lng: <?php echo $shmap_longitude; ?> };
			var map = new google.maps.Map(document.getElementById('wpcpod-ro-map'), { 
				zoom: 13, 
				center: geoCooridinates,
			} );
			// Add a marker at the center of the map.
			addMarker( geoCooridinates, map );
		}

		// Adds a marker to the map.
		function addMarker( location, map ) {
			// Add the marker at the clicked location, and add the next-available label
			// from the array of alphabetical characters.
			var marker = new google.maps.Marker({
				position: location,
				map: map,
				draggable:true,
				animation: google.maps.Animation.DROP,
			});
			marker.addListener('dragend', function( event ){
				var latitude = event.latLng.lat();
				var longitude =  event.latLng.lng();
				document.getElementById( 'shmap_longitude' ).value = latitude;
				document.getElementById( 'shmap_latitude' ).value = longitude;

				geocodePosition(marker.getPosition());
					
			});
		}
		function geocodePosition(pos) {
			geocoder.geocode({
				latLng: pos
			}, function(responses) {
				if (responses && responses.length > 0) {
					document.getElementById( 'shmap_origin_marker' ).value = responses[0].formatted_address;
				} else {
					alert('Cannot determine address at this location.');
				}
			});
		}
	</script>
<?php endif; ?>