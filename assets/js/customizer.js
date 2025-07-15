
/**
 * Mohtawa Theme Customizer JavaScript
 */

(function($) {
    wp.customize( 'blogname', function( value ) {
        value.bind( function( newval ) {
            $( '.site-title a' ).html( newval );
        } );
    } );

    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( newval ) {
            $( '.site-description' ).html( newval );
        } );
    } );

    // Example: Live update for header background color
    wp.customize( 'mohtawa_header_background_color', function( value ) {
        value.bind( function( newval ) {
            $( '.site-header' ).css( 'background-color', newval );
        } );
    } );

    // Example: Live update for primary color
    wp.customize( 'mohtawa_primary_color', function( value ) {
        value.bind( function( newval ) {
            $( 'a, .button, .primary-color-element' ).css( 'color', newval );
        } );
    } );

})(jQuery);

