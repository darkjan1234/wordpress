<div id="wpcargo-track-header" class="wpcargo-col-md-12 text-center detail-section">
	<?php do_action( 'wpcargo_before_track_header', $shipment ); ?>
    <div class="comp_logo">
        <?php $options = get_option('wpcargo_option_settings');  ?>
        <img src="<?php echo !empty($options['settings_shipment_ship_logo']) ? esc_html( $options['settings_shipment_ship_logo'] ) : ''; ?>" style="margin: 0 auto;">
    </div><!-- comp_logo -->
	<?php
		$options = get_option('wpcargo_option_settings');
		$barcode_settings = !empty($options['settings_barcode_checkbox']) ? esc_html( $options['settings_barcode_checkbox'] ) : '';
		if(!empty($barcode_settings)) {
			?>
		    <div class="b_code">
		        <img src="<?php echo esc_html( $url_barcode ); ?>" alt="<?php echo esc_html( $tracknumber ); ?>" style="margin: 0 auto;" />
		    </div><!-- b_code -->
			<?php
		}
	?>
	<?php do_action( 'wpcargo_after_track_barcode', $shipment ); ?>
	<div class="shipment-number">
        <span class="wpcargo-title" style="display: block; font-size: 18px!important;"><?php echo apply_filters('wpcargo_track_result_shipment_number', esc_html( $tracknumber ) ); ?></span>
    </div><!-- Track_Num -->
	<?php do_action( 'wpcargo_after_track_header', $shipment ); ?>
</div>