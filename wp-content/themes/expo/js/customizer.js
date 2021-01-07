/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );

	// Logo
    wp.customize( "expo_options[logo]", function( value ) {
        value.bind( function( to ) {
            $( ".site-title a" ).html( "<img class=\"sitetitle\" src=\"" + to + "\">" );
        } );
    } );

	// Fonts
    wp.customize( "expo_options[font]", function( value ) {
        value.bind( function( to ) {
            $( "#fontdiv" ).remove();
            var googlefont = to.split( "," );
            var n = googlefont[0].indexOf( ":" );
            googlefontfamily = googlefont[0].substring( 0, n != -1 ? n : googlefont[0].length );
            $( "body" ).append( "<div id=\"fontdiv\"><link href=\"http://fonts.googleapis.com/css?family="+googlefont[0]+"\" rel=\"stylesheet\" type=\"text/css\" /><style type=\"text/css\">  h1, h2, h3, h4, h5, h6, h1.page-title, h1.entry-title, .site-description, .navs a, #infinite-handle span {font-family: \""+googlefontfamily+"\";}</style></div>" );
        } );
    } );
 
    // Font Alt
    wp.customize( "expo_options[font_alt]", function( value ) {
        value.bind( function( to ) {
            $( "#fontaltdiv" ).remove();
            var googlefont = to.split( "," );
            var n = googlefont[0].indexOf( ":" );
            googlefontfamily = googlefont[0].substring( 0, n != -1 ? n : googlefont[0].length );
            $( "body" ).append( "<div id=\"fontaltdiv\"><link href=\"http://fonts.googleapis.com/css?family="+googlefont[0]+"\" rel=\"stylesheet\" type=\"text/css\" /><style type=\"text/css\">  body, p, textarea, input, select, label, .site-title, .menu li a, .show-posts {font-family: \""+googlefontfamily+"\";}</style></div>" );
        } );
    } );

    // CSS
    wp.customize( "expo_options[css]", function( value ) {
        value.bind( function( to ) {
            $( "#tempcss" ).remove();
            $( "body" ).append( "<div id=\"tempcss\"><style type=\"text/css\">" + to + "</style></div>" );
        } );
    } );

} )( jQuery );
