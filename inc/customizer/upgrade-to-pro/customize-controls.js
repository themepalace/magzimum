( function( api ) {

	// Extends our custom "magzimum" section.
	api.sectionConstructor['magzimum'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
