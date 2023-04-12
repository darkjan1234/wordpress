<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
define( 'WPCARGO_PACKAGE_POSTMETA', apply_filters( 'wpcargo_package_postmeta', 'wpc-multiple-package' ) );
function wpcargo_package_weight_units(){
	$units = array(
		_x( 'kg', 'Weigt units', 'wpcargo' ), 
		_x( 'g', 'Weigt units', 'wpcargo' ), 
		_x( 'lbs', 'Weigt units', 'wpcargo' ), 
		_x( 'oz', 'Weigt units', 'wpcargo' ),
	);
	return apply_filters( 'wpcargo_package_weight_units', $units);
}
function wpcargo_package_dim_units(){
	$units = array(
		_x( 'mm', 'Dimension units', 'wpcargo' ), 
		_x( 'cm', 'Dimension units', 'wpcargo' ), 
		_x( 'm', 'Dimension units', 'wpcargo' ), 
		_x( 'in', 'Dimension units', 'wpcargo' ), 
		_x( 'ft', 'Dimension units', 'wpcargo' ), 
		_x( 'yd', 'Dimension units', 'wpcargo' )
	);
	return apply_filters( 'wpcargo_package_dim_units', $units);
}
function wpcargo_multiple_package_details_tbl_responsive(){
	?>
    <style>
            /*
            Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
            */
			#wpcsr-rate-section .wpcsr-payment-details th,
			#wpcsr-rate-section .wpcsr-details th {
				background: #eee;
			}
			#wpcsr-rate-section .wpcsr-payment-details tr th,
			#wpcsr-rate-section .wpcsr-payment-details tr td,
			#wpcsr-rate-section .wpcsr-details tr th,
			#wpcsr-rate-section .wpcsr-details tr td {
				border-color: #bdbdbd;
				border: 1px solid #bdbdbd;
				padding: 6px;
			}
            @media
            only screen 
            and (max-width: 760px), (min-device-width: 768px) 
            and (max-device-width: 1024px)  {
            /* Force table to not be like tables anymore */
			/* Shipping rate pacakge */
			#wpcsr-rate-packages table.wpcargo-table,  
            #wpcsr-rate-packages table.wpcargo-table thead, 
            #wpcsr-rate-packages table.wpcargo-table tbody, 
            #wpcsr-rate-packages table.wpcargo-table th, 
            #wpcsr-rate-packages table.wpcargo-table td, 
            #wpcsr-rate-packages table.wpcargo-table tr,
			/* Normal package */
            #wpc-multiple-package table.wpcargo-table,  
            #wpc-multiple-package table.wpcargo-table thead, 
            #wpc-multiple-package table.wpcargo-table tbody, 
            #wpc-multiple-package table.wpcargo-table th, 
            #wpc-multiple-package table.wpcargo-table td, 
            #wpc-multiple-package table.wpcargo-table tr { 
                display: block; 
            }
			/* Shipping rate pacakge */
			#wpcsr-rate-packages table.wpcargo-table thead tr,
			/* Normal package */
            #wpc-multiple-package table.wpcargo-table thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
			#wpcsr-rate-packages table.wpcargo-table tr:nth-of-type(odd),
			#wpc-multiple-package table.wpcargo-table tr:nth-of-type(odd) {
				background: #eee;
			}
			/* Shipping rate pacakge */
			#wpcsr-rate-packages table.wpcargo-table tr,
			/* Normal package */
            #wpc-multiple-package table.wpcargo-table tr { 
				border: 1px solid #ccc; 
			} 
			/* Shipping rate pacakge */
			#wpcsr-rate-packages table.wpcargo-table td,
			/* Normal package */
            #wpc-multiple-package table.wpcargo-table td { 
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 50%; 
            }
			/* Shipping rate pacakge */
			#wpcsr-rate-packages table.wpcargo-table td:before,
			/* Normal package */
            #wpc-multiple-package table.wpcargo-table td:before { 
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%; 
                padding-right: 10px; 
                white-space: nowrap;
            }
            /*
            Label the data
            */
            <?php $counter = 1; ?>
            <?php foreach ( wpcargo_package_fields() as $key => $value ): ?>
				<?php if( in_array( $key, wpcargo_package_dim_meta() ) && !wpcargo_package_settings()->dim_unit_enable ){ continue; } ?>
				/* Shipping rate pacakge */
				#wpcsr-rate-packages table.wpcargo-table td:nth-of-type(<?php echo esc_html( $counter ); ?>):before { content: "<?php echo esc_html( $value['label'] ); ?>"; }
				/* Normal package */
                #wpc-multiple-package table.wpcargo-table td:nth-of-type(<?php echo esc_html( $counter ); ?>):before { content: "<?php echo esc_html( $value['label'] ); ?>"; }
            <?php $counter++; endforeach; ?>
        }
    </style>
    <?php
}
add_action('wpcargo_after_package_details', 'wpcargo_multiple_package_details_tbl_responsive', 10, 1);
function wpcargo_multiple_package_after_track_details( $shipment ){
	if( multiple_package_status() ) {
		$template = wpcargo_include_template( 'package.tpl' );
		require( $template );
	}
}
add_action('wpcargo_after_package_details', 'wpcargo_multiple_package_after_track_details', 5, 1 );
function wpcargo_after_package_details_callback( $shipment ){
	$shipment_id 			= !empty ( $shipment ) ? $shipment->ID : '';
	$package_volumetric 	= !empty ( $shipment ) ? wpcargo_package_volumetric( $shipment->ID ) : '0.00';
	$package_actual_weight 	= !empty ( $shipment ) ? wpcargo_package_actual_weight( $shipment->ID ) : '0.00';
	$package_volume 		= !empty ( $shipment ) ? wpcargo_package_volume( $shipment->ID ) : '0.00';
	$dim_enable 			= wpcargo_package_settings()->dim_unit_enable;
	$fm_class 				= $dim_enable ? 'wpcargo-col-md-4' : 'wpcargo-col-md-12';
	$ad_class 				= $dim_enable ? 'one-third' : '';
    $class 					= is_admin() ? $ad_class : $fm_class ;
    $style 					= is_admin() ? 'style="display:block;overflow:hidden;margin-bottom:36px;"' : '' ;
	?>
	<div id="package-weight-info" class="wpcargo-container" <?php echo esc_html( $style ); ?>>
		<div class="wpcargo-row">
			<?php if( $dim_enable ): ?>
				<section class="<?php echo esc_html( $class ); ?> first" style="text-align: center; font-weight: bold;">
					<?php echo apply_filters( 'wpcargo_package_volumetric_label', esc_html__('Total Volumetric Weight :', 'wpcargo') ); ?> <span id="package_volumetric"><?php echo esc_html( $package_volumetric ).'</span>'. esc_html( wpcargo_package_settings()->weight_unit ); ?>.
				</section>
				<section class="<?php echo esc_html( $class ); ?>" style="text-align: center; font-weight: bold;">
					<?php echo apply_filters( 'wpcargo_package_volume_label', esc_html__('Total Volume :', 'wpcargo') ); ?> <span id="package_volume"><?php echo esc_html( $package_volume ).'</span>'. esc_html( wpcargo_volume_unit_label() ); ?>
				</section>
			<?php endif; ?>
			<section class="<?php echo esc_html( $class ); ?>" style="text-align: center; font-weight: bold;">
				<?php echo apply_filters( 'wpcargo_package_actual_weight_label', esc_html__('Total Actual Weight :', 'wpcargo') ); ?> <span id="package_actual_weight"><?php echo esc_html( $package_actual_weight ).'</span>'.esc_html( wpcargo_package_settings()->weight_unit ); ?>.
			</section>
		</div>
	</div>
	<?php
	do_action('wpcargo_after_package_details_script', $shipment);
}
add_action('wpcargo_after_package_totals', 'wpcargo_after_package_details_callback', 10, 1 );
add_action('wpcargo_after_package_details_script', 'wpcargo_after_package_details_script_callback', 10, 1 );
function wpcargo_after_package_details_script_callback( $shipment ){
	$dim_meta   	= wpcargo_package_dim_meta();
	$qty_meta   	= wpcargo_package_qty_meta();
	$weight_meta 	= wpcargo_package_weight_meta();
	$shipment_id 	= $shipment ? $shipment->ID : false;
	$divisor    	= apply_filters( 'wpcargo_volumetric_divisor', wpcargo_package_settings()->divisor, $shipment_id );
	$decimal 		= apply_filters( 'wpcargo_package_decimal_place', 2 );
	$dimesion_unit 	= trim( strtolower( wpcargo_package_settings()->dim_unit ) );
	$cubic_divisor 	= wpcargo_volume_divisor();
	$cubic_operator = $dimesion_unit != 'yd' ? '/' : '*' ;	
	?>
	<script>
		var mainContainer   = 'table tbody[data-repeater-list="<?php echo WPCARGO_PACKAGE_POSTMETA; ?>"]';
		var divisor         = <?php echo esc_html( $divisor ); ?>;
		var dimMeta         = <?php echo json_encode( $dim_meta ); ?>;
		var qtyMeta         = "<?php echo esc_html( $qty_meta ); ?>";
		var weightMeta      = "<?php echo esc_html( $weight_meta ); ?>";  
		var cubic_divisor 	= <?php echo esc_html( $cubic_divisor ); ?>;  
		var cubic_operator 	= "<?php echo esc_html( $cubic_operator ); ?>";  
		jQuery(document).ready(function($){
			<?php do_action( 'wpcargo_package_details_script' ); ?>
			function getDecimal( value = 0 ){
				value = parseFloat( value );
				if( value >= 1 ){
					return <?php echo esc_html($decimal); ?>;
				}
				var str 	= "0.";
				var dPlace = 1;
				for (i = 1; i < 10; i++) {
					str = str+'0';
					var z_value 	= str+"1";
					if( parseFloat(value) > parseFloat( z_value ) ){
						dPlace = i+2;
						break;
					}
				}
				return dPlace;
			}
			function calculatePackage(){
				var totalQTY        = 0;
				var totalWeight     = 0;
				var totalVolumetric = 0;
				var totalVolume		= 0;
				$( mainContainer + ' tr' ).each(function(){
					var currentVolumetric = 1; 
					var currentQTY        = 0;
					var packageWeight     = 0;
					$(this).find('input').each(function(){
						var currentField    = $(this);
						var className       = $( currentField ).attr('name');
						// Exclude in the loop field without name attribute
						if ( typeof className === "undefined" ){
								return;
						}
						// Get the QTY
						if ( className.indexOf(qtyMeta) > -1 ){
							var pQty = $( currentField ).val() == '' ? 0 : $( currentField ).val() ;
							totalQTY += parseFloat( pQty );
							currentQTY = parseFloat( pQty );
						}
						// Get the weight
						if ( className.indexOf(weightMeta) > -1 ){
							var pWeight = $( currentField ).val() == '' ? 0 : $( currentField ).val() ;
							packageWeight += parseFloat( pWeight );
						}
						
						// Calculate the volumetric                       
						$.each( dimMeta, function( index, value ){   
												
							if ( className.indexOf(value) == -1 ){
								return;
							}
							currentVolumetric *= $( currentField ).val();
						} );
					});
					totalVolumetric += currentQTY * ( currentVolumetric / divisor );
					totalWeight     += currentQTY * packageWeight;
					// totalVolume		+= currentQTY * currentVolumetric;
					// Calculate Volume
					if( cubic_operator == '*' ){
						totalVolume += currentQTY * ( currentVolumetric * cubic_divisor );
					}else{
						totalVolume += currentQTY * ( currentVolumetric / cubic_divisor );
					}
				});


				$('#package-weight-info #package_volume').text( totalVolume.toFixed( getDecimal(totalVolume) ) );
				$('#package-weight-info #package_volumetric').text( totalVolumetric.toFixed( getDecimal(totalVolumetric) ) );
				$('#package-weight-info #package_actual_weight').text( totalWeight.toFixed( getDecimal(totalWeight) ) );
			}
			if( mainContainer.length > 0 ){
				$( mainContainer ).on( 'change keyup', 'input', function(){
					calculatePackage();
				});
				$('body').on('DOMSubtreeModified', mainContainer, function(){
					setTimeout(() => {
						calculatePackage();
					}, 1000 );
				});
			}
		});
	</script>
    <?php
}
function wpcargo_package_settings(){
	$options                        = get_option( 'wpc_mp_settings' );
	$options 						= $options ? $options : array();
	// Dimension compatibility     
	$dimension_divisor 				= array_key_exists( 'wpcargo_dim_divisor', $options ) ? $options['wpcargo_dim_divisor'] : false ;

	// Depreciatred
	$woointeg_dim_divisor           = get_option( 'woointeg_dim_divisor' ) ? floatval( get_option( 'woointeg_dim_divisor' ) ) : 5000 ;
	$woointeg_dim_divisor 			= apply_filters( 'wpcargo_package_divisor_cm', $woointeg_dim_divisor );
	$woointeg_dim_divisor_inc       = get_option( 'woointeg_dim_divisor_inc' ) ? floatval( get_option( 'woointeg_dim_divisor_inc' ) ) : 138.4 ;
	$woointeg_dim_divisor_inc 		= apply_filters( 'wpcargo_package_divisor_inc', $woointeg_dim_divisor_inc );

	// New Dimesion Divisor
	$woointeg_dim_divisor 			= $dimension_divisor ? $dimension_divisor : $woointeg_dim_divisor;

    $wpc_mp_dimension_unit          = array_key_exists( 'wpc_mp_dimension_unit', $options ) ? $options['wpc_mp_dimension_unit'] : 'cm';
    $wpc_mp_peice_type              = array_key_exists( 'wpc_mp_piece_type', $options ) ? array_filter( array_map('trim', explode(",", $options['wpc_mp_piece_type']) ) ) : array();
    $wpc_mp_weight_unit             = array_key_exists( 'wpc_mp_weight_unit', $options ) ? $options['wpc_mp_weight_unit'] : 'lbs';
    $wpc_mp_enable_dimension_unit   = array_key_exists( 'wpc_mp_enable_dimension_unit', $options ) ? $options['wpc_mp_enable_dimension_unit'] : false;
    $wpc_mp_enable_admin  			= array_key_exists( 'wpc_mp_enable_admin', $options ) ? $options['wpc_mp_enable_admin'] : false;
    $wpc_mp_enable_frontend  		= array_key_exists( 'wpc_mp_enable_frontend', $options ) ? $options['wpc_mp_enable_frontend'] : false;
    $package_settings                    = new stdClass();
    $package_settings->dim_unit          = $wpc_mp_dimension_unit;
    $package_settings->peice_types       = $wpc_mp_peice_type;
    $package_settings->weight_unit       = $wpc_mp_weight_unit;
    $package_settings->dim_unit_enable   = $wpc_mp_enable_dimension_unit;
    $package_settings->admin_enable   	 = apply_filters( 'wpcargo_package_admin_enable', $wpc_mp_enable_admin );
    $package_settings->frontend_enable   = apply_filters( 'wpcargo_package_frontend_enable', $wpc_mp_enable_frontend );
    $package_settings->divisor           = $woointeg_dim_divisor;
    $package_settings->volume_unit       = $wpc_mp_dimension_unit == 'cm' ? apply_filters( 'wpcargo_package_cm_volume_unit', 'kg.' ) : apply_filters( 'wpcargo_package_inc_volume_unit', 'lbs.' );
    return apply_filters( 'wpcargo_package_settings', $package_settings);
}
function wpcargo_package_dim_meta( ){
	$dim_meta = array( 'wpc-pm-length', 'wpc-pm-width', 'wpc-pm-height' );
	return apply_filters( 'wpcargo_package_dim_meta', $dim_meta );
}
function wpcargo_package_qty_meta( ){
	return apply_filters( 'wpcargo_package_qty_meta', 'wpc-pm-qty' );
}
function wpcargo_package_weight_meta( ){
	return apply_filters( 'wpcargo_package_weight_meta', 'wpc-pm-weight' );
}
function wpcargo_package_fields(){
    $package_fields = array(
        'wpc-pm-qty' => array(
            'label' => esc_html__('Qty.', 'wpcargo'),
            'field' => 'number',
            'required' => false,
            'options' => array()
        ),
        'wpc-pm-piece-type' => array(
            'label' => esc_html__('Piece Type', 'wpcargo'),
            'field' => 'select',
            'required' => false,
            'options' => wpcargo_package_settings()->peice_types
        ),
        'wpc-pm-description' => array(
            'label' => esc_html__('Description', 'wpcargo'),
            'field' => 'textarea',
            'required' => false,
            'options' => array()
        ),
    );
	if( wpcargo_package_settings()->dim_unit_enable ){
		$package_fields['wpc-pm-length'] = array(
            'label' => esc_html__('Length', 'wpcargo').'('.wpcargo_package_settings()->dim_unit.')',
            'field' => 'number',
            'required' => false,
            'options' => array()
        );
        $package_fields['wpc-pm-width'] = array(
            'label' => esc_html__('Width', 'wpcargo').'('.wpcargo_package_settings()->dim_unit.')',
            'field' => 'number',
            'required' => false,
            'options' => array()
        );
        $package_fields['wpc-pm-height'] = array(
            'label' => esc_html__('Height', 'wpcargo').'('.wpcargo_package_settings()->dim_unit.')',
            'field' => 'number',
            'required' => false,
            'options' => array()
        );
	}
	$package_fields['wpc-pm-weight'] = array(
		'label' => esc_html__('Weight ', 'wpcargo').'('.wpcargo_package_settings()->weight_unit.')',
		'field' => 'number',
		'required' => false,
		'options' => array()
	);
    return apply_filters( 'wpcargo_package_fields', $package_fields );
}
function wpcargo_get_package_data( $shipment_id, $meta_key = WPCARGO_PACKAGE_POSTMETA  ){
    $packages = get_post_meta( (int)$shipment_id, $meta_key, true) ? maybe_unserialize( get_post_meta( (int)$shipment_id, $meta_key, true) ) : array();
    return apply_filters( 'wpcargo_get_package_data', $packages, $shipment_id, $meta_key );
}
function wpcargo_volume_unit_label(){
	$dimesion_unit 	= trim( strtolower( wpcargo_package_settings()->dim_unit ) );
	$volume_meter 	= array( 'cm', 'm', 'mm', );
	$volume_feet 	= array( 'ft', 'in', 'yd', );
	if( in_array( $dimesion_unit, $volume_meter ) ){
		return apply_filters( 'wpcargo_convert_volume_unit_cm', __('cu. m.', 'wpcargo' ) );
	}elseif( in_array( $dimesion_unit, $volume_feet ) ){
		return apply_filters( 'wpcargo_convert_volume_unit_in', __('cu. ft.', 'wpcargo' ) );
	}else{
		return $dimesion_unit;
	}
}
function wpcargo_volume_divisor( $shipment_id = false ){
	$unit    	= wpcargo_package_settings()->dim_unit;
	switch ($unit) {
		case 'mm':
			$divisor = 1000000000;
			break;
		case 'cm':
			$divisor = 1000000;
			break;
		case 'm':
			$divisor = 1;
			break;
		case 'in':
			$divisor = 1728;
			break;
		case 'ft':
			$divisor = 1;
			break;
		case 'yd':
			$divisor = 27;
			break;
		default:
			$divisor = 1;
			break;
	}
	return apply_filters( 'wpcargo_volume_divisor', $divisor, $shipment_id );
}
function wpcargo_package_volumetric( $shipment_id ){
	$packages 	= wpcargo_get_package_data( $shipment_id );
	$volumetric = wpcargo_calculate_volumetric( $packages, $shipment_id );
	$decimal 	= wpcargo_dynamic_decimal( $volumetric );
	return apply_filters( 'wpcargo_package_volumetric', number_format( $volumetric, $decimal, '.', ''), $shipment_id, $volumetric );
}
function wpcargo_package_volume( $shipment_id ){
	$packages 	= wpcargo_get_package_data( $shipment_id );
	$volume 	= wpcargo_calculate_volume( $packages, $shipment_id );
	$decimal 	= wpcargo_dynamic_decimal( $volume );
	return apply_filters( 'wpcargo_package_volume', number_format( $volume, $decimal, '.', ''), $shipment_id, $volume );
}
function wpcargo_package_actual_weight( $shipment_id ){
	$packages 	= wpcargo_get_package_data( $shipment_id );
	$weight 	= wpcargo_calculate_weight( $packages, $shipment_id );
	$decimal 	= wpcargo_dynamic_decimal( $weight );
	return apply_filters( 'wpcargo_package_actual_weight', number_format( $weight, $decimal, '.', ''), $shipment_id );
}
// Package Calculator
function wpcargo_calculate_volumetric( $packages, $shipment_id = false ){
	$divisor    = apply_filters( 'wpcargo_volumetric_divisor', wpcargo_package_settings()->divisor, $shipment_id );
	$volumetric = 0;
	if( !empty( $packages ) ){	
		foreach ($packages as $key => $value) {
			$multiplier = 1;
			$qty = array_key_exists( wpcargo_package_qty_meta(), $value ) ? $value[wpcargo_package_qty_meta()] : 1 ;
			foreach ( wpcargo_package_dim_meta() as $dim_meta ) {
				if( !array_key_exists( $dim_meta, $value ) ){
					continue;
				}
				$multiplier *=  floatval($value[$dim_meta]);
			}
			$volumetric += ( floatval($multiplier) / floatval($divisor) ) * floatval($qty);
		}		
	}
	return apply_filters( 'wpcargo_calculate_volumetric', $volumetric, $shipment_id );
}
function wpcargo_calculate_volume( $packages, $shipment_id = false ){
	$unit    	= wpcargo_package_settings()->dim_unit;
	$divisor 	= wpcargo_volume_divisor( $shipment_id );
	$volume 	= 0;
	if( !empty( $packages ) ){	
		foreach ($packages as $key => $value) {
			$multiplier = 1;
			$qty = array_key_exists( wpcargo_package_qty_meta(), $value ) ? $value[wpcargo_package_qty_meta()] : 1 ;
			foreach ( wpcargo_package_dim_meta() as $dim_meta ) {
				if( !array_key_exists( $dim_meta, $value ) ){
					continue;
				}
				$multiplier *=  floatval($value[$dim_meta]);
			}
			if( $unit == 'yd' ){
				$volume += ( floatval($multiplier) * floatval($divisor) ) * floatval($qty);
			}else{
				$volume += ( floatval($multiplier) / floatval($divisor) ) * floatval($qty);
			}
		}		
	}
	return apply_filters( 'wpcargo_calculate_volume', $volume, $shipment_id );
}
function wpcargo_calculate_weight( $packages, $shipment_id = false ){
	$weight 	= 0;
	if( !empty( $packages ) ){	
		foreach ($packages as $key => $value) {
			$qty 			= array_key_exists( wpcargo_package_qty_meta(), $value ) ? $value[wpcargo_package_qty_meta()] : 0 ;
			$weight_meta 	= array_key_exists( wpcargo_package_weight_meta(), $value ) ? $value[wpcargo_package_weight_meta()] : 0 ;			
			$weight_meta 	= apply_filters( 'wpcargo_calculate_weight_meta', $weight_meta );
			$weight 		+= floatval( $weight_meta ) * floatval( $qty );
		}		
	}
	return apply_filters( 'wpcargo_calculate_weight', $weight, $shipment_id );
}
function multiple_package_status(){
	$status = false;
	if( wpcargo_package_settings()->frontend_enable && !empty( wpcargo_package_fields() ) ) {
		$status = true;
	}
	return apply_filters( 'multiple_package_status', $status );
}
// Checked dynamic decimal places
function wpcargo_dynamic_decimal( $value ){
	if(!$value){
		return 2;
	}
	$zero_decimal  = "0.0";
	$decimal_place = 2;
	if( $value < 1 ){
		for( $i=2; $i<10; $i++ ){
			$new_decimal 	= str_pad( $zero_decimal, $i, "0", STR_PAD_RIGHT );
			$zero_value 	= $new_decimal."1";
			if( $value < $zero_value ){
				$decimal_place = $i+1;
			}
		}
	}
	return $decimal_place;
}
// Save Shipment Package
function wpcargo_save_package_callback( $shipment_id, $data ){
	if( !isset( $data[WPCARGO_PACKAGE_POSTMETA] ) ){
		return false;
	}
	$packages 	= array();
	if( is_array( $_POST[WPCARGO_PACKAGE_POSTMETA] ) ){
		$packages = array_map( function( $value ){
			return array_map( 'sanitize_text_field', $value );
		}, $_POST[WPCARGO_PACKAGE_POSTMETA]  );
	}
	update_post_meta( $shipment_id, WPCARGO_PACKAGE_POSTMETA, $packages );
}
add_action( 'wpcargo_after_save_shipment', 'wpcargo_save_package_callback', 10, 2 );