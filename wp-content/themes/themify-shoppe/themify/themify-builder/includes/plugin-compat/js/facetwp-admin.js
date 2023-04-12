( function ( api, Themify ) {

	Themify.on( 'tb_editing_module', lightbox => {
		/* assume that if DQ feature in Pro is disabled on a query_posts field, it should also not have filtering enabled */
		let has_query_posts = lightbox.querySelector( '.tb_field[data-type="query_posts"]:not(.tbp_disable_dynamic_query)' );
		if ( ! has_query_posts ) {
			return;
		}

		let options = ThemifyConstructor.create( [
			{ type : 'separator', 'html' : '<div><hr><h4>' + tbFacet.label + '</h4></div>' },
			{ type : 'toggle_switch', id : 'facetwp', label : tbFacet.label, help : tbFacet.desc , options : {
				on : { name : 'y', value : 'en' },
				off : { name : '', value : 'dis' }
			} }
		] );
		lightbox.querySelector( '#tb_options_setting' ).appendChild( options );
	} );

})( tb_app, Themify );