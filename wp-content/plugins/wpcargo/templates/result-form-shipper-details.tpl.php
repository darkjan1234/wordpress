<?php
	$shipper_name		= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_shipper_name' );
	$shipper_address	= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_shipper_address' );
	$shipper_phone		= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_shipper_phone' );
	$shipper_email		= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_shipper_email' );
	$receiver_name		= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_receiver_name' );
	$receiver_address	= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_receiver_address' );
	$receiver_phone		= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_receiver_phone' );
	$receiver_email		= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_receiver_email' );
?>
<div id="shipper-info" class="wpcargo-row">
    <div class="wpcargo-col-md-6 detail-section">
            <p id="shipper-header" class="header-title"><strong><?php echo apply_filters('result_shipper_address', esc_html__('Shipper Information', 'wpcargo')); ?></strong></p>
            <?php do_action( 'wpcargo_before_track_shipper_data', $shipment ); ?>
            <p class="shipper details"><?php echo esc_html( $shipper_name ); ?><br />
            <?php echo esc_html( $shipper_address ); ?><br />
            <?php echo esc_html( $shipper_phone ); ?><br />
            <?php echo esc_html( $shipper_email ); ?><br /></p>
            <?php do_action( 'wpcargo_after_track_shipper_data', $shipment ); ?>
    </div>
    <div class="wpcargo-col-md-6 detail-section">
            <p id="receiver-header" class="header-title"><strong><?php echo apply_filters('result_receiver_address', esc_html__('Receiver Information', 'wpcargo')); ?></strong></p>
            <?php do_action( 'wpcargo_before_track_receiver_data', $shipment ); ?>
            <p class="receiver details"><?php echo esc_html( $receiver_name ); ?><br />
            <?php echo esc_html( $receiver_address ); ?><br />
            <?php echo esc_html( $receiver_phone ); ?><br />
            <?php echo esc_html( $receiver_email ); ?><br /></p>
            <?php do_action( 'wpcargo_after_track_receiver_data', $shipment ); ?>
    </div>
    <div class="clear-line"></div>
</div>